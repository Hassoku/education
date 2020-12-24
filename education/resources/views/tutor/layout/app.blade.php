<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{asset('assets/tutor/images/educationpluslogo.jpeg')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') - {{ config('app.name', 'Duroos')}}</title>


    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/tutor/css/bootstrap-reboot.min.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/tutor/css/fa-regular.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/tutor/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/tutor/css/bootstrap.min.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/tutor/css/custom.css')}}" rel="stylesheet"  >

    <!-- Mobile Number Field CSS -->
    <link rel="stylesheet" href="{{asset('assets/tutor/mobile_number_field/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/tutor/mobile_number_field/css/demo.css')}}">

</head>
<body @yield('body_class_atr')>
            <!-- Navigation Bar -->
        @yield('tutor_layout_topnavbar')

        <!-- Content -->
        @yield('content')

{{--        <!-- Footer -->
        @yield()--}}

            @if(!Auth::guest())
                <!-- Incoming Call Modal -->
                <div class="modal fade" id="incoming-call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="call-model-title">Julia is calling for a session</h5>
                                <button id="reject-request-x" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" >
                                <p id="modalBody">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p>
                            </div>
                            <div class="modal-footer ">
                                <div class="m-auto">
                                    <button id="accept-request" type="button" class="btn btn-success mr-4" data-dismiss="modal">Accept</button>
                                        <!-- POST form for tutor.learning.session.request.response -->
                                        <form id="tutor-learning-session-request-response-form" action="{{ route('tutor.learning.session.request.response') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input id="#learning_session_request_id" type="hidden" name="learning_session_request_id" value=" ">
                                            <input id="#learning_session_request_status" type="hidden" name="learning_session_request_status" value=" ">
                                            {{--<input type="hidden" name="device" value="browser">
                                            <input type="hidden" name="identity" value="{{ Auth::user()->name}}">--}}
                                        </form>
                                    <button id="reject-request" type="button" class="btn btn-danger" data-dismiss="modal">Reject</button></div>
                            </div>
                            <div id="incoming-call-tune-div"></div>
                        </div>
                    </div>
                </div>
                <!-- Call withdrew  -->
                <div class="modal fade" id="call-withdrew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Call Dismissed</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" >
                                <p id="modalBody">The Student has dismissed the session request</p>
                            </div>
                            <div class="modal-footer ">
                                <div class="m-auto">
                                    <button id="call-withdrew-ok" class="btn btn-primary mr-4" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" onerror="alert('- Internet is not available. \n- Some features might not work.');"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="{{asset('assets/tutor/js/bootstrap.min.js')}}" ></script>
    <script src="{{asset('assets/tutor/js/custom.js')}}" ></script>

         {{--Mobile Number Field JS--}}
         <script src="{{asset('assets/tutor/mobile_number_field/js//intlTelInput.js')}}"></script>
         {{--@if(!Auth::guest())--}}
         @if(Auth::guard('tutor')->check())
             <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
             <script>
                 var pusher = new Pusher('6a46b90592aa1656faab', {
                     cluster: 'ap2',
                     encrypted: true
                 });

                 var channel = pusher.subscribe('tutor.learning_session.request.{{Auth()->user()->id}}');
                 channel.bind('learning_session.request.event', function(data) {
                    /* alert(data.student_name + " is calling.");*/
                     sendNotification('Incomming Call', data.student_name + ' is calling for a session.', 'url');
                     //$(document).ready(function () {
//                         $('#call-model-title').text(data.student_name + " is calling." + data.learning_session_request_id);
                         $('#call-model-title').text(data.student_name + " is calling.");
                         $('#modalBody').text(data.student_name);

                         const audio = document.createElement('audio');
                             audio.setAttribute('id','incoming-call-tune');
                             audio.setAttribute('autoplay','');
                             audio.setAttribute('loop','');
                             audio.volume = 0.1;
                             const source = document.createElement('source');
                                        source.setAttribute('src',"{{asset('assets/tutor/mp3/call-tune.mp3')}}");
                                        {{--source.setAttribute('src',"{{asset('assets/tutor/mp3/frog.mp3')}}");--}}
                                           {{--source.setAttribute('src',"{{asset('assets/tutor/mp3/calling_tone.mp3')}}");--}}
                                        source.setAttribute('type',"audio/mpeg");
                              audio.appendChild(source);
                         document.getElementById('incoming-call-tune-div').appendChild(audio);
                         $.ajaxSetup({
                             headers:
                                 { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                         });
                         $('#accept-request').click(function () {
                             $('input[name=learning_session_request_id]').val(data.learning_session_request_id);
                             $('input[name=learning_session_request_status]').val('true');
                                $('#tutor-learning-session-request-response-form').submit();

                             // stop the call tune
                             $('#incoming-call-tune').remove();
                         });
                         // reject and x of model
                         $('#reject-request, #reject-request-x').click(function () {
                             var learning_session_request_id = data.learning_session_request_id;
                             $.post(
                                 "{{route('tutor.learning.session.request.response')}}",
                                 {
                                     "learning_session_request_id" : learning_session_request_id,
                                     "learning_session_request_status" : false
                                 },
                                 function (data) {
                                     console.log(data.msg);
                                 }, 'json').fail(function (xhr, textStatus, errorThrown) {
                                 console.log('post error.', xhr);
                             });
                             // stop the call tune
                             $('#incoming-call-tune').remove();
                         });
                         $('#incoming-call').modal('show');
                     //});
                 });
                 // withdraw the call
                 channel.bind('learning_session.request.event.withdraw', function (data) {
                     // stop the call tune
                     $('#incoming-call-tune').remove();
                     $('#incoming-call').modal('hide');
                     $('#call-withdrew').modal('show');
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

             <!-- Twilio Room connect -->
             @yield('twilio_room_js')

             <!-- dashboard -->
             <script>
                // will work over reservation and payments
                 function reservationPagination(URL) {
                     var url = window.location.href = URL;
                     var $page = url.split("=")[1];

                     if(url.localeCompare('{{route('tutor.dashboard')}}#reservations?page='+$page)==0){
                         var res_url = "{{route('tutor.dashboard.tab',['tab' => 'res'])}}?page="+$page;
                         console.log(res_url);
                         $.get(
                             res_url,
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_res_li').addClass('active');
                                 $('#nav_tab_comm_li').removeClass('active');
                                 $('#nav_tab_pay_li').removeClass('active');
                             }
                         );
                     }

                     if(url.localeCompare('{{route('tutor.dashboard')}}#payments?page='+$page)==0){
                         var res_url = "{{route('tutor.dashboard.tab',['tab' => 'pay'])}}?page="+$page;
                         console.log(res_url);
                         $.get(
                             res_url,
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_pay_li').addClass('active');
                                 $('#nav_tab_comm_li').removeClass('active');
                                 $('#nav_tab_res_li').removeClass('active');
                             }
                         );
                     }

                 }

                 $(document).ready(function(){
                     $.ajaxSetup({
                         headers:
                             { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                     });
                     // setting tab
                     var url = window.location.href;
                     if(url.split("#")[1]){
                         switch (url.split("#")[1].split("?")[0].split("&")[0]){
                             //switch (url.split("#")[1]){
                             case"reservations":{
                                 var $page = url.split("=")[1];
                                 var res_url = "{{route('tutor.dashboard.tab',['tab' => 'res'])}}?page="+$page;
                                 console.log(res_url);
                                 $.get(
                                     res_url,
                                     function(data){
                                         $('#dash-content').html(data);
                                         $('#nav_tab_res_li').addClass('active');
                                         $('#nav_tab_comm_li').removeClass('active');
                                         $('#nav_tab_pay_li').removeClass('active');
                                     }
                                 );
                             } break;
                             case"communications":{
                                 $.get(
                                     "{{route('tutor.dashboard.tab',['tab' => 'comm'])}}",
                                     function(data){
                                         $('#dash-content').html(data);
                                         $('#nav_tab_res_li').removeClass('active');
                                         $('#nav_tab_comm_li').addClass('active');
                                         $('#nav_tab_pay_li').removeClass('active');
                                         $('.wide .chats').css('height', $(window).height() - 357);
                                     }
                                 );
                             } break;
                             case"payments":{
                                 $.get(
                                     "{{route('tutor.dashboard.tab',['tab' => 'pay'])}}",
                                     function(data){
                                         $('#dash-content').html(data);
                                         $('#nav_tab_res_li').removeClass('active');
                                         $('#nav_tab_comm_li').removeClass('active');
                                         $('#nav_tab_pay_li').addClass('active');
                                     }
                                 );
                             } break;
                             case"notifications":{
                                 $.get(
                                     "{{route('tutor.dashboard.tab',['tab' => 'ntf'])}}",
                                     function(data){
                                         $('#dash-content').html(data);
                                         $('#nav_tab_res_li').removeClass('active');
                                         $('#nav_tab_comm_li').removeClass('active');
                                         $('#nav_tab_pay_li').removeClass('active');
                                     }
                                 );
                             } break;
                             /*case"settings-account":{
                                 $.get(
                                     "{{--{{route('tutor.dashboard.tab',['tab' => 'stng-act'])}}--}}",
                                     function(data){
                                         $('#dash-content').html(data);
                                         $('#nav_tab_res_li').removeClass('active');
                                         $('#nav_tab_comm_li').removeClass('active');
                                         $('#nav_tab_pay_li').removeClass('active');
                                     }
                                 );
                             } break;*/
                             default:{
                                 if(url.localeCompare("{{route('tutor.dashboard')}}")==0)
                                     $.get(
                                         "{{route('tutor.dashboard.tab',['tab' => 'res'])}}",
                                         function(data){
                                             $('#dash-content').html(data);
                                             $('#nav_tab_res_li').addClass('active');
                                             $('#nav_tab_comm_li').removeClass('active');
                                             $('#nav_tab_pay_li').removeClass('active');
                                         }
                                     );
                             }
                         }
                     }else{
                         if(url.localeCompare("{{route('tutor.dashboard')}}")==0)
                             $.get(
                                 "{{route('tutor.dashboard.tab',['tab' => 'res'])}}",
                                 function(data){
                                     $('#dash-content').html(data);
                                     $('#nav_tab_res_li').addClass('active');
                                     $('#nav_tab_comm_li').removeClass('active');
                                     $('#nav_tab_pay_li').removeClass('active');
                                 }
                             );
                     }

                     // availability
                     $('#tu_avl_ch_box').change(function () {
                         let status = false;
                         if (document.getElementById('tu_avl_ch_box').checked) {
                             // online
                             status = true;
                         } else {
                             // offline
                             status = false;
                         }
                         $.post(
                             "{{route('tutor.availability.post')}}",
                             /*$(this).closest('form').serialize(), // form data*/
                             {
                                 'status' : status
                             }
                             ,
                             function (data) {
                                 console.log(data.online_status);
                             }, 'json').fail(function (xhr, textStatus, errorThrown) {
                             console.log('post error.', xhr);
                         });
                     });
                     // tabs
                    $('#nav_tab_res').click(function () {
                        $.get(
                            "{{route('tutor.dashboard.tab',['tab' => 'res'])}}",
                            function(data){
                                $('#dash-content').html(data);
                                $('#nav_tab_res_li').addClass('active');
                                $('#nav_tab_comm_li').removeClass('active');
                                $('#nav_tab_pay_li').removeClass('active');
                            }
                        );
                    });
                     $('#nav_tab_comm').click(function () {
                         $.get(
                             "{{route('tutor.dashboard.tab',['tab' => 'comm'])}}",
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_res_li').removeClass('active');
                                 $('#nav_tab_comm_li').addClass('active');
                                 $('#nav_tab_pay_li').removeClass('active');
                                 $('.wide .chats').css('height', $(window).height() - 357);
                             }
                         );
                     });
                     $('#nav_tab_pay').click(function () {
                         $.get(
                             "{{route('tutor.dashboard.tab',['tab' => 'pay'])}}",
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_res_li').removeClass('active');
                                 $('#nav_tab_comm_li').removeClass('active');
                                 $('#nav_tab_pay_li').addClass('active');
                             }
                         );
                     });
                     // notification view all <a></a>
                     $('#ntf_view_all').click(function () {
                         $.get(
                             "{{route('tutor.dashboard.tab',['tab' => 'ntf'])}}",
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_res_li').removeClass('active');
                                 $('#nav_tab_comm_li').removeClass('active');
                                 $('#nav_tab_pay_li').removeClass('active');
                             }
                         );
                     });
                     // setting <a></a>
/*                     $('#tu_stng_act').click(function () {
                         $.get(
                             "{{--{{route('tutor.dashboard.tab',['tab' => 'stng-act'])}}--}}",
                             function(data){
                                 $('#dash-content').html(data);
                                 $('#nav_tab_res_li').removeClass('active');
                                 $('#nav_tab_comm_li').removeClass('active');
                                 $('#nav_tab_pay_li').removeClass('active');
                             }
                         );
                     });*/
                  });
             </script>
         @endif
         @yield('own_js')
</body>
</html>
