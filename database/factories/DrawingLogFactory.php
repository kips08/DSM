<?php

namespace Database\Factories;

use App\Models\DrawingLog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrawingLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrawingLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->text(255),
            'rev' => $this->faker->randomNumber(0),
            'files' => [],
            'uploaded_at' => $this->faker->dateTime,
            'uploaded_by' => $this->faker->randomNumber,
            'reviewed_at' => $this->faker->dateTime,
            'reviewed_by' => $this->faker->randomNumber,
            'review_note' => $this->faker->text,
            'review_files' => [],
            'reviewed_by' => \App\Models\User::factory(),
            'drawing_id' => \App\Models\Drawing::factory(),
            'uploaded_by' => \App\Models\User::factory(),
        ];
    }
}
