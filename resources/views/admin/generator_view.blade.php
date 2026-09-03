@extends('layouts.admin_layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Generator</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="">First Charactor</label>
                    <input type="number" step="1" id="first_charactor" class="form-control">
                </div>
                
                <div class="col-md-3">
                    <button id="btn_fetch_codes" class="btn btn-success mt-4 w-100">Fetch Codes</button>
                </div>

                <div class="col-md-12 mt-3">

                    <p id="p_fetch_status"></p>

                    <label for="">Filter</label>
                    <textarea name="txt_code_filter" id="txt_code_filter" cols="30" rows="5" class="form-control"></textarea>
                </div>

                <div class="col-md-3 mt-2">
                    <label for="">Code Count</label>
                    <input type="number" step="1" id="code_count" class="form-control" value="10">
                </div>

                <div class="col-md-3 mt-2">
                    <label for="">Profile Name</label>
                    <input type="text" id="txt_profile" class="form-control" value="Unlimited 30 Days">
                </div>

                <div class="col-md-3 mt-2">
                    <button type="button" id="btn_generate" class="btn btn-primary mt-4 w-100">Generate</button>
                </div>
            </div>

            <div class="row mt-2">
                <p id="p_codes"></p>
            </div>
        </div>
    </div>

    {{-- remover --}}
    <div class="card mt-3">
        <div class="card-header">
            <h5>Remover</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Select Camp</label>
                    <select name="cmb_remove_camp" id="cmb_remove_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="">Codes to remove</label>
                    <textarea name="txt_remove_codes" id="txt_remove_codes" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-danger mt-2">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_generator.js') }}"></script>
@endsection