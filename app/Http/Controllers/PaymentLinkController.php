<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\StripeHistory;
use App\Http\Requests\PlanRequest;
use Illuminate\Support\Facades\Redirect;

class PaymentLinkController extends Controller
{
    public function plan()
    {
        $plans = Plan::all();
        return view('payment-link-plan', compact('plans'));
    }

    public function payment(PlanRequest $request)
    {
        $plan = Plan::find($request->type);
        $data = StripeHistory::where('user_id', auth()->id())->where('plan_id', $plan->id)->first();
        if (!$data) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $token = hash("sha256", rand());
            $data = $stripe->paymentLinks->create(
                [
                    'line_items' => [['price' => $plan->stripe_price_id, 'quantity' => 1]],
                    'after_completion' => [
                        'type' => 'redirect',
                        'redirect' => ['url' => route('payment.link.verify', ['token' => $token])],
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

    public function verify(Request $request)
    {
        $data = StripeHistory::where('user_id', auth()->id())->where('token', $request->token)->first();
        if (!$data) {
            session()->flash('element_fail', 'Fail Stripe Payment Links method!');
            return to_route('payment.link.fail');
        }
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
        session()->flash('element_success', 'Success with Stripe Payment Links method!');
        return to_route('payment.link.success');
    }

    public function success()
    {
        if ($elementSuccess = session()->get('element_success')) {
            return view('message', ['message' => $elementSuccess]);
        }
        return to_route('dashboard');
    }

    public function fail()
    {
        if ($elementFail = session()->get('element_fail')) {
            return view('message', ['message' => $elementFail]);
        }
        return to_route('dashboard');
    }
}
