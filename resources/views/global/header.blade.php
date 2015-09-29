<header class="main-header">
    <a href="{{ route('dashboard.index') }}" class="logo">
        <span class="logo-mini">{{ trans('dashboard::dashboard.global.small_title') }}</span>
        <span class="logo-lg">{{ trans('dashboard::dashboard.global.title') }}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('dashboard::dashboard.global.toggle_nav') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        @if ($activeUser)
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="user user-menu"><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out"></i> Sign out</a></li>
                </ul>
            </div>
        @endif
    </nav>
</header>