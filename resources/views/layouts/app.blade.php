<!DOCTYPE html>
<!--[if lte IE 9]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title> @yield('title')</title>
    <!--=================================
    Meta tags
    =================================-->
    <meta name="description" content="">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no"/>
<link href="http://fonts.googleapis.com/css?family=Lato:400,900,700,400italic,300,700italic" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flexslider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animations.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dl-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.datetimepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.bxslider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

<script src="{{ asset('assets/js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    @yield('link_css')
</head>
<body dir="rtl">


<!--===============================
Preloading Splash Screen
===================================-->
<div class="pageLoader"></div>

<div class="majorWrap">

<header id="sticktop" class="doc-header">

    <!--========================================
    Radio Stream
    ===========================================-->
    <div id="audio-player-radio" class="jp-radioPlayer" data-radio-url="http://listen.radionomy.com/abc-jazz" data-title="Streaming Radio Station ABC Jazz">
        <div class="container">
            <div id="player-instance-radio" class="jp-jplayer"></div>
            <div class="controls jp-controls-holder">
                <div class="play-pause jp-play pc-play"></div>
                <div class="play-pause jp-pause fa pc-pause" style=" display:none"></div>
            </div>
            <div class="jp-volume-controls">
                <button class="sound-control pc-volume jp-mute"></button>
                <button class="sound-control pc-mute jp-unmute"></button>
                <div class="jp-volume-bar" style="display: none;">
                    <div class="jp-volume-bar-value" style="width: 1.4737%;"></div>
                </div>
            </div>


            <div class="music_pseudo_bars">
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
                <div class="music_pseudo_bar"></div>
            </div>
        </div>
    </div>


    <!--========================================
    Nav
    ===========================================-->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">
                    <img src="assets/img/basic/logo.png" alt=""/>
                </a>
            </div>

            <div id="dl-menu" class="radio-style xv-menuwrapper responsive-menu">
                <button class="menuTrigger"><i class="fa fa-navicon"></i></button>
                <div class="clearfix"></div>
                <ul class="dl-menu">

                    @auth
                        <li><a href="{{ route('dashboard.index') }}"> داشبورد </a></li>
                    @else
                        <li><a href="{{ route('register_login') }}">  ورود | ثبت نام </a></li>
                    @endauth
                        <li><a href="{{ route('musics') }}">  موزیک ها</a></li>
                        <li><a href="{{ route('blog') }}">وبلاگ</a></li>
                        <li><a href="{{ route('albums') }}"> آلبوم ها</a></li>
                        <li><a href="{{ route('index') }}"> خانه</a></li>


                </ul>
            </div><!-- /dl-menuwrapper -->
        </div>
    </nav>
</header>

<div id="ajaxArea">
    @yield('content')
</div>

<footer class="doc-footer text-uppercase text-center">
    <div class="container">
        <ul class="social-list style2 circular">
            <li><a href="#" class="fa fa-facebook"></a></li>
            <li><a href="#" class="fa fa-twitter"></a></li>
            <li><a href="#" class="fa fa-google-plus"></a></li>
            <li><a href="#" class="fa fa-tumblr"></a></li>
            <li><a href="#" class="fa fa-instagram"></a></li>
            <li><a href="#" class="fa fa-dribbble"></a></li>
            <li><a href="#" class="fa fa-tumblr"></a></li>
            <li><a href="#" class="fa fa-vimeo"></a></li>
        </ul>
        <div class="row">
            <div class="col-xs-12">
                <strong>&copy; Music javan created at 2022</strong>
                <p class="title-post">تمام حقوق این وبسایت محفوظ است</p>
            </div>
        </div>
    </div>
</footer>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/ajaxify.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.downCount.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/jplayer/jquery.jplayer.min.js') }}"></script>
    <script src="{{ asset('assets/js/jplayer/jplayer.playlist.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waitforimages.js') }}"></script>
    <script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/packery.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/tweetie.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.bxslider.min.js') }}"></script> <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&#038;sensor=false&#038;ver=3.0'></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
