<?php

namespace Database\Seeders;
use App\Models\Post;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::factory()->count(10)->create([
            'subpage_id' => \App\Models\Subpage::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ]);
    }
}