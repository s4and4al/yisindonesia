<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

#[Signature('app:create-admin-user')]
#[Description('Create the initial YISI CMS administrator')]
class CreateAdminUser extends Command
{
    public function handle(): int
    {
        $data = Validator::make([
            'name' => $this->ask('Nama administrator'),
            'email' => $this->ask('Alamat email'),
        ], [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
        ])->validate();

        $password = $this->secret('Password (minimal 12 karakter)');
        $confirmedPassword = $this->secret('Ulangi password');

        Validator::make([
            'password' => $password,
            'password_confirmation' => $confirmedPassword,
        ], [
            'password' => ['required', 'string', Password::min(12), 'confirmed'],
        ])->validate();

        User::query()->create([
            ...$data,
            'password' => $password,
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->info('Akun administrator berhasil dibuat. Login melalui /admin.');

        return self::SUCCESS;
    }
}
