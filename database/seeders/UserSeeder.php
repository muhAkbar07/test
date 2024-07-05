<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        // 1. create a super admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        $superAdmin->syncRoles('Super Admin');

        // 2. create an admin unit
        $adminUnit = User::factory()->create([
            'name' => 'Admin Unit',
            'email' => 'adminunit@example.com',
            'unit_id' => 1,
        ]);
        $adminUnit->syncRoles('Admin Unit');

        // 3. create a staff unit
        $staffUnit = User::factory()->create([
            'name' => 'Staff Unit',
            'email' => 'staffunit@example.com',
            'unit_id' => 1,
        ]);
        $staffUnit->syncRoles('Staff Unit');
    }
}