@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Codes</h5>
        </div>
        <div class="card-body">
            
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Select Camp</label>
                        <select name="cmb_camp" id="cmb_camp" class="form-select">
                            <option value="0">--- Select Camp ---</option>
                            @foreach ($camps as $camp)                                
                                <option value="{{ $camp->id }}">{{ $camp->name }}</option>                                
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-3">
                        <label for="">Select Sheet name</label>
                        <select name="cmb_sheet" id="cmb_sheet" class="form-select"></select>
                    </div>

                    <div class="col-md-3">
                        <label for="">Date</label>
                        <input type="date" class="form-control" name="sheet_date" id="sheet_date">
                    </div>

                    <div class="col-md-3">
                        <button type="button" id="btn_fetch_codes" class="btn btn-primary">Fetch</button>
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <button type="button" class="btn btn-success w-50" id="btn_fetch_by_date">Fetch by Date</button>
                </div>

            </form>

        </div>
    </div>

    <script src="{{ asset('js/code_upload.js') }}"></script>
@endsection