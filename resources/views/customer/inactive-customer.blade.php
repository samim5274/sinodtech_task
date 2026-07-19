<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-Active Customer</title>
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
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Inactive Customer</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Track purchase history, frequency, and lifecycles.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Records: {{ $customers->count() }}
                </span>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-left">Customer</th>
                            <th class="px-6 py-3.5 text-left">Contact</th>
                            <th class="px-6 py-3.5 text-center">Last Purchase</th>
                            <th class="px-6 py-3.5 text-center">Inactive Days</th>
                            <th class="px-6 py-3.5 text-center">Status</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($customers as $customer)
                            <tr class="transition hover:bg-slate-50">
                                {{-- Customer --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $customer->name }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        Customer #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                {{-- Contact --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-slate-700">
                                        {{ $customer->phone ?: 'N/A' }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $customer->email ?: 'No Email' }}
                                    </div>
                                </td>

                                {{-- Last Purchase --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="font-medium text-slate-700">
                                        {{ $customer->last_purchase_at->format('d M Y') }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $customer->last_purchase_at->format('h:i A') }}
                                    </div>
                                </td>

                                @php
                                    $inactiveDays = $customer->last_purchase_at?->diffInDays(now());
                                @endphp

                                {{-- Inactive Days --}}
                                <td class="px-6 py-4 text-center">
                                    @if($inactiveDays)
                                        <span class="font-semibold text-red-600">
                                            {{ $inactiveDays }} Days
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        ● Inactive
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('assign', ['customer_id' => $customer->id,'employee_id' => $employee->id,]) }}"
                                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
                                        <i class="fa-brands fa-atlassian"></i>
                                        Assign
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fa-solid fa-angle-right"></i>
                                        <p class="text-lg font-semibold text-slate-600">
                                            No Inactive Customers
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            All customers have made a purchase within the last 90 days.
                                        </p>
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
