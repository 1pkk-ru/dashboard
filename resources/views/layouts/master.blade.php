<!DOCTYPE html>
<html lang="en">
<head>

    {{-- Include Head --}}
    @include($viewNamespace . '::global.head')

    {{-- Header Extras Section --}}
    @yield('header-extras')

</head>
<body class="{{ config('laraflock.dashboard.theme') }} sidebar-mini">
<div class="wrapper">

    {{-- Include Header --}}
    @include($viewNamespace . '::global.header')

    {{-- Include Sidebar --}}
    @include($viewNamespace . '::global.sidebar')

    <div class="content-wrapper">

        {{-- Header Section --}}
        <section class="content-header">
            <h1>

                {{-- Page Title --}}
                @yield('page-title')

                {{-- Page Subtitle --}}
                <small>@yield('page-subtitle')</small>

            </h1>
        </section>

        {{-- Content Section --}}
        <section class="content">

            {{-- Include Flash Messages --}}
            @include('flash::message')

            {{-- Content Section --}}
            @yield('content')

        </section>

    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>{{ trans('dashboard::dashboard.global.version') }}</b> {{ trans('dashboard::dashboard.global.version_num') }}
        </div>
        <strong>{{ trans('dashboard::dashboard.global.copyright') }} &copy; {{ date('Y') }} {{ trans('dashboard::dashboard.global.credits') }}.</strong> {{ trans('dashboard::dashboard.global.rights_reserved') }}
    </footer>

</div>

{{-- Include Footer Scripts --}}
@include($viewNamespace . '::global.footer-scripts')

{{-- Footer Extras Section --}}
@yield('footer-extras')

</body>
</html>