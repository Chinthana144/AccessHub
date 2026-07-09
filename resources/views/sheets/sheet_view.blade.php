@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                {{ $camp->name }} Sheets
                <button class="btn btn-primary btn-sm float-end" id="btn_sync_sheets">Synchronize</button>
            </h5>
        </div>
        <div class="card-body">
            <p>content {{ $camp->name }}</p>
            <div class="col-md-6">
                <input type="hidden" id="hide_camp_id" value="{{ $active_camp_id }}">
                <select name="cmb_camp" id="cmb_camp" class="form-select">
                    @foreach ($camps as $camp)
                        <option value="{{ $camp->id }}" @selected($camp->id == $active_camp_id)>{{ $camp->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <table class="table mt-2" id="tbl_sheets"></table>

            <div class="d-flex justify-content-center">
                {{ $sheets->links() }}
            </div>
        </div>
    </div>

    @include('sheets.sheet_synced_modal')
    @include('sheets.edit_sheet_modal')

    <script src="{{ asset('js/sheet_view.js') }}"></script>
@endsection