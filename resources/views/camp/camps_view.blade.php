@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Camps
                @can('create', App\Models\Camps::class)
                    <button class="btn btn-primary btn-sm float-end" id="btn_add_camp">Add Camp</button>
                @endcan
            </h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table" id="tbl_camps">
                <tr>
                    <th>Camp</th>
                    <th>Contact</th>
                    <th>Mikrotik</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($camps as $camp)
                    <tr data-id="{{ $camp->id }}">
                        <td>
                            {{ $camp->name }} <br>
                            {{ $camp->address }}
                        </td>
                        <td>
                            {{ $camp->contactPerson }} <br>
                            {{ $camp->contactNo }}
                        </td>
                        <td>
                            {{ $camp->mikrotikHost }} <br>
                            {{ $camp->mikrotikPort }}
                        </td>
                        <td>
                            @if ($camp->is_upload)
                                <span class="badge bg-success">Upload Sheet</span>                                
                            @else
                                <span class="badge bg-secondary">No Upload</span>
                            @endif
                            <br>
                            @if ($camp->status)
                                <span class="badge bg-success">Active</span>                                
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-outline-warning btn-sm btn_edit_camp">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="d-flex justify-content-center">
                {{ $camps->links() }}
            </div>
        </div>
    </div>

    @include('camp.camp_add_modal')
    @include('camp.camp_edit_modal')

    <script src="{{ asset('js/camps.js') }}"></script>
    
@endsection