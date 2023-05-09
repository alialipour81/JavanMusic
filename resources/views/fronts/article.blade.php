@extends('layouts.app')
@section('title',$article->title)
@section('content')
    <div class="pageArea">
        <!--=================================
        Search and navigator
        =================================-->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="blogNavigator clearfix">
                        <a class="btn btn-default btnBackto" href="{{ route('blog') }}"><i class="fa fa-chevron-circle-left"></i> بازگشت به وبلاگ </a>
                    </div><!--blogNavigator-->
                </div><!--column-->
            </div>
        </div>
        <!--=================================
        Blog Section
        =================================-->
        <div>
            <div class="container">
                <article class="articleSingle">
                    <div class="row">
                        <div class="col-xs-12">
                            @if($article->status == 0)
                               <br> <div class="alert alert-info IranSans">شما این مقاله را در حالت آزمایشی میبینید</div>
                            @endif
                            <div class="about-article text-center text-uppercase">
                                <h2 class="title-post"> {{ $article->title }}</h2>
                                <span dir="rtl" class="timeStamp"><i class="fa fa-clock-o"></i>  {{ $article->created_at->diffForHumans() }} </span>
                                @if($article->status != 0)
                                <ul class="social-list" title="اشتراک گذاری">
                                  {!! $share !!}
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                            <figure>
                                <img src="{{ asset('storage/'.$article->image) }}" alt=""/>
                            </figure>
                            <p dir="rtl" class="weblog-description weblog-text">{!! $article->description !!}</p>
                            @if($article->tags()->count())
                            <div class="tagcloud">
                                <span class="title-post">برچسپ ها: </span>
                                @foreach($article->tags as $tag)
                                <a  @if($article->status != 0) href="#" @endif class="b-tag title-post">#{{$tag->name}}</a>
                                @endforeach
                            </div><!--tags-->
                                @endif
                            <div>
                                <span class="nevisandegan nevisandeh-margin-right"> <i class="fa fa-pencil"></i> نویسندگان: </span>
                                @php $other_users_sub = explode('-',$article->other_users_sub); @endphp
                                <span class="nevisandeh">{{ $article->user->name }}</span>
                                @foreach($other_users_sub as $user)
                                    @if(strpos($article->other_users_acc,$user.'A'))
                                        <span class="nevisandeh">{{ $article->info_user($user)->name }}</span>
                                    @endif
                                @endforeach
                            </div>
                            <br>
                            <div>
                                <span class="visit1 title-post">  <i class="fa fa-eye text-danger"></i>تعداد بازدید: {{$visits->count()}}</span>
                            </div>
                        </div><!--column-->
                    </div><!--row-->
                </article>
            </div><!--container-->
        </div>
        @if($article->status != 0)
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
                        <form class="text-uppercase text-bold row" dir="rtl" method="post" action="{{ route('comment.store',$article->title) }}">
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
                            <input type="hidden" name="type" value="blog">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-wide btn-dark btn-send-comment" type="submit">ارسال نظر </button>
                            </div>
                        </form>

                    </div><!--column-->
                </div><!--row-->
            </div>
        </section>
        @endif
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
                                    @if($comment->replies2()->count())
                                        <ol>
                                            @foreach($comment->replies2 as $reply)
                                                <li id="li-comment-14" class="comment media">
                                                    <a class="author_avatar" href="#">
                                                        <img class="avatar" @if($reply->email ==null)
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
                                <div class="alert alert-success">نظری برای این مقاله وجود ندارد</div>
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
