{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.edit')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.permissions.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.permissions.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.permissions.edit.page_subtitle'))

{{-- Content Section --}}
@section('content')

    {{-- Open Form --}}
    {!! BootForm::open()->post()->action($model->edit_route)->multipart() !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($model) !!}

    {{-- Permission Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.slug'), 'slug') !!}
        </div>
    </div>

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')

    {{-- Close Form --}}
    {!! BootForm::close() !!}

@stop
