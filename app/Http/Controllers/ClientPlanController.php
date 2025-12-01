<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\PricingPlan;

class ClientPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::where('status', 1)->get();

        $clientPlans = Order::with(['user', 'plan'])
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.client-plans.index', compact('plans', 'clientPlans'));
    }

    /**
     * Store (assign) a plan to a client
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:pricing_plans,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $plan = PricingPlan::findOrFail($request->plan_id);

        // Create new order
        Order::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'amount'          => $plan->price,
            'start_date'      => now(),
            'end_date'        => $plan->billing_cycle === 'monthly'
                ? now()->addMonth()
                : now()->addYear(),

            // copy domain limit separately
            'allowed_domains' => $plan->domain_count,
            'used_domains'    => 0,

            'status' => 'active',
        ]);

        return redirect()
            ->route('client-plans.index')
            ->with('success', 'Client plan purchased successfully.');
    }

    /**
     * Delete a client plan (order)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return redirect()
            ->route('client-plans.index')
            ->with('success', 'Client plan deleted successfully.');
    }
}
