<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trizent Infratech</title>
    <link rel="stylesheet" href="{{ asset('css/camp_portal.css') }}">
</head>
<body>
    <div id="div_top_bar">
        <h4>Camp Portal</h4>
    </div>
    <div id="div_content">
        @foreach ($user_camps as $user_camp)
            <a href="/goto_camp/{{$user_camp->camp->id}}" class="camp_link">
                <div class="camp_card">
                    <h4>
                        {{ $user_camp->camp->name }}
                    </h4>
                </div>
            </a>
        @endforeach
    </div>
    
</body>
</html>