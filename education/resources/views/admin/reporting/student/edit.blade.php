@php
    $student = $studentReport->student;
    $tutor = $studentReport->tutor;
@endphp

@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.tut_std.reporting')}}">Tut/Std Reporting</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.tut_std.reporting.student')}}">Students</a></li>
                    <li class="breadcrumb-item active">{{$student->name}} {{$student->last_name}}</li>
                </ol>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box padding">
                <div class="box-header">
                    <a href="{{route('admin.student.show',['id' => $student->id])}}"  target="_blank" >
                        <img id="profile-img" src="{{asset($student->profile->picture)}}" class="circle " width="100" height="100" alt="...">
                        <div style="padding: 15px">
                            <h2>{{$student->name}} {{$student->middle_name}} {{$student->last_name}}</h2>
                        </div>
                        <div>
                            <span class="label {{($student->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$student->email}} ">
                                {{($student->online_status)? 'Online': 'Offline'}}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="b-b b-primary nav-active-primary">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Detail</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-a m-b-md">
                    {{--info tab--}}
                    <div class="tab-pane active" id="info" aria-expanded="false">
                        <form role="form" method="POST" action="{{route('admin.tut_std.reporting.student.update',['id' => $studentReport->id])}}" enctype="multipart/form-data">
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Description</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="" name="description" placeholder="Enter description" value="{{ $studentReport->description }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="title_arabic">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="pending" @if($studentReport->status == 'pending') selected @endif>Pending</option>
                                        <option value="in-process" @if($studentReport->status == 'in-process') selected @endif>In-Process</option>
                                        <option value="closed" @if($studentReport->status == 'closed') selected @endif>Closed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">By:</label>
                                <div class="col-sm-10">
                                    <img id="profile-img" src="{{asset($tutor->profile->picture)}}" class="circle " width="60" height="60" alt="...">
                                    <div>
                                        <a href="{{route('admin.tutor.show',['id' => $tutor->id])}}">
                                            <h5>{{$tutor->name}} {{$tutor->middle_name}} {{$student->last_name}}</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-lg text-sm-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-fw primary" name="publish">Update Info <i class="fa fa-save"></i></button>
                                </div>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->

    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection