<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            PrioritySeeder::class,
            TicketStatusSeeder::class,
            ProblemCategoryMigration::class,
            TicketSeeder::class,
        ]);
        // $user1 = User::factory()->create([
        //     'name' => 'Super Admin',
        //     'email' => 'superadmin@example.com',
        // ]);

        // $user2 = User::factory()->create([
        //     'name' => 'Admin Unit',
        //     'email' => 'adminunit@example.com',
        //     'unit_id' => 1,
        // ]);


        // $role = Role::create([
        //     'name' => 'Super Admin',
        //     'guard_name' => 'web',
        // ]);
        // $user1->assignRole('Super Admin');

        // $role = Role::create([
        //     'name' => 'Admin Unit',
        //     'guard_name' => 'web',
        // ]);
        // $user2->assignRole('Admin Unit');
        
    
    }
}