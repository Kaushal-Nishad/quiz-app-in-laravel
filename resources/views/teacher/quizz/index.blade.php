@extends('teacher.layout.default')
@section('title','Online Quizzes')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home']])
    @slot('title') Quizzes @endslot
    @slot('add_btn') <a href="{{url('teacher/quizzes/create')}}" class="align-top btn btn-sm btn-success">Add New</a> @endslot
    @slot('active') Online Quizzes @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Quiz Title','Duration','Questions','Published','LeaderBoard','Action']
])
    @slot('table_id') quizzy-list @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#quizzy-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "quizzes",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '10px'},
            {data: 'quizz_title', name: 'quizz_title'},
            {data: 'duration', name: 'duration'},
            {data: 'questions', name: 'questions'},
            {data: 'status', name: 'status'},
            {data: 'leaderboard', name: 'leaderboard'},
            {
                data: 'action',
                name: 'action',
                sWidth: '40px'
            }
            
        ]
    });
</script>
@stop