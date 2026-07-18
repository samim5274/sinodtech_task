<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\Sale;

class SaleController extends Controller
{
    public function saleView(){
        $products = Product::where('status', 1)->where('stock_quantity', '>', '0')->get();
        $customers = Customer::all();
        $sales = Sale::with('customer')->get();

        $totalSales = Sale::count() + 1;
        $invoiceNo = 'INV-' . str_pad($totalSales, 5, '0', STR_PAD_LEFT);

        $saleItems = SaleItem::where('reg', $invoiceNo)->get();

        return view('sale', compact('products', 'customers', 'saleItems', 'sales'));
    }

    public function addSaleItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Insufficient stock.');
        }

        $totalSales = Sale::count() + 1;
        $invoiceNo = 'INV-' . str_pad($totalSales, 5, '0', STR_PAD_LEFT);

        $saleItem = SaleItem::where('reg', $invoiceNo)
            ->where('product_id', $product->id)
            ->first();

        if ($saleItem) {

            $newQty = $saleItem->quantity + $validated['quantity'];

            if ($newQty > $product->stock_quantity) {
                return back()->with('error', 'Insufficient stock.');
            }

            $saleItem->update([
                'quantity'   => $newQty,
                'unit_price' => $product->price,
                'subtotal'   => $newQty * $product->price,
            ]);

        } else {

            if ($validated['quantity'] > $product->stock_quantity) {
                return back()->with('error', 'Insufficient stock.');
            }

            SaleItem::create([
                'reg'        => $invoiceNo,
                'product_id' => $product->id,
                'quantity'   => $validated['quantity'],
                'unit_price' => $product->price,
                'subtotal'   => $product->price * $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Product added successfully.');
    }

    public function deleteSaleItem($id)
    {
        $saleItem = SaleItem::findOrFail($id);

        $saleItem->delete();

        return back()->with('success', 'Product removed successfully.');
    }

    public function confirmSale(Request $request){
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
        ]);

        try {

            DB::transaction(function () use ($validated) {

                $totalSales = Sale::count() + 1;
                $invoiceNo = 'INV-' . str_pad($totalSales, 5, '0', STR_PAD_LEFT);

                // Check duplicate invoice
                if (Sale::where('invoice_no', $invoiceNo)->exists()) {
                    throw new \Exception('Invoice already exists.');
                }

                $saleItems = SaleItem::where('reg', $invoiceNo)->lockForUpdate()->get();

                if($saleItems->isEmpty()) {
                    throw new \Exception('No sale items found.');
                }

                // Check Stock
                foreach ($saleItems as $item) {

                    $product = Product::lockForUpdate()->findOrFail($item->product_id);

                    if ($product->stock_quantity < $item->quantity) {
                        throw new \Exception(
                            "{$product->name} has only {$product->stock_quantity} item(s) in stock."
                        );
                    }
                }

                // Calculate Totals
                $subtotal = $saleItems->sum('subtotal');
                $discount = round($subtotal * 0.10, 2);
                $tax = round($subtotal * 0.05, 2);
                $grand_total = round($subtotal - $discount + $tax, 2);

                Sale::create([
                    'invoice_no'    => $invoiceNo,
                    'customer_id'   => $validated['customer_id'],
                    'subtotal'      => $subtotal,
                    'discount'      => $discount,
                    'tax'           => $tax,
                    'grand_total'   => $grand_total,
                    'sale_date'     => now(),
                ]);

                foreach ($saleItems as $item) {
                    Product::where('id', $item->product_id)
                        ->decrement('stock_quantity', $item->quantity);
                }

                $customer = Customer::find($validated['customer_id']);

                if (!$customer) {
                    throw new \Exception('Customer not found.');
                }

                $customer->update([
                    'purchase_count' => $customer->purchase_count + 1,
                    'last_purchase_at' => now(),
                ]);


            });

            return redirect()->back()->with(
                'success',
                'Sale completed successfully.'
            );

        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

    }
}
