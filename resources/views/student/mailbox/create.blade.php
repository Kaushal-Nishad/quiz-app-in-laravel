@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') Mailbox @endslot
    @slot('add_btn') <a href="{{url('student/mailbox')}}" class="btn btn-dark float-right">Back</a> @endslot
@endcomponent
<!-- Main content -->
<section class="content">
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Form validation  -->
            <form class="form-horizontal" id="addStudentmailbox" method="POST" novalidate>
            @csrf  
            <input type="hidden" class="url" value="{{url('student/mailbox/add')}}" > 
            <input type="hidden" class="rdt-url" value="{{url('student/mailbox/sent')}}" >    
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Compose New Message</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <label>TO:</label>
                    <select name="receiver" class="form-control" >
                        <option value="0" disabled >Select Teacher</option>
                        <?php  $m_to = '';
                        if(isset($_GET['tr']) && $_GET['tr'] != ''){
                            $m_to = $_GET['tr'];
                        } ?>
                        @if(!empty($teacher))
                            @foreach($teacher as $types)
                              @php $checked = '';  @endphp  
                              @if($m_to != '')
                                @php $checked = ($m_to == $types->teacher_id)? 'selected' : ''; @endphp
                              @endif
                                <option value="{{$types->teacher_id}}" {{$checked}}>{{$types->teacher_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label>Title:</label>
                    <?php  $m_title = '';
                    if(isset($_GET['title']) && $_GET['title'] != ''){
                        $m_title = $_GET['title'];
                    } ?>
                    <input class="form-control" name="title" value="{{$m_title}}" placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea id="compose-textarea" class="form-control" style="height: 500px" placeholder="Description" name="description"></textarea>
                    
                </div>
                <div class="form-group">
                    <div class="form-group row">
                        <label class="col-md-2">Image</label>
                        <div class="custom-file col-md-7">
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            <img id="image" src="{{asset('mailbox/default.png')}}" alt=""  width="80px" height="80px">
                        </div>
                    </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            </form>
            <!-- /.Form validation  -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container --> 
</section>  
@stop
@section('pageJsScripts')
<!-- Summernote -->
<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
<script>
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
  $(function() {
    //Add text editor
    $('#compose-textarea').summernote();
  })
</script>
@stop