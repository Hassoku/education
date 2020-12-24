@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Tut/Std Reporting</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Tutor and Student reporting</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="padding">
            {{--Tutor and student--}}
            <div class="row">
                {{--tutor--}}
                <div class="col-xs-6 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-40 primary text-center rounded">
                              <i class="material-icons">report</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-md"><a href="{{route('admin.tut_std.reporting.tutor')}}">{{$tutorReportsCount}} <span class="text-sm">Tutor Reports</span></a></h4>
                            <small class="text-muted">{{$newTutorReportsCount}} - new</small>
                            <br>
                            <small class="text-muted">{{$closedTutorReportsCount}} - closed</small>
                        </div>
                    </div>
                </div>

                {{--student--}}
                <div class="col-xs-6 col-sm-6">
                    <div class="box p-a">
                        <div class="pull-left m-r">
                            <span class="w-40 primary text-center rounded">
                              <i class="material-icons">report</i>
                            </span>
                        </div>
                        <div class="clear">
                            <h4 class="m-a-0 text-md"><a href="{{route('admin.tut_std.reporting.student')}}">{{$studentReportsCount}} <span class="text-sm">Student Reports</span></a></h4>
                            <small class="text-muted">{{$newStudentReportsCount}} - new</small>
                            <br>
                            <small class="text-muted">{{$closedStudentReportsCount}} - closed</small>
                        </div>
                    </div>
                </div>
            </div>

            {{--New top 5 reports of Tut/Std--}}
            <div class="row">
                {{--Tutor--}}
                <div class="col-sm-6 col-md-6">
                    <div class="box" style="height: 355px; max-height: 355px;">
                        <div class="box-header">
                            <a href="{{route('admin.tut_std.reporting.tutor')}}"><h3>Tutor Reports</h3></a>
                            <small class="text-muted">Top 5 new</small>
                        </div>
                        <div class="box-tool">
                            <a href="{{route('admin.tut_std.reporting.tutor')}}" class="text-primary text-u-l">Show all</a>
                        </div>
                        <ul class="list no-border p-b">
                            @foreach($tutorReportCollection as $tutorReport)
                                @php
                                    $tutor = $tutorReport->tutor
                                @endphp
                                <li class="list-item">
                                    <a href="{{route('admin.tutor.show',['id' => $tutor->id])}}" class="list-left">
                                        <span class="w-40 avatar">
                                          <img src="{{asset($tutor->profile->picture)}}" alt="...">
                                          <i class="{{($tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-tut-'.$tutor->email}}"></i>
                                        </span>
                                    </a>
                                    <div class="list-body">
                                        <div><a href="{{route('admin.tutor.show',['id' => $tutor->id])}}">{{$tutor->name}} {{$tutor->last_name}}</a></div>
                                        <small class="text-muted text-ellipsis">
                                            @foreach($tutor->profile->tutor_specializations as $tutor_specialization)
                                                {{$tutor_specialization->topic->topic}}@if(!$loop->last),@endif
                                            @endforeach
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{--Student--}}
                <div class="col-sm-6 col-md-6">
                    <div class="box" style="height: 355px; max-height: 355px;">
                        <div class="box-header">
                            <a href="{{--{{route('admin.students')}}--}}"><h3>Student Reports</h3></a>
                            <small class="text-muted">Top 5 new</small>
                        </div>
                        <div class="box-tool">
                            <a href="{{route('admin.tut_std.reporting.student')}}" class="text-primary text-u-l">Show all</a>
                        </div>
                        <ul class="list no-border p-b">
                            @foreach($studentReportCollection as $studentReport)
                                @php
                                    $student = $studentReport->student
                                @endphp
                                <li class="list-item">
                                    <a href="{{route('admin.student.show',['id'=>$student->id])}}" class="list-left">
                                        <span class="w-40 avatar">
                                          <img src="{{asset($student->profile->picture)}}" alt="...">
                                          <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-stu-'.$student->email}}"></i>
                                        </span>
                                    </a>
                                    <div class="list-body">
                                        <div><a href="{{route('admin.student.show',['id'=>$student->id])}}">{{$student->name}} {{$student->last_name}}</a></div>
                                        <small class="text-muted text-ellipsis">
                                            {{--@foreach($student->profile->student_specializations as $student_specialization)--}}
                                            {{--{{$student_specialization->topic->topic}}@if(!$loop->last),@endif--}}
                                            {{--@endforeach--}}
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- ############ PAGE END-->
    </div>
@endsection