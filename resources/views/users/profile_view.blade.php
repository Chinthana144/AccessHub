@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>User Profile</h5>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h5>Welcome {{ $user->name }}</h5>

                    <p>
                        Username: <b> {{ $user->name }} </b><br>
                        Email: <b> {{ $user->email }} </b><br>
                        Role: <b> {{ $user->role->name }} </b><br>
                    </p>
                </div>

                <div class="col-md-6">
                    <h5>Change Password</h5>

                    <form action="{{ route('profile.change-password') }}" method="post">
                        @csrf
                        <input type="hidden" name="hide_user_id" value="{{ $user->id }}">

                        <label for="">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control mb-2">

                        <label for="">Re-enter Password</label>
                        <input type="password" name="re_new_password" id="re_new_password" class="form-control mb-2">

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/profile.js') }}"></script>
@endsection