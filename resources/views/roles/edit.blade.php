{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.edit')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.roles.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.roles.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.roles.edit.page_subtitle'))

{{-- Content Section --}}
@section('content')

    {{-- Open Form --}}
    {!! BootForm::open()->post()->action($model->edit_route)->multipart() !!}

    {{-- Bind Model to Form for Filling out Inputs --}}
    {!! BootForm::bind($model) !!}

    {{-- Role Box --}}
    <div class="box">
        <div class="box-body">
            {!! BootForm::text(trans('dashboard::dashboard.form.name'), 'name') !!}
            {!! BootForm::text(trans('dashboard::dashboard.form.slug'), 'slug') !!}
            <div class="form-group">
                <label>{{ trans('dashboard::dashboard.form.permissions') }}</label>

                <div class="clearfix"></div>
                @foreach($permissions as $permission)
                    @if(is_array($model->permissions) && array_key_exists($permission->slug, $model->permissions))
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]")->check() !!}
                    @else
                        {!! BootForm::inlineCheckbox($permission->name, "permissions[{$permission->slug}]") !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Include Form Actions for Edit --}}
    @include($viewNamespace . '::helpers.form.actions-edit')

    {{-- Close Form --}}
    {!! BootForm::close() !!}

@stop
