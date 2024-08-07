<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OutletSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            PrioritySeeder::class,
            TicketStatusSeeder::class,
            ProblemCategorySeeder::class,
            TicketSeeder::class,
        ]);
    }
}