<?php

namespace Database\Factories;

use Faker\Provider\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecretFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'secret' => Text::randomLetter(),
        ];
    }
}
