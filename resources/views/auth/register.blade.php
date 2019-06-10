@extends('layouts.web')

@section('content')
<div class="intro py-5 py-lg-9 position-relative text-white">
    <div class="bg-overlay">
        <img src="{{ asset('images/cover.jpg') }}" class="img-fluid img-cover" alt="{{ config('app.name', 'Prode') }}" />
    </div>
    <div class="intro-content pt-8 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h1 class="display-4 mb-3">{{ __('Sign up').' '.__('to').' '.config('app.name', 'Prode') }}</h1>
                    <p class="lead mb-4">{{ __('The best game of result predictions of different official soccer tournaments.') }}</p>
                </div>
                <div class="col-md-5 ml-auto">
                    <div class="card">
                        <div class="card-body text-dark">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter your name') }}" required autofocus />

                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your e-mail address') }}" required autofocus />

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Enter your password') }}" required />
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm your password') }}" required />
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg mb-2">{{ __('Sign up') }}</button>
                                <div class="text-center">
                                    {{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
