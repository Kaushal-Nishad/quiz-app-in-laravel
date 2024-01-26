@extends('admin.layout.default')
@section('title','Add New Students')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Students'=>'admin/students']])
    @slot('title') Add Student @endslot
    @slot('add_btn') @endslot
    @slot('active') Add Student @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                @if(count($subject) == 0)
                    <div class="alert alert-danger">First Add Subjects for Create New Student</div>
                @endif
                <!-- Form validation  -->
                <form class="form-horizontal" id="addStudent" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf    
                    <span class="section">Student Infomation</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Registeration No.<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" class='optional' name="register_no" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Student Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="student_name" placeholder="Student Name" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Father Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='optional' name="father_name" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Date OF Birth<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='date' type="date" name="dob" required='required'></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Gender</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="gender" class="form-control select2" >
                                <option value="0" selected disabled >Select The Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="tel" class='tel' name="phone" required='required' data-validate-length-range="8,20" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" class='optional' name="address" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Subjects</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="subjects[]" class="form-control select2" multiple="multiple">
                                @if(!empty($subject))
                                    @foreach($subject as $types)
                                        <option value="{{$types->subject_id}}">{{$types->subject_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Photo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            <img id="image" src="{{asset('student/default.png')}}" alt=""  width="80px" height="80px">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" class='email' required="required" type="email" /></div>
                    </div>
                    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="password" id="password1" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character" required />
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Submit</button>
                                <button type='reset' class="btn btn-success">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.Form validation  -->
            </div>
        </div>
    </div>
</div>

@stop
@section('pageJsScripts')
<script src="{{asset('assets/js/select2.min.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.select2').select2();
    });

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