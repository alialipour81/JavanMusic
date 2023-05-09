@extends('layouts.dashboard.front')
@php
if(isset($tag))
    $type = "ویرایش برچسپ";
else
    $type = "افزودن برچسپ";
@endphp
@section('title',$type)
@section('content')
    <div class="col-md-11 m-2">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                {{ $type }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ isset($tag) ? route('tags.update',$tag->name) : route('tags.store') }}" method="post">
                @csrf
                @isset($tag)
                    @method('PUT')
                @endisset
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">نام</label>

                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="نام برچسپ را وارد کنید" value="{{ isset($tag) ? $tag->name : old('name') }}">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary">{{ $type }}</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>
@endsection
