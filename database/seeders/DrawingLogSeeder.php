<?php

namespace Database\Seeders;

use App\Models\DrawingLog;
use Illuminate\Database\Seeder;

class DrawingLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrawingLog::factory()
            ->count(5)
            ->create();
    }
}
