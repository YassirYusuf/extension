<?php

namespace Database\Factories;

use App\Models\Subpage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubpageFactory extends Factory
{
    protected $model = Subpage::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(1),
            'description' => $this->faker->paragraph,
            'owner_id' => User::factory()->create()->id,
            'slug' => $this->faker->unique()->slug,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
