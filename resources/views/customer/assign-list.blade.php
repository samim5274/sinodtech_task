<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Assignments</title>
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
                        <h2 class="text-base font-bold text-slate-800 uppercase tracking-wide">Customer Assignments</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Manage and track customer relationships assigned to employees.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-md border border-indigo-100">
                    Total Assignments: {{ $assignEmployeeAndCustomer->count() }}
                </span>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-left">Customer</th>
                            <th class="px-6 py-3.5 text-left">Assigned Employee</th>
                            <th class="px-6 py-3.5 text-center">Assigned Date</th>
                            <th class="px-6 py-3.5 text-left">Remarks</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($assignEmployeeAndCustomer as $assignment)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $assignment->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        #{{ str_pad($assignment->customer_id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-slate-700">
                                        {{ $assignment->employee->name ?? 'N/A' }}
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        Code: EMP-{{ str_pad($assignment->employee_id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-slate-700">
                                        {{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->format('d M Y') : 'N/A' }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->format('h:i A') : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600 max-w-xs truncate" title="{{ $assignment->remarks }}">
                                        {{ $assignment->remarks ?: 'No remarks dynamic' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" onsubmit="return confirm('Remove this assignment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fa-solid fa-folder-open text-2xl text-slate-400"></i>
                                        <p class="text-lg font-semibold text-slate-600">
                                            No Assignments Found
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            No customers are currently assigned to any employees.
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
