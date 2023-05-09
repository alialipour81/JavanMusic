@extends('layouts.dashboard.front')
@section('title','اسلایدر')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">اسلایدر </h3>

                <div class="card-tools">
                    <a href="{{ route('slider.create') }}" class="btn btn-danger btn-sm">افزودن</a>
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
                        <th>بکگراند</th>
                        <th>عنوان</th>
                        <th>زیر عنوان</th>
                        <th>عنوان دکمه سیاه/لینک</th>
                        <th>عنوان دکمه سبز/لینک</th>
                        <th>وضعیت نمایش</th>
                        <th>تاریخ ایجاد</th>
                        <th>تاریخ بروزرسانی</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}#</td>
                            <td>
                                <img src="{{ asset('storage/'.$slider->image) }}" width="60px" height="40px" class="rounded shadow">
                            </td>
                            <td>
                                <img src="{{ asset('storage/'.$slider->image_background) }}" width="60px" height="40px" class="rounded shadow">
                            </td>
                            <td><span class="badge badge-secondary">{{ $slider->title }}</span></td>
                            <td><span class="badge badge-secondary">{{ $slider->sub_title }}</span></td>
                            <td>
                                @if(!empty($slider->title_button_black) && !empty($slider->link_button_black))
                                    <span class="badge badge-dark">{{ $slider->title_button_black }}</span><br>
                                    <a href="{{ $slider->link_button_black }}" class="text-link text-sm">مشاهده لینک</a>
                                @else
                                    <span class="badge badge-info">خالی است</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($slider->title_button_green) && !empty($slider->link_button_green))
                                    <span class="badge badge-success">{{ $slider->title_button_green }}</span><br>
                                    <a href="{{ $slider->link_button_green }}" class=" text-link text-sm">مشاهده لینک</a>
                                @else
                                    <span class="badge badge-info">خالی است</span>
                                @endif
                            </td>
                            <td>
                                @if($slider->status == 1)
                                    <span class="badge badge-success">نمایش</span>
                                @else
                                    <span class="badge badge-danger"> عدم نمایش</span>
                                @endif
                            </td>
                            <td><span class="badge badge-warning">{{ $slider->created_at->diffForHumans() }}</span></td>
                            <td><span class="badge badge-warning">{{ $slider->updated_at->diffForHumans() }}</span></td>
                            <td>
                                <a href="{{ route('slider.edit',$slider->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('slider.destroy',$slider->id) }}" method="post">
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
        {{ $sliders->links() }}
        <!-- /.card -->
    </div>
@endsection
