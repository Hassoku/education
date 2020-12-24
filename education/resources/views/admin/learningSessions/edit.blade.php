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