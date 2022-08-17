<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StripeHistory;
use Illuminate\Support\Facades\Redirect;

class PaymentLinkController extends Controller
{
    public function plan()
    {
        $plans = Plan::all();
        return view('payment-link-plan', compact('plans'));
    }

    public function payment(Request $request)
    {
        $plan = Plan::find($request->type);
        $orderExist = Order::where('user_id', auth()->id())->where('plan_id', $plan->id)->exists();
        if ($orderExist) {
            return to_route('dashboard');
        }
        $data = StripeHistory::where('user_id', auth()->id())->where('plan_id', $plan->id)->first();
        if (!$data) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $token = hash("sha256", rand());
            $data = $stripe->paymentLinks->create(
                [
                    'line_items' => [['price' => $plan->stripe_price_id, 'quantity' => 1]],
                    'after_completion' => [
                        'type' => 'redirect',
                        'redirect' => ['url' => route('payment.link.success', ['token' => $token])],
                    ],
                ]
            );
            StripeHistory::create([
                'user_id' => auth()->id(),
                'plan_id' => $plan->id,
                'url' => $data->url,
                'token' => $token,
                'plink' => $data->id,
            ]);
        }
        return Redirect::to($data->url);
    }

    public function success(Request $request)
    {
        $data = StripeHistory::where('user_id', auth()->id())->where('token', $request->token)->first();
        $payment = [
            'user_id' => $data->user_id,
            'plan_id' => $data->plan_id,
            'started_at' => now()->startOfMonth(),
            'ended_at' => now()->endOfMonth(),
        ];
        Order::create($payment);
        StripeHistory::destroy($data->id);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $stripe->paymentLinks->update(
            $data->plink,
            ['active' => false]
        );
        return to_route('dashboard');
    }
}
