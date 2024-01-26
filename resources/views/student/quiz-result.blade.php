@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->

<!-- Main content -->
<div class="content p-4">
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$quiz_data->quizzy_title}}</h5>
                </div>
                <div class="card-body">
                    {{$quiz_data->quizzy_des}}
                </div>
                <div class="card-footer clearfix">
                    <span class="float-left">Questions: {{$quiz_data->questions}}</span>
                    <span class="float-right">Duration: {{$quiz_data->duration}} Mins</span>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Summary</h5>
                </div>
                <div class="card-body row">
                    <div class="col-4 mb-3">
                        <span class="btn btn-primary">{{$participant->questions}}</span>
                        <h5 class="d-inline-block">Total Questions</h5>
                    </div>
                    <div class="col-4 mb-3">
                        <span class="btn btn-warning">{{$participant->total_attempt}}</span>
                        <h5 class="d-inline-block">Total Attempt Questions</h5>
                    </div>
                    <div class="col-4 mb-3">
                        <span class="btn btn-success">{{$participant->correct}}</span>
                        <h5 class="d-inline-block">Correct Answers</h5>
                    </div>
                    <div class="col-4 mb-3">
                        <span class="btn btn-danger">{{$participant->total_attempt - $participant->correct}}</span>
                        <h5 class="d-inline-block">Incorrect Answers</h5>
                    </div>
                    <div class="col-4 mb-3">
                        <span class="btn btn-info">{{$participant->questions -$participant->total_attempt}}</span>
                        <h5 class="d-inline-block">Not Attempted</h5>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Questions Detail</h5>
                </div>
                <div class="card-body">
                    @foreach($participant_questions as $q)
                    
                    <div class="card card-secondary">
                        <div class="card-header">
                        <h5 class="card-title"></h5>Question : {{$q->question}}</div>
                        <div class="card-body">
                            @php
                                $choices = json_decode(json_decode($q->choices));
                            @endphp
                            <ul class="list-group list-group-horizontal-lg">
                                @for($l=0;$l<count($choices);$l++)
                                    @php
                                        $bg = (($l+1) == $q->correct_answer) ? 'bg-success' : '';
                                        $wbg = '';
                                        if($q->is_correct == '0' && $q->student_answer != ''){
                                            $wbg = (($l+1) == (int)$q->student_answer) ? 'bg-danger' : '';
                                        }
                                    @endphp
                                    
                                <li class="list-group-item {{$wbg}} {{$bg}}">{{$choices[$l]}}</li>
                                @endfor
                            </ul>
                        </div>
                        <div class="card-footer">
                            @if($q->is_correct == '1')
                                <span class="badge badge-success">Correct</span>
                            @elseif($q->is_correct == '0' && $q->student_answer == '')
                                <span class="badge badge-warning">Not Attempted</span>
                            @else
                                <span class="badge badge-danger">Incorrect</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    @php
                        $start = date_create($participant->started);
                        $end = date_create($participant->completed);
                        $diff = date_diff($end,$start);
                    @endphp
                    <span>Time Spend:-  {{$diff->i.' Mins '.$diff->s.' Secs. '}}</span>
                </div>
            </div>
        </div>
        
    </div>
    <!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
@stop