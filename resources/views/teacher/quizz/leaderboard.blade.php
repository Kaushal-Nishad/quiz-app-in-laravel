@extends('teacher.layout.default')
@section('title','Leader Board')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Quizzes'=>'teacher/quizzes']])
    @slot('title') Leader Board @endslot
    @slot('add_btn') @endslot
    @slot('active') Leader Board @endslot
@endcomponent
<!-- /.content-header -->
<div class="x_panel">
    <div class="x_content">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Quiz Title :</strong> {{$quiz->quizz_title}}</td>
                    <td><strong>Questions :</strong> {{$quiz->questions}}</td>
                    <td><strong>Duration :</strong> {{$quiz->duration}} Mins.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Quiz Title','Student Name','Questions','Attempt','Correct','Duration','Date']
])
    @slot('table_id') leaderboard @endslot
@endcomponent

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var path = window.location.pathname.split( '/' );
        var id = path[path.length -1];
        var table = $("#leaderboard").DataTable({
            processing: true,
            serverSide: true,
            ajax: id,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '10px'},
                {data: 'quizz_title', name: 'quizz_title'},
                {data: 'student_name', name: 'student_name'},
                {data: 'questions', name: 'questions'},
                {data: 'total_attempt', name: 'attempt'},
                {data: 'correct', name: 'correct'},
                {data: 'duration', name: 'duration'},
                {data: 'started', name: 'started'},
            ]
        });
    });
</script>
@stop