<?php

namespace Tests\Feature\API\ProductController;

use App\Models\Product;

class ShowTest extends AbstractProductControllerTestCase
{
    public function testShowSucceeds(): void
    {
        $product = Product::factory()->create();
        $this->passportActingAsClient();

        $response = $this->getJson(\sprintf(self::API_URI.'/%s', $product->id));

        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($product->price, $payload['price']);
        $this->assertEquals($product->name, $payload['name']);
    }

    public function testProductNotFound(): void
    {
        $this->passportActingAsClient();

        $response = $this->getJson(\sprintf(self::API_URI.'/%s', 'no-id'));

        $response->assertNotFound();
    }
}
