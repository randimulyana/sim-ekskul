<?php

namespace Database\Seeders;

use App\Services\CriteriaConfigurationService;
use Illuminate\Database\Seeder;

class CriteriaPhase4Seeder extends Seeder
{
    /**
     * Jalankan seeder konfigurasi kriteria.
     */
    public function run(): void
    {
        $service = app(CriteriaConfigurationService::class);
        $service->setupProposedConfiguration();
        $service->setupResearchTargetMappings();
    }
}
