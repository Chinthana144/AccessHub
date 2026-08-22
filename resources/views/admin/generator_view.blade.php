@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Generator</h5>
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
                    <label for="">Code Count</label>
                    <input type="number" step="1" class="form-control" value="10">
                </div>
                <div class="col-md-4">
                    <label for="">Initial Number</label>
                    <input type="number" step="1" class="form-control">
                </div>

                <div class="col-md-12 mt-3">
                    <label for="">Filter</label>
                    <textarea name="txt_code_filter" id="txt_code_filter" cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <button type="button" id="btn_generate" class="btn btn-primary mt-2">Generate</button>
                </div>
            </div>
        </div>
    </div>
@endsection