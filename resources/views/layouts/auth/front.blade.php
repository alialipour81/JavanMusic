<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>  @yield('title')</title>
    <!-- Styles -->
    <link type="text/css" href="{{ asset('auth/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('auth/css/style.css') }}" rel="stylesheet" />
    <!-- /Styles -->
</head>
<body class="rtl">
<div class="container register">
    <div class="row">
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('auth/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>
<!-- /Scripts -->

</body><!-- This template has been downloaded from Webrubik.com -->
</html>
