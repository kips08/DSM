<?php

namespace Database\Factories;

use App\Models\DrawRequest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrawRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrawRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->text(255),
            'object_name' => $this->faker->text(255),
            'ship_type' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
