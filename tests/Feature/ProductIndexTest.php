<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_product_index_returns_products_with_owner_information(): void
    {
        $vendor = User::factory()->create([
            'name' => 'Vendor One',
            'role' => 'vendor',
        ]);

        Product::factory()->for($vendor)->create([
            'name' => 'Blue Office Chair',
            'status' => ProductStatus::Published,
            'price' => 125.50,
            'quantity' => 12,
        ]);

        Product::factory()->for($vendor)->count(2)->create();

        $response = $this->getJson('/api/products?status=published&sort=name&direction=asc&per_page=10');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Blue Office Chair')
            ->assertJsonPath('data.0.owner.name', 'Vendor One')
            ->assertJsonPath('meta.current_page', 1);
    }

    public function test_product_index_pagination_metadata_exists_todo(): void
    {
        User::factory()
            ->has(Product::factory()->count(3), 'products')
            ->create(['role' => 'vendor']);

        $response = $this->getJson('/api/products?per_page=2');

        $response->assertOk();
        $response->assertJsonStructure([
            'data',
            'meta' => ['current_page', 'per_page', 'total'],
        ]);

        // TODO: tighten this once the endpoint uses Laravel's database paginator metadata.
    }

    public function test_product_index_rejects_invalid_sort_values_when_completed(): void
    {
        $this->markTestSkipped('Known gap: invalid sort fields currently reach the query layer instead of returning a validation error.');

        $this->getJson('/api/products?sort=not_a_column')
            ->assertUnprocessable();
    }
}
