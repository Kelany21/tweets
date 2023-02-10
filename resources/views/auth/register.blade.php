@extends('layouts.app')

@section('title' , trans('website.register'))

@section('content')
    <!-- Start Head Title -->
    <div class="head_main_title">
        <div class="section_title">
            <h1>{{ trans('website.register') }}</h1>
            <img src="{{ url('/website/images/head_title_img.png') }}" alt="{{ trans('website.register') }}"/>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ trans('website.register') }}</li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ trans('website.register') }}
                </li>
            </ol>
        </nav>
    </div>
    <!-- End Head Title -->

    <!-- Start Page Content -->
    <div class="page_content">
        <div class="log_page">
            <div class="container">
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="input_row">
                        <p>{{ trans('website.name') }}</p>
                        <label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </label>

                    </div>
                    <div class="input_row">
                        <p>{{ trans('website.email') }}</p>
                        <label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </label>
                    </div>
                    <div class="input_row">
                        <p>{{ trans('website.password') }}</p>
                        <label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </label>
                    </div>
                    <div class="input_row">
                        <p>{{ trans('website.confirm_password') }}</p>
                        <label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </label>
                    </div>
                    <button class="log_btn">{{ trans('website.register') }}</button>
                </form>

            </div>
        </div>
    </div>
    <!-- End Page Content -->
@endsection
