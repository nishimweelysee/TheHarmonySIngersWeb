@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Balance Sheet</h3>
                            <p class="mt-1 text-sm text-gray-600">As of {{ $date->format('F d, Y') }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.financial-reports.export-balance-sheet', ['date' => $date->format('Y-m-d')]) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Export CSV
                            </a>
                            <a href="{{ route('admin.financial-reports.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Back to Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="GET" class="flex items-center space-x-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">As of Date</label>
                            <input type="date" name="date" id="date"
                                value="{{ $date->format('Y-m-d') }}"
                                class="mt-1 block border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                        <div class="text-sm font-medium text-green-600">Total Assets</div>
                        <div class="text-2xl font-bold text-green-900">${{ $balanceSheet['totals']['formatted_totals']['total_assets'] }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-red-600">Total Liabilities</div>
                        <div class="text-2xl font-bold text-red-900">${{ $balanceSheet['totals']['formatted_totals']['total_liabilities'] }}</div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-blue-600">Total Equity</div>
                        <div class="text-2xl font-bold text-blue-900">${{ $balanceSheet['totals']['formatted_totals']['total_equity'] }}</div>
                    </div>
                </div>

                <!-- Balance Sheet Sections -->
                <div class="space-y-8">
                    <!-- Assets Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">ASSETS</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Account Name
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Balance
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($balanceSheet['assets'] as $asset)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $asset['account_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="font-mono font-semibold {{ $asset['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                ${{ $asset['formatted_balance'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            TOTAL ASSETS
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            <span class="font-mono">${{ $balanceSheet['totals']['formatted_totals']['total_assets'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Liabilities Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">LIABILITIES</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Account Name
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Balance
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($balanceSheet['liabilities'] as $liability)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $liability['account_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="font-mono font-semibold {{ $liability['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                ${{ $liability['formatted_balance'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            TOTAL LIABILITIES
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            <span class="font-mono">${{ $balanceSheet['totals']['formatted_totals']['total_liabilities'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Equity Section -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">EQUITY</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Account Name
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Balance
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($balanceSheet['equity'] as $equity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $equity['account_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="font-mono font-semibold {{ $equity['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                ${{ $equity['formatted_balance'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            TOTAL EQUITY
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            <span class="font-mono">${{ $balanceSheet['totals']['formatted_totals']['total_equity'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Balance Check -->
                @php
                $totalAssets = $balanceSheet['totals']['total_assets'];
                $totalLiabilities = $balanceSheet['totals']['total_liabilities'];
                $totalEquity = $balanceSheet['totals']['total_equity'];
                $isBalanced = abs(($totalAssets - $totalLiabilities - $totalEquity)) < 0.01;
                    @endphp

                    @if($isBalanced)
                    <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Balance Sheet Balanced</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Assets = Liabilities + Equity. The balance sheet is balanced.</p>
                            </div>
                        </div>
                    </div>
            </div>
            @else
            <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Balance Sheet Unbalanced</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Assets ≠ Liabilities + Equity. There may be an error in the accounting records.</p>
                            <p class="mt-1">Difference: ${{ number_format($totalAssets - $totalLiabilities - $totalEquity, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection