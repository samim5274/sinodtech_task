<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        try {
            $products = Product::with('saleItems')->get();
            // dd($products);
            return view('product-list', [
                'products' => $products,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Products could not be fetched.',
            ], 500);
        }
    }

    public function showProduct(string $sku) {
        $product = Product::whereSku($sku)->firstOrFail();
        // dd($product);
        return view('product-details', compact('product'));
    }

}
