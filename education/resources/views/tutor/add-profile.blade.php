@extends('tutor.layout.app')
@section('pageTitle', 'Tutor Dashboard')
@section('body_class_atr')class="main"@endsection
@section('tutor_layout_topnavbar')
    @include('tutor.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-md-2 ">
                    <div class="left-area pl-3">
                        <div class="left-profile text-center align-middle"><img id="profile-img" src="{{asset($tutor_profile_pic)}}" class="circle " width="150" height="150" alt="...">
                            <div class="my-3 rating-left">
                                <a id="add-profile-image" class="btn btn-link" href="#" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                    <i class="fas fa-plus"></i>
                                    <input type="file" id="select-profile-image" accept="image/png, image/jpeg, image/gif"  style="display:none">
                                    Add Image
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 border-right">
                    {{--Name & Specialization--}}
                    @php
                        $topics = [];
                        foreach($tutor_specializations as $tutor_specialization){
                            $topics[] = \App\Models\Topic::find($tutor_specialization->topic_id);
                        }
                    @endphp
                    <div id="data-topics" data-topics="{{json_encode($topics)}}" ></div>
                    <div id="data-tutor-specializations" data-tutor-specializations="{{json_encode($tutor_specializations)}}" ></div>
                    <div class="profile-property">
                        <h2 class="mr-auto font-weight-light" >
                            {{$tutor_name}}
                        </h2>
                        <div class="d-flex justify-content-between">
                            <p id="specializations-p">Specializes in:
                                @foreach($topics as $topic)
                                    {{$topic->topic}}@if(!$loop->last),@endif
                                @endforeach
                            </p>
                            <a id="edit-specialization-a" class="btn btn-link" href="#" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>

                    {{--Video--}}
                    {{--File to select video--}}
                    <input type="file" id="select-profile-video" accept="video/mp4"  style="display:none">
                    <div id="video-div" class="profile-property">
                        @if(!$tutor_profile_video)
                            <div class="text-center no-video p-5">
                                <a id="add-profile-video" class="btn btn-outline-success" href="#" role="button" >
                                    <i class="fas fa-plus"></i>
                                    Add Video
                                </a>
                            </div>
                        @else
                            <div class="profile-video text-center">
                                <video width="600" height="400" controls>
                                    <source src="{{asset($tutor_profile_video)}}" type="video/mp4" />
                                </video>
                                {{--                                <iframe width="400" height="300" src="https://www.youtube.com/embed/YlQlXVbMzs0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>--}}
                            </div>

                            <div class="text-center my-3">
                                <a id="remove-profile-video" class="btn btn-link  text-danger" href="#" role="button" >
                                    <i class="far fa-trash-alt"></i>
                                    Remove Video</a>
                                <a id="change-profile-video" class="btn btn-link" href="#" role="button" >
                                    <i class="fas fa-sync"></i>
                                    Change Video
                                </a>
                            </div>
                        @endif
                    </div>

                    {{--Languages--}}
                    @php
                        $languages = [];
                        foreach($tutor_languages as $tutor_language){
                            $languages[] = \App\Models\Language::find($tutor_language->language_id);
                        }
                    @endphp
                    <div id="data-languages" data-languages="{{json_encode($languages)}}" ></div>
                    <div id="data-tutor-languages" data-tutor-languages="{{json_encode($tutor_languages)}}" ></div>
                    <div class="profile-property row py-2">
                        <div class="col-md-3 font-weight-bold">
                            <p>Languages:</p>
                        </div>
                        <div class="d-flex justify-content-between col-md-9">
                            <p id ="languages-p">
                                @foreach($languages as $language)
                                    {{$language->language}}@if(!$loop->last),@endif
                                @endforeach
                            </p>
                            <a id="edit-language-a" class="btn btn-link" href="#"{{-- role="button" data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>

                    </div>

                    {{--Tutoring style--}}
                    @php
                        $tutoring_styles = [];
                            foreach($tutor_tutoring_styles as $tutor_tutoring_style){
                                   $tutoring_styles[] =  \App\Models\TutoringStyle::find($tutor_tutoring_style->tutoring_style_id);
                            }
                    @endphp
                    <div id="data-tutoring_styles" data-tutoring_styles="{{json_encode($tutoring_styles)}}" ></div>
                    <div id="data-tutor-tutoring_styles" data-tutor-tutoring_styles="{{json_encode($tutor_tutoring_styles)}}" ></div>
                    <div class="profile-property row py-2">
                        <div class="col-md-3 font-weight-bold">
                            <p>Tutoring Style:</p>
                        </div>
                        <div class="d-flex justify-content-between col-md-9">
                            <p id ="tutoring_style-p">
                                @foreach($tutoring_styles as $tutoring_style)
                                    {{$tutoring_style->tutoring_style}}@if(!$loop->last),@endif
                                @endforeach
                            </p>
                            <a id="edit-tutoring_style-a" class="btn btn-link" href="#" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>

                    {{--Interests--}}
                    @php
                        $interests = [];
                        foreach ($tutor_interests as $tutor_interest){
                            $interests[] = \App\Models\Interest::find($tutor_interest->interest_id);
                        }
                    @endphp
                    <div id="data-interests" data-interests="{{json_encode($interests)}}" ></div>
                    <div id="data-tutor-interests" data-tutor-interests="{{json_encode($tutor_interests)}}" ></div>
                    <div class="profile-property row py-2">
                        <div class="col-md-3 font-weight-bold">
                            <p>Interests:</p>
                        </div>
                        <div class="d-flex justify-content-between col-md-9">
                            <p id="interest-p">
                                @foreach($interests as $interest)
                                    {{$interest->interest}}@if(!$loop->last),@endif
                                @endforeach
                            </p>
                            <a id="edit-interest-a" class="btn btn-link" href="#" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>

                    {{--Certificate--}}
                    <div id="data-tutor-certificates" data-tutor-certificates="{{json_encode($tutor_certifications)}}" ></div>
                    <div class="profile-property row py-2">
                        <div class="col-md-3 font-weight-bold">
                            <p>Certificate:</p>
                        </div>
                        <div class="d-flex justify-content-between col-md-9">
                            <p id="certificates-p">
                                @foreach($tutor_certifications as $tutor_certification)
                                    {{--{{\App\Models\Users\Tutors\TutorCertification::find($tutor_certification->id)->title}}@if(!$loop->last),@endif--}}
                                    {{$tutor_certification->title}}@if(!$loop->last),@endif
                                @endforeach
                            </p>
                            <a id="edit-certificates-a" class="btn btn-link" href="#" {{--role="button" data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>

                    {{--Education--}}
                    <div id="data-tutor-education" data-tutor-education="{{$tutor_education}}"></div>
                    <div class="profile-property row py-2"  >
                        <div class="col-md-3 font-weight-bold">
                            <p>Education:</p>
                        </div>
                        <div class="d-flex justify-content-between col-md-9">
                            <div class="profile-data">
                                <p id="education-p">
                                    {{$tutor_education}}
                                </p>
                            </div>
                            <a id="edit-education-a" class="btn btn-link" href="#" role="button" {{--data-toggle="modal" data-target="#edit"--}}>
                                <i class="fas fa-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>

                    {{--Availability--}}
                    <div id="tutor_pf_availability" class="profile-property row py-2">
                        <div class="col-md-3 font-weight-bold">
                            <p>Availability:</p>
                        </div>
                        <div class="col-md-9">
                            <div id = "availability-div">
                                @foreach($tutor_availabilities as $t_availability)
                                    <div id="availability-schedule-{{$t_availability->id}}-div" class="d-flex justify-content-between">
                                        <p>{{Carbon::parse($t_availability->start_time)->format('g:i A')}} - {{Carbon::parse($t_availability->end_time)->format('g:i A')}}</p>
                                        <p class="day-rouded pull-right">
                                            @if($t_availability->SUN == 1)<span>S</span>  @endif
                                            @if($t_availability->MUN == 1)<span>M</span> @endif
                                            @if($t_availability->TUE == 1)<span>T</span> @endif
                                            @if($t_availability->WED == 1)<span>W</span> @endif
                                            @if($t_availability->THU == 1)<span>TH</span> @endif
                                            @if($t_availability->FRI == 1)<span>F</span> @endif
                                            @if($t_availability->SAT == 1)<span>SA</span> @endif
                                            {{--<span>S</span> <span>M</span> <span>T</span> <span>W</span> <span>TH</span> <span>F</span> <span>S</span>--}}
                                        </p>
                                        <a class="btn btn-link text-danger" href="#" onclick="deleteAvailabilitySchedule('availability-schedule-{{$t_availability->id}}-div',{{$t_availability->id}})" {{--role="button" data-toggle="modal" data-target="#edit"--}}><i class="fas fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center">
                                <a id = "add-availability-a"  class="btn btn-link " href="#" {{--role="button" data-toggle="modal" data-target="#add-shedule"--}}><i class="fas fa-plus"></i> Add New Schedule</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-area col-md-2 ">
                    <h3 class="h4 font-weight-light">Payments</h3>
                    <ul class="list-group mb-3 mr-3">
                        <li class="list-group-item ">
                            <h6 class="m-0">You have no payment</h6>
                        </li>
                    </ul>
                    <p>
                        <a class="btn btn-secondary  disabled" href="#" role="button"  aria-disabled="true">
                            Withdraw Payments
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @include('tutor.layout.footer') {{--including footer--}}
    <!-- Modals -->

        <!-- Edit Specialization -->
        <div class="modal fade" id="editSpecialization-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Specialization</h5>
                        <button id="add-specialization-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="editSpecialization-modal-body" class="modal-body">
                    </div>
                    <div id ="add-specialization-div" class="d-flex {{--justify-content-between--}}">
                        <a id ="add-specialization-a" class="col-sm-2 btn btn-link" href="#">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <form id="add-specialization-form" class="col-sm-10">
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
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-specialization-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-specialization-ok-btn" type="button" class="btn btn-success" >Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Language -->
        <div class="modal fade" id="editLanguage-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Languages</h5>
                        <button id="add-language-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="editLanguage-modal-body" class="modal-body">
                    </div>
                    <div id ="add-language-div" class="d-flex {{--justify-content-between--}}">
                        <a id ="add-language-a" class="btn btn-link col-sm-2" href="#">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <form id="add-language-form" class="col-sm-10">
                            <div class="form-group row">
                                {{--<label class="col-sm-4 col-form-label">Select</label>--}}
                                <div class="col-sm-12">
                                    <select name="language_id" class="form-control" id="select-language">
                                        <option>Select Language:</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-language-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-language-ok-btn" type="button" class="btn btn-success" >Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit tutoring_style -->
        <div class="modal fade" id="editTutoring_style-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tutoring Style</h5>
                        <button id="add-tutoring_style-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="editTutoring_style-modal-body" class="modal-body">
                    </div>
                    <div id ="add-tutoring_style-div" class="d-flex {{--justify-content-between--}}">
                        <a id ="add-tutoring_style-a" class="btn btn-link col-sm-2" href="#">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <form id="add-tutoring_style-form" class="col-sm-10">
                            <div class="form-group row">
                                {{--<label class="col-sm-4 col-form-label">Select</label>--}}
                                <div class="col-sm-12">
                                    <select name="tutoring_style_id" class="form-control" id="select-tutoring_style">
                                        <option>Select Tutoring style:</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-tutoring_style-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-tutoring_style-ok-btn" type="button" class="btn btn-success" >Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit interest -->
        <div class="modal fade" id="editInterest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Interests</h5>
                        <button id="add-interest-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="editInterest-modal-body" class="modal-body">
                    </div>
                    <div id ="add-interest-div" class="d-flex {{--justify-content-between--}}">
                        <a id ="add-interest-a" class="btn btn-link col-sm-2" href="#">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                        <form id="add-interest-form" class="col-sm-10">
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
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-interest-cancel-btn" type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="add-interest-ok-btn" type="button" class="btn btn-success" >Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Certificate -->
        <div class="modal fade" id="showCertificate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Certificate</h5>
                        <button id="show-certificate-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="show-certificate-modal-body" class="modal-body">
                    </div>
                    <div id ="show-certificate-div" class="d-flex {{--justify-content-between--}}">
                        <a id ="add-certificate-a" class="btn btn-link col-sm-2" href="#">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="show-certificate-cancel-btn" type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="show-certificate-ok-btn" type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCertificate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Certificate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-certificate-form" >
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" name="description" class="form-control" placeholder="Enter description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Issuing Authority</label>
                                <div class="col-sm-8">
                                    <input type="text" name="issuing_authority" class="form-control" placeholder="About authorities">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">From</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" name="start_date" class="form-control" placeholder="Add Date">
                                        <span class="input-group-append">
                                                <button class="btn btn-outline-success" type="button">
                                                    <i class="far fa-calendar-alt"></i>
                                                </button>
                                         </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">To</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" name="end_date" class="form-control" placeholder="Add Date">
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-success" type="button">
                                                <i class="far fa-calendar-alt"></i>
                                            </button>
                                     </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="add_certificate_save_btn" type="button" class="btn btn-success" {{--data-dismiss="modal"--}}>Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editCertificate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Certificate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-certificate-form" >

                            {{--id--}}
                            <input id="edit-certificate-id" type="hidden" name="tutor_certificate_id">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-title" type="text" name="title" class="form-control" placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-description" type="text" name="description" class="form-control" placeholder="Enter description">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Issuing Authority</label>
                                <div class="col-sm-8">
                                    <input id="edit-certificate-issuing-authority" type="text" name="issuing_authority" class="form-control" placeholder="About authorities">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">From</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input id="edit-certificate-start-date" type="text" name="start_date" class="form-control" placeholder="Add Date">
                                        <span class="input-group-append">
                                                <button class="btn btn-outline-success" type="button">
                                                    <i class="far fa-calendar-alt"></i>
                                                </button>
                                         </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">To</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input id="edit-certificate-end-date" type="text" name="end_date" class="form-control" placeholder="Add Date">
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-success" type="button">
                                                <i class="far fa-calendar-alt"></i>
                                            </button>
                                     </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button type="button" class="btn btn-link mr-4" data-dismiss="modal">Cancel</button>
                            <button id="edit_certificate_update_btn" type="button" class="btn btn-success" {{--data-dismiss="modal"--}}>Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Education model -->
        <div class="modal fade" id="editEducation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Education</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-education-form">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Educational Details</label>
                                <div class="col-sm-10">
                                    <textarea id="edit-education-area" name="education" class="form-control" placeholder="Educational Details" rows="4"></textarea>
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
        <div class="modal fade" id="addSchedule-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Schedule</h5>
                        <button id="add-availability-close-btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    <select class="form-control" id="select-availability-repeat" name="availability_repeat">
                                        <option value="none">None</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                    </select>
                                </div>
                                <div class="col-sm-8 p-2 day-rouded pull-right" id="availability_days">
                                    <span> <input name="sun" type="checkbox" value="false" onchange="selectDay(this)" /> <label class="checkbox">SUN </label></span>
                                    <span> <input name="mon" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">MON </label></span>
                                    <span> <input name="tue" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">TUE </label></span>
                                    <span> <input name="wed" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">WED </label></span>
                                    <span> <input name="thu" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">THU </label></span>
                                    <span> <input name="fri" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">FRI </label></span>
                                    <span> <input name="sat" type="checkbox" value="false" onchange="selectDay(this)"/> <label class="checkbox">SAT </label></span>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer ">
                        <div class="">
                            <button id="add-availability-cancel-btn"  type="button" class="btn btn-link mr-4">Cancel</button>
                            <button id="availability_save" type="button" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Uploading bar Modal -->
        <div class="modal fade" id="video-upload-modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" {{--style="display: flex; flex-direction: column; justify-content: center; overflow: auto;"--}} role="document">
                <div class="modal-content">
                    {{--                    <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Uploading Video</h5>
                                            <buttons type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </buttons>
                                        </div>--}}
                    <div id="video-upload-modal-body" class="modal-body">

                        <div id="video-upload-progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
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
    </main>
@endsection
@section('own_js')
    <script>
        // function to delete the specialization from model
        function deleteSpecialization(div_id, tutor_specialization_id) {
            $.ajax({
                url: '{{route('tutor.profile.specialization.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_specialization_id' : tutor_specialization_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();
                    // set the data
                    $('#data-tutor-specializations').data('tutor-specializations', response.tutor_specializations);
                    $('#data-topics').data('topics', response.topics);

                    // add in specialization
                    $('#select-topic').empty().append("<option>Select Topic:</option>");
                    var $getTopics = response.getTopics.topics;
                    $.each($getTopics, function(i, topic){
                        $('#select-topic').append("" +
                            "<option value='"+topic.id+"'>" +
                            ""+ topic.topic +
                            "</option>"
                        );
                    });

                    // update the #specializations-p
                    var $topics = response.topics;
                    var text = "Specializes in:";
                    $('#specializations-p').empty();
                    $.each($topics, function(i, topic){
                        text += topic.topic;
                        if(i < $topics.length-1){
                            text += ', ';
                        }
                    });
                    $('#specializations-p').text(""+text);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the language from model
        function deleteLanguage(div_id, tutor_language_id) {
            $.ajax({
                url: '{{route('tutor.profile.language.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_language_id' : tutor_language_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();
                    // set the data
                    $('#data-tutor-languages').data('tutor-languages', response.tutor_languages);
                    $('#data-languages').data('languages', response.languages);

                    // add in language
                    $('#select-language').empty().append("<option>Select language:</option>");
                    var $getLanguages = response.getLanguages.languages;
                    $.each($getLanguages, function(i, language){
                        $('#select-language').append("" +
                            "<option value='"+language.id+"'>" +
                            ""+ language.language +
                            "</option>"
                        );
                    });

                    // update the #languages-p
                    var $languages = response.languages;
                    var text = "";
                    $('#languages-p').empty();
                    $.each($languages, function(i, language){
                        text += language.language;
                        if(i < $languages.length-1){
                            text += ', ';
                        }
                    });
                    $('#languages-p').text(""+text);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the tutoring_style from model
        function deleteTutoringStyle(div_id, tutor_tutoring_style_id) {
            $.ajax({
                url: '{{route('tutor.profile.tutoring_style.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_tutoring_style_id' : tutor_tutoring_style_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();
                    // set the data
                    $('#data-tutor-tutoring_styles').data('tutor-tutoring_styles', response.tutor_tutoring_styles);
                    $('#data-tutoring_styles').data('tutoring_styles', response.tutoring_styles);

                    // add in tutoring_style
                    $('#select-tutoring_style').empty().append("<option>Select Tutoring style:</option>");
                    var $getTutoring_styles = response.getTutoringStyles.tutoring_styles;
                    $.each($getTutoring_styles, function(i, tutoring_style){
                        $('#select-tutoring_style').append("" +
                            "<option value='"+tutoring_style.id+"'>" +
                            ""+ tutoring_style.tutoring_style +
                            "</option>"
                        );
                    });

                    // update the #tutoring_styles-p
                    var $tutoring_styles = response.tutoring_styles;
                    var text = "";
                    $('#tutoring_style-p').empty();
                    $.each($tutoring_styles, function(i, tutoring_style){
                        text += tutoring_style.tutoring_style;
                        if(i < $tutoring_styles.length-1){
                            text += ', ';
                        }
                    });
                    $('#tutoring_style-p').text(""+text);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete the interest from model
        function deleteInterest(div_id, tutor_interest_id) {
            $.ajax({
                url: '{{route('tutor.profile.interest.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_interest_id' : tutor_interest_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();
                    // set the data
                    $('#data-tutor-interests').data('tutor-interests', response.tutor_interests);
                    $('#data-interests').data('interests', response.interests);

                    // add in interest
                    $('#select-interest').empty().append("<option>Select Interest:</option>");
                    var $getInterests = response.getInterests.interests;
                    $.each($getInterests, function(i, interest){
                        $('#select-interest').append("" +
                            "<option value='"+interest.id+"'>" +
                            ""+ interest.interest +
                            "</option>"
                        );
                    });

                    // update the #interests-p
                    var $interests = response.interests;
                    var text = "";
                    $('#interest-p').empty();
                    $.each($interests, function(i, interest){
                        text += interest.interest;
                        if(i < $interests.length-1){
                            text += ', ';
                        }
                    });
                    $('#interest-p').text(""+text);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function for certificates
        // to delete
        function deleteCertificate(div_id, tutor_certificate_id) {
            $.ajax({
                url: '{{route('tutor.profile.certificate.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_certificate_id' : tutor_certificate_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();

                    // set data
                    $('#data-tutor-certificates').data('tutor-certificates', response.tutor_certifications);

                    // update #certificates-p
                    var $certificates = response.tutor_certifications;
                    var $text = "";
                    $.each($certificates, function (i, certificate) {
                        $text += certificate.title;
                        if(i < $certificates.length-1){
                            $text += ', ';
                        }
                    })
                    $("#certificates-p").empty().text($text);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }
        // to edit {also hide the $("#showCertificate-modal")}
        function editCertificate(tutor_certificate_id){
            $.ajax({
                url: '{{route('tutor.profile.certificate.get')}}',
                type: "POST",
                dataType: 'json',
                data:{
                    'tutor_certificate_id' : tutor_certificate_id
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
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        // function to delete tutor availability schedule
        function deleteAvailabilitySchedule (div_id, tutor_availability_id) {
            $.ajax({
                url: '{{route('tutor.profile.availability.schedule.remove')}}',
                type: "DELETE",
                data:{
                    'tutor_availability_id' : tutor_availability_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    $('#'+div_id).remove();
                },
                error:function (error) {
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
            // <changing profile image>
            $('#add-profile-image').click(function () {
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
                            url:'{{ route('tutor.profile.pic.change') }}',
                            type:"POST",
                            data:formData,
                            contentType: false,
                            processData: false,
                            success:function (response) {
                                console.log("response: " + JSON.stringify(response));
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            // </changing profile image>

            // <adding profile video>
            // delegate - for dynamically created  #remove-profile-videos
            $('#video-div').on('click', '#add-profile-video' ,function () {
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
                        if( fileSize <= (1024 * 1024) * 126 ){
                            var formData = new FormData();
                            formData.append('profile_video', file);

                            $('#video-upload-modal').modal('show');
                            var $video_upload_progress_bar = $('#video-upload-progress-bar');
                            $video_upload_progress_bar.width('0%');
                            $video_upload_progress_bar.text('0%');

                            ///
                            $.ajax({
                                url:'{{ route('tutor.profile.video.change') }}',
                                type:"POST",
                                data:formData,
                                contentType: false,
                                processData: false,
                                xhr: function () {
                                    var xhr = $.ajaxSettings.xhr();
                                    xhr.onprogress = function e() {
                                        // For downloads
                                        if (e.lengthComputable) {
                                            console.log((e.loaded / e.total) *100);
                                        }
                                    };
                                    xhr.upload.onprogress = function (e) {
                                        // For uploads
                                        if (e.lengthComputable) {
                                            var pro = parseInt("" + (e.loaded / e.total) *100);
                                            console.log( pro );
                                            $video_upload_progress_bar.width( pro +'%');
                                            $video_upload_progress_bar.text( pro +' %');
                                        }
                                    };
                                    return xhr;
                                },
                                success:function (response) {
                                    $('#video-upload-modal').modal('hide');
                                    console.log("response: " + JSON.stringify(response));
                                    var $video_path = response.video_path;
                                    var $content = "" +
                                        "<div class=\"profile-video text-center\">\n" +
                                        "<video width=\"600\" height=\"400\" controls>\n" +
                                        "<source src=\""+$video_path+"\" type=\"video/mp4\" />\n" +
                                        "</video>\n" +
                                        "</div>\n" +
                                        "<div class=\"text-center my-3\">\n" +
                                        "<a id=\"remove-profile-video\" class=\"btn btn-link  text-danger\" href=\"#\" role=\"button\" >\n" +
                                        "<i class=\"far fa-trash-alt\"></i>\n" +
                                        "Remove Video" +
                                        "</a>\n" +
                                        "<a id=\"change-profile-video\" class=\"btn btn-link\" href=\"#\" role=\"button\" >\n" +
                                        "<i class=\"fas fa-sync\"></i>\n" +
                                        "Change Video\n" +
                                        "</a>\n" +
                                        "</div>";

                                    // set to #video-div
                                    $("#video-div").html($content);
                                },
                                error:function (error) {
                                    $('#video-upload-modal').modal('hide');
                                    alert('Error: Uploading Failed');
                                    console.log('Error: ' + JSON.stringify(error));
                                    console.log(error.responseText);
                                }
                            });
                        }else{
                            alert("File size exceeded: must be under 125 Mbs");
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            // </changing profile image>

            // <removing profile video>
            // delegate - for dynamically created  #remove-profile-videos
            $("#video-div").on('click', "#remove-profile-video",function () {
                $.ajax({
                    url:'{{ route('tutor.profile.video.remove') }}',
                    type:"DELETE",
                    success:function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $content =
                            "<div class=\"text-center no-video p-5\">\n" +
                            "<a id=\"add-profile-video\" class=\"btn btn-outline-success\" href=\"#\" role=\"button\" >\n" +
                            "<i class=\"fas fa-plus\"></i>\n" +
                            "Add Video\n" +
                            "</a>\n" +
                            "</div>";

                        // set to #video-div
                        $("#video-div").html($content);
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </removing profile video>

            // <change profile video>
            $("#video-div").on('click', '#change-profile-video', function () {
                document.getElementById("select-profile-video").click();
            });
            // </change profile video>

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
                        "<div id=\"tutor-specialization-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<p id=\"tutor-specialization-"+i+"\" >" + topic.topic + "</p>\n" +
                        "<a id=\"tutor-specialization-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteSpecialization(\"tutor-specialization-"+i+"-div\", "+$tutor_specializations[i].id+")' >" +
                        "<i class=\"fas fa-times\"></i>" +
                        "</a>\n" +
                        "</div>";
                });
                $('#editSpecialization-modal-body').empty().html($content);
                $('#editSpecialization-modal').modal('show');
            });

            // <add-specialization-a>
            $('#add-specialization-a').click(function () {
                $('#add-specialization-form').show();
                $('#select-topic').empty().append("<option>Select Topic:</option>");
                $.ajax({
                    url: '{{route('get.topics')}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $topics = response.topics;
                        $.each($topics, function(i, topic){
                            $('#select-topic').append("" +
                                "<option value='"+topic.id+"'>" +
                                ""+ topic.topic +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-specialization-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error:function (error) {
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
                if($text.localeCompare("Add") == 0){
                    // add selected specialization
                    if($('#select-topic').val().localeCompare('Select Topic:') == 0){
                        alert("Please Select any specialization if listed");
                    }else{
                        $.ajax({
                            url: '{{route('tutor.profile.specialization.add')}}',
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
                                        "<div id=\"tutor-specialization-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<p id=\"tutor-specialization-"+i+"\" >" + topic.topic + "</p>\n" +
                                        "<a id=\"tutor-specialization-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteSpecialization(\"tutor-specialization-"+i+"-div\", "+$tutor_specializations[i].id+")' >" +
                                        "<i class=\"fas fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div>";
                                });
                                $('#editSpecialization-modal-body').empty().html($content);

                                // update the #specializations-p
                                var text = "Specializes in:";
                                $('#specializations-p').empty();
                                $.each($topics, function(i, topic){
                                    text += topic.topic;
                                    if(i < $topics.length-1){
                                        text += ', ';
                                    }
                                });
                                $('#specializations-p').text(""+text);

                                // update specializations in model
                                $('#add-specialization-form').hide();

                                // change btn
                                $okbtn = $('#add-specialization-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                }else{
                    $('#editSpecialization-modal').modal('hide');
                }
            });
            // </add-specialization-ok-btn>

            // <add-specialization-cancel-btn>
            $("#add-specialization-cancel-btn, #add-specialization-close-btn").click(function () {
                $text = $('#add-specialization-ok-btn').text();
                // if text is 0
                if($text.localeCompare("Add") != 0){
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
                        "<div id=\"tutor-language-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<p id=\"tutor-language-"+i+"\" >" + language.language + "</p>\n" +
                        "<a id=\"tutor-language-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteLanguage(\"tutor-language-"+i+"-div\", "+$tutor_languages[i].id+")' >" +
                        "<i class=\"fas fa-times\"></i>" +
                        "</a>\n" +
                        "</div>";
                });
                $('#editLanguage-modal-body').empty().html($content);
                $('#editLanguage-modal').modal('show');
            });

            // <add-language-a>
            $('#add-language-a').click(function () {
                $('#add-language-form').show();
                $('#select-language').empty().append("<option>Select language:</option>");
                $.ajax({
                    url: '{{route('get.languages')}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $languages = response.languages;
                        $.each($languages, function(i, language){
                            $('#select-language').append("" +
                                "<option value='"+language.id+"'>" +
                                ""+ language.language +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-language-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error:function (error) {
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
                if($text.localeCompare("Add") == 0){
                    // add selected language
                    if($('#select-language').val().localeCompare('Select language:') == 0){
                        alert("Please Select any language if listed");
                    }else{
                        $.ajax({
                            url: '{{route('tutor.profile.language.add')}}',
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
                                        "<div id=\"tutor-language-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<p id=\"tutor-language-"+i+"\" >" + language.language + "</p>\n" +
                                        "<a id=\"tutor-language-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteLanguage(\"tutor-language-"+i+"-div\", "+$tutor_languages[i].id+")' >" +
                                        "<i class=\"fas fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div>";
                                });
                                $('#editLanguage-modal-body').empty().html($content);

                                // update the #languages-p
                                var text = "";
                                $('#languages-p').empty();
                                $.each($languages, function(i, language){
                                    text += language.language;
                                    if(i < $languages.length-1){
                                        text += ', ';
                                    }
                                });
                                $('#languages-p').text(""+text);

                                // update languages in model
                                $('#add-language-form').hide();

                                // change btn
                                $okbtn = $('#add-language-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                }else{
                    $('#editLanguage-modal').modal('hide');
                }
            });
            // </add-language-ok-btn>

            // <add-language-cancel-btn>
            $("#add-language-cancel-btn, #add-language-close-btn").click(function () {
                $text = $('#add-language-ok-btn').text();
                // if text is 0
                if($text.localeCompare("Add") != 0){
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
                        "<div id=\"tutor-tutoring_style-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<p id=\"tutor-tutoring_style-"+i+"\" >" + tutoring_style.tutoring_style + "</p>\n" +
                        "<a id=\"tutor-tutoring_style-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteTutoringStyle(\"tutor-tutoring_style-"+i+"-div\", "+$tutor_tutoring_styles[i].id+")' >" +
                        "<i class=\"fas fa-times\"></i>" +
                        "</a>\n" +
                        "</div>";
                });
                $('#editTutoring_style-modal-body').empty().html($content);
                $('#editTutoring_style-modal').modal('show');
            });

            // <add-tutoring_style-a>
            $('#add-tutoring_style-a').click(function () {
                $('#add-tutoring_style-form').show();
                $('#select-tutoring_style').empty().append("<option>Select Tutoring Style:</option>");
                $.ajax({
                    url: '{{route('get.tutoring.styles')}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $tutoring_styles = response.tutoring_styles;
                        $.each($tutoring_styles, function(i, tutoring_style){
                            $('#select-tutoring_style').append("" +
                                "<option value='"+tutoring_style.id+"'>" +
                                ""+ tutoring_style.tutoring_style +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-tutoring_style-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error:function (error) {
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
                if($text.localeCompare("Add") == 0){
                    // add selected tutoring_style
                    if($('#select-tutoring_style').val().localeCompare('Select Tutoring Style:') == 0){
                        alert("Please Select any Tutoring Style if listed");
                    }else{
                        $.ajax({
                            url: '{{route('tutor.profile.tutoring.style.add')}}',
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
                                        "<div id=\"tutor-tutoring_style-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<p id=\"tutor-tutoring_style-"+i+"\" >" + tutoring_style.tutoring_style + "</p>\n" +
                                        "<a id=\"tutor-tutoring_style-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteTutoringStyle(\"tutor-tutoring_style-"+i+"-div\", "+$tutor_tutoring_styles[i].id+")' >" +
                                        "<i class=\"fas fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div>";
                                });
                                $('#editTutoring_style-modal-body').empty().html($content);

                                // update the #tutoring_styles-p
                                var text = "";
                                $('#tutoring_style-p').empty();
                                $.each($tutoring_styles, function(i, tutoring_style){
                                    text += tutoring_style.tutoring_style;
                                    if(i < $tutoring_styles.length-1){
                                        text += ', ';
                                    }
                                });
                                $('#tutoring_style-p').text(""+text);

                                // update tutoring_styles in model
                                $('#add-tutoring_style-form').hide();

                                // change btn
                                $okbtn = $('#add-tutoring_style-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                }else{
                    $('#editTutoring_style-modal').modal('hide');
                }
            });
            // </add-tutoring_style-ok-btn>

            // <add-tutoring_style-cancel-btn>
            $("#add-tutoring_style-cancel-btn, #add-tutoring_style-close-btn").click(function () {
                $text = $('#add-tutoring_style-ok-btn').text();
                // if text is 0
                if($text.localeCompare("Add") != 0){
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
                        "<div id=\"tutor-interest-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<p id=\"tutor-interest-"+i+"\" >" + interest.interest + "</p>\n" +
                        "<a id=\"tutor-interest-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteInterest(\"tutor-interest-"+i+"-div\", "+$tutor_interests[i].id+")' >" +
                        "<i class=\"fas fa-times\"></i>" +
                        "</a>\n" +
                        "</div>";
                });
                $('#editInterest-modal-body').empty().html($content);
                $('#editInterest-modal').modal('show');
            });

            // <add-interest-a>
            $('#add-interest-a').click(function () {
                $('#add-interest-form').show();
                $('#select-interest').empty().append("<option>Select Interest:</option>");
                $.ajax({
                    url: '{{route('get.interests')}}',
                    type: "GET",
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $interests = response.interests;
                        $.each($interests, function(i, interest){
                            $('#select-interest').append("" +
                                "<option value='"+interest.id+"'>" +
                                ""+ interest.interest +
                                "</option>"
                            );
                        });
                        $okbtn = $('#add-interest-ok-btn');
                        $okbtn.text("Add");
                        $okbtn.removeClass('btn-success');
                        $okbtn.addClass('btn-primary');
                    },
                    error:function (error) {
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
                if($text.localeCompare("Add") == 0){
                    // add selected interest
                    if($('#select-interest').val().localeCompare('Select Interest:') == 0){
                        alert("Please Select any Interest if listed");
                    }else{
                        $.ajax({
                            url: '{{route('tutor.profile.interest.add')}}',
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
                                        "<div id=\"tutor-interest-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                        "<p id=\"tutor-interest-"+i+"\" >" + interest.interest + "</p>\n" +
                                        "<a id=\"tutor-interest-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteInterest(\"tutor-interest-"+i+"-div\", "+$tutor_interests[i].id+")' >" +
                                        "<i class=\"fas fa-times\"></i>" +
                                        "</a>\n" +
                                        "</div>";
                                });
                                $('#editInterest-modal-body').empty().html($content);

                                // update the #interests-p
                                var text = "";
                                $('#interest-p').empty();
                                $.each($interests, function(i, interest){
                                    text += interest.interest;
                                    if(i < $interests.length-1){
                                        text += ', ';
                                    }
                                });
                                $('#interest-p').text(""+text);

                                // update interests in model
                                $('#add-interest-form').hide();

                                // change btn
                                $okbtn = $('#add-interest-ok-btn');
                                $okbtn.text("Ok");
                                $okbtn.removeClass('btn-primary');
                                $okbtn.addClass('btn-success');

                                //
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }
                }else{
                    $('#editInterest-modal').modal('hide');
                }
            });
            // </add-interest-ok-btn>

            // <add-interest-cancel-btn>
            $("#add-interest-cancel-btn, #add-interest-close-btn").click(function () {
                $text = $('#add-interest-ok-btn').text();
                // if text is 0
                if($text.localeCompare("Add") != 0){
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
                        "<div id=\"tutor-certificate-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                        "<p id=\"tutor-certificate-"+i+"\" >" + tutor_certificate.title + "</p>\n" +
                        "<div>"+
                        "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link\" href=\"#\" onclick='editCertificate("+tutor_certificate.id+")'>" +
                        "<i class=\"far fa-edit\"></i> Edit" +
                        "</a>\n" +
                        "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-"+i+"-div\", "+tutor_certificate.id+")'>" +
                        "<i class=\"fas fa-times\"></i>" +
                        "</a>\n" +
                        "</div>" +
                        "</div>";
                });
                $('#show-certificate-modal-body').empty().html($content);
                $("#showCertificate-modal").modal('show');
            });
            // <showCertificate Modal>
            $('#add-certificate-a').click(function () {
                $('#addCertificate-modal').modal('show');
            });

            // <addCertificate Modal>
            $('#add_certificate_save_btn').click(function () {
                $.ajax({
                    url: '{{route('tutor.profile.certificate.add')}}',
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
                            if(i+1 < $tutor_certifications.length){
                                $text += ', ';
                            }

                            $content += "\n" +
                                "<div id=\"tutor-certificate-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                "<p id=\"tutor-certificate-"+i+"\" >" + tutor_certificate.title + "</p>\n" +
                                "<div>"+
                                "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link\" href=\"#\">" +
                                "<i class=\"far fa-edit\"></i> Edit" +
                                "</a>\n" +
                                "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-"+i+"-div\", "+tutor_certificate.id+")'>" +
                                "<i class=\"fas fa-times\"></i>" +
                                "</a>\n" +
                                "</div>" +
                                "</div>";
                        });
                        $('#certificates-p').empty().text($text);
                        $('#show-certificate-modal-body').empty().html($content);
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
                $('#addCertificate-modal').modal('hide');
            });

            // <editCertificate Modal>
            $('#edit_certificate_update_btn').click(function () {
                $.ajax({
                    url: '{{route('tutor.profile.certificate.update')}}',
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
                            if(i+1 < $tutor_certifications.length){
                                $text += ', ';
                            }

                            $content += "\n" +
                                "<div id=\"tutor-certificate-"+i+"-div\"  class=\"d-flex justify-content-between \">\n" +
                                "<p id=\"tutor-certificate-"+i+"\" >" + tutor_certificate.title + "</p>\n" +
                                "<div>"+
                                "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link\" href=\"#\">" +
                                "<i class=\"far fa-edit\"></i> Edit" +
                                "</a>\n" +
                                "<a id=\"tutor-certificate-"+i+"-a\" class=\"btn btn-link text-danger\" href=\"#\" onclick='deleteCertificate(\"tutor-certificate-"+i+"-div\", "+tutor_certificate.id+")'>" +
                                "<i class=\"fas fa-times\"></i>" +
                                "</a>\n" +
                                "</div>" +
                                "</div>";
                        });
                        $('#certificates-p').empty().text($text);
                        $('#show-certificate-modal-body').empty().html($content);
                    },
                    error:function (error) {
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
                    url: '{{route('tutor.profile.education.update')}}',
                    type: "PUT",
                    dataType: 'json',
                    data: $('#edit-education-form').serialize(),
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        var $tutor_education = response.education;

                        // set data
                        $("#data-tutor-education").data('tutor-education',response.education);

                        // change education-p
                        $("#education-p").empty().text($tutor_education);

                        $("#editEducation-modal").modal("hide");
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });
            // </Education>

            // <Availability>
            $("#availability_days").hide();
            $("#select-availability-repeat").change(function () {
                if($(this).val().localeCompare("daily") == 0){
                    $("#availability_days").hide();
                    $("#availability_days span input:checkbox").prop('checked', true).val("true");
                }
                if($(this).val().localeCompare("weekly") == 0){
                    $("#availability_days").show();
                    $("#availability_days span input:checkbox").prop('checked', false).val("false");
                }
                if($(this).val().localeCompare("none") == 0){
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

                var $start_time = $start_time_hour.val() + ":00 "+ $start_time_meridian.val();
                var $end_time = $end_time_hour.val() + ":00 "+ $end_time_meridian.val();

                if($("#select-availability-repeat").val().localeCompare("none") == 0){
                    alert("Please select any repeat method");
                }else{
                    if($start_time.localeCompare($end_time) != 0){
                        // when start and end time is not same
                        $.ajax({
                            url: '{{route('tutor.profile.availability.schedule.add')}}',
                            type: "POST",
                            dataType: 'json',
                            data: $('#add-schedule-form').serialize(),
                            success: function (response) {
                                console.log("response: " + JSON.stringify(response));

                                // getting data from response
                                var $t_availability_id = response.tutor_availability.id;
                                var $start_time = response.tutor_availability.start_time;
                                var $end_time = response.tutor_availability.end_time;
                                var $days  = response.tutor_availability.days;
                                var days = "";
                                if($days.SUN === 1){ days += "<span>S</span> " }
                                if($days.MON === 1){ days += "<span>M</span> " }
                                if($days.TUE === 1){ days += "<span>T</span> " }
                                if($days.WED === 1){ days += "<span>W</span> " }
                                if($days.THU === 1){ days += "<span>TH</span> " }
                                if($days.FRI === 1){ days += "<span>F</span> " }
                                if($days.SAT === 1){ days += "<span>SA</span> " }

                                var  content = "" +
                                    "<div id=\"availability-schedule-"+$t_availability_id+"-div\" class=\"d-flex justify-content-between\">\n" +
                                    "<p>"+$start_time+" - "+$end_time+"</p>\n" +
                                    "<p class=\"day-rouded pull-right\">" +
                                    days +
                                    "</p>\n" +
                                    "<a class=\"btn btn-link text-danger\" href=\"#\" onclick=\"deleteAvailabilitySchedule('availability-schedule-"+$t_availability_id+"-div',"+$t_availability_id+")\" {{--role=\"button\" data-toggle=\"modal\" data-target=\"#edit\"--}}><i class=\"fas fa-times\"></i></a>\n" +
                                    "</div>";

                                // adding to div
                                var currentContent = $("#availability-div").html();
                                $("#availability-div").html(content + "\n" + currentContent);

                                $("#addSchedule-modal").modal("hide");
                            },
                            error:function (error) {
                                console.log('Error: ' + JSON.stringify(error));
                                console.log(error.responseText);
                            }
                        });
                    }else{
                        // if start and end time is same
                        alert("Start and end time can't be same.\nPlease set a valid time.");
                    }
                }
            });
            // </Availability>
        });
    </script>
@endsection