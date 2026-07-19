<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Mail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

    @include('header')

    <main class="flex-1 flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 my-6">

        @include('message')

        <div class="w-full max-w-2xl bg-white rounded-2xl border border-slate-200/80 shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100 bg-linear-to-r from-slate-50/80 to-slate-50/30 flex items-center gap-3.5">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center border border-indigo-100/80 shadow-xs">
                    <i class="fa-regular fa-envelope text-lg"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800 tracking-wide">Compose Promotional Mail</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Send bulk emails to your selected target customers.</p>
                </div>
            </div>

            <form action="{{ route('send-mail') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Email Subject <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            required
                            value="🎉 Exclusive Offer: Enjoy 20% OFF on Your Next Purchase!"
                            placeholder="e.g., Exclusive 20% Discount Just For You!"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all font-medium shadow-2xs"
                        />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="body" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Mail Body / Message <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="body"
                        name="body"
                        rows="10"
                        required
                        placeholder="Write your email content here..."
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all leading-relaxed resize-y shadow-2xs"
                    >Dear Valued Customer,

Thank you for being a part of our journey! We truly appreciate your continuous support.

As a token of our gratitude, we are thrilled to offer you a special 20% discount on your next order. Whether you are looking to restock your favorites or try something brand new, now is the perfect time!

Use Promo Code: THANKYOU20 at checkout to claim your discount.

Hurry, this exclusive offer is valid for a limited time only!

Best regards,
Customer Success Team</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 rounded-lg text-xs font-semibold tracking-wide transition-all shadow-xs cursor-pointer"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg text-xs tracking-wide shadow-xs hover:shadow-md transition-all duration-200 cursor-pointer"
                    >
                        <i class="fa-regular fa-paper-plane"></i>
                        <span>Send Mail</span>
                    </button>
                </div>
            </form>
        </div>

    </main>

    @include('footer')

</body>
</html>
