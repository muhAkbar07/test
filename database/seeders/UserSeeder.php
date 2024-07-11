<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $roles = ['Super Admin', 'Admin Unit', 'Staff Unit'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Current timestamp for email_verified_at
        $currentTimestamp = now();

        // 1. create a super admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Set the password
                'email_verified_at' => $currentTimestamp, // Set email_verified_at
            ]
        );
        $superAdmin->syncRoles('Super Admin');

        // 2. create an admin unit
        $adminUnit = User::updateOrCreate(
            ['email' => 'adminunit@example.com'],
            [
                'name' => 'Admin Unit',
                'unit_id' => 1,
                'password' => Hash::make('password123'), // Set the password
                'email_verified_at' => $currentTimestamp, // Set email_verified_at
            ]
        );
        $adminUnit->syncRoles('Admin Unit');

        // 3. create a staff unit
        $staffUnit = User::updateOrCreate(
            ['email' => 'staffunit@example.com'],
            [
                'name' => 'Staff Unit',
                'unit_id' => 1,
                'password' => Hash::make('password123'), 
                'email_verified_at' => $currentTimestamp, 
            ]
        );
        $staffUnit->syncRoles('Staff Unit');
    }
}