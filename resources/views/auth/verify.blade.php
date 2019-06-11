@extends('layouts.web')

@section('content')
<div class="intro py-5 py-lg-9 position-relative text-white">
    <div class="bg-overlay">
        <img src="{{ asset('images/cover.jpg') }}" class="img-fluid img-cover" alt="{{ config('app.name', 'Prode') }}" />
    </div>
    <div class="intro-content pt-8 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <h1 class="display-4 mb-3">{{ __('Verify Your Email Address') }}</h1>
                    <p class="lead mb-4">&nbsp;</p>
                </div>
                <div class="col-lg-6 ml-auto">
                    <div class="card">
                        <div class="card-body text-dark">
                            @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
