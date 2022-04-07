<?php

namespace Database\Seeders;

use App\Models\Drawing;
use Illuminate\Database\Seeder;

class DrawingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drawing::factory()
            ->count(5)
            ->create();
    }
}
