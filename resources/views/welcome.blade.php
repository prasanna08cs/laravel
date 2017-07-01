<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 70vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 64px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .error{
                border:1px solid #a94442
            }
            #error{
                font-size:1.8rem;
                font-weight:300;
                min-height:3rem
            }
            .result{
                margin: 2rem 0;
                padding: 1rem;
                font-size: 2rem;
                font-weight: 400;
                border: 1px solid #ddd;
                border-radius: 0.4rem;
                display:none
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                   {{ config('app.name') }}
                </div>

                <div class="col-xs-12 col-md-offset-2 col-md-8">
                    <div class="text-danger" id="error">
                    </div>
                    <div class="input-group">
                    <input type="text" class="form-control" id='url' placeholder="Paste your URL here...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="shortenButton">Shorten</button>
                    </span>
                    </div><!-- /input-group -->

                    <div class="result">
                
                    </div>
                </div>
               
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/js/app.js"></script>
        <script>
        /*
        *   Shorten Button Click        
        */

        $('#shortenButton').on('click', function(){
            
            $('.result').css('display', 'none');
            var url = $('#url').val();
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            if(!regexp.test(url)){
               $('#error').html('Enter a valid URL');
               $('#url').addClass('error');
               $(this).addClass('btn-danger');
            }else{
                $(this).removeClass('btn-danger').addClass('btn-success');
                $('#url').removeClass('error');
                $('#error').html('');
                $('.result').slideDown('fast');
                $('.result').html('Processing...');
               $.ajax({
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                   url: 'urlShortener',
                   type: 'post',
                   data: { url: url },
                   dataType: 'json'
               }).done(function(response){
                    $('.result').html(
                        'Shortened URL : <a href="'+response+'">'+response+'</a>'
                    );
               }).fail(function(Error){
                    $('#url').addClass('error');
                    $('#shortenButton').removeClass('btn-success').addClass('btn-danger');
                    $('#error').html('The URL provided for shortening is not valid or currently unavailable.');
               });
            } 
        })
        </script>
    </body>
</html>
