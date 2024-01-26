@extends('teacher.layout.default')
@section('title','Mailbox')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home']])
    @slot('title') Inbox @endslot
    @slot('add_btn') <a href="{{url('teacher/mailbox/create')}}" class="align-top btn btn-sm btn-success">Compose</a> @endslot
    @slot('active') Mailbox @endslot
@endcomponent


<div class="col-md-12 col-sm-12 ">
    <div class="x_content">
        <div class="row">
            <div class="col-sm-3">
                <ul style="padding:0;margin:0;list-style:none;">
                    <li><a href="{{url('teacher/mailbox')}}" class="btn btn-success" style="width:100%;">Inbox</a></li>
                    <li><a href="{{url('teacher/mailbox/sent')}}" class="btn btn-secondary" style="width:100%;">Sent Mail</a></li>
                </ul>
            </div>
            <div class="col-sm-9">
            <div class="card-box table-responsive">
                <table id="mail-list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                   <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Title</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#mail-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "mailbox", 
        columns: [
            {data: 'status', name: 'status',sWidth: '10px'},
            {data: 'sender', name: 'sender',sWidth: '200px'},
            {data: 'mail_title', name: 'mail_title'},
            {data: 'created_at', name: 'date',sWidth: '100px'},
            
        ],
        "order": [[ 0, "desc" ]]
    });
</script>
@stop
