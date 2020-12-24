@extends('admin.layout.app')
{{--Setting values--}}
@php
    $tutor_profile = $tutor->profile;
    $tutor_rating = $tutor_profile->rating();
    $tutor_specializations = $tutor_profile->tutor_specializations;
    $tutor_languages = $tutor_profile->tutor_languages;
    $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
    $tutor_interests = $tutor_profile->tutor_interests;
    $tutor_certifications = $tutor_profile->tutor_certifications;
    $tutor_education = $tutor_profile->education;
    $tutor_availabilities = $tutor_profile->tutor_availabilities;
@endphp
@section('content')
    <div ui-view class="app-body" id="view">
            <!-- ############ PAGE START-->
                <div class="p-a white lt box-shadow">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.tutors')}}">Tutors</a></li>
                            <li class="breadcrumb-item active">{{$tutor->name}} {{$tutor->last_name}}</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="m-b-0 _300">{{$tutor->name}} {{$tutor->last_name}}</h4>
                        </div>
                        <div class="col-sm-6 text-sm-right"></div>
                    </div>
                </div>
                <div class="row">@include('admin.layout.errors')</div>
                <div class="padding">
                    <div class="box padding">
                        <div class="box-header">
                            <img id="profile-img" src="{{asset($tutor_profile->picture)}}" class="circle " width="150" height="150" alt="...">
                            <div style="padding: 15px">
                                <h2>{{$tutor->name}} {{$tutor->middle_name}} {{$tutor->last_name}}</h2>
                            </div>
                            <div>
                                <span class="label {{($tutor->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$tutor->email}} ">
                                    {{($tutor->online_status)? 'Online': 'Offline'}}
                                </span>
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
                                        <div class="col-sm-10">{{ $tutor->name }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Middle Name</label>
                                        <div class="col-sm-10">@if($tutor->middle_name) {{$tutor->middle_name}} @else <i class="text-muted">Not Set</i> @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Last Name*</label>
                                        <div class="col-sm-10">{{ $tutor->last_name }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Mobile*</label>
                                        <div class="col-sm-10">{{ $tutor->mobile }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Email*</label>
                                        <div class="col-sm-10">{{ $tutor->email }}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Date Created</label>
                                        <div class="col-sm-10">{{$tutor->created_at->format('F j, Y H:i:s')}}</div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="title_arabic">Status</label>
                                        <div class="col-sm-10">
                                            @if($tutor->status == 'under_review')
                                                <span class="label  yellow pos-rlt m-r-xs">Under Review</span>
                                            @elseif($tutor->status == 'active')
                                                <span class="label success pos-rlt m-r-xs">Activated</span>
                                            @elseif($tutor->status == 'suspended')
                                                <span class="label red pos-rlt m-r-xs">Suspended</span>
                                            @elseif($tutor->status == 'block')
                                                <span class="label dark pos-rlt m-r-xs">Blocked</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2" >
                                            <a href="{{route('admin.tutor.edit',['id' => $tutor->id])}}" class="btn btn-fw primary" ><i class="fa fa-edit"></i> Edit Info</a>
                                        </div>
                                        <div class="col-sm-10"></div>
                                    </div>
                                </form>
                            </div>

                            {{--profile tab--}}
                            <div class="tab-pane" id="profile" aria-expanded="false">
                                <form role="form" method="POST" action="#" enctype="multipart/form-data">
                                    {{--Video--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Profile Video</label>
                                        <div class="col-sm-10">
                                            @if(!$tutor_profile->video)
                                                <i class="text-muted">Not Set</i>
                                            @else
                                                <div class="text-center">
                                                    <video width="600" height="400" controls>
                                                        <source src="{{asset($tutor_profile->video)}}" type="video/mp4" />
                                                    </video>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Specialization--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Specializations</label>
                                        <div class="col-sm-10">
                                            @if($tutor_specializations->count() > 0)
                                                @foreach($tutor_specializations as $tutor_specialization)
                                                    {{$tutor_specialization->topic->topic}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Languages--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Languages</label>
                                        <div class="col-sm-10">
                                            @if($tutor_languages->count() > 0)
                                                @foreach($tutor_languages as $tutor_language)
                                                    {{$tutor_language->language->language}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Tutoring Style--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Tutoring Style</label>
                                        <div class="col-sm-10">
                                            @if($tutor_tutoring_styles->count() > 0)
                                                @foreach($tutor_tutoring_styles as $tutor_tutoring_style)
                                                    {{$tutor_tutoring_style->tutoring_style->tutoring_style}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Interest--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Interests</label>
                                        <div class="col-sm-10">
                                            @if($tutor_interests->count() > 0)
                                                @foreach($tutor_interests as $tutor_interest)
                                                    {{$tutor_interest->interest->interest}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Certificate--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Certificate</label>
                                        <div class="col-sm-10">
                                            @if($tutor_certifications->count() > 0)
                                                @foreach($tutor_certifications as $tutor_certification)
                                                    {{$tutor_certification->title}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Education--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Education</label>
                                        <div class="col-sm-10">
                                            @if(!$tutor_education)
                                                <i class="text-muted">Not Set</i>
                                            @else
                                                {{$tutor_education}}
                                            @endif
                                        </div>
                                    </div>

                                    {{--Availability--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Availability</label>
                                        <div class="col-sm-10">
                                            @if($tutor_availabilities->count() > 0)
                                                @foreach($tutor_availabilities as $t_availability)
                                                        <p class="">
                                                            {{Carbon::parse($t_availability->start_time)->format('g:i A')}} - {{Carbon::parse($t_availability->end_time)->format('g:i A')}}
                                                            <span style="padding-left: 20%; text-align: center">
                                                                <span class="day-rouded">
                                                                    @if($t_availability->SUN == 1)<span>S</span>  @endif
                                                                    @if($t_availability->MUN == 1)<span>M</span> @endif
                                                                    @if($t_availability->TUE == 1)<span>T</span> @endif
                                                                    @if($t_availability->WED == 1)<span>W</span> @endif
                                                                    @if($t_availability->THU == 1)<span>TH</span> @endif
                                                                    @if($t_availability->FRI == 1)<span>F</span> @endif
                                                                    @if($t_availability->SAT == 1)<span>SA</span> @endif
                                                                </span>
                                                            </span>
                                                        </p>
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>

                                    {{--Rating--}}
                                    <div class="row form-group">
                                        <label class="col-sm-2" for="exampleInputEmail1">Rating</label>
                                        <div class="col-sm-10">
                                            <div class="review-summary p-3 mb-5">
                                                <div class="row">
                                                    <div class="col-md-3 text-right">
                                                        <p class="m-0 big-rating">{{$tutor_rating['total_rating']}}</p>
                                                        <p class="mb-0 mt-2 mr-3 rating-total">{{$tutor_rating['total_raters']}}</p>
                                                    </div>
                                                    <div class="col-md-9 border-l-grey">
                                                        <div class="stars">
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            ({{$tutor_rating['rating_frequencies'][5]}})
                                                        </div>
                                                        <div class="stars">
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            ({{$tutor_rating['rating_frequencies'][4]}}) </div>
                                                        <div class="stars">
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            ({{$tutor_rating['rating_frequencies'][3]}}) </div>
                                                        <div class="stars">
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            ({{$tutor_rating['rating_frequencies'][2]}}) </div>
                                                        <div class="stars">
                                                            <i class="fa fa-star fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            <i class="fa fa-star no-fill mr-2"></i>
                                                            ({{$tutor_rating['rating_frequencies'][1]}}) </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            {{--Session Reservations--}}
                            <div class="tab-pane" id="session_reservations" aria-expanded="false">
                                @if($tutor->learning_session_reservations->count() < 1)
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
                                                <th>Student</th>
                                                <th>Topic</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th style="width:50px;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $serialNumberCounter = 1;
                                            @endphp
                                            @foreach($tutor->learning_session_reservations as $learning_session_reservation)
                                                <tr>
                                                    <td>
                                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                        {{$serialNumberCounter++ }}
                                                    </td>
                                                    <td>
                                                         <span class="w-40 avatar">
                                                          <img src="{{asset($learning_session_reservation->student->profile->picture)}}" alt="...">
                                                          <i class="{{($learning_session_reservation->student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-stu-'.$learning_session_reservation->tutor->email}}"></i>
                                                        </span>
                                                        <br>
                                                        <h6 style="margin-top: 10px; margin-bottom: 0">{{$learning_session_reservation->student->name}} {{$learning_session_reservation->student->last_name}}</h6>
                                                    </td>
                                                    <td>{{$learning_session_reservation->topic->topic}}</td>
                                                    <td>{{$learning_session_reservation->date}}</td>
                                                    <td>{{$learning_session_reservation->start_time}}</td>
                                                    <td>{{$learning_session_reservation->end_time}}</td>
                                                    <td>
                                                        <span class="label {{($learning_session_reservation->status == true)? 'success': 'red'}} pos-rlt m-r-xs">
                                                            {{($learning_session_reservation->status)? 'Active': 'Completed'}}
                                                        </span>
                                                    <td>{{$tutor->created_at->format('F j, Y')}}</td>
                                                    <td style="width:18%;">
                                                        {{--                                                        <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>--}}
                                                        <a class="btn btn-sm info" href="#"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                                        <a class="btn btn-sm danger" onclick="showWarningDialog({{$learning_session_reservation->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
                                                        <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{--Session history--}}
                            <div class="tab-pane" id="session_history" aria-expanded="false">
                                @if($tutor->learning_session_participants->count() < 1)
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
                                                <th>Student</th>
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
                                            {{--@foreach($tutor->learning_session as $learning_session)--}}
                                            @foreach($tutor->learning_session_participants as $learning_session)
                                                <tr>
                                                    <td>
                                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                                        {{$serialNumberCounter++ }}
                                                    </td>
                                                    <td>
                                                         <span class="w-40 avatar">
                                                          <img src="{{asset($learning_session->student->profile->picture)}}" alt="...">
                                                          <i class="{{($learning_session->student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-stu-'.$learning_session->student->email}}"></i>
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
                                {{--nav--}}
                                <div class="b-b nav-active-primary">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#earningTab" data-toggle="tab" data-target="#earningTab" aria-expanded="false">Earning</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#withdrawTab" data-toggle="tab" data-target="#withdrawTab" aria-expanded="false">Withdraw</a>
                                        </li>
                                    </ul>
                                </div>

                                {{--tabs--}}
                                <div class="tab-content p-a m-b-md">
                                    {{--earning tab--}}
                                    <div class="tab-pane active" id="earningTab" aria-expanded="false">
                                        @if($tutor->tutor_earning_transactions->count() < 1)
                                            <div class="table-responsive text-center">No record found.</div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped b-t">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:20px;">Sno</th>
                                                        <th>Earning Amount</th>
                                                        <th>Created Date</th>
                                                        <th style="width:50px;">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $serialNumberCounter = 1;
                                                    @endphp
                                                    @foreach($tutor->tutor_earning_transactions as $transaction)
                                                        <tr>
                                                            <td>
                                                                {{$serialNumberCounter++ }}
                                                            </td>
                                                            <td>{{$transaction->earning_amount}}</td>
                                                            <td>{{$tutor->created_at->format('F j, Y')}}</td>
                                                            <td style="width:18%;">
                                                                <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    {{--withdraw tab--}}
                                    <div class="tab-pane " id="withdrawTab" aria-expanded="false">
                                        @if($tutor->tutor_withdraw_transactions->count() < 1)
                                            <div class="table-responsive text-center">No record found.</div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped b-t">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:20px;">Sno</th>
                                                        <th>Earning Amount</th>
                                                        <th>Created Date</th>
                                                        <th style="width:50px;">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $serialNumberCounter = 1;
                                                    @endphp
                                                    @foreach($tutor->tutor_withdraw_transactions as $transaction)
                                                        <tr>
                                                            <td>
                                                                {{$serialNumberCounter++ }}
                                                            </td>
                                                            <td>{{$transaction->withdraw_amount}}</td>
                                                            <td>{{$tutor->created_at->format('F j, Y')}}</td>
                                                            <td style="width:18%;">
                                                                <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
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
                    </div>
                </div>
            <!-- ############ PAGE END-->

        </div>
@endsection


{{--Own styles and scripts--}}
@section('styles')
    <style>
        .day-rouded span {
            border-radius: 500px;
            background-color: #28a745;
            padding: 0.20em 0.55em;
            color: white;
        }

        /*rating*/
            .review-summary
            {background: #fff;}

            .big-rating
            {font-weight: 300;
                line-height:85%;
                color: #007bff;
                font-size: 100px;}
            .rating-total
            {font-size: 20px;}

            .stars
            {font-size: 18px;}

            .fill
            {color: #ffd200;}

            .no-fill
            {color: #cdd4e8;}

            .border-l-grey
            {border-left: 1px solid #e6e9f1;}

    </style>

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
            var elements = document.getElementsByClassName('online-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('red');
                    element.classList.add('success');
                    element.innerHTML = "Online";
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('success');
                        element.classList.add('red');
                        element.innerHTML = "Offline";
                    }
                }
            });
        });

        // student
        var channel = pusher.subscribe('student.status');
        channel.bind('student.status.event', function (data) {
            var student = data.student;
            // console.log(student);
            var elements = document.getElementsByClassName('online-stu-'+student.email);
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