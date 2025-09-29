@extends('backEnd.layouts.master')

@section('title')
    Dashboard
@endsection
@section('content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Welcome Admin Dashboard</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-top justify-content-between">
                        <div class="flex-fill">
                            <p class="mb-0 text-muted">Total Category</p>
                            <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">5</span> </div>
                        </div>
                        <div>
                            <span class="avatar avatar-md avatar-rounded bg-primary-transparent text-primary fs-18"><i class="bx bx-layer fs-16"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-top justify-content-between">
                        <div class="flex-fill">
                            <p class="mb-0 text-muted">Total Users</p>
                            <div class="d-flex align-items-center">
                                <span class="fs-5 fw-semibold">10</span> <span class="fs-12 text-success ms-2">
                                <i class="ti ti-trending-up me-1 d-inline-block"></i>0.0%</span>
                            </div>
                        </div>
                        <div> <span class="avatar avatar-md avatar-rounded bg-secondary-transparent text-secondary fs-18">
                                <i class="bi bi-person-lines-fill fs-16"></i> </span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-top justify-content-between">
                        <div class="flex-fill">
                            <p class="mb-0 text-muted">Page Views</p>
                            <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">1,986</span> <span
                                    class="fs-12 text-success ms-2"><i
                                        class="ti ti-trending-up me-1 d-inline-block"></i>5.1%</span> </div>
                        </div>
                        <div> <span class="avatar avatar-md avatar-rounded bg-success-transparent text-success fs-18">
                                <i class="bi bi-eye-fill fs-16"></i> </span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-top justify-content-between">
                        <div class="flex-fill">
                            <p class="mb-0 text-muted">Total Applications</p>
                            <div class="d-flex align-items-center"> <span class="fs-5 fw-semibold">{{ $data['total_applications'] }}</span>
                                <span class="fs-12 text-success ms-2"><i class="ti ti-trending-up me-1 d-inline-block"></i>3.5%</span> </div>
                        </div>
                        <div> <span class="avatar avatar-md avatar-rounded bg-info-transparent text-info fs-18"> <i class="bi bi-file-earmark-text-fill fs-16"></i> </span> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
