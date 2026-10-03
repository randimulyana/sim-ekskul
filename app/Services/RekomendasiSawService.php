<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Recommendation;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class RekomendasiSawService
{
    public const METHOD_NAME = 'Simple Additive Weighting (SAW)';
    public const METHOD_VERSION = '1.0';

    public function __construct(
        protected MatriksKeputusanService $matrixService,
        protected KonfigurasiKriteriaService $configService
    ) {}

    /**
     * Jalankan seluruh pipeline rekomendasi SAW untuk seorang siswa.
     *
     * Pipeline:
     * 1. Matriks Keputusan X (dari MatriksKeputusanService)
     * 2. Validasi Kesiapan
     * 3. Normalisasi R (rij = xij / max(xj) untuk benefit, min(xj) / xij untuk cost)
     * 4. Matriks Berbobot V (vij = rij * wj)
     * 5. Nilai Preferensi (Vi = sum(vij))
     * 6. Peringkat Deterministik
     * 7. Simpan ke database (hanya jika READY dan $persist bernilai true)
     *
     * @return array{
     *     status: string,
     *     status_label: string,
     *     student_id: int,
     *     student_name: string,
     *     period_id: ?int,
     *     criteria: array<string, array{name: string, type: string, weight: float}>,
     *     matrix_x: array<int, array<string, ?float>>,
     *     matrix_r: array<int, array<string, float>>,
     *     matrix_v: array<int, array<string, float>>,
     *     ranking: array<int, array{
     *         rank: int,
     *         extracurricular_id: int,
     *         name: string,
     *         slug: string,
     *         category: string,
     *         preference_score: float,
     *         formatted_score: string,
     *         percentage_score: float,
     *         criteria_breakdown: array<string, array{x: ?float, r: float, v: float}>
     *     }>,
     *     reasons: array<string>,
     *     persisted: bool,
     *     recommendation_id: ?int,
     *     method: string,
     *     method_version: string
     * }
     */
    public function recommend(Student $student, ?Period $period = null, bool $persist = true): array
    {
        $period = $period ?? Period::where('is_active', true)->first();

        // 1. Dapatkan Matriks Keputusan X dari layanan Phase 5A
        $matrixData = $this->matrixService->build($student, $period);

        // 2. Validasi kesiapan
        $validation = $this->validateReadiness($matrixData);

        if (! $validation['is_ready']) {
            return [
                'status' => 'NOT_READY',
                'status_label' => 'Rekomendasi Belum Dapat Dihitung (Menunggu Validasi)',
                'student_id' => $student->id,
                'student_name' => $student->name,
                'period_id' => $period?->id,
                'criteria' => $matrixData['criteria'] ?? [],
                'matrix_x' => $matrixData['matrix_x'] ?? [],
                'matrix_r' => [],
                'matrix_v' => [],
                'ranking' => [],
                'reasons' => $validation['reasons'],
                'persisted' => false,
                'recommendation_id' => null,
                'method' => self::METHOD_NAME,
                'method_version' => self::METHOD_VERSION,
            ];
        }

        $criteria = $matrixData['criteria'];
        $matrixX = $matrixData['matrix_x'];
        $alternatives = $matrixData['alternatives'];

        // 3. Normalisasi R
        $matrixR = $this->normalizeMatrix($matrixX, $criteria);

        // 4. Matriks Berbobot V
        $matrixV = $this->calculateWeightedMatrix($matrixR, $criteria);

        // 5. Nilai Preferensi Vi
        $preferenceScores = $this->calculatePreferenceScores($matrixV);

        // 6. Peringkat Deterministik
        $ranking = $this->rankAlternatives($alternatives, $preferenceScores, $matrixX, $matrixR, $matrixV);

        // 7. Simpan ke database (hanya jika siap dan diminta)
        $persistedRecommendation = null;
        if ($persist && $period) {
            $persistedRecommendation = $this->persistRecommendation($student, $period, $ranking);
        }

        return [
            'status' => 'READY',
            'status_label' => 'Rekomendasi Berhasil Dihitung',
            'student_id' => $student->id,
            'student_name' => $student->name,
            'period_id' => $period?->id,
            'criteria' => $criteria,
            'matrix_x' => $matrixX,
            'matrix_r' => $matrixR,
            'matrix_v' => $matrixV,
            'ranking' => $ranking,
            'reasons' => [],
            'persisted' => $persistedRecommendation !== null,
            'recommendation_id' => $persistedRecommendation?->id,
            'method' => self::METHOD_NAME,
            'method_version' => self::METHOD_VERSION,
        ];
    }

    /**
     * Validasi apakah matriks keputusan siap untuk eksekusi SAW.
     *
     * @param array<string, mixed> $matrixData
     * @return array{is_ready: bool, reasons: array<string>}
     */
    public function validateReadiness(array $matrixData): array
    {
        $reasons = $matrixData['reasons'] ?? [];

        // Periksa apakah status matriks dari Phase 5A belum siap
        if (($matrixData['status'] ?? 'NOT_READY') !== 'READY_FOR_SAW') {
            if (empty($reasons)) {
                $reasons[] = 'Matriks keputusan belum memenuhi syarat kesiapan SAW.';
            }
        }

        // Verifikasi total bobot sama dengan 1.0000 (toleransi: 0.001)
        $criteria = $matrixData['criteria'] ?? [];
        $totalWeight = array_sum(array_column($criteria, 'weight'));
        if (abs($totalWeight - 1.00) > 0.001) {
            $reasons[] = 'Total bobot kriteria tidak bernilai 1.00 (100%).';
        }

        // Periksa apakah alternatif atau kriteria kosong
        $alternatives = $matrixData['alternatives'] ?? [];
        if (empty($alternatives)) {
            $reasons[] = 'Tidak ada alternatif ekstrakurikuler yang dapat dievaluasi.';
        }

        if (count($criteria) < 5) {
            $reasons[] = 'Jumlah kriteria aktif kurang dari 5 kriteria dasar (C1-C5).';
        }

        // Periksa bahwa setiap sel dalam Matriks X memiliki skor kecocokan yang tidak null
        $matrixX = $matrixData['matrix_x'] ?? [];
        $hasNullCell = false;
        foreach ($matrixX as $row) {
            foreach ($row as $val) {
                if ($val === null) {
                    $hasNullCell = true;
                    break 2;
                }
            }
        }

        if ($hasNullCell && ! in_array('Matriks nilai target/ideal ekstrakurikuler belum divalidasi resmi oleh pihak sekolah (Status: NEEDS_VALIDATION). Nilai tidak dikarang bebas demi integritas penelitian.', $reasons, true)) {
            $reasons[] = 'Terdapat nilai kesesuaian pada matriks keputusan yang bernilai null (belum lengkap).';
        }

        $reasons = array_values(array_unique($reasons));

        return [
            'is_ready' => empty($reasons),
            'reasons' => $reasons,
        ];
    }

    /**
     * Normalisasi Matriks Keputusan X menjadi Matriks R sesuai tipe kriteria.
     *
     * Benefit: rij = xij / max_i(xij)
     * Cost:    rij = min_i(xij) / xij
     *
     * @param array<int, array<string, ?float>> $matrixX
     * @param array<string, array{type: string}> $criteria
     * @return array<int, array<string, float>> Matrix R
     */
    public function normalizeMatrix(array $matrixX, array $criteria): array
    {
        $matrixR = [];

        // Hitung terlebih dahulu max dan min untuk setiap kolom kriteria
        $colMax = [];
        $colMin = [];

        foreach ($criteria as $code => $crit) {
            $values = [];
            foreach ($matrixX as $row) {
                if (isset($row[$code]) && $row[$code] !== null) {
                    $values[] = (float) $row[$code];
                }
            }

            $colMax[$code] = ! empty($values) ? max($values) : 0.0;
            $colMin[$code] = ! empty($values) ? min($values) : 0.0;
        }

        // Hitung nilai ternormalisasi rij untuk setiap sel
        foreach ($matrixX as $altId => $row) {
            $matrixR[$altId] = [];

            foreach ($criteria as $code => $crit) {
                $xij = isset($row[$code]) && $row[$code] !== null ? (float) $row[$code] : 0.0;
                $type = strtolower($crit['type'] ?? 'benefit');

                if ($type === 'cost') {
                    $min = $colMin[$code];
                    $rij = ($xij > 0.0) ? ($min / $xij) : 0.0;
                } else {
                    // Default ke benefit
                    $max = $colMax[$code];
                    $rij = ($max > 0.0) ? ($xij / $max) : 0.0;
                }

                $matrixR[$altId][$code] = round($rij, 4);
            }
        }

        return $matrixR;
    }

    /**
     * Hitung Matriks Berbobot V: vij = rij * wj.
     *
     * @param array<int, array<string, float>> $matrixR
     * @param array<string, array{weight: float}> $criteria
     * @return array<int, array<string, float>> Matrix V
     */
    public function calculateWeightedMatrix(array $matrixR, array $criteria): array
    {
        $matrixV = [];

        foreach ($matrixR as $altId => $row) {
            $matrixV[$altId] = [];

            foreach ($criteria as $code => $crit) {
                $rij = $row[$code] ?? 0.0;
                $wj = (float) ($crit['weight'] ?? 0.0);
                $vij = $rij * $wj;

                $matrixV[$altId][$code] = round($vij, 4);
            }
        }

        return $matrixV;
    }

    /**
     * Hitung Nilai Preferensi Vi untuk setiap alternatif: Vi = sum(vij).
     *
     * @param array<int, array<string, float>> $matrixV
     * @return array<int, float> [altId => Vi]
     */
    public function calculatePreferenceScores(array $matrixV): array
    {
        $scores = [];

        foreach ($matrixV as $altId => $row) {
            $sum = array_sum($row);
            $scores[$altId] = round($sum, 4);
        }

        return $scores;
    }

    /**
     * Peringkatkan alternatif berdasarkan nilai preferensi secara menurun dengan pemecah seri deterministik.
     *
     * Pemecah seri:
     * 1. Nilai preferensi lebih tinggi
     * 2. ID alternatif lebih kecil (fallback deterministik)
     *
     * @param array<int, array<string, mixed>> $alternatives
     * @param array<int, float> $preferenceScores
     * @param array<int, array<string, ?float>> $matrixX
     * @param array<int, array<string, float>> $matrixR
     * @param array<int, array<string, float>> $matrixV
     * @return array<int, array{
     *     rank: int,
     *     extracurricular_id: int,
     *     name: string,
     *     slug: string,
     *     category: string,
     *     preference_score: float,
     *     formatted_score: string,
     *     percentage_score: float,
     *     criteria_breakdown: array<string, array{x: ?float, r: float, v: float}>
     * }>
     */
    public function rankAlternatives(
        array $alternatives,
        array $preferenceScores,
        array $matrixX = [],
        array $matrixR = [],
        array $matrixV = []
    ): array {
        $ranked = [];

        foreach ($alternatives as $alt) {
            $id = (int) $alt['extracurricular_id'];
            $score = $preferenceScores[$id] ?? 0.0;

            $breakdown = [];
            if (isset($matrixX[$id])) {
                foreach ($matrixX[$id] as $code => $xVal) {
                    $breakdown[$code] = [
                        'x' => $xVal,
                        'r' => $matrixR[$id][$code] ?? 0.0,
                        'v' => $matrixV[$id][$code] ?? 0.0,
                    ];
                }
            }

            $ranked[] = [
                'extracurricular_id' => $id,
                'name' => $alt['name'],
                'slug' => $alt['slug'],
                'category' => $alt['category'],
                'preference_score' => $score,
                'formatted_score' => number_format($score, 4),
                'percentage_score' => round($score * 100, 2),
                'criteria_breakdown' => $breakdown,
            ];
        }

        // Sort descending by preference score, then ascending by extracurricular_id
        usort($ranked, function ($a, $b) {
            if ($b['preference_score'] !== $a['preference_score']) {
                return $b['preference_score'] <=> $a['preference_score'];
            }

            // Deterministic tie-breaker
            return $a['extracurricular_id'] <=> $b['extracurricular_id'];
        });

        // Assign 1-indexed rank
        $result = [];
        foreach ($ranked as $index => $item) {
            $item['rank'] = $index + 1;
            $result[] = $item;
        }

        return $result;
    }

    /**
     * Simpan hasil rekomendasi ke database dalam transaksi idempoten.
     *
     * @param array<int, array<string, mixed>> $ranking
     */
    public function persistRecommendation(Student $student, Period $period, array $ranking): Recommendation
    {
        return DB::transaction(function () use ($student, $period, $ranking) {
            // Find or create parent recommendation record
            $recommendation = Recommendation::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'period_id' => $period->id,
                ],
                [
                    'method_name' => 'SAW',
                    'method_version' => self::METHOD_VERSION,
                    'generated_at' => now(),
                ]
            );

            // Replace recommendation items
            $recommendation->items()->delete();

            foreach ($ranking as $item) {
                $recommendation->items()->create([
                    'extracurricular_id' => $item['extracurricular_id'],
                    'score' => $item['preference_score'],
                    'rank' => $item['rank'],
                    'explanation' => "Skor preferensi kecocokan SAW: {$item['formatted_score']} (Peringkat #{$item['rank']})",
                ]);
            }

            return $recommendation;
        });
    }
}
