<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\User;
use App\Models\PricingPlan;
use App\Models\DomainRecord;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'plan'])->get();
        $clients = User::role('client')->get();
        $packages = PricingPlan::all();

        return view('backEnd.sales.index', compact('sales', 'clients', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'  => 'required|exists:users,id',
            'package_id' => 'required|exists:pricing_plans,id',
        ]);

        // Get package info
        $plan = PricingPlan::find($request->package_id);

        // Recalculate end date if package changed
        $start = Carbon::parse($request->start_date ?? now());
        $periods = [
            'monthly' => 1,
            'quarterly' => 3,
            'half-yearly' => 6,
            'yearly' => 12,
            'lifetime' => null,
        ];
        $months = $periods[$plan->billing_cycle] ?? 0;
        $end = $months ? $start->copy()->addMonths($months) : null;
        $start_date = $start->toDateString();
        $end_date = $end?->toDateString();

        // Generate unique invoice number
        do {
            $year  = date('y');
            $month = date('m');
            $random = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
            $invoice_no = "INV-$year$month$random";
        } while (DB::table('sales')->where('invoice_number', $invoice_no)->exists());

        Sale::create([
            'user_id'         => $request->client_id,
            'plan_id'         => $request->package_id,
            'invoice_number'  => $invoice_no,
            'amount'          => $plan->price,
            'start_date'      => $start_date,
            'end_date'        => $end_date,
            'allowed_domains' => $plan->domain_count,
            'used_domains'    => 0,
            'total_requests'    => 0,
            'status'          => 'active',
        ]);

        return redirect()->back()->with('success', 'Sale created successfully.');
    }

    /**
     * Update Sale
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id'  => 'required|exists:users,id',
            'package_id' => 'required|exists:pricing_plans,id',
        ]);

        $sale = Sale::findOrFail($id);
        $plan = PricingPlan::find($request->package_id);

        // Recalculate end date if package changed
        $start = Carbon::parse($request->start_date ?? now());
        $periods = [
            'monthly' => 1,
            'quarterly' => 3,
            'half-yearly' => 6,
            'yearly' => 12,
            'lifetime' => null,
        ];
        $months = $periods[$plan->billing_cycle] ?? 0;
        $end = $months ? $start->copy()->addMonths($months) : null;
        $start_date = $start->toDateString();
        $end_date = $end?->toDateString();


        $sale->update([
            'user_id'         => $request->client_id,
            'plan_id'         => $request->package_id,
            'amount'          => $plan->price,
            'start_date'      => $start_date,
            'end_date'        => $end_date,
            'allowed_domains' => $plan->domain_count,
            'used_domains'    => 0,
            'total_requests'  => 0,
            'status'          => 'active',
        ]);

        return redirect()->back()->with('success', 'Sale updated successfully.');
    }

    /**
     * Delete a client plan (Sale)
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->back()->with('success', 'Client plan deleted successfully.');
    }

    public function upgrade(Request $request, Sale $sale)
    {
        $request->validate([
            'end_date' => 'required|date',
            'request_limit' => 'required|integer|min:1',
            'allowed_domains' => 'required|integer|min:1',
        ]);

        $sale->update([
            'end_date' => $request->end_date,
            'request_limit' => $request->request_limit,
            'allowed_domains' => $request->allowed_domains,
        ]);

        return response()->json(['status' => true, 'message' => 'Sale upgraded successfully']);
    }
}
