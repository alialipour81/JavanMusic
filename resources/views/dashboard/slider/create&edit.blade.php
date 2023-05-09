@extends('layouts.dashboard.front')
@php
if(isset($slider))
    $type = "ویرایش اسلایدر";
else
    $type = "افزودن اسلایدر";
@endphp
@section('title',$type)
@section('content')
    <div class="col-md-11 m-2">
        @include('layouts.message')

        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                {{ $type }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ isset($slider) ? route('slider.update',$slider->id) : route('slider.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($slider)
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
                            <label for="1" class="col-sm-2 control-label">تصویر(251*251):</label>

                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control" id="1"  >
                            </div>
                            @isset($slider)
                                <img src="{{ asset('storage/'.$slider->image) }}" width="100%" height="100%" class="rounded my-2 shadow">
                            @endisset
                        </div>
                        <div class="form-group">
                            <label for="image_background" class="col-sm-2 control-label">تصویر بکگراند(1349*400):</label>

                            <div class="col-sm-10">
                                <input type="file" name="image_background" class="form-control" id="image_background"  >
                            </div>
                            @isset($slider)
                                <img src="{{ asset('storage/'.$slider->image_background) }}" width="100%" height="100%" class="rounded my-2 shadow">
                            @endisset
                        </div>
                    <div class="form-group">
                        <label for="2" class="col-sm-2 control-label">عنوان:</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="2" placeholder="عنوان  را وارد کنید" value="{{ isset($slider) ? $slider->title : old('title') }}">
                        </div>
                        <label for="2" class="col-sm-2 control-label">زیر عنوان:</label>

                        <div class="col-sm-10">
                            <input type="text" name="sub_title" class="form-control" id="2" placeholder="زیر عنوان  را وارد کنید" value="{{ isset($slider) ? $slider->sub_title : old('sub_title') }}">
                        </div>
                    </div>
                        <div class="form-group col-md-10">
                            <label for="description">توضیحات:</label>
                            <textarea class="form-control col-md-10" name="description" rows="4" id="description">{{ isset($slider) ? $slider->description : old('description') }}</textarea>
                            <script>
                                CKEDITOR.replace('description',{
                                   language:'fa'
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="2" class="col-sm-2 control-label">تنظیمات دکمه سیاه: (اختیاری است)</label>

                            <div class="col-sm-10">
                                <input type="text" name="title_button_black" class="form-control" id="2" placeholder=" عنوان دکمه سیاه را وارد کنید" value="{{ isset($slider) ? $slider->title_button_black : old('title_button_black') }}">
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="link_button_black" class="form-control mt-1" id="2" placeholder="لینک دکمه سیاه را وارد کنید" value="{{ isset($slider) ? $slider->link_button_black : old('link_button_black') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="2" class="col-sm-2 control-label">تنظیمات دکمه سبز: (اختیاری است)</label>

                            <div class="col-sm-10">
                                <input type="text" name="title_button_green" class="form-control" id="2" placeholder=" عنوان دکمه سبز را وارد کنید" value="{{ isset($slider) ? $slider->title_button_green : old('title_button_green') }}">
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="link_button_green" class="form-control mt-1" id="2" placeholder="لینک دکمه سبز را وارد کنید" value="{{ isset($slider) ? $slider->link_button_green : old('link_button_green') }}">
                            </div>
                        </div>
                    @isset($slider)
                            <div class="form-group col-md-10">
                                <label for="status">وضعیت نمایش :</label>
                                <select name="status" class="form-control" id="status">
                                    @foreach($statuses as $key=>$status)
                                        <option value="{{ $key }}" @if($key==$slider->status) selected @endif>{{ $status }}</option>
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
@section('link_css')
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
@endsection
