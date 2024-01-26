@extends('admin.layout.default')
@section('title','Teachers')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
    @slot('title') Teachers @endslot
    @slot('add_btn') <a href="{{url('admin/teachers/create')}}" class="align-top btn btn-sm btn-success">Add New</a> @endslot
    @slot('active') Teachers @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Photo','Teacher Name','Email','Subject','Status','Action']
])
    @slot('table_id') teachers-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->

<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#teachers-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "teachers",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth:'10px'},
            {data: 'image', name: 'image'},
            {data: 'teacher_name', name: 'teacher_name'},
            {data: 'email', name: 'teacher_name'},
            {data: 'subject_name', name: 'designation'},
            {data: 'status', name: 'status',sWidth:'50px'},
            {data: 'action', name: 'action',sWidth:'100px'}
        ]
    });
</script>
@stop