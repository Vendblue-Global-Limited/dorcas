<?php

namespace Tests\Unit;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_a_user_and_casts_status(): void
    {
        $vendor = User::factory()->create(['role' => 'vendor']);

        $product = Product::factory()->for($vendor)->create([
            'status' => ProductStatus::Draft,
            'quantity' => 7,
        ]);

        $this->assertTrue($product->user->is($vendor));
        $this->assertSame(ProductStatus::Draft, $product->status);
        $this->assertSame(7, $product->quantity);
    }
}
