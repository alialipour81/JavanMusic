@extends('layouts.app')
@section('title','موزیک ها')
@section('content')
    <section>
        <div class="container mt-30 mb-30 hidden-xs">
            <div class="row">
                <div class="col-xs-12">
                    <form class="search-widget" method="get" action="{{ route('musics') }}">
                        <input type="text"  placeholder="نام آهنگ موردنظر را واردکنید" name="musics" value="{{ request()->query('musics') }}">
                        <button><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div><!--container-->

        <div class="container">
            <div class="search-filters text-uppercase text-bold">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-5">
                        <div class="searched-for" >
                            <span class="s-keyword title-post"> همه موزیک ها  </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-7 text-right">
                        <div class="search-actions">
                            <ul>
                                <li><a class="title-post">آخرین بروزرسانی:</a></li>
                                <li class="active title-post"><a > {{ $last_update->updated_at->diffForHumans() }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--row-->
        </div><!--container-->

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="store-grid text-uppercase text-bold">
                        @foreach($musics as $music)
                        <div class="store-product">
                            <figure>
                                <img src="{{ asset('storage/'.$music->image) }}"  />
                                <figcaption>
                                    <a class="btn btn-grey" href="{{ route('music',$music->slug) }}">دانلود موزیک<i class="fa fa-download"></i> </a>
                                </figcaption>
                            </figure>
                            <div class="product-info">
                                <h3 class="title-post">   {{ $music->name }}</h3>
                                <h6 class="title-post">{{ $music->artist->name }}</h6>
                            </div>
                        </div>
                        @endforeach
                    </div><!--album-grid-->
                </div><!--column-->
            </div><!--row-->
        </div><!--container-->

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <nav>
                        <ul class="pagination" >
                         {{ $musics->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </section>
@endsection
