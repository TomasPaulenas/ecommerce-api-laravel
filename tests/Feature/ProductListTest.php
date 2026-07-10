<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_products_list(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }
}
