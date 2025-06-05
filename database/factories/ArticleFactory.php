<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uid'=>'1',
            'type'=>$this->faker->numberBetween(1, 2),
            'cid'=>$this->faker->numberBetween(1, 5),
            'title' => $this->faker->sentence(5, true),
            'content' => $this->faker->paragraphs(4, true),
            'view' => $this->faker->numberBetween(1, 200),
            'file' => '',
            'name' => $this->faker->unique()->name,
            'phone' => $this->faker->unique()->phoneNumber,
        ];
    }
}
