<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Mail\CustomerOfferMail;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        return view('mail.user-mail');
    }

    public function sendMail(Request $request){
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        try {

            $customers = Customer::where(function ($query) {
                    $query->whereNull('last_purchase_at')
                        ->orWhere('last_purchase_at', '<=', now()->subDays(90));
                })
                ->whereNotNull('email')
                ->get();

            // foreach ($customers as $customer) {

            //     Mail::to($customer->email)
            //         ->queue(new CustomerOfferMail(
            //             $validated['subject'],
            //             $validated['body']
            //         ));

            //     usleep(500000);
            // }

            Mail::to($customers[0]->email)
                    ->queue(new CustomerOfferMail(
                        $validated['subject'],
                        $validated['body']
                    ));

            return back()->with(
                'success',
                "{$customers->count()} emails sent successfully."
            );

        } catch (\Exception $e) {

            Log::error($e);

            return back()->with('error', $e->getMessage());
        }
    }
}
