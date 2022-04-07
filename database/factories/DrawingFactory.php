<?php

namespace Database\Factories;

use App\Models\Drawing;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrawingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Drawing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'component_name' => $this->faker->text(255),
            'drawing_name' => $this->faker->text(255),
            'status' => $this->faker->text(255),
            'rev' => $this->faker->randomNumber(0),
            'files' => [],
            'uploaded_at' => $this->faker->dateTime,
            'uploaded_by' => $this->faker->randomNumber,
            'reviewed_at' => $this->faker->dateTime,
            'reviewed_by' => $this->faker->randomNumber,
            'review_note' => $this->faker->text,
            'review_files' => [],
            'uploaded_by' => \App\Models\User::factory(),
            'reviewed_by' => \App\Models\User::factory(),
            'request_id' => \App\Models\DrawRequest::factory(),
        ];
    }
}
