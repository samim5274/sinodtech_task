<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items List</title>
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
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Customer Purchase Items</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Track purchase history, frequency, and lifecycles.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Orders: {{ $saleItems->count('subtotal') }}
                </span>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5">Product Details</th>
                            <th class="px-6 py-3.5">Registration / Batch</th>
                            <th class="px-6 py-3.5 text-center">Quantity</th>
                            <th class="px-6 py-3.5 text-right">Unit Price</th>
                            <th class="px-6 py-3.5 text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm bg-white">
                        @forelse($saleItems as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center border border-indigo-100">
                                            <i class="fa-solid fa-dolly"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">
                                                {{ $item->product->name ?? 'Unknown Product' }}
                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                SKU/Code: {{ $item->product->sku ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if($item->reg)
                                        <span class="font-mono bg-slate-100 text-slate-700 text-xs font-medium px-2 py-1 rounded border border-slate-200">
                                            {{ $item->reg }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No Reg</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center font-semibold text-slate-700 font-mono">
                                    {{ number_format($item->quantity) }} <span class="text-xs text-slate-400 font-sans font-normal">Pcs</span>
                                </td>

                                <td class="px-6 py-4 text-right text-slate-600 font-medium font-mono">
                                    ৳{{ number_format($item->unit_price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-slate-900 font-mono">
                                    ৳{{ number_format($item->subtotal, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-file w-8 h-8 text-slate-300"></i>
                                        <span class="text-xs">No items found in this sale record.</span>
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
