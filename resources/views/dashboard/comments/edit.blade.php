@extends('layouts.dashboard.front')

@section('title', '  ویرایش نظر: '.$comment->text)
@section('content')
    <div class="col-md-11 m-2">

        <div class="card card-info">
            <div class="card-header">
                <span class="card-title"> ویرایش نظر کاربر
                    @empty($comment->name)
                        {{ $comment->user->name }}
                    @else
                        {{ $comment->name }}
                    @endempty
                    @if($comment->star == null)
                        <span class="badge badge-dark">(این یک پاسخ است)</span>
                    @endif
                </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
                @php
                if($comment->type == "music"):
                $type_comment = 'music';
                else:
                 $type_comment = 'blog';
                endif;
                function selected($val1,$val2,$checked='off'){
                if($val1 == $val2){
                if($checked == "off"):
                echo 'selected';
                else:
                echo 'checked';
                endif;
                 }
               }
                @endphp
            <form class="form-horizontal" action="{{route('comments.update',$comment->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="badge badge-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group">
                        <label for="user_id">کاربر:</label>
                        @if($comment->name == null)
                            <select name="user_id" id="user_id" class="col-md-11 select2 form-control">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ selected($user->id,$comment->user_id) }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <input class="form-control col-md-11" type="text" name="username" value="{{ $comment->name }}">
                        @endif
                    </div>
                        @if($comment->star != null)
                    <div class="form-group">
                        <label for="item">
                            @if($type_comment == 'music')
                            موزیک ها
                            @else
                                مقاله ها
                            @endif
                        </label>
                        <select name="type_id" class="select2 form-control col-md-11" id="item">
                          @foreach($items as $item)
                                @if($type_comment == 'music')
                                <option value="{{ $item->id }}" {{ selected($item->id,$comment->type_id) }}>{{ $item->name }}</option>
                                @else
                                <option value="{{ $item->id }}" {{ selected($item->id,$comment->type_id) }}>{{ $item->title }}</option>
                                @endif
                          @endforeach
                        </select>
                    </div>
                        @endif
                        @if($comment->star != null)
                       <div class="form-group d-flex justify-content-start "dir="rtl">
                               <label class="mt-2">تعداد امتیاز:</label>
                               <div id="reviewStars-input" dir="rtl">
                                   <input id="star-4" type="radio" name="star"  value="5" {{ selected($comment->star,5,'checked') }}/>
                                   <label title="عالی" for="star-4"></label>

                                   <input id="star-3" type="radio" name="star" value="4" {{ selected($comment->star,4,'checked') }}/>
                                   <label title="خوب" for="star-3"></label>

                                   <input id="star-2" type="radio" name="star" value="3" {{ selected($comment->star,3,'checked') }}/>
                                   <label title="متوسط" for="star-2"></label>

                                   <input id="star-1" type="radio" name="star" value="2" {{ selected($comment->star,2,'checked') }}/>
                                   <label title="قابل قبول" for="star-1"></label>

                                   <input id="star-0" type="radio" name="star" value="1" {{ selected($comment->star,1,'checked') }} />
                                   <label title="ضعیف" for="star-0"></label>
                               </div>
                       </div>
                        @endif
                    <div class="form-group">
                        <label > متن نظر :</label>
                        <textarea class="form-control col-md-11" rows="4" name="text">{{ $comment->text }}</textarea>
                    </div>
                        <div class="form-group col-md-10">
                            <label for="status">وضعیت نمایش :</label>
                            <select name="status" class="form-control" id="status">
                                @foreach($statuses as $key=>$status)
                                    <option value="{{ $key }}" {{ selected($key,$comment->status) }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">ویرایش</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection
@section('link_css')
    <link rel="stylesheet" href="{{ asset('khodam/css/star.css') }}">
@endsection
