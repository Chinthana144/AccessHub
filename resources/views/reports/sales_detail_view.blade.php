@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Sales Detail Report</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Select Camp</label>
                        <select name="cmb_camp" id="cmb_camp" class="form-select">
                            @foreach ($user_camps as $camp)
                                <option value="{{ $camp->camp->id }}">{{ $camp->camp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection