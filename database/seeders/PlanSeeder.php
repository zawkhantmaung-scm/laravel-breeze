<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $goldProduct = $stripe->products->create([
            'name' => 'Gold',
        ]);
        $goldPrice = $stripe->prices->create([
            'unit_amount' => 100,
            'currency' => 'sgd',
            'recurring' => ['interval' => 'month'],
            'product' => $goldProduct->id,
        ]);
        $gold = [
            'name' => $goldProduct->name,
            'price' => $goldPrice->unit_amount,
            'stripe_product_id' => $goldProduct->id,
            'stripe_price_id' => $goldPrice->id,
        ];
        
        Plan::create($gold);

        $platinumProduct = $stripe->products->create([
            'name' => 'Platinum',
        ]);
        $platinumPrice = $stripe->prices->create([
            'unit_amount' => 300,
            'currency' => 'sgd',
            'recurring' => ['interval' => 'month'],
            'product' => $platinumProduct->id,
        ]);
        $platinum = [
            'name' => $platinumProduct->name,
            'price' => $platinumPrice->unit_amount,
            'stripe_product_id' => $platinumProduct->id,
            'stripe_price_id' => $platinumPrice->id,
        ];
        
        Plan::create($platinum);

        $diamondProduct = $stripe->products->create([
            'name' => 'Diamond',
        ]);
        $diamondPrice = $stripe->prices->create([
            'unit_amount' => 500,
            'currency' => 'sgd',
            'recurring' => ['interval' => 'month'],
            'product' => $diamondProduct->id,
        ]);
        $diamond = [
            'name' => $diamondProduct->name,
            'price' => $diamondPrice->unit_amount,
            'stripe_product_id' => $diamondProduct->id,
            'stripe_price_id' => $diamondPrice->id,
        ];

        Plan::create($diamond);
    }
}
