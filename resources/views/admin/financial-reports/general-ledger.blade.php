@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">General Ledger</h3>
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

                <!-- Filters -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700">Account</label>
                            <select name="account_id" id="account_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Accounts</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_code }} - {{ $account->account_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Report
                            </button>
                        </div>
                    </form>
                </div>

                @if(isset($account))
                <!-- Account Summary -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="text-lg font-medium text-blue-900 mb-2">Account: {{ $account->account_name }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-blue-700">Account Code:</span>
                            <span class="text-blue-900">{{ $account->account_code }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Account Type:</span>
                            <span class="text-blue-900">{{ ucfirst($account->account_type) }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-700">Opening Balance:</span>
                            <span class="text-blue-900">${{ number_format($openingBalance, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- General Ledger Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Entry #
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Debit
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Credit
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ledgerEntries as $entry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $entry['date']->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $entry['entry_number'] }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $entry['description'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    @if($entry['debit'] > 0)
                                    <span class="font-mono font-semibold text-blue-600">
                                        ${{ number_format($entry['debit'], 2) }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    @if($entry['credit'] > 0)
                                    <span class="font-mono font-semibold text-green-600">
                                        ${{ number_format($entry['credit'], 2) }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    <span class="font-mono font-semibold {{ $entry['running_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format($entry['running_balance'], 2) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No transactions found for the selected period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($account) && count($ledgerEntries) > 0)
                <!-- Account Summary Footer -->
                <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-sm font-medium text-gray-600">Total Debits</div>
                            <div class="text-lg font-bold text-blue-900">
                                ${{ number_format($ledgerEntries->sum('debit'), 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-600">Total Credits</div>
                            <div class="text-lg font-bold text-green-900">
                                ${{ number_format($ledgerEntries->sum('credit'), 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-600">Closing Balance</div>
                            <div class="text-lg font-bold {{ $closingBalance >= 0 ? 'text-green-900' : 'text-red-900' }}">
                                ${{ number_format($closingBalance, 2) }}
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