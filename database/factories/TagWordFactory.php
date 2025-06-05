<?php

namespace Database\Factories;

use App\Models\TagWord;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagWordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tagword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'word' => $this->faker->word,
            'num' => $this->faker->numberBetween(1, 200),
        ];
    }
}
