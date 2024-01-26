@extends('teacher.layout.default')
@section('title','Mailbox')
@section('content')
<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Mailbox'=> 'teacher/mailbox']])
    @slot('title') @endslot
    @slot('add_btn') @endslot
    @slot('active') Mail @endslot
@endcomponent
        <div class="row" style="display: block;">
            <div class="col-sm-12">
                <div class="x_panel">
                    <div class="x_content">
                    {{ method_field('PATCH') }}
                    @php
                    //print_r($mailbox);
                    @endphp
                    <span class="section">{{$mailbox->mail_title}}</span>
                    <input type="hidden" class="id" value="{{$mailbox->mail_id}}" >  
                    <input type="hidden" class="url" value="{{url('mailbox/reply')}}" >  
                    <input type="hidden" class="rdt-url" value="{{url('teacher/mailbox')}}" > 
                    <!-- start recent activity -->
                    <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">
                    <div class="media media-chat"> <img class="avatar" src="{{asset('student/default.png')}}" alt="...">
                        <div class="media-body">
                            <h5>{{$mailbox->student_name}}</h5>
                            <p>{!!htmlspecialchars_decode($mailbox->mail_des)!!} </p>
                            @if($mailbox->mail_img != '')
                            <img src="{{asset('mailbox/'.$mailbox->mail_img)}}" alt="{{$mailbox->mail_img}}" width="150px">
                            @endif
                            <p class="meta"><time datetime="2021">{{date('H:i:s',strtotime($mailbox->created_at))}}</time></p>
                            
                        </div>
                    </div>
                    
                    <a href="{{url('teacher/mailbox/create?st='.$mailbox->sender_id.'&title='.$mailbox->mail_title)}}" class="btn btn-success btn-sm"><i class="fa fa-reply"></i> Reply</a>
                    
                </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- /page content -->
@stop