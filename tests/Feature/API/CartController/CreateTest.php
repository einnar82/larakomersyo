<?php

namespace Tests\Feature\API\CartController;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class CreateTest extends AbstractCartControllerTestCase
{
    public function testCreateSucceeds(): void
    {
        $product = Product::factory()->create();
        $data = [
            'items' => [
                [
                        'product_id' => $product->id,
                        'quantity' => 1
                    ]
                ]
        ];
        $this->passportActingAsUser();

        $response = $this->postJson(self::API_URI, $data);
        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $payload = $response->json('data');

        $this->assertEquals($data['items'][0]['product_id'], $payload[0]['product_id']);
        $this->assertEquals($data['items'][0]['quantity'], $payload[0]['quantity']);
    }

    public function testCreateIfThrowsValidationException(): void
    {
        $this->passportActingAsUser();

        $response = $this->postJson(self::API_URI);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
