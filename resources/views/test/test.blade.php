@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Testing Page</h5>
        </div>
        <div class="card-body">
            <p>content</p>

            <div class="container container-md">
                <form action="{{ route('test.sheetNames') }}" method="post">
                @csrf

                <input type="text" name="code" class="form-control">

                <button class="btn btn-primary">Click</button>
            </form>
            </div>

            <div class="mt-3">
                <h5>Codes</h5>

                <button class="btn btn-success btn-sm" id="btn_fetch">Fetch</button>

                <button class="btn btn-success btn-sm" id="btn_fetch_users">Fetch all users</button>
            </div>
            
        </div>
    </div>

    <script src="{{ asset('js/test.js') }}"></script>
@endsection