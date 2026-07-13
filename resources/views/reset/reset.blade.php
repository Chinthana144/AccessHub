<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code Reset</title>

    <link rel="stylesheet" href="{{ asset('css/common_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset_page.css') }}">

</head>
<body>
    <div id="div_main">

        <h4>Code Reset</h4>

        <div id="main_row">
            <div id="div_reset_control" class="row_column">

                <div class="row_card">
                    <h5>Code Control</h5>

                    <label for="" class="input_label">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="input">
                        @foreach ($user_camps as $camp)
                            <option value="{{ $camp->camp->id }}">{{ $camp->camp->name }}</option>
                        @endforeach
                    </select>

                    <label for="" class="input_label">Username</label>
                    <input type="text" name="username" id="username" class="input">

                    <div id="button_row">
                        <button id="btn_fetch_user" class="btn_input">Fetch User</button>
                        <button id="btn_reset_user" class="btn_input">Reset</button>
                        <br>
                        <button id="btn_disable_user" class="btn_input">Disable</button>
                        <button id="btn_enable_user" class="btn_input">Enable</button>
                    </div>

                </div>
                
            </div>
            <div id="reset_content" class="row_column">
                <div class="row_card">
                    <h5>Details</h5>
                    <div id="div_identity"></div>

                    <input type="hidden" id="end_time" value="">

                    <div id="loader" class="loader-hidden"></div>

                    <div id="div_content"></div>
                    <p id="p_countdown"></p>
                </div>               
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/reset.js') }}"></script>
</body>
</html>