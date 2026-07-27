@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Sales Reports</h5>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-3">
                    <a href="/salesDetailReport" class="btn btn-primary">Daily Sales Report</a>
                </div>  
            </div>
        </div>
    </div>
@endsection