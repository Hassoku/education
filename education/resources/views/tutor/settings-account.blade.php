@extends('tutor.layout.app')
@section('pageTitle', 'Tutor Settings')
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
                        <h3 class="h4 font-weight-light">Settings</h3>
                        <ul class="list-group mt-4 mb-3">
                            <li id="sa-account-detail-li" class="list-group-item active">
                                <div>
                                    <h6 id="sa-account-details" class="m-0">Account Details</h6>
                                </div>
                            </li>
                            <li id="sa-card-detail-li" class="list-group-item ">
                                <div>
                                    <h6 id="sa-card-detail" class="m-0">Card Details</h6>
                                </div>
                            </li>
                            <li id="sa-withdraw-funds-li" class="list-group-item ">
                                <div>
                                    <h6 id="sa-withdraw-funds" class="m-0">Withdraw funds</h6>
                                </div>
                            </li>
                            <li id="sa-preferences-li" class="list-group-item ">
                                <div>
                                    <h6 id="sa-preferences" class="m-0">Preferences</h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="setting-content" class="col-md-8 border-right">
                    <div class="d-flex justify-content-between">
                        <h2 class="mr-auto font-weight-light" data-toggle="modal" data-target="#incoming-call">Account Details</h2>
                    </div>
                    <form class="white-container center-form p-4 mt-1" method="POST" action="{{route('tutor.setting.update.account.detail')}}">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">First Name</label>
                            <div class="col-md-10">
                                <input type="text"  class="form-control" id="first-name-field" name = "first_name" value="{{$name['first_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">Middle Name</label>
                            <div class="col-md-10">
                                <input type="text"  class="form-control" id="middle-name-field" name = "middle_name" value="{{$name['middle_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">Last Name</label>
                            <div class="col-md-10">
                                <input type="text"  class="form-control" id="last-name-field" name = "last_name" value="{{$name['last_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-md-2 col-form-label">Mobile</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="mobile-field" name = "mobile" value="{{$mobile}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input type="text"  class="form-control" id="email-field" name = "email" value="{{$email}}" disabled="true">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" id="password-field" name = "password" placeholder="Password" disabled="true">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="update-btn" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10 ">
                                <button class="btn  btn-primary" id="update-btn" type="submit">Update</button>
                            </div>
                        </div>

                    </form>
                </div>

                {{--payment_aside--}}
                @include('tutor.layout.payment_aside',['payments' => $payments])
            </div>
        </div>
        @include('tutor.layout.footer') {{--including footer--}}
    </main>
@endsection
@section('own_js')

    {{--Will be available when user's status will be active--}}
    @if(Auth::user()->status == 'active')
        {{--For #communication--}}
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
        <script src="{{ asset('assets/tutor/js/vendor/jquery-throttle.min.js') }}"></script>
        <script src="{{ asset('assets/tutor/js/vendor/jquery.loadTemplate-1.4.4.min.js') }}"></script>
        {{--    <script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
            <script src="https://media.twiliocdn.com/sdk/js/chat/v2.2/twilio-chat.min.js"></script>--}}
        <script src="//media.twiliocdn.com/sdk/js/common/releases/0.1.5/twilio-common.js"></script>
        <script src="//media.twiliocdn.com/sdk/js/chat/releases/0.11.1/twilio-chat.js"></script>
        <script src="{{ asset('assets/tutor/js/dateformatter.js') }}"></script>
    @endif

    <script>
        // switch the tab on the basis of URL
        var url = window.location.href;
        // for cardDetail
        if(url.localeCompare("{{route('tutor.account.settings',['tab' => 'cardDetails'])}}")==0){
            $.get(
                "{{route('tutor.settings.tab',['tab' => 'card-dtls'])}}",
                function(data){
                    $('#setting-content').html(data);
                    $("#sa-account-detail-li").removeClass("active");
                    $("#sa-card-detail-li").addClass("active");
                    $("#sa-withdraw-funds-li").removeClass("active");
                    $("#sa-preferences-li").removeClass("active");
                });
        }

        // for
        if(url.localeCompare("{{route('tutor.account.settings',['tab' => 'preferences'])}}")==0){
            $.get(
                "{{route('tutor.settings.tab',['tab' => 'pref'])}}",
                function(data){
                    $('#setting-content').html(data);
                    $("#sa-account-detail-li").removeClass("active");
                    $("#sa-card-detail-li").removeClass("active");
                    $("#sa-withdraw-funds-li").removeClass("active");
                    $("#sa-preferences-li").addClass("active");
                }
            );
        }

        ////////////////////////
        // account detail
        $("#sa-account-details").click(function () {
            $.get(
                "{{route('tutor.settings.tab',['tab' => 'act-dtls'])}}",
                function(data){
                    $('#setting-content').html(data);
                    $("#sa-account-detail-li").addClass("active");
                    $("#sa-card-detail-li").removeClass("active");
                    $("#sa-withdraw-funds-li").removeClass("active");
                    $("#sa-preferences-li").removeClass("active");
                }
            );
        });

        ////////////////////////////////////////////////////////////////////////////////////
        // card details
        $("#sa-card-detail").click(function () {
            $.get(
                "{{route('tutor.settings.tab',['tab' => 'card-dtls'])}}",
                function(data){
                    $('#setting-content').html(data);
                    $("#sa-account-detail-li").removeClass("active");
                    $("#sa-card-detail-li").addClass("active");
                    $("#sa-withdraw-funds-li").removeClass("active");
                    $("#sa-preferences-li").removeClass("active");
                }
            );

        });

        ////////////////////////////////////////////////////////////////////////////////////
        // with draw
        $("#sa-withdraw-funds").click(function () {
            $("#sa-account-detail-li").removeClass("active");
            $("#sa-card-detail-li").removeClass("active");
            $("#sa-withdraw-funds-li").addClass("active");
            $("#sa-preferences-li").removeClass("active");
        });
        // Preferences
        $("#sa-preferences").click(function () {
            $.get(
                "{{route('tutor.settings.tab',['tab' => 'pref'])}}",
                function(data){
                    $('#setting-content').html(data);
                    $("#sa-account-detail-li").removeClass("active");
                    $("#sa-card-detail-li").removeClass("active");
                    $("#sa-withdraw-funds-li").removeClass("active");
                    $("#sa-preferences-li").addClass("active");
                }
            );
        });
        
    </script>
@endsection