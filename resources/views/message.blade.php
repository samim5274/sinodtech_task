@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="mb-4 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-800 shadow-sm">

        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg text-green-600"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>

        <button @click="show = false" class="text-green-600 hover:text-green-800">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="mb-4 flex items-center justify-between rounded-lg border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm">

        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-xmark text-lg text-red-600"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>

        <button @click="show = false" class="text-red-600 hover:text-red-800">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if (session('warning'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="mb-4 flex items-center justify-between rounded-lg border border-amber-200 bg-amber-50 px-5 py-4 text-amber-800 shadow-sm">

        <div class="flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation text-lg text-amber-600"></i>
            <span class="text-sm font-medium">{{ session('warning') }}</span>
        </div>

        <button @click="show = false" class="text-amber-600 hover:text-amber-800">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif
