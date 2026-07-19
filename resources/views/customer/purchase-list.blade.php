<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-12">

        @include('message')

        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">

            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
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
                                            <i class="fa-solid fa-file-lines"></i>
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
                                        <i class="fa-solid fa-eye w-3.5 h-3.5 text-slate-400"></i>
                                        View Bill
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-left-right w-8 h-8 text-slate-300"></i>
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
