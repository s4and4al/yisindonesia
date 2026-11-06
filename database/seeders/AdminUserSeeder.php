<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Str::password(16);

        User::query()->updateOrCreate(
            ['email' => 'admin@investasisosial.com'],
            [
                'name' => 'Administrator YISI',
                'password' => $password,
                'role' => 'admin',
                'is_active' => true,
            ],
        );

        $this->command?->info('Akun admin berhasil dibuat/diperbarui:');
        $this->command?->info('Email   : admin@investasisosial.com');
        $this->command?->info('Password: ' . $password);
    }
}
