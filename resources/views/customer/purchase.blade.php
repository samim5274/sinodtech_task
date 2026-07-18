<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-12">

        @include('message')

        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
    
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Customer Purchase Directory</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Track purchase history, frequency, and lifecycles.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Customers: {{ $customers->count() }}
                </span>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5">Customer Details</th>
                            <th class="px-6 py-3.5 text-center">Total Purchases</th>
                            <th class="px-6 py-3.5 text-center">Purchase Frequency</th>
                            <th class="px-6 py-3.5">Last Purchase Date</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm bg-white">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-slate-100 text-slate-600 font-bold rounded-full flex items-center justify-center border border-slate-200 uppercase text-xs">
                                            {{ substr($customer->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $customer->name }}</div>
                                            <div class="text-xs text-slate-400 font-mono flex items-center gap-2 mt-0.5">
                                                <span>{{ $customer->phone ?? 'No Phone' }}</span>
                                                @if($customer->email)
                                                    <span class="text-slate-300">|</span>
                                                    <span>{{ $customer->email }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center font-bold text-slate-700 font-mono">
                                    {{ number_format($customer->purchase_count ?? 0) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $purchaseCount = $customer->purchase_count ?? 0;
                                        $lastPurchase = $customer->last_purchase_at ? \Carbon\Carbon::parse($customer->last_purchase_at) : null;
                                        
                                        $configDays = 90; 
                                        $isLost = $lastPurchase && $lastPurchase->diffInDays(now()) >= $configDays;
                                    @endphp

                                    @if($isLost)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                            ⚠️ Lost (>{{ $configDays }} Days)
                                        </span>
                                    @elseif($purchaseCount >= 15)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            🔥 Loyal / Frequent
                                        </span>
                                    @elseif($purchaseCount >= 5)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            ⚡ Regular
                                        </span>
                                    @elseif($purchaseCount > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            🌱 Occasional
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100">
                                            ❄️ New / Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if($customer->last_purchase_at)
                                        <div class="text-slate-700 font-medium">
                                            {{ \Carbon\Carbon::parse($customer->last_purchase_at)->format('d M, Y') }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($customer->last_purchase_at)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Never purchased yet</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('customer-purchase-list', $customer->id) }}" class="inline-flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-lg px-3 py-1.5 font-medium text-xs transition-all gap-1.5 shadow-sm">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="text-xs">No customer records found.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </main>

    @include('footer')

</body>
</html>
