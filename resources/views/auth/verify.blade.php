@extends('layouts.auth.front')
@section('title','تایید ایمیل شما')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تایید ایمیل شما</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('لینک تایید ایمیل به ایمیل شما ارسال شد') }}
                        </div>
                    @endif
                    برای دسترسی به پنل خودتان باید ایمیل خود را تایید کنید <br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">لینک تایید را برایم ارسال کن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
