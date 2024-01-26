@extends('student.layout.default')

@section('content')
<!-- Content Header (Page header) -->
@component('student.layout.content-header')
    @slot('title') My Profile @endslot
    @slot('add_btn') @endslot
@endcomponent
<!-- Main content -->
<div class="content">
    <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body clearfix">
                    <div class="float-left mr-3">
                        <img src="{{asset('student/'.$student->stu_image)}}" class="img-thumbnail" width="100px">
                    </div>
                    <div class="float-left text-secondary">
                        <span>Reg. No. : #{{$student->register_no}}</span>
                        <h4 class="text-dark m-0">{{ucfirst($student->student_name)}}</h4>
                        <span>Father Name : {{ucfirst($student->father_name)}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-secondary">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>Date of Birth :</strong></td>
                                <td>{{date('d M, Y',strtotime($student->date_of_birth))}}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender :</strong></td>
                                <td>{{ucfirst($student->gender)}}</td>
                            </tr>
                            <tr>
                                <td><strong>Join Date :</strong></td>
                                <td>{{date('d M, Y',strtotime($student->created_at))}}</td>
                            </tr>
                        </tbody>
                    </table>      
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-secondary">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>Email :</strong></td>
                                <td>{{$student->email}}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone :</strong></td>
                                <td>{{$student->phone}}</td>
                            </tr>
                            <tr>
                                <td><strong>Address :</strong></td>
                                <td>{{ucfirst($student->address)}}</td>
                            </tr>
                        </tbody>
                    </table>      
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- /.content -->
@stop