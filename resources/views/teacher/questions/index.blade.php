@extends('teacher.layout.default')
@section('title','Questions')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home']])
    @slot('title') Questions @endslot
    @slot('add_btn') <a href="{{url('teacher/questions/create')}}" class="align-top btn btn-sm btn-success">Add New</a> @endslot
    @slot('active') Questions @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Question','Quiz Name','Image','Action']
])
    @slot('table_id')question-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#question-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "questions",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth:"10px"},
            {data: 'question', name: 'question'},
            {data: 'quizz_title', name: 'quizz_title'},
            {data: 'image', name: 'image',sWidth:'80px'},
            {
                data: 'action',
                name: 'action',
                sWidth: '50px'
            }
        ]
    });
</script>
@stop