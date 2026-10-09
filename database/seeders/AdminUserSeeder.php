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

        $now = now();

        DB::transaction(function () use ($email, $password, $now): void {
            $target = DB::table('users')->where('email', $email)->lockForUpdate()->first();
            $admins = DB::table('users')->where('is_admin', true)->lockForUpdate()->get(['id']);

            if ($target !== null && ! (bool) $target->is_admin) {
                throw new RuntimeException('ADMIN_EMAIL belongs to a non-admin user; no account was changed.');
            }

            if ($target !== null) {
                DB::table('users')->where('id', $target->id)->update([
                    'password' => Hash::make($password),
                    'updated_at' => $now,
                ]);

                return;
            }

            if ($admins->count() > 1) {
                throw new RuntimeException('Multiple administrators exist; set ADMIN_EMAIL to one of their current email addresses.');
            }

            if ($admins->count() === 1) {
                DB::table('users')->where('id', $admins->first()->id)->update([
                    'email' => $email,
                    'password' => Hash::make($password),
                    'updated_at' => $now,
                ]);

                return;
            }

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
