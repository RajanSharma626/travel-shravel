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
        // Helper to create user with details
        $createUser = function ($name, $email, $role, $dept, $designation) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'user_id' => strtolower(str_replace(' ', '', $name)) . '001', // Simple ID generation
                    'role' => $role,
                    'department' => $dept,
                    'designation' => $designation,
                    'employment_status' => 'Permanent',
                    'employment_type' => 'Full Time',
                    'doj' => now(),
                    'password' => 'password123', // Will be hashed by mutator/cast
                    'status' => 'Active',
                ]
            );

            // Create related records (placeholders for now)
            $user->empBasicInfo()->create([
                'present_address' => '123 Main St, City',
                'emergency_contact' => '9876543210'
            ]);
            
            $user->incentivePerformance()->create([
                'incentive_eligibility' => true,
                'incentive_type' => 'fixed',
                'monthly_target' => '100000'
            ]);

            $user->statutoryPayrollDetails()->create([
                'salary_structure' => 'CTC',
                'bank_name' => 'Demo Bank'
            ]);

            $user->exitClearance()->create([]);
            
            // Assign role
            $user->assignRole($role);
            return $user;
        };

        // Admin
        $createUser('Admin User', 'admin@travelshravel.com', 'Admin', 'Management', 'Administrator');

        // Sales Manager
        $createUser('John Sales Manager', 'salesmanager@travelshravel.com', 'Sales Manager', 'Sales', 'Sales Manager');

        // Sales Persons
        $createUser('Priya Sharma', 'priya@travelshravel.com', 'Sales', 'Sales', 'Sales Executive');
        $createUser('Raj Kumar', 'raj@travelshravel.com', 'Sales', 'Sales', 'Sales Executive');
        $createUser('Anita Patel', 'anita@travelshravel.com', 'Sales', 'Sales', 'Sales Executive');

        // Operation Manager
        $createUser('Mike Operations Manager', 'opsmanager@travelshravel.com', 'Operation Manager', 'Operations', 'Operations Manager');

        // Operation
        $createUser('Sarah Operations', 'sarah@travelshravel.com', 'Operation', 'Operations', 'Operations Executive');

        // Accounts Manager
        $createUser('David Accounts Manager', 'accountsmanager@travelshravel.com', 'Accounts Manager', 'Accounts', 'Accounts Manager');

        // Accounts
        $createUser('Lisa Accounts', 'lisa@travelshravel.com', 'Accounts', 'Accounts', 'Accounts Executive');

        // Post Sales Manager
        $createUser('Emma Post Sales Manager', 'postsalesmanager@travelshravel.com', 'Post Sales Manager', 'Post Sales', 'Post Sales Manager');

        // Post Sales
        $createUser('Kevin Post Sales', 'kevin@travelshravel.com', 'Post Sales', 'Post Sales', 'Post Sales Executive');

        // Delivery Manager
        $createUser('Tom Delivery Manager', 'deliverymanager@travelshravel.com', 'Delivery Manager', 'Delivery', 'Delivery Manager');

        // Delivery
        $createUser('Alex Delivery', 'alex@travelshravel.com', 'Delivery', 'Delivery', 'Delivery Executive');

        // HR
        $createUser('HR Manager', 'hr@travelshravel.com', 'HR', 'HR', 'HR Manager');

        $this->command->info('Users and profiles created successfully!');
        $this->command->info('Default password for all users: password123');
    }
}
