<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Detail Report</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        th{
            text-align: left;
        }
        #tbl_data td, th{
            border: 1px solid black;
            padding: 4px;
        }
        h2, h5{
            margin:0px 20px;
        }
        #img_logo{
            width: 80%;
            margin: 5px;
            padding: 10px;
            border-radius: 10px;
            background-color: rgb(10, 10, 94);
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td width='20%'>
                <img src="{{ public_path('images/trizent_logo.png') }}" alt="Logo" id="img_logo">
            </td>
            <td>
                <h2>Trizent Infratech</h2>
                <h5>Sales Detail Report</h5>
                <h5>Camp: {{ $camp->name }}</h5>
            </td>
        </tr>
    </table>    
    <p>Sales Details Report from {{ $start_date }} to {{ $end_date }}</p>

    <table id="tbl_data">
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
</body>
</html>