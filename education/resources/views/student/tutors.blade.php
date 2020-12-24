@extends('student.layout.app')
@section('pageTitle', 'Tutors')
@section('body_class_atr')main @endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar',['tutors' => true])
@endsection
@section('content')
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <div class="users-list-filter">
                        <div class="card-panel">
                            <div class="row">
                                <form class="navbar-form waves-effect waves-light accent-2 z-depth-2"  action="{{route('search.tutor')}}" method="get" role="search" style="margin-left: 102px;">
                                    <div class="col s12 m6 l3">
                                        <label for="users-list-role">Country</label>
                                        <div class="input-field">
                                            <select class="browser-default" id="country" name ="country"></select>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <label for="users-list-status">State</label>
                                        <div class="input-field ">
                                            <select class="browser-default" id ="state"  name ="states" ></select>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <label for="users-list-verified">Education</label>
                                        <div class="input-field">
                                            <select class="browser-default" id="users-list-verified" name="level">
                                                <option value="">Select Level</option>
                                                    @foreach ($tutor_profiles as $item)
                                                        <option value="{{$item->education}}">{{$item->education}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3 display-flex align-items-center show-btn" style=" margin-top: 47px;">
                                        <button type="submit" class="btn btn-block indigo waves-effect waves-light">Show</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @forelse($tutorsCollections  as $tutor)
                      <div class="col s12 m6 xl4 ">
                        <div id="profile-card" class="card accent-2 z-depth-3" style="width: 100%;border-radius: 15px;">
                            <div class="card-image waves-effect waves-block waves-light" style="border-radius: 15px;">
                                <img class="activator" src="{{asset('assets/student/app-assets/images/gallery/28.jpg')}}" alt="user bg">
                            </div>
                            <div class="card-content">
                                <img src="{{asset('assets/student/app-assets/images/avatar/avatar-7.png')}}" alt="" class="circle responsive-img activator card-profile-image cyan lighten-1 padding-2">
                                <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                                    <i class="material-icons">edit</i>
                                </a>
                                <h5 class="card-title activator grey-text text-darken-4">{{$tutor->name}} {{$tutor->last_name}}</h5>
                                <p> @foreach($tutor->profile->tutor_specializations as $tutor_specialization)
                                    @if($loop->last) {{$tutor_specialization->topic->topic}} @else {{$tutor_specialization->topic->topic}}, @endif
                                @endforeach</p>
                                
                                <div class="w3-container">
                                  
                                  <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-4  gradient-45deg-indigo-purple" href="{{route('student.tutorProfile.show',['tutor_id' => $tutor->id])}}">
                                    <i class="material-icons">person</i>
                                </a>
                                <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-4 gradient-45deg-indigo-purple">
                                    <i class="material-icons">library_add</i>
                                </a>
                                <a class="btn-floating btn-large waves-effect waves-light red accent-2 z-depth-4 gradient-45deg-indigo-purple" href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}">
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
                </div>
            </div>
        </div>
    </div>
</div>
@include('student.layout.footer') {{--including footer--}}
@endsection
@section('own_js')
<script type= "text/javascript" src = "{{asset('assets/student/js/countries.js')}}"></script>
<script language="javascript">
	populateCountries("country", "state"); // first parameter is id of country drop-down and second parameter is id of state drop-down

</script>


    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        var channel = pusher.subscribe('tutor.status');
        // rejected
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
           // console.log(tutor);
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
@endsection
