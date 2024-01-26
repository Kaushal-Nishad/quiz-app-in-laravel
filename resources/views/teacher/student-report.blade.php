@extends('teacher.layout.default')
@section('title','Student Report')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Students'=>'teacher/my-students']])
    @slot('title') Student Report @endslot
    @slot('add_btn') @endslot
    @slot('active') Student Report @endslot
@endcomponent
<!-- /.content-header -->
<div class="x_panel">
    <div class="x_content">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Student Name : </strong> {{$student->student_name}}</td>
                    <td><strong>Reg. No. :</strong> {{$student->register_no}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Quiz Title','Questions','Attempt','Correct','Duration','Date']
])
    @slot('table_id') report-list @endslot
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
       //  alert(id);

        var table = $("#report-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: id,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '10px'},
            {data: 'quizz_title', name: 'Quiz Title'},
            {data: 'questions', name: 'questions'},
            {data: 'total_attempt', name: 'attempt'},
            {data: 'correct', name: 'correct'},
            {data: 'duration', name: 'duration'},
            {data: 'started', name: 'date'},
        ]
        });
    });
</script>
@stop