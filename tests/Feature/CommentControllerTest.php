<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Subpage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CommentController;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_comment_is_stored_in_database()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a subpage and post for the user
        $subpage = Subpage::factory()->create();
        $post = Post::factory()->create(['subpage_id' => $subpage->id]);

        // Mock a request with the required data
        $content = $this->faker->sentence;
        $response = $this->actingAs($user)->post(route('posts.comments.store', [$subpage->slug, $post->slug]), [
            'content' => $content,
        ]);

        // Assert the response
        $response->assertRedirect(); // Assuming your store method uses a redirect

        // Assert the comment is stored in the database
        $this->assertDatabaseHas('comments', [
            'content' => $content,
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Additional assertions if needed
    }


    public function testToggleLike()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a comment
        $comment = Comment::factory()->create();

        // Acting as the authenticated user
        $this->actingAs($user);

        // Make a POST request to toggle the like
        $response = $this->post(route('comments.toggleLike', $comment));

        // Assert that the response is a redirect back
        $response->assertRedirect();

        // Assert that the like status is toggled
        $this->assertTrue($comment->fresh()->isLikedByUser($user));

        // Toggle the like again
        $this->post(route('comments.toggleLike', $comment));

        // Assert that the like is removed
        $this->assertFalse($comment->fresh()->isLikedByUser($user));
    }
    
    

    public function testDestroyComment()
    {
      // Create a user
      $user = User::factory()->create();

      // Create a comment by the user
      $comment = Comment::factory()->create(['user_id' => $user->id]);

      // Acting as the authenticated user
      $this->actingAs($user);

      // Make a DELETE request to the destroy method
      $response = $this->delete(route('comments.destroy', $comment));

      // Assert that the response is a redirect back
      $response->assertRedirect();

      // Assert that the comment is deleted
      $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

      // You can also assert any other behavior, such as checking the session for a status message
      $this->assertTrue(session()->has('status'));
      $this->assertEquals('Comment deleted successfully.', session('status'));
    }

}