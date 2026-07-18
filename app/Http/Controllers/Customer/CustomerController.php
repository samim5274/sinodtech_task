<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\Sale;

class CustomerController extends Controller
{
    public function purchaseHistory(){
        $customers = Customer::all();
        return view('customer.purchase', compact('customers'));
    }

    public function customerPurchaseList($customerId){
        $customer = Customer::findOrFail($customerId);
        $customerOrders = Sale::where('customer_id', $customer->id)
            ->latest('sale_date')
            ->get();

        return view('customer.purchase-list', compact(
            'customer',
            'customerOrders'
        ));
    }

    public function showSale($reg) {
        $saleItems = SaleItem::with('product')->where('reg', $reg)->get();

        return view('customer.items-list', compact(
            'saleItems',
        ));
    }
}
