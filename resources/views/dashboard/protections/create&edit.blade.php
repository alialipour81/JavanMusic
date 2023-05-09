@extends('layouts.dashboard.front')
@php
if(isset($protection))
    $type = "ویرایش حمایت";
else
    $type = "افزودن حمایت";
@endphp
@section('title',$type)
@section('content')
    <div class="col-md-11 m-2">

        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                {{ $type }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ isset($protection) ? route('protections.update',$protection->id) : route('protections.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($protection)
                    @method('PUT')
                @endisset
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="badge badge-danger">{{ $error }}</li><br>
                            @endforeach
                        </ul>
                    @endif
                        <div class="form-group">
                            <label for="1" class="col-sm-2 control-label">تصویر:</label>

                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control" id="1"  >
                            </div>
                            @isset($protection)
                                <img src="{{ asset('storage/'.$protection->image) }}" width="100%" height="100%" class="rounded my-2 shadow">
                            @endisset
                        </div>
                    <div class="form-group">
                        <label for="2" class="col-sm-2 control-label">عنوان:</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="2" placeholder="عنوان حمایت را وارد کنید" value="{{ isset($protection) ? $protection->title : old('title') }}">
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="2" class="col-sm-2 control-label">لینک(url):</label>

                            <div class="col-sm-10">
                                <input type="url" name="link" class="form-control" id="2" placeholder="لینک حمایت را وارد کنید" value="{{ isset($protection) ? $protection->link : old('link') }}">
                            </div>
                        </div>
                    @isset($protection)
                            <div class="form-group col-md-10">
                                <label for="status">وضعیت نمایش :</label>
                                <select name="status" class="form-control" id="status">
                                    @foreach($statuses as $key=>$status)
                                        <option value="{{ $key }}" @if($key==$protection->status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-danger">{{ $type }}</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection
