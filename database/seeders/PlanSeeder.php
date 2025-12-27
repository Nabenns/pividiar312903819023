<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::firstOrCreate(
            ['slug' => 'the-contrarian'],
            [
                'name' => 'The Contrarian',
                'price' => 10000000, // 10 Million
                'billing_cycle' => 'lifetime',
                'role_name' => 'premium',
                'features' => [
                    'Access to The Contrarian Course',
                    'Premium Community Access',
                    'Direct Mentorship',
                    'Lifetime Updates',
                ],
                'is_active' => true,
                'is_popular' => true,
            ]
        );
    }
}
