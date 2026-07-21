@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Users
                <button id="btn_create_user" class="btn btn-primary btn-sm float-end">Add User</button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table" id="tbl_users">
                <tr>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $user)
                    <tr data-id='{{ $user->id }}'>
                        <td>{{ $user->role->name }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-flex">
                            <button class="btn btn-primary btn-sm btn_change_password">Change Password</button>
                            <button class="btn btn-outline-warning btn-sm ms-1 btn_edit_user"><i class="bx bx-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="d-flex">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @include('users.add_user_modal')
    @include('users.edit_user_modal')

    <script src="{{ asset('js/users.js') }}"></script>
@endsection