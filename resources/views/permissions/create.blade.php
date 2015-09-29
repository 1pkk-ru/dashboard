{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.permissions.create.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.permissions.create.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.permissions.create.page_subtitle'))

{{-- Content Section --}}
@section('form')

    {{-- Permission Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text('Name', 'name') !!}
            {!! BootForm::text('Slug', 'slug') !!}
        </div>
    </div>

@stop
