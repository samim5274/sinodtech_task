<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $i) {

            Customer::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@mail.com",
                'phone' => '017' . rand(10000000,99999999),
                'address' => "Dhaka {$i}",
                'purchase_count' => 0,
                'last_purchase_at' => Carbon::now()->subDays(rand(10,150)),
            ]);
        }
    }
}
