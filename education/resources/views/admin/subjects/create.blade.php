@extends('admin.layout.app')
@section('content')

    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.subjects')}}">Subjects</a></li>
                    <li class="breadcrumb-item active">Add New Subject</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Add New Subject</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box">
                <div class="box-header">
                    <h3>Add New Topic</h3>
                </div>
                <div class="padding">
                    <form role="form" method="POST" action="{{route('admin.subject.store')}}" enctype="multipart/form-data">
                        <div class="row form-group">
                            <label class="col-sm-2" >Subject*</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="topic" placeholder="Enter Subject" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" >Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="description" placeholder="Enter Description">
                            </div>
                        </div>
                        <input type="hidden" name="parent" value=0>
{{--                        <div class="row form-group">
                            <label class="col-sm-2" >Parent*</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="parent">
                                    --}}{{--<option>-</option>--}}{{--
                                    <option style="color: red" value = 0>Subject</option>
                                    @foreach($parent_topics as $t)
                                        <option value = {{$t->id}}>{{$t->topic}}</option>
                                    @endforeach
                                </select>
                                <small class="text-info">Make a subject: Please Select <span style="color: red">Subject</span> from list.</small>
                            </div>
                        </div>--}}
                        <div class="row form-group">
                            <label class="col-sm-2" >Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">
                                    <option value="activate">Activated</option>
                                    <option value="deactivate">Deactivated</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-t-lg text-sm-right">
                            <div class="col-sm-12">
                                <button class="btn btn-fw primary" name="publish"><i class="fa fa-plus"></i> Create Subject</button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </form>
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