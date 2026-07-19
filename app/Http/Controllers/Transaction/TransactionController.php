<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Employee;
use App\Models\CustomerAssignment;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index($reg)
    {
        $saleItems = SaleItem::where('reg', $reg)->get();
        $sale = Sale::where('invoice_no', $reg)->first();
        return view('payment.payment-view', compact('saleItems', 'sale'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,card,bank,mobile',
        ]);

        $sale = null;

        DB::transaction(function () use ($validated, &$sale) {

            $sale = Sale::lockForUpdate()->findOrFail($validated['sale_id']);

            // Total Paid Amount
            $previousPaid = Transaction::where('sale_id', $sale->id)
                ->where('payment_status', 'paid')
                ->sum('amount');

            // Remaining Due
            $dueAmount = $sale->grand_total - $previousPaid;

            if ($validated['amount'] > $dueAmount) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'amount' => 'Payment amount cannot be greater than due amount.',
                ]);
            }

            // Generate Transaction No
            do {
                $transactionNo = 'TRX-' . now()->format('YmdHis') . '-' . rand(1000, 9999);
            } while (Transaction::where('transaction_no', $transactionNo)->exists());

            Transaction::create([
                'sale_id'         => $sale->id,
                'transaction_no'  => $transactionNo,
                'amount'          => $validated['amount'],
                'payment_method'  => $validated['payment_method'],
                'payment_status'  => 'paid',
                'paid_at'         => now(),
            ]);

        });

        return redirect()->route('sales.show', ['invoice_no' => $sale->invoice_no])->with('success', 'Payment has been recorded successfully.');
    }
}
