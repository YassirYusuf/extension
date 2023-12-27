<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subpage;

class SubpageSeeder extends Seeder
{
    public function run()
    {
        Subpage::factory()->count(10)->create([
            'owner_id' => \App\Models\User::factory()->create()->id,
        ]);
    }
}
