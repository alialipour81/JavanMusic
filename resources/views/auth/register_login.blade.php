@extends('layouts.auth.front')
@section('title','ورود | ثبت نام  ')
@section('content')
<!-- Right Side Title -->
<div class="col-12 col-md-3 register-right">
    <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
    <h3>خوش آمدید</h3>
    <form action="{{ route('index') }}" method="get">
        @csrf
        <input type="submit"  value="  بازگشت به صفحه اصلی"/><br/>
    </form>
</div>
<!-- /Right Side Title -->
<!-- Left Side Forms -->
<div class="col-12 col-md-9">
    <div class="register-left p-3">
        <!-- Tabs Nav-bar -->
        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ورود</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ثبت نام</a>
            </li>
        </ul>
        <!-- /Tabs Nav-bar -->
        <div class="tab-content" id="myTabContent">
            <!-- Tab 1 -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h3 class="register-heading"> ورود به حساب کاربری </h3>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="row register-form mx-auto">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="پست الکترونیک *" value="{{ old('email') }}"/>
                                @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                    <div class="form-check">
                                        <input  class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            مرا به خاطربسپار
                                        </label>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="رمز عبور  *"/>
                            </div>
                            @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror

                            <input type="submit" class="btnRegister"  value="ورود"/>
                        </div>
                        <a href="{{ route('password.request') }}" class="btn btn-outline-info">بازیابی رمز عبور</a>
                    </div>
                </form>
            </div>
            <!-- /Tab 1 -->
            <!-- Tab 2 -->
            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h3  class="register-heading">ثبت نام </h3>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="row register-form mx-auto">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="*نام و نام خانوادگی" value="{{ old('name') }}" />
                                @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور *"  />
                                @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="پست الکترونیک *" value="{{ old('email') }}" />
                                @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="تکرار رمز عبور *"  />
                            </div>

                            <input type="submit" class="btnRegister"  value="ثبت نام"/>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /Tab 2 -->
        </div>
    </div>
</div>
<!-- /Left Side Forms -->
@endsection
