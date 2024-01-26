@extends('admin.layout.default')
@section('title','Dashboard')
@section('content')
<!-- <div> -->
<div class="row" style="display:inline-block;">

    <div class="top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-book"></i></div>
                <div class="count">{{$students}}</div>
                <h3>Subjects</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count"> {{$teachers}}</div>
                <h3>Teachers</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{$students}}</div>
                <h3>Students</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                <div class="count">{{$quizzes}}</div>
                <h3>Quizzes</h3>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Latest Quizzes</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Quiz Title</th>
                            <th>Teacher Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($latest_quizzes as $exam)
                        @php $i++; @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$exam->quizz_title}}</td>
                            <td>{{$exam->teacher_name}}</td>
                            <td>@php echo ($exam->status == '1')? 'Published' : 'Draft';  @endphp</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Latest Questions</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Question</th>
                            <th>Quiz Title</th>
                            <th>Teacher Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($latest_questions as $exam)
                        @php $i++; @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$exam->question}}</td>
                            <td>{{$exam->quizz_title}}</td>
                            <td>{{$exam->teacher_name}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop