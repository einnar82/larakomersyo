<?php

namespace Tests\Feature\API\ProductController;

use App\Models\Product;

class DeleteTest extends AbstractProductControllerTestCase
{
    public function testDeleteSucceeds(): void
    {
        $product = Product::factory()->create();
        $this->passportActingAsUser();

        $response = $this->deleteJson(\sprintf(self::API_URI.'/%s', $product->id));

        $response->assertNoContent();
    }

    public function testProductNotFound(): void
    {
        $this->passportActingAsUser();

        $response = $this->deleteJson(\sprintf(self::API_URI.'/%s', 'no-id'));

        $response->assertNotFound();
    }
}
