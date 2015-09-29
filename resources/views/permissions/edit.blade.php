{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.edit')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.permissions.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.permissions.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.permissions.edit.page_subtitle'))

{{-- Content Section --}}
@section('form')

    {{-- Permission Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.slug'), 'slug') !!}
        </div>
    </div>

@stop
