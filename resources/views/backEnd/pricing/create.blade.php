@extends('backEnd.layouts.master')
@section('title', 'Add Pricing Plan')

@section('content')
<h4>Add Pricing Plan</h4>

<form action="{{ route('admin.pricing.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Badge</label>
        <input type="text" name="badge" class="form-control">
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Billing Cycle</label>
        <select name="billing_cycle" class="form-control">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Features</label>
        <input type="text" name="features[]" class="form-control mb-2" placeholder="Feature 1">
        <input type="text" name="features[]" class="form-control mb-2" placeholder="Feature 2">
        <input type="text" name="features[]" class="form-control mb-2" placeholder="Feature 3">
        <small class="text-muted">Add as many inputs as needed</small>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
