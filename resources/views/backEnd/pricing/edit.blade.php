@extends('backEnd.layouts.master')
@section('title', 'Edit Pricing Plan')

@section('content')
<h4>Edit Pricing Plan</h4>

<form action="{{ route('admin.pricing.update', $pricingPlan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $pricingPlan->name }}" required>
    </div>
    <div class="mb-3">
        <label>Badge</label>
        <input type="text" name="badge" class="form-control" value="{{ $pricingPlan->badge }}">
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" value="{{ $pricingPlan->price }}" required>
    </div>
    <div class="mb-3">
        <label>Billing Cycle</label>
        <select name="billing_cycle" class="form-control">
            <option value="monthly" {{ $pricingPlan->billing_cycle=='monthly'?'selected':'' }}>Monthly</option>
            <option value="yearly" {{ $pricingPlan->billing_cycle=='yearly'?'selected':'' }}>Yearly</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $pricingPlan->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Features</label>
        @if($pricingPlan->features)
            @foreach($pricingPlan->features as $feature)
                <input type="text" name="features[]" class="form-control mb-2" value="{{ $feature }}">
            @endforeach
        @endif
        <small class="text-muted">Add as many inputs as needed</small>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
