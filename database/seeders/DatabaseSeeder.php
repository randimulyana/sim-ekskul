<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed database aplikasi.
     */
    public function run(): void
    {
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
