@extends('admin.layout.default')
@section('title','Add New Teachers')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Teachers'=>'admin/teachers']])
    @slot('title') Edit Teachers @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Teachers @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateTeacher" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    {{ method_field('PATCH') }}
                    <span class="section">Teacher Infomation</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Regsitration No<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" value="{{$teachers->register_no}}" disabled />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Teacher Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="teacher_name" value="{{$teachers->teacher_name}}" placeholder="Teacher Name" />
                        </div>
                    </div>
                    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Designation<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                             <select name="designation" class="form-control select2" >
                                <option value="0"  selected disabled >Select The Designation</option>
                                @if(!empty($subjects))
                                    @foreach($subjects as $types)
                                        @if($teachers->designation == $types->subject_id)
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
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Date OF Birth<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='date' type="date" name="dob" value="{{$teachers->date_of_birth}}" required='required'></div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Gender</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control select2" name="gender">
                                <option disabled  value="" >Select The Gender</option>
                                <option value="male" {{($teachers->gender == "male" ? "selected":"")}}>Male</option>
                                <option value="female" {{($teachers->gender == "female" ? "selected":"")}}>Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="tel" class='tel' name="phone"  value="{{$teachers->phone}}" required='required' data-validate-length-range="8,20" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                        <input class="form-control" class='optional' name="address" value="{{$teachers->address}}" data-validate-length-range="5,15" type="text" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Joining Date *<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" class='date' type="date" name="joining_date" value="{{$teachers->join_date}}" required='required'></div>
                    </div> 
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Photo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" name="old_img" value="{{$teachers->image}}" />
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            @if($teachers->image != '')
                            <img id="image" src="{{asset('teacher/'.$teachers->image)}}" alt="" width="80px" height="80px">
                            @else
                            <img id="image" src="{{asset('teacher/default.png')}}" alt="" width="80px" height="80px">
                            @endif
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" class='email' value="{{$teachers->email}}" required="required" type="email" /></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="password" class='password' value="" type="password" />
                            <input name="old_password" value="{{$teachers->password}}" type="password" hidden />
                            <small class="text-danger">( Password leave empty if not change in password. )</small>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="control-label col-form-label col-md-3 col-sm-3  label-align" >Status</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control select2" name="status">
                                <option value="1" {{($teachers->status == "1" ? "selected":"")}}>Active</option>
                                <option value="0" {{($teachers->status == "0" ? "selected":"")}}>Inactive</option>
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