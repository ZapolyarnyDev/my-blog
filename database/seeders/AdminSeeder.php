<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate([
            'name' => 'admin',
        ]);

        Role::query()->firstOrCreate([
            'name' => 'editor',
        ]);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );

        $admin->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}
