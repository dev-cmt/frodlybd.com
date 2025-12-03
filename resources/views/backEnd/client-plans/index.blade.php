@extends('backend.layouts.master')
@section('title', 'Users Management')
@push('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--open {
            z-index: 100000 !important;
        }
    </style>
@endpush
@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Your Plans</h1>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Client-plans</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">Plans List</div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $key => $user)
                            <tr class="{{ $user->id == 1 ? 'd-none' : ''}}">
                                <td>{{ ++$key }}</td>
                                <td>
                                    @if($user->photo_path)
                                        <img src="{{ asset($user->photo_path) }}" alt="photo" class="rounded-circle" width="40" height="40">
                                    @else
                                        <span class="badge bg-secondary">No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->first() ?? '-' }}</td>
                                <td>
                                    <div class="btn-list">
                                        <button type="button" class="btn btn-sm btn-warning-light btn-icon edit-user"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->roles->pluck('name')->first() ?? '' }}"
                                            data-photo="{{ $user->photo_path }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-light btn-icon" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
