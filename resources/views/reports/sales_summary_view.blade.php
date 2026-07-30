@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Sale Summary Report</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('report.saleSummary') }}" method="get">
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
                        <th>30 AED</th>
                        <th>15 AED</th>
                        <th>Free</th>
                        <th>Total</th>
                    </tr>
                    @php
                        $total_30 = 0;
                        $total_15 = 0;
                        $free = 0;
                        $total_count = 0;
                    @endphp
                    @foreach ($data as $dt)
                        @php
                            $total_30 += $dt[1];
                            $total_15 += $dt[2];
                            $free += $dt[3];
                            $total_count += $dt[4];
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dt[0] }}</td>
                            <td>{{ $dt[1] }}</td>
                            <td>{{ $dt[2] }}</td>
                            <td>{{ $dt[3] }}</td>
                            <td>{{ $dt[4] }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="2">Totals</td>
                            <td>{{ $total_30 }}</td>
                            <td>{{ $total_15 }}</td>
                            <td>{{ $free }}</td>
                            <td>{{ $total_count }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>
@endsection