<a id="show-sidebar" class="btn btn-sm btn-dark" href="javascript:void(0);">
    <i class="fas fa-bars"></i>
</a>
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="/">{{ config('app.name', 'Prode') }}</a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="user-pic">
                <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/bootstrap4/assets/img/user.jpg" alt="User picture">
            </div>
            <div class="user-info">
                <span class="user-name">
                    <strong>{{ Auth::user()->name }}</strong>
                </span>
                {{--<span class="user-role">Administrator</span>--}}
                <a class="logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                    <span>{{ __('Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </div>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-menu">
            <ul>
                {{--<li class="header-menu">
                    <span>General</span>
                </li>--}}
                <li>
                    <a href="{{ route('dashboard.index', ['iCompetitionId'=>1]) }}">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ranking.index', ['iCompetitionId'=>1]) }}">
                        <i class="fa fa-trophy"></i>
                        <span>Ranking</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/') }}">
                        <i class="far fa-list-alt"></i>
                        <span>Rules</span>
                    </a>
                </li>
                {{--<li class="sidebar-dropdown">
                    <a href="#">
                        <i class="fa fa-chart-line"></i>
                        <span>Charts</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="#">Pie chart</a>
                            </li>
                            <li>
                                <a href="#">Line chart</a>
                            </li>
                            <li>
                                <a href="#">Bar chart</a>
                            </li>
                            <li>
                                <a href="#">Histogram</a>
                            </li>
                        </ul>
                    </div>
                </li>--}}
            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
</nav>