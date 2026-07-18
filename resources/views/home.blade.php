<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home - My Website</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <!-- Navbar / Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="text-2xl font-bold text-indigo-600">BrandLogo</a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium">About</a>
                    <a href="/public/products" class="text-gray-500 hover:text-indigo-600 font-medium">Products</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium">Services</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium">Contact</a>
                </nav>

                <!-- Call to Action Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium">Log in</a>
                    <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-medium hover:bg-indigo-700 transition">Sign up</a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center">
                    <button type="button" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gray-50 py-12 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col-reverse md:flex-row items-center gap-12">
            <!-- Text Content -->
            <div class="w-full md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-6">
                    Build Your Next Great Idea <span class="text-indigo-600">With Us</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Start your journey with our amazing platform. We provide the best tools and services to help you grow your business effortlessly.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="#" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700 transition text-center">Get Started</a>
                    <a href="#" class="bg-white text-indigo-600 border border-indigo-600 px-6 py-3 rounded-md font-medium hover:bg-gray-50 transition text-center">Learn More</a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="w-full md:w-1/2">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80" alt="Hero Image" class="rounded-lg shadow-lg object-cover w-full h-80 md:h-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900">Why Choose Us?</h2>
                <p class="mt-4 text-lg text-gray-500">Everything you need to manage your workflow effectively.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Fast Performance</h3>
                    <p class="text-gray-600">Experience blazing fast load times and smooth interactions across all devices.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">High Security</h3>
                    <p class="text-gray-600">Your data is safe with us. We use industry-standard encryption for maximum security.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition text-center">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Our dedicated support team is always here to help you, any time of the day.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-indigo-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">Ready to dive in?</h2>
            <p class="text-indigo-100 text-lg mb-8">Create an account today and start managing your projects like a pro.</p>
            <a href="#" class="bg-white text-indigo-600 px-8 py-3 rounded-md font-bold text-lg hover:bg-gray-100 transition shadow-lg">Sign Up Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-12 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="text-xl font-bold text-white tracking-wider">BrandLogo</span>
                    <p class="mt-4 text-sm">Making the world a better place through constructing elegant hierarchies.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="/public/products" class="hover:text-white transition">Products</a></li>
                        <li><a href="#" class="hover:text-white transition">Services</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Connect</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                        <li><a href="#" class="hover:text-white transition">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
                &copy; 2026 BrandLogo, Inc. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
