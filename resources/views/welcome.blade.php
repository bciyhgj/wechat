<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>扫码</title>

        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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
                height: 100vh;
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
                font-size: 84px;
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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <img id="qrcode" src="" class="img-responsive">
                </div>
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Note!</strong> 扫描后需要关注公众平台测试号，可以过后自行取消关注。
                    </div>
                </div>
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="alert alert-info hide" role="alert" id="connect-info">
                        <strong>Well done!</strong> 连接成功.
                    </div>
                </div>
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="alert alert-success hide" role="alert" id="scan-info">
                        <strong id="username"></strong> 登录成功. 欢迎关注我的公众号～
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script>
            const socket = new WebSocket("{{ config('swoole-wechat.ws') }}");
            socket.addEventListener('open', function (event) {
                $('#connect-info').removeClass('hide');
            });
            socket.addEventListener('message', function (event) {
                var data = JSON.parse(event.data);
                console.log(data);
                if (data.message_type == 'qrcode_url'){
                    $('#qrcode').attr('src', data.url);
                }
                if (data.message_type == 'scan_success'){
                    $('#scan-info').removeClass('hide');
                    $('#username').text(data.user);
                    $('#qrcode').attr('src', '/images/qrcode_for_gh_72b6109b62cf_430.jpg');
                }
            });
        </script>

    </body>
</html>
