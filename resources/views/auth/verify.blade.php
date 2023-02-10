@extends('layouts.app')

@section('title' , trans('website.login'))

@section('content')

    <!-- Start Head Title -->
    <div class="head_main_title">
        <div class="section_title">
            <h1>{{ trans('website.login') }}</h1>
            <img src="{{ url('/website/images/head_title_img.png') }}" alt="{{ trans('website.login') }}"/>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ u('register') }}">{{ trans('website.register') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('website.login') }}</li>
            </ol>
        </nav>
    </div>
    <!-- End Head Title -->

    <!-- Start Page Content -->
    <div class="page_content">
        <div class="log_page">
            <div class="container">

                <p>{{ __('Verify Your Email Address') }}</p>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="log_btn">{{ __('click here to request another') }}</button>
                    .
                </form>
            </div>
        </div>
    </div>
    <!-- End Page Content -->

@endsection
