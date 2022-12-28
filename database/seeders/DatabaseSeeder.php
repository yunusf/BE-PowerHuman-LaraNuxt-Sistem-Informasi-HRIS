<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Responsibility;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // membuat data faker untuk user
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory(10)->unverified()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // membuat data faker untuk company
        // Company::factory(10)->create();

        // membuat data faker untuk team
        // Team::factory(30)->create();

        // membuat data faker untuk role
        // Role::factory(50)->create();

        // membuat data faker untuk responsibility
        // Responsibility::factory(200)->create();

        // membuat data faker untuk responsibility
        Employee::factory(970)->create();
    }
}
