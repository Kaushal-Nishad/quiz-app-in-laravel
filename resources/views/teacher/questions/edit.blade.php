@extends('teacher.layout.default')
@section('title','Add New Question')
@section('content')

<!-- Content Header (Page header) -->
@component('teacher.layout.content-header',['breadcrumb'=>['Home'=>'teacher/home','Questions'=>'teacher/questions']])
    @slot('title') Edit Question @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Question @endslot
@endcomponent
<!-- /.content-header -->

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            
            <div class="x_content">
                <!-- Form validation  -->
                <form class="form-horizontal" id="updateQuestion" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    {{ method_field('PATCH') }}
                    @foreach($question as $row)
                     <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Question<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="question" placeholder="Question" value="{{$row->question}}"/>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Quiz Id<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                               <select name="quizzy" class="form-control" >
                                <option value="0"  selected disabled >Select The Quiz</option>
                                @if(!empty($quizzy))
                                    @foreach($quizzy as $types)
                                        @if($row->quizzy_id == $types->quizzy_id)
                                            <option value="{{$types->quizzy_id}}" selected>{{$types->quizzy_title}}</option>
                                            @else
                                            <option value="{{$types->quizzy_id}}">{{$types->quizzy_title}}</option>
                                        @endif
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
                            @php
                            $choice = json_decode(json_decode($row->choices));
                            $count_choice = count($choice);
                            
                            @endphp
                            @for($i=0;$i<$count_choice;$i++)
                            <div class="input-group">
                                <input type="text" class="form-control" id="ch{{$i+1}}" name="choice[]" value="{{$choice[$i]}}" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        @if($row->correct_answer == ($i+1))
                                        <input type="radio" id="cr{{$i+1}}" name="correct" checked>
                                        @else
                                        <input type="radio" id="cr{{$i+1}}" name="correct">
                                        @endif
                                        
                                    </div>
                                </div>
                                @if($i == 0)
                                <button type="button" class="btn btn-sm btn-success add-choice m-0 ml-2"><i class="fa fa-plus"></i></button>
                                @else
                                <button type="button" class="btn btn-sm btn-danger remove-choice m-0 ml-2"><i class="fa fa-times"></i></button>
                                @endif
                            </div>
                            @endfor
                        </div>
                    </div>
                   
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Image</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" class="custom-file-input" name="old_img" value="{{$row->image}}" />
                            <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="col-md-3 text-right">
                            @if($row->image != '')
                            <img id="image" src="{{asset('question/'.$row->image)}}" alt="" width="80px" height="80px">
                            @else
                            <img id="image" src="{{asset('question/no-image.png')}}" alt="" width="80px" height="80px">
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-danger d-none er-message"></div>
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