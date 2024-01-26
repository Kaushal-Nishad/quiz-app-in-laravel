@extends('admin.layout.default')
@section('title','Profile Settings')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'dashboard']])
    @slot('title') Profile Settings @endslot
    @slot('add_btn') @endslot
    @slot('active') Profile Settings @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateProfile" method="POST" enctype="multipart/form-data">
                    @csrf 
                
                    @foreach($data as $item)   
                    <span class="section">Profile Information</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Admin Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="admin_name" value="{{$item->admin_name}}"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Username<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="username" value="{{$item->username}}"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" class='email' required="required" type="email" value="{{$item->email}}"/></div>
                    </div>
                   
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Admin Photo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden"  name="old_image" value="{{$item->image}}">
                              <input type="file" class="custom-file-input" name="image" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3">
                            @if(empty($item->image))
                                <img class="img-thumbnail" id="image" src="{{asset('site-img/default.png')}}" width="80px" height="80px">
                            @else
                                <img class="img-thumbnail" id="image" src="{{asset('site-img/'.$item->image)}}" width="80px" height="80px">
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </form>
                <!-- /.Form validation  -->
            </div>
        </div>
    </div>
</div>
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
@stop