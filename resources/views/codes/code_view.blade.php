@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Codes</h5>
        </div>
        <div class="card-body">
            
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Select Camp</label>
                        <select name="cmb_camp" id="cmb_camp" class="form-select">
                            <option value="0">--- Select Camp ---</option>
                            @foreach ($camps as $camp)                                
                                <option value="{{ $camp->id }}">{{ $camp->name }}</option>                                
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-4">
                        <label for="">Select Sheet name</label>
                        <select name="cmb_sheet" id="cmb_sheet" class="form-select"></select>
                    </div>

                    <div class="col-md-4">
                        <button type="button" id="btn_fetch_codes" class="btn btn-primary">Fetch</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script src="{{ asset('js/code_upload.js') }}"></script>
@endsection