@extends('layouts.app')
@section('title',$music->name)
@section('content')
    <div class="pageArea">
        <!--=================================
        Search and navigator

        <!--=================================
        Blog Section
        =================================-->
        <div>
            <div class="container">
                <article class="articleSingle">
                    <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                            <h2 class="title-post title-music" align="center">  {{$music->name}} </h2>
                            <figure>
                                <img src="{{ asset('storage/'.$music->image) }}" alt=""/>
                            </figure>
                            <center>
                                <audio
                                    class="audio"
                                     @if(!empty($music->quality_320))
                                         @if(filter_var($music->quality_320,FILTER_VALIDATE_URL))
                                             src="{{ $music->quality_320 }}" type="audio/mpeg"
                                    @else
                                        src="{{ asset('storage/'.$music->quality_320) }}" type="audio/{{$music->format_320}}"
                                    @endif
                                    @else
                                        @if(filter_var($music->quality_128,FILTER_VALIDATE_URL))
                                            src="{{ $music->quality_128 }}" type="audio/mpeg"
                                    @else
                                        src="{{ asset('storage/'.$music->quality_128) }}" type="audio/{{$music->format_128}}"
                                    @endif
                                    @endif
                                    controls></audio>
                                <form  method="post" action="{{ route('download.music',$music) }}">
                                    @csrf
                                    @method('PUT')
                                    @if(!empty($music->quality_128))
                                        <button type="submit" name="quality_128" value="quality_128" class="btn-single-download title-post b-danger">
                                            دانلود با کیفیت 128<i class="fa fa-download"></i></button><br>
                                    @endif
                                        @if(!empty($music->quality_320))
                                        <button type="submit" name="quality_320" value="quality_320" class="btn-single-download title-post b-danger">
                                            دانلود با کیفیت 320<i class="fa fa-download"></i></button>
                                    @endif
                                </form>
                            </center>
                            <p dir="rtl" class="title-post music-text weblog-description" align="center" >{!! $music->text !!}</p>
                            <div class="col-xs-12 share-music">
                                <span class="title-post share-with"> اشتراک گذاری با:</span>
                                <ul class="social-list">
                                   {!! $share !!}
                                </ul>
                            </div>
                            @if($music->tags()->count())
                            <br><br><br><br>
                            <div class="tagcloud tags-music">
                                <span class="title-post "> برچسپ ها:</span>
                                @foreach($music->tags as $tag)
                                <a href="#" class="b-tag-music title-post">#{{$tag->name}}</a>
                                @endforeach
                            </div><!--tags-->
                            @endif
                            <div>
                                <span class="visit1 title-post">  <i class="fa fa-eye text-danger"></i>تعداد بازدید: {{$visits->count()}}</span>
                            </div>
                        </div><!--column-->
                    </div><!--row-->
                </article>
            </div><!--container-->
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                        @include('layouts.message')
                        <header class="style5 text-uppercase text-bold">
                            <h3 dir="rtl" class="title-post">نظر خود را بنویسید</h3>
                        </header>
                        <div dir="rtl">
                            @if($errors->any())
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li class="text-danger">{{  $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <form class="text-uppercase text-bold row" dir="rtl" method="post" action="{{ route('comment.store',$music->name) }}">
                            @csrf
                            @guest
                            <div class="col-xs-12 col-sm-6">
                                <div class="field-wrap">
                                    <label for="xv_name" class="title-post">نام شما </label>
                                    <input name="name" id="xv_name" type="text" value="{{ old('name') }}" />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="field-wrap">
                                    <label class="tranparent title-post" for="xv_email">ایمیل شما</label>
                                    <input name="email" class="tranparent" id="xv_email" type="text" value="{{ old('email') }}" />
                                </div>
                            </div>
                            @endguest
                            <div class="col-xs-12">
                                <div class="field-wrap textarea-wrap">
                                    <label for="xv_message_1" class="title-post">نوشتن نظر </label>
                                    <textarea name="text" id="xv_message_1" >{{ old('text') }}</textarea>
                                </div>
                            </div>
                            <div class="my-2">
                                <div id="reviewStars-input">
                                    <input id="star-4" type="radio" name="star" value="5"/>
                                    <label title="عالی" for="star-4"></label>

                                    <input id="star-3" type="radio" name="star" value="4"/>
                                    <label title="خوب" for="star-3"></label>

                                    <input id="star-2" type="radio" name="star" value="3"/>
                                    <label title="متوسط" for="star-2"></label>

                                    <input id="star-1" type="radio" name="star" value="2"/>
                                    <label title="قابل قبول" for="star-1"></label>

                                    <input id="star-0" type="radio" name="star" value="1" />
                                    <label title="ضعیف" for="star-0"></label>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="music">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-wide btn-dark btn-send-comment" type="submit">ارسال نظر </button>
                            </div>
                        </form>

                    </div><!--column-->
                </div><!--row-->
            </div>
        </section>

        <section class="mt-50 mb-100" dir="rtl">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                        <header class="style5 text-uppercase text-bold">
                            <h3 class="title-post">همه نظرات({{$comments->count()}}) </h3>
                        </header>


                        <ol class="comment-list" >
                            @empty(!$average)
                                <h4> امتیاز {{round($average,1)}} از 5</h4>
                                @for($j=0;$j<floor($average);$j++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                            @endempty
                           @forelse($comments as $comment)
                            <li id="li-comment-11" class="comment media" dir="rtl">
                                <a class="author_avatar" href="#">
                                    <img class="avatar" @if($comment->email ==null)
                                        @if($comment->user->image == null) src="{{Gravatar::get($comment->user->email) }}" @else src="{{ asset('storage/'.$comment->user->image) }}" @endif
                                         @else src="{{Gravatar::get($comment->email) }}" @endif  alt="">
                                </a>
                                <div class="comment-inner">
                                    <h4 class="media-heading comment-author vcard title-post"><cite class="fn">
                                           @if($comment->name == null)  {{ $comment->user->name }} @else {{ $comment->name }} @endif
                                            <span class="label text-gray">{{ $comment->created_at->diffForhumans() }} </span>  </cite> </h4>
                                    <span class="meta commentTimeStamp">
                                         </span>
                                    <div class="media-body">
                                        <p class="title-post">{!! nl2br($comment->text) !!}</p>
                                    </div>
                                </div>
                                <div>
                                    @for($j=0;$j<$comment->star;$j++)
                                        <i class="fa fa-star star-bg-gold"></i>
                                    @endfor
                                </div>
                             @if($comment->replies()->count())
                                <ol>
                                    @foreach($comment->replies as $reply)
                                    <li id="li-comment-14" class="comment media">
                                        <a class="author_avatar" href="#">
                                            <img class="avatar"
                                                 @if($reply->email ==null)
                                                     @if($reply->user->image == null) src="{{Gravatar::get($reply->user->email) }}" @else src="{{ asset('storage/'.$reply->user->image) }}" @endif
                                                 @else src="{{Gravatar::get($reply->email) }}" @endif  alt="">
                                        </a>
                                        <div class="comment-inner">
                                            <h4 class="media-heading comment-author vcard title-post "> <cite class="fn ">    @if($reply->name == null)  {{ $reply->user->name }} @else {{ $reply->name }} @endif  <span class="label text-gray"> {{ $reply->created_at->diffForhumans() }}   </span> </cite> </h4>
                                            <div class="media-body">
                                                <p class="title-post">{!! nl2br($reply->text) !!}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                                @endif

                            </li>
                            @empty
                               <div class="alert alert-success">نظری برای این موزیک وجود ندارد</div>
                            @endforelse

                        </ol>


                    </div><!--column-->
                </div><!--row-->
            </div>
        </section>
    </div>

@endsection
@section('link_css')
    <link rel="stylesheet" href="{{ asset('khodam/css/star.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossOrigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
@endsection
