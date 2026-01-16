<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Destination;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some destinations and locations if they exist
        $destinations = Destination::with('locations')->get();

        if ($destinations->isEmpty()) {
            $this->command->info('No destinations found. Please seed destinations first.');
            return;
        }

        $hotels = [
            [
                'name' => 'Grand Palace Hotel',
                'contact_no_1' => '+91 9876543210',
                'contact_no_2' => '+91 9876543211',
                'address' => '123 Main Street, Downtown Area',
                'country' => 'India',
                'is_active' => true,
            ],
            [
                'name' => 'Sunset Beach Resort',
                'contact_no_1' => '+66 2 123 4567',
                'contact_no_2' => '+66 2 123 4568',
                'address' => '456 Beach Road, Coastal Area',
                'country' => 'Thailand',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain View Lodge',
                'contact_no_1' => '+977 1 234 5678',
                'contact_no_2' => null,
                'address' => '789 Hill Station Road, Mountain Region',
                'country' => 'Nepal',
                'is_active' => true,
            ],
            [
                'name' => 'City Center Inn',
                'contact_no_1' => '+91 8765432109',
                'contact_no_2' => '+91 8765432108',
                'address' => '321 Business District, City Center',
                'country' => 'India',
                'is_active' => true,
            ],
            [
                'name' => 'Heritage Palace',
                'contact_no_1' => '+91 7654321098',
                'contact_no_2' => null,
                'address' => '654 Heritage Street, Old Town',
                'country' => 'India',
                'is_active' => false,
            ],
        ];

        foreach ($hotels as $hotelData) {
            // Randomly assign a destination and location if available
            $destination = $destinations->random();
            $location = $destination->locations->isNotEmpty() ? $destination->locations->random() : null;

            Hotel::create([
                'name' => $hotelData['name'],
                'contact_no_1' => $hotelData['contact_no_1'],
                'contact_no_2' => $hotelData['contact_no_2'],
                'address' => $hotelData['address'],
                'country' => $hotelData['country'],
                'destination_id' => $destination->id,
                'location_id' => $location?->id,
                'is_active' => $hotelData['is_active'],
            ]);
        }

        $this->command->info('Hotels seeded successfully!');
    }
}
