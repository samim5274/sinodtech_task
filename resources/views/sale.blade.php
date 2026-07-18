<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-12">

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1 space-y-6">

                    <form action="{{ route('add.sale.item') }}" method="POST">
                        @csrf

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Add Product Item</h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="product_select" class="block text-xs font-medium text-gray-500 mb-1">Product</label>
                                    <select id="product_select" name="product_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border outline-none bg-white">
                                        <option value="" disabled selected>-- Choose a product --</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{$product->name}} ({{ $product->price }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="product_quantity" class="block text-xs font-medium text-gray-500 mb-1">Quantity</label>
                                    <input type="number" id="product_quantity" name="quantity" value="1" min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border outline-none">
                                </div>

                                <button type="submit" id="add-item-btn" class="w-full bg-indigo-50 text-indigo-600 border border-indigo-200 rounded-lg py-2.5 px-4 font-semibold text-sm hover:bg-indigo-100 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Product
                                </button>
                            </div>
                        </div>

                    </form>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Customer</label>
                        <select id="customer_id" name="customer_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 border outline-none bg-white">
                            <option value="" disabled selected>-- Choose a customer --</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-900">Sale Invoice Items</h2>
                            <span id="item-count" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-2.5 py-1 rounded-full">{{ $saleItems->count() }} Items</span>
                        </div>

                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        <th class="px-6 py-3">Product Description</th>
                                        <th class="px-6 py-3 text-center">Price</th>
                                        <th class="px-6 py-3 text-center">Qty</th>
                                        <th class="px-6 py-3 text-right">Total</th>
                                        <th class="px-6 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-items-container" class="divide-y divide-gray-100 text-sm">
                                    @forelse($saleItems as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-900">
                                                    {{ $item->product->name ?? 'Product ID: ' . $item->product_id }}
                                                </div>
                                                @if(isset($item->product->sku))
                                                    <div class="text-xs text-gray-500">{{ $item->product->sku }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-600">
                                                ৳ {{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-center font-semibold text-gray-900">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">
                                                ৳ {{ number_format($item->subtotal, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('sale-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 dynamic-delete-btn">
                                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="empty-state-row">
                                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                                No products added yet. Select a product and click Add.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="border-t border-gray-200 p-6 bg-gray-50 space-y-4">
                            <div class="flex justify-between items-center text-xl font-black text-gray-900">
                                <span>Grand Total:</span>
                                <span>৳ <span id="grand-total-display">{{ number_format($saleItems->sum('subtotal'), 2) }}</span></span>
                            </div>

                            <button type="submit" id="complete-sale-btn" disabled class="w-full bg-indigo-600 text-white rounded-xl py-3 px-6 font-bold text-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100 disabled:bg-gray-300 disabled:shadow-none disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Complete Sale
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        <!-- <form action="#" method="POST" id="sale-form">
        @csrf
        </form> -->
    </main>

    @include('footer')

</body>
</html>
