<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        if (! app()->environment('production')) {
            return;
        }

        $email = env('PORTFOLIO_ADMIN_RECOVERY_EMAIL');
        $password = env('PORTFOLIO_ADMIN_RECOVERY_PASSWORD');

        if (! is_string($email) || $email === '' || ! is_string($password) || strlen($password) < 32) {
            throw new RuntimeException('Admin recovery configuration is missing or invalid.');
        }

        $connection = DB::connection();

        if ($connection->getDriverName() !== 'mysql') {
            throw new RuntimeException('Admin recovery requires the production MySQL connection.');
        }

        if (! $connection->getSchemaBuilder()->hasTable('users')) {
            throw new RuntimeException('Admin recovery could not find the users table.');
        }

        $connection->transaction(function () use ($connection, $email, $password): void {
            $admin = $connection->table('users')
                ->where('email', $email)
                ->where('is_admin', true)
                ->lockForUpdate()
                ->first();

            if ($admin !== null) {
                $connection->table('users')
                    ->where('id', $admin->id)
                    ->update([
                        'password' => Hash::make($password),
                        'updated_at' => now(),
                    ]);

                return;
            }

            $existingAdmins = $connection->table('users')
                ->where('is_admin', true)
                ->lockForUpdate()
                ->get(['id']);

            if ($existingAdmins->count() === 1) {
                $existingUser = $connection->table('users')
                    ->where('email', $email)
                    ->lockForUpdate()
                    ->first();

                if ($existingUser !== null && (int) $existingUser->id !== (int) $existingAdmins->first()->id) {
                    throw new RuntimeException('The recovery email belongs to another user; recovery stopped without changes.');
                }

                $connection->table('users')
                    ->where('id', $existingAdmins->first()->id)
                    ->update([
                        'email' => $email,
                        'password' => Hash::make($password),
                        'updated_at' => now(),
                    ]);

                return;
            }

            if ($existingAdmins->count() > 1) {
                throw new RuntimeException('A different production admin exists; recovery stopped without changes.');
            }

            $existingUser = $connection->table('users')
                ->where('email', $email)
                ->lockForUpdate()
                ->first();

            $attributes = [
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ];

            if ($existingUser !== null) {
                $connection->table('users')
                    ->where('id', $existingUser->id)
                    ->update($attributes);

                return;
            }

            $connection->table('users')->insert([
                'name' => 'Portfolio Administrator',
                'email' => $email,
                ...$attributes,
                'created_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        throw new LogicException('Admin credential recovery is a one-time operation and cannot be rolled back.');
    }
};
