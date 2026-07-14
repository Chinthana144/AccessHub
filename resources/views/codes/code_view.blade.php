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
                        <button type="button" class="btn btn-success mt-4" id="btn_fetch_by_date">Fetch by Date</button>
                    </div>
                </div>

            </form>

            <div id="div_table">

                <div class="row mt-3">
                    <div class="col-md-6">
                        <button type="button" id="btn_submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-md-6">
                        <div id="div_totals"></div>
                    </div>
                </div>
                

                <table id="tbl_codes" class="table table-bordered mt-2">
                    
                </table>    

                <div id="loader" class="loader-hidden"></div>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/code_upload.js') }}"></script>
@endsection