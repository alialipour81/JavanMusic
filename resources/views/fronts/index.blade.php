@extends('layouts.app')
@section('title','جوان موزیک')
@section('content')

        <!--=================================
        Main Slider
        =================================-->
        @if($slider->count())
        <section class="custom-slider">
            <div id="home-slider" class="xv_slider flexslider">
                <ul class="slides">
                    @foreach($slider as $item)
                    <li class="xv_slide "  data-slidebg="url('{{ asset('storage/'.$item->image_background) }}')">
                        <div class="albumAction ">
                            <div class="container">
                                @if(!empty($item->title_button_black) && !empty($item->link_button_black))
                                <a  class="btn btn-dark text-uppercase text-bold title-post" href="{{ $item->link_button_black }}">
                                    <i class="fa fa-play"></i>  {{$item->title_button_black}}
                                </a>
                                @endif
                                    @if(!empty($item->title_button_green) && !empty($item->link_button_green))
                                <a  class="btn btn-default text-uppercase text-bold title-post" href="{{ $item->link_button_green }}">
                                    <i class="fa fa-eye"></i>  {{ $item->title_button_green }}
                                </a>
                                    @endif
                            </div>
                        </div>

                        <div class="flex-caption ">
                            <div class="container ">
                                <div class="row ">
                                    <div class="col-xs-12 col-sm-6 col-md-3 slide-visual">
                                        <figure class="fadeInLeft animated">
                                            <img src="{{ asset('storage/'.$item->image) }}" alt=""/>
                                        </figure>
                                    </div><!--column-->
                                    <div class="col-xs-12 col-sm-6 col-md-6 about-album">
                                        <div class="animated fadeInRight" dir="rtl">
                                            <h2 class="title-post">{{ $item->title }} </h2>
                                            <h6 class="title-post"> {{ $item->sub_title }}</h6>
                                            <p class="IranSans">
                                                {!! strip_tags(\Illuminate\Support\Str::limit($item->description)) !!}
                                            </p>
                                        </div>
                                    </div><!--column-->
                                </div><!--row-->
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>
        @endif
        <!--=================================
        Albums Section
        =================================-->
        <section>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">

                        </div>
                        <div class="col-xs-12 col-md-6">
                            <form class="search-widget" action="{{ route('musics') }}"  method="get">
                                <input type="text"  placeholder="نام آهنک  از آهنگ را واردکنید" name="musics" value="{{ request()->query('musics') }}">
                                <button><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </header><!--section header-->
            <div class="container" id="yourself-music">
                <div class="search-filters text-uppercase text-bold">
                    <div class="row" >
                        <div class="col-xs-12 col-sm-6 col-md-5">
                            <div class="searched-for title-post" >
                                <span class="s-keyword title-post"> جدیدترین موزیک ها</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-7 text-right">
                            <div class="search-actions">
                                <ul>
                                    <li><a class="title-post">آخرین بروزرسانی:</a></li>
                                    <li class="active title-post"><a >   {{ $last_update->updated_at->diffForhumans() }}</a></li>
                                </ul>
                                <ul>
                                    <li><a class="title-post">موزیک های امروز:</a></li>
                                    <li class="active"><a>{{ count($music_today) }} </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!--row-->
            </div><!--container-->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12" >
                        <div class="album-grid-wrap" dir="rtl">
                            <a href="#" class="album-control btn xv-prev"><i class="fa fa-angle-left"></i></a>
                            <a href="#" class="album-control btn bottom-right xv-next"><i class="fa fa-angle-right"></i></a>
                            <div class="album-grid text-uppercase clearfix">
                                @foreach($musics as $mus)
                                <a href="{{ route('music',$mus->slug) }}" class="album-unit" >
                                    <figure><img src="{{ asset('storage/'.$mus->image) }}" width="265" height="265" alt=""/>
                                        <figcaption class="new-musics" dir="ltr">
                                            <span class="title-post">   {{ $mus->artist->name }}</span>
                                            <h3 class="title-post">{{ $mus->name }}</h3>
                                        </figcaption>
                                    </figure>
                                </a>
                                @endforeach
                            </div><!--album-grid-->
                        </div><!--album-grid-wrap-->
                    </div><!--column-->
                </div><!--row-->
            </div><!--container-->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <a  class="btn btn-wide btn-grey text-uppercase text-bold shwo-all-musics" href="{{ route('musics') }}">  نمایش تمام موزیک ها</a>
                    </div>
                </div>
            </div>
        </section>
        <!--=================================================
        TOP songs /Trendding This week / Featured Songs
        ==================================================-->
        <section>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- null -->
                        </div>
                    </div>
                </div>
            </header><!--section header-->

            <div class="container">
                <div class="search-filters text-uppercase text-bold">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-5">
                            <a class="link link-grey p-music" href="#">پرطرفدارترین موزیک ها <i class="fa fa-music"></i></a>
                        </div>

                    </div><!--row-->
                </div>
            </div><!--container-->
            <!-- پرطرفدارترین موزیک ها -->
            <div class="container">
                <ul class="song-list text-uppercase text-bold clearfix">
                    @foreach($famous_music as $key=>$music)
                        @if($music->status == 1 && $key<10)
                     <li id="singleSongPlayer-{{ $key+1 }}" class="song-unit singleSongPlayer clearfix" data-before="{{ $key+1 }}">

                            <div id="singleSong-jplayer-{{ $key+4 }}" class="singleSong-jplayer title-post " data-title=" {{ $music->name }} "
                                 @if(!empty($music->quality_320))
                                     @if(filter_var($music->quality_320,FILTER_VALIDATE_URL))
                                         data-mp3="{{ $music->quality_320 }}"
                                 @else
                                     data-mp3="{{ asset('storage/'.$music->quality_320) }}"
                                 @endif
                                 @elseif(!empty($music->quality_128))
                                     @if(filter_var($music->quality_128,FILTER_VALIDATE_URL))
                                         data-mp3="{{ $music->quality_128 }}"
                                 @else
                                     data-mp3="{{ asset('storage/'.$music->quality_128) }}"
                                @endif
                                @endempty
                            >
                            </div>

                            <figure><img src="{{ asset('storage/'.$music->image) }}" alt="" width="265" height="265"/></figure>

                            <span class="playit controls jp-controls-holder">
                            <i class="jp-play pc-play"></i>
                            <i class="jp-pause pc-pause"></i>
                        </span>
                            <span class="song-title jp-title" ></span>
                            <span class="song-author title-post" data-before="خواننده:">  {{ $music->artist->name }}</span>
                            <span class="song-time jp-duration title-post" ></span>
                            <form action="{{ route('download.music',$music) }}" method="post">
                                @csrf
                                @method('PUT')
                                @if(!empty($music->quality_128))
                                    <button type="submit" class="song-btn title-post  b-danger btn-download" name="quality_128" value="quality_128"> کیفیت 128 <i class="fa fa-download"></i></button><br>
                                @endif
                                @if(!empty($music->quality_320))
                                    <button type="submit" class="song-btn title-post  b-danger btn-download" name="quality_320" value="quality_320"> کیفیت 320 <i class="fa fa-download"></i></button>
                                @endif
                            </form>

                            <div class="audio-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar" style="width:20%;"></div>
                                </div><!--jp-seek-bar-->
                            </div><!--audio-progress-->
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>

        </section>
        <!--=================================================

        ==================================================-->
        <section>
            <header class="style2" id="contents-weblog">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="text-uppercase">آخرین مطالب وبلاگ</h2>
                        </div>
                    </div>
                </div>
            </header><!--section header-->

            <div class="container">
                <div class="clearfix masonry-container">
                    @foreach($articles as $article)
                    <div class="ele-masonry">
                        <article>
                            <figure>
                                <img src="{{ asset('storage/'.$article->image) }}" alt="" width="509" height="252"/>
                            </figure>
                            <div class="about-article text-center text-uppercase">
                                <h3 ><a href="{{ route('article',$article->slug) }}" class="title-post">آهنگ جدید و قدیمی  </a></h3>
                                <span> {{ $article->created_at->diffForHumans() }} </span>
                            </div>

                            <p class="weblog-description" dir="rtl">{!!   strip_tags(\Illuminate\Support\Str::limit($article->description,500)) !!}</p>
                            <a href="{{ route('article',$article->slug) }}" class="btn btn-transparent text-uppercase text-semibold next-content"> ادامه مطلب</a>
                        </article>
                    </div>
                    @endforeach
                </div><!--row-->
                <a href="{{ route('blog') }}" class="btn btn-wide btn-grey text-uppercase text-bold go-to-weblog">رفتن به وبلاگ</a>
                <div class="mb-40"></div>
            </div><!--container-->

        </section>
        <!--=================================
        Events/concerts
        =================================-->
        <section>
            <header class="parallax parallax_two style3 text-center text-uppercase text-bold" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="title-post">آخرین  اطلاعیه حمایت ها</h2>
                            <p > با خیال راحت از خواننده مورد نظرتان در سایت خودش حمایت کنید :)    </p>
                        </div>
                    </div>
                </div>
            </header><!--section header-->
            @if($protections->count())
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="eventsSlider" data-nexttext="<i class='fa fa-arrow-right'></i>  بیشتر  " data-prevtext="<i class='fa fa-arrow-left'></i>   کمتر">
                            @foreach($protections as $protection)
                            <div class="event-unit-slide">
                                <div class="event-unit text-uppercase text-bold">
                                    <div class="time-date"><span class="title-post">{{ $protection->updated_at->diffForhumans() }}</span></div>
                                    <div class="event-info">
                                        <figure><img src="{{ asset('storage/'.$protection->image) }}" alt="" width="265" height="265"/></figure>
                                        <span><a class="eventTitle" href="{{ $protection->link }}"> {{ $protection->title }}</a></span>
                                    </div>
                                    <a href="{{ $protection->link }}" target="_blank" class="btn btn-danger title-post">حمایت</a>
                                </div><!--event-->
                            </div>
                            @endforeach
                        </div>
                    </div><!--column-->
                </div><!--row-->

                <div class="navigators text-bold text-uppercase text-center">
                    <div class="row">
                        <div class="col-xs-6">
                            <div id="prevEvents" class="sliderControls"></div>
                        </div>
                        <div class="col-xs-6">
                            <div id="nextEvents" class="sliderControls"></div>
                        </div>
                    </div>
                </div>

            </div><!--container-->
            @endif
        </section>

@endsection
