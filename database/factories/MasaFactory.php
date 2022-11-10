<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                        'user_id' => User::factory(),
            'name' => $this->faker->unique()->masa,
            'profile' => $this->faker->realText,
        ];
    }
}
