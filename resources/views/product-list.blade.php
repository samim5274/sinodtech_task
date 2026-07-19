<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sinodtech - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: {
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    @include('header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-12">

        <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Latest Products</h1>
                <p class="mt-2 text-sm text-gray-500">Explore our premium collection of products.</p>
            </div>
            <div class="text-sm text-gray-500">
                Showing {{ $products->count() }} products
            </div>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col">

                        <div class="relative w-full h-48 bg-gray-100">
                            @php
                                $defaultImage = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80';
                                $productImage = $defaultImage;
                            @endphp
                            <img src="{{ $productImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">

                            @if($product->stock_quantity < 1)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    Out of Stock
                                </div>
                            @else
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                    In Stock
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <!-- SKU -->
                            <p class="text-xs text-gray-500 mb-1 font-medium uppercase tracking-wide">SKU: {{ $product->sku }}</p>

                            <h3 class="text-lg font-bold text-gray-900 mb-2 truncate hover:underline" title="{{ $product->name }}">
                                <a href="/public/product/{{ $product->sku }}">{{ $product->name }}</a>
                            </h3>

                            <p class="text-xl font-extrabold text-indigo-600 mb-4">
                                ৳ {{ number_format($product->price, 2) }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">

                                <a href="/public/product/{{ $product->sku }}" class="flex-1 text-center bg-gray-50 text-gray-700 border border-gray-300 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition">
                                    View
                                </a>

                                @if($product->stock_quantity < 1 || $product->status != '1')
                                    <button type="button" disabled class="flex-1 bg-gray-400 text-white py-2 rounded-md text-sm font-medium cursor-not-allowed text-center shadow-sm">
                                        Buy Now
                                    </button>
                                @else
                                    <a href="{{ route('sale.index') }}" class="flex-1 bg-indigo-600 text-white py-2 rounded-md text-sm font-medium hover:bg-indigo-700 text-center transition shadow-sm">
                                        Buy Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg border border-gray-200">
                <i class="fa-brands fa-opencart mx-auto h-12 w-12 text-gray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for new arrivals.</p>
            </div>
        @endif

    </main>

    @include('footer')

</body>
</html>
