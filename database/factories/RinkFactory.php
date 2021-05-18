<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\Models\Rink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class RinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'TEST City '.$this->faker->numberBetween($min = 001, $max = 999)
        ];
    }

   
}

