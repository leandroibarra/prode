@extends('layouts.web')

@section('content')
<div class="intro py-5 py-lg-9 position-relative text-white">
    <div class="bg-overlay">
        <img src="{{ asset('images/cover.jpg') }}" class="img-fluid img-cover" alt="{{ config('app.name', 'Prode') }}" />
    </div>
    <div class="intro-content py-6">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-10 col-lg-8 mx-auto text-center">
                    <h1 class="my-3 display-4 d-none d-lg-inline-block">{{ __('Welcome to').' '.config('app.name', 'Prode') }}</h1>
                    <span class="h1 my-3 d-inline-block d-lg-none">{{ __('Welcome to').' '.config('app.name', 'Prode') }}</span>
                    <p class="lead mb-3">{{ __('The best game of result predictions of different official soccer tournaments.') }}</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12 col-lg-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">{{ __('Choose your prediction') }}</h3>
                            <p class="text-left">{{ __('You can select or change the prediction until before the start time of the match between home, draw, or away.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">{{ __('Success final result') }}</h3>
                            <p class="text-left">{{ __('If the final result of the match matches your prediction, you win the points awarded by the match.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">{{ __('Be the winner') }}</h3>
                            <p class="text-left">{{ __('At the end of competition, the user at the top of ranking win the competition.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 align-items-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto text-center">
                    @guest
                        <h2 class="d-none d-lg-inline-block w-100">{{ __('Get started') }}</h2>
                        <span class="h2 d-inline-block d-lg-none w-100">{{ __('Get started') }}</span>
                        <a class="btn btn-outline-white btn-lg my-1" href="{{ route('login') }}" role="button">{{ __('Sign in') }}</a>
                        @if (Route::has('register'))
                        <span class="mx-2">{{ __('or') }}</span>
                        <a class="btn btn-success btn-lg my-1" href="{{ route('register') }}" role="button">{{ __('Sign up') }}</a>
                        @endif
                    @else
                        <a class="btn btn-success btn-lg my-1" href="{{ route('home.index') }}" role="button">{{ __('Get started') }}</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
