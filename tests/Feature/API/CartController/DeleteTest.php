<?php

namespace Tests\Feature\API\CartController;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class DeleteTest extends AbstractCartControllerTestCase
{
    public function testDeleteSucceeds(): void
    {
        /** @var User $user */
        $user = $this->passportActingAsUser();
        /** @var Cart $cart */
        $cart = Cart::factory(1)
            ->for($user)
            ->for(Product::factory())
            ->create();

        $response = $this->deleteJson(\sprintf(self::API_URI.'/%s', $cart[0]->id));

        $response->assertNoContent();
    }

    public function testUserNotFound(): void
    {
        $this->passportActingAsUser();

        $response = $this->deleteJson(\sprintf(self::API_URI.'/%s', 'no-id'));

        $response->assertNotFound();
    }
}
