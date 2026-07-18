<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1,100) as $i) {

            DB::transaction(function () {

                $customer = Customer::inRandomOrder()->first();

                $sale = Sale::create([
                    'invoice_no' => 'INV-' . strtoupper(uniqid()),
                    'customer_id' => $customer->id,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax' => 0,
                    'grand_total' => 0,
                    'sale_date' => now(),
                ]);

                $subtotal = 0;

                $products = Product::inRandomOrder()
                    ->take(rand(1,4))
                    ->get();

                foreach ($products as $product){

                    $qty = rand(1,3);

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                        'subtotal' => $qty * $product->price,
                    ]);

                    $subtotal += $qty * $product->price;

                    $product->decrement('stock_quantity',$qty);
                }

                $sale->update([
                    'subtotal'=>$subtotal,
                    'grand_total'=>$subtotal
                ]);

                $customer->increment('purchase_count');

                $customer->update([
                    'last_purchase_at'=>now()
                ]);

            });

        }
    }
}
