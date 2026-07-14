<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code Reset</title>
    <link rel="stylesheet" href="{{ asset('css/reset_login.css') }}">
</head>
<body>
    <div id="div_login">
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div id="login_card">
            <h4>Code Reset</h4>
            <div id="div_logo">
                <img src="{{ asset('images/com_logo_2.png') }}" alt="">
            </div>
            <form action="{{ route('reset.login') }}" method="post">
                @csrf
                <label for="">Username (Email)</label>
                <input type="text" name="username" class="login_input">

                <label for="">Password</label>
                <input type="password" name="password" class="login_input">

                <input type="checkbox" id="chk_password" name="chk_password" value="yes">
                <label for="chk_password">Show Password</label>

                <button type="submit" id="btn_login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>