<?php

namespace API\ProductController;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\API\ProductController\AbstractProductControllerTestCase;

class UpdateTest extends AbstractProductControllerTestCase
{
    public function testUpdateSucceeds(): void
    {
        $product = Product::factory()->create();
        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'price' => number_format($this->faker->randomDigit(), 2)
        ];
        $this->passportActingAsUser();

        $response = $this->putJson(\sprintf(self::API_URI.'/%s', $product->id), $data);

        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['price'], $payload['price']);
        $this->assertEquals($data['name'], $payload['name']);
    }

    public function testProductNotFound(): void
    {
        $this->passportActingAsUser();

        $response = $this->putJson(\sprintf(self::API_URI.'/%s', 'no-id'));

        $response->assertNotFound();
    }

    public function testUpdateIfThrowsValidationException(): void
    {
        $product = Product::factory()->create();
        $this->passportActingAsUser();

        $response = $this->putJson(\sprintf(self::API_URI.'/%s', $product->id), [
            'name' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
