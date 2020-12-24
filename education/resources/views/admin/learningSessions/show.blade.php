@extends('admin.layout.app')
@section('content')

    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.sessions')}}">Sessions</a></li>
                    <li class="breadcrumb-item active">{{$session->tutor->name}} and {{$session->student->name}}</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Manage Session</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box">
                <div class="box-header">
                    <h3>
                        <strong>{{$session->tutor->name}} {{$session->tutor->last_name}}</strong>
                        session with
                        <strong>{{$session->student->name}} {{$session->student->last_name}}</strong>
                    </h3>
                    <div class="p-t-3">
                        Status ->
                        @if($session->status == 0)
                            <span class="label success pos-rlt m-r-xs"> Complete</span>
                        @else
                            <span class="label red pos-rlt m-r-xs"> Running</span>
                        @endif
                    </div>
                </div>
                <div class=" padding">
                    <div class="b-b b-primary nav-active-primary">
                        <ul class="nav nav-tabs">

                            {{--info--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'info') active @endif"  href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Basic Info</a>
                            </li>

                            {{--Video--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'video') active @endif"  href="#video" data-toggle="tab" data-target="#video" aria-expanded="false">Video Details</a>
                            </li>

                            {{--Chat--}}
                            <li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'chat') active @endif"  href="#chat" data-toggle="tab" data-target="#chat" aria-expanded="false">Chat Details</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content p-a m-b-md">

                        {{--info tab--}}
                        <div class="tab-pane @if($selectedTab == 'info') active @endif" id="info" aria-expanded="false">
                            info
                        </div>

                        {{--video tab--}}
                        <div class="tab-pane @if($selectedTab == 'video') active @endif" id="video" aria-expanded="false">
                            video details
                        </div>

                        {{--chat tab--}}
                        <div class="tab-pane @if($selectedTab == 'chat') active @endif" id="chat" aria-expanded="false">
                            chat details
                        </div>

                    </div>
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