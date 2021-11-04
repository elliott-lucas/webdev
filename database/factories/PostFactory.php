<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,100),
            'text' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'date_posted' => $this->faker->dateTimeBetween('-1 week', '+1 week')
        ];
    }
}
