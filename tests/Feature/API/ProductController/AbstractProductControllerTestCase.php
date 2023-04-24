<?php

namespace Tests\Feature\API\ProductController;

use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class AbstractProductControllerTestCase extends TestCase
{
    use WithFaker, RefreshDatabase, DatabaseMigrations;

    protected const RESPONSE_STRUCTURE = [
      'data' => [
          'created_at',
          'updated_at',
          'image_url',
          'description',
          'name',
          'price'
      ]
    ];

    protected const LIST_RESPONSE_STRUCTURE = [
        'data',
        'links' => [
            "first",
            "last",
            "prev",
            "next",
        ],
        "meta" => [
            "current_page",
            "from",
            "path",
            "per_page",
            "to"
        ]
    ];


    protected const API_URI = '/api/products';

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->seed(OAuth2ClientSeeder::class);
    }
}
