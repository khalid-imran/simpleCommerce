<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/icons.min.css')}}">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <!-- loader-->
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <title>Diivaa</title>
    <script>
        window.APP_URL = '{{ env('APP_URL') }}';
    </script>
</head>

<body>
<!--wrapper-->
<div id="app">
    <app></app>
</div>
<!--end wrapper-->
<script src="{{asset('frontend/js/modernizr-3.11.7.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-v3.6.0.min.js')}}"></script>
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/plugins.js')}}"></script>
<!--app JS-->
<script src="{{ asset('js/frontend/app.js?v=1.3') }}"></script>
<!-- Main JS -->
<script src="{{asset('frontend/js/main.js')}}"></script>

</body>
</html>
