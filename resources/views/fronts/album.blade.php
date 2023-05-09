@extends('layouts.app')
@section('title',$album->name .'-'.$album->artist->name)
@section('content')
    <!--=================================
    Albums
    =================================-->

    <section class="album-header">
        <figure class="album-cover-wrap">
            <div class="album-cover_overlay"></div>
            <img class="album-cover" src="{{ asset('storage/'.$album->image_background) }}" alt="" data-stellar-ratio="0.5">
        </figure>
        <div class="container">
            <div class="cover-content">
                <hr>
                <div class="clearfix text-uppercase album_overview">
                    <figure class="album-thumb">
                        <img src="{{ asset('storage/'.$album->image) }}" alt="">
                    </figure>
                    <h1 class="title-post title-album">{{ $album->name }} </h1>
                    <cite class="album-author mb-20 IranSans title-album text-light"> {{ $album->artist->name }} </cite>
                    @foreach($album->categories as $category)
                        <a class="btn btn-transparent-2 btn-tag IranSans" href="#">{{ $category->name }} </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="mt-100 mb-50">

        <div class="container">
            <ul class="song-list text-uppercase text-bold clearfix list-music">
                @foreach($album->musics as $key=>$music)
                <li id="singleSongPlayer-{{ $key+1 }}" class="song-unit singleSongPlayer clearfix" data-before="{{ $key+1 }}" >

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
                @endforeach

            </ul>
        </div>

    </div>

    <!--=================================
    Similar Album Content
    =================================-->
    @if($albums->count())
    <section class="mt-50 mb-100">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="text-uppercase title-post" dir="rtl">آلبوم های دیگر این خواننده</h2>
                    </div>
                </div>
            </div>
        </header><!--section header-->

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="store-grid text-uppercase text-bold store-grid-slider">
                            @foreach($albums as $alb)
                                <div class="store-product">
                                    <figure>
                                        <img src="{{ asset('storage/'.$alb->image) }}"/>
                                        <figcaption>
                                            <a class="btn btn-grey title-post" href="{{ route('album',$alb->slug) }}">مشاهده<i class="fa fa-eye"></i> </a>
                                        </figcaption>
                                    </figure>
                                    <div class="product-info">
                                        <h3 class="title-post">{{ $alb->name }} </h3>
                                        <h6 class="title-post">{{ $alb->artist->name }} </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div><!--album-grid-->
                    </div><!--column-->
                </div><!--row-->


            </div><!--container-->
        @endif

    </section>
@endsection
