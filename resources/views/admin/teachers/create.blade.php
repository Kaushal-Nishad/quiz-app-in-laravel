@extends('admin.layout.default')
@section('title','Add New Teachers')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Teachers'=>'admin/teachers']])
    @slot('title') Add Teachers @endslot
    @slot('add_btn') @endslot
    @slot('active') Add Teachers @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content pl-2 pr-2">
                @if(count($subjects) == 0)
                    <div class="alert alert-danger">First Add Subjects for Create New Teaher</div>
                @endif<!-- Form validation  -->
                <form class="form-horizontal" id="addTeacher" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf    
                    <span class="section">Teacher Infomation</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Teacher Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" data-validate-length-range="6" data-validate-words="2" name="teacher_name" placeholder="Teacher Name" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Registration No.<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="number" class="form-control" data-validate-length-range="6" data-validate-words="2" name="registration" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Designation<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                               <select name="designation" class="form-control select2" >
                                <option value="0"  selected disabled >Select The Subject</option>
                                @if(!empty($subjects))
                                    @foreach($subjects as $types)
                                        <option value="{{$types->subject_id}}">{{$types->subject_name}} teacher</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Date OF Birth<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="date" name="dob" value="{{date('Y-m-d')}}" required='required'></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Gender</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control select2" name="gender">
                                <option value="Select The Gender" disabled >Select The Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="tel" name="phone" required='required' pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" name="address" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Joining Date <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="date" name="joining_date" value="{{date('Y-m-d')}}" required='required'></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Photo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            <img id="image" src="{{asset('images/user.png')}}" alt=""  width="80px" height="80px">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" required="required" type="email" /></div>
                    </div>
                    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character" required />
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