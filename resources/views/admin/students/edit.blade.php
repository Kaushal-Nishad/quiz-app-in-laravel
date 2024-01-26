@extends('admin.layout.default')
@section('title','Add New Students')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Students'=>'admin/students']])
    @slot('title') Edit Student @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Student @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateStudent" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    <span class="section">Student Infomation</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Register Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" name="register_no" value="{{$students->register_no}}" type="text" disabled /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Student Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="student_name"  value="{{$students->student_name}}" placeholder="Student Name" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Father Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='optional' name="father_name"  value="{{$students->father_name}}" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Date OF Birth<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='date' type="date" name="dob"  value="{{$students->date_of_birth}}" required='required'></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Gender</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="gender" class="form-control" >
                                <option disabled  value="" >Select The Gender</option>
                                <option value="male" {{($students->gender == "male" ? "selected":"")}}>Male</option>
                                <option value="female" {{($students->gender == "female" ? "selected":"")}}>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="tel" class='tel' name="phone" value="{{$students->phone}}" required='required' data-validate-length-range="8,20" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" class='optional' name="address" value="{{$students->address}}" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Subjects</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="subjects[]" class="form-control select2" multiple="multiple">
                                @if(!empty($subject))
                                    @php
                                        $row_subjects = array_filter(explode(',',$students->subjects));
                                    @endphp
                                    @foreach($subject as $types)
                                        @if(in_array($types->subject_id,$row_subjects))
                                        <option value="{{$types->subject_id}}" selected>{{$types->subject_name}}</option>
                                        @else
                                        <option value="{{$types->subject_id}}">{{$types->subject_name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Photo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" class="custom-file-input" name="old_img" value="{{$students->stu_image}}" />
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            @if($students->stu_image != '')
                                <img id="image" src="{{asset('student/'.$students->stu_image)}}" alt="" width="80px" height="80px">
                            @else
                                <img id="image" src="{{asset('student/default.png')}}" alt="" width="80px" height="80px">
                            @endif
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" class='email' value="{{$students->email}}" required="required" type="email" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="password" class='password' type="password" />
                            <input hidden name="old_password" value="{{$students->password}}" type="password" />
                            <small class="text-danger">( Password leave empty if not change in password. )</small>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Status</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="status" class="form-control select2" >
                                <option value="1" {{($students->status == '1') ? 'selected' : ''}}>Active</option>
                                <option value="0" {{($students->status == '0') ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Update</button>
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