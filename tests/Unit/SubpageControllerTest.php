<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Subpage;
use App\Models\User;
use Tests\TestCase;

class SubpageControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_show_subpage(): void
    {
        $subpage = Subpage::factory()->create(); // Create a single subpage for testing
    
        $response = $this->get(route('subpages.showSubpage', ['slug' => $subpage->slug]));
    
        $response->assertStatus(200);
        $response->assertViewIs('subpages.show');
        $response->assertViewHas('subpage', $subpage);
    }

    public function test_show_all_subpages()
    {
        $subpages = Subpage::factory()->count(5)->create();
        $response = $this->get(route('subpages.showAll'));
        $response->assertStatus(200);
        $response->assertViewIs('subpages.subpages');
        $response->assertViewHas('subpages', $subpages);
    }

    public function test_search_subpages()
    {
        Subpage::factory()->create([
            'name' => 'Sample Subpage',
            'description' => 'Sample Description'
        ]);
    
        $response = $this->get(route('subpages.search', ['search' => 'Sample']));
        $response->assertStatus(200);
        $response->assertViewIs('subpages.subpages');
        $response->assertSee('Sample Subpage');
        $response->assertSee('Sample Description');
    }

    public function test_subscribed_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('subpages.subscribed'));
        $response->assertStatus(200);
        $response->assertViewIs('subpages.subscribed');
    }

    public function test_create_subpage_view()
    {
        $response = $this->get(route('subpages.create'));
        $response->assertStatus(302);
        $response->assertViewIs('subpages.create');
    }

    public function test_store_subpage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subpageData = [
            'name' => 'New Subpage',
            'description' => 'New Subpage Description'
        ];

        $response = $this->post(route('subpages.store'), $subpageData);
        $response->assertRedirect();

        $this->assertDatabaseHas('subpages', $subpageData);
    }


}
