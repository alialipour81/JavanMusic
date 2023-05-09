@extends('layouts.dashboard.front')
@section('title','دسته بندی ها')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">دسته بندی ها </h3>

                <div class="card-tools">
                    <a href="{{ route('categories.create') }}" class="btn btn-danger btn-sm">افزودن</a>
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
                        <th>تاریخ ایجاد</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}#</td>
                            <td>{{ $category->name }}</td>
                            <td><span class="badge badge-secondary">{{ $category->created_at->diffForHumans() }}</span></td>
                            <td>
                                <a href="{{ route('categories.edit',$category->name) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('categories.destroy',$category->name) }}" method="post">
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
        {{ $categories->links() }}
        <!-- /.card -->
    </div>
@endsection
