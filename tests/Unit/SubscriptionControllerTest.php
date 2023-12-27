<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Subpage;
use App\Models\User;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscribe_to_subpage()
    {
        $user = User::factory()->create();
        $subpage = Subpage::factory()->create();

        $response = $this->actingAs($user)->post(route('subscribe', ['slug' => $subpage->slug]));

        $response->assertStatus(200); // Check the appropriate redirect status
        $this->assertTrue($user->subscribedTo($subpage)); // Assuming you have a method to check subscription
    }

    public function test_unsubscribe_from_subpage()
    {
        $user = User::factory()->create();
        $subpage = Subpage::factory()->create();

        $user->subscribeTo($subpage); // Assuming you have a method to subscribe

        $response = $this->actingAs($user)->delete(route('unsubscribe', ['slug' => $subpage->slug]));

        $response->assertStatus(302); // Check the appropriate redirect status
        $this->assertFalse($user->subscribedTo($subpage)); // Assuming you have a method to check subscription
    }
}
