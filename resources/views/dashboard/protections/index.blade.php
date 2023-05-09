@extends('layouts.dashboard.front')
@section('title','حمایت ها')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">حمایت ها </h3>

                <div class="card-tools">
                    <a href="{{ route('protections.create') }}" class="btn btn-danger btn-sm">افزودن</a>
                </div>
            </div>
            <div class="my-2">@include('layouts.message')</div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>لینک</th>
                        <th>وضعیت نمایش</th>
                        <th>کاربر</th>
                        <th>تاریخ ایجاد</th>
                        <th>تاریخ بروزرسانی</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($protections as $protection)
                        <tr>
                            <td>{{ $protection->id }}#</td>
                            <td>
                                <img src="{{ asset('storage/'.$protection->image) }}" width="60px" height="40px" class="rounded shadow">
                            </td>
                            <td>{{ $protection->title }}</td>
                            <td>{{ $protection->link }}</td>
                            <td>
                                @if($protection->status == 1)
                                    <span class="badge badge-success">نمایش</span>
                                @else
                                    <span class="badge badge-danger"> عدم نمایش</span>
                                @endif
                            </td>
                            <td><span class="badge badge-primary">{{ $protection->user->name }}</span></td>
                            <td><span class="badge badge-secondary">{{ $protection->created_at->diffForHumans() }}</span></td>
                            <td><span class="badge badge-secondary">{{ $protection->updated_at->diffForHumans() }}</span></td>
                            <td>
                                <a href="{{ route('protections.edit',$protection->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('protections.destroy',$protection->id) }}" method="post">
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
        {{ $protections->links() }}
        <!-- /.card -->
    </div>
@endsection
