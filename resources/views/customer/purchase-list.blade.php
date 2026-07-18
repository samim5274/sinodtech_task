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
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Customer Purchase Hisotry</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Track purchase history, frequency, and lifecycles.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Orders: {{ $customerOrders->count() }}
                </span>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5">Invoice Details</th>
                            <th class="px-6 py-3.5">Purchase Date</th>
                            <th class="px-6 py-3.5 text-right">Subtotal</th>
                            <th class="px-6 py-3.5 text-right">Discount / Tax</th>
                            <th class="px-6 py-3.5 text-right">Grand Total</th>
                            <th class="px-6 py-3.5 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm bg-white">
                        @forelse($customerOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </span>
                                        <span class="font-mono font-bold text-slate-800 tracking-wide">
                                            #{{ $order->invoice_no }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-slate-700 font-medium">
                                        {{ \Carbon\Carbon::parse($order->sale_date)->format('d M, Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($order->sale_date)->format('h:i A') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right text-slate-600 font-medium font-mono">
                                    ৳{{ number_format($order->subtotal, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right text-xs">
                                    <div class="text-rose-600 font-mono">-৳{{ number_format($order->discount ?? 0, 2) }}</div>
                                    <div class="text-emerald-600 font-mono mt-0.5">+৳{{ number_format($order->tax ?? 0, 2) }}</div>
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-slate-900 font-mono text-base">
                                    ৳{{ number_format($order->grand_total, 2) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('sales.show', $order->invoice_no) }}" class="inline-flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-lg px-3 py-1.5 font-medium text-xs transition-all gap-1.5 shadow-sm">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Bill
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4m8 8l4-4-4-4"></path>
                                        </svg>
                                        <span class="text-xs">No purchase records found for this customer.</span>
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
