@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') {{$quiz_title}}  <div class="d-inline ml-2 float-right"> Count Down :<div class="timer d-inline" data-seconds-left="{{$left_time}}"></div></div> @endslot
    @slot('add_btn')  @endslot
@endcomponent
<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="offset-2 col-8">
                <form class="card test-form" method="POST">
                @csrf
                    <div class="card-header bg-dark clearfix">
                        <h6 class="card-title float-left"><strong>Question No. {{$id}}</h6>
                        <div class="float-right">{{$id}}/{{$total_question}}</div>
                    </div>
                    <div class="card-header">
                        <h6 class="card-title"><strong>Q : </strong>{{$question_data->question}}</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $choices = json_decode(json_decode($question_data->choices));
                            $choices_count = count($choices);
                        @endphp

                        @for($i=0;$i<$choices_count;$i++)
                        @php $q_answer = isset($question_data->answer)  ?  $question_data->answer : NULL; @endphp
                        @php $checked = ''; @endphp
                        @if($i == ($q_answer-1))
                            @php $checked = 'checked'; @endphp
                        @endif
                        <div class="form-group">
                                <input type="radio" id="optiob{{$i}}" {{$checked}} name="answer" value="{{$i+1}}">
                                <label for="option{{$i}}">{{$choices[$i]}}</label>
                            </div>
                        @endfor
                    </div>
                    <div class="card-footer clearfix text-center">
                        @if($id > 1)
                        <button type="submit" name="previous" value="previous" class="btn btn-success mx-1 float-left">Previous</button>
                        @endif
                        @if($id < $total_question)
                        <button type="submit" name="next" value="next" class="btn btn-success mx-1 float-right">Next</button>
                        <button type="submit" name="save_next" value="save_next" class="btn btn-success mx-1 float-right submit">Save and Next</button>
                        @endif
                        <button type="submit" name="submit" value="submit" class="btn btn-success float-right mx-1 submit-test submit">Submit Test</button>
                    </div>
                </form>
            </div>
            
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.content -->
@stop

@section('pageJsScripts')
<!-- jQuery Simple Timer -->
    <script src="{{asset('assets/js/jquery.simple.timer.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    @if($id < $total_question)
    <script>
        window.onbeforeunload = function(){
            alert(1);
            swal({
                title: "Are you Sure",
                text: "Your Total Attempt is ",
                type: "warning",
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: 'Ok, Submit',
                cancelButtonText: 'Cancel',
              },
              function(isConfirm){
                if (isConfirm == true) {
                  var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "submit_test")
                    .val("submit_test");

                  $(".test-form").append($(input));
                  $(".test-form").submit();
                }
              }
            );
        };
    </script>
    @endif
    <script>
        
        
        $('.timer').startTimer();

        // $('.test-form').submit(function(e){
        $('.submit').click(function(e){
           if($('input[name=answer]').is(':checked')){
           }else{
               e.preventDefault();
               swal({
                    title: "No answer given yet",
                });
           }

        });

    </script>
@stop