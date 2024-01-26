@extends('teacher.layout.default')
@section('title','My Profile')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home']])
    @slot('title')My Profile @endslot
    @slot('add_btn') @endslot
    @slot('active') My Profile @endslot
@endcomponent
<!-- /.content-header -->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <form class="form-horizontal" id="modifyTeacher" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf    
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="teacher_name" placeholder="Your Name" value="{{$teacher->teacher_name}}" />
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Phone No.<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="teacher_phone" placeholder="Your Phone Number" value="{{$teacher->phone}}" />
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Email / Username<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="teacher_email" placeholder="Your Email" value="{{$teacher->email}}" disabled />
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Date of Birth<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="date" class="form-control" name="teacher_dob" placeholder="Date of Birth" value="{{$teacher->date_of_birth}}" />
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea name="teacher_address" class="form-control" cols="30" rows="2">{{$teacher->address}}</textarea>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('pageJsScripts')
<script type="text/javascript">
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
<script>
    $('.select2').select2();
</script>
@stop