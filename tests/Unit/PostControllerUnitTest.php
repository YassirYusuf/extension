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
