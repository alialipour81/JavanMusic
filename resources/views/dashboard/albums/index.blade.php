@extends('layouts.dashboard.front')
@section('title','آلبوم ها ')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">آلبوم ها  </h3>

                <div class="card-tools">
                    <a href="{{ route('albums.create') }}" class="btn btn-danger btn-sm">افزودن</a>
                </div>
            </div>
            <div class="my-2">@include('layouts.message')</div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>  تصویر اصلی</th>
                        <th>  تصویر بکگراند</th>
                        <th> نام هنرمند</th>
                        <th>دسته بندی ها</th>
                        <th>ادمین</th>
                        <th>وضعیت </th>
                        <th> آخرین بروزرسانی</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($albums as $album)
                        <tr>
                            <td>{{ $album->id }}#</td>
                            <td>{{ $album->name }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$album->image) }}" class="rounded shadow" width="60px" height="40px">
                            </td>
                            <td>
                                <img src="{{ asset('storage/'.$album->image_background) }}" class="rounded shadow" width="60px" height="40px">
                            </td>
                            <td><span class="badge badge-dark p-1">{{ $album->artist->name }}</span></td>
                            <td>
                                @forelse($album->categories as $category)
                                    <span class="badge badge-success p-1">{{ $category->name }}</span>
                                @empty
                                    <span>ندارد</span>
                                @endforelse
                            </td>
                            <td><span class="badge badge-warning p-1">{{ $album->user->name }}</span></td>
                            <td>
                                @if($album->status == 1)
                                    <span class="badge badge-success p-1">نمایش</span>
                                @else
                                    <span class="badge badge-danger p-1">عدم نمایش</span>
                                @endif
                            </td>
                            <td><span class="badge badge-secondary">{{ $album->updated_at->diffForHumans() }}</span></td>
                            <td>
                                <a href="{{ route('albums.edit',$album->name) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('albums.destroy',$album->name) }}" method="post">
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
        {{ $albums->links() }}
        <!-- /.card -->
    </div>
@endsection
