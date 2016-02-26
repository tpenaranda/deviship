<!DOCTYPE html>
<html>
    <head>
        <title>Deviget PHP Challenge!</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="/static/js/pusher.min.js"></script>
        <script src="/static/js/main.js"></script>
        <link href="/static/css/main.css" rel="stylesheet" type="text/css">
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
