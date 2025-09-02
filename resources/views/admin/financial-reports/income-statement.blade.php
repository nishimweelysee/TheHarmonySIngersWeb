@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Income Statement</h3>
                            <p class="mt-1 text-sm text-gray-600">For the period {{ $startDate->format('F d, Y') }} to {{ $endDate->format('F d, Y') }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.financial-reports.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Back to Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ $startDate->format('Y-m-d') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ $endDate->format('Y-m-d') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Report
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Summary Stats -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-green-600">Total Revenue</div>
                        <div class="text-2xl font-bold text-green-900">${{ $incomeStatement['totals']['formatted_totals']['total_revenue'] }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-red-600">Total Expenses</div>
                        <div class="text-2xl font-bold text-red-900">${{ $incomeStatement['totals']['formatted_totals']['total_expenses'] }}</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-blue-600">Net Income</div>
                        <div class="text-2xl font-bold {{ $incomeStatement['totals']['net_income'] >= 0 ? 'text-green-900' : 'text-red-900' }}">
                            ${{ $incomeStatement['totals']['formatted_totals']['net_income'] }}
                        </div>
                    </div>
                </div>

                <!-- Income Statement Sections -->
                <div class="space-y-8">
                    <!-- Revenue Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">REVENUE</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Account Name
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($incomeStatement['revenue'] as $revenue)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $revenue['account_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="font-mono font-semibold text-green-600">
                                                ${{ $revenue['formatted_amount'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            TOTAL REVENUE
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            <span class="font-mono text-green-600">${{ $incomeStatement['totals']['formatted_totals']['total_revenue'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Expenses Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">EXPENSES</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Account Name
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($incomeStatement['expenses'] as $expense)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $expense['account_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="font-mono font-semibold text-red-600">
                                                ${{ $expense['formatted_amount'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            TOTAL EXPENSES
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            <span class="font-mono text-red-600">${{ $incomeStatement['totals']['formatted_totals']['total_expenses'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Net Income Section -->
                    <div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <div class="text-center">
                                <h4 class="text-xl font-bold text-blue-900 mb-2">NET INCOME</h4>
                                <div class="text-3xl font-bold {{ $incomeStatement['totals']['net_income'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ $incomeStatement['totals']['formatted_totals']['net_income'] }}
                                </div>
                                <p class="text-sm text-blue-700 mt-2">
                                    @if($incomeStatement['totals']['net_income'] >= 0)
                                    The organization generated a profit during this period.
                                    @else
                                    The organization had a net loss during this period.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection