@extends('admin.layout.default')
@section('title','General Settings')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'dashboard']])
    @slot('title') General Settings @endslot
    @slot('add_btn') @endslot
    @slot('active') General Settings @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateGeneralSetting" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf 
                    @foreach($data as $item)   
                    <span class="section">General Information</span>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Site Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="site_name" value="{{$item->site_name}}"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Site Title<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="site_title" value="{{$item->site_title}}"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Email<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" name="email" class='email' required="required" type="email" value="{{$item->site_email}}"/></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="tel" class='tel' name="phone" required='required' data-validate-length-range="8,20" value="{{$item->site_phone}}"/></div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Site Logo</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden"  name="old_logo" value="{{$item->site_logo}}">
                              <input type="file" class="custom-file-input" name="logo" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3">
                            @if(empty($item->site_logo))
                                <img class="img-thumbnail" id="image" src="{{asset('site-img/default.png')}}" width="80px" height="80px">
                            @else
                                <img class="img-thumbnail" id="image" src="{{asset('site-img/'.$item->site_logo)}}" width="80px" height="80px">
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