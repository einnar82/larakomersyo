<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @const string[]
     */
    private const RESPONSE_STRUCTURE = [
        'access_token',
        'expires_in',
        'refresh_token',
        'token_type',
    ];


    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $this->seed(OAuth2ClientSeeder::class);
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $payload = $response->json();
        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $this->assertNotNull($payload['access_token']);
        $this->assertNotNull($payload['refresh_token']);
        $this->assertEquals('Bearer' , $payload['token_type']);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $this->seed(OAuth2ClientSeeder::class);

        $response = $this->postJson('/api/login', [
            'email' => 'wrong@gmail.com',
            'password' => 'somePassword'
        ]);

        $payload = $response->json();
        $response->isNotFound();
        $this->assertNotNull($payload['message']);
    }
}
