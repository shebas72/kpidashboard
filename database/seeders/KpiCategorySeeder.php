<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KpiCategory;

class KpiCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sales Performance',
                'description' => 'KPIs related to sales metrics and revenue generation',
                'color' => '#3B82F6',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Satisfaction',
                'description' => 'Customer experience and satisfaction metrics',
                'color' => '#10B981',
                'is_active' => true,
            ],
            [
                'name' => 'Operational Efficiency',
                'description' => 'Internal operations and process efficiency metrics',
                'color' => '#F59E0B',
                'is_active' => true,
            ],
            [
                'name' => 'Financial Performance',
                'description' => 'Financial metrics and profitability indicators',
                'color' => '#EF4444',
                'is_active' => true,
            ],
            [
                'name' => 'Employee Performance',
                'description' => 'HR and employee productivity metrics',
                'color' => '#8B5CF6',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing & Growth',
                'description' => 'Marketing effectiveness and growth metrics',
                'color' => '#06B6D4',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            KpiCategory::create($category);
        }
    }
}
