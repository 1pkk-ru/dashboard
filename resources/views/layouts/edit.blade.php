{{-- Extend Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Header Extras to be Included --}}
@section('header-extras')

@stop

{{-- Content Section --}}
@section('content')

    {{-- Open Form --}}
    {!! BootForm::open()->post()->action(route($editRoute, ['id' => $model->id]))->multipart() !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($model) !!}

    {{-- Form Section --}}
    @yield('form')

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')

    {{-- Close Form --}}
    {!! BootForm::close() !!}

@stop

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@stop