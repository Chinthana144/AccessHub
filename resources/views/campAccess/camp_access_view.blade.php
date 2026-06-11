@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Camp Access
                <button class="btn btn-primary btn-sm float-end" id="btn_add_access">Add</button>
            </h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('duplicate'))
                <div class="alert alert-warning">
                    {{ session('duplicate') }}
                </div>
            @endif
            @if (session('remove'))
                <div class="alert alert-warning">
                    {{ session('remove') }}
                </div>
            @endif

            <table class="table">
                <tr>
                    <th>User</th>
                    <th>Camp Name</th>
                    <th>Actions</th>
                </tr>
                @foreach ($camp_accesses as $camp_access)
                    <tr data-id="{{ $camp_access->id }}">
                        <td>{{ $camp_access->user->name }}</td>
                        <td>{{ $camp_access->camp->name }}</td>
                        <td>
                            <form action="{{ route('campAccess.remove') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="camp_access_id" value="{{ $camp_access->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('campAccess.add_access_modal')

    <script src="{{ asset('js/camp_access.js') }}"></script>
@endsection