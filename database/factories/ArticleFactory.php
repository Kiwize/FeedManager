<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(4),
            'description' => $this->faker->paragraph(20),
            'link' => $this->faker->unique()->url(),
            'pubdate' => now(),
            'feed_id' => 1
        ];
    }
}
