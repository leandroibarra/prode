<nav class="navbar navbar-lg navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Prode') }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {{ (url()->current() == route('home.index')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home.index') }}">{{ __('Home') }}</a>
                </li>
                @php
                $iCompetitionId = request()->route()->iCompetitionId;
                @endphp

                @if (!is_null($iCompetitionId))
                <li class="nav-item {{ (request()->route()->getName() == 'dashboard.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.index', ['iCompetitionId'=>$iCompetitionId]) }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item {{ (request()->route()->getName() == 'ranking.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('ranking.index', ['iCompetitionId'=>$iCompetitionId]) }}">{{ __('Ranking') }}</a>
                </li>
                @endif
            </ul>
            <div class="dropdown ml-1">
                <button class="btn btn-outline-white dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Sign out') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>