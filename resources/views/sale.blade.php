<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-12">

        @include('message')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 space-y-5">

                <form action="{{ route('add.sale.item') }}" method="POST">
                    @csrf
                    <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
                        <div class="flex flex-col md:flex-row items-end gap-3">

                            <div class="w-full flex-1">
                                <label for="product_select" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Select Product</label>
                                <div class="relative">
                                    <select id="product_select" name="product_id" required class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 pl-3 pr-10 border outline-none bg-slate-50/50 font-medium text-sm transition-all appearance-none">
                                        <option value="" disabled selected>Search or choose a product...</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{$product->name}} &nbsp;|&nbsp; Stock: {{ $product->stock_quantity }} &nbsp;|&nbsp; (৳{{ number_format($product->price, 0) }})</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                        <i class="fa-solid fa-chevron-down w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-28">
                                <label for="product_quantity" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Qty</label>
                                <input type="number" id="product_quantity" name="quantity" value="1" min="1" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 px-3 border outline-none bg-slate-50/50 font-semibold text-sm text-center transition-all">
                            </div>

                            <div class="w-full md:w-auto">
                                <button type="submit" id="add-item-btn" class="w-full bg-indigo-600 text-white rounded-lg py-2 px-5 font-semibold text-sm hover:bg-indigo-700 active:transform active:scale-[0.98] transition-all flex items-center justify-center gap-2 h-[38px] shadow-sm shadow-indigo-100">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    Add Item
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

                <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">

                    <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
                            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Current Cart</h2>
                        </div>
                        <span id="item-count" class="text-xs bg-slate-200/70 text-slate-700 font-bold px-2.5 py-0.5 rounded-md">{{ $saleItems->count() }} Items</span>
                    </div>

                    <div class="flex-1 overflow-x-auto max-h-[400px] overflow-y-auto relative">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="sticky top-0 z-10 border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="px-5 py-3 bg-slate-50">Product Details</th>
                                    <th class="px-5 py-3 text-center bg-slate-50">Unit Price</th>
                                    <th class="px-5 py-3 text-center bg-slate-50">Qty</th>
                                    <th class="px-5 py-3 text-right bg-slate-50">Subtotal</th>
                                    <th class="px-5 py-3 text-center bg-slate-50">Action</th>
                                </tr>
                            </thead>
                            <tbody id="invoice-items-container" class="divide-y divide-slate-100 text-sm bg-white">
                                @forelse($saleItems as $item)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <div class="font-semibold text-slate-800">
                                                {{ $item->product->name ?? 'Product ID: ' . $item->product_id }}
                                            </div>
                                            @if(isset($item->product->sku))
                                                <div class="text-[11px] font-mono text-slate-400 mt-0.5">{{ $item->product->sku }}</div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-center text-slate-600 font-medium">
                                            ৳{{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-5 py-3.5 text-center">
                                            <span class="inline-block bg-slate-100 px-2.5 py-0.5 rounded text-xs font-bold text-slate-700">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right font-semibold text-slate-900">
                                            ৳{{ number_format($item->subtotal, 2) }}
                                        </td>
                                        <td class="px-5 py-3.5 text-center">
                                            <form action="{{ route('sale-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-1 rounded hover:bg-red-50 inline-flex items-center">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-state-row">
                                        <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                            <div class="flex flex-col items-center justify-center gap-2">
                                                <i class="fa-solid fa-bag-shopping"></i>
                                                <span class="text-xs">No products added yet. Select a product and click Add.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <form action="{{ route('confirm.sale') }}" method="POST" id="sale-form" class="border-t border-slate-100 bg-slate-50/30">
                        @csrf

                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4 items-center bg-white border-t border-slate-100">
                            <div>
                                <label for="customer_id" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Customer Information</label>
                                <div class="relative">
                                    <select id="customer_id" name="customer_id" required class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 py-2 pl-3 pr-10 border outline-none bg-slate-50/50 text-sm transition-all appearance-none">
                                        <option value="" disabled selected>-- Choose a customer --</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                        <i class="fa-solid fa-chevron-down w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4 md:mt-5">
                                <div class="text-left sm:text-right">
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Payable Amount</span>
                                    <span class="text-2xl font-black text-slate-900">৳<span id="grand-total-display">{{ number_format($saleItems->sum('subtotal'), 2) }}</span></span>
                                </div>

                                <button type="submit" id="complete-sale-btn" class="bg-emerald-600 text-white rounded-lg py-2.5 px-6 font-bold text-sm hover:bg-emerald-700 active:transform active:scale-[0.98] transition-all shadow-sm shadow-emerald-100 disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    Complete Checkout
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Recent Invoices</h2>
                    </div>

                    <div class="p-4 space-y-3 max-h-[570px] overflow-y-auto">
                        @foreach($sales as $sale)
                        <div class="p-3.5 rounded-lg border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/10 transition-all group">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">
                                            #{{ $sale->invoice_no }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, h:i A') }}
                                        </span>
                                    </div>
                                    <h3 class="text-sm font-semibold text-slate-700 mt-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $sale->customer->name ?? 'Walk-in Customer' }}
                                    </h3>
                                    @if(isset($sale->customer->phone))
                                        <p class="text-xs text-slate-400 mt-0.5 font-mono">{{ $sale->customer->phone }}</p>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <span class="text-xs text-slate-400 block font-medium">Total</span>
                                    <span class="text-sm font-bold text-slate-800 block mt-0.5">
                                        ৳{{ number_format($sale->grand_total, 0) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>

    </main>

    @include('footer')

</body>
</html>
