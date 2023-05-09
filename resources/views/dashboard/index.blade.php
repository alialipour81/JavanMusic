@extends('layouts.dashboard.front')
@section('title','داشبورد')
@section('content')
    <section class="content">
        @include('layouts.message')
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $visits->count() }}</h3>

                            <p> همه بازدید ها</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-eye"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $comments->count() }}

                            <p> کل نظرات</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-comments"></i>
                        </div>
                        <a href="{{ route('comments.index') }}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $usersCount }}</h3>

                            <p>کاربران  </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="#users" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ count($viewsToday) }}</h3>

                            <p>بازدید امروز</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-eye"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->

                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">کاربران </h3>

                                <div class="card-tools">
                                    <form action="{{ route('dashboard.index') }}" method="get">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="users" value="{{ request()->query('users') }}" class="form-control float-right" placeholder="جستجو">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover" id="users">
                                    <tr>
                                        <th>آیدی</th>
                                        <th>نام</th>
                                        <th>تصویر</th>
                                        <th>ایمیل</th>
                                        <th>نقش کاربری</th>
                                        <th>وضعیت تایید ایمیل</th>
                                        <th>تاریخ ثبت نام</th>
                                        <th>  آخرین بروزرسانی</th>
                                        <th>ویرایش</th>
                                        <th>حذف</th>
                                    </tr>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}#</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if($user->image == null)
                                                <img src="{{ Gravatar::get($user->email,['size'=>40]) }}" class="img-circle shadow elevation-2" alt="{{ $user->name }} ">
                                            @else
                                                <img src=" {{ asset('storage/'.$user->image) }}" width="40px" height="40px" class="img-circle shadow elevation-2" alt="{{ $user->name }} ">
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role == "admin")
                                                <span class="badge badge-success">ادمین</span>
                                            @else
                                                <span class="badge badge-primary">کاربر</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->email_verified_at != null)
                                                <span class="badge badge-success">تایید شده</span>
                                            @else
                                                <span class="badge badge-danger">تایید نشده</span>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-secondary">{{ $user->created_at->diffForhumans() }}</span></td>
                                        <td><span class="badge badge-secondary">{{ $user->updated_at->diffForhumans() }}</span></td>
                                        <td>
                                            <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                {{ $users->links() }}
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
