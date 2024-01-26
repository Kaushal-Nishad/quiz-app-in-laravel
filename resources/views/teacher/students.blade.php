@extends('teacher.layout.default')
@section('title','Online Quizzes')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home']])
    @slot('title') Students @endslot
    @slot('add_btn') @endslot
    @slot('active') Students @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Reg. No.','Student Name','Status','Report']
])
    @slot('table_id') quizz-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#quizz-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "my-students",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '10px'},
            {data: 'register_no', name: 'register_no'},
            {data: 'student_name', name: 'student_name'},
            {data: 'status', name: 'status'},
            {data: 'report', name: 'report'},
        ]
    });
</script>
@stop