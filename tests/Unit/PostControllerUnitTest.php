<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Subpage;
use App\Models\User;

class PostControllerUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testStoreMethod()
    {
       // Assuming you have a user
    $user = User::factory()->create();
    $this->actingAs($user);

    // Assuming you have a subpage
    $subpage = Subpage::factory()->create();

    // Post data to store a new post
    $postData = [
        'title' => 'Test Post Title',
        'content' => 'Test Post Content'
    ];

    $response = $this->post(route('subpages.posts.store', ['slug' => $subpage->slug]), $postData);

    // Check for a successful response or appropriate redirect
    $response->assertStatus(302); // Check for a redirect status

    // Optionally, assert for a redirection to a specific route
    $response->assertRedirect(route('subpages.showSubpage', ['slug' => $subpage->slug]));

    // Optionally, assert that the post was created in the database
    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post Title',
        'content' => 'Test Post Content'
        // Add more fields to check as necessary
    ]);
    }


    public function testToggleLikeMethod()
    {
        // Assuming you have a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Assuming you have a subpage and a post
        $subpage = Subpage::factory()->create();
        $post = Post::factory()->create(['subpage_id' => $subpage->id]);

        // Toggle like for the post
        $response = $this->post(route('posts.like.toggle', ['slug' => $subpage->slug, 'postSlug' => $post->slug]));

        // Assert that the like was toggled
        $this->assertCount(1, $post->likes);

        // Toggle like again
        $response = $this->post(route('posts.like.toggle', ['slug' => $subpage->slug, 'postSlug' => $post->slug]));

        // Assert that the like was removed
        $this->assertCount(0, $post->fresh()->likes);
    }

    public function testDestroyMethod()
    {
        // Assuming you have a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Assuming you have a subpage and a post
        $subpage = Subpage::factory()->create();
        $post = Post::factory()->create(['subpage_id' => $subpage->id, 'user_id' => $user->id]);

        // Delete the post
        $response = $this->delete(route('subpages.posts.destroy', ['slug' => $subpage->slug, 'postSlug' => $post->slug]));

        // Assert that the post was deleted
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);

        // Assert the response status and redirection
        $response->assertStatus(302);
        //$response->assertRedirect(route('subpages.showSubpage', $subpage->slug));
        
    }
}
