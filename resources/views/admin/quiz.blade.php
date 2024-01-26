@extends('admin.layout.default')
@section('title','Quizzes')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
    @slot('title') Quizzes @endslot
    @slot('add_btn') @endslot
    @slot('active') Quizzes @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['S.No.','Quiz Title','Teacher Name','Questions Count','Duration','Published','Created On']
])
    @slot('table_id') quiz-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript">
    var table = $("#quiz-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "quizzes",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'quizz_title', name: 'title'},
            {data: 'teacher_name', name: 'name'},
            {data: 'questions', name: 'questions'},
            {data: 'duration', name: 'duration'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_on'},
        ]
    });
</script>
@stop