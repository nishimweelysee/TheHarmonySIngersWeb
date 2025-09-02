<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class ChartOfAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // Assets
            ['account_code' => '1000', 'account_name' => 'Cash and Cash Equivalents', 'account_type' => 'asset', 'account_category' => 'current_assets', 'description' => 'Cash on hand and in bank accounts'],
            ['account_code' => '1100', 'account_name' => 'Accounts Receivable', 'account_type' => 'asset', 'account_category' => 'current_assets', 'description' => 'Amounts owed by customers and sponsors'],
            ['account_code' => '1200', 'account_name' => 'Prepaid Expenses', 'account_type' => 'asset', 'account_category' => 'current_assets', 'description' => 'Expenses paid in advance'],
            ['account_code' => '1500', 'account_name' => 'Equipment', 'account_type' => 'asset', 'account_category' => 'fixed_assets', 'description' => 'Musical instruments and equipment'],
            ['account_code' => '1600', 'account_name' => 'Furniture and Fixtures', 'account_type' => 'asset', 'account_category' => 'fixed_assets', 'description' => 'Office furniture and fixtures'],
            ['account_code' => '1700', 'account_name' => 'Buildings', 'account_type' => 'asset', 'account_category' => 'fixed_assets', 'description' => 'Rehearsal halls and office buildings'],

            // Liabilities
            ['account_code' => '2000', 'account_name' => 'Accounts Payable', 'account_type' => 'liability', 'account_category' => 'current_liabilities', 'description' => 'Amounts owed to suppliers and vendors'],
            ['account_code' => '2100', 'account_name' => 'Accrued Expenses', 'account_type' => 'liability', 'account_category' => 'current_liabilities', 'description' => 'Expenses incurred but not yet paid'],
            ['account_code' => '2200', 'account_name' => 'Deferred Revenue', 'account_type' => 'liability', 'account_category' => 'current_liabilities', 'description' => 'Revenue received in advance'],
            ['account_code' => '2500', 'account_name' => 'Long-term Loans', 'account_type' => 'liability', 'account_category' => 'long_term_liabilities', 'description' => 'Long-term bank loans and mortgages'],

            // Equity
            ['account_code' => '3000', 'account_name' => 'Retained Earnings', 'account_type' => 'equity', 'account_category' => 'equity', 'description' => 'Accumulated net income over time'],
            ['account_code' => '3100', 'account_name' => 'Member Contributions', 'account_type' => 'equity', 'account_category' => 'equity', 'description' => 'Member contributions and dues'],
            ['account_code' => '3200', 'account_name' => 'Sponsor Contributions', 'account_type' => 'equity', 'account_category' => 'equity', 'description' => 'Sponsor and corporate contributions'],

            // Revenue
            ['account_code' => '4000', 'account_name' => 'Concert Revenue', 'account_type' => 'revenue', 'account_category' => 'operating_revenue', 'description' => 'Revenue from concert performances'],
            ['account_code' => '4100', 'account_name' => 'Recording Revenue', 'account_type' => 'revenue', 'account_category' => 'operating_revenue', 'description' => 'Revenue from album sales and recordings'],
            ['account_code' => '4200', 'account_name' => 'Workshop Revenue', 'account_type' => 'revenue', 'account_category' => 'operating_revenue', 'description' => 'Revenue from workshops and training'],
            ['account_code' => '4300', 'account_name' => 'Donations', 'account_type' => 'revenue', 'account_category' => 'operating_revenue', 'description' => 'General donations and gifts'],
            ['account_code' => '4400', 'account_name' => 'Grant Revenue', 'account_type' => 'revenue', 'account_category' => 'operating_revenue', 'description' => 'Government and foundation grants'],
            ['account_code' => '4500', 'account_name' => 'Interest Income', 'account_type' => 'revenue', 'account_category' => 'other_revenue', 'description' => 'Interest earned on investments'],

            // Expenses
            ['account_code' => '5000', 'account_name' => 'Personnel Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Salaries, wages, and benefits'],
            ['account_code' => '5100', 'account_name' => 'Rehearsal Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Rehearsal hall rental and related costs'],
            ['account_code' => '5200', 'account_name' => 'Concert Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Concert venue rental and production costs'],
            ['account_code' => '5300', 'account_name' => 'Equipment Maintenance', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Maintenance and repair of musical equipment'],
            ['account_code' => '5400', 'account_name' => 'Marketing and Promotion', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Advertising, marketing, and promotional costs'],
            ['account_code' => '5500', 'account_name' => 'Office Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Office supplies and administrative costs'],
            ['account_code' => '5600', 'account_name' => 'Insurance', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Liability and property insurance'],
            ['account_code' => '5700', 'account_name' => 'Professional Services', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Legal, accounting, and consulting fees'],
            ['account_code' => '5800', 'account_name' => 'Travel Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Travel costs for performances and events'],
            ['account_code' => '5900', 'account_name' => 'Recording Expenses', 'account_type' => 'expense', 'account_category' => 'operating_expenses', 'description' => 'Studio rental and recording costs'],
            ['account_code' => '6000', 'account_name' => 'Depreciation', 'account_type' => 'expense', 'account_category' => 'other_expenses', 'description' => 'Depreciation of fixed assets'],
            ['account_code' => '6100', 'account_name' => 'Interest Expense', 'account_type' => 'expense', 'account_category' => 'other_expenses', 'description' => 'Interest on loans and credit'],
            ['account_code' => '6200', 'account_name' => 'Bank Charges', 'account_type' => 'expense', 'account_category' => 'other_expenses', 'description' => 'Bank fees and service charges'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::create($account);
        }
    }
}
