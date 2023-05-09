@extends('layouts.auth.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-outline-danger">خروج</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
