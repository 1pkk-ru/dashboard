{{-- Extend Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Header Extras to be Included --}}
@section('header-extras')

@stop

{{-- Content Section --}}
@section('content')

    {{-- Open Form --}}
    {!! BootForm::open()->post()->action(route($createRoute))->multipart() !!}

    {{-- Form Section --}}
    @yield('form')

    {{-- Include Form Actions for Create --}}
    @include($viewNamespace . '::helpers.form.actions-create')

    {{-- Close Form --}}
    {!! BootForm::close() !!}

@stop

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@stop