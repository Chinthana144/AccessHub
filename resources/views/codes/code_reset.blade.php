@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Code Reset</h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <label for="">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}" @selected($camp->id == $active_camp_id)>{{ $camp->name }}</option>
                        @endforeach
                    </select>

                    <label for="">Username</label>
                    <input type="text" name="username" id="username" class="form-control">

                    <br>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" id="btn_fetch_user">Fetch User</button>
                    </div>
                </div>

                {{-- details --}}
                <div class="col-md-6">
                    <div id="div_identity"></div>

                    <div id="loader" class="loader-hidden"></div>

                    <div id="div_content"></div>
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('js/code_reset.js') }}"></script>
@endsection