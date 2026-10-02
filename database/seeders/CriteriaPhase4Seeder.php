<?php

namespace Database\Seeders;

use App\Services\CriteriaConfigurationService;
use Illuminate\Database\Seeder;

class CriteriaPhase4Seeder extends Seeder
{
    /**
     * Run the criteria configuration seeder.
     */
    public function run(): void
    {
        $service = app(CriteriaConfigurationService::class);
        $service->setupProposedConfiguration();
    }
}
