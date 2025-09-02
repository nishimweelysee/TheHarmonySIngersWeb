@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Cash Flow Statement</h3>
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
                <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-blue-600">Opening Balance</div>
                        <div class="text-xl font-bold text-blue-900">${{ number_format($openingBalance, 2) }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-green-600">Total Inflow</div>
                        <div class="text-xl font-bold text-green-900">${{ number_format($totalInflow, 2) }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-red-600">Total Outflow</div>
                        <div class="text-xl font-bold text-red-900">${{ number_format($totalOutflow, 2) }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-purple-600">Closing Balance</div>
                        <div class="text-xl font-bold text-purple-900">${{ number_format($closingBalance, 2) }}</div>
                    </div>
                </div>

                <!-- Cash Flow Details -->
                <div class="mb-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Cash Flow Details</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Inflow
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Outflow
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Running Balance
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cashFlow as $flow)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $flow['date']->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $flow['description'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $flow['account'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        @if($flow['inflow'] > 0)
                                        <span class="font-mono font-semibold text-green-600">
                                            ${{ number_format($flow['inflow'], 2) }}
                                        </span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        @if($flow['outflow'] > 0)
                                        <span class="font-mono font-semibold text-red-600">
                                            ${{ number_format($flow['outflow'], 2) }}
                                        </span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        <span class="font-mono font-semibold {{ $flow['running_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            ${{ number_format($flow['running_balance'], 2) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cash Flow Summary -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Cash Flow Summary</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="text-md font-medium text-gray-700 mb-2">Cash Inflows</h5>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>• Donations and contributions</li>
                                <li>• Concert revenue</li>
                                <li>• Sponsor contributions</li>
                                <li>• Interest income</li>
                                <li>• Other revenue</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="text-md font-medium text-gray-700 mb-2">Cash Outflows</h5>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>• Operating expenses</li>
                                <li>• Personnel costs</li>
                                <li>• Equipment and supplies</li>
                                <li>• Venue and rehearsal costs</li>
                                <li>• Administrative expenses</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection