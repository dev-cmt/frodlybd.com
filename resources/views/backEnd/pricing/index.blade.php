@extends('backEnd.layouts.master')
@section('title', 'Pricing List')

@push('css')

@endpush

@section('content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Pricing</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start:: row-1 -->
    <div class="row mb-5">
        <div class="col-xl-12">
            <h5 class="fw-semibold text-center"> Frodly Pricing For Everyone </h5>
            <p class="text-muted text-center">Choose plan that suits best for your business needs, Our plans scales with you based on your needs</p>
            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-tabs mb-3 tab-style-6 bg-primary-transparent" id="myTab1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pricing-monthly1" data-bs-toggle="tab"
                            data-bs-target="#pricing-monthly1-pane" type="button" role="tab"
                            aria-controls="pricing-monthly1-pane" aria-selected="true">Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pricing-yearly1" data-bs-toggle="tab"
                            data-bs-target="#pricing-yearly1-pane" type="button" role="tab"
                            aria-controls="pricing-yearly1-pane" aria-selected="false">Yearly</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane show active p-0 border-0" id="pricing-monthly1-pane"
                    role="tabpanel" aria-labelledby="pricing-monthly1" tabindex="0">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="px-1 py-2 bg-success op-3"></div>
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="fs-18 fw-semibold">Free</div>
                                            <div>
                                                <span class="badge bg-success-transparent">For Indivudials</span>
                                            </div>
                                        </div>
                                        <div class="fs-25 fw-bold mb-1">$0<sub class="text-muted fw-semibold fs-11 ms-1">/ Per Month</sub></div>
                                        <div class="mb-1 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure quos debitis aliquam .</div>
                                        <div class="fs-12 mb-3"><u>Billed Monthly</u></div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">2 Free</strong>Websites
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">1 GB</strong>Hard disk storage
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">1 Year</strong>Email support
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">2</strong>Licenses
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Custom SEO optimizataion
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Chat Support
                                                </span>
                                            </li>
                                            <li class="d-grid">
                                                <button class="btn btn-light btn-wave">Choose Plan</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-0 border-0" id="pricing-yearly1-pane" role="tabpanel" aria-labelledby="pricing-yearly1" tabindex="0">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="px-1 py-2 bg-success op-3"></div>
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="fs-18 fw-semibold">Free</div>
                                            <div>
                                                <span class="badge bg-success-transparent">For Indivudials</span>
                                            </div>
                                        </div>
                                        <div class="fs-25 fw-bold mb-1">$0<sub class="text-muted fw-semibold fs-11 ms-1">/ Per Month</sub></div>
                                        <div class="mb-1 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure quos debitis aliquam .</div>
                                        <div class="fs-12 mb-3"><u>Billed Monthly</u></div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">2 Free</strong>Websites
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">1 GB</strong>Hard disk storage
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">1 Year</strong>Email support
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">2</strong>Licenses
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Custom SEO optimizataion
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Chat Support
                                                </span>
                                            </li>
                                            <li class="d-grid">
                                                <button class="btn btn-light btn-wave">Choose Plan</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="px-1 py-2 bg-success op-3"></div>
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="fs-18 fw-semibold">Team</div>
                                            <div>
                                                <span class="badge bg-success-transparent">
                                                    For Small Teams
                                                </span>
                                            </div>
                                        </div>
                                        <div class="fs-25 fw-bold mb-1">$1,799<sub class="text-muted fw-semibold fs-11 ms-1">/ Per Month</sub></div>
                                        <div class="mb-1 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure quos debitis aliquam .</div>
                                        <div class="fs-12 mb-3"><u>Billed Monthly</u></div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">5 Free</strong>Websites
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">5 GB</strong>Hard disk storage
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">2 Years</strong>Email support
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                </span>
                                                <span>
                                                    <strong class="me-1">5</strong>Licenses
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Custom SEO optimizataion
                                                </span>
                                            </li>
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="me-2">
                                                    <i class="ri-checkbox-circle-line fs-15 text-muted op-3"></i>
                                                </span>
                                                <span>
                                                    Chat Support
                                                </span>
                                            </li>
                                            <li class="d-grid">
                                                <button class="btn btn-light btn-wave">Choose Plan</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:: row-1 -->
@endsection

@push('js')

@endpush
