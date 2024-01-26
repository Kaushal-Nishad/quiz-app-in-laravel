@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') My Quizzes @endslot
    @slot('add_btn') @endslot
@endcomponent
<!-- Main content -->
<div class="content">
    <div class="container">
    <div class="row">
        @foreach($quizzes as $item)
        @if($item->q_count > 0)
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h5 class="card-title m-0">{{$item->quizzy_title}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{$item->quizzy_des}}</p>
                    <strong>Total Questions :</strong>
                    <span>{{$item->q_count}}</span><br>
                    <strong>Total Time:</strong>
                    <span>{{$item->duration}} Mins.</span>
                </div>
                <div class="card-footer">
                    @php
                    $running = (session()->get('test_session')) ? 'test-running' : '';
                    @endphp
                    <a href="{{url('student/q/instruction/'.$item->quizz_slug)}}" class="btn btn-dark float-left {{$running}}">Start Quiz</a>
                    <a href="{{url('student/quiz/leaderboard/'.$item->quizz_slug)}}" class="btn btn-info float-right {{$running}}">Leader Board</a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
@stop
@section('pageJsScripts')
<script src="{{asset('assets/js/sweetalert.min.js')}}" ></script>
@if(session()->get('test_session'))
@php
$text = session()->get('test_session')["quiz_data"]["quizzy_slug"];

@endphp
<script>
    
    $(".test-running").on("click", function (e) {
    e.preventDefault();
    var link = "<?php echo $text; ?>";
    swal({
        title: "Quiz Already Running",
        text: "Please Complete Or Stop Running Quiz",
        icon: "warning",
        buttons: ['Stop Quiz','Resume Quiz'],
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: "Resume Quiz",
        cancelButtonText: "Stop Quiz",
      }).then((value)=>{
          if(value == 'null'){
            var origin = window.location.origin;
            var path = window.location.pathname.split( '/' );
            var URL = origin+'/'+path[1]+'/';
            window.location.href = URL+'q/result/'+link;
          }else{
            var origin = window.location.origin;
            var path = window.location.pathname.split( '/' );
            var URL = origin+'/'+path[1]+'/';
            window.location.href = URL+'quiz/'+link+'/1';
          }
      });
      
  });
//     $.notify({
// 	// options
// 	message: 'Hello World',
     
// },{
// 	// settings
// 	type: 'danger',
//     allow_dismiss: false,
//     z_index: 2000,
//     showProgressbar: true,
// });
</script>

@endif


    
@stop