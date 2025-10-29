<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Domestic Travel',
                'code' => 'DOM001',
                'description' => 'Complete domestic travel packages including flights, hotels, and local transport',
                'default_price' => 25000.00,
                'is_active' => true,
            ],
            [
                'name' => 'International Travel',
                'code' => 'INT001',
                'description' => 'International travel packages with visa assistance and travel insurance',
                'default_price' => 75000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Honeymoon Packages',
                'code' => 'HNY001',
                'description' => 'Special honeymoon packages with romantic destinations and luxury accommodations',
                'default_price' => 100000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Adventure Tours',
                'code' => 'ADV001',
                'description' => 'Adventure and trekking packages for thrill seekers',
                'default_price' => 35000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pilgrimage Tours',
                'code' => 'PLG001',
                'description' => 'Spiritual and pilgrimage tours to holy places',
                'default_price' => 20000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Beach Holidays',
                'code' => 'BCH001',
                'description' => 'Relaxing beach holidays with water sports activities',
                'default_price' => 40000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Family Packages',
                'code' => 'FAM001',
                'description' => 'Family-friendly packages with kid-friendly activities',
                'default_price' => 50000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Corporate Travel',
                'code' => 'CORP001',
                'description' => 'Business travel solutions with conference facilities',
                'default_price' => 30000.00,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
