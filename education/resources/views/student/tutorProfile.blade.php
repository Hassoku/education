@extends('student.layout.app')
@section('pageTitle', 'Tutor Profile')

@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
   
        <div id="main">
            <div class="row">
                <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
                <div class="col s12">
                    <div class="container">
                        <div class="section">     
                            <div class="row vertical-modern-dashboard">         
                                {{-- profile card --}}
                                <div class="col s12 m6 xl4">
                                    <div id="profile-card" class="card accent-2 z-depth-3" style="width: 328px;">
                                        <div class="content-wrapper-before teal darken-4" style="background-color: #353a40;" ></div>
                                       <div class="card-image waves-effect waves-block waves-light deep-purple lighten-5">
                                       </div>
                                       <div class="card-content">
                                          <img src="{{asset('assets/student/app-assets/images/gallery/28.jpg')}}" alt="" class="circle responsive-img activator card-profile-image cyan lighten-1 padding-2" style="width: 127px;top: 33px;left: 94px;">
                                          <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                                             <i class="material-icons">edit</i>
                                          </a>
                                          <h5 class="card-title activator grey-text text-darken-4">{{$tutor_name}}</h5>
                                        <p><i class="material-icons profile-card-i">perm_identity</i>{{$tutor_post}}</p>
                                          <p><i class="material-icons profile-card-i">book</i>  @foreach($tutor_specializations as $tutor_specialization)
                                            {{$tutor_specialization->topic->topic}}@if(!$loop->last),@endif
                                        @endforeach</p>
                                          <p><i class="material-icons profile-card-i">email</i> yourmail@domain.com</p>
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
                                 {{-- Basic --}}
                                <div class="col s12 m6 xl4">
                                    <div id="profile-card" class="card accent-2 z-depth-3" style="right: 190px;width: 139%;height: 565px;">
                                        <div class="card-content">
                                            <div class="card-tabs">
                                                <ul class="tabs tabs-fixed-width">
                                                  <li class="tab"><a href="#test4" class="active">Aboute Me</a></li>
                                                  <li class="tab"><a class="" href="#test5">Puma</a></li>
                                                  <li class="tab"><a href="#test6" class="">Reebok</a></li>
                                                <li class="indicator" style="left: 0px; right: 348px;"></li></ul>
                                              </div>
                                        </div>
                                        <div class="card-content">
                                            <div id="test4" class="center active" style="display: block;">{{$tutor_intro}}</div>
                                            <div id="test5" class="center" style="display: none;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo quidem, dignissimos non, nesciunt laboriosam, numquam facilis sapiente nulla quibusdam dolores nostrum natus? Ullam nobis eaque, quibusdam quae consequatur dolor quis!</div>
                                            <div id="test6" class="center" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum autem quae facilis ab assumenda, maiores eligendi odio labore quaerat beatae, molestias placeat. Vero aut earum animi voluptas? Saepe, quo officia.</div>
                                          </div>
                                </div>
                                <!--Basic Card-->
                                {{-- <div class="card" style="height: 536px;margin-left: 438px;">
                                    <div class="card-content">
                                      <h4 class="card-title">Basic Cards</h4>
                                      <p>Basic card good at containing small bits of information.</p>
                                      <div class="row">
                                        <div class="row">
                                          <div class="col s12 m6 l6">
                                            <div class="card light-blue">
                                              <div class="card-content white-text">
                                                <span class="card-title">Card Title</span>
                                                <p>
                                                  I am a very simple card with solid background &amp; link. I am good at
                                                  containing small bits of
                                                  information. I am convenient because I require little markup to use
                                                  effectively.
                                                </p>
                                              </div>
                                              <div class="card-action">
                                                <a href="#!" class="lime-text text-accent-1">This is a link</a>
                                                <a href="#!" class="lime-text text-accent-1">This is a link</a>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col s12 m6 l6">
                                            <div class="card gradient-45deg-light-blue-cyan gradient-shadow">
                                              <div class="card-content white-text">
                                                <span class="card-title">Card Title</span>
                                                <p>
                                                  I am a very simple card with gradient background &amp; button. I am good at
                                                  containing small bits
                                                  of
                                                  information. I am convenient because I require little markup to use
                                                  effectively.
                                                </p>
                                              </div>
                                              <div class="card-action">
                                                <a href="#!" class="waves-effect waves-light btn gradient-45deg-red-pink">Button</a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('own_js')
    <script>
/*
        $('#tutReport-btn').click(function () {
            // show moddal
            $("#tutReport-modal").modal('show');
        });

        $('#tutReport-add-btn').click(function () {
            // get values
            var $description = $("#tutReport-decription").val();
            var $tutor_id = $("#tutID").val();
            if($description.length > 25){
                // ajax
                $.ajax({
                    url: '{{route('student.ajax.tutor.reportTutor')}}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "tutor_id" : $tutor_id,
                        "description" : $description,
                    },
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                        $("#tutReport-modal").modal("hide");
                        alert("Reported Successfully.");
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            }else{
                alert("Please write some detailed feedback");
            }
        });

        $('#tutReport-cancel-btn').click(function () {
            // show modal
            $("#tutReport-modal").modal('hide');
        });

        ///////////////////// Notify Me //////////////////

        $('#notifyMe-checkBox').change(function () {
            var $tutor_id = $("#tutID").val();
            if($(this).prop('checked') == true){
                // checked
                $.ajax({
                    url: '{{route('student.ajax.tutor.NotifyStudentTA.add')}}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "tutor_id" : $tutor_id,
                    },
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response));
                    },
                    error:function (error) {
                        console.log('Error: ' + JSON.stringify(error));
                        console.log(error.responseText);
                    }
                });
            }else{
                if($(this).prop('checked') == false){
                    $.ajax({
                        url: '{{route('student.ajax.tutor.NotifyStudentTA.delete')}}',
                        type: "DELETE",
                        dataType: 'json',
                        data: {
                            "tutor_id" : $tutor_id,
                        },
                        success: function (response) {
                            console.log("response: " + JSON.stringify(response));
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });
                }
            }
        });

        /*----------------------------------------------*/
    </script>
@endsection