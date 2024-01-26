@extends('teacher.layout.default')
@section('title','Dashboard')
@section('content')
<div class="row" style="display:block;">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-3 col-sm-12  profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            @if($teacher->image != '')
                            <img class="img-responsive avatar-view" src="{{asset('teacher/'.$teacher->image)}}" alt="Avatar" width="100%" title="Change the avatar">
                            @else
                            <img class="img-responsive avatar-view" src="{{asset('teacher/default.png')}}" alt="Avatar" width="100%" title="Change the avatar">
                            @endif
                        </div>
                    </div>
                    <h3>{{$teacher->teacher_name}}</h3>
                    <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> {{$teacher->address}}</li>

                        <li><i class="fa fa-briefcase user-profile-icon"></i> {{$teacher->subject_name}} Teacher</li>

                        <li class="m-top-xs"><i class="fa fa-envelope user-profile-icon"></i> {{$teacher->email}}</li>
                    </ul>
                    <a class="btn btn-success" href="{{url('teacher/profile')}}"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="top_tiles">
                        <!-- <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 ">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-users"></i></div>
                                <div class="count">55</div>
                                <h3>Students</h3>
                            </div>
                        </div> -->
                        <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 ">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                                <div class="count">{{$quiz}}</div>
                                <h3>Quizzes</h3>
                            </div>
                        </div>
                    </div>
                    <div class="x_panel">
                        <h3 class="x_title">Latest Mails</h3>
                        @php //print_r($mailbox); @endphp
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($mailbox) > 0)
                                @foreach($mailbox as $mail)
                                    <tr>
                                        <td>
                                        @if($mail->status == '1')
                                            <span class="text-secondary"><i class="fa fa-circle"></i></span>
                                        @else
                                            <span class="text-success"><i class="fa fa-circle"></i></span>
                                        @endif
                                        </td>
                                        <td><a href="{{url('teacher/mailbox/singlepage/'.$mail->mail_id)}}">{{$mail->student_name}}</a></td>
                                        <td>{{$mail->mail_title}}</td>
                                        <td>{{date('d M, Y',strtotime($mail->created_at))}}</td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">No Records Found</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop