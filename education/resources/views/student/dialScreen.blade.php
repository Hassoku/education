@extends('student.layout.app')
@section('pageTitle', 'Dial Screen')
@section('body_class_atr')class="main"@endsection
@section('ownCSS')
    <style>
        body {
            height: 100%;
            background: #349dff no-repeat; /* For browsers that do not support gradients */
            /*background: linear-gradient(to bottom left, #41d5ff, #349dff);*/ /* Standard syntax (must be last) */
        }
        .goool{
            border-radius: 100px;
        }
        .cal-btn{
            font-size: 30px;
            width: 75px;
            height: 75px;
        }
    </style>
@endsection
@section('content')
    <main role= "main">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div style="padding: 100px; text-align: center">
                    <img class="goool" src="{{asset($tutor->profile->picture)}}" alt="Tutor Picture" width="150" height="150">
                    <h3 style="margin-top: 50px" >{{$tutor->name}} {{$tutor->middle_name}} {{$tutor->last_name}}</h3>
                </div>
                <div style="padding: 10px; text-align: center ">
                    <button id="call-disconnect-btn" class="btn btn-danger goool cal-btn">
                        <i class="fas fa-phone"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="data-learningSessionRequestID" data-learningSessionRequestID=0 ></div>
    </main>
@endsection
@section('own_js')
    {{--Pusher--}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        var channel = pusher.subscribe('student.learning_session.{{Auth()->user()->id}}');
        // rejected
        channel.bind('learning_session.event.reject', function (data) {
            var msg = data.msg;
            console.log(msg);
            alert(msg);

            // back this page
            history.back();
        });
        // accepted
        channel.bind('learning_session.event.accept', function (data) {

            console.log(data);

            var $twilio_room_sid = data.twilio_room_sid;
            var $twilio_room_unique_name = data.twilio_room_unique_name;
            var $access_token = data.access_token;
            // chat
            var $twilio_chat_channel_sid = data.twilio_chat_channel_sid;
            var $twilio_chat_channel_unique_name = data.twilio_chat_channel_unique_name;
            var $twilio_chat_channel_friendly_name = data.twilio_chat_channel_friendly_name;


            var newURL = "{{route('student.join.learning.session')}}";
            newURL += '?twilio_room_sid=' + $twilio_room_sid;
            newURL += '&twilio_room_unique_name='+$twilio_room_unique_name;
            newURL += '&access_token='+$access_token;
            newURL += '&twilio_chat_channel_sid='+$twilio_chat_channel_sid;
            newURL += '&twilio_chat_channel_unique_name='+$twilio_chat_channel_unique_name;
            newURL += '&$twilio_chat_channel_friendly_name='+$twilio_chat_channel_friendly_name;

            console.log(newURL);

            // redirect to learning session
            location.href = newURL;
        });

        /*notification*/
        function sendNotification(title, message, url) {
            //First, check notification is supported or not in your browser!
            if (!Notification) {
                console.log('Push notifications are not supported in your browser..');
                return;
            }

            //Ask for permission from user
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            } else {
                var notification = new Notification(title, {
                    icon: "{{asset('assets/tutor/images/symbol.png')}}",
                    body: message
                });

                // Remove the notification when clicked and open the URL.
                notification.onclick = function() {
                    //window.open(url);
                    window.focus();
                };

                // Callback function when the notification is closed.
                notification.onclose = function() {
                    console.log('Notification closed');
                };
            }
        }
    </script>

    <script>
        var $learningSessionRequestId = 0;
        $(document).ready(function() {
            $.ajaxSetup({
                headers:
                    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                url: '{{route('student.learningSession.request.generate')}}',
                type: "POST",
                data:{
                    'tutor_id' : '{{$tutor->id}}',
                    'device' : 'browser'
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    var status = response.status;
                    var msg = response.msg;

                    if(status.localeCompare("success") == 0){
                        console.log(status);
                        console.log(msg);
                        var chat = response.chat;
                            var identity = chat.identity;
                            var token = chat.token;
                        var learningSessionRequestId = response.learning_session_request_id;
                        $('#data-learningSessionRequestID').data('learningSessionRequestID', learningSessionRequestId);

                        $learningSessionRequestId = learningSessionRequestId;
                        console.log(chat);
                        console.log(identity);
                        console.log(token);
                        console.log(learningSessionRequestId);

                        // start calling

                    }else{
                        if(status.localeCompare("error") == 0){
                            console.log(msg);
                            alert(msg);

                            // back this page
                            history.back();
                        }
                    }
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });

            $('#call-disconnect-btn').click(function () {
                var learningSessionRequestId = parseInt($('#data-learningSessionRequestID').data('learningSessionRequestID'));
                if(learningSessionRequestId > 0){
                    console.log('is not 0');

                    var newURL = '{{route('student.learningSession.request.withdraw',['learning_session_request_id' => 'learning_session_request_id'])}}';
                    newURL = newURL.replace('learning_session_request_id', learningSessionRequestId);

                    $.ajax({
                        url: newURL,
                        type: "GET",
                        success: function (response) {
                            var status = response.status;
                            var msg = response.msg;

                            if(status.localeCompare("success") == 0){
                                console.log(status);
                                console.log(msg);
                                alert("Call failed.");

                                // back this page
                                history.back();
                            }
                        },
                        error: function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });

                }else{
                    console.log('is 0');
                    console.log(learningSessionRequestId);
                }
            });
        });

        // On back button of browser
/*        window.onhashchange = function(e) {
            /!*var oldURL = e.oldURL;
            var newURL = e.newURL;*!/
             console.log("Old URL: "  + oldURL + " New URL: "  + newURL);
            e.preventDefault();
            return false;
        }*/
    </script>
@endsection
