<!DOCTYPE html>
<html>
    <head>
        <title>Deviget PHP Challenge!</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://fgnass.github.io/spin.js/spin.min.js"></script>
        <script src="http://fgnass.github.io/spin.js/jquery.spin.js"></script>
        <script src="/static/js/main.js"></script>
        <link href="/static/css/main.css" rel="stylesheet" type="text/css">
        <!-- <script src="https://js.pusher.com/3.0/pusher.min.js"></script> -->
    </head>
    <body>
        <div class="container">
            <div class="content">
                @yield('content')
            </div>
        </div>
        <span id="jqueryData" data-csrftoken="{{ csrf_token() }}"></span>
    </body>
</html>
