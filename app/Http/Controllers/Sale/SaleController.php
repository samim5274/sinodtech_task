<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;

class SaleController extends Controller
{
    public function saleView(){
        $products = Product::where('status', 1)->where('stock_quantity', '>=', '0')->get();
        $customers = Customer::all();

        return view('sale', compact('products', 'customers'));
    }
}
