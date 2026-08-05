<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's admin user.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');

        $admin = User::where('email', $email)->first();

        if ($admin) {
            $admin->update([
                'name' => env('ADMIN_NAME', 'Administrador'),
                'role' => 'admin',
            ]);

            return;
        }

        User::create([
            'name' => env('ADMIN_NAME', 'Administrador'),
            'email' => $email,
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            'role' => 'admin',
        ]);
    }
}
