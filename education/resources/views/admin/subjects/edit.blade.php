@extends('admin.layout.app')
@section('content')

    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.subjects')}}">Subjects</a></li>
                    <li class="breadcrumb-item active">{{$topic->topic}}</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Edit {{$topic->topic}}</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box padding">
                <div class="b-b b-primary nav-active-primary">
                    <ul class="nav nav-tabs">
                        {{--info--}}
                        <li class="nav-item">
                            <a class="nav-link  active" href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Basic Info</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-a m-b-md">
                    {{--info tab--}}
                    <div class="tab-pane  active" id="info" aria-expanded="false">
                        <form role="form" method="POST" action="{{route('admin.subject.update.info',['id' => $topic->id])}}" enctype="multipart/form-data">
                            <div class="row form-group">
                                <label class="col-sm-2" >Topic*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="topic" placeholder="Enter Topic" value="{{ $topic->topic }}" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" >Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="description" placeholder="Enter Description" value="{{ $topic->description }}">
                                </div>
                            </div>
                            <input type="hidden" name="parent" value=0>
{{--                            <div class="row form-group">
                                <label class="col-sm-2" >Parent*</label>
                                <div class="col-sm-10">
                                    --}}{{--@if($topic->parent != 0)--}}{{--
                                        <select class="form-control" name="parent">
                                            <option style="color: red" value = 0 @if($topic->parent == 0) selected @endif>Subject</option>
                                            @foreach($parent_topics as $t)
                                                @if($topic->id != $t->id)
                                                    <option value = {{$t->id}} @if($topic->parent == $t->id) selected @endif>{{$t->topic}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @if($topic->parent == 0)
                                        <small class="text-info">'<i>{{$topic->topic}}</i>  ' a <span style="color: red">Subject</span></small><br>
                                        <small class="text-info">Change into topic: please select any parent from list</small>
                                    @else
                                        <small class="text-info">Make '<i>{{$topic->topic}}</i>  ' a subject: Please Select <span style="color: red">Subject</span> from list.</small>
                                    @endif
                                        --}}{{--@else
                                        <i class="text-muted">It's a subject</i>
                                        <input type="hidden" name="parent" value=0>
                                    @endif--}}{{--
                                </div>
                            </div>--}}
                            <div class="row form-group">
                                <label class="col-sm-2" >Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="activate" @if($topic->status == 'activate') selected @endif>Activated</option>
                                        <option value="deactivate" @if($topic->status == 'deactivate') selected @endif>Deactivated</option>
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