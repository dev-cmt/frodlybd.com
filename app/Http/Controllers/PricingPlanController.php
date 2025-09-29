<?php
namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::all();
        return view('backEnd.pricing.index', compact('plans'));
    }

    public function create()
    {
        return view('backEnd.pricing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'billing_cycle' => 'required|in:monthly,yearly',
            'features' => 'nullable|array',
        ]);

        PricingPlan::create([
            'name' => $request->name,
            'badge' => $request->badge,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $request->features,
        ]);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Plan Created Successfully');
    }

    public function edit(PricingPlan $pricingPlan)
    {
        return view('backEnd.pricing.edit', compact('pricingPlan'));
    }

    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'billing_cycle' => 'required|in:monthly,yearly',
            'features' => 'nullable|array',
        ]);

        $pricingPlan->update([
            'name' => $request->name,
            'badge' => $request->badge,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $request->features,
        ]);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Plan Updated Successfully');
    }

    public function destroy(PricingPlan $pricingPlan)
    {
        $pricingPlan->delete();
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Plan Deleted Successfully');
    }
}

