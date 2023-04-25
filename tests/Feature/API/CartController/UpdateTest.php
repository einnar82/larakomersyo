<?php

namespace Tests\Feature\API\CartController;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UpdateTest extends AbstractCartControllerTestCase
{
    public function testUpdateSucceeds(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();
        /** @var Cart $cart */
        $cart = Cart::factory()
            ->for(User::factory())
            ->for(Product::factory())
            ->create();

        $data = [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ];
        $this->passportActingAsUser();

        $response = $this->putJson(\sprintf(self::API_URI.'/%s', 'update'), $data);

        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['items'][0]['product_id'], $payload[0]['product_id']);
        $this->assertEquals($data['items'][0]['quantity'], $payload[0]['quantity']);
    }

    public function testUpdateIfThrowsValidationException(): void
    {
        $this->passportActingAsUser();

        $response = $this->putJson(\sprintf(self::API_URI.'/%s', 'update'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
