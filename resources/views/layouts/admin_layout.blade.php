<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <div class="d-flex p-1">        
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">Home</a>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-primary btn-sm ms-1">Admin</a>
        <a href="{{ route('admin.session') }}" class="btn btn-outline-primary btn-sm ms-1">Sessions</a>
        <a href="{{ route('generator.index') }}" class="btn btn-outline-primary btn-sm ms-1">Generator</a>
    </div>

    @yield('content')
</body>
</html>