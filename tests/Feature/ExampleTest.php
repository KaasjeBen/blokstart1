<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_the_homepage(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/');

        $response->assertStatus(200);
    }

    public function test_guests_are_redirected_to_login_before_viewing_the_portfolio(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/home')->assertRedirect(route('login'));
        $this->get(route('portfolio.index'))->assertRedirect(route('login'));
        $this->get(route('portfolio.show', 1))->assertRedirect(route('login'));
    }
}
