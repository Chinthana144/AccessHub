@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Sales Detail Report</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('report.salesDetails') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Select Camp</label>
                        <select name="cmb_camp" id="cmb_camp" class="form-select">
                            @foreach ($user_camps as $camp)
                                <option value="{{ $camp->camp->id }}" @selected($camp_id == $camp->camp->id)>{{ $camp->camp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ isset($start_date) ? $start_date : '' }}">
                    </div>

                    <div class="col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ isset($end_date) ? $end_date : '' }}">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-primary mt-4">Search</button>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <button type="submit" name="action" value="pdf" class="btn btn-primary">Generate PDF</button>
                    </div>
                    {{-- <div class="col-md-3">
                        <button type="submit" name="action" value="excel" class="btn btn-success">Generate Excel</button>
                    </div> --}}
                </div>
            </form>

            @if (isset($data))
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Room No</th>
                        <th>Amount</th>
                    </tr>
                    @foreach ($data as $dt)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dt['issue_date'] }}</td>
                            <td>{{ $dt['username'] }}</td>
                            <td>{{ $dt['password'] }}</td>
                            <td>{{ $dt['customer_name'] }}</td>
                            <td>{{ $dt['room_no'] }}</td>
                            <td>{{ $dt['amount'] }}</td>
                        </tr>
                    @endforeach
                </table>
                
            @endif
        </div>
    </div>
@endsection