<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Fetch roles
        $adminRole = \App\Models\Role::where('name', 'Admin')->first();
        $hrRole = \App\Models\Role::where('name', 'HR')->first();
        $leadRole = \App\Models\Role::where('name', 'Lead')->first();
        $employeeRole = \App\Models\Role::where('name', 'Employee')->first();
        $internRole = \App\Models\Role::where('name', 'Intern')->first();

        // Admin User
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'employee_code' => 'EMP001',
            'phone' => '1234567890',
            'status' => 'active',
            'role_id' => $adminRole->id,
        ]);

        // HR User
        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Connor',
            'email' => 'sarah.c@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'employee_code' => 'EMP002',
            'phone' => '9876543210',
            'status' => 'active',
            'role_id' => $hrRole->id,
        ]);

        // Lead User
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'employee_code' => 'EMP003',
            'phone' => '5551234567',
            'status' => 'active',
            'role_id' => $leadRole->id,
        ]);

        // Employees & Interns
        $firstNames = ['Alice', 'Bob', 'Charlie', 'David', 'Eva', 'Frank', 'Grace', 'Henry', 'Ivy', 'Jack', 'Karen', 'Leo', 'Mia'];
        $lastNames = ['Smith', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson', 'Thomas', 'Anderson', 'Taylor', 'Moore', 'Jackson', 'Martin'];
        
        $roles = [$employeeRole, $internRole];
        $statuses = ['active', 'inactive'];

        for ($i = 0; $i < 13; $i++) {
            $role = $roles[array_rand($roles)];
            $status = $statuses[array_rand($statuses)];
            $code = 'EMP' . str_pad($i + 4, 3, '0', STR_PAD_LEFT);

            User::create([
                'first_name' => $firstNames[$i],
                'last_name' => $lastNames[$i],
                'email' => strtolower($firstNames[$i] . '.' . $lastNames[$i] . '@example.com'),
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'employee_code' => $code,
                'phone' => '5550000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => $status,
                'role_id' => $role->id,
            ]);
        }
    }
}
