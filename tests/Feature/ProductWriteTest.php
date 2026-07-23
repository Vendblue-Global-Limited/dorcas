<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductWriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_update_a_product_record(): void
    {
        $owner = User::factory()->create(['role' => 'vendor']);
        $actor = User::factory()->create([
            'email' => 'vendor-two@example.test',
            'role' => 'vendor',
        ]);

        $product = Product::factory()->for($owner)->create([
            'name' => 'Original Name',
        ]);

        $response = $this
            ->withHeader('X-User-Email', $actor->email)
            ->patchJson("/api/products/{$product->id}", [
                'name' => 'Updated Name',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Name');
    }
}
