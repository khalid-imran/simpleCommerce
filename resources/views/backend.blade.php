<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Diivaa Admin</title>
    <script>
        window.APP_URL = '{{ env('APP_URL') }}';
    </script>
</head>

<body>
<!--wrapper-->
<div class="wrapper" id="app">
    <app></app>
</div>
<!--end wrapper-->
<!-- Bootstrap JS -->
<!--plugins-->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>
<!--app JS-->
<script src="{{ asset('/js/backend/app.js?v=0.0.1') }}"></script>
</body>
</html>
