<?php

namespace Tests\Feature\API\CartController;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class ListTest extends AbstractCartControllerTestCase
{
    public function testListSuccess(): void
    {
        /** @var User $user */
        $user = $this->passportActingAsUser();
        /** @var Cart $cart */
        $cart = Cart::factory(1)
            ->for($user)
            ->for(Product::factory())
            ->create();
        Cart::factory()
            ->count(10)
            ->for($user)
            ->for(Product::factory())
            ->create();

        $response = $this->getJson(self::API_URI);
        $payload = $response->json('data');

        $response->assertSuccessful()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $this->assertEquals($cart[0]->id, $payload[0]['id']);
        $this->assertEquals($cart[0]->product_id, $payload[0]['product_id']);
        $this->assertEquals($cart[0]->user_id, $payload[0]['user_id']);
    }
}
