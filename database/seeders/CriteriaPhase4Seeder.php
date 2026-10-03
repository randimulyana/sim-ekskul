<?php

namespace Database\Seeders;

use App\Services\KonfigurasiKriteriaService;
use Illuminate\Database\Seeder;

class CriteriaPhase4Seeder extends Seeder
{
    /**
     * Jalankan seeder konfigurasi kriteria.
     */
    public function run(): void
    {
        $service = app(KonfigurasiKriteriaService::class);
        $service->setupProposedConfiguration();
        $service->setupResearchTargetMappings();
    }
}
