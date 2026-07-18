<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sale;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Sale::all() as $sale){

            Transaction::create([
                'sale_id'=>$sale->id,
                'transaction_no'=>'TRX-'.strtoupper(uniqid()),
                'amount'=>$sale->grand_total,
                'payment_method'=>collect([
                    'cash',
                    'card',
                    'bank',
                    'mobile'
                ])->random(),
                'payment_status'=>'paid',
                'paid_at'=>now(),
            ]);

        }
    }
}
