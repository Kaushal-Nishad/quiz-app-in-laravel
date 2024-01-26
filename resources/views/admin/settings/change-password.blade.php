@extends('admin.layout.default')
@section('title','Change Password')
@section('content')

<!-- Content Header (Page header) -->
@component('admin.layout.content-header',['breadcrumb'=>['Dashboard'=>'dashboard']])
    @slot('title') Change Password @endslot
    @slot('add_btn') @endslot
    @slot('active') Change Password @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <form class="form-horizontal" id="changePassword" method="POST" enctype="multipart/form-data">
                    @csrf 
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Old Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="password" class="form-control" name="old_password"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">New Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="password" class="form-control" id="password" name="new_password" required="required"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Confirm New Password<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="password" class="form-control" name="con_password" required="required" />
                        </div>
                    </div>
                    <div class="ln_solid pt-3">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary update-pass">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
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