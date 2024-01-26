@extends('admin.layout.default')
@section('title','Subjects')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'dashboard']])
    @slot('title') Subjects @endslot
    @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-success">Add New</button> @endslot
    @slot('active') Subjects @endslot
@endcomponent
<!-- /.content-header -->
<!-- show data table -->
@component('admin.layout.data-table',['thead'=>
    ['#','Subject Name','Action']
])
    @slot('table_id') subjects-list @endslot
@endcomponent
<!-- add new subject modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <form  id="add_subject" method="POST" >
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Subject Name</label>
                        <input type="text" name="sub_name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Subject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <form  id="edit_subject" method="POST" >
                    <div class="modal-body">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                        <label>Subject Name</label>
                            <input type="text" name="sub_name" class="form-control">
                            <input type="hidden" name="id">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary ">Update</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop
@section('pageJsScripts')
<!-- Datatables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap.js')}}"></script>
<script type="text/javascript">
    var table = $("#subjects-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "subjects",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth:'10px'},
            {data: 'subject_name', name: 'subject_name'},
            {
                data: 'action',
                name: 'action',
                sWidth:'50px'
            }
        ]
    });
</script>
@stop