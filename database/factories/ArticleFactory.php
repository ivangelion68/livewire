<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articles>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image'=>$this->faker->imageUrl,
            'title'=> $this->faker->sentence,
            'content'=>$this->faker->paragraph,
            'slug'=>$this->faker->slug,
            'user_id'=>User::factory()
        ];
    }
}
