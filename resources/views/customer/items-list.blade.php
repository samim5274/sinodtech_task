<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Invoice Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-12">

        @include('message')
















        <!-- Top Navigation / Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Invoice Details</h1>
                <p class="text-xs text-slate-500 mt-1">Registration/Invoice No: <span class="font-semibold text-indigo-600">#{{ $saleItems->first()->reg ?? 'N/A' }}</span></p>
            </div>
            <div>
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <!-- <a href="{{ route('payment.view', $saleItems[0]->reg) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <i class="fa-solid fa-bank"></i> Pay Now
                </a> -->
            </div>
        </div>

        <!-- Payment Pending Alert Banner -->
        @if(!$transaction && $sale)
            <div class="mb-6 p-4 rounded-xl border border-amber-200 bg-amber-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-sm animate-pulse">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-amber-100 rounded-lg flex items-center justify-center text-amber-700 border border-amber-200">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900">Payment Collection Pending</h4>
                        <p class="text-xs text-amber-700/80 mt-0.5">This sale record is currently waiting for settlement confirmation.</p>
                    </div>
                </div>
                <a href="{{ route('payment.view', $saleItems[0]->reg) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-amber-700 whitespace-nowrap">
                    <i class="fa-solid fa-plus text-[10px]"></i> Collect Payment Now
                </a>
            </div>
        @endif

        <!-- Core Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            @if($saleItems->isNotEmpty())
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Unique Items</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $saleItems->count() }} Types</h3>
                    </div>
                    <div class="h-11 w-11 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-boxes-stacked text-lg"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between transition hover:shadow-md">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Quantity</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $saleItems->sum('quantity') }} Pcs</h3>
                    </div>
                    <div class="h-11 w-11 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-calculator text-lg"></i>
                    </div>
                </div>
            @endif

            @if($sale)
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between bg-gradient-to-br from-white to-indigo-50/20 border-r-indigo-200 transition hover:shadow-md">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-500">Net Payable</p>
                        <h3 class="text-2xl font-black text-indigo-700 mt-1">৳{{ number_format($sale->grand_total, 2) }}</h3>
                    </div>
                    <div class="h-11 w-11 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-200">
                        <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
                    </div>
                </div>
            @endif
        </div>

        <!-- Detailed Breakdown Grid Split -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

            <!-- Left Panel: Financial Analysis -->
            @if($sale)
                <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                            <i class="fa-solid fa-chart-pie"></i> Cost Configuration
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-4 rounded-lg bg-slate-50 border border-slate-100">
                                <span class="text-xs text-slate-400 block mb-0.5">Base Subtotal</span>
                                <span class="text-base font-bold text-slate-700">৳{{ number_format($sale->subtotal, 2) }}</span>
                            </div>
                            <div class="p-4 rounded-lg bg-amber-50/40 border border-amber-100/70">
                                <span class="text-xs text-amber-600 block mb-0.5">Campaign Discount</span>
                                <span class="text-base font-bold text-amber-700">-৳{{ number_format($sale->discount, 2) }}</span>
                            </div>
                            <div class="p-4 rounded-lg bg-rose-50/40 border border-rose-100/70">
                                <span class="text-xs text-rose-600 block mb-0.5">Government Tax</span>
                                <span class="text-base font-bold text-rose-700">+৳{{ number_format($sale->tax, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Right Panel: Settlement Status -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved"></i> Settlement Proof
                    </h4>

                    @if($transaction)
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 text-xs">Trx ID:</span>
                                <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $transaction->transaction_no }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 text-xs">Method:</span>
                                <span class="font-semibold text-slate-700 flex items-center gap-1">
                                    <i class="fa-solid fa-wallet text-slate-400 text-xs"></i> {{ $transaction->payment_method }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400 text-xs">Cleared Amount:</span>
                                <span class="font-black text-emerald-600">৳{{ number_format($transaction->amount, 2) }}</span>
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex justify-between items-center">
                                @if($transaction->payment_status === 'Paid')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-100">
                                        ● Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-100">
                                        ● {{ ['paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed'][$transaction->payment_status] ?? 'N/A' }}
                                    </span>
                                @endif
                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('d M, h:i A') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div class="h-10 w-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 border border-dashed border-slate-200 mb-2">
                                <i class="fa-solid fa-money-bill-transfer text-slate-400"></i>
                            </div>
                            <p class="text-xs font-semibold text-slate-400">No Receipt Found</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>



















        <!-- Sale Items Table Card -->
        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">

            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Product Item List</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Products purchased under this specific registration code.</p>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-left w-12">#</th>
                            <th class="px-6 py-3.5 text-left">Product Name</th>
                            <th class="px-6 py-3.5 text-right">Unit Price</th>
                            <th class="px-6 py-3.5 text-center">Quantity</th>
                            <th class="px-6 py-3.5 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($saleItems as $index => $item)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm font-medium text-slate-400">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $item->product->name ?? 'Unknown Product' }}
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        SKU/Code: #{{ str_pad($item->product_id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium text-slate-600">
                                    ৳{{ number_format($item->unit_price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 border border-slate-200">
                                        {{ $item->quantity }} Pcs
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-bold text-slate-800">
                                    ৳{{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                            <i class="fa-solid fa-file-invoice text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-base font-semibold text-slate-600">No items found</p>
                                            <p class="text-xs text-slate-400 mt-0.5">No items were found in this sale record.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if($saleItems->isNotEmpty())
                        <!-- Table Footer for Grand Total Summary Row -->
                        <tfoot>
                            <tr class="bg-slate-50/70 font-bold text-slate-800 border-t border-slate-200">
                                <td colspan="3" class="px-6 py-4 text-right text-sm uppercase text-slate-500 font-medium">Grand Total:</td>
                                <td class="px-6 py-4 text-center text-sm border-x border-slate-100">
                                    {{ $saleItems->sum('quantity') }} Pcs
                                </td>
                                <td class="px-6 py-4 text-right text-base text-indigo-700">
                                    ৳{{ number_format($saleItems->sum('subtotal'), 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

        </div>

    </main>

    @include('footer')

</body>
</html>
