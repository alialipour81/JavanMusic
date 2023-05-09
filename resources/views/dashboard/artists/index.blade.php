@extends('layouts.dashboard.front')
@section('title','هنرمندان ')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">هنرمندان  </h3>

                <div class="card-tools">
                    <a href="{{ route('artists.create') }}" class="btn btn-danger btn-sm">افزودن</a>
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
                    @foreach($artists as $artist)
                        <tr>
                            <td>{{ $artist->id }}#</td>
                            <td>{{ $artist->name }}</td>
                            <td><span class="badge badge-secondary">{{ $artist->created_at->diffForHumans() }}</span></td>
                            <td>
                                <a href="{{ route('artists.edit',$artist->name) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('artists.destroy',$artist->name) }}" method="post">
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
        {{ $artists->links() }}
        <!-- /.card -->
    </div>
@endsection
