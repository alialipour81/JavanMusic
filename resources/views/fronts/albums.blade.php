@extends('layouts.app')
@section('title','آلبوم ها')
@section('content')
        <!--=================================
        Albums Section
        =================================-->
        <section>
            <div class="container mt-30 mb-30 hidden-xs">
                <div class="row">
                    <div class="col-xs-12">
                        <form class="search-widget" action="{{ route('albums') }}" method="get">
                            <input type="text"  placeholder="نام آلبوم موردنظر را واردکنید" name="albums" value="{{ request()->query('albums') }}">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div><!--container-->

            <div class="container">
                <div class="search-filters text-uppercase text-bold">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-5">
                            <div class="searched-for" >
                                <span class="s-keyword">همه آلبوم ها </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-7 text-right">
                            <div class="search-actions update-album">
                                <ul>
                                    <li><a > آخرین بروزرسانی:</a></li>
                                    <li class="active "><a>{{ $last_update->updated_at->diffForHumans() }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!--row-->
            </div><!--container-->

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="album-grid-wrap style2">
                            <div class="album-grid text-uppercase clearfix">
                                @foreach($albums as $album)
                                <a href="{{ route('album',$album->slug) }}" class="album-unit">
                                    <figure><img src="{{ asset('storage/'.$album->image) }}" width="265" height="265" alt=""/>
                                        <figcaption>
                                            <span class="weblog-description"> {{ $album->artist->name }}  </span>
                                            <h3 class="title-post">{{ $album->name }} </h3>
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
                        <nav>
                            <ul class="pagination" >
                             {{ $albums->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div><!--container-->
        </section>
@endsection
