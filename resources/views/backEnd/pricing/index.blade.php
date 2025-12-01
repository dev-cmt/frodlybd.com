@extends('backend.layouts.master')
@section('title', 'Pricing Plans')

@push('css')
<style>
.custom-card { transition: 0.3s; }
.custom-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
</style>
@endpush

@section('content')
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Pricing Plans</h1>
    <div class="ms-md-1 ms-0">
        <button id="create-modal" class="btn btn-sm btn-primary btn-wave waves-effect waves-light">
            <i class="ri-add-line align-middle me-1 fw-semibold"></i>Create New Plan</button>
    </div>
</div>

<div class="row mb-5">
    @foreach($plans as $plan)
    <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
        <div class="card custom-card overflow-hidden">
            <div class="card-body p-0">
                <div class="px-1 py-2 bg-success op-3"></div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fs-18 fw-semibold">{{ $plan->name }}</div>
                        <div><span class="badge bg-success-transparent">{{ $plan->domain_count }} Domains</span></div>
                    </div>
                    <div class="fs-25 fw-bold mb-1">${{ $plan->price }}
                        <sub class="text-muted fw-semibold fs-11 ms-1">/ {{ ucfirst($plan->billing_cycle) }}</sub>
                    </div>
                    <div class="mb-1 text-muted">{{ $plan->description }}</div>
                    <ul class="list-unstyled mb-3">
                        @foreach(json_decode($plan->features ?? '[]', true) as $feature)
                            <li class="d-flex align-items-center mb-2">
                                <span class="me-2">
                                    <i class="ri-checkbox-circle-line fs-15 {{ $feature['is_active'] == 1 ? 'text-success' : 'text-muted op-3' }}"></i>
                                </span>
                                <span>{{ $feature['text'] ?? '' }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between">
                        {{-- FIX: Using @json($plan->features) for clean JSON output in the data attribute --}}
                        <button class="btn btn-primary-light btn-wave waves-effect waves-light edit-plan"
                            data-id="{{ $plan->id }}"
                            data-name="{{ $plan->name }}"
                            data-domain_count="{{ $plan->domain_count }}"
                            data-price="{{ $plan->price }}"
                            data-regular_price="{{ $plan->regular_price }}"
                            data-billing_cycle="{{ $plan->billing_cycle }}"
                            data-status="{{ $plan->status }}"
                            data-description="{{ $plan->description }}"
                            data-features='@json(json_decode($plan->features, true) ?? [])'>
                            <i class="ri-edit-line align-middle me-1 fw-semibold"></i> Edit
                        </button>

                        <form action="{{ route('admin.pricing-plans.destroy', $plan->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger-light btn-wave waves-effect waves-light" onclick="return confirm('Delete?')"><i class="ri-delete-bin-6-line align-middle me-1 fw-semibold"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="modal fade" id="planModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="planForm" method="POST" action="{{ route('admin.pricing-plans.store') }}">
                @csrf
                <input type="hidden" name="id" id="plan_id">
                <div class="modal-header">
                    <h5 class="modal-title">Create Pricing Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Name *</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3"><label class="form-label">Domain Count</label>
                            <input type="number" name="domain_count" id="domain_count" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3"><label class="form-label">Price *</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3"><label class="form-label">Regular Price</label>
                            <input type="number" step="0.01" name="regular_price" id="regular_price" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3"><label class="form-label">Billing Cycle</label>
                            <select name="billing_cycle" id="billing_cycle" class="form-select">
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="half-yearly">Half Yearly</option>
                                <option value="yearly">Yearly</option>
                                <option value="lifetime">Lifetime</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3"><label class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Features</label>
                            <div id="features-wrapper"></div>
                            <button type="button" id="add-feature" class="btn btn-sm btn-outline-primary mt-2">Add Feature</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Save Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function(){

    // Function to add a feature input row
    function addFeatureInput(feature = {}, defaultChecked = false){
        const text = feature.text || '';
        // If feature.is_active exists, use it. Otherwise, use defaultChecked
        const isActive = (feature.is_active == 1 || feature.is_active === "1") || defaultChecked ? 'checked' : '';
        const index = Date.now() + Math.floor(Math.random() * 1000);

        let html = `<div class="d-flex mb-2 feature-row align-items-center">
            <input type="hidden" name="features_active[${index}]" value="0">
            <input type="checkbox" name="features_active[${index}]" value="1" ${isActive} class="form-check-input me-2">
            <input type="text" name="features_text[${index}]" class="form-control me-2" value="${text}" placeholder="Feature">
            <button type="button" class="btn btn-danger btn-sm remove-feature">X</button>
        </div>`;

        $('#features-wrapper').append(html);
    }


    // Open modal for create
    $('#create-modal').click(function(){
        $('#planForm')[0].reset();
        $('#plan_id').val('');
        $('#features-wrapper').empty();
        addFeatureInput({}, true);
        $('#planForm').attr('action', "{{ route('admin.pricing-plans.store') }}");
        $('#planModal .modal-title').text('Create Pricing Plan');
        $('#planModal').modal('show');
    });

    // Open modal for edit - Uses data attributes
    $(document).on('click', '.edit-plan', function(){
        let $btn = $(this);

        // 1. Get data from attributes
        let id = $btn.data('id');
        let name = $btn.data('name');
        let domain_count = $btn.data('domain_count');
        let price = $btn.data('price');
        let regular_price = $btn.data('regular_price');
        let billing_cycle = $btn.data('billing_cycle');
        let status = $btn.data('status');
        let description = $btn.data('description');

        let features = $btn.data('features');

        // 2. Fallback check for features array
        if (!Array.isArray(features)) {
            // If it failed to parse for some reason, initialize empty array
            features = [];
        }

        // 3. Populate form fields
        $('#plan_id').val(id);
        $('#name').val(name);
        $('#domain_count').val(domain_count);
        $('#price').val(price);
        $('#regular_price').val(regular_price);
        $('#billing_cycle').val(billing_cycle);
        $('#status').val(status);
        $('#description').val(description);

        // 4. Populate features
        $('#features-wrapper').empty();
        if(features.length > 0){
            features.forEach(f => addFeatureInput(f));
        } else {
            addFeatureInput();
        }

        $('#planForm').attr('action', "{{ route('admin.pricing-plans.store') }}");
        $('#planModal .modal-title').text('Edit Pricing Plan');
        $('#planModal').modal('show');
    });


    // Remove feature input
    $(document).on('click', '.remove-feature', function(){
        $(this).closest('.feature-row').remove();
    });

    // Add new feature input
    $('#add-feature').click(function(){ addFeatureInput({}, true); });

});
</script>
@endpush
