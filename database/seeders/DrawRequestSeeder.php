<?php

namespace Database\Seeders;

use App\Models\DrawRequest;
use Illuminate\Database\Seeder;

class DrawRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrawRequest::factory()
            ->count(5)
            ->create();
    }
}
