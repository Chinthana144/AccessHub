@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Testing Page</h5>
        </div>
        <div class="card-body">
            <p>content</p>

            <div class="container container-md">
                <form action="{{ route('test.sheetNames') }}" method="post">
                @csrf

                <input type="text" name="code" class="form-control">

                <button class="btn btn-primary">Click</button>
            </form>
            </div>
            
        </div>
    </div>
@endsection