<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@travelshravel.com',
            'role' => 'Admin',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('Admin');

        // Sales Manager
        $salesManager = User::create([
            'name' => 'John Sales Manager',
            'email' => 'salesmanager@travelshravel.com',
            'role' => 'Sales Manager',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $salesManager->assignRole('Sales Manager');

        // Sales Persons
        $sales1 = User::create([
            'name' => 'Priya Sharma',
            'email' => 'priya@travelshravel.com',
            'role' => 'Sales',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $sales1->assignRole('Sales');

        $sales2 = User::create([
            'name' => 'Raj Kumar',
            'email' => 'raj@travelshravel.com',
            'role' => 'Sales',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $sales2->assignRole('Sales');

        $sales3 = User::create([
            'name' => 'Anita Patel',
            'email' => 'anita@travelshravel.com',
            'role' => 'Sales',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $sales3->assignRole('Sales');

        // Operation Manager
        $operationManager = User::create([
            'name' => 'Mike Operations Manager',
            'email' => 'opsmanager@travelshravel.com',
            'role' => 'Operation Manager',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $operationManager->assignRole('Operation Manager');

        // Operation
        $operation = User::create([
            'name' => 'Sarah Operations',
            'email' => 'sarah@travelshravel.com',
            'role' => 'Operation',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $operation->assignRole('Operation');

        // Accounts Manager
        $accountsManager = User::create([
            'name' => 'David Accounts Manager',
            'email' => 'accountsmanager@travelshravel.com',
            'role' => 'Accounts Manager',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $accountsManager->assignRole('Accounts Manager');

        // Accounts
        $accounts = User::create([
            'name' => 'Lisa Accounts',
            'email' => 'lisa@travelshravel.com',
            'role' => 'Accounts',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $accounts->assignRole('Accounts');

        // Post Sales Manager
        $postSalesManager = User::create([
            'name' => 'Emma Post Sales Manager',
            'email' => 'postsalesmanager@travelshravel.com',
            'role' => 'Post Sales Manager',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $postSalesManager->assignRole('Post Sales Manager');

        // Post Sales
        $postSales = User::create([
            'name' => 'Kevin Post Sales',
            'email' => 'kevin@travelshravel.com',
            'role' => 'Post Sales',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $postSales->assignRole('Post Sales');

        // Delivery Manager
        $deliveryManager = User::create([
            'name' => 'Tom Delivery Manager',
            'email' => 'deliverymanager@travelshravel.com',
            'role' => 'Delivery Manager',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $deliveryManager->assignRole('Delivery Manager');

        // Delivery
        $delivery = User::create([
            'name' => 'Alex Delivery',
            'email' => 'alex@travelshravel.com',
            'role' => 'Delivery',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $delivery->assignRole('Delivery');

        // HR
        $hr = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@travelshravel.com',
            'role' => 'HR',
            'status' => 'Active',
            'password' => Hash::make('password123'),
        ]);
        $hr->assignRole('HR');

        $this->command->info('Users created successfully!');
        $this->command->info('Default password for all users: password123');
    }
}
