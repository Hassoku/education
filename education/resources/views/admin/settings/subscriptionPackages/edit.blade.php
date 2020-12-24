@extends('admin.layout.app')
@section('content')

    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.settings',['tab' => 'subscription_package'])}}">Settings</a></li>
                    <li class="breadcrumb-item active">Subscription Package</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Edit Subscription Package</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box padding">
                <div class="b-b b-primary nav-active-primary">
                    <ul class="nav nav-tabs">
                        {{--subscription-package--}}
                        <li class="nav-item">
                            <a class="nav-link  active" href="#subscription-package" data-toggle="tab" data-target="#subscription-package" aria-expanded="false">Subscription Package</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-a m-b-md">
                    {{--info tab--}}
                    <div class="tab-pane  active" id="subscription-package" aria-expanded="false">
                        <form role="form" method="POST" action="{{route('admin.subscriptionPackage.update',['id' => $sub_pkg->id])}}" enctype="multipart/form-data">
                            <div class="row form-group">
                                <label class="col-sm-2" >Minutes*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="minutes" placeholder="Enter Minutes" value="{{ $sub_pkg->minutes }}" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" >Price*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="price" placeholder="Enter Price" value="{{ $sub_pkg->price }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" >Type*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="type">
                                        <option value="individual" @if($sub_pkg->type == 'individual') selected @endif>Individual</option>
                                        <option value="group" @if($sub_pkg->type == 'group') selected @endif>Group</option>
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