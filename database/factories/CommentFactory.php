<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => $this->faker->numberBetween(1,count(Post::get())),
            'user_id' => $this->faker->numberBetween(1,count(User::get())),
            'text' => $this->faker->realText($maxNbChars = 200),
            'date_posted' => $this->faker->dateTimeBetween('-1 week', '+1 week')
        ];
    }
}
