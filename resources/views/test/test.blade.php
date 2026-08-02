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

            <div class="mt-3">
                <div id="div_data"></div>
            </div>

            <hr>

            <div class="mt-3">
                <p>hotspot session</p>

                <div class="col-md-6">

                </div>
                <label for="">Code</label>
                <input type="text" id="txt_code" class="form-control">

                <button id="btn_get_session" class="btn btn-primary">get session</button>
            </div>
            
        </div>
    </div>

    <script src="{{ asset('js/test.js') }}"></script>
@endsection