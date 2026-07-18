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

        @include('message')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">

                    <form action="{{ route('add.sale.item') }}" method="POST">
                        @csrf

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <!-- items-end ব্যবহার করা হয়েছে যাতে লেবেলগুলোর নিচে ইনপুট ও বাটন সুন্দরভাবে এলাইন হয় -->
                            <div class="flex flex-col md:flex-row items-end gap-4">
                                
                                <!-- প্রোডাক্ট সিলেক্ট (বেশি জায়গা নিবে তাই flex-1) -->
                                <div class="w-full flex-1">
                                    <label for="product_select" class="block text-xs font-medium text-gray-500 mb-1">Product</label>
                                    <select id="product_select" name="product_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border outline-none bg-white">
                                        <option value="" disabled selected>-- Choose a product --</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{$product->name}} ({{ $product->price }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- পরিমাণ (তুলনামূলক কম জায়গা নিবে তাই md:w-32) -->
                                <div class="w-full md:w-32">
                                    <label for="product_quantity" class="block text-xs font-medium text-gray-500 mb-1">Quantity</label>
                                    <input type="number" id="product_quantity" name="quantity" value="1" min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border outline-none">
                                </div>

                                <!-- বাটন (ইনপুটগুলোর সাথে একই লাইনে থাকবে) -->
                                <div class="w-full md:w-auto">
                                    <button type="submit" id="add-item-btn" class="w-full bg-indigo-50 text-indigo-600 border border-indigo-200 rounded-lg py-2 px-4 font-semibold text-sm hover:bg-indigo-100 transition flex items-center justify-center gap-2 h-[42px]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Product
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>



                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-900">Sale Invoice Items</h2>
                            <span id="item-count" class="text-xs bg-indigo-100 text-indigo-700 font-bold px-2.5 py-1 rounded-full">{{ $saleItems->count() }} Items</span>
                        </div>

                        <div class="flex-1 overflow-x-auto max-h-[450px]">
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

                        <form action="{{ route('confirm.sale') }}" method="POST" id="sale-form">
                            @csrf

                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Customer</label>
                                <select id="customer_id" name="customer_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3 border outline-none bg-white">
                                    <option value="" disabled selected>-- Choose a customer --</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="border-t border-gray-200 p-6 bg-gray-50 space-y-4">
                                <div class="flex justify-between items-center text-xl font-black text-gray-900">
                                    <span>Grand Total:</span>
                                    <span>৳ <span id="grand-total-display">{{ number_format($saleItems->sum('subtotal'), 2) }}</span></span>
                                </div>

                                <button type="submit" id="complete-sale-btn" class="w-full bg-indigo-600 text-white rounded-xl py-3 px-6 font-bold text-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100 disabled:bg-gray-300 disabled:shadow-none disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Complete Sale
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="space-y-4">
                        @foreach($sales as $sale)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                
                                <div class="flex items-start gap-3">
                                    
                                    <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-lg shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded uppercase tracking-wider">
                                                #{{ $sale->invoice_no }}
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-800 mt-1">
                                            {{ $sale->customer->name ?? 'Walk-in Customer' }}
                                        </h3>
                                        @if(isset($sale->customer->phone))
                                            <p class="text-xs text-gray-500">{{ $sale->customer->phone }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6 border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                   
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Grand Total</p>
                                        <p class="text-base font-bold text-gray-900">
                                            ৳ {{ number_format($sale->grand_total, 2) }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

                
            </div>

    </main>

    @include('footer')

</body>
</html>
