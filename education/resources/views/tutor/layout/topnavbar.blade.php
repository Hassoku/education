{{--Will appear when tutor is not active--}}
@if(Auth::user()->status != 'active')
    <div class="row" style="background:#1a237e; color: white; text-align: center">
        {{--<div class="col-md-2"></div>--}}
        <div class="col-md-12 p-3">
            Your account is
            @if(Auth::user()->status == 'under_review')
                <u><i>Under Review</i></u>.
            @elseif(Auth::user()->status == 'suspended')
                <u><i>Suspended</i></u>.
            @elseif(Auth::user()->status == 'block')
                <u><i>Blocked</i></u>.
            @endif
            <br>
            Please contact with <a href><u>Duroos support</u></a> for further details.
        </div>
    </div>
@endif

{{--User has not provide the card details--}}
@if(!Auth::user()->card_details)
    <div class="row" style="background:#1a237e; color: white; text-align: center">
        <div class="col-md-12 p-3">
            Please provide your card details.
            <u><i><a href="{{route('tutor.account.settings',['tab' => 'cardDetails'])}}">Settings</a></i></u>
        </div>
    </div>
@endif


<nav class="navbar navbar-expand-xl navbar-light">
    <a class="navbar-brand pl-3 pr-2" href="#"><img src="{{asset('assets/tutor/images/educationpluslogo.jpeg')}}" width="105" ></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">

        {{--Will be available when user's status will be active--}}
        @if(Auth::user()->status == 'active')
            <ul class="navbar-nav pl-4 mr-auto  main-navigation border-l-grey">
                <li id="nav_tab_res_li" class="nav-item">
                    <a id="nav_tab_res" class="nav-link" href="{{route('tutor.dashboard')}}#reservations">Reservations </a>
                </li>
                <li id="nav_tab_comm_li" class="nav-item {{ (isset($is_from_individual_chat)) ? "active" : "" }}">
                    <a id="nav_tab_comm" class="nav-link" href="{{route('tutor.dashboard')}}#communications">Communications</a>
                </li>
                <li id="nav_tab_pay_li" class="nav-item">
                    <a id="nav_tab_pay" class="nav-link" href="{{route('tutor.dashboard')}}#payments">Payments</a>
                </li>
            </ul>
            <div class="border-l-grey height-header">
                <form class="form-inline pl-3">
                    <label class="pr-2">Availability</label>
                    <label class="switch">
                        <input id="tu_avl_ch_box" type="checkbox" {{ (Auth::user()->online_status) ? "checked" : NULL }}>
                        <span class="slider round"></span>
                    </label>
                </form>
            </div>
        @else
            <ul class="navbar-nav pl-4 mr-auto  main-navigation border-l-grey">
                <li id="nav_tab_res_li" class="nav-item">
                    <a id="nav_tab_res" class="nav-link" href disabled>Reservations </a>
                </li>
                <li id="nav_tab_comm_li" class="nav-item {{ (isset($is_from_individual_chat)) ? "active" : "" }}">
                    <a id="nav_tab_comm" class="nav-link" href disabled>Communications</a>
                </li>
                <li id="nav_tab_pay_li" class="nav-item">
                    <a id="nav_tab_pay" class="nav-link" href disabled>Payments</a>
                </li>
            </ul>
            <div class="border-l-grey height-header">
                <form class="form-inline pl-3">
                    <label class="pr-2">Availability</label>
                    <label class="switch">
                        <input id="tu_avl_ch_box" type="checkbox" disabled>
                        <span class="slider round"></span>
                    </label>
                </form>
            </div>
        @endif

        <ul class="navbar-nav main-navigation  ml-3">
            <li class="nav-item dropdown active border-l-grey top-notification">
                {{-- <input type="hidden" id="send_url" value="{{route('remove-notification')}}"> --}}
                <?php
                    use App\Helpers\HelperFunctions;
                    $notifications = HelperFunctions::getAllWebNotifications(Auth::user()->id);
                ?>
                <a class="nav-link dropdown-toggle " href="#" id="user-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-bell">@if(count($notifications) > 0)<span></span>@endif</i>
                </a>
                @if(count($notifications)>0)
                    <div class="dropdown-menu top-notification-dd dropdown-menu-right width-300" aria-labelledby="user-menu">
                        @foreach($notifications as $notification)
                            <a id="notification" data-val='{{$notification['id']}}' data-href="{{route($notification['route'])}}" >{{ $notification['message'] }}</a>
                        @endforeach
                    </div>
                @endif
                {{--<div class="dropdown-menu top-notification-dd dropdown-menu-right width-300" aria-labelledby="user-menu">
                    <a class="" href="#notification_Notification_1">Notification 1</a>
                    <a class="" href="#">Notification 2</a>
                    <a class="" href="#">Notification 3</a>
                    <a id="ntf_view_all" href="#notifications" class="text-primary text-center"> View All</a>
                </div>--}}

            </li>
            <li class="nav-item dropdown border-l-grey">
                <a class="nav-link dropdown-toggle user-menu" href="#" id="user-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-truncate ">
                        {{ Auth::user()->name}}
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-right width-300" aria-labelledby="user-menu">
                    <div class="d-flex flex-row left-profile dropdown-item top-profile align-middle py-3">
                        <img src="{{asset('' . Auth::user()->profile->picture)}}" class="circle " width="50" height="50" alt="...">
                        <a href="{{route('tutor.profile.show')}}" class="ml-2 text-truncate">
                            {{ Auth::user()->name}} {{ Auth::user()->last_name}}
                            <br>
                            <small>
                                View Profile
                                <i class="fas fa-angle-right"></i>
                            </small>
                        </a>
                    </div>
                    <!-- setting -->
                     <a id="tu_stng_act" class="dropdown-item" href="{{route('tutor.account.settings')}}">settings</a>
                    <!-- logout-->
                        <a class="dropdown-item" href="{{ route('tutor.logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <!-- Form for logout -->
                        <form id="logout-form" action="{{ route('tutor.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    <!-- / logout-->
                </div>

            </li>
            <li class="nav-item border-l-grey">
                <a class="nav-link" href="#">Arabic </a>
            </li>
        </ul>
    </div>
</nav>