<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException('ADMIN_EMAIL must contain a valid administrator email address.');
        }

        if (! is_string($password) || strlen($password) < 32) {
            throw new RuntimeException('ADMIN_PASSWORD must contain at least 32 characters.');
        }

        DB::transaction(function () use ($email, $password): void {
            $admins = DB::table('users')->where('is_admin', true)->lockForUpdate()->get(['id']);

            if ($admins->isNotEmpty()) {
                return;
            }

            $target = DB::table('users')->where('email', $email)->lockForUpdate()->first();

            if ($target !== null) {
                throw new RuntimeException('ADMIN_EMAIL belongs to a non-admin user; no account was changed.');
            }

            $now = now();

            DB::table('users')->insert([
                'name' => env('ADMIN_NAME', 'Portfolio Administrator'),
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }
}
