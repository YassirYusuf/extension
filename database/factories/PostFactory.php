<?php

namespace Database\Factories;
use App\Models\Post;
use App\Models\Subpage;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'subpage_id' => Subpage::factory()->create()->id,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'slug' => $this->faker->unique()->slug,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
