<?php

namespace Tests;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function passportActingAsClient(array $scopes = ['*']): Client
    {
        return Passport::actingAsClient(
            Client::factory()->create(),
            $scopes
        );
    }

    public function passportActingAsUser(array $scopes = ['*']): Authenticatable|HasApiTokens
    {
        return Passport::actingAs(
            User::factory()->create(),
            $scopes
        );
    }
}
