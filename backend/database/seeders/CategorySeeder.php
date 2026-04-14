<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Engine',      'icon' => '🔥', 'description' => 'Engine components, spark plugs, belts, and more.'],
            ['name' => 'Brakes',      'icon' => '🛑', 'description' => 'Brake pads, rotors, callipers, and brake fluid.'],
            ['name' => 'Suspension',  'icon' => '🔧', 'description' => 'Shock absorbers, springs, control arms, and steering racks.'],
            ['name' => 'Electrical',  'icon' => '⚡', 'description' => 'Batteries, alternators, headlights, and sensors.'],
            ['name' => 'Body',        'icon' => '🚗', 'description' => 'Wiper blades, mirrors, bumpers, and body panels.'],
            ['name' => 'Filters',     'icon' => '💨', 'description' => 'Oil, air, fuel, and cabin air filters.'],
            ['name' => 'Tyres',       'icon' => '🏎️', 'description' => 'Passenger car, SUV, and performance tyres.'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'        => $cat['name'],
                    'slug'        => Str::slug($cat['name']),
                    'icon'        => $cat['icon'],
                    'description' => $cat['description'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
