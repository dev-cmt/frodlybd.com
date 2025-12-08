<?php

namespace App\Http\Controllers;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index() {
        $plans = PricingPlan::all();
        return view('backEnd.pricing.index', compact('plans'));
    }

    public function store(Request $request) {
        $data = $request->only(['name','domain_limit', 'request_limit','price','regular_price','billing_cycle','status','description']);

        $features_text = $request->features_text ?? [];
        $features_active = $request->features_active ?? [];
        $features_data = [];
        foreach ($features_text as $index => $text) {
            if (!empty($text)) {
                $features_data[] = [
                    'text' => $text,
                    'is_active' => $features_active[$index] ?? 0
                ];
            }
        }

        $data['features'] = json_encode($features_data);

        PricingPlan::updateOrCreate(['id' => $request->id], $data);
        return redirect()->back()->with('success','Pricing plan saved successfully');
    }

    public function destroy($id) {
        PricingPlan::findOrFail($id)->delete();
        return redirect()->back()->with('success','Pricing plan deleted successfully');
    }
}
