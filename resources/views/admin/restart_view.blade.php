@extends('layouts.admin_layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Code Restart</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="">Code</label>
                    <input type="text" id="txt_code" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="button" id="btn_restart" class="btn btn-success mt-4">Restart</button>
                </div>
            </div>
            
            <div class="row mt-2">
                <p id="p_status">Status</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_restart.js') }}"></script>

@endsection