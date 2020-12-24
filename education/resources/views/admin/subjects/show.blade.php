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
                        <h4 class="m-b-0 _300">{{$topic->topic}}</h4>
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
                                <a class="nav-link @if($selectedTab == 'info') active @endif" href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Basic Info</a>
                            </li>

                            {{--tutor--}}
                            {{--<li class="nav-item">
                                <a class="nav-link @if($selectedTab == 'tutors') active @endif" href="#tutors" data-toggle="tab" data-target="#tutors" aria-expanded="false">Tutors ({{$tutorsCollection->count()}})</a>
                            </li>--}}
                        </ul>
                    </div>
                    <div class="tab-content p-a m-b-md">
                        {{--info tab--}}
                        <div class="tab-pane @if($selectedTab == 'info') active @endif" id="info" aria-expanded="false">
                            <form role="form" method="POST" action="#" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <label class="col-sm-2" >Topic</label>
                                    <div class="col-sm-10">{{ $topic->topic }}</div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2" >Description</label>
                                    <div class="col-sm-10">{{ $topic->description }}</div>
                                </div>
{{--                                <div class="row form-group">
                                    <label class="col-sm-2" >Parent</label>
                                    <div class="col-sm-10">
                                        @if($topic->parent != 0)
                                            <a href="{{route('admin.topic.show',['id' => $parent->id])}}">
                                                <u>{{$parent->topic}}</u>
                                            </a>
                                        @else
                                            <i class="text-muted">Has No Parent</i>
                                        @endif
                                    </div>
                                </div>--}}
                                <div class="row form-group">
                                    <label class="col-sm-2" >Topics</label>
                                    <div class="col-sm-10">
                                        @if($sub_topics->count() > 0)
                                            @foreach($sub_topics as $t)
                                            <a href="{{route('admin.topic.show',['id' => $t->id])}}">
                                                <u>{{$t->topic}}</u>
                                            </a>
                                            @if(!$loop->last), @endif
                                            @endforeach
                                        @else
                                            <i class="text-muted">Has No topics</i>
                                        @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2" >Status</label>
                                    <div class="col-sm-10">
                                        @if($topic->status == 'activate')
                                            <span class="label  success pos-rlt m-r-xs">Activated</span>
                                        @elseif($topic->status == 'deactivate')
                                            <span class="label red pos-rlt m-r-xs">Deactivated</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-2" >
                                        <a href="{{route('admin.subject.edit',['id' => $topic->id])}}" class="btn btn-fw primary" ><i class="fa fa-edit"></i> Edit Info</a>
                                    </div>
                                    <div class="col-sm-10"></div>
                                </div>
                            </form>
                        </div>

                        {{--tutors tab--}}
{{--                        <div class="tab-pane @if($selectedTab == 'tutors') active @endif" id="tutors" aria-expanded="false">
                            @if($tutorsCollection->count() < 1)
                                <div class="table-responsive text-center">No record found.</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped b-t">
                                        <thead>
                                        <tr>
                                            <th style="width:20px;">
                                                <!--<label class="ui-check m-a-0"><input type="checkbox" class="has-value"><i></i> </label>-->
                                                ID
                                            </th>
                                            <th></th> --}}{{--profile image--}}{{--
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>State</th>
                                            <th>Created Date</th>
                                            <th style="width:50px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $serialNumberCounter = ($tutorsCollection->currentPage()-1) * $tutorsCollection->perPage()+1;
                                        @endphp
                                        @foreach($tutorsCollection as $tutor)
                                            <tr>
                                                <td>
                                                    <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                    {{$serialNumberCounter++ }}
                                                </td>
                                                <td>
                                        <span class="w-40 avatar">
                                          <img src="{{asset($tutor->profile->picture)}}" alt="...">
                                          <i class="{{($tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$tutor->email}}"></i>
                                        </span>
                                                </td>
                                                <td>{{$tutor->name}}</td>
                                                <td>{{$tutor->last_name}}</td>
                                                <td>{{$tutor->email}}</td>
                                                <td>
                                                    @if($tutor->status == 'under_review')
                                                        <span class="label  yellow pos-rlt m-r-xs">Under Review</span>
                                                    @elseif($tutor->status == 'active')
                                                        <span class="label success pos-rlt m-r-xs">Activated</span>
                                                    @elseif($tutor->status == 'suspended')
                                                        <span class="label red pos-rlt m-r-xs">Suspended</span>
                                                    @elseif($tutor->status == 'block')
                                                        <span class="label dark pos-rlt m-r-xs">Blocked</span>
                                                    @endif
                                                </td>
                                                <td>{{$tutor->created_at->format('F j, Y')}}</td>
                                                <td style="width:18%;">
                                                    <a class="btn btn-sm success" href="{{route('admin.tutor.show',['id'=>$tutor->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                    --}}{{--<a class="btn btn-sm info" href="{{route('admin.tutor.edit',['id'=>$tutor->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>--}}{{--
                                                    --}}{{--<a class="btn btn-sm danger" onclick="showWarningDialog({{$tutor->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>--}}{{--
                                                    <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <footer class="dker p-a">
                                    <div class="row">
                                        <div class="col-sm-4 hidden-xs">
                                            <!--<select class="input-sm form-control w-sm inline v-middle">
                                                <option value="0">Bulk action</option>
                                                <option value="1">Delete selected</option>
                                                <option value="2">Bulk edit</option>
                                                <option value="3">Export</option>
                                            </select>
                                            <button class="btn btn-sm white">Apply</button>-->
                                        </div>
                                        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($tutorsCollection->currentpage()-1)*$tutorsCollection->perpage()+1}} to {{(($tutorsCollection->currentpage()-1)*$tutorsCollection->perpage())+$tutorsCollection->count()}} of {{ $tutorsCollection->total() }} items</small> </div>
                                        <div class="col-sm-4 text-right text-center-xs ">
                                        {{ $tutorsCollection->links() }}
                                        <!--<ul class="pagination pagination-sm m-a-0">
                                <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                                <li class="active"><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">4</a></li>
                                <li><a href="">5</a></li>
                                <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                            </ul>-->
                                        </div>
                                    </div>
                                </footer>
                            @endif
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