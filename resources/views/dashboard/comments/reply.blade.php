@extends('layouts.dashboard.front')

@section('title', ' پاسخ به نظر: '.$comment->text)
@section('content')
    <div class="col-md-11 m-2">

        <div class="card card-danger">
            <div class="card-header">
                <span class="card-title">پاسخ به کاربر
                    @empty($comment->name)
                        {{ $comment->user->name }}
                    @else
                        {{ $comment->name }}
                    @endempty
                </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('comments.reply',$comment->id)}}" method="post">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="badge badge-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group">
                        <label >پاسخ به نظر :</label>
                        <textarea class="form-control" rows="4" disabled>{{ $comment->text }}</textarea>
                    </div>
                        <div class="form-group">
                            <label >  متن پاسخ :</label>
                            <textarea class="form-control" rows="5" name="text"></textarea>
                        </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-danger">پاسخ</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection
