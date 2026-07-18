<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Product Details</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <!-- Header / Navbar -->
    @include('header')

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="{{ url('/public/products') }}" class="hover:text-indigo-600 transition"> &larr; Back</a>
            <span class="mx-2">/</span>
            <a href="/" class="hover:text-indigo-600 transition">Home</a>
            <span class="mx-2">/</span>
            <a href="#" class="hover:text-indigo-600 transition">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
        </nav>

        <!-- Product Grid (1 column on mobile, 2 columns on desktop) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">

            <!-- Left Side: Image Section -->
            <div class="space-y-4">
                <div class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                    @php
                        $defaultImage = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=1000&q=80';
                        $productImage = $product->image ?? $defaultImage;
                    @endphp
                    <img src="{{ $productImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                </div>

                <!-- Thumbnail Demo (For aesthetic purposes) -->
                <div class="grid grid-cols-4 gap-3">
                    <div class="aspect-square rounded-lg overflow-hidden border-2 border-indigo-500 cursor-pointer">
                        <img src="{{ $productImage }}" class="w-full h-full object-cover" alt="Main thumbnail">
                    </div>
                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 opacity-60 hover:opacity-100 transition cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1572569533902-4e69d807aa11?w=500&q=80" class="w-full h-full object-cover" alt="Thumbnail 2">
                    </div>
                </div>
            </div>

            <!-- Right Side: Product Information -->
            <div class="flex flex-col justify-between">
                <div>
                    <!-- SKU and Status Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                            SKU: {{ $product->sku }}
                        </span>

                        @if($product->stock_quantity > 0 && $product->status == '1')
                            <span class="inline-flex items-center text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full border border-green-200">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                In Stock
                            </span>
                        @else
                            <span class="inline-flex items-center text-xs font-semibold text-red-700 bg-red-50 px-2.5 py-1 rounded-full border border-red-200">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mb-2">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="my-4">
                        <span class="text-3xl font-black text-indigo-600">৳ {{ number_format($product->price, 2) }}</span>
                    </div>

                    <!-- Description -->
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Description</h3>
                        <p class="text-gray-600 text-base leading-relaxed">
                            {{ $product->description ?? 'No description available for this product.' }}
                        </p>
                    </div>
                </div>

                <!-- Cart Form and Action Buttons -->
                <div class="border-t border-gray-100 pt-6 mt-8">

                    <!-- Quantity Selector and Available Stock -->
                    <div class="flex items-center justify-between">
                        <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                        <div class="flex items-center space-x-3">
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                class="w-20 text-center rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-2 border outline-none disabled:bg-gray-100"
                                {{ $product->stock_quantity < 1 || $product->status != '1' ? 'disabled' : '' }}>
                            <span class="text-xs text-gray-400">({{ $product->stock_quantity }} items available)</span>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <!-- Buy Now Button -->
                        <a href="{{ route('sale.index') }}"
                            class="flex-1 bg-indigo-600 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 shadow-md shadow-indigo-100 disabled:bg-gray-300 disabled:shadow-none disabled:cursor-not-allowed"
                            {{ $product->stock_quantity < 1 || $product->status != '1' ? 'disabled' : '' }}>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            {{ $product->stock_quantity > 0 && $product->status == '1' ? 'Buy Now' : 'Unavailable' }}
                        </a>

                        <!-- Wishlist Button -->
                        <a href="{{ route('sale.index') }}" class="py-3 px-4 rounded-xl flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:text-red-500 border border-gray-200 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('footer')

</body>
</html>
