@extends('teacher.layout.default')
@section('title','Add Question')
@section('content')
<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Question'=>'teacher/questions']])
    @slot('title') Add Question @endslot
    @slot('add_btn') @endslot
    @slot('active') Add Question @endslot
@endcomponent
<!-- /.content-header -->
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="addQuestion" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf    
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Question Title<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="question" placeholder="Question" />
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Quiz Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                               <select name="quizz" class="form-control select2" style="width:100%;">
                                <option value="0"  selected disabled >Select Quiz Name</option>
                                @if(!empty($quiz))
                                    @foreach($quiz as $types)
                                        <option value="{{$types->quizz_id}}">{{$types->quizz_title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group row">
                        <div class="col-md-3 text-right">
                            <label class="col-form-label label-align">Choices<span class="required">*</span></label>
                        </div>
                        <div class="col-md-6 choice-container">
                            <div class="input-group">
                                <input type="text" class="form-control" id="ch1" name="choice[]" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" id="cr1" name="correct">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-success add-choice m-0 ml-2"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Image</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            <img id="image" src="{{asset('question/no-image.png')}}" alt=""  width="80px" height="80px">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-danger d-none er-message"></div>
                            <button type='submit' class="btn btn-primary">Submit</button>
                            <button type='reset' class="btn btn-success">Reset</button>
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
<script type="text/javascript">
    $('.select2').select2();

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