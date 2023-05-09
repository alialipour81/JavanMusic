@extends('layouts.dashboard.front')
@section('title','ویرایش کاربر')
@section('content')
    @php
    function selected($val1,$val2){
    if($val1 == $val2){
       echo 'selected';
    }}
    @endphp
    <div class="col-md-11 m-2">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">
                ویرایش کاربر  {{$user->name}}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            @empty(!$user->image)
                <form action="{{ route('delete.image.profile',$user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger btn-sm my-2 mr-2"><i class="fa fa-image"></i> حذف تصویر پروفایل </button>
                </form>
            @endempty
            <form class="form-horizontal" action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                    @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="badge badge-danger">{{ $error }}</li><br>
                            @endforeach
                        </ul>
                    @endif
                        <div class="form-group">
                            <label for="image_user" class="col-sm-2 control-label">تصویر :</label>

                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control custom-file" id="image_user" >
                            </div>
                            @if(isset($user) && !empty($user->image))
                                <img src=" {{ asset('storage/'.$user->image) }}" width="130px" height="130px" class="my-2 img-circle shadow elevation-2" alt="{{ $user->name }} ">
                            @endif
                        </div>
                    <div class="form-group">
                        <label for="1" class="col-sm-2 control-label">نام:</label>

                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="1" placeholder="نام کاربر " value="{{ $user->name }}">
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="2" class="col-sm-2 control-label">ایمیل:</label>

                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" id="2" placeholder="ایمیل کاربر  " value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="3" class="col-sm-2 control-label">نقش کاربر</label>

                            <div class="col-sm-10">
                                <select name="role" id="3" class="form-control">
                                    @foreach($roles as $key=>$role)
                                        <option value="{{ $key }}" {{ selected($key,$user->role) }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="2" class="col-sm-2 control-label">پسورد جدید:</label>

                            <div class="col-sm-10">
                                <input type="text" name="new_password" class="form-control" id="2" placeholder="پسورد جدید برای کاربر صادرکنید  " >
                            </div>
                        </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark">ویرایش</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection
