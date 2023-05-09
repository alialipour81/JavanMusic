@extends('layouts.app')
@section('title',' بلاگ جوان موزیک')
@section('content')
    <!--=================================
    Blog Section
        =================================-->
    <section>

        <header class="style4">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 d-flex">
                        <h2 class="IranSans title-real-weblog"> وبلاگ جوان موزیک</h2>
                        <form class="search-widget" method="get" action="{{ route('blog') }}">
                            <input type="text"  placeholder="نام مقاله را بنویسید" name="article" value="{{ request()->query('article') }}">
                            <button><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </header><!--section header-->

        <div class="container">
            <div class="row">
                @foreach($articles as $article)
                <div class="blog-wrapper">
                    <article>
                        <figure>
                            <img src="{{ asset('storage/'.$article->image) }}" alt="" width="509" height="252"/>
                        </figure>
                        <div class="about-article text-center text-uppercase">
                            <h2><a href="{{ route('article',$article->slug) }}" class="title-post">  {{ $article->title }}  </a></h2>
                            <span dir="rtl"><i class="fa fa-clock-o"></i> {{ $article->created_at->diffForHumans() }}  </span>
                        </div>
                        <p class="weblog-description">{!!   strip_tags(\Illuminate\Support\Str::limit($article->description,500)) !!}</p>
                        <a href="{{ route('article',$article->slug) }}" class="btn btn-transparent text-uppercase text-semibold next-content"> ادامه مطلب</a>
                        <ul class="article-meta">
                            <li><a href="{{ route('article',$article->slug) }}" ><i class="fa fa-comments-o"></i> <span class="comments-count">{{ $article->comments($article)->count() }}</span></a></li>
                            <li><a href="{{ route('article',$article->slug) }}" ><i class="fa fa-eye"></i> <span class="comments-count">{{ $article->get_visit($article->id)->count() }}</span></a></li>
                        </ul>
                    </article>
                </div>
                @endforeach
            </div><!--row-->
            {{ $articles->links() }}
        </div><!--container-->

    </section>

@endsection
