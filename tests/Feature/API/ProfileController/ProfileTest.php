<?php

namespace API\ProfileController;

use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker, DatabaseMigrations, RefreshDatabase;

    protected const RESPONSE_STRUCTURE = [
        'data' => [
            '*' => [
                'product_id',
                'user_id',
                'quantity',
                'product',
                'created_at',
                'updated_at'
            ]
        ]
    ];

    protected const API_URI = '/api/cart';

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->seed(OAuth2ClientSeeder::class);
    }
}
