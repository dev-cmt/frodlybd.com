@extends('backend.layouts.master')
@section('title')
    Role & Permission
@endsection

@section('css')
    <style>
        .custom-tr td {
                vertical-align: text-top !important;
            }
    </style>
    <!-- Sweetalerts CSS -->
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="mt-4"></div>
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Create Role & Permissions
            </div>
            <div class="prism-toggle">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success-gradient">Add Role</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordered text-nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @if (count($roles) > 0)
                            @foreach ($roles as $key => $item)
                                <?php
                                $rolePermissions = DB::table('role_has_permissions')
                                    ->where('role_has_permissions.role_id', $item->id)
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all();
                                ?>
                                <tr class="custom-tr">
                                    <td style="width: 1%">{{ $i++ }}</td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td style="text-wrap: wrap;">
                                        @foreach ($item->permissions as $permission)
                                                <span
                                                    class="badge bg-success-transparent">{{ ucwords(str_replace('-', ' ',$permission->name)) }}
                                                </span>
                                        @endforeach
                                    </td>


                                    <td width="5%">
                                        <a href="{{ route('admin.roles.edit', $item->id) }}" title="Edit"
                                            class="badge bg-outline-info mb-1 w-100 edit-btn">Edit
                                        </a>
                                        <br>

                                        <a href="javascript:void(0);" onclick="deleteForm({{ $item->id }})"
                                            title="Delete" class="badge bg-outline-danger btn_delete mb-1 w-100">Delete</a>
                                    </td>


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-danger text-center">No Data Available!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- {{ $departments->links('backEnd.pagination.paginate') }} --}}
        </div>
    </div>
@endsection
@section('js')
    <!-- Sweetalerts JS -->
    <script src="{{ asset('backEnd/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


@endsection
