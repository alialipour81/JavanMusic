@extends('layouts.dashboard.front')
@section('title','مقاله ها')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    @if(auth()->user()->role == "admin")
                    مقاله ها
                    @else
                        مقاله های من
                    @endif
                </h3>

                <div class="card-tools">
                    <a href="{{ route('articles.create') }}" class="btn btn-danger btn-sm">افزودن</a>
                </div>
            </div>
            <div class="my-2">@include('layouts.message')</div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>تصویر</th>
                        <th>دسته بندی</th>
                        <th>وضعیت </th>
                        @if(auth()->user()->role == "admin")   <th>کاربر </th> @endif
                        <th>مشترک با</th>
                        <th>  وضعیت پذیرش</th>
                        <th>تاریخ ایجاد</th>
                        <th> آخرین بروزرسانی</th>
                        <th>تعداد بازدید</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}#</td>
                            <td>{{ $article->title }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$article->image) }}" width="60px" height="40px" class="rounded shadow">
                            </td>
                            <td><span>{{ $article->category->name }}</span></td>
                            <td>
                                @if($article->status == 0)
                                    <span class="badge badge-danger">عدم نمایش</span>
                                @else
                                    <span class="badge badge-success"> نمایش</span>
                                @endif
                            </td>
                            @if(auth()->user()->role == "admin")
                                <td> <span class="badge badge-info">{{ $article->user->name }}</span></td>
                            @endif
                            <td>
                                @if($article->other_users_sub == 0)
                                    <span class="badge badge-dark">مشترک نیست</span>
                                @else
                                    @foreach(\App\Models\Article::users_moshtarak($article->other_users_sub) as $user)
                                        <span class="badge badge-warning">{{ $user->name }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if($article->other_users_sub == 0)
                                    <span class="badge badge-dark">مشترک نیست</span>
                                @else
                               @foreach(\App\Models\Article::users_moshtarak($article->other_users_sub) as $user_moshtarak_sub)
                                   @if(strpos($article->other_users_acc,$user_moshtarak_sub->id.'A'))
                                       <span title="پذیرفته شده" class="badge badge-success">{{ $user_moshtarak_sub->name }}</span>
                                    @elseif(strpos($article->other_users_acc,$user_moshtarak_sub->id.'C'))
                                        <span title="پذیرفته نشده" class="badge badge-danger">{{ $user_moshtarak_sub->name }}</span>
                                        @else
                                            <span title=" نامشخص" class="badge badge-light">{{ $user_moshtarak_sub->name }}</span>
                                    @endif
                                @endforeach
                                @endif
                            </td>
                            <td><span class="badge badge-secondary">{{ $article->created_at->diffForhumans() }}</span></td>
                            <td><span class="badge badge-secondary">{{ $article->updated_at->diffForhumans() }}</span></td>
                            <td>
                                {{ $article->get_visit($article->id)->count() }}<i class="fa fa-eye text-success"></i>
                            </td>
                            <td>
                                <a href="{{ route('articles.edit',$article->slug) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('articles.destroy',$article->slug) }}" method="post">
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
        {{ $articles->links() }}
        <br><br><br><br><br><br><br><br><br>
        <div class="card-body table-responsive p-0">
            <div class="card">
                <div class="card-header bg-primary-gradient">
                    <h3 class="card-title">مقاله های مشترک</h3>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>درخواست شده از</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th> آخرین بروزرسانی</th>
                    <th>مشاهده</th>
                    @if(auth()->user()->role == "user")
                    <th>ویرایش</th>
                    @endif
                    <th>وضعیت پذیرش</th>
                </tr>
                </thead>
                <tbody>
                @forelse($moshtaraks as $moshtarak)
                <tr>
                    <td>{{ $moshtarak->id }}#</td>
                    <td>{{ $moshtarak->title }}</td>
                    <td>
                        <img src="{{ asset('storage/'.$moshtarak->image) }}" width="60px" height="40px" class="rounded shadow">
                    </td>
                    <td><span class="badge badge-primary">{{ $moshtarak->user->name }}</span></td>
                    <td>
                        @if($moshtarak->status == 0)
                            <span class="badge badge-danger">عدم نمایش</span>
                        @else
                            <span class="badge badge-success"> نمایش</span>
                        @endif
                    </td>
                    <td><span class="badge badge-secondary">{{ $moshtarak->created_at->diffForhumans() }}</span></td>
                    <td>
                        @if(strpos($moshtarak->other_users_acc,auth()->user()->id.'A'))
                        <span class="badge badge-secondary">
                            {{ $moshtarak->updated_at->diffForhumans() }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('article',$moshtarak->slug) }}" class="btn btn-success btn-sm">مشاهده</a>
                    </td>
                    @if(auth()->user()->role == "user")
                    <td>
                        @if(strpos($moshtarak->other_users_acc,auth()->user()->id.'A'))
                        <a href="{{ route('articles.edit',$moshtarak->slug) }}" class="btn btn-primary btn-sm">ویرایش</a>
                        @endif
                    </td>
                    @endif
                    <td>
                        @if(!strpos($moshtarak->other_users_acc,auth()->user()->id.'A') && !strpos($moshtarak->other_users_acc,auth()->user()->id.'C'))
                            <span class="badge badge-warning">نامشخص</span><br>
                        @else
                            @if(strpos($moshtarak->other_users_acc,auth()->user()->id.'A'))
                                <span class="badge badge-success">پذیرفته شده</span>
                            @elseif(strpos($moshtarak->other_users_acc,auth()->user()->id.'C'))
                                <span class="badge badge-danger">پذیرفته نشده</span>
                            @endif
                        @endif

                    </td>
                    <td>
                        @if(!strpos($moshtarak->other_users_acc,auth()->user()->id.'A') && !strpos($moshtarak->other_users_acc,auth()->user()->id.'C'))
                            <form action="{{ route('access_or_cancel.article_moshtarak',$moshtarak->slug) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="access" value="access" class="btn btn-success btn-sm mb-1">مشترک شدن</button>
                            </form>
                            <form action="{{ route('access_or_cancel.article_moshtarak',$moshtarak->slug) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="cancel" value="cancel" class="btn btn-danger btn-sm">مشترک نشدن</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                    <td><div class="alert alert-success">هیچ مقاله اشتراکی وجود ندارد</div></td>
                @endforelse
                </tbody>
            </table>
        <!-- /.card -->
    </div>
@endsection
