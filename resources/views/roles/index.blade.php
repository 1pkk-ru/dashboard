{{-- Extend Layout --}}
@extends($viewNamespace . '::layouts.index')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.roles.all.title'))

{{-- Page Title --}}
@section('page-title', trans('dashboard::dashboard.roles.all.page_title'))

{{-- Page Subtitle --}}
@section('page-subtitle', trans('dashboard::dashboard.roles.all.page_subtitle'))

{{-- Columns --}}
@section('columns')

    @foreach($columns as $c)
        <th>{{ $c }}</th>
    @endforeach

@stop

{{-- Models --}}
@section('models')
    @foreach($models as $m)
        <tr>
            @foreach($columns as $attr => $c)

                @if($attr == 'id')
                    <td class="text-center col-xs-1">
                        <a href="{{ $m->edit_route }}">{{ $m->$attr }}</a>
                    </td>
                @elseif($attr != 'actions')
                    <td>{{ $m->$attr }}</td>
                @else
                    <td class="text-center col-xs-1">
                        {!! BootForm::open()->delete()->action($m->delete_route) !!}

                        <a href="{{ $m->edit_route }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>

                        {!! BootForm::submit('<i class="fa fa-trash"></i><span class="sr-only">Delete</span>')->addClass('btn btn-xs btn-danger')->removeClass('btn-default')->data('toggle', 'tooltip')->data('placement', 'top')->title('Delete') !!}

                        {!! BootForm::close() !!}
                    </td>
                @endif

            @endforeach
        </tr>
    @endforeach
@stop