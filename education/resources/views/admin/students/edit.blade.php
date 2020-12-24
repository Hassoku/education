@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">

            <!-- ############ PAGE START-->
                <div class="p-a white lt box-shadow">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.students')}}">Students</a></li>
                            <li class="breadcrumb-item active">{{$student->name}} {{$student->last_name}}</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="m-b-0 _300">{{$student->name}} {{$student->last_name}}</h4>
                        </div>
                        <div class="col-sm-6 text-sm-right"></div>
                    </div>
                </div>
                <div class="row">@include('admin.layout.errors')</div>
                <div class="padding">
                    <div class="box padding">
                        <div class="box-header">
                            <a href="{{route('admin.student.show',['id' => $student->id])}}">
                                <img id="profile-img" src="{{asset($student->profile->picture)}}" class="circle " width="150" height="150" alt="...">
                                <div style="padding: 15px">
                                    <h2>{{$student->name}} {{$student->middle_name}} {{$student->last_name}}</h2>
                                </div>
                            </a>
                            <div>
                                    <span class="label {{($student->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$student->email}} ">
                                        {{($student->online_status)? 'Online': 'Offline'}}
                                    </span>
                            </div>
                        </div>
                        <div class="b-b b-primary nav-active-primary">
                            <ul class="nav nav-tabs">

                                {{--info--}}
                                <li class="nav-item">
                                    <a class="nav-link @if($selectedTab == 'info') active @endif"  href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Basic Info</a>
                                </li>

                                {{--profile--}}
{{--                                <li class="nav-item">
                                    <a class="nav-link @if($selectedTab == 'profile') active @endif " href="#profile" data-toggle="tab" data-target="#profile" aria-expanded="true">Profile</a>
                                </li>--}}
                            </ul>
                        </div>
                        <div class="tab-content p-a m-b-md">

                            {{--info tab--}}
                            <div class="tab-pane @if($selectedTab == 'info') active @endif" id="info" aria-expanded="false">
                                <form role="form" method="POST" action="{{route('admin.student.update.info',['id' => $student->id])}}" enctype="multipart/form-data">
                                    <div class="row form-group">
                                        <label class="col-sm-2">First Name*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="" name="name" placeholder="Enter First Name" value="{{ $student->name }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2">Middle Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="" name="middle_name" placeholder="Enter Middle Name" @if($student->middle_name) value="{{$student->middle_name}}"@endif>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2">Last Name*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="" name="last_name" placeholder="Enter Last Name" value="{{ $student->last_name }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2">Mobile*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="" name="mobile" placeholder="Enter Mobile" value="{{ $student->mobile }}">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2">Email*</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="" name="email" placeholder="Enter Email" value="{{ $student->email }}">
                                        </div>
                                    </div>
{{--                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Date Created</label>
                                        <div class="col-sm-10">{{$student->created_at->format('F j, Y H:i:s')}}</div>
                                    </div>--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="status">
                                                <option value="under_review" @if($student->staus == 'under_review') selected @endif>Under Review</option>
                                                <option value="active" @if($student->status == 'active') selected @endif>Active</option>
                                                <option value="suspended" @if($student->status == 'suspended') selected @endif>Suspended</option>
                                                <option value="block" @if($student->status == 'block') selected @endif>Block</option>
                                            </select>
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

                            {{--profile tab--}}
{{--                            <div class="tab-pane @if($selectedTab == 'profile') active @endif" id="profile" aria-expanded="false">
                                Profile
                            </div>--}}
                        </div>
                    </div>
                </div>
            <!-- ############ PAGE END-->

        </div>
@endsection


{{--Own styles and scripts--}}
@section('styles')

@endsection
@section('scripts')

@endsection