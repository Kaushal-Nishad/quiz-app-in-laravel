@extends('admin.layout.default')
@section('title','Questions')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
    @slot('title') Questions @endslot
    @slot('add_btn') @endslot
    @slot('active') Questions @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['S.No.','Question','Choices','Quiz Title','Teacher Name','Image','Created On']
])
    @slot('table_id') question-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript">
    var table = $("#question-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "questions",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'question', name: 'title'},
            {data: 'choice_list', name: 'choices'},
            {data: 'quizz_title', name: 'questions'},
            {data: 'teacher_name', name: 'teacher_name'},
            {data: 'image', name: 'duration'},
            {data: 'created_at', name: 'created_on'},
        ]
    });
</script>
@stop