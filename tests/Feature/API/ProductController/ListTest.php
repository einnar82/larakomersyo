<?php

namespace Tests\Feature\API\ProductController;

use App\Models\Product;

class ListTest extends AbstractProductControllerTestCase
{
    public function testListSuccess(): void
    {
        $this->passportActingAsClient();
        $product = Product::factory()->create();
        Product::factory(10)->create();

        $response = $this->getJson(self::API_URI);
        $payload = $response->json('data');

        $response->assertSuccessful()
            ->assertJsonStructure(self::LIST_RESPONSE_STRUCTURE);
        $this->assertEquals($product->id, $payload[0]['id']);
        $this->assertEquals($product->price, $payload[0]['price']);
        $this->assertEquals($product->name, $payload[0]['name']);
    }
}
