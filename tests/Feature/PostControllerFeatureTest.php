<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Subpage;
use App\Models\User;

class PostControllerFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function testCreateView()
    {
        // Assuming you have a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Assuming you have a subpage
        $subpage = Subpage::factory()->create();

        // Visit the create view
        $response = $this->get(route('posts.create', ['subpage' => $subpage]));

        // Assert the response status
        $response->assertStatus(200);

        // Assert that the view contains necessary elements or data
        $response->assertSee('Create Post');
        $response->assertViewHas('subpage', $subpage);
    }

    public function testStoreMethod()
    {
        // Assuming you have a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Assuming you have a subpage
        $subpage = Subpage::factory()->create();

        // Data for the post
        $postData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        // Submit the form
        $response = $this->post(route('posts.store', $subpage->slug), $postData);

        // Assert that the post was created
        $this->assertCount(1, Post::all());

        // Assert the response status and redirection
        $response->assertStatus(302);
        $response->assertRedirect(route('subpages.showSubpage', $subpage->slug));
    }
}
