@extends('layouts.web')

@section('content')
<div class="intro py-5 py-lg-9 position-relative text-white">
    <div class="bg-overlay-primary">
        <img src="{{ asset('images/cover.jpg') }}" class="img-fluid img-cover" alt="{{ config('app.name', 'Prode') }}" />
    </div>
    <div class="intro-content pt-8 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h1 class="display-4 mb-3">{{ __('Reset Password') }}</h1>
                    <p class="lead mb-4">&nbsp;</p>
                </div>
                <div class="col-md-5 ml-auto">
                    <div class="card">
                        <div class="card-body text-dark">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your e-mail address') }}" required autofocus />

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg mb-2">{{ __('Send Password Reset Link') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
