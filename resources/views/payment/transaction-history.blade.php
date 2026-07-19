<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction history</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-12">

        @include('message')

        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate tracking-tight">
                    Transaction History
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Overview of your recent sales payments and transaction logs.
                </p>
            </div>
        </div>

        <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl overflow-hidden">

            <div class="block md:hidden divide-y divide-gray-100">
                @forelse($transactions as $payment)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $payment->transaction_no ?? 'No Txn ID' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Sale ID: <span class="font-medium text-gray-700">#{{ $payment->sale_id }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-950">
                                    ৳{{ number_format($payment->amount, 2) }}
                                </p>
                                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider block mt-0.5">
                                    {{ $payment->payment_method }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-dashed border-gray-100">
                            <span class="text-xs text-gray-500">
                                {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : 'N/A' }}
                            </span>

                            @if(in_array(strtolower($payment->payment_status), ['success', 'completed', 'paid']))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                    Success
                                </span>
                            @elseif(strtolower($payment->payment_status) === 'pending')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-gray-500">
                        No transaction history found.
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-50/70">
                        <tr>
                            <th scope="col" class="w-1/4 px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date & Time</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Transaction No</th>
                            <th scope="col" class="w-24 px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sale ID</th>
                            <th scope="col" class="w-28 px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="w-28 px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($transactions as $payment)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($payment->paid_at)
                                        <div class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 tabular-nums">
                                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 tabular-nums">
                                    {{ $payment->transaction_no ?? '—' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    #{{ $payment->sale_id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium uppercase tracking-wide">
                                    {{ $payment->payment_method }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right tabular-nums">
                                    ৳{{ number_format($payment->amount, 2) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    @if(in_array(strtolower($payment->payment_status), ['success', 'completed', 'paid']))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                            Success
                                        </span>
                                    @elseif(strtolower($payment->payment_status) === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    No transaction history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

    </main>

    @include('footer')

</body>
</html>
