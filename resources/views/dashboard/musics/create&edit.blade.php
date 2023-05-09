@extends('layouts.dashboard.front')
@php
if(isset($music))
    $type = "ویرایش موزیک";
else
    $type = "افزودن موزیک";

function selected($val1,$val2){
    if($val1 == $val2){
       echo 'selected';
    }
}
@endphp
@section('title',$type)
@section('content')
    <div class="col-md-11 m-2" dir="rtl">
@include('layouts.message')
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                {{ $type }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="col-md-11">
                <form action="{{ isset($music) ? route('music.update',$music->slug) : route('music.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($music)
                    @method('PUT')
                    @endisset
                @if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="badge badge-danger font-size-6">{{ $error }}</li><br>
                        @endforeach
                    </ul>
                @endif
                <div class="form-group mt-2">
                    <label for="inputEmail3" class="col-sm-2 control-label">نام موزیک</label>

                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="نام موزیک را وارد کنید" value="{{ isset($music) ? $music->name : old('name') }}">
                    </div>
                </div>
                    <div class="form-group col-md-10">
                        <label>   این موزیک جزو کدام آلبوم است؟ </label>
                        <select name="album_id" class="form-control select2"   style="width: 100%;text-align: right">
                            <option value="0" @isset($music) {{ selected($music->album_id,0) }} @endisset>این موزیک سینگل است</option>
                            @foreach($albums as $album)
                                <option value="{{ $album->id }}" @isset($music) {{ selected($music->album_id,$album->id) }}  @endisset >{{ $album->name }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group col-md-10">
                    <label>  موزیک متعلق به کدام هنرمند است؟ </label>
                    <select name="artist_id" class="form-control select2"   data-placeholder="یک هنرمند انتخاب کنید" style="width: 100%;text-align: right">
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" @isset($music) {{ selected($music->artist_id,$artist->id) }}  @endisset >{{ $artist->name }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="form-group col-md-10">
                        <label>برچسپ  های مورد نظر را انتخاب کنید </label>
                        <select name="tags[]" class="form-control select2"  multiple="multiple" data-placeholder="یک یا چند  برچسپ  انتخاب کنید"
                                style="width: 100%;text-align: right">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                        @isset($music)
                                            @foreach($music->tags_music() as $tag_music)
                                            {{  selected($tag->id,$tag_music) }}
                                            @endforeach
                                        @endisset
                                >#{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-10">
                        <label for="exampleInputFile">عکس اصلی </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile"> برای آپلود کلیک کنید | سایز عکس: 73*73  </label>
                            </div>

                        </div>
                        @isset($music)
                            <img src="{{ asset('storage/'.$music->image) }}" width="100%" height="100%" class="rounded shadow my-2">
                        @endisset
                    </div>
                    <div class="form-group col-md-10">
                        <label for="exampleInputFile"> فایل موزیک (کیفیت 128) </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="quality_128" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile"> برای آپلود کلیک کنید   </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="link_quality_128" class="form-control my-2"
                                   placeholder="لینک موزیک"
                                   @isset($music)
                                       @empty(!$music->quality_128)
                                           @if(filter_var($music->quality_128,FILTER_VALIDATE_URL))
                                               value="{{ isset($music) ? $music->quality_128 : old('link_quality_128') }}"
                                   @endif
                                   @endempty
                                   @endisset

                            >
                        </div>
                        @isset($music)
                            @empty(!$music->quality_128)
                            <audio controls>
                                <source
                                    @if(filter_var($music->quality_128,FILTER_VALIDATE_URL))
                                        src="{{ $music->quality_128 }}" type="audio/mpeg"
                                    @else
                                        src="{{ asset('storage/'.$music->quality_128) }}" type="audio/{{$music->format_128}}"
                                    @endif
                                >
                            </audio>
                            @endempty
                        @endisset
                    </div>
                    <div class="form-group col-md-10">
                        <label for="exampleInputFile"> فایل موزیک (کیفیت 320) </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="quality_320" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile"> برای آپلود کلیک کنید   </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="link_quality_320" class="form-control my-2" placeholder="لینک موزیک"
                                   @isset($music)
                                       @empty(!$music->quality_320)
                                           @if(filter_var($music->quality_320,FILTER_VALIDATE_URL))
                                               value="{{ isset($music) ? $music->quality_320 : old('link_quality_320') }}"
                                   @endif
                                   @endempty
                                   @endisset


                            >
                        </div>
                    </div>
                    @isset($music)
                        @empty(!$music->quality_320)
                            <audio controls>
                                <source
                                    @if(filter_var($music->quality_320,FILTER_VALIDATE_URL))
                                        src="{{ $music->quality_320 }}" type="audio/mpeg"
                                    @else
                                        src="{{ asset('storage/'.$music->quality_320) }}" type="audio/{{$music->format_320}}"
                                    @endif
                                >
                            </audio>
                        @endempty
                    @endisset
                    <div class="form-group col-md-10">
                        <label for="text_music"> متن موزیک را بنویسید </label>
                        <textarea class="form-control" rows="4" name="text" id="text_music" placeholder="متن موزیک را بنویسید">
                            @isset($music) {!! $music->text !!} @else {{ old('text') }} @endisset
                        </textarea>
                        <script>
                            CKEDITOR.replace('text_music',{
                               language: 'fa'
                            });
                        </script>
                    </div>
                 @isset($music)
                        <div class="form-group col-md-10">
                            <label for="status">کاربر  :</label>
                            <select name="user_id" class="form-control" id="status">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ selected($user->id,$music->user_id) }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="status">وضعیت نمایش :</label>
                            <select name="status" class="form-control" id="status">
                                @foreach($statuses as $key=>$status)
                                    <option value="{{ $key }}" {{ selected($key,$music->status) }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endisset
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-info">{{ $type }}</button>
                    </div>
                </form>
                <span class="badge badge-danger mt-4">نکته ها:</span>
                <ul>
                    <li class="badge badge-dark">در قسمت فایل موزیک یا باید فایل موزیک وارد کنید یا لینک آن نمیتوانید هردو را انتخاب کنید</li><br>
                    <li class="badge badge-dark">درصورت انتخاب لینک لینک باید یک لینک معتبر باشد</li><br>
                    <li class="badge badge-dark">لینک موزیک باید با فرمت mp3 باشد</li><br>
                </ul>
            </div>
        </div>

    </div>
@endsection
@section('link_css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Persian Data Picker -->
    <link rel="stylesheet" href="{{ asset('dist/css/persian-datepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('dist/css/custom-style.css') }}">
@endsection
@section('link_js')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
    <!-- Persian Data Picker -->
    <script src="{{ asset('dist/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('dist/js/persian-datepicker.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- Page script -->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass   : 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()


            $('.normal-example').persianDatepicker();




        })
    </script>
@endsection
