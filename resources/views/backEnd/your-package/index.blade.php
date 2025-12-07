@extends('backEnd.layouts.master')
@section('title', 'Users Management')
@push('css')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('backEnd/plugins/select2/select2.min.css') }}">
<style>
    .select2-container--open {
        z-index: 100000 !important;
    }
</style>
@endpush
@section('content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Your Package</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Your Package</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($sale)
    <div class="row">
        <div class="col-xl-4 d-flex">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Package Information
                    </div><span class="badge bg-success">{{ ucfirst($sale->status) }}</span>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="fs-18 fw-semibold mb-2 text-primary">{{ $sale->plan->name ?? 'No Plan' }}</div>
                        <p class="mb-1"><strong>Date:</strong> <br> {{ \Carbon\Carbon::parse($sale->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($sale->end_date)->format('d M Y') }}</p>
                    </div>
                    <ul class="list-unstyled mb-0 upcoming-events-list">
                        @foreach(json_decode($sale->plan->features ?? '[]', true) as $feature)
                            <li class="mt-2">
                                @if ($feature['is_active'] == 1)
                                    <div class="flex-fill">
                                        <p class="mb-0 fs-14">{{ $feature['text'] ?? '' }}</p>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-xl-4 d-flex">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Domain & Settings</div>
                </div>
                <div class="card-body">
                    <!-- Add Domain Form -->
                    @if($sale->used_domains < $sale->allowed_domains)
                        <form action="{{ route('admin.domains.store') }}" method="POST" class="mb-3 d-flex">
                            @csrf
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <input type="text" name="domain_name" class="form-control me-2" placeholder="Enter domain name" required>
                            <button type="submit" class="btn btn-primary btn-sm">Add</button>
                        </form>
                    @else
                        <p class="fs-18 fw-semibold mb-2 text-center text-success"><i class='bx  bx-globe-alt'></i> You have reached the maximum number of allowed domains ({{ $sale->allowed_domains }}).</p>

                    @endif
                    <hr>
                    <!-- Existing Domains -->
                    <ul class="list-unstyled">
                        @forelse($sale->domains as $domain)
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fs-16 fw-semibold">
                                    &#127760; <span class="text-info ">{{ $domain->domain_name }}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editDomainModal{{ $domain->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.domains.destroy', $domain->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this domain?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>

                                <!-- Edit Domain Modal -->
                                <div class="modal fade" id="editDomainModal{{ $domain->id }}" tabindex="-1" aria-labelledby="editDomainModalLabel{{ $domain->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered justify-content-center">
                                        <form action="{{ route('admin.domains.update', $domain->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDomainModalLabel{{ $domain->id }}">Edit Domain</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="domain_name_{{ $domain->id }}" class="form-label">Domain Name</label>
                                                        <input type="text" name="domain_name" id="domain_name_{{ $domain->id }}" class="form-control" value="{{ $domain->domain_name }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </li>
                        @empty
                            <li class="text-center">No domains added yet.</li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>

        @php
            $user = auth()->user(); // currently logged-in user
            $sale = $user->sales()->latest()->first(); // get latest sale
        @endphp

        @if($sale)
        <div class="col-xl-4 d-flex">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Usage Statistics
                    </div>
                </div>
                <div class="card-body">
                    <!-- Expire Date -->
                    <div class="d-flex align-items-center mb-3">
                        <span class="avatar avatar-md avatar-rounded bg-success me-2">
                            <i class="bi bi-calendar fs-16"></i>
                        </span>
                        <p class="mb-0 flex-fill text-muted">Expire Date: {{ date('d-m-Y', strtotime($sale->end_date)) }}</p>
                    </div>

                    @php
                        // Total requests and remaining %
                        $totalRequests = $sale->domains->sum('total_requests');
                        $maxRequests = $sale->request_limit ?? 1; // avoid division by zero
                        $remainingRequests = max($maxRequests - $totalRequests, 0);
                        $remainingPercentage = ($remainingRequests / $maxRequests) * 100;
                        $totalPercentage = ($totalRequests / $maxRequests) * 100;
                    @endphp

                    <!-- Total Requests & Remaining % -->
                    <div class="d-flex align-items-center mb-2">
                        <span class="fs-5 fw-semibold me-2">Limit: {{ number_format($maxRequests) }}</span>
                        <span class="fs-12 text-success ms-auto">
                            <i class="ti ti-trending-up me-1 d-inline-block"></i>
                            {{ number_format($remainingPercentage, 1) }}% left
                        </span>
                    </div>

                    <!-- Total Requests Progress Bar -->
                    @php
                        if ($totalPercentage <= 50) {
                            $barColor = 'bg-success';
                        } elseif ($totalPercentage <= 80) {
                            $barColor = 'bg-warning';
                        } else {
                            $barColor = 'bg-danger';
                        }
                    @endphp

                    <div class="fw-normal d-flex align-items-center mb-2 mt-3">
                        <p class="mb-0 flex-fill">Total Requests</p>
                        <span>{{ number_format($totalRequests) }}</span>
                    </div>
                    <div class="progress progress-xs mb-4">
                        <div class="progress-bar {{ $barColor }}" role="progressbar"
                            style="width: {{ min($totalPercentage, 100) }}%;"
                            aria-valuenow="{{ $totalPercentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <!-- Domain-wise Requests -->
                    {{-- @foreach($sale->domains as $domain)
                        @php
                            $domainPercentage = ($domain->total_requests / $maxRequests) * 100;
                        @endphp
                        <div class="fw-normal d-flex align-items-center mb-2 mt-3">
                            <p class="mb-0 flex-fill">{{ ucfirst($domain->domain_name) }} Requests</p>
                            <span>{{ number_format($domain->total_requests) }}</span>
                        </div>
                        <div class="progress progress-xs mb-4">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ min($domainPercentage, 100) }}%;"
                                aria-valuenow="{{ $domainPercentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
        @endif


    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4>No Plan Purchased Yet!</h4>
                    <a href="{{ url('/#pricing') }}" class="btn btn-primary mt-3">View Pricing Plans</a>
                </div>
            </div>
        </div>
    </div>

    @endif
@endsection

@push('js')
<script src="{{ asset('backEnd/plugins/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function(){
        // Initialize Select2
        function initSelect2() {
            $('select.select2').select2({
                placeholder: "Select role", // placeholder text
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editUserModal') // fixes modal dropdown issue
            });
        }
        initSelect2();
    });
</script>

@endpush
