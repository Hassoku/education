@extends('student.layout.app')
@section('pageTitle', 'Student Profile')
@section('body_class_atr')class="main"@endsection
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
                                  <h5 class="card-title activator grey-text text-darken-4"></h5>
                                <p><i class="material-icons profile-card-i">perm_identity</i></p>
                                  <p><i class="material-icons profile-card-i">book</i>  </p>
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
                                    <div id="test4" class="center active" style="display: block;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ea cum voluptatibus vero corporis eaque consequatur, necessitatibus et adipisci ex! Aliquid quidem voluptate perferendis eveniet eaque sunt dicta, nisi quam dolor.</div>
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
        $(document).ready(function () {
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
                                url:'{{ route('student.profile.pic.change') }}',
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
        });
    </script>
@endsection