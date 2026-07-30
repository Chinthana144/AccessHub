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
            <th>Username</th>
            <th>Password</th>
            <th>Name</th>
            <th>Room No</th>
            <th>Amount</th>
        </tr>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dt->issue_date }}</td>
                <td>{{ $dt->username }}</td>
                <td>{{ $dt->password }}</td>
                <td>{{ $dt->customer_name }}</td>
                <td>{{ $dt->room_no }}</td>
                <td>{{ $dt->amount }}</td>                
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <td style="text-align: right" colspan="6">Total</td>
                <td><b>{{ $data->sum('amount') }}</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>