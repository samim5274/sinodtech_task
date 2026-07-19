<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    @include('header')

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-12">

        @include('message')

        <!-- Form Card Wrapper -->
        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">

            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-600"></span>
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Collect Payment</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Record a new payment transaction for an existing sale record.</p>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <div class="h-9 w-9 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 border border-emerald-100 shadow-sm">
                        <i class="fa-solid fa-credit-card text-sm"></i>
                    </div>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back
                    </a>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('payments.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <!-- Hidden Input for Sale ID (Backend submission for relation) -->
                <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Sale Reference (Read Only Visual) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Sale Invoice Reference
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fa-solid fa-file-invoice text-sm"></i>
                            </span>
                            <input type="text" value="Invoice #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }} (Reg: {{ $saleItems[0]->reg ?? 'N/A' }})" disabled
                                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500 outline-none cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div>
                        <label for="payment_method" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Payment Method <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-wallet text-sm"></i>
                            </span>
                            <select
                                name="payment_method"
                                id="payment_method"
                                required
                                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-700 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition appearance-none @error('payment_method') border-red-500 @enderror">

                                <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>
                                    Select Method...
                                </option>

                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                                    Cash
                                </option>

                                <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>
                                    Mobile Banking (bKash / Nagad / Rocket)
                                </option>

                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                                    Debit / Credit Card
                                </option>

                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>
                                    Bank Transfer
                                </option>

                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        @error('payment_method')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payable Amount Input -->
                    <div class="md:col-span-2">
                        <label for="amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Amount to Pay (৳) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fa-solid fa-bangladeshi-taka-sign text-sm"></i>
                            </span>
                            <!-- Pre-filled with Sale Amount, but editable if they are making partial payments -->
                            <input type="number" name="amount" id="amount" min="1" step="0.01"
                                value="{{ $sale->grand_total ?? '' }}" placeholder="0.00" required
                                class="w-full pl-9 pr-3 py-3 rounded-lg border border-slate-200 text-base font-bold text-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition @error('amount') border-red-500 @enderror">
                        </div>
                        <p class="mt-1 text-xs text-slate-400">Default total payable amount is fetched from the selected invoice.</p>
                        @error('amount')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Subtle Status Notice -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-info text-slate-400 text-sm"></i>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Payment Status Upon Submission</p>
                            <p class="text-[11px] text-slate-400">This transaction will instantly be recorded under status: <span class="font-medium text-emerald-600">Paid</span>.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 text-sm font-medium border rounded-lg text-slate-600 hover:text-slate-800 transition">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500/20">
                        <i class="fa-solid fa-receipt text-xs"></i>
                        Payment
                    </button>
                </div>

            </form>
        </div>

    </main>

    @include('footer')

</body>
</html>
