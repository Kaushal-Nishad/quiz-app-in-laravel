@extends('admin.layout.default')
@section('title','Student')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
    @slot('title') Students @endslot
    @slot('add_btn') <a href="{{url('admin/students/create')}}" class="align-top btn btn-sm btn-success">Add New</a> @endslot
    @slot('active') Students @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['Student Id','Image','Name','email','Status','Action']
])
    @slot('table_id') students-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript">
    var table = $("#students-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "students",
        columns: [
            {data: 'register_no', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'student_name', name: 'student_name'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });
</script>
@stop