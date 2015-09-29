{{-- Extend Layout --}}
@extends($viewNamespace . '::layouts.master')

{{-- Header Extras to be Included --}}
@section('header-extras')

    {{-- Data Table Styles --}}
    <link href="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>

@stop

{{-- Content Section --}}
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <table class="table">
                <thead>
                <tr>
                    @yield('columns')
                </tr>
                </thead>
                <tbody>

                @yield('models')

                </tbody>
            </table>
        </div>
    </div>
@stop

{{-- Footer Extras to be Included --}}
@section('footer-extras')

    {{-- Data Table Scripts --}}
    <script src="{{ asset('vendor/laraflock/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/laraflock/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    {{-- Initiate DataTable --}}
    <script type="text/javascript">
        $(function () {
            $('#index').dataTable({
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false
                }]
            });
        });
    </script>

@stop