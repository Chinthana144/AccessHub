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
            <table class="table" id="tbl_sheets">
                <tr>
                    <th>Sheet Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Last Sync</th>
                    <th>Codes</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($sheets as $sheet)
                    <tr data-id={{$sheet->id}}>
                        <td>{{ $sheet->name }}</td>
                        <td>{{ $sheet->start_date }}</td>
                        <td>{{ $sheet->end_date }}</td>
                        <td>{{ $sheet->last_synced_at }}</td>
                        <td>
                            @if ($sheet->has_data == 1)
                                <p class="badge badge-success bg-success">Code</p>
                            @else
                                <span class="badge badge-secondary bg-secondary">No Codes</span>
                            @endif
                        </td>
                        <td>
                            @if ($sheet->status == 1)
                                <span class="badge bg-success">Active</span>                                
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning btn_edit_sheet">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="d-flex justify-content-center">
                {{ $sheets->links() }}
            </div>
        </div>
    </div>

    @include('sheets.sheet_synced_modal')
    @include('sheets.edit_sheet_modal')

    <script src="{{ asset('js/sheet_view.js') }}"></script>
@endsection