@extends('layouts.dashboard.front')
@section('title','نظرات')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">نظرات </h3>

                <div class="card-tools">
                </div>
            </div>
            <div class="my-2">@include('layouts.message')</div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>
                            <span class="text-danger">موزیک</span>/
                            <span class="text-success">مقاله</span>
                        </th>
                        <th>کاربر</th>
                        <th>متن نظر</th>
                        <th>امتیاز </th>
                        <th> وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>پاسخ</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}#</td>

                            <td>
                             @if($comment->type == "music")
                                 <a href="{{ route('music',$comment->music->slug) }}" class="text-danger"> {{ $comment->music->name }}</a>
                                @else
                                    <a href="{{ route('article',$comment->article->slug) }}" class="text-success"> {{ $comment->article->title }}</a>
                             @endif
                            </td>
                            <td>
                                <span class="badge @empty($comment->name) badge-dark @else badge-primary @endempty"
                                @empty($comment->name) title="کاربر ثبت نام شده" @else title="کاربر ناشناس" @endempty
                                >
                                    @empty($comment->name)
                                        {{ $comment->user->name }}
                                    @else
                                        {{ $comment->name }}
                                    @endempty
                                </span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($comment->text,20) }}</td>
                            <td>
                                @empty(!$comment->star)
                                @for($j=0;$j<$comment->star;$j++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                                @else
                                    <i class="fa fa-reply text-info" title="این یک پاسخ است"></i>
                                @endempty
                            </td>
                            <td>
                                <span class="badge @if($comment->status==1) badge-success @else badge-danger @endif">
                                    @if($comment->status == 1)
                                        نمایش
                                    @else
                                        عدم نمایش
                                    @endif
                                </span>
                            </td>
                            <td><span class="badge badge-secondary">{{ $comment->created_at->diffForHumans() }}</span></td>
                            <td>
                                @empty($comment->star)
                                    <span class="badge badge-info">پاسخ است</span>
                                @else
                                <a href="{{ route('comments.show',$comment->id) }}" class="btn btn-default  btn-sm"><i class="fa fa-reply text-info"></i>پاسخ({{$comment->allReply()->count()}})</a>
                                @endempty
                            </td>
                            <td>
                                <a href="{{ route('comments.edit',$comment->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('comments.destroy',$comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        {{ $comments->links() }}
        <!-- /.card -->
    </div>
@endsection
