<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Payment;
use App\Models\CostComponent;
use App\Models\Operation;
use App\Models\LeadRemark;
use App\Models\LeadHistory;
use App\Models\Document;
use App\Models\Delivery;
use App\Models\Incentive;
use App\Models\Service;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        $destinations = Destination::all();
        $salesUsers = User::whereIn('role', ['Sales', 'Sales Manager'])->get();
        $operationUsers = User::whereIn('role', ['Operation', 'Operation Manager'])->get();
        $accountsUsers = User::whereIn('role', ['Accounts', 'Accounts Manager'])->get();
        $deliveryUsers = User::whereIn('role', ['Delivery', 'Delivery Manager'])->get();

        if ($services->isEmpty() || $destinations->isEmpty() || $salesUsers->isEmpty()) {
            $this->command->warn('Please run ServiceSeeder, DestinationSeeder, and UserSeeder first!');
            return;
        }

        $statuses = ['new', 'contacted', 'follow_up', 'priority', 'booked', 'closed'];
        $customers = [
            ['name' => 'Ramesh Kumar', 'phone' => '9876543210', 'email' => 'ramesh@example.com'],
            ['name' => 'Sita Devi', 'phone' => '9876543211', 'email' => 'sita@example.com'],
            ['name' => 'Amit Patel', 'phone' => '9876543212', 'email' => 'amit@example.com'],
            ['name' => 'Kavita Singh', 'phone' => '9876543213', 'email' => 'kavita@example.com'],
            ['name' => 'Vikram Sharma', 'phone' => '9876543214', 'email' => 'vikram@example.com'],
            ['name' => 'Neha Gupta', 'phone' => '9876543215', 'email' => 'neha@example.com'],
            ['name' => 'Rajesh Mehta', 'phone' => '9876543216', 'email' => 'rajesh@example.com'],
            ['name' => 'Pooja Reddy', 'phone' => '9876543217', 'email' => 'pooja@example.com'],
            ['name' => 'Suresh Iyer', 'phone' => '9876543218', 'email' => 'suresh@example.com'],
            ['name' => 'Anjali Nair', 'phone' => '9876543219', 'email' => 'anjali@example.com'],
        ];

        // Create 30 leads
        for ($i = 0; $i < 30; $i++) {
            $customer = $customers[array_rand($customers)];
            $service = $services->random();
            $destination = $destinations->random();
            $salesUser = $salesUsers->random();
            $status = $statuses[array_rand($statuses)];

            $sellingPrice = rand(20000, 200000);
            $bookedValue = $status === 'booked' ? $sellingPrice * (rand(80, 100) / 100) : null;

            $nameParts = preg_split('/\s+/', $customer['name']);
            $firstName = $nameParts[0] ?? $customer['name'];
            $lastName = null;
            $middleName = null;

            if (count($nameParts) > 1) {
                $lastName = array_pop($nameParts);
                if (!empty($nameParts)) {
                    $firstName = array_shift($nameParts);
                    if (!empty($nameParts)) {
                        $middleName = implode(' ', $nameParts);
                    }
                }
            }

            $lead = Lead::create([
                'service_id' => $service->id,
                'destination_id' => $destination->id,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'primary_phone' => $customer['phone'],
                'email' => $customer['email'],
                'address' => rand(0, 1) ? 'Mumbai, Maharashtra' : 'Delhi, India',
                'travel_date' => Carbon::now()->addDays(rand(30, 180))->format('Y-m-d'),
                'adults' => rand(1, 4),
                'children' => rand(0, 2),
                'infants' => rand(0, 1),
                'assigned_user_id' => $salesUser->id,
                'selling_price' => $sellingPrice,
                'booked_value' => $bookedValue,
                'status' => $status,
            ]);

            // Create lead remarks
            if (rand(0, 1)) {
                LeadRemark::create([
                    'lead_id' => $lead->id,
                    'user_id' => $salesUser->id,
                    'remark' => 'Customer showed interest in ' . $destination->name . '. Follow up required.',
                    'follow_up_date' => Carbon::now()->addDays(rand(1, 7)),
                    'visibility' => rand(0, 1) ? 'public' : 'internal',
                ]);
            }

            // Create payments for booked leads
            if ($status === 'booked' && rand(0, 1)) {
                $paymentMethods = ['cash', 'bank_transfer', 'cheque', 'card', 'online'];
                $paymentStatuses = ['pending', 'partial', 'paid', 'overdue'];

                $totalPaid = 0;
                $numPayments = rand(1, 3);
                $amountPerPayment = $bookedValue / $numPayments;

                for ($j = 0; $j < $numPayments; $j++) {
                    $paymentStatus = $j === $numPayments - 1 ? 'paid' : $paymentStatuses[array_rand($paymentStatuses)];
                    
                    Payment::create([
                        'lead_id' => $lead->id,
                        'amount' => $amountPerPayment,
                        'method' => $paymentMethods[array_rand($paymentMethods)],
                        'paid_on' => Carbon::now()->subDays(rand(0, 30)),
                        'due_date' => $paymentStatus === 'pending' ? Carbon::now()->addDays(rand(1, 30)) : null,
                        'status' => $paymentStatus,
                        'notes' => 'Payment installment ' . ($j + 1) . ' of ' . $numPayments,
                    ]);

                    if ($paymentStatus === 'paid') {
                        $totalPaid += $amountPerPayment;
                    }
                }
            }

            // Create cost components for booked leads
            if ($status === 'booked' && rand(0, 1)) {
                $costTypes = ['hotel', 'transport', 'visa', 'insurance', 'meal', 'guide', 'other'];
                $numCosts = rand(2, 5);
                $costPerItem = ($sellingPrice * 0.6) / $numCosts; // Assume 60% of selling price is cost

                for ($j = 0; $j < $numCosts; $j++) {
                    $operationUser = $operationUsers->random();
                    CostComponent::create([
                        'lead_id' => $lead->id,
                        'type' => $costTypes[array_rand($costTypes)],
                        'description' => ucfirst($costTypes[array_rand($costTypes)]) . ' cost for ' . $destination->name,
                        'amount' => $costPerItem + rand(-5000, 5000),
                        'entered_by' => $operationUser->id,
                    ]);
                }
            }

            // Create operation record for booked leads
            if ($status === 'booked' && rand(0, 1)) {
                $lead->refresh(); // Refresh to get cost components
                $totalCost = $lead->costComponents->sum('amount');
                $nettCost = $totalCost > 0 ? $totalCost : $sellingPrice * 0.65;
                $profit = $sellingPrice - $nettCost;
                $needsApproval = $profit < 0;

                Operation::create([
                    'lead_id' => $lead->id,
                    'operation_status' => rand(0, 1) ? 'in_progress' : 'completed',
                    'nett_cost' => $nettCost,
                    'admin_approval_required' => $needsApproval,
                    'approval_reason' => $needsApproval ? 'Nett cost exceeds selling price. Profit: ' . number_format($profit, 2) : null,
                    'approval_requested_by' => $needsApproval ? $operationUsers->random()->id : null,
                    'approval_requested_at' => $needsApproval ? Carbon::now()->subDays(rand(1, 5)) : null,
                    'internal_notes' => 'Operation notes for ' . $destination->name . ' package.',
                ]);
            }

            // Create documents for booked leads
            if ($status === 'booked' && rand(0, 1)) {
                $documentTypes = ['Passport', 'Visa', 'Ticket', 'Voucher', 'Invoice', 'Insurance'];
                $documentStatuses = ['not_received', 'received', 'verified', 'rejected'];

                $numDocs = rand(2, 4);
                for ($j = 0; $j < $numDocs; $j++) {
                    $type = $documentTypes[array_rand($documentTypes)];
                    $statusValue = $documentStatuses[array_rand($documentStatuses)];
                    $receivedBy = null;
                    $receivedAt = null;
                    $verifiedBy = null;
                    $verifiedAt = null;

                    if (in_array($statusValue, ['received', 'verified'], true)) {
                        $receivedBy = $salesUser->id;
                        $receivedAt = Carbon::now()->subDays(rand(1, 5));
                    }

                    if ($statusValue === 'verified') {
                        $verifiedBy = $accountsUsers->isNotEmpty() ? $accountsUsers->random()->id : null;
                        $verifiedAt = Carbon::now()->subDays(rand(0, 2));
                    }

                    Document::create([
                        'lead_id' => $lead->id,
                        'uploaded_by' => $salesUser->id,
                        'type' => $type,
                        'status' => $statusValue,
                        'notes' => 'Checklist item for ' . strtolower($type),
                        'received_by' => $receivedBy,
                        'received_at' => $receivedAt,
                        'verified_by' => $verifiedBy,
                        'verified_at' => $verifiedAt,
                    ]);
                }
            }

            // Create delivery for booked leads
            if ($status === 'booked' && rand(0, 1)) {
                $deliveryStatuses = ['pending', 'in_process', 'delivered', 'failed'];
                Delivery::create([
                    'lead_id' => $lead->id,
                    'assigned_to' => $deliveryUsers->random()->id,
                    'status' => $deliveryStatuses[array_rand($deliveryStatuses)],
                    'courier_id' => rand(0, 1) ? 'COURIER' . rand(1000, 9999) : null,
                    'tracking_info' => rand(0, 1) ? 'Package dispatched and in transit' : null,
                    'expected_delivery_date' => Carbon::now()->addDays(rand(1, 14)),
                    'actual_delivery_date' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 5)) : null,
                    'delivery_notes' => 'Delivery scheduled for ' . $destination->name,
                ]);
            }

            // Create incentives for booked leads with profit
            if ($status === 'booked' && rand(0, 1)) {
                $lead->refresh(); // Refresh to get operation
                $operation = $lead->operation;
                $profit = $operation ? ($sellingPrice - $operation->nett_cost) : ($sellingPrice * 0.3);

                if ($profit > 1000) {
                    $rule = \App\Models\IncentiveRule::where('active', true)->first();
                    if ($rule) {
                        $incentiveAmount = $rule->calculateIncentive($profit);
                        
                        if ($incentiveAmount > 0) {
                            Incentive::create([
                                'lead_id' => $lead->id,
                                'salesperson_id' => $salesUser->id,
                                'profit_amount' => $profit,
                                'incentive_amount' => $incentiveAmount,
                                'incentive_rule_id' => $rule->id,
                                'status' => rand(0, 1) ? 'pending' : 'approved',
                                'approved_by' => rand(0, 1) ? User::where('role', 'Admin')->first()->id : null,
                                'approved_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                                'notes' => 'Incentive calculated automatically',
                            ]);
                        }
                    }
                }
            }
        }

        $this->command->info('Leads and related data created successfully!');
        $this->command->info('Created: 30 leads with payments, costs, operations, documents, deliveries, and incentives');
    }
}
