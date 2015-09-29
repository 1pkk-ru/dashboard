{{-- Extends Master Layout --}}
@extends($viewNamespace . '::layouts.edit')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.roles.edit.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.roles.edit.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.roles.edit.page_subtitle'))

{{-- Content Section --}}
@section('form')

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

@stop
