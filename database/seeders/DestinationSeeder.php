<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            // Domestic
            [
                'name' => 'Goa',
                'country' => 'India',
                'state' => 'Goa',
                'city' => 'Panaji',
                'description' => 'Beautiful beaches, vibrant nightlife, and Portuguese heritage',
                'is_active' => true,
            ],
            [
                'name' => 'Kerala',
                'country' => 'India',
                'state' => 'Kerala',
                'city' => 'Kochi',
                'description' => 'Backwaters, hill stations, and Ayurvedic wellness',
                'is_active' => true,
            ],
            [
                'name' => 'Manali',
                'country' => 'India',
                'state' => 'Himachal Pradesh',
                'city' => 'Manali',
                'description' => 'Snow-capped mountains, adventure sports, and scenic beauty',
                'is_active' => true,
            ],
            [
                'name' => 'Rajasthan',
                'country' => 'India',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'description' => 'Royal palaces, deserts, and rich cultural heritage',
                'is_active' => true,
            ],
            [
                'name' => 'Kashmir',
                'country' => 'India',
                'state' => 'Jammu and Kashmir',
                'city' => 'Srinagar',
                'description' => 'Paradise on earth with lakes, gardens, and snow',
                'is_active' => true,
            ],
            [
                'name' => 'Darjeeling',
                'country' => 'India',
                'state' => 'West Bengal',
                'city' => 'Darjeeling',
                'description' => 'Tea gardens, toy train, and mountain views',
                'is_active' => true,
            ],
            // International
            [
                'name' => 'Dubai',
                'country' => 'UAE',
                'state' => null,
                'city' => 'Dubai',
                'description' => 'Ultra-modern city with luxury shopping, skyscrapers, and desert safaris',
                'is_active' => true,
            ],
            [
                'name' => 'Bangkok',
                'country' => 'Thailand',
                'state' => null,
                'city' => 'Bangkok',
                'description' => 'Bustling city with temples, markets, and vibrant nightlife',
                'is_active' => true,
            ],
            [
                'name' => 'Singapore',
                'country' => 'Singapore',
                'state' => null,
                'city' => 'Singapore',
                'description' => 'Modern city-state with gardens, shopping, and diverse cuisine',
                'is_active' => true,
            ],
            [
                'name' => 'Maldives',
                'country' => 'Maldives',
                'state' => null,
                'city' => 'Male',
                'description' => 'Tropical paradise with overwater bungalows and crystal-clear waters',
                'is_active' => true,
            ],
            [
                'name' => 'Bali',
                'country' => 'Indonesia',
                'state' => null,
                'city' => 'Denpasar',
                'description' => 'Island paradise with temples, beaches, and rice terraces',
                'is_active' => true,
            ],
            [
                'name' => 'Switzerland',
                'country' => 'Switzerland',
                'state' => null,
                'city' => 'Zurich',
                'description' => 'Alpine beauty, chocolate, and pristine lakes',
                'is_active' => true,
            ],
            [
                'name' => 'Paris',
                'country' => 'France',
                'state' => null,
                'city' => 'Paris',
                'description' => 'City of lights, Eiffel Tower, and world-class museums',
                'is_active' => true,
            ],
            [
                'name' => 'London',
                'country' => 'United Kingdom',
                'state' => null,
                'city' => 'London',
                'description' => 'Royal palaces, historical landmarks, and vibrant culture',
                'is_active' => true,
            ],
            [
                'name' => 'Tokyo',
                'country' => 'Japan',
                'state' => null,
                'city' => 'Tokyo',
                'description' => 'Modern metropolis blending tradition and technology',
                'is_active' => true,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
