@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') @endslot
    @slot('add_btn') <a href="{{url('student/mailbox')}}" class="btn btn-dark float-right">Back</a> @endslot
@endcomponent
<!-- Main content -->
<section class="content">
  <div class="container">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            {{ method_field('PATCH') }}
            
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">{{$mailbox->mail_title}}</h3>
              </div>
               <input type="hidden" class="id" value="{{$mailbox->mail_id}}" >  
                <input type="hidden" class="url" value="{{url('mailbox/reply')}}" >  
                <input type="hidden" class="rdt-url" value="{{url('student/mailbox')}}" > 
              <!-- /.card-header -->
              <!-- start recent activity -->
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important; margin:0 0 0 20px">
                <div class="media media-chat"> <img class="avatar" src="{{asset('student/default.png')}}" alt="...">
                    <div class="media-body">
                        <h4>{{$mailbox->teacher_name}}</h4>
                        <p>{!!htmlspecialchars_decode($mailbox->mail_des)!!} </p>
                        @if($mailbox->mail_img != '')
                          <img src="{{asset('mailbox/'.$mailbox->mail_img)}}" alt="{{$mailbox->mail_img}}" width="150px">
                          @endif
                        <p class="meta"><time datetime="2021">{{date('H:i:s',strtotime($mailbox->created_at))}}</time></p>
                    </div>
                </div>
                <a href="{{url('student/mailbox/create?tr='.$mailbox->sender_id.'&title='.$mailbox->mail_title)}}" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Reply</a>
                </div>
            </div> 
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container --> 
</section>  
@stop
