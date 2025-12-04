<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use App\Models\PricingPlan;
use App\Models\DomainRecord;

class YourPackageController extends Controller
{
    public function index()
    {
        $sale = Sale::with(['user', 'plan'])->where('user_id', auth()->id())->first();

        return view('backEnd.your-package.index', compact('sale'));
    }

    /**--------------------------------------------------------------------------------------
     * Domain Management for Client's Purchased Plan
     * --------------------------------------------------------------------------------------
     */
    public function storeDomain(Request $request)
    {
        $sale = Sale::findOrFail($request->sale_id);

        if ($sale->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        if ($sale->used_domains >= $sale->allowed_domains) {
            return redirect()->back()->with('error', 'Max domains reached');
        }

        $request->validate([
            'domain_name' => 'required|string|max:255|unique:domain_records,domain_name,NULL,id,sale_id,'.$sale->id,
        ]);

        DomainRecord::create([
            'sale_id' => $sale->id,
            'domain_name' => $request->domain_name,
            'status' => 'active',
        ]);

        $sale->increment('used_domains');

        return redirect()->back()->with('success', 'Domain added successfully.');
    }

    public function updateDomain(Request $request, DomainRecord $domain)
    {
        if ($domain->sale->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $request->validate([
            'domain_name' => 'required|string|max:255|unique:domain_records,domain_name,'.$domain->id.',id,sale_id,'.$domain->sale_id,
        ]);
        $domain->update([
            'domain_name' => $request->domain_name,
        ]);

        return redirect()->back()->with('success', 'Domain updated successfully.');
    }
    public function destroyDomain(DomainRecord $domain)
    {
        if ($domain->sale->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $domain->delete();
        $domain->sale->decrement('used_domains');

        return redirect()->back()->with('success', 'Domain deleted successfully.');
    }




}
