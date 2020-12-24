@extends('admin.layout.app')
{{--Setting values for profile--}}
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
                    <a href="{{route('admin.tutor.show',['id' => $tutor->id])}}">
                        <img id="profile-img" src="{{asset($tutor->profile->picture)}}" class="circle " width="150"
                             height="150" alt="...">
                        <div style="padding: 15px">
                                <span class="text-center">
                                    <a id="change-profile-image" class="btn btn-outline-primary" href="?tab=profile#">
                                        <i class="fa fa-refresh"></i>
                                        <input type="file" id="select-profile-image"
                                               accept="image/png, image/jpeg, image/gif" style="display:none">
                                        Change Picture
                                    </a>
                                    <a id="remove-profile-image" class="btn btn-outline-danger" href="?tab=profile#">
                                        <i class="fa fa-trash-o"></i>
                                        Remove Picture</a>
                                </span>
                            <h2>{{$tutor->name}} {{$tutor->middle_name}} {{$tutor->last_name}}</h2>
                        </div>
                    </a>
                    <div>
                                <span class="label {{($tutor->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$tutor->email}} ">
                                    {{($tutor->online_status)? 'Online': 'Offline'}}
                                </span>
                    </div>
                </div>
                <div class="b-b b-primary nav-active-primary">
                    <ul class="nav nav-tabs">

                        {{--info--}}
                        <li class="nav-item">
                            <a class="nav-link @if($selectedTab == 'info') active @endif" href="#info" data-toggle="tab"
                               data-target="#info" aria-expanded="false">Basic Info</a>
                        </li>

                        {{--profile--}}
                        <li class="nav-item">
                            <a class="nav-link @if($selectedTab == 'profile') active @endif " href="#profile"
                               data-toggle="tab" data-target="#profile" aria-expanded="true">Profile</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-a m-b-md">
                    {{--info tab--}}
                    <div class="tab-pane @if($selectedTab == 'info') active @endif" id="info" aria-expanded="false">
                        <form role="form" method="POST"
                              action="{{route('admin.tutor.update.info',['id' => $tutor->id])}}"
                              enctype="multipart/form-data">
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">First Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="name"
                                           placeholder="Enter First Name" value="{{ $tutor->name }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Middle Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="middle_name"
                                           placeholder="Enter Middle Name"
                                           @if($tutor->middle_name) value="{{$tutor->middle_name}}"@endif>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Last Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="last_name"
                                           placeholder="Enter Last Name" value="{{ $tutor->last_name }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Mobile*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" name="mobile"
                                           placeholder="Enter Mobile" value="{{ $tutor->mobile }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Email*</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="" name="email"
                                           placeholder="Enter Email" value="{{ $tutor->email }}">
                                </div>
                            </div>
                            {{--                                    <div class="row form-group">
                                                                    <label class="col-sm-2" for="title_arabic">Date Created</label>
                                                                    <div class="col-sm-10">{{$tutor->created_at->format('F j, Y H:i:s')}}</div>
                                                                </div>--}}
                            <div class="row form-group">
                                <label class="col-sm-2" for="title_arabic">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="under_review"
                                                @if($tutor->staus == 'under_review') selected @endif>Under Review
                                        </option>
                                        <option value="active" @if($tutor->status == 'active') selected @endif>Active
                                        </option>
                                        <option value="suspended" @if($tutor->status == 'suspended') selected @endif>
                                            Suspended
                                        </option>
                                        <option value="block" @if($tutor->status == 'block') selected @endif>Block
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-2" for="is_percentage">Is Percentage?</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" name="is_percentage" id="is_percentage"
                                           {{ ($tutor->is_percentage) ? 'checked' : null }} onclick="changeTextPercentageInput(this)">
                                </div>
                            </div>
                            <div class="row form-group">
                                @php
                                    $name = 'Fixed';
                                    if($tutor->is_percentage){
                                        $name = 'Percentage';
                                    }
                                @endphp
                                <label class="col-sm-2" for="charge" id="inputTitle">{{ $name }}</label>
                                <div class="col-sm-10">
                                    <input type="text" id="charge" class="form-control" placeholder="10" name="charge"
                                           value="{{ $tutor->charge }}" required>
                                </div>
                            </div>

                            <div class="form-group m-t-lg text-sm-right">
                                <div class="col-sm-12">
                                    <button class="btn btn-outline-primary primary" name="publish">Update Info <i
                                                class="fa fa-save"></i></button>
                                </div>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>

                    {{--profile tab--}}
                    <div class="tab-pane @if($selectedTab == 'profile') active @endif" id="profile"
                         aria-expanded="false">
                        <form role="form" method="POST" action="#" enctype="multipart/form-data">
                            {{--Video--}}
                            <div class="row form-group">
                                <label id="pVid" class="col-sm-2" for="exampleInputEmail1">Profile Video</label>
                                <div class="col-sm-10">
                                    <input type="file" id="select-profile-video" accept="video/mp4"
                                           style="display:none">
                                    @if(!$tutor_profile->video)
                                        <div class="col-sm-10">
                                            <i class="text-muted">Not set</i>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="text-center no-video p-5">
                                                <a id="add-profile-video" class="btn btn-outline-primary"
                                                   href="?tab=profile#pVid" role="button">
                                                    <i class="fa fa-plus"></i>
                                                    Add Video
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-10">
                                            <div class="text-center">
                                                <video width="600" height="400" controls>
                                                    <source src="{{asset($tutor_profile->video)}}" type="video/mp4"/>
                                                </video>
                                            </div>

                                            <div class="text-center">
                                                <a id="remove-profile-video" class="btn btn-outline-danger"
                                                   href="?tab=profile#pVid" role="button">
                                                    <i class="fa fa-trash-o"></i>
                                                    Remove Video</a>
                                                <a id="change-profile-video" class="btn btn-outline-primary"
                                                   href="?tab=profile#pVid" role="button">
                                                    <i class="fa fa-refresh"></i>
                                                    Change Video
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                    @endif
                                </div>
                            </div>

                            {{--Specialization--}}
                            @php
                                $topics = [];
                                foreach($tutor_specializations as $tutor_specialization){
                                    if((\App\Models\Topic::find($tutor_specialization->topic_id))->status == 'activate'){
                                        $topics[] = \App\Models\Topic::find($tutor_specialization->topic_id);
                                    }
                                }
                            @endphp
                            <div id="data-topics" data-topics="{{json_encode($topics)}}"></div>
                            <div id="data-tutor-specializations"
                                 data-tutor-specializations="{{json_encode($tutor_specializations)}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Specializations</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="specializations-p">
                                            @if($tutor_specializations->count() > 0)
                                                @foreach($tutor_specializations as $tutor_specialization)
                                                    {{$tutor_specialization->topic->topic}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-specialization-a"
                                             class="btn btn-outline-primary" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                            @if($tutor_specializations->count() > 0)
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @else
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Languages--}}
                            @php
                                $languages = [];
                                foreach($tutor_languages as $tutor_language){
                                    $languages[] = \App\Models\Language::find($tutor_language->language_id);
                                }
                            @endphp
                            <div id="data-languages" data-languages="{{json_encode($languages)}}"></div>
                            <div id="data-tutor-languages"
                                 data-tutor-languages="{{json_encode($tutor_languages)}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Languages</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="languages-p">
                                            @if($tutor_languages->count() > 0)
                                                @foreach($tutor_languages as $tutor_language)
                                                    {{$tutor_language->language->language}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-language-a" class="btn btn-outline-primary">
                                            @if($tutor_languages->count() > 0)
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @else
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{--Tutoring Style--}}
                            @php
                                $tutoring_styles = [];
                                    foreach($tutor_tutoring_styles as $tutor_tutoring_style){
                                           $tutoring_styles[] =  \App\Models\TutoringStyle::find($tutor_tutoring_style->tutoring_style_id);
                                    }
                            @endphp
                            <div id="data-tutoring_styles"
                                 data-tutoring_styles="{{json_encode($tutoring_styles)}}"></div>
                            <div id="data-tutor-tutoring_styles"
                                 data-tutor-tutoring_styles="{{json_encode($tutor_tutoring_styles)}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Tutoring Style</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="tutoring_style-p">
                                            @if($tutor_tutoring_styles->count() > 0)
                                                @foreach($tutor_tutoring_styles as $tutor_tutoring_style)
                                                    {{$tutor_tutoring_style->tutoring_style->tutoring_style}}@if(!$loop->last)
                                                        ,@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-tutoring_style-a" class="btn btn-outline-primary">
                                            @if($tutor_tutoring_styles->count() > 0)
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @else
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Interest--}}
                            @php
                                $interests = [];
                                foreach ($tutor_interests as $tutor_interest){
                                    $interests[] = \App\Models\Interest::find($tutor_interest->interest_id);
                                }
                            @endphp
                            <div id="data-interests" data-interests="{{json_encode($interests)}}"></div>
                            <div id="data-tutor-interests"
                                 data-tutor-interests="{{json_encode($tutor_interests)}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Interests</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="interest-p">
                                            @if($tutor_interests->count() > 0)
                                                @foreach($tutor_interests as $tutor_interest)
                                                    {{$tutor_interest->interest->interest}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-interest-a" class="btn btn-outline-primary">
                                            @if($tutor_interests->count() > 0)
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @else
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Certificate--}}
                            <div id="data-tutor-certificates"
                                 data-tutor-certificates="{{json_encode($tutor_certifications)}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Certificate</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="certificates-p">
                                            @if($tutor_certifications->count() > 0)
                                                @foreach($tutor_certifications as $tutor_certification)
                                                    {{$tutor_certification->title}}@if(!$loop->last),@endif
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-certificates-a" class="btn btn-outline-primary">
                                            @if($tutor_certifications->count() > 0)
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @else
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Education--}}
                            <div id="data-tutor-education" data-tutor-education="{{$tutor_education}}"></div>
                            <div class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Education</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <p id="education-p">
                                            @if(!$tutor_education)
                                                <i class="text-muted">Not Set</i>
                                            @else
                                                {{$tutor_education}}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <div id="edit-education-a" class="btn btn-outline-primary">
                                            @if(!$tutor_education)
                                                <i class="fa fa-plus"></i>
                                                Add
                                            @else
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{--Availability--}}
                            <div id="tutor_pf_availability" class="row form-group">
                                <label class="col-sm-2" for="exampleInputEmail1">Availability</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-10">
                                        <div id="availability-div">
                                            @if($tutor_availabilities->count() > 0)
                                                @foreach($tutor_availabilities as $t_availability)
                                                    <div id="availability-schedule-{{$t_availability->id}}-div"
                                                         class="row">
                                                        <div class="col-sm-11">
                                                            {{Carbon::parse($t_availability->start_time)->format('g:i A')}}
                                                            - {{Carbon::parse($t_availability->end_time)->format('g:i A')}}
                                                            <span style="padding-left: 20%; text-align: center">
                                                                <span class="day-rouded">
                                                                    @if($t_availability->SUN == 1)<span>S</span>  @endif
                                                                    @if($t_availability->MON == 1)<span>M</span> @endif
                                                                    @if($t_availability->TUE == 1)<span>T</span> @endif
                                                                    @if($t_availability->WED == 1)<span>W</span> @endif
                                                                    @if($t_availability->THU == 1)<span>TH</span> @endif
                                                                    @if($t_availability->FRI == 1)<span>F</span> @endif
                                                                    @if($t_availability->SAT == 1)<span>SA</span> @endif
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <a class="btn btn-link text-danger col-sm-1"
                                                           {{--href="#"--}} onclick="deleteAvailabilitySchedule('availability-schedule-{{$t_availability->id}}-div',{{$t_availability->id}})"><i
                                                                    class="fa fa-times"></i></a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <i class="text-muted">Not Set</i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <a id="add-availability-a" class="btn btn-outline-primary" href="?tab=profile#">
                                            <i class="fa fa-plus"></i> Add New
                                        </a>
                                    </div>
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
                                                    ({{$tutor_rating['rating_frequencies'][4]}})
                                                </div>
                                                <div class="stars">
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    ({{$tutor_rating['rating_frequencies'][3]}})
                                                </div>
                                                <div class="stars">
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    ({{$tutor_rating['rating_frequencies'][2]}})
                                                </div>
                                                <div class="stars">
                                                    <i class="fa fa-star fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    <i class="fa fa-star no-fill mr-2"></i>
                                                    ({{$tutor_rating['rating_frequencies'][1]}})
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->


        <!-- Edit Specialization -->
        <div class="modal fade" id="editSpecialization-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Specialization</h5>
                        <button id="add-specialization-close-btn" class="close col-sm-1" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="editSpecialization-modal-body"></div>
                        <div id="add-specialization-div" class="row">
                            <a id="add-specialization-a" class="col-sm-1 btn btn-link" href="#">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                            <form id="add-specialization-form" class="col-sm-11">
                                <div class="form-group row">
                                    {{--<label class="col-sm-4 col-form-label">Select</label>--}}
                                    <div class="col-sm-12">
                                        <select name="topic_id" class="form-control" id="select-topic">
                                            <option>Select Topic:</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="add-specialization-cancel-btn" type="button" class="btn btn-link mr-4">Cancel
                        </button>
                        <button id="add-specialization-ok-btn" type="button" class="btn btn-success">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Language -->
        <div class="modal fade" id="editLanguage-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Languages</h5>
                        <button id="add-language-close-btn" type="button" class="close col-sm-1" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="editLanguage-modal-body"></div>
                        <div id="add-language-div" class="row">
                            <a id="add-language-a" class="btn btn-link col-sm-1" href="#">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                            <form id="add-language-form" class="col-sm-11">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select name="language_id" class="form-control" id="select-language">
                                            <option>Select Language:</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-language-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-language-ok-btn" type="button" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit tutoring_style -->
        <div class="modal fade" id="editTutoring_style-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Tutoring Style</h5>
                        <button id="add-tutoring_style-close-btn" type="button" class="close col-sm-1"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="editTutoring_style-modal-body"></div>
                        <div id="add-tutoring_style-div" class="row">
                            <a id="add-tutoring_style-a" class="btn btn-link col-sm-1" href="#">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                            <form id="add-tutoring_style-form" class="col-sm-11">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select name="tutoring_style_id" class="form-control"
                                                id="select-tutoring_style">
                                            <option>Select Tutoring style:</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="">
                            <button id="add-tutoring_style-cancel-btn" type="button" class="btn btn-link mr-4">Cancel
                            </button>
                            <button id="add-tutoring_style-ok-btn" type="button" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit interest -->
        <div class="modal fade" id="editInterest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Interests</h5>
                        <button id="add-interest-close-btn" type="button" class="close col-sm-1" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="editInterest-modal-body"></div>
                        <div id="add-interest-div" class="row">
                            <a id="add-interest-a" class="btn btn-link col-sm-1" href="#">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                            <form id="add-interest-form" class="col-sm-11">
                                <div class="form-group row">
                                    {{--<label class="col-sm-4 col-form-label">Select</label>--}}
                                    <div class="col-sm-12">
                                        <select name="interest_id" class="form-control" id="select-interest">
                                            <option>Select Interest:</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-interest-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-interest-ok-btn" type="button" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Certificate -->
        <div class="modal fade" id="showCertificate-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Certificate</h5>
                        <button id="show-certificate-close-btn" type="button" class="close col-sm-1"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="show-certificate-modal-body"></div>
                        <div id="show-certificate-div" class="row">
                            <a id="add-certificate-a" class="btn btn-link col-sm-1" href="#">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="show-certificate-cancel-btn" type="button" class="btn btn-link mr-4"
                                    data-dismiss="modal">Cancel
                            </button>
                            <button id="show-certificate-ok-btn" type="button" class="btn btn-success"
                                    data-dismiss="modal">Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCertificate-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Certificate</h5>
                        <button type="button" class="close col-sm-1" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-certificate-form">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input id="add-certificate-title" type="text" name="title" class="form-control"
                                           placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input id="add-certificate-description" type="text" name="description"
                                           class="form-control" placeholder="Enter description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Issuing Authority</label>
                                <div class="col-sm-8">
                                    <input id="add-certificate-issuing-authority" type="text" name="issuing_authority"
                                           class="form-control" placeholder="About authorities">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">From</label>
                                <div class="col-sm-8">
                                    <div class="input-group date" ui-jp="datetimepicker" ui-options="{
                                                                                                    icons: {
                                                                                                      time: 'fa fa-clock-o',
                                                                                                      date: 'fa fa-calendar',
                                                                                                      up: 'fa fa-chevron-up',
                                                                                                      down: 'fa fa-chevron-down',
                                                                                                      previous: 'fa fa-chevron-left',
                                                                                                      next: 'fa fa-chevron-right',
                                                                                                      today: 'fa fa-screenshot',
                                                                                                      clear: 'fa fa-trash',
                                                                                                      close: 'fa fa-remove'
                                                                                                    }
                                                                                                  }">
                                        <input id="add-certificate-start-date" class="form-control has-value"
                                               name="start_date" type="text">
                                        <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                  </span>
                                    </div>
                                    {{--<div class="input-group row">--}}
                                    {{--<input type="text" name="start_date" class="form-control" placeholder="Add Date">--}}
                                    {{--<span class="input-group-append">--}}
                                    {{--<button class="btn btn-outline-success" type="button">--}}
                                    {{--<i class="fa fa-calendar-alt"></i>--}}
                                    {{--</button>--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">To</label>
                                <div class="col-sm-8">
                                    <div class="input-group date" ui-jp="datetimepicker" ui-options="{
                                                                                                    icons: {
                                                                                                      time: 'fa fa-clock-o',
                                                                                                      date: 'fa fa-calendar',
                                                                                                      up: 'fa fa-chevron-up',
                                                                                                      down: 'fa fa-chevron-down',
                                                                                                      previous: 'fa fa-chevron-left',
                                                                                                      next: 'fa fa-chevron-right',
                                                                                                      today: 'fa fa-screenshot',
                                                                                                      clear: 'fa fa-trash',
                                                                                                      close: 'fa fa-remove'
                                                                                                    }
                                                                                                  }">
                                        <input id="add-certificate-end-date" class="form-control has-value"
                                               name="end_date" type="text">
                                        <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                  </span>
                                    </div>
                                    {{--<div class="input-group">--}}
                                    {{--<input type="text" name="end_date" class="form-control" placeholder="Add Date">--}}
                                    {{--<span class="input-group-append">--}}
                                    {{--<button class="btn btn-outline-success" type="button">--}}
                                    {{--<i class="fa fa-calendar-alt"></i>--}}
                                    {{--</button>--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="add_certificate_save_btn" type="button"
                                    class="btn btn-success" {{--data-dismiss="modal"--}}>Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editCertificate-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Certificate</h5>
                        <button type="button" class="close col-sm-1" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-certificate-form">

                            {{--id--}}
                            <input id="edit-certificate-id" type="hidden" name="tutor_certificate_id">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-title" type="text" name="title" class="form-control"
                                           placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-description" type="text" name="description"
                                           class="form-control" placeholder="Enter description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Issuing Authority</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-issuing-authority" type="text" name="issuing_authority"
                                           class="form-control" placeholder="About authorities">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">From</label>
                                <div class="col-sm-8">
                                    <div class="input-group date" ui-jp="datetimepicker" ui-options="{
                                                                                                    icons: {
                                                                                                      time: 'fa fa-clock-o',
                                                                                                      date: 'fa fa-calendar',
                                                                                                      up: 'fa fa-chevron-up',
                                                                                                      down: 'fa fa-chevron-down',
                                                                                                      previous: 'fa fa-chevron-left',
                                                                                                      next: 'fa fa-chevron-right',
                                                                                                      today: 'fa fa-screenshot',
                                                                                                      clear: 'fa fa-trash',
                                                                                                      close: 'fa fa-remove'
                                                                                                    }
                                                                                                  }">
                                        <input class="form-control has-value" name="start_date" type="text">
                                        <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                  </span>
                                    </div>
                                    {{--<div class="input-group">--}}
                                    {{--<input id="edit-certificate-start-date" type="text" name="start_date" class="form-control" placeholder="Add Date">--}}
                                    {{--<span class="input-group-append">--}}
                                    {{--<button class="btn btn-outline-success" type="button">--}}
                                    {{--<i class="fa fa-calendar-alt"></i>--}}
                                    {{--</button>--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">To</label>
                                <div class="col-sm-8">
                                    <div class="input-group date" ui-jp="datetimepicker" ui-options="{
                                                                                                    icons: {
                                                                                                      time: 'fa fa-clock-o',
                                                                                                      date: 'fa fa-calendar',
                                                                                                      up: 'fa fa-chevron-up',
                                                                                                      down: 'fa fa-chevron-down',
                                                                                                      previous: 'fa fa-chevron-left',
                                                                                                      next: 'fa fa-chevron-right',
                                                                                                      today: 'fa fa-screenshot',
                                                                                                      clear: 'fa fa-trash',
                                                                                                      close: 'fa fa-remove'
                                                                                                    }
                                                                                                  }">
                                        <input class="form-control has-value" name="end_date" type="text">
                                        <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                  </span>
                                    </div>
                                    {{--<div class="input-group">--}}
                                    {{--<input id="edit-certificate-end-date" type="text" name="end_date" class="form-control" placeholder="Add Date">--}}
                                    {{--<span class="input-group-append">--}}
                                    {{--<button class="btn btn-outline-success" type="button">--}}
                                    {{--<i class="fa fa-calendar-alt"></i>--}}
                                    {{--</button>--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="edit_certificate_update_btn" type="button"
                                    class="btn btn-success" {{--data-dismiss="modal"--}}>Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Education model -->
        <div class="modal fade" id="editEducation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">Education</h5>
                        <button type="button" class="close col-sm-1" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-education-form">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Educational Details</label>
                                <div class="col-sm-10">
                                    <textarea id="edit-education-area" name="education" class="form-control"
                                              placeholder="Educational Details" rows="4"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="edit-education_update-btn" type="button" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- add-schedule model -->
        <div class="modal fade" id="addSchedule-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header row">
                        <h5 class="modal-title col-sm-11" id="exampleModalLabel">New Schedule</h5>
                        <button id="add-availability-close-btn" type="button" class="close col-sm-1"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-schedule-form">
                            {{--start time--}}
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Start time</label>
                                {{--hours--}}
                                <div class="col-sm-6">
                                    <select class="form-control" id="start_time_hour" name="start_time_hour">
                                        <option value="12">12:00</option>
                                        <option value="01">01:00</option>
                                        <option value="02">02:00</option>
                                        <option value="03">03:00</option>
                                        <option value="04">04:00</option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                    </select>
                                </div>
                                {{--Meridiem - AM / PM--}}
                                <div class="col-sm-4">
                                    <select class="form-control" id="start_time_meridian" name="start_time_meridian">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                            {{--End Time--}}
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">End time</label>
                                {{--hours--}}
                                <div class="col-sm-6">
                                    <select class="form-control" id="end_time_hour" name="end_time_hour">
                                        <option value="12">12:00</option>
                                        <option value="01">01:00</option>
                                        <option value="02">02:00</option>
                                        <option value="03">03:00</option>
                                        <option value="04">04:00</option>
                                        <option value="05">05:00</option>
                                        <option value="06">06:00</option>
                                        <option value="07">07:00</option>
                                        <option value="08">08:00</option>
                                        <option value="09">09:00</option>
                                        <option value="10">10:00</option>
                                        <option value="11">11:00</option>
                                    </select>
                                </div>
                                {{--Meridian - AM / PM--}}
                                <div class="col-sm-4">
                                    <select class="form-control" id="end_time_meridian" name="end_time_meridian">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>

                            {{--Repeat--}}
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Repeat</label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="select-availability-repeat"
                                            name="availability_repeat">
                                        <option value="none">None</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                    </select>
                                </div>
                                <div class="col-sm-8 p-2 day-rouded pull-right" id="availability_days">
                                    <span> <input name="sun" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">SUN </label></span>
                                    <span> <input name="mon" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">MON </label></span>
                                    <span> <input name="tue" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">TUE </label></span>
                                    <span> <input name="wed" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">WED </label></span>
                                    <span> <input name="thu" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">THU </label></span>
                                    <span> <input name="fri" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">FRI </label></span>
                                    <span> <input name="sat" type="checkbox" value="false" onchange="selectDay(this)"/> <label
                                                class="checkbox">SAT </label></span>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-availability-cancel-btn" type="button" class="btn btn-link mr-4">Cancel
                            </button>
                            <button id="availability_save" type="button" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Uploading bar Modal -->
        <div class="modal fade" id="video-upload-modal"
             data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"
                 {{--style="display: flex; flex-direction: column; justify-content: center; overflow: auto;"--}} role="document">
                <div class="modal-content">
                    {{--                    <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Uploading Video</h5>
                                            <buttons type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </buttons>
                                        </div>--}}
                    <div id="video-upload-modal-body" class="modal-body">

                        <div id="video-upload-progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            0%
                        </div>

                    </div>
                    {{--                    <div class="modal-footer ">
                                            <div class="">
                                                Uploading...
                                            </div>
                                        </div>--}}
                </div>
            </div>
        </div>

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
        .review-summary {
            background: #fff;
        }

        .big-rating {
            font-weight: 300;
            line-height: 85%;
            color: #007bff;
            font-size: 100px;
        }

        .rating-total {
            font-size: 20px;
        }

        .stars {
            font-size: 18px;
        }

        .fill {
            color: #ffd200;
        }

        .no-fill {
            color: #cdd4e8;
        }

        .border-l-grey {
            border-left: 1px solid #e6e9f1;
        }

    </style>
@endsection
@section('scripts')
    <script>
        function changeTextPercentageInput(me) {
            let val = $(me).is(":checked");
            let selector = $("#inputTitle");
            selector.html("Fixed");
            if (val) {
                selector.html("Percentage");
            }
        }

        // function to delete the specialization from model
        function deleteSpecialization(div_id, tutor_specialization_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.specialization.remove',['id'=>$tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_specialization_id': tutor_specialization_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();
                    // set the data
                    $('#data-tutor-specializations').data('tutor-specializations', response.tutor_specializations);
                    $('#data-topics').data('topics', response.topics);

                    // add in specialization
                    $('#select-topic').empty().append("<option>Select Topic:</option>");
                    var $getTopics = response.getTopics.topics;
                    $.each($getTopics, function (i, topic) {
                        $('#select-topic').append("" +
                            "<option value='" + topic.id + "'>" +
                            "" + topic.topic +
                            "</option>"
                        );
                    });

                    // update the #specializations-p
                    var $topics = response.topics;
                    var text = "";
                    $('#specializations-p').empty();
                    $.each($topics, function (i, topic) {
                        text += topic.topic;
                        if (i < $topics.length - 1) {
                            text += ', ';
                        }
                    });
                    $('#specializations-p').text("" + text);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the language from model
        function deleteLanguage(div_id, tutor_language_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.language.remove',['id' => $tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_language_id': tutor_language_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();
                    // set the data
                    $('#data-tutor-languages').data('tutor-languages', response.tutor_languages);
                    $('#data-languages').data('languages', response.languages);

                    // add in language
                    $('#select-language').empty().append("<option>Select language:</option>");
                    var $getLanguages = response.getLanguages.languages;
                    $.each($getLanguages, function (i, language) {
                        $('#select-language').append("" +
                            "<option value='" + language.id + "'>" +
                            "" + language.language +
                            "</option>"
                        );
                    });

                    // update the #languages-p
                    var $languages = response.languages;
                    var text = "";
                    $('#languages-p').empty();
                    $.each($languages, function (i, language) {
                        text += language.language;
                        if (i < $languages.length - 1) {
                            text += ', ';
                        }
                    });
                    $('#languages-p').text("" + text);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the tutoring_style from model
        function deleteTutoringStyle(div_id, tutor_tutoring_style_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.tutoring_style.remove',['id' => $tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_tutoring_style_id': tutor_tutoring_style_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();
                    // set the data
                    $('#data-tutor-tutoring_styles').data('tutor-tutoring_styles', response.tutor_tutoring_styles);
                    $('#data-tutoring_styles').data('tutoring_styles', response.tutoring_styles);

                    // add in tutoring_style
                    $('#select-tutoring_style').empty().append("<option>Select Tutoring style:</option>");
                    var $getTutoring_styles = response.getTutoringStyles.tutoring_styles;
                    $.each($getTutoring_styles, function (i, tutoring_style) {
                        $('#select-tutoring_style').append("" +
                            "<option value='" + tutoring_style.id + "'>" +
                            "" + tutoring_style.tutoring_style +
                            "</option>"
                        );
                    });

                    // update the #tutoring_styles-p
                    var $tutoring_styles = response.tutoring_styles;
                    var text = "";
                    $('#tutoring_style-p').empty();
                    $.each($tutoring_styles, function (i, tutoring_style) {
                        text += tutoring_style.tutoring_style;
                        if (i < $tutoring_styles.length - 1) {
                            text += ', ';
                        }
                    });
                    $('#tutoring_style-p').text("" + text);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the interest from model
        function deleteInterest(div_id, tutor_interest_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.interest.remove',['id' => $tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_interest_id': tutor_interest_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();
                    // set the data
                    $('#data-tutor-interests').data('tutor-interests', response.tutor_interests);
                    $('#data-interests').data('interests', response.interests);

                    // add in interest
                    $('#select-interest').empty().append("<option>Select Interest:</option>");
                    var $getInterests = response.getInterests.interests;
                    $.each($getInterests, function (i, interest) {
                        $('#select-interest').append("" +
                            "<option value='" + interest.id + "'>" +
                            "" + interest.interest +
                            "</option>"
                        );
                    });

                    // update the #interests-p
                    var $interests = response.interests;
                    var text = "";
                    $('#interest-p').empty();
                    $.each($interests, function (i, interest) {
                        text += interest.interest;
                        if (i < $interests.length - 1) {
                            text += ', ';
                        }
                    });
                    $('#interest-p').text("" + text);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function for certificates
        // to delete
        function deleteCertificate(div_id, tutor_certificate_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.certificate.remove',['id' => $tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_certificate_id': tutor_certificate_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();

                    // set data
                    $('#data-tutor-certificates').data('tutor-certificates', response.tutor_certifications);

                    // update #certificates-p
                    var $certificates = response.tutor_certifications;
                    var $text = "";
                    $.each($certificates, function (i, certificate) {
                        $text += certificate.title;
                        if (i < $certificates.length - 1) {
                            $text += ', ';
                        }
                    })
                    $("#certificates-p").empty().text($text);
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // to edit {also hide the $("#showCertificate-modal")}
        function editCertificate(tutor_certificate_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.certificate.get',['id' => $tutor->id])}}',
                type: "POST",
                dataType: 'json',
                data: {
                    'tutor_certificate_id': tutor_certificate_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    var tutor_certificate = response.tutor_certificate;
                    var id = tutor_certificate.id;
                    var title = tutor_certificate.title;
                    var description = tutor_certificate.description;
                    var issuing_authority = tutor_certificate.issuing_authority;
                    var start_time = tutor_certificate.start_time;
                    var end_time = tutor_certificate.end_time;

                    $("#edit-certificate-id").val(id);
                    $("#edit-certificate-title").val(title);
                    $("#edit-certificate-description").val(description);
                    $("#edit-certificate-issuing-authority").val(issuing_authority);
                    $("#edit-certificate-start-date").val(start_time);
                    $("#edit-certificate-end-date").val(end_time);

                    $("#editCertificate-modal").modal('show');
                    // hide
                    $("#showCertificate-modal").modal('hide');
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete tutor availability schedule
        function deleteAvailabilitySchedule(div_id, tutor_availability_id) {
            $.ajax({
                url: '{{route('admin.ajax.tutor.profile.availability.schedule.remove',['id' => $tutor->id])}}',
                type: "DELETE",
                data: {
                    'tutor_availability_id': tutor_availability_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#' + div_id).remove();
                },
                error: function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to select the day
        function selectDay(element) {
            element.checked ? element.value = "true" : element.value = "false";
            //alert("value: " + element.value);
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers:
                    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            // <changing profile image>
            $('#change-profile-image').click(function () {
                document.getElementById("select-profile-image").click();
            });
            $("#select-profile-image").change(function () {
                readURLPic(this);
            });

            function readURLPic(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile-img').attr('src', e.target.result);
                        var fileName = input.files[0].name
                        var file = input.files[0];

                        var formData = new FormData();
                        formData.append('profile_pic', file);
                        ///
                        $.ajax({
                            url: '{{ route('admin.ajax.tutor.profile.pic.change',['id' => $tutor->id]) }}',
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#remove-profile-image').click(function () {
                $.ajax({
                    url: '{{ route('admin.ajax.tutor.profile.pic.remove',['id' => $tutor->id]) }}',
                    type: "DELETE",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        if (response.status + "".localeCompare('error') == 0) {
                            alert(response.msg);
                        } else {
                            $picPath = response.pic_path;
                            $('#profile-img').attr('src', $picPath);
                            alert(response.msg);
                        }
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </changing profile image>

            // <profile-video>
            $('#add-profile-video').click(function () {
                document.getElementById("select-profile-video").click();
            });
            $("#select-profile-video").change(function () {
                readURLVid(this);
            });

            function readURLVid(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        //                        $('#profile-img').attr('src', e.target.result);
                        var fileName = input.files[0].name
                        var file = input.files[0];
                        var fileSize = file.size; // size will be in bytes

                        // check file size must under 125 MBs
                        if (fileSize <= (1024 * 1024) * 126) {
                            var formData = new FormData();
                            formData.append('profile_video', file);

                            $('#video-upload-modal').modal('show');
                            var $video_upload_progress_bar = $('#video-upload-progress-bar');
                            $video_upload_progress_bar.width('0%');
                            $video_upload_progress_bar.text('0%');

                            ///
                            $.ajax({
                                url: '{{ route('admin.ajax.tutor.profile.video.change',['id'=>$tutor->id]) }}',
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                xhr: function () {
                                    var xhr = $.ajaxSettings.xhr();
                                    xhr.onprogress = function e() {
                                        // For downloads
                                        if (e.lengthComputable) {
                                            console.log((e.loaded / e.total) * 100);
                                        }
                                    };
                                    xhr.upload.onprogress = function (e) {
                                        // For uploads
                                        if (e.lengthComputable) {
                                            var pro = parseInt("" + (e.loaded / e.total) * 100);
                                            console.log(pro);
                                            $video_upload_progress_bar.width(pro + '%');
                                            $video_upload_progress_bar.text(pro + ' %');
                                        }
                                    };
                                    return xhr;
                                },
                                success: function (response) {
                                    console.log("response: " + JSON.stringify(response));
                                    // refresh the page
                                    location.reload(true);
                                },
                                error: function (error) {
                                    $('#video-upload-modal').modal('hide');
                                    alert('Error: Uploading Failed');
                                    console.log('Error: ' + JSON.stringify(error));
                                    console.log(error.responseText);
                                }
                            });
                        } else {
                            alert("File size exceeded: must be under 125 Mbs");
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#remove-profile-video').click(function () {
                $.ajax({
                    url: '{{ route('admin.ajax.tutor.profile.video.remove',['id' => $tutor->id]) }}',
                    type: "DELETE",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        location.reload(true);
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });

            $('#change-profile-video').click(function () {
                document.getElementById("select-profile-video").click();
            });
            // </profile-video>

            // <specialization>
            $('#add-specialization-form').hide();
            $('#edit-specialization-a').click(function () {
                // get data
                var $tutor_specializations = $('#data-tutor-specializations').data('tutor-specializations');
                var $topics = $('#data-topics').data('topics');
                var $content = "";
                $.each($topics, function (i, topic) {
                    /*                        console.log(i + " - " + specialization + "\n");*/
                    $content += "\n" +
                        "<div id=\"tutor-specialization-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<div class=\"row\">\n" +
                        "<p id=\"tutor-specialization-" + i + "\" class=\"col-sm-11\" >" + topic.topic + "</p>\n" +
                        "<a id=\"tutor-specialization-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteSpecialization(\"tutor-specialization-" + i + "-div\", " + $tutor_specializations[i].id + ")' >" +
                        "<i class=\"fa fa-times\"></i>" +
                        "</a>\n" +
                        "</div></div>";
                });
                $('#editSpecialization-modal-body').empty().html($content);
                $('#editSpecialization-modal').modal('show');
            });

            // <add-specialization-a>
            $('#add-specialization-a').click(function () {
                $('#add-specialization-form').show();
                $('#select-topic').empty().append("<option>Select Topic:</option>");
                $.ajax({
                    url: '{{route('admin.ajax.tutor.get.topics',['id' => $tutor->id])}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $topics = response.topics;
                        $.each($topics, function (i, topic) {
                            $('#select-topic').append("" +
                                "<option value='" + topic.id + "'>" +
                                "" + topic.topic +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-specialization-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </add-specialization-a>

            // <add-specialization-ok-btn>
            $('#add-specialization-ok-btn').click(function () {
                $text = $(this).text();
                // if text is 0
                if ($text.localeCompare("Add") == 0) {
                    // add selected specialization
                    if ($('#select-topic').val().localeCompare('Select Topic:') == 0) {
                        alert("Please Select any specialization if listed");
                    } else {
                        $.ajax({
                            url: '{{route('admin.ajax.tutor.profile.specialization.add',['id' => $tutor->id])}}',
                            type: "POST",
                            data: $('#add-specialization-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));

                                // set the data
                                $('#data-tutor-specializations').data('tutor-specializations', response.tutor_specializations);
                                $('#data-topics').data('topics', response.topics);
                                // get data
                                var $tutor_specializations = $('#data-tutor-specializations').data('tutor-specializations');
                                var $topics = $('#data-topics').data('topics');
                                var $content = "";
                                $.each($topics, function (i, topic) {
                                    $content += "\n" +
                                        "<div id=\"tutor-specialization-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<div class=\"row\">\n" +
                                        "<p id=\"tutor-specialization-" + i + "\" class=\"col-sm-11\" >" + topic.topic + "</p>\n" +
                                        "<a id=\"tutor-specialization-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteSpecialization(\"tutor-specialization-" + i + "-div\", " + $tutor_specializations[i].id + ")' >" +
                                        "<i class=\"fa fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div></div>";
                                });
                                $('#editSpecialization-modal-body').empty().html($content);

                                // update the #specializations-p
                                var text = "";
                                $('#specializations-p').empty();
                                $.each($topics, function (i, topic) {
                                    text += topic.topic;
                                    if (i < $topics.length - 1) {
                                        text += ', ';
                                    }
                                });
                                $('#specializations-p').text("" + text);

                                // update specializations in model
                                $('#add-specialization-form').hide();

                                // change btn
                                $okbtn = $('#add-specialization-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                } else {
                    $('#editSpecialization-modal').modal('hide');
                }
            });
            // </add-specialization-ok-btn>

            // <add-specialization-cancel-btn>
            $("#add-specialization-cancel-btn, #add-specialization-close-btn").click(function () {
                $text = $('#add-specialization-ok-btn').text();
                // if text is 0
                if ($text.localeCompare("Add") != 0) {
                    $('#editSpecialization-modal').modal('hide');
                }
                $('#add-specialization-form').hide();
                // change btn
                $okbtn = $('#add-specialization-ok-btn');
                $okbtn.text("Ok");
                $okbtn.removeClass('btn-primary');
                $okbtn.addClass('btn-success');
            });
            // </add-specialization-cancel-btn>
            // </specialization>

            // <language>
            $('#add-language-form').hide();
            $('#edit-language-a').click(function () {
                // get data
                var $tutor_languages = $('#data-tutor-languages').data('tutor-languages');
                var $languages = $('#data-languages').data('languages');
                var $content = "";
                $.each($languages, function (i, language) {
                    /*                        console.log(i + " - " + language + "\n");*/
                    $content += "\n" +
                        "<div id=\"tutor-language-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<div class=\"row\">\n" +
                        "<p id=\"tutor-language-" + i + "\" class=\"col-sm-11\">" + language.language + "</p>\n" +
                        "<a id=\"tutor-language-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteLanguage(\"tutor-language-" + i + "-div\", " + $tutor_languages[i].id + ")' >" +
                        "<i class=\"fa fa-times\"></i>" +
                        "</a>\n" +
                        "</div></div>";
                });
                $('#editLanguage-modal-body').empty().html($content);
                $('#editLanguage-modal').modal('show');
            });

            // <add-language-a>
            $('#add-language-a').click(function () {
                $('#add-language-form').show();
                $('#select-language').empty().append("<option>Select language:</option>");
                $.ajax({
                    url: '{{route('admin.ajax.tutor.get.languages',['id' => $tutor->id])}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $languages = response.languages;
                        $.each($languages, function (i, language) {
                            $('#select-language').append("" +
                                "<option value='" + language.id + "'>" +
                                "" + language.language +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-language-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </add-language-a>

            // <add-language-ok-btn>
            $('#add-language-ok-btn').click(function () {
                $text = $(this).text();
                // if text is 0
                if ($text.localeCompare("Add") == 0) {
                    // add selected language
                    if ($('#select-language').val().localeCompare('Select language:') == 0) {
                        alert("Please Select any language if listed");
                    } else {
                        $.ajax({
                            url: '{{route('admin.ajax.tutor.profile.language.add',['id' => $tutor->id])}}',
                            type: "POST",
                            data: $('#add-language-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));

                                // set the data
                                $('#data-tutor-languages').data('tutor-languages', response.tutor_languages);
                                $('#data-languages').data('languages', response.languages);
                                // get data
                                var $tutor_languages = $('#data-tutor-languages').data('tutor-languages');
                                var $languages = $('#data-languages').data('languages');
                                var $content = "";
                                $.each($languages, function (i, language) {
                                    $content += "\n" +
                                        "<div id=\"tutor-language-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<div class=\"row\">\n" +
                                        "<p id=\"tutor-language-" + i + "\" class=\"col-sm-11\">" + language.language + "</p>\n" +
                                        "<a id=\"tutor-language-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteLanguage(\"tutor-language-" + i + "-div\", " + $tutor_languages[i].id + ")' >" +
                                        "<i class=\"fa fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div></div>";
                                });
                                $('#editLanguage-modal-body').empty().html($content);

                                // update the #languages-p
                                var text = "";
                                $('#languages-p').empty();
                                $.each($languages, function (i, language) {
                                    text += language.language;
                                    if (i < $languages.length - 1) {
                                        text += ', ';
                                    }
                                });
                                $('#languages-p').text("" + text);

                                // update languages in model
                                $('#add-language-form').hide();

                                // change btn
                                $okbtn = $('#add-language-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                } else {
                    $('#editLanguage-modal').modal('hide');
                }
            });
            // </add-language-ok-btn>

            // <add-language-cancel-btn>
            $("#add-language-cancel-btn, #add-language-close-btn").click(function () {
                $text = $('#add-language-ok-btn').text();
                // if text is 0
                if ($text.localeCompare("Add") != 0) {
                    $('#editLanguage-modal').modal('hide');
                }
                $('#add-language-form').hide();
                // change btn
                $okbtn = $('#add-language-ok-btn');
                $okbtn.text("Ok");
                $okbtn.removeClass('btn-primary');
                $okbtn.addClass('btn-success');
            });
            // </add-language-cancel-btn>
            // </language>

            // <tutoring style>
            $('#add-tutoring_style-form').hide();
            $('#edit-tutoring_style-a').click(function () {
                // get data
                var $tutor_tutoring_styles = $('#data-tutor-tutoring_styles').data('tutor-tutoring_styles');
                var $tutoring_styles = $('#data-tutoring_styles').data('tutoring_styles');
                var $content = "";
                $.each($tutoring_styles, function (i, tutoring_style) {
                    /*                        console.log(i + " - " + language + "\n");*/
                    $content += "\n" +
                        "<div id=\"tutor-tutoring_style-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<div class=\"row\">\n" +
                        "<p id=\"tutor-tutoring_style-" + i + "\" class='col-sm-11' >" + tutoring_style.tutoring_style + "</p>\n" +
                        "<a id=\"tutor-tutoring_style-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteTutoringStyle(\"tutor-tutoring_style-" + i + "-div\", " + $tutor_tutoring_styles[i].id + ")' >" +
                        "<i class=\"fa fa-times\"></i>" +
                        "</a>\n" +
                        "</div></div>";
                });
                $('#editTutoring_style-modal-body').empty().html($content);
                $('#editTutoring_style-modal').modal('show');
            });

            // <add-tutoring_style-a>
            $('#add-tutoring_style-a').click(function () {
                $('#add-tutoring_style-form').show();
                $('#select-tutoring_style').empty().append("<option>Select Tutoring Style:</option>");
                $.ajax({
                    url: '{{route('admin.ajax.tutor.get.tutoring.styles',['id' => $tutor->id])}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $tutoring_styles = response.tutoring_styles;
                        $.each($tutoring_styles, function (i, tutoring_style) {
                            $('#select-tutoring_style').append("" +
                                "<option value='" + tutoring_style.id + "'>" +
                                "" + tutoring_style.tutoring_style +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-tutoring_style-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </add-tutoring_style-a>

            // <add-tutoring_style-ok-btn>
            $('#add-tutoring_style-ok-btn').click(function () {
                $text = $(this).text();
                // if text is 0
                if ($text.localeCompare("Add") == 0) {
                    // add selected tutoring_style
                    if ($('#select-tutoring_style').val().localeCompare('Select Tutoring Style:') == 0) {
                        alert("Please Select any Tutoring Style if listed");
                    } else {
                        $.ajax({
                            url: '{{route('admin.ajax.tutor.profile.tutoring.style.add',['id' => $tutor->id])}}',
                            type: "POST",
                            data: $('#add-tutoring_style-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));

                                // set the data
                                $('#data-tutor-tutoring_styles').data('tutor-tutoring_styles', response.tutor_tutoring_styles);
                                $('#data-tutoring_styles').data('tutoring_styles', response.tutoring_styles);
                                // get data
                                var $tutor_tutoring_styles = $('#data-tutor-tutoring_styles').data('tutor-tutoring_styles');
                                var $tutoring_styles = $('#data-tutoring_styles').data('tutoring_styles');
                                var $content = "";
                                $.each($tutoring_styles, function (i, tutoring_style) {
                                    $content += "\n" +
                                        "<div id=\"tutor-tutoring_style-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<div class=\"row\">\n" +
                                        "<p id=\"tutor-tutoring_style-" + i + "\" class='col-sm-11' >" + tutoring_style.tutoring_style + "</p>\n" +
                                        "<a id=\"tutor-tutoring_style-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteTutoringStyle(\"tutor-tutoring_style-" + i + "-div\", " + $tutor_tutoring_styles[i].id + ")' >" +
                                        "<i class=\"fa fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div></div>";
                                });
                                $('#editTutoring_style-modal-body').empty().html($content);

                                // update the #tutoring_styles-p
                                var text = "";
                                $('#tutoring_style-p').empty();
                                $.each($tutoring_styles, function (i, tutoring_style) {
                                    text += tutoring_style.tutoring_style;
                                    if (i < $tutoring_styles.length - 1) {
                                        text += ', ';
                                    }
                                });
                                $('#tutoring_style-p').text("" + text);

                                // update tutoring_styles in model
                                $('#add-tutoring_style-form').hide();

                                // change btn
                                $okbtn = $('#add-tutoring_style-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                } else {
                    $('#editTutoring_style-modal').modal('hide');
                }
            });
            // </add-tutoring_style-ok-btn>

            // <add-tutoring_style-cancel-btn>
            $("#add-tutoring_style-cancel-btn, #add-tutoring_style-close-btn").click(function () {
                $text = $('#add-tutoring_style-ok-btn').text();
                // if text is 0
                if ($text.localeCompare("Add") != 0) {
                    $('#editTutoring_style-modal').modal('hide');
                }
                $('#add-tutoring_style-form').hide();
                // change btn
                $okbtn = $('#add-tutoring_style-ok-btn');
                $okbtn.text("Ok");
                $okbtn.removeClass('btn-primary');
                $okbtn.addClass('btn-success');
            });
            // </add-tutoring_style-cancel-btn>
            // </tutoring style>

            // <interest>
            $('#add-interest-form').hide();
            $('#edit-interest-a').click(function () {
                // get data
                var $tutor_interests = $('#data-tutor-interests').data('tutor-interests');
                var $interests = $('#data-interests').data('interests');
                var $content = "";
                $.each($interests, function (i, interest) {
                    /*                        console.log(i + " - " + language + "\n");*/
                    $content += "\n" +
                        "<div id=\"tutor-interest-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<div class=\"row\">\n" +
                        "<p id=\"tutor-interest-" + i + "\" class='col-sm-11' >" + interest.interest + "</p>\n" +
                        "<a id=\"tutor-interest-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteInterest(\"tutor-interest-" + i + "-div\", " + $tutor_interests[i].id + ")' >" +
                        "<i class=\"fa fa-times\"></i>" +
                        "</a>\n" +
                        "</div></div>";
                });
                $('#editInterest-modal-body').empty().html($content);
                $('#editInterest-modal').modal('show');
            });

            // <add-interest-a>
            $('#add-interest-a').click(function () {
                $('#add-interest-form').show();
                $('#select-interest').empty().append("<option>Select Interest:</option>");
                $.ajax({
                    url: '{{route('admin.ajax.tutor.get.interests',['id' => $tutor->id])}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $interests = response.interests;
                        $.each($interests, function (i, interest) {
                            $('#select-interest').append("" +
                                "<option value='" + interest.id + "'>" +
                                "" + interest.interest +
                                "</option>"
                            );
                        })
                        $okbtn = $('#add-interest-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </add-interest-a>

            // <add-interest-ok-btn>
            $('#add-interest-ok-btn').click(function () {
                $text = $(this).text();
                // if text is 0
                if ($text.localeCompare("Add") == 0) {
                    // add selected interest
                    if ($('#select-interest').val().localeCompare('Select Interest:') == 0) {
                        alert("Please Select any Interest if listed");
                    } else {
                        $.ajax({
                            url: '{{route('admin.ajax.tutor.profile.interest.add',['id' => $tutor->id])}}',
                            type: "POST",
                            data: $('#add-interest-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));

                                // set the data
                                $('#data-tutor-interests').data('tutor-interests', response.tutor_interests);
                                $('#data-interests').data('interests', response.interests);

                                // get data
                                var $tutor_interests = $('#data-tutor-interests').data('tutor-interests');
                                var $interests = $('#data-interests').data('interests');
                                var $content = "";
                                $.each($interests, function (i, interest) {
                                    $content += "\n" +
                                        "<div id=\"tutor-interest-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<div class=\"row\">\n" +
                                        "<p id=\"tutor-interest-" + i + "\" class='col-sm-11' >" + interest.interest + "</p>\n" +
                                        "<a id=\"tutor-interest-" + i + "-a\" class=\"btn btn-link text-danger col-sm-1\" href=\"#\" onclick='deleteInterest(\"tutor-interest-" + i + "-div\", " + $tutor_interests[i].id + ")' >" +
                                        "<i class=\"fa fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div></div>";
                                });
                                $('#editInterest-modal-body').empty().html($content);

                                // update the #interests-p
                                var text = "";
                                $('#interest-p').empty();
                                $.each($interests, function (i, interest) {
                                    text += interest.interest;
                                    if (i < $interests.length - 1) {
                                        text += ', ';
                                    }
                                });
                                $('#interest-p').text("" + text);

                                // update interests in model
                                $('#add-interest-form').hide();

                                // change btn
                                $okbtn = $('#add-interest-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                } else {
                    $('#editInterest-modal').modal('hide');
                }
            });
            // </add-interest-ok-btn>

            // <add-interest-cancel-btn>
            $("#add-interest-cancel-btn, #add-interest-close-btn").click(function () {
                $text = $('#add-interest-ok-btn').text();
                // if text is 0
                if ($text.localeCompare("Add") != 0) {
                    $('#editInterest-modal').modal('hide');
                }
                $('#add-interest-form').hide();
                // change btn
                $okbtn = $('#add-interest-ok-btn');
                $okbtn.text("Ok");
                $okbtn.removeClass('btn-primary');
                $okbtn.addClass('btn-success');
            });
            // </add-interest-cancel-btn>
            // </interest>

            // <Certificates>
            $("#edit-certificates-a").click(function () {
                // get data
                var $tutor_certificates = $('#data-tutor-certificates').data('tutor-certificates');
                var $content = "";
                $.each($tutor_certificates, function (i, tutor_certificate) {
                    $content += "\n" +
                        "<div id=\"tutor-certificate-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<div class=\"row \">\n" +
                        "<p id=\"tutor-certificate-" + i + "\" class='col-sm-10' >" + tutor_certificate.title + "</p>\n" +
                        "<div class='col-sm-2 row'>" +
                        "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link col-sm-6\" href=\"#\" onclick='editCertificate(" + tutor_certificate.id + ")'>" +
                        "<i class=\"fa fa-edit\"></i> Edit" +
                        "</a>\n" +
                        "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link text-danger col-sm-6\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-" + i + "-div\", " + tutor_certificate.id + ")'>" +
                        "<i class=\"fa fa-times\"></i>" +
                        "</a>\n" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                });
                $('#show-certificate-modal-body').empty().html($content);
                $("#showCertificate-modal").modal('show');
            });
            // <showCertificate Modal>
            $('#add-certificate-a').click(function () {
                $("#add-certificate-title").val("");
                $("#add-certificate-description").val("");
                $("#add-certificate-issuing-authority").val("");
                $("#add-certificate-start-date").val("");
                $("#add-certificate-end-date").val("");
                $('#addCertificate-modal').modal('show');
            });

            // <addCertificate Modal>
            $('#add_certificate_save_btn').click(function () {
                $.ajax({
                    url: '{{route('admin.ajax.tutor.profile.certificate.add',['id' => $tutor->id])}}',
                    type: "POST",
                    data: $('#add-certificate-form').serialize(),
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $content = '';
                        var $text = '';
                        var $tutor_certifications = response.tutor_certifications;

                        // set data
                        $("#data-tutor-certificates").data('tutor-certificates', response.tutor_certifications);

                        $.each($tutor_certifications, function (i, tutor_certificate) {
                            $text += tutor_certificate.title;
                            if (i + 1 < $tutor_certifications.length) {
                                $text += ', ';
                            }

                            $content += "\n" +
                                "<div id=\"tutor-certificate-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                "<div class=\"row \">\n" +
                                "<p id=\"tutor-certificate-" + i + "\" class='col-sm-10' >" + tutor_certificate.title + "</p>\n" +
                                "<div class='col-sm-2 row'>" +
                                "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link col-sm-6\" href=\"#\" onclick='editCertificate(" + tutor_certificate.id + ")'>" +
                                "<i class=\"fa fa-edit\"></i> Edit" +
                                "</a>\n" +
                                "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link text-danger col-sm-6\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-" + i + "-div\", " + tutor_certificate.id + ")'>" +
                                "<i class=\"fa fa-times\"></i>" +
                                "</a>\n" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                        });
                        $('#certificates-p').empty().text($text);
                        $('#show-certificate-modal-body').empty().html($content);
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
                $('#addCertificate-modal').modal('hide');
            });

            // <editCertificate Modal>
            $('#edit_certificate_update_btn').click(function () {
                $.ajax({
                    url: '{{route('admin.ajax.tutor.profile.certificate.update',['id' => $tutor->id])}}',
                    type: "put",
                    data: $('#edit-certificate-form').serialize(),
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $content = '';
                        var $text = '';
                        var $tutor_certifications = response.tutor_certifications;

                        // set data
                        $("#data-tutor-certificates").data('tutor-certificates', response.tutor_certifications);

                        $.each($tutor_certifications, function (i, tutor_certificate) {
                            $text += tutor_certificate.title;
                            if (i + 1 < $tutor_certifications.length) {
                                $text += ', ';
                            }

                            $content += "\n" +
                                "<div id=\"tutor-certificate-" + i + "-div\"  class=\"d-flex justify-content-between \">\n" +
                                "<div class=\"row \">\n" +
                                "<p id=\"tutor-certificate-" + i + "\" class='col-sm-10' >" + tutor_certificate.title + "</p>\n" +
                                "<div class='col-sm-2 row'>" +
                                "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link col-sm-6\" href=\"#\" onclick='editCertificate(" + tutor_certificate.id + ")'>" +
                                "<i class=\"fa fa-edit\"></i> Edit" +
                                "</a>\n" +
                                "<a id=\"tutor-certificate-" + i + "-a\" class=\"btn btn-link text-danger col-sm-6\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-" + i + "-div\", " + tutor_certificate.id + ")'>" +
                                "<i class=\"fa fa-times\"></i>" +
                                "</a>\n" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                        });
                        $('#certificates-p').empty().text($text);
                        $('#show-certificate-modal-body').empty().html($content);
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
                $('#editCertificate-modal').modal('hide');
            });
            // </Certificates>

            // <Education>
            $("#edit-education-a").click(function () {
                // get data
                var $tutor_education = $("#data-tutor-education").data('tutor-education');
                // set data in model
                $("#edit-education-area").val($tutor_education);
                $("#editEducation-modal").modal("show");
            });

            // editEducation-model
            $("#edit-education_update-btn").click(function () {
                $.ajax({
                    url: '{{route('admin.ajax.tutor.profile.education.update',['id' => $tutor->id])}}',
                    type: "PUT",
                    dataType: 'json',
                    data: $('#edit-education-form').serialize(),
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $tutor_education = response.education;

                        // set data
                        $("#data-tutor-education").data('tutor-education', response.education);

                        // change education-p
                        $("#education-p").empty().text($tutor_education);

                        $("#editEducation-modal").modal("hide");
                    },
                    error: function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </Education>

            // <Availability>
            $("#availability_days").hide();
            $("#select-availability-repeat").change(function () {
                if ($(this).val().localeCompare("daily") == 0) {
                    $("#availability_days").hide();
                    $("#availability_days span input:checkbox").prop('checked', true).val("true");
                }
                if ($(this).val().localeCompare("weekly") == 0) {
                    $("#availability_days").show();
                    $("#availability_days span input:checkbox").prop('checked', false).val("false");
                }
                if ($(this).val().localeCompare("none") == 0) {
                    $("#availability_days span input:checkbox").prop('checked', false).val("false");
                    $("#availability_days").hide();
                }
            });

            $("#add-availability-a").click(function () {
                $('#addSchedule-modal').modal('show');
            });

            $("#add-availability-cancel-btn, #add-availability-close-btn").click(function () {
                $('#addSchedule-modal').modal('hide');
            });

            $("#availability_save").click(function () {
                var $start_time_hour = $("#start_time_hour");
                var $start_time_meridian = $("#start_time_meridian");

                var $end_time_hour = $("#end_time_hour");
                var $end_time_meridian = $("#end_time_meridian");

                var $start_time = $start_time_hour.val() + ":00 " + $start_time_meridian.val();
                var $end_time = $end_time_hour.val() + ":00 " + $end_time_meridian.val();

                if ($("#select-availability-repeat").val().localeCompare("none") == 0) {
                    alert("Please select any repeat method");
                } else {
                    if ($start_time.localeCompare($end_time) != 0) {
                        // when start and end time is not same
                        $.ajax({
                            url: '{{route('admin.ajax.tutor.profile.availability.schedule.add',['id' => $tutor->id])}}',
                            type: "POST",
                            dataType: 'json',
                            data: $('#add-schedule-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));
                                $("#addSchedule-modal").modal("hide");
                                // refresh the page
                                location.reload(true);
                            },
                            error: function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    } else {
                        // if start and end time is same
                        alert("Start and end time can't be same.\nPlease set a valid time.");
                    }
                }
            });
            // </Availability>

        });
    </script>
@endsection
