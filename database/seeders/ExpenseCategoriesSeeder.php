<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Personnel', 'description' => 'Salaries, wages, and benefits', 'color' => '#EF4444'],
            ['name' => 'Rehearsal & Practice', 'description' => 'Rehearsal hall rental and practice costs', 'color' => '#3B82F6'],
            ['name' => 'Concert & Events', 'description' => 'Concert venue rental and production costs', 'color' => '#8B5CF6'],
            ['name' => 'Equipment & Instruments', 'description' => 'Musical instruments and equipment costs', 'color' => '#10B981'],
            ['name' => 'Marketing & Promotion', 'description' => 'Advertising, marketing, and promotional costs', 'color' => '#F59E0B'],
            ['name' => 'Office & Administrative', 'description' => 'Office supplies and administrative costs', 'color' => '#6B7280'],
            ['name' => 'Insurance & Legal', 'description' => 'Insurance, legal, and professional services', 'color' => '#EC4899'],
            ['name' => 'Travel & Transportation', 'description' => 'Travel costs for performances and events', 'color' => '#06B6D4'],
            ['name' => 'Recording & Media', 'description' => 'Studio rental and recording costs', 'color' => '#84CC16'],
            ['name' => 'Maintenance & Repairs', 'description' => 'Maintenance and repair costs', 'color' => '#F97316'],
            ['name' => 'Utilities', 'description' => 'Electricity, water, internet, and other utilities', 'color' => '#6366F1'],
            ['name' => 'Other Expenses', 'description' => 'Miscellaneous and other expenses', 'color' => '#94A3B8'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
