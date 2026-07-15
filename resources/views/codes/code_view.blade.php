@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Codes</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        <option value="0">--- Select Camp ---</option>
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->camp->id }}">{{ $camp->camp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">Search</label>
                    <input type="text" name="txt_search" id="txt_search" class="form-control">
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn_search" class="btn btn-primary mt-4 w-100">Search</button>
                </div>
            </div>

            <div id="div_content">
                <div id="div_table">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Name</th>
                            <th>Room No</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($codes as $code)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $code->issue_date }}</td>
                                <td>{{ $code->username }}</td>
                                <td>{{ $code->password }}</td>
                                <td>{{ $code->customer_name }}</td>
                                <td>{{ $code->room_no }}</td>
                                <td>{{ $code->amount }}</td>
                                <td>{{ $code->note }}</td>
                                <td>
                                    <button class="btn btn-outline-warning btn-sm"><i class="bx bx-edit"></i></button>
                                    <button class="btn btn-outline-danger btn-sm"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $codes->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection