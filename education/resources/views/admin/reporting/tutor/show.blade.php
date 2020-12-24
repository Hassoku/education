@php
    $tutor = $tutorReport->tutor;
    $student = $tutorReport->student;
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
                    <li class="breadcrumb-item"><a href="{{route('admin.tut_std.reporting.student')}}">Tutors</a></li>
                    <li class="breadcrumb-item active">{{$tutor->name}} {{$tutor->last_name}}</li>
                </ol>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box padding">
                <div class="box-header">
                    <a href="{{route('admin.tutor.show',['id' => $tutor->id])}}"  target="_blank" >
                        <img id="profile-img" src="{{asset($tutor->profile->picture)}}" class="circle " width="100" height="100" alt="...">
                        <div style="padding: 15px">
                            <h2>{{$tutor->name}} {{$tutor->middle_name}} {{$tutor->last_name}}</h2>
                        </div>
                        <div>
                            <span class="label {{($tutor->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$tutor->email}} ">
                                {{($tutor->online_status)? 'Online': 'Offline'}}
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
                        <form role="form" method="POST" action="#" enctype="multipart/form-data">
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Description</label>
                                <div class="col-sm-10">{{ $tutorReport->description }}</div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="title_arabic">Status</label>
                                <div class="col-sm-10">
                                    @if($tutorReport->status == 'pending')
                                        <span class="label  yellow pos-rlt m-r-xs">Pending</span>
                                    @elseif($tutorReport->status == 'in-process')
                                        <span class="label success pos-rlt m-r-xs">In-Process</span>
                                    @elseif($tutorReport->status == 'closed')
                                        <span class="label red pos-rlt m-r-xs">Closed</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Created Date</label>
                                <div class="col-sm-10">{{$tutorReport->created_at->format('F j, Y')}}</div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">By:</label>
                                <div class="col-sm-10">
                                    <img id="profile-img" src="{{asset($student->profile->picture)}}" class="circle " width="60" height="60" alt="...">
                                    <div>
                                        <a href="{{route('admin.student.show',['id' => $student->id])}}">
                                            <h5>{{$student->name}} {{$student->middle_name}} {{$student->last_name}}</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-2" >
                                    <a href="{{route('admin.tut_std.reporting.tutor.edit',['id' => $tutorReport->id])}}" class="btn btn-fw primary" ><i class="fa fa-edit"></i> Edit </a>
                                </div>
                                <div class="col-sm-10"></div>
                            </div>
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