<?php

namespace App\Services;

class CompatibilityCalculator
{
    /**
     * Research status indicator.
     * Classified strictly as PROTOTYPE / NEEDS VALIDATION.
     */
    public const METHOD_NAME = 'Absolute Difference Linear Compatibility';
    public const STATUS = 'PROTOTYPE / NEEDS_VALIDATION';
    public const SCALE_MIN = 1.0;
    public const SCALE_MAX = 5.0;
    public const MAX_DIFFERENCE = 4.0; // SCALE_MAX - SCALE_MIN

    /**
     * Calculate linear compatibility between a student's criterion score and an extracurricular target score.
     *
     * Formula:
     * compatibility = 1 - (|student_score - target_score| / 4)
     *
     * Returns NULL if either score is null.
     */
    public function calculate(?float $studentScore, ?float $targetScore): ?float
    {
        if ($studentScore === null || $targetScore === null) {
            return null;
        }

        $difference = abs($studentScore - $targetScore);
        $rawCompatibility = 1.0 - ($difference / self::MAX_DIFFERENCE);

        // Clamp compatibility within [0.0, 1.0] and round to 4 decimals
        return max(0.0, min(1.0, round($rawCompatibility, 4)));
    }

    /**
     * Evaluate compatibility with full contextual metadata and readiness status.
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
