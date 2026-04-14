<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'Engine',
                'name'     => 'NGK Iridium Spark Plug',
                'sku'      => 'NGK-IRI-001',
                'brand'    => 'NGK',
                'desc'     => 'Iridium fine wire centre electrode for maximum ignitability. Fits most Japanese & Korean vehicles.',
                'emoji'    => '⚡',
                'price'    => 38.50,
                'stock'    => 120,
                'rating'   => 4.8,
                'reviews'  => 214,
            ],
            [
                'category' => 'Filters',
                'name'     => 'Bosch Oil Filter',
                'sku'      => 'BSH-OIL-002',
                'brand'    => 'Bosch',
                'desc'     => 'High-performance oil filter with anti-drain back valve. Universal fit for most sedans and SUVs.',
                'emoji'    => '🔩',
                'price'    => 18.90,
                'stock'    => 87,
                'rating'   => 4.6,
                'reviews'  => 98,
            ],
            [
                'category' => 'Brakes',
                'name'     => 'Brembo Brake Pads (Front)',
                'sku'      => 'BRM-BRK-003',
                'brand'    => 'Brembo',
                'desc'     => 'OEM-quality ceramic brake pads. Low dust, low noise, superior stopping power.',
                'emoji'    => '🛑',
                'price'    => 145.00,
                'stock'    => 45,
                'rating'   => 4.9,
                'reviews'  => 311,
            ],
            [
                'category' => 'Suspension',
                'name'     => 'KYB Gas Shock Absorber',
                'sku'      => 'KYB-SHK-004',
                'brand'    => 'KYB',
                'desc'     => 'Gas-pressurized shock absorber for improved handling and ride comfort. Fits Proton, Perodua, Toyota.',
                'emoji'    => '🔧',
                'price'    => 210.00,
                'stock'    => 32,
                'rating'   => 4.7,
                'reviews'  => 156,
            ],
            [
                'category' => 'Filters',
                'name'     => 'Denso Air Filter',
                'sku'      => 'DNS-AIR-005',
                'brand'    => 'Denso',
                'desc'     => 'High-flow paper air filter for improved engine breathing and performance.',
                'emoji'    => '💨',
                'price'    => 42.00,
                'stock'    => 63,
                'rating'   => 4.5,
                'reviews'  => 77,
            ],
            [
                'category' => 'Electrical',
                'name'     => 'Osram H4 Headlight Bulb',
                'sku'      => 'OSR-H4-006',
                'brand'    => 'Osram',
                'desc'     => '60/55W halogen headlight bulb. Fits most Malaysian cars including Myvi and Viva.',
                'emoji'    => '💡',
                'price'    => 55.00,
                'stock'    => 200,
                'rating'   => 4.4,
                'reviews'  => 182,
            ],
            [
                'category' => 'Tyres',
                'name'     => 'Michelin Pilot Sport 5 (205/55R16)',
                'sku'      => 'MCH-TYR-007',
                'brand'    => 'Michelin',
                'desc'     => 'Ultra-high performance tyre with exceptional wet and dry grip. Speed rating W.',
                'emoji'    => '🏎️',
                'price'    => 480.00,
                'stock'    => 18,
                'rating'   => 4.9,
                'reviews'  => 423,
            ],
            [
                'category' => 'Suspension',
                'name'     => 'TRW Power Steering Rack',
                'sku'      => 'TRW-STR-008',
                'brand'    => 'TRW',
                'desc'     => 'Hydraulic power steering rack. OEM replacement for Proton Saga, Iriz, and Persona.',
                'emoji'    => '🎮',
                'price'    => 620.00,
                'stock'    => 8,
                'rating'   => 4.6,
                'reviews'  => 44,
            ],
            [
                'category' => 'Body',
                'name'     => 'Bosch Wiper Blade Set',
                'sku'      => 'BSH-WPR-009',
                'brand'    => 'Bosch',
                'desc'     => 'Aerotwin flat blade set. Smear-free wiping in tropical rain. 24"+16" pair.',
                'emoji'    => '🌧️',
                'price'    => 68.00,
                'stock'    => 95,
                'rating'   => 4.3,
                'reviews'  => 128,
            ],
            [
                'category' => 'Electrical',
                'name'     => 'ACDelco Car Battery 65Ah',
                'sku'      => 'ACD-BAT-010',
                'brand'    => 'ACDelco',
                'desc'     => 'Maintenance-free calcium battery. 18-month warranty. Suitable for most 1.3–2.0L cars.',
                'emoji'    => '🔋',
                'price'    => 340.00,
                'stock'    => 22,
                'rating'   => 4.7,
                'reviews'  => 209,
            ],
            [
                'category' => 'Engine',
                'name'     => 'Motul 5100 10W40 Engine Oil 4L',
                'sku'      => 'MTL-OIL-011',
                'brand'    => 'Motul',
                'desc'     => 'Semi-synthetic 4-stroke engine oil. Ideal for high-mileage and performance engines.',
                'emoji'    => '🛢️',
                'price'    => 88.00,
                'stock'    => 76,
                'rating'   => 4.8,
                'reviews'  => 391,
            ],
            [
                'category' => 'Brakes',
                'name'     => 'DBA Drilled Brake Rotor',
                'sku'      => 'DBA-ROT-012',
                'brand'    => 'DBA',
                'desc'     => 'Cross-drilled slotted rotor for superior heat dissipation. Reduces brake fade in aggressive driving.',
                'emoji'    => '⭕',
                'price'    => 275.00,
                'stock'    => 14,
                'rating'   => 4.7,
                'reviews'  => 67,
            ],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();
            if (! $category) {
                continue;
            }

            Product::updateOrCreate(
                ['sku' => $p['sku']],
                [
                    'category_id' => $category->id,
                    'name'        => $p['name'],
                    'slug'        => Str::slug($p['name']),
                    'sku'         => $p['sku'],
                    'brand'       => $p['brand'],
                    'description' => $p['desc'],
                    'emoji'       => $p['emoji'],
                    'price'       => $p['price'],
                    'stock'       => $p['stock'],
                    'rating'      => $p['rating'],
                    'reviews'     => $p['reviews'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
