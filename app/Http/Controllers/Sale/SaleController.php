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
        $products = Product::where('status', 1)->where('stock_quantity', '>=', '0')->get();
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

        DB::transaction(function () use ($validated) {

            $totalSales = Sale::count() + 1;
            $invoiceNo = 'INV-' . str_pad($totalSales, 5, '0', STR_PAD_LEFT);

            $isExist = Sale::where('invoice_no', $invoiceNo)->first();

            if($isExist){
                return back()->with('error', 'Orver already created. Try again latter. Thanks!');
            }

            $saleItems = SaleItem::where('reg', $invoiceNo)->get();

            if($saleItems->isEmpty()) {
                return back()->with('error', 'Sale items not found.');
            }

            $subtotal = $saleItems->sum('subtotal');
            $discount = $subtotal* 0.10;
            $tax = ($subtotal * 5) / 100;
            $grand_total = ($subtotal - $discount)+$tax;

            Sale::create([
                'invoice_no'    => $invoiceNo,
                'customer_id'   => $validated['customer_id'],
                'subtotal'      => $subtotal,
                'discount'      => $discount,
                'tax'           => $tax,
                'grand_total'   => $grand_total,
                'sale_date'     => now(),
            ]);

        });

        return redirect()->back()->with('success', 'Sale completed successfully.');
    }
}
