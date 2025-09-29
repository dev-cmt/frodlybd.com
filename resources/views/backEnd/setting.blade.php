@extends('backEnd.layouts.master')
@section('title')
    Settings
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backEnd/plugins/summernote/summernote-lite.min.css') }}">
@endpush
@section('content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Settings</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
        </div>
    </div>
    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-7">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Info
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       value="{{ $settings ? $settings->email : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" name="phone" class="form-control" id="phone"
                                       value="{{ $settings ? $settings->phone : '' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea name="address" id="address" class="form-control">{{ $settings ? $settings->address : '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card custom-card mb-3">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Page Setting
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Home Page Title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       value="{{ $settings ? $settings->title : '' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Home Page Description</label>
                                <textarea name="description" id="description" class="form-control summernote"
                                          rows="5">{!! $settings ? $settings->description : '' !!}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="success_text" class="form-label">Success Page Text</label>
                                <textarea name="success_text" id="success_text" class="form-control summernote"
                                          rows="5">{!! $settings ? $settings->success_text : '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">

                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Logo
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($settings)
                            @if ($settings->logo)
                                <img class="mb-2" src="{{ asset($settings->logo) }}" alt="{{ $settings->logo }}"
                                     width="50">
                            @endif
                        @endif
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Favicon
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($settings)
                            @if ($settings->favicon)
                                <img class="mb-2" src="{{ asset($settings->favicon) }}" alt="{{ $settings->favicon }}"
                                     width="50">
                            @endif
                        @endif
                        <input type="file" name="favicon" class="form-control">
                    </div>
                </div>
                <div class="card custom-card mb-3">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Facebook Pixel
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-12 mb-3">
                                <label class="form-label" for="fb_pixel_code">Facebook Pixel Code</label>
                                <textarea name="fb_pixel_code" id="fb_pixel_code" class="form-control" rows="10">{!! $settings->fb_pixel_code ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Action
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script src="{{ asset('backEnd/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,
            });
        });
    </script>
@endpush
