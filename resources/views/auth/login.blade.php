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
                    <h1 class="display-4 mb-3">{{ __('Sign in').' '.__('to').' '.config('app.name', 'Prode') }}</h1>
                    <p class="lead mb-4">{{ __('The best game of result predictions of different official soccer tournaments.') }}</p>
                </div>
                <div class="col-lg-6 ml-auto">
                    <div class="card">
                        <div class="card-body text-dark">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <input type="hidden" id="timezone_offset_minutes" name="timezone_offset_minutes" value="" />

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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg mb-2">{{ __('Sign in') }}</button>
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
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

@section('scripts')
<script type="text/javascript">
var iTimezoneOffsetMinutes = new Date().getTimezoneOffset(),
    iTimezoneOffsetMinutes = (iTimezoneOffsetMinutes == 0) ? 0 : -iTimezoneOffsetMinutes;

document.getElementById('timezone_offset_minutes').value = iTimezoneOffsetMinutes;
</script>
@endsection