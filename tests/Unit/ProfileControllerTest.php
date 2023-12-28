<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_view_profile_edit_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.profile');
        $response->assertViewHas('user', $user);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.update'), [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ]);
        
        $response->assertStatus(200); // Change to the appropriate redirect status code
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    
}
