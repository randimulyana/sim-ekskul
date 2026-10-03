<?php

namespace App\Services;

class KalkulatorKecocokan
{
    /**
     * Indikator status penelitian.
     * Diklasifikasikan secara ketat sebagai PROTOTYPE / NEEDS VALIDATION.
     */
    public const METHOD_NAME = 'Absolute Difference Linear Compatibility';
    public const STATUS = 'PROTOTYPE / NEEDS_VALIDATION';
    public const SCALE_MIN = 1.0;
    public const SCALE_MAX = 5.0;
    public const MAX_DIFFERENCE = 4.0; // SCALE_MAX - SCALE_MIN

    /**
     * Hitung kecocokan linier antara skor kriteria seorang siswa dan skor target ekstrakurikuler.
     *
     * Formula:
     * compatibility = 1 - (|student_score - target_score| / 4)
     *
     * Mengembalikan NULL jika salah satu skor bernilai null.
     */
    public function calculate(?float $studentScore, ?float $targetScore): ?float
    {
        if ($studentScore === null || $targetScore === null) {
            return null;
        }

        $difference = abs($studentScore - $targetScore);
        $rawCompatibility = 1.0 - ($difference / self::MAX_DIFFERENCE);

        // Batasi nilai kecocokan dalam rentang [0.0, 1.0] dan bulatkan ke 4 desimal
        return max(0.0, min(1.0, round($rawCompatibility, 4)));
    }

    /**
     * Evaluasi kecocokan dengan metadata kontekstual lengkap dan status kesiapan.
     *
     * @param float|null $studentScore
     * @param float|null $targetScore
     * @param string|null $mappingStatus
     * @return array{
     *     student_score: ?float,
     *     target_score: ?float,
     *     difference: ?float,
     *     compatibility: ?float,
     *     status: string,
     *     status_label: string,
     *     method: string,
     *     method_status: string
     * }
     */
    public function evaluate(?float $studentScore, ?float $targetScore, ?string $mappingStatus = null): array
    {
        $compatibility = $this->calculate($studentScore, $targetScore);
        $difference = ($studentScore !== null && $targetScore !== null)
            ? round(abs($studentScore - $targetScore), 4)
            : null;

        if ($targetScore === null) {
            $status = 'NEEDS_VALIDATION';
            $statusLabel = 'Target Ekstrakurikuler Belum Ditetapkan';
        } elseif ($mappingStatus !== null && strtolower($mappingStatus) !== 'validated') {
            $status = 'NEEDS_VALIDATION';
            $statusLabel = 'Pemetaan Menunggu Validasi Resmi Sekolah';
        } elseif ($studentScore === null) {
            $status = 'NOT_READY';
            $statusLabel = 'Skor Kriteria Siswa Belum Lengkap';
        } else {
            $status = 'READY';
            $statusLabel = 'Siap Digunakan';
        }

        return [
            'student_score' => $studentScore,
            'target_score' => $targetScore,
            'difference' => $difference,
            'compatibility' => $compatibility,
            'status' => $status,
            'status_label' => $statusLabel,
            'method' => self::METHOD_NAME,
            'method_status' => self::STATUS,
        ];
    }
}
