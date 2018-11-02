<nav class="navbar navbar-lg navbar-expand-lg navbar-transparant navbar-dark navbar-absolute w-100">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Prode') }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            @guest
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ (url()->current() == route('login')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Sign in') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item {{ (url()->current() == route('register')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{ locale()->nameFor(locale()->current()) }}</span>
                    </a>
                    <div class="dropdown-menu">
                        @foreach (locale()->supported() as $sLocale)
                            @php
                            if ($sLocale == locale()->current())
                                continue;
                            @endphp
                        <a class="dropdown-item" href="{{ route('locale.edit', ['sLocale'=>$sLocale]) }}">{{ locale()->nameFor($sLocale) }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            @endguest
        </div>
    </div>
</nav>