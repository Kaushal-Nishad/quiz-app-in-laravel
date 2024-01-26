@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') {{$quiz->quizz_title}} @endslot
    @slot('add_btn') <a href="{{url('student/my-quizzes')}}" class="btn btn-dark float-right">Back</a> @endslot
@endcomponent
<!-- Main content -->
<div class="content">
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="card-title">Description</h5>
                </div>
                <div class="card-body">
                    <p>{{$quiz->quizz_des}}</p>
                </div>
            </div>
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="card-title">Instruction</h5>
                </div>
                <div class="card-body">
                    <p>{!!htmlspecialchars_decode($quiz->instruction)!!}</p>
                </div>
            </div>
            <a href="{{url('student/q/start/'.$quiz->quizz_slug)}}" class="btn btn-success d-block">Start Quiz</a>
        </div>
    </div>
    <!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
@stop