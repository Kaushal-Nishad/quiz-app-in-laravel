@extends('teacher.layout.default')
@section('title','Mailbox')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Mailbox'=>'teacher/mailbox']])
    @slot('title') Compose @endslot
    @slot('add_btn') @endslot
    @slot('active') Compose @endslot
@endcomponent


<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="addMailbox"  method="POST" novalidate>
                    @csrf    
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-2 col-sm-12  label-align" >To</label>
                        <div class="col-md-9 col-sm-12 ">
                            <select name="receiver" class="form-control" >
                                <option value="0" selected disabled >Select Student</option>
                                @php $m_student = ''; @endphp
                                @if(isset($_GET['st']) && $_GET['st'] != '')
                                    @php $m_student = $_GET['st']; @endphp
                                @endif
                                @if(!empty($student))
                                    @foreach($student as $types)
                                        @php $selected = ($types->student_id == $m_student) ? 'selected' : '';  @endphp
                                        
                                        <option value="{{$types->student_id}}" {{$selected}}>{{$types->student_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Title<span class="required">*</span></label>
                        @php $m_title = ''; @endphp
                        @if(isset($_GET['title']) && $_GET['title'] != '')
                            @php $m_title = $_GET['title']; @endphp
                        @endif
                        <div class="col-md-9 col-sm-12">
                            <input class="form-control" name="title" value="{{$m_title}}" placeholder="Subject" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Description<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-12">
                        <textarea id="message" required="required" class="form-control" name="description" placeholder="Message" ></textarea>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Attachment</label>
                        <div class="col-md-6 col-sm-12">
                            <input type="file" name="img" onChange="readURL(this);">
                        </div>
                        <div class="col-md-3 col-sm-12 text-right">
                            <img id="image" src="{{asset('mailbox/default.png')}}" alt=""  width="80px">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                            <button type='submit' class="btn btn-primary">Send</button>
                            <button type='reset' class="btn btn-success">Reset</button>
                        </div>
                    </div>
                </form>
                <!-- /.Form validation  -->
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- /page content -->
@stop
@section('pageJsScripts')
<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
<script type="text/javascript">
    $('#message').summernote();
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop

