@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Permission
                <button id="btn_create_permission" class="btn btn-primary btn-sm float-end">Create Permission</button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table" id="tbl_permission">
                <tr>
                    <th>Role</th>
                    <th>Page</th>
                    <th>Create</th>
                    <th>Edit</th>
                    <th>View</th>
                    <th>Delete</th>
                    <th>Action</th>
                </tr>
                @foreach ($permissions as $permission)
                    <tr data-id='{{ $permission->id }}'>
                        <td>{{ $permission->role->name }}</td>
                        <td>{{ $permission->page->name }}</td>
                        <td>
                            @if ($permission->can_create == 1)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($permission->can_edit == 1)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($permission->can_view == 1)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($permission->can_delete == 1)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm btn_edit_permission"><i class="bx bx-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('permissions.add_permission_modal')

    <script src="{{ asset('js/permission.js') }}"></script>
    
@endsection