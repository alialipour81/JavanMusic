@extends('layouts.dashboard.front')
@php
if(isset($article))
    $type = "ویرایش مقاله";
else
    $type = "افزودن مقاله";

function selected($val1,$val2){
    if($val1 == $val2){
       echo 'selected';
    }
}
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
            <form class="form-horizontal" action="{{ isset($article) ? route('articles.update',$article->slug) : route('articles.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($article)
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
                        <label for="1" class="col-sm-2 control-label">عنوان</label>

                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="1" placeholder="عنوان مقاله را وارد کنید" value="{{ isset($article) ? $article->title : old('title') }}">
                        </div>
                    </div>
                        <div class="form-group col-md-10">
                            <label>  دسته بندی این مقاله؟ </label>
                            <select name="category_id" class="form-control select2"   data-placeholder="یک دسته بندی انتخاب کنید" style="width: 100%;text-align: right">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @isset($article) {{ selected($article->category_id,$category->id) }} @endisset>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->role == "admin" || isset($article) && auth()->user()->id == $article->user_id || request()->url()==route('articles.create'))
                        <div class="form-group col-md-10">
                            <label>این پست با کدام کاربر یا کاربران مشترک میشوید ؟ <br>
                            (میتوانید هیچ گزینه ای انتخاب نکنید)
                            </label>
                            <select dir="rtl" name="other_users_sub[]" class="form-control select2" multiple="multiple"
                                    data-placeholder="کاربر را   انتخاب کنید" style="width: 100%;text-align: right">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                    @isset($article)
                                        @php $valus_not_exists=[] ;@endphp
                                        @if($article->other_users_sub != 0)
                                            @php $user_moshtaraks = $article->users_moshtarak($article->other_users_sub); @endphp
                                            @foreach($user_moshtaraks as $user_moshtarak)
                                                {{ selected($user->id,$user_moshtarak->id) }}
                                                @endforeach
                                            @endif
                                        @endisset
                                    >{{ $user->name }}</option>
                                @endforeach
                                <!-- برای وقتی که کاربر مشترک خودمان هستیم -->
                                    @isset($article)
                                        @if($article->other_users_sub != 0)
                                        @foreach($user_moshtaraks as $user_moshtarak)
                                            @if(auth()->user()->role == "admin" && $article->user_id!= auth()->user()->id && auth()->user()->id == $user_moshtarak->id )
                                                <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    @endisset


                            </select>
                        </div>
                        @else
                            <label >کاربرانی که در این پست با آنها مشترک هستید:</label>
                            <div class="form-group col-md-10">
                                <select dir="rtl" name="other_users_sub[]" class="form-control select2" multiple="multiple" disabled
                                        data-placeholder="کاربر را   انتخاب کنید" style="width: 100%;text-align: right">
                                    <option value="{{ $article->user_id }}" selected>{{ $article->user->name }}</option>
                                    @foreach($users as $user)
                                        <option  disabled
                                        @foreach($article->users_moshtarak($article->other_users_sub) as $user_moshtarak)
                                            @if(strpos($article->other_users_acc,$user_moshtarak->id.'A'))
                                            {{ selected($user->id,$user_moshtarak->id) }}
                                                @endif
                                            @endforeach
                                        >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @foreach($article->users_moshtarak($article->other_users_sub) as $user_moshtarak)
                                    <input type="hidden" name="other_users_sub[]" value="{{ $user_moshtarak->id }}">
                                @endforeach

                            </div>
                        @endif
                        <div class="form-group col-md-10">
                            <label>  برچسپ های  این مقاله؟ </label>
                            <select dir="rtl" name="tags[]" class="form-control select2" multiple="multiple"   data-placeholder="یک برچسپ  انتخاب کنید" style="width: 100%;text-align: right">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                    @isset($article) @if($article->tags_select($tag->id)) selected @endif @endisset
                                    >{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="2"> تصویر</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="2">
                                    <label class="custom-file-label" for="exampleInputFile"> برای آپلود کلیک کنید   </label>
                                </div>
                            </div>
                            @isset($article)
                                <img src="{{ asset('storage/'.$article->image) }}" width="100%" height="100%" class="rounded shadow my-2">
                            @endisset
                        </div>
                        <div class="form-group col-md-10">
                            <label for="description"> توضیحات  را بنویسید </label>
                            <textarea class="form-control" rows="4" name="description" id="description" placeholder=" توضیحات را بنویسید">
                                {!!  isset($article) ? $article->description : old('description') !!}
                            </textarea>
                            <script>
                                CKEDITOR.replace('description',{
                                    language: 'fa',
                                    filebrowserUploadUrl: "{{route('ckeditor.image_upload', ['_token' => csrf_token() ])}}",
                                    filebrowserUploadMethod: 'form'
                                });
                            </script>
                        </div>

                        @if(auth()->user()->role == "admin")
                            @isset($article)
                                    <div class="form-group col-md-10">
                                        <label for="status">کاربر  :</label>
                                        <select name="user_id" class="form-control" id="status">
                                            <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ selected($user->id,$article->user_id) }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="form-group col-md-10">
                                    <label for="status">وضعیت نمایش :</label>
                                    <select name="status" class="form-control" id="status">
                                        @foreach($statuses as $key=>$status)
                                            <option
                                                value="{{ $key }}" {{ selected($key,$article->status) }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endisset
                        @else
                            <input type="hidden" name="status" value="0">
                            @isset($article) <input type="hidden" name="user_id" value="{{ $article->user_id }}"> @endisset
                        @endif

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ $type }}</button>
                </div>
                <!-- /.card-footer -->
            </form>
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
