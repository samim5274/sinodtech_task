<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-Active Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Inactive Customer</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Track purchase history, frequency, and lifecycles.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Orders: 0
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

                    <tbody class="divide-y divide-slate-100">
                        @forelse($customers as $customer)
                            @php
                                $lastSale = $customer->sales()->latest()->first();
                                $inactiveDays = $lastSale
                                    ? $lastSale->created_at->diffInDays(now())
                                    : '-';
                            @endphp

                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">
                                        {{ $customer->name }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        ID: {{ $customer->id }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div>{{ $customer->phone }}</div>
                                    <div class="text-xs text-slate-500">{{ $customer->email }}</div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $lastSale ? $lastSale->created_at->format('d M Y') : 'No Purchase' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $inactiveDays }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                        Inactive
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <a href="#"
                                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                        Assign
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-500">
                                    No inactive customers found.
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
