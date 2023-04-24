<?php

namespace Tests\Feature\API\ProductController;

use Symfony\Component\HttpFoundation\Response;

class CreateTest extends AbstractProductControllerTestCase
{
    public function testCreateSucceeds(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'price' => number_format($this->faker->randomDigit(), 2)
        ];
        $this->passportActingAsUser();

        $response = $this->postJson(self::API_URI, $data);

        $response->assertCreated()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['price'], $payload['price']);
        $this->assertEquals($data['name'], $payload['name']);
    }

    public function testCreateIfThrowsValidationException(): void
    {
        $this->passportActingAsUser();

        $response = $this->postJson(self::API_URI);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
