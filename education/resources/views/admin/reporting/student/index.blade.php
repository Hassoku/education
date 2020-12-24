@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">

            <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.tut_std.reporting')}}">Tut/Std Reporting</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Manage Student Reporting</h4>
                </div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box">
                <div class="box-header">
                    <h3>Students</h3>
                </div>
                <div class="row p-a">
                    <div class="col-sm-5">
                        @if(isset($searchKeyword) && !empty($searchKeyword))
                            <strong>{{$studentReportCollection->count()}}</strong> Result(s) found for: <strong>{{$searchKeyword}}</strong><br><a href="{{route('admin.tut_std.reporting.student')}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                        @else
                            Total Records: {{$studentReportCollection->total()}}
                        @endif
                    </div>
                    <div class="col-sm-4"> </div>
                    <div class="col-sm-3">
                        <form method="GET" action="{{route('admin.tut_std.reporting.student')}}">
                        <div class="input-group input-group-sm">

                                <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchKeyword)){{$searchKeyword}}@endif" name="keyword">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn b-a white" type="button">Go!</button>
                                </span>

                        </div>
                        </form>
                    </div>
                </div>
                @if($studentReportCollection->count() < 1)
                    <div class="table-responsive text-center">No record found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped b-t">
                            <thead>
                            <tr>
                                <th style="width:20px;">
                                    ID
                                </th>
                                <th>Student</th> {{--profile image--}}
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $serialNumberCounter = ($studentReportCollection->currentPage()-1) * $studentReportCollection->perPage()+1;
                            @endphp
                            @foreach($studentReportCollection as $studentReport)
                                @php
                                    $student = $studentReport->student;
                                @endphp
                                <tr>
                                    <td>
                                        {{$serialNumberCounter++ }}
                                    </td>
                                    <td>
                                        <span class="w-40 avatar">
                                          <img src="{{asset($student->profile->picture)}}" alt="...">
                                          <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$student->email}}"></i>
                                        </span>
                                        <br>
                                        {{$student->name}} {{$student->last_name}}
                                    </td>
                                    <td>{{$studentReport->description}}</td>
                                    <td>
                                        @if($studentReport->status == 'pending')
                                            <span class="label  yellow pos-rlt m-r-xs">Pending</span>
                                        @elseif($studentReport->status == 'in-process')
                                            <span class="label success pos-rlt m-r-xs">In-Process</span>
                                        @elseif($studentReport->status == 'closed')
                                            <span class="label red pos-rlt m-r-xs">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{$studentReport->created_at->format('F j, Y')}}</td>
                                    <td style="width:18%;">
                                        <a class="btn btn-sm success" href="{{route('admin.tut_std.reporting.student.show',['id'=>$studentReport->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                        <a class="btn btn-sm info" href="{{route('admin.tut_std.reporting.student.edit',['id'=>$studentReport->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                        {{--<a class="btn btn-sm danger" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>--}}
                                        <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-4 hidden-xs">
                        </div>
                        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($studentReportCollection->currentpage()-1)*$studentReportCollection->perpage()+1}} to {{(($studentReportCollection->currentpage()-1)*$studentReportCollection->perpage())+$studentReportCollection->count()}} of {{ $studentReportCollection->total() }} items</small> </div>
                        <div class="col-sm-4 text-right text-center-xs ">
                            {{ $studentReportCollection->links() }}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
            <!-- ############ PAGE END-->

        </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection