@extends('teacher.layout.default')
@section('title','Edit Quiz')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['home'=>'teacher/home','Quizzes'=>'teacher/quizzes']])
    @slot('title') Edit Quiz @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Quiz @endslot
@endcomponent
<!-- /.content-header -->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateQuizzy" method="POST" novalidate>
                    @csrf
                    {{ method_field('PATCH') }}
                    @foreach($quizzes as $row)
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Quiz Title<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-12">
                            <input class="form-control" name="qui_title" value="{{$row->quizzy_title}}" placeholder="Quizzy Title" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Description<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-12">
                           <textarea id="message" required="required" class="form-control" name="description">{{$row->quizzy_des}}</textarea>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Instructions<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-12">
                           <textarea id="message" required="required" class="form-control" name="instruction"  >{{$row->instruction}}</textarea>
                        </div>
                    </div>
                    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Duration<span class="required">*</span></label>
                        <div class="input-group col-md-9 col-sm-12">
                            <input class="form-control" name="duration" type="number" value="{{$row->duration}}" />
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2" style="font-size: 14px;">Mins.</span>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-2 col-sm-12  label-align">Published<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-12">
                           <select name="status" class="form-control select2">
                               <option value="1" {{ ($row->status == '1')?'selected' : ''; }}>Yes</option>
                               <option value="0" {{ ($row->status == '0')?'selected' : ''; }}>No</option>
                           </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                            <button type='submit' class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    @endforeach
                </form>
                <!-- /.Form validation  -->
            </div>
        </div>
    </div>
</div>
@stop
@section('pageJsScripts')
<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
<script>
    $('#message').summernote();
    $('.select2').select2();
</script>
@stop