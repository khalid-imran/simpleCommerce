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
    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '646929627418669');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=646929627418669&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->
    <script>
        // window.fbAsyncInit = function() {
        //     FB.init({
        //         xfbml            : true,
        //         version          : 'v12.0'
        //     });
        // };
        //
        // (function(d, s, id) {
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s); js.id = id;
        //     js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));
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
<script src="{{ asset('js/frontend/app.js?v=2.0') }}"></script>
<!-- Main JS -->
<script src="{{asset('frontend/js/main.js')}}"></script>

</body>
</html>
