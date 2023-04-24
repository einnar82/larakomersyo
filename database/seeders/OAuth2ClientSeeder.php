<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuth2ClientSeeder extends Seeder
{
    /**
     * @const string
     */
    private const OAUTH_CLIENTS_TABLE = 'oauth_clients';

    /**
     * @const string[]
     */
    private const SELECTED_ENVIRONMENTS = ['local', 'testing'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (\in_array(\config('app.env'), self::SELECTED_ENVIRONMENTS)) {
            DB::table(self::OAUTH_CLIENTS_TABLE)->truncate();
            DB::table(self::OAUTH_CLIENTS_TABLE)->insert([
                [
                    'id' => 1,
                    'user_id' => null,
                    'name' => 'Laravel Personal Access Client',
                    'secret' => 'pq13PBp9n8Ffatl8JCPuphJW6w6rCsLk81Ca22Lq',
                    'provider' => null,
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 1,
                    'password_client' => 0,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'id' => 2,
                    'user_id' => null,
                    'name' => 'Laravel Password Grant Client',
                    'secret' => 'IgJHJHYCTy3bDLKk5LX3JtVFRtjqunOWy9hddY2Q',
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'id' => 3,
                    'user_id' => null,
                    'name' => 'Laravel ClientCredentials Grant Client',
                    'secret' => 'jZskEWSflrjdF4tz14h4g5HkyceLWfQdApArCoDh',
                    'provider' => null,
                    'redirect' => '',
                    'personal_access_client' => 0,
                    'password_client' => 0,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]
            ]);
        }
    }
}
