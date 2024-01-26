@extends('student.layout.default')
@section('content')

<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') Leader Board @endslot
    @slot('add_btn') <a href="{{url('student/my-quizzes')}}" class="btn btn-dark float-right">Back</a> @endslot
@endcomponent

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <table table class="table table-bordered mb-5">
                            <tbody>
                                <tr>
                                    <td><strong>Quiz Title : </strong> {{$quiz->quizzy_title}}</td>
                                    <td><strong>Questions :</strong> {{$quiz->questions}}</td>
                                    <td><strong>Duration :</strong> {{$quiz->duration}} Mins.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-responsive mailbox-messages">
                            <table id="leaderboard" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Quiz Title</th>
                                <th>Student Name</th>
                                <th>Questions</th>
                                <th>Attempt</th>
                                <th>Correct</th>
                                <th>Duartion</th>
                                <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                    </div>
                </div>
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
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
                {data: 'quizzy_title', name: 'quizzy_title'},
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