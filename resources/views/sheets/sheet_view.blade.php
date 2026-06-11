@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Sheets
                <button class="btn btn-primary btn-sm float-end" id="btn_sync_sheets">Synchronize</button>
            </h5>
        </div>
        <div class="card-body">
            <p>content {{ $camp->name }}</p>
        </div>
    </div>

    @include('sheets.sheet_synced_modal')

    <script src="{{ asset('js/sheet_view.js') }}"></script>
@endsection