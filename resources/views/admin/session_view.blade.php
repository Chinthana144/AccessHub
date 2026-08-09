@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Session and User</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">code</label>
                    <input type="text" id="txt_username" class="form-control">
                    <button class="btn btn-success mt-2" id="btn_fetch_session">Session</button>
                    <button class="btn btn-primary mt-2" id="btn_fetch_user">Fetch User</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_session.js') }}"></script>
@endsection