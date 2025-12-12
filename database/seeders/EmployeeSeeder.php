<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            // Admin
            [
                'employee_id' => 'EMP000001',
                'name' => 'Admin User',
                'dob' => Carbon::parse('1985-01-15'),
                'department' => 'Admin',
                'designation' => 'Administrator',
                'reporting_manager' => null,
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2020-01-01'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43210',
                'work_email' => 'admin@travelshravel.com',
                'crm_access_user_id' => 'admin1',
            ],

            // Sales Manager
            [
                'employee_id' => 'EMP000002',
                'name' => 'John Sales Manager',
                'dob' => Carbon::parse('1988-03-20'),
                'department' => 'Sales Manager',
                'designation' => 'Sales Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-02-15'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43211',
                'work_email' => 'salesmanager@travelshravel.com',
                'crm_access_user_id' => 'salesmanager1',
            ],

            // Sales Persons
            [
                'employee_id' => 'EMP000003',
                'name' => 'Priya Sharma',
                'dob' => Carbon::parse('1992-05-10'),
                'department' => 'Sales',
                'designation' => 'Sales Executive',
                'reporting_manager' => 'John Sales Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-06-01'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43212',
                'work_email' => 'priya@travelshravel.com',
                'crm_access_user_id' => 'sales1',
            ],
            [
                'employee_id' => 'EMP000004',
                'name' => 'Raj Kumar',
                'dob' => Carbon::parse('1990-07-25'),
                'department' => 'Sales',
                'designation' => 'Sales Executive',
                'reporting_manager' => 'John Sales Manager',
                'branch_location' => 'Delhi',
                'doj' => Carbon::parse('2022-07-15'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43213',
                'work_email' => 'raj@travelshravel.com',
                'crm_access_user_id' => 'sales2',
            ],
            [
                'employee_id' => 'EMP000005',
                'name' => 'Anita Patel',
                'dob' => Carbon::parse('1993-09-18'),
                'department' => 'Sales',
                'designation' => 'Sales Executive',
                'reporting_manager' => 'John Sales Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-08-20'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43214',
                'work_email' => 'anita@travelshravel.com',
                'crm_access_user_id' => 'sales3',
            ],

            // Operation Manager
            [
                'employee_id' => 'EMP000006',
                'name' => 'Mike Operations Manager',
                'dob' => Carbon::parse('1987-11-12'),
                'department' => 'Operation Manager',
                'designation' => 'Operations Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-03-10'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43215',
                'work_email' => 'opsmanager@travelshravel.com',
                'crm_access_user_id' => 'opsmanager1',
            ],

            // Operation
            [
                'employee_id' => 'EMP000007',
                'name' => 'Sarah Operations',
                'dob' => Carbon::parse('1991-04-05'),
                'department' => 'Operation',
                'designation' => 'Operations Executive',
                'reporting_manager' => 'Mike Operations Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-09-01'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43216',
                'work_email' => 'sarah@travelshravel.com',
                'crm_access_user_id' => 'ops1',
            ],

            // Accounts Manager
            [
                'employee_id' => 'EMP000008',
                'name' => 'David Accounts Manager',
                'dob' => Carbon::parse('1986-06-30'),
                'department' => 'Accounts Manager',
                'designation' => 'Accounts Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-04-15'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43217',
                'work_email' => 'accountsmanager@travelshravel.com',
                'crm_access_user_id' => 'accountsmanager1',
            ],

            // Accounts
            [
                'employee_id' => 'EMP000009',
                'name' => 'Lisa Accounts',
                'dob' => Carbon::parse('1994-08-22'),
                'department' => 'Accounts',
                'designation' => 'Accounts Executive',
                'reporting_manager' => 'David Accounts Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-10-05'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43218',
                'work_email' => 'lisa@travelshravel.com',
                'crm_access_user_id' => 'accounts1',
            ],

            // Post Sales Manager
            [
                'employee_id' => 'EMP000010',
                'name' => 'Emma Post Sales Manager',
                'dob' => Carbon::parse('1989-10-08'),
                'department' => 'Post Sales Manager',
                'designation' => 'Post Sales Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-05-20'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43219',
                'work_email' => 'postsalesmanager@travelshravel.com',
                'crm_access_user_id' => 'postsalesmanager1',
            ],

            // Post Sales
            [
                'employee_id' => 'EMP000011',
                'name' => 'Kevin Post Sales',
                'dob' => Carbon::parse('1992-12-14'),
                'department' => 'Post Sales',
                'designation' => 'Post Sales Executive',
                'reporting_manager' => 'Emma Post Sales Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-11-10'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43220',
                'work_email' => 'kevin@travelshravel.com',
                'crm_access_user_id' => 'ps1',
            ],

            // Delivery Manager
            [
                'employee_id' => 'EMP000012',
                'name' => 'Tom Delivery Manager',
                'dob' => Carbon::parse('1988-02-28'),
                'department' => 'Delivery Manager',
                'designation' => 'Delivery Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-06-05'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43221',
                'work_email' => 'deliverymanager@travelshravel.com',
                'crm_access_user_id' => 'deliverymanager1',
            ],

            // Delivery
            [
                'employee_id' => 'EMP000013',
                'name' => 'Alex Delivery',
                'dob' => Carbon::parse('1993-06-16'),
                'department' => 'Delivery',
                'designation' => 'Delivery Executive',
                'reporting_manager' => 'Tom Delivery Manager',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2022-12-01'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43222',
                'work_email' => 'alex@travelshravel.com',
                'crm_access_user_id' => 'delivery1',
            ],

            // HR
            [
                'employee_id' => 'EMP000014',
                'name' => 'HR Manager',
                'dob' => Carbon::parse('1987-09-03'),
                'department' => 'HR',
                'designation' => 'HR Manager',
                'reporting_manager' => 'Admin User',
                'branch_location' => 'Mumbai',
                'doj' => Carbon::parse('2021-01-15'),
                'dol' => null,
                'emergency_contact' => '+91 98765 43223',
                'work_email' => 'hr@travelshravel.com',
                'crm_access_user_id' => 'hr1',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        $this->command->info('Employees created successfully!');
        $this->command->info('Total employees created: ' . count($employees));
    }
}
