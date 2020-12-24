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
                            <img id="profile-img" src="{{asset($student->profile->picture)}}" class="circle " width="150" height="150" alt="...">
                            <div style="padding: 15px">
                                <h2>{{$student->name}} {{$student->middle_name}} {{$student->last_name}}</h2>
                            </div>
                            <div>
                                <span class="label {{($student->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$student->email}} ">
                                    {{($student->online_status)? 'Online': 'Offline'}}
                                </span>
                                <br>
                                <br>
                                <a href="{{route('admin.student.assign.free.minutes',['id' => $student->id])}}" class="btn btn-fw success"> Assign - 60 - minutes</a>
                            </div>
                        </div>
                        <div class="b-b b-primary nav-active-primary">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#info" data-toggle="tab" data-target="#info" aria-expanded="false">Basic Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#profile" data-toggle="tab" data-target="#profile" aria-expanded="true">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#session_reservations" data-toggle="tab" data-target="#session_reservations" aria-expanded="true">Session Reservations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#session_history" data-toggle="tab" data-target="#session_history" aria-expanded="true">Session history</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#payment_history" data-toggle="tab" data-target="#payment_history" aria-expanded="true">Payment history</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content p-a m-b-md">
                            {{--info tab--}}
                            <div class="tab-pane active" id="info" aria-expanded="false">
                                <form role="form" method="POST" action="#" enctype="multipart/form-data">
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">First Name*</label>
                                        <div class="col-sm-10">{{ $student->name }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Middle Name</label>
                                        <div class="col-sm-10">@if($student->middle_name) {{$student->middle_name}} @else <i class="text-muted">Not Set</i> @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Last Name*</label>
                                        <div class="col-sm-10">{{ $student->last_name }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Mobile*</label>
                                        <div class="col-sm-10">{{ $student->mobile }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Email*</label>
                                        <div class="col-sm-10">{{ $student->email }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Date Created</label>
                                        <div class="col-sm-10">{{$student->created_at->format('F j, Y H:i:s')}}</div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Status</label>
                                        <div class="col-sm-10">
                                            @if($student->status == 'under_review')
                                                <span class="label  yellow pos-rlt m-r-xs">Under Review</span>
                                            @elseif($student->status == 'active')
                                                <span class="label success pos-rlt m-r-xs">Activated</span>
                                            @elseif($student->status == 'suspended')
                                                <span class="label red pos-rlt m-r-xs">Suspended</span>
                                            @elseif($student->status == 'block')
                                                <span class="label dark pos-rlt m-r-xs">Blocked</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-2" >
                                            <a href="{{route('admin.student.edit',['id' => $student->id])}}" class="btn btn-fw primary" ><i class="fa fa-edit"></i> Edit Info</a>
                                        </div>
                                        <div class="col-sm-10"></div>
                                    </div>
                                </form>
                            </div>

                            {{--profile tab--}}
                            <div class="tab-pane" id="profile" aria-expanded="false">
                                Profile
                            </div>

                            {{--Session Reservations--}}
                            <div class="tab-pane" id="session_reservations" aria-expanded="false">
                                @if($student->learning_session_reservations->count() < 1)
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
                                                <th>Tutor</th>
                                                <th>Topic</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                {{--<th style="width:50px;">Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $serialNumberCounter = 1;
                                            @endphp
                                            @foreach($student->learning_session_reservations as $learning_session_reservation)
                                                <tr>
                                                    <td>
                                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                        {{$serialNumberCounter++ }}
                                                    </td>
                                                    <td>
                                                         <span class="w-40 avatar">
                                                          <img src="{{asset($learning_session_reservation->tutor->profile->picture)}}" alt="...">
                                                          <i class="{{($learning_session_reservation->tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-tut-'.$learning_session_reservation->tutor->email}}"></i>
                                                        </span>
                                                        <br>
                                                        <h6 style="margin-top: 10px; margin-bottom: 0">{{$learning_session_reservation->tutor->name}} {{$learning_session_reservation->tutor->last_name}}</h6>
                                                    </td>
                                                    <td>{{$learning_session_reservation->topic->topic}}</td>
                                                    <td>{{$learning_session_reservation->date}}</td>
                                                    <td>{{$learning_session_reservation->start_time}}</td>
                                                    <td>{{$learning_session_reservation->end_time}}</td>
                                                    <td>
                                                        <span class="label {{($learning_session_reservation->status == true)? 'success': 'red'}} pos-rlt m-r-xs">
                                                            {{($learning_session_reservation->status)? 'Active': 'Completed'}}
                                                        </span>
                                                    <td>{{$student->created_at->format('F j, Y')}}</td>
                                                    {{--<td style="width:18%;">--}}
{{--                                                        <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>--}}
                                                        {{--<a class="btn btn-sm info" href="#"><i class="glyphicon glyphicon-edit"></i> edit</a>--}}
                                                        {{--<a class="btn btn-sm danger" onclick="showWarningDialog({{$learning_session_reservation->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>--}}
                                                        {{--<!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->--}}
                                                    {{--</td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{--Session history--}}
                            <div class="tab-pane" id="session_history" aria-expanded="false">
                                @if($student->learning_session_participants->count() < 1)
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
                                                <th>Tutor</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                {{--<th style="width:50px;">Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $serialNumberCounter = 1;
                                            @endphp
                                            {{--@foreach($student->learning_session as $learning_session)--}}
                                            @foreach($student->learning_session_participants as $learning_session)
                                                <tr>
                                                    <td>
                                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                        {{$serialNumberCounter++ }}
                                                    </td>
                                                    <td>
                                                         <span class="w-40 avatar">
                                                          <img src="{{asset($learning_session->tutor->profile->picture)}}" alt="...">
                                                          <i class="{{($learning_session->tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-tut-'.$learning_session->tutor->email}}"></i>
                                                        </span>
                                                        <br>
                                                        <h6 style="margin-top: 10px; margin-bottom: 0">{{$learning_session->tutor->name}} {{$learning_session->tutor->last_name}}</h6>
                                                    </td>
                                                    <td>{{Carbon::parse($learning_session->learning_session->start_time)->format('g:i A')}}</td>
                                                    <td>{{Carbon::parse($learning_session->learning_session->end_time)->format('g:i A')}}</td>
                                                    <td>
                                                        <span class="label {{($learning_session->learning_session->status == true)? 'success': 'red'}} pos-rlt m-r-xs">
                                                            {{($learning_session->learning_session->status == true) ? 'Running': 'Completed'}}
                                                        </span>
                                                    </td>
                                                    <td>{{$learning_session->created_at->format('F j, Y')}}</td>
                                                    {{--<td style="width:18%;">--}}
                                                        {{--<a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>--}}
                                                        {{--<a class="btn btn-sm info" href="#"><i class="glyphicon glyphicon-edit"></i> edit</a>--}}
                                                        {{--<a class="btn btn-sm danger" onclick="showWarningDialog({{$learning_session->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>--}}
                                                        {{--<!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->--}}
                                                    {{--</td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{--Payment history--}}
                            <div class="tab-pane" id="payment_history" aria-expanded="false">
                                @if($student->student_balance_payments->count() < 1)
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
                                                <th>Purchased Minutes</th>
                                                <th>Amount</th>
                                                <th>Total Minutes</th>
                                                <th>Total Amount</th>
                                                <th>Time</th>
                                                <th>Date</th>
                                                <th style="width:50px;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $serialNumberCounter = 1;
                                            @endphp
                                            @foreach($student->student_balance_payments as $student_balance)
                                                <tr>
                                                    <td>
                                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                        {{$serialNumberCounter++ }}
                                                    </td>
                                                    <td>{{($student_balance->purchased_slots > 0) ? ($student_balance->purchased_slots) / 4 : 'Free Minutes'}}</td>
                                                    <td>{{($student_balance->purchased_amount > 0) ?  $student_balance->purchased_amount : '0'}}</td>
                                                    <td>{{($student_balance->remaining_slots) / 4}}</td>
                                                    <td>{{$student_balance->remaining_amount}}</td>
                                                    {{--<td>{{$learning_session->created_at->format('F j, Y')}}</td>--}}
                                                    <td>{{$student_balance->updated_at->format('g:i A')}}</td>
                                                    <td>{{$student_balance->updated_at->format('F j, Y')}}</td>
                                                    <td style="width:18%;">
                                                        <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                        {{--<a class="btn btn-sm info" href="#"><i class="glyphicon glyphicon-edit"></i> edit</a>--}}
                                                        {{--<a class="btn btn-sm danger" onclick="showWarningDialog({{$student_balance->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>--}}
                                                        <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <!-- ############ PAGE END-->

        </div>
@endsection


{{--Own styles and scripts--}}
@section('styles')
    <link href="{{asset('assets/admin/css/sweetalert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('assets/admin/js/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        function showWarningDialog(id) {
            swal({
                title: "Are you sure to remove Reservation & all related data?",
                text: "You will not be able to recover this info!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function () {
                /*                $.ajax({
                                    type: "DELETE",
                                    dataType: 'json',
                                    url: 'schools/'+id,
                                    data: {},
                                    success: function (returnedData) {
                                        if (returnedData.success) {
                                            //swal("Deleted!", "Record has been deleted.", "success");
                                            window.location = '';
                                        } else {
                                            swal("Problem", "Unable to delete record.", "error");
                                        }
                                    },
                                    error: function (returnedData) {
                                        swal("Error", "There some problem with the request.", "error");
                                    }
                                });*/
            });
        }
    </script>


    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        // tutor
        var channel = pusher.subscribe('tutor.status');
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
            // console.log(tutor);
            var elements = document.getElementsByClassName('online-tut-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('off');
                    element.classList.add('on');
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('on');
                        element.classList.add('off');
                    }
                }
            });
        });

        // student
        var channel = pusher.subscribe('student.status');
        channel.bind('student.status.event', function (data) {
            var student = data.student;
            // console.log(student);
            var elements = document.getElementsByClassName('online-'+student.email);
            $.each(elements, function (i, element) {
                if(student.online_status){
                    element.classList.remove('red');
                    element.classList.add('success');
                    element.innerHTML = "Online";
                }else {
                    if(!student.online_status){
                        console.log("false");
                        element.classList.remove('success');
                        element.classList.add('red');
                        element.innerHTML = "Offline";
                    }
                }
            });
        });
    </script>
@endsection