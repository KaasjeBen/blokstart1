<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_portfolio_can_be_created_and_its_image_is_shown_on_show_and_edit_pages(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('portfolio.jpg');

        $response = $this->actingAs($user)->post(route('portfolio.store'), [
            'title' => 'My portfolio',
            'description' => 'A portfolio description',
            'email' => 'portfolio@example.com',
            'phone' => '123456789',
            'tags' => ['web-design'],
            'image' => $image,
        ]);

        $portfolio = Portfolio::firstOrFail();

        $response->assertRedirect(route('portfolio.index'));
        $this->assertNotNull($portfolio->image);
        $this->assertTrue(Storage::disk('public')->exists($portfolio->image));
        $this->actingAs($user)->get(route('portfolio.show', $portfolio->id))
            ->assertOk()
            ->assertSee($portfolio->image);
        $this->actingAs($user)->get(route('portfolio.edit', $portfolio->id))
            ->assertOk()
            ->assertSee($portfolio->image);
    }

    public function test_a_portfolio_image_can_be_replaced(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $oldImage = 'images/old.jpg';
        Storage::disk('public')->put($oldImage, 'old image');
        $portfolio = Portfolio::factory()->create([
            'user_id' => $user->id,
            'image' => $oldImage,
        ]);

        $response = $this->actingAs($user)->patch(route('portfolio.update', $portfolio->id), [
            'title' => $portfolio->title,
            'description' => $portfolio->description,
            'email' => $portfolio->email,
            'phone' => $portfolio->phone,
            'tags' => $portfolio->tags,
            'image' => UploadedFile::fake()->image('replacement.jpg'),
        ]);

        $portfolio->refresh();

        $response->assertRedirect(route('portfolio.index'));
        $this->assertFalse(Storage::disk('public')->exists($oldImage));
        $this->assertTrue(Storage::disk('public')->exists($portfolio->image));
    }
}
