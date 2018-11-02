<footer class="py-6 lh-1 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <h3 class="h4 mb-4">{{ config('app.name', 'Prode') }}</h3>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <h4 class="h6">{{ __('Source Code') }}</h4>
                        <ul class="list-unstyled">
                            <li>
                                <a href="https://github.com/leandroibarra/prode" target="_blank">
                                    <i class="fab fa-github"></i>
                                    {{ __('GitHub') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h4 class="h6">{{ __('Author') }}</h4>
                        <ul class="list-unstyled">
                            <li>
                                <a href="https://github.com/leandroibarra" target="_blank">Leandro Ibarra</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <h4 class="h6">{{ __('License') }}</h4>
                        <ul class="list-unstyled">
                            <li>
                                <a href="https://github.com/leandroibarra/prode/blob/master/LICENSE" target="_blank">{{ __('MIT License') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center text-sm">
                <p class="mb-0">&copy; {{ date('Y') }} - <a href="{{ url('/') }}">{{ config('app.name', 'Prode') }}</a></p>
            </div>
        </div>
    </div>
</footer>