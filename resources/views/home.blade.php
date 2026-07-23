@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <div id="div_top">
        <div class="div_box" id="div_sale_box">
            <h6>Daily Sales</h6>
            <i class="bx bx-bar-chart fs-3"></i>
            <h4>{{ $daily_sale }} AED</h4>
        </div>
        <div class="div_box" id="div_code_count">
            <h6>Codes</h6>
            <i class="bx bx-clipboard fs-3"></i>
            <h4>{{ $daily_code_count }}</h4>
        </div>
        <div class="div_box" id="div_month_sale_box">
            <h6>Monthly Sales</h6>
            <i class="bx bx-book-bookmark fs-3"></i>
            <h4>{{ $month_sale }} AED</h4>
        </div>
        <div class="div_box" id="div_month_code_count">
            <h6>Monthly Codes</h6>
            <i class="bx bx-file fs-3"></i>
            <h4>{{ $month_code_count }}</h4>
        </div>
    </div>

    <div id="div_content">
        <div id="div_chart">
            pastha...
        </div>
    </div>

    <script src="{{ asset('js/home.js') }}"></script>
@endsection