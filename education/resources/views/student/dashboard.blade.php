@extends('student.layout.app')
@section('pageTitle', 'Student Dashboard')

@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection


@section('content')
    {{-- check --}}
    @if(Auth::user()->city == '')
    <div class="container">
        <div class="row" style="background:#1a237e; color: white; text-align: center">
            <div class="col-md-12 p-3">
            Dear Student <strong>{{Auth::user()->name }}</strong> One step more to proceed
                Please fill out the remaining profile information.
            </div>
        </div>
        <div class="row mt-5">
        <div class="col-md-12 border-right border-left">
            {{-- info --}}
            <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="align-content: center">
                        <h4 >Your Profile</h4>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('student.profile.update')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                <label for="name" class="col-4 col-form-label"><strong>First Name</strong> </label> 
                                <div class="col-8">
                                <input id="name" name="name" placeholder="First Name" class="form-control here" type="text" value="{{ Auth::user()->name}}" readonly>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="lastname" class="col-4 col-form-label"><strong>Last Name</strong> </label> 
                                <div class="col-8">
                                    <input id="lastname" name="lastname" placeholder="Last Name" class="form-control here" type="text" value="{{ Auth::user()->last_name}}" readonly>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"> <strong>City*</strong> </label> 
                                <div class="col-8">
                                    <input id="text" name="city" placeholder="City" class="form-control here" required="required" type="text">
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"> <strong>Country*</strong> </label> 
                                <div class="col-8">
                                    <input id="text" name="country" placeholder="Country" class="form-control here" required="required" type="text">
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"> <strong>Grade*</strong> </label> 
                                <div class="col-8">
                                    <input id="text" name="grade" placeholder="Grade" class="form-control here" required="required" type="text">
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"><strong>Subject*</strong></label> 
                                <div class="col-8">
                                    <input id="text" name="subject" placeholder="Subject" class="form-control here" required="required" type="text">
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"><strong>Hobbies</strong> </label> 
                                <div class="col-8">
                                    <textarea id="text" name="hobbies" placeholder="What are your Hobbies?" class="form-control here" type="text"></textarea>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="text" class="col-4 col-form-label"><strong>School Name</strong> </label> 
                                <div class="col-8">
                                    <input id="text" name="school" placeholder="Enter Your School" class="form-control here" type="text">
                                </div>
                                </div>
                                <div class="form-group row">
                                <div class="offset-4 col-8">
                                    <button name="submit" type="submit" class="btn btn-primary">Update My Profile</button>
                                </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        {{--  end info--}}
        </div>
        </div>
    </div>
    @else
    <div id="main">
        
        <div class="row">
            <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
            <div class="col s12">
                <div class="container">
                    <div class="section">
<div class="row vertical-modern-dashboard">
    @foreach($tutorsCollections as $tutor)
        <div class="col s12 m6 xl4 ">
            <div id="profile-card" class="card waves-effect waves-light accent-2 z-depth-4" style="width: 100%;border-radius: 15px;">
                <div class="card-image waves-effect waves-block waves-light" style="border-radius: 15px;">
                    <img class="activator" src="{{asset('assets/student/app-assets/images/gallery/28.jpg')}}" alt="user bg">
                </div>
                <div class="card-content">
                    
                    <img src="{{asset('assets/student/app-assets/images/avatar/avatar-7.png')}}" alt="" class="circle responsive-img activator card-profile-image cyan lighten-1 padding-2">
                    <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                        <i class="material-icons">edit</i>
                    </a>
                    
                    <h5 class="card-title activator grey-text text-darken-4">{{$tutor->name}} {{$tutor->last_name}}</h5>
                    <p>@foreach($tutor->profile->tutor_specializations as $tutor_specialization)
                        @if($loop->last) {{$tutor_specialization->topic->topic}} @else {{$tutor_specialization->topic->topic}}, @endif
                    @endforeach</p>
                    <div class="w3-container">
                        <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-3  gradient-45deg-indigo-purple" href="{{route('student.tutorProfile.show',['tutor_id' => $tutor->id])}}">
                            <i class="material-icons">person</i>
                        </a>
                        <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-3 gradient-45deg-indigo-purple">
                            <i class="material-icons">library_add</i>
                        </a>
                        <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-3 gradient-45deg-indigo-purple" href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}">
                            <i class="material-icons">access_time</i>
                        </a>
                    </div>

                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Roger Waters <i class="material-icons right">close</i>
                    </span>
                    <p>Here is some more information about this card.</p>
                    <p><i class="material-icons">perm_identity</i> Project Manager</p>
                    <p><i class="material-icons">perm_phone_msg</i> +1 (612) 222 8989</p>
                    <p><i class="material-icons">email</i> yourmail@domain.com</p>
                    <p><i class="material-icons">cake</i> 18th June 1990</p>
                    <p></p>
                    <p><i class="material-icons">airplanemode_active</i> BAR - AUS</p>
                    <p></p>
                </div>
            </div>
        </div>
    @endforeach
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-tabs">
                            <ul class="tabs tabs-fixed-width">
                              <li class="tab"><a href="#test4" class="active">Reservations</a></li>
                              <li class="tab"><a class="" href="#test5">Calendar</a></li>
                            <li class="indicator" style="left: 0px; right: 348px;"></li></ul>
                          </div>
                    </div>
                    <div class="card-content">
                        <div id="test4" class="center active" style="display: block;"><h4 class="card-title">Reservations &nbsp; <strong>  <script> document.write(new Date().toDateString()); </script></strong></h4>
                            <div class="row">
                                <div class="col s12">
                                    <div id="scroll-dynamic_wrapper" class="dataTables_wrapper"><div id="scroll-dynamic_filter" class="dataTables_filter"></div><div class="dataTables_scroll"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px none; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 974px; padding-right: 17px;">
                                        <table class="display dataTable" role="grid" style="margin-left: 0px; width: 974px;">
                                            <thead>
                                                <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 154.383px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Serial no.</th><th class="sorting" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 237.35px;" aria-label="Position: activate to sort column ascending">Tutor Reservations</th><th class="sorting" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 121.5px;" aria-label="Office: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 89.6167px;" aria-label="Age: activate to sort column ascending">Start Time</th><th class="sorting" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 102.567px;" aria-label="Start date: activate to sort column ascending"> End Time</th><th class="sorting" tabindex="0" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 100.583px;" aria-label="Salary: activate to sort column ascending">Duration</th></tr>
                                            </thead>
                                        </table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 50vh; width: 100%;"><table id="scroll-dynamic" class="display dataTable dtr-inline" role="grid" aria-describedby="scroll-dynamic_info" style="width: 100%;"><thead>
                                            <tr role="row" style="height: 0px;"><th class="sorting_asc" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 154.383px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-sort="ascending" aria-label="Name: activate to sort column descending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Tutor Reservations</div></th><th class="sorting" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 237.35px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Position: activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Position</div></th><th class="sorting" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 121.5px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Office: activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Office</div></th><th class="sorting" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 89.6167px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Age: activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Age</div></th><th class="sorting" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 102.567px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Start date: activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Start date</div></th><th class="sorting" aria-controls="scroll-dynamic" rowspan="1" colspan="1" style="width: 100.583px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Salary: activate to sort column ascending"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Salary</div></th></tr>
                                        </thead><tfoot>
                                            <tr style="height: 0px;"><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 154.383px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Name</div></th><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 237.35px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Position</div></th><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 121.5px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Office</div></th><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 89.6167px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Age</div></th><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 102.567px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Start date</div></th><th rowspan="1" colspan="1" style="padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px; width: 100.583px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Salary</div></th></tr>
                                        </tfoot>
                                        
                                        <tbody>
                                            @foreach($learningSessionReservationCollection as $learningSessionReservation)
                                        @if($learningSessionReservation->tutor->status == 'active')
                                            <tr role="row" class="odd">
                                                <td tabindex="0" class="sorting_1">{{$loop->iteration }}</td>
                                                <td>{{$learningSessionReservation->topic->topic}} <br> {{$learningSessionReservation->tutor->name}} {{$learningSessionReservation->tutor->last_name}}</td>
                                                <td>{{$learningSessionReservation->date}}</td>
                                                <td>{{$learningSessionReservation->start_time}}</td>
                                                <td>{{$learningSessionReservation->end_time}}</td>
                                                <td>{{$learningSessionReservation->duration}}</td>
                                            </tr>
                                            
                                            @endif
                                            @endforeach
                                        </tbody>
                                        
                                    </table></div><div class="dataTables_scrollFoot" style="overflow: hidden; border: 0px none; width: 100%;"><div class="dataTables_scrollFootInner" style="width: 974px; padding-right: 17px;"><table class="display dataTable" role="grid" style="margin-left: 0px; width: 974px;"><tfoot>
                                            <tr><th rowspan="1" colspan="1" style="width: 154.383px;">Serial no.</th><th rowspan="1" colspan="1" style="width: 237.35px;">Tutor Reservations</th><th rowspan="1" colspan="1" style="width: 121.5px;">Date</th><th rowspan="1" colspan="1" style="width: 89.6167px;">Start Date</th><th rowspan="1" colspan="1" style="width: 102.567px;">End date</th><th rowspan="1" colspan="1" style="width: 100.583px;">Duration</th></tr>
                                        </tfoot></table></div></div></div><div class="dataTables_info" id="scroll-dynamic_info" role="status" aria-live="polite">Showing 1 to 57 of 57 entries</div></div>
                                </div>
                            </div>
                        </div>
                        <div id="test5" class="center" style="display: none;">
                            
                            <div id="app-calendar">
                                <div class="row">
                                  <div class="col s12">
                                    <div class="card">
                                      <div class="card-content">
                                        <h4 class="card-title">
                                          Basic Calendar
                                        </h4>
                                        <div id="basic-calendar">

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>                  
                            </div>
                      </div>
                    <div class="card-content">
                        
                    </div>
                </div>
            </div>
        </div>    


    
</div>
<!--/ End Dashboard-->
<div class="row">
    <div class="col s12 m6 l4">
    </div>
    <div class="col s12 m6 l8">
    </div>
</div>
</div>
</div>
</div>
</div>
@include('student.layout.footer') {{--including footer--}}
@endif
@endsection

@section('own_js')

    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        // tutor online status
        var channel = pusher.subscribe('tutor.status');
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
            //console.log(tutor);
            var elements = document.getElementsByClassName('online-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('text-muted');
                    element.classList.add('text-success');
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('text-success');
                        element.classList.add('text-muted');
                    }
                }
            });

            var element_learningSessionAnchor = document.getElementsByClassName('a-'+tutor.email);
            $.each(element_learningSessionAnchor, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.removeAttribute('disabled');
                    element.setAttribute('href', '{{route('student.learningSession.request.tutor',['tutor_id' => 0])}}'+tutor.id);
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.removeAttribute('href');
                        element.setAttribute('disabled', 'disabled');
                    }
                }
            });
        });

    </script>
    <script>

        /*delete reservation*/
        function delete_reservation(learning_session_reservation_id) {
            $.ajax({
                url: '{{route('student.ajax.tutor.reservation.delete')}}',
                type: "DELETE",
                data:{
                    'learning_session_reservation_id' : learning_session_reservation_id
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    var status = response.status;
                    var msg = response.msg;
                    alert(msg);
                    if(status.localeCompare('success') == 0){
                        // remove card
                        $('#card-div-'+learning_session_reservation_id).remove();
                    }
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }

        $(document).ready(function () {

            // getting all tutors
            $.ajax({
                url: '{{route('student.ajax.tutors.all')}}',
                type: "GET",
                success: function (response) {
                    //console.log("response: " + JSON.stringify(response));
                    var $tutors = response.tutors;
                    $('#data-tutors').data('tutors', $tutors);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });

            // reservation
            $('#newReservation_btn').click(function () {
                $('#select-tutor').empty().append('<option value="0">Select Tutor:</option>');
                $('.res-el').empty().attr('disabled', 'disabled');

                var $tutors = $('#data-tutors').data('tutors');
                $.each($tutors, function (i, tutor) {
                    var $name = tutor.name + " " +tutor.last_name;
                    $('#select-tutor').append("" +
                        "<option value='"+tutor.id+"'>" +
                        ""+ $name +
                        "</option>"
                    );
                    //console.log($first_name + " " + $last_name);
                })
                // show model
                $('#newReservation').modal('show');
            });

            // tutor selection
            $('#select-tutor').change(function () {
                if($('#select-tutor').val().localeCompare('0') != 0){
                    // selected tutor id
                    var $tutorID = $('#select-tutor').val();
                    console.log($tutorID);

                    $('.res-el').removeAttr('disabled');
                    $('#session_duration').empty();
                    for(var i = 1; i <= 4; i++ ){
                        $('#session_duration').append('<option value="'+(i * 15)+'">'+(i * 15)+'</option>');
                    }

                    var $tutors = $('#data-tutors').data('tutors');
                    $.each($tutors, function (i, tutor) {
                       if(tutor.id == $tutorID){

                           // topics
                           var $tutorSpecializations = tutor.profile.tutor_specializations;
                           $("#select-topic").empty();
                           $.each($tutorSpecializations, function (i, tutorSpecialization) {
                               var topicID = tutorSpecialization.topic_id;
                               var topic = tutorSpecialization.topic;
                               $("#select-topic").append('<option value="'+topicID+'">'+topic+'</option>');
                           })
                           console.log($tutorSpecializations);

                           // available dates
                           var availabilityDates = tutor.profile.tutor_availability_dates;
                           $('#select-av_date').empty();
                            $.each(availabilityDates, function (i, date) {
                                $('#select-av_date').append('<option value="'+date+'">'+date+'</option>');
                            });
                            console.log(availabilityDates);



                            // getting available times
                           updateAvTime();

                           // break the loop
                           return false;
                       }
                    });
                }else{
                    console.log("Please select");
                    $('.res-el').attr('disabled', 'disabled');
                }
            });

            // on change duration
            $('#session_duration').change(function () {
                updateAvTime();
            });

            // on change date
            $('#select-av_date').change(function () {
               updateAvTime();
            });

            // on click reserve_btn
            $('#reserve_btn').click(function () {
                var $selectedTutor_id = $('#select-tutor').val();
                var $selectedTopic_id = $('#select-topic').val();
                var $selectDuration = $('#session_duration').val();
                var $selectedDate = $('#select-av_date').val();
                var $selectedTime = $.parseJSON($('#select-av_time').val()); // parse in json
                //console.log($selectedTutor_id + "\n" + $selectedTopic_id + "\n" + $selectDuration + "\n" + $selectedDate + "\n" + "FROM " + $selectedTime.from + " TO " + $selectedTime.to);

                $.ajax({
                    url: '{{route('student.ajax.tutor.reservation')}}',
                    type: "POST",
                    data:{
                        'tutor_id' : $selectedTutor_id,
                        'topic_id' : $selectedTopic_id,
                        'duration' : $selectDuration,
                        'date' : $selectedDate,
                        'start_time' : $selectedTime.from,
                        'end_time' : $selectedTime.to
                    },
                    success: function (response) {
                       // console.log("response: " + JSON.stringify(response));
                        var status = response.status;
                        var msg = response.msg;
                        alert(msg);
                        $('#newReservation').modal('hide');
                        if(status.localeCompare('success') == 0){
                            var $lr_reservation = response.detail;
                            //console.log($lr_reservation);

                            // refresh the page
                            location.reload();
                        }
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            });

        });

        // update the available time slots
        function updateAvTime() {
            // getting available times
            var $selectedTutor_id = $('#select-tutor').val();
            var $selectDuration = $('#session_duration').val();
            var $selectedDate = $('#select-av_date').val();
            $.ajax({
                url: '{{route('student.ajax.tutor.reservation.availability')}}',
                type: "POST",
                data: {
                    'tutor_id' : $selectedTutor_id,
                    'duration' : $selectDuration,
                    'date' : $selectedDate
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    var availabilities = response.available_slots;
                    $('#select-av_time').empty();
                    $.each(availabilities, function (i, availability) {
                        $('#select-av_time').append("<option value='{\"from\" :\""+availability.from+"\" ,\"to\" :\""+availability.to+"\" }'>"+availability.from+" - "+availability.to+"</option>");
                    });
                    console.log(availabilities);
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                }
            });
        }
    </script>
   
  <script type="text/javascript">
    // CSRF Token

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

   $(document).ready(function(){


     $( "#topic" ).autocomplete({

       source: function( request, response ) {

         // Fetch data

         $.ajax({

           url:"{{route('autocomplete')}}",

           type: 'post',

           dataType: "json",

           data: {

             _token: CSRF_TOKEN,

             search: request.term

           },

           success: function( data ) {

             response( data );

           }

         });

       },

       select: function (event, ui) {

         $('#topic').val(ui.item.label);

         $('#topicid').val(ui.item.value); 

         return false;

       }

     });


   });

 </script>
@endsection

