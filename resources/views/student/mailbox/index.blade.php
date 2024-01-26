@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') Inbox @endslot
    @slot('add_btn') <a href="{{url('student/mailbox/create')}}" class="btn btn-primary float-right">Compose</a> @endslot
@endcomponent
<!-- Main content -->
<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-3 card">
        <div class="card-body p-0">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item active">
              <a href="{{url('student/mailbox')}}" class="nav-link active"><i class="fas fa-inbox"></i> Inbox</a>
            </li>
            <li class="nav-item">
              <a href="{{url('student/mailbox/sent')}}" class="nav-link"><i class="far fa-envelope"></i> Sent Mail</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="table-responsive mailbox-messages">
            <table id="mail-list" class="table table-hover table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>Teacher Name</th>
                  <th>Message Title</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <!-- /.table -->
          </div>
          </div>
        </div>
      </div>
    </div> <!-- /.row -->
  </div><!-- /.container --> 
</section>    
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
            {data: 'sender', name: 'recevier',sWidth: '200px'},
            {data: 'mail_title', name: 'mail_title'},
            {data: 'created_at', name: 'date',sWidth: '100px'},
            
        ],
        "order": [[ 0, "desc" ]]
    });
</script>
@stop