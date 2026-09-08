<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_portfolio_requires_at_least_one_tag(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('portfolio.store'), [
            'title' => 'Untagged portfolio',
            'tags' => [],
        ]);

        $response->assertSessionHasErrors('tags');
        $this->assertDatabaseCount('portfolios', 0);
    }

    public function test_portfolios_can_be_filtered_by_tag(): void
    {
        $user = User::factory()->create();
        $matchingPortfolio = Portfolio::factory()->create([
            'title' => 'Matching portfolio',
            'tags' => ['web-design', 'branding'],
        ]);
        $otherPortfolio = Portfolio::factory()->create([
            'title' => 'Other portfolio',
            'tags' => ['development'],
        ]);

        $response = $this->actingAs($user)->get(route('portfolio.index', ['tag' => 'web-design']));

        $response->assertOk()
            ->assertSee($matchingPortfolio->title)
            ->assertDontSee($otherPortfolio->title);
    }

    public function test_portfolio_tags_can_be_changed_when_editing(): void
    {
        $user = User::factory()->create();
        $portfolio = Portfolio::factory()->create([
            'user_id' => $user->id,
            'tags' => ['web-design'],
        ]);

        $response = $this->actingAs($user)->patch(route('portfolio.update', $portfolio->id), [
            'title' => $portfolio->title,
            'description' => $portfolio->description,
            'email' => $portfolio->email,
            'phone' => $portfolio->phone,
            'tags' => ['branding', 'ui-ux'],
        ]);

        $response->assertRedirect(route('portfolio.index'));
        $this->assertSame(['branding', 'ui-ux'], $portfolio->refresh()->tags);
    }
}
