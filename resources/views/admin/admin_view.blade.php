@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Mikrotik Admin Control Panel</h5>
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

            <h5>CLI Execute</h5>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">General CLI</label>
                    <input type="text" class="form-control" id="txt_general_cli">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary mt-4" id="btn_general_cli">Execute</button>
                </div>
            </div>

            <hr>
            <h5>Testing</h5>
            <button class="btn btn-primary btn-sm" id="btn_testing">Click</button>


            <p>create token table</p>
            <form action="{{ route('create.tokenTable') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Create Table</button>
            </form>

        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
@endsection