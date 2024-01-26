@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') My Quiz History @endslot
    @slot('add_btn') @endslot
@endcomponent
<!-- Main content -->
<div class="content">
    <div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-borderd bg-white">
                <thead class="bg-dark">
                    <tr>
                        <td>Title</td>
                        <td>Questions</td>
                        <td>Attended</td>
                        <td>Correct</td>
                        <td>Wrong</td>
                        <td>Date</td>
                        <td>View</td>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($history))
                    @foreach($history as $h)
                        <tr>
                            <td>{{$h->quizz_title}}</td>
                            <td>{{$h->questions}}</td>
                            <td>{{$h->total_attempt}}</td>
                            <td>{{$h->correct}}</td>
                            <td>{{$h->total_attempt - $h->correct}}</td>
                            <td>{{date('d M, Y',strtotime($h->started))}}</td>
                            <td><a href="{{url('student/q/summary/'.$h->p_id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6" >No Quiz History Found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
@stop