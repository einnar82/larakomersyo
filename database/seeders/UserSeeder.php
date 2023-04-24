<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@admin.com';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->hasSeededAdminAccount() === false) {
            User::query()->create([
                'email' => self::ADMIN_EMAIL,
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now()->toDateTimeString(),
                'is_admin' => true
            ]);
        }
    }

    private function hasSeededAdminAccount(): bool
    {
        return User::query()
            ->where('email', self::ADMIN_EMAIL)
            ->where('is_admin', 1)
            ->exists();
    }
}
