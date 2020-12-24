
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
            Please contact with <a href><u>Education+ support</u></a> for further details.
        </div>
    </div>
@endif
<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
  <div class="brand-sidebar">
    <h1 class="logo-wrapper "><a class="brand-logo darken-1" href="{{route('student.dashboard')}}" ><img class="hide-on-med-and-down waves-effect waves-light " src="{{asset('assets/student/images/educationpluslogo.jpeg')}}" alt="materialize logo"/><img class="show-on-medium-and-down hide-on-med-and-up" src="{{asset('assets/student/images/educationpluslogo.jpg')}}" alt="materialize logo"/><span class="logo-text hide-on-med-and-down"></span></a></h1>
  </div>
  <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion" style="text-decoration: none !important;">
    <li class="active bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">dashboard</i><span class="menu-title" data-i18n="Dashboard">Student Dashboard</span></a>
      <div class="collapsible-body">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
       
          <li class="active"><a class="waves-effect waves-cyan" href="{{route('student.dashboard')}}"><i class="material-icons">border_all</i><span data-i18n="Modern">Dashboard</span></a>
          </li>
          <li><a class="waves-effect waves-cyan"  href="{{route('student.dashboard.page',['p_code' => 'ttr'])}}"><i class="material-icons">person</i><span data-i18n="eCommerce">All Teachers  </span></a>
          </li>
          <li><a class="waves-effect waves-cyan" href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}"><i class="material-icons">event_available</i><span data-i18n="Analytics">Reserve Sessions</span></a>
          </li>
        </ul>
      </div>
    </li>
    <li class="navigation-header"><a class="navigation-header-text">Paid Services</a><i class="navigation-header-icon material-icons">more_horiz</i>
    </li>
    <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">receipt</i><span class="menu-title" data-i18n="Invoice">Proofreading</span></a>
    </li>
    <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">crop_original</i><span class="menu-title" data-i18n="Medias">Translations</span></a>
      <div class="collapsible-body">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
          <li><a href="media-gallery-page.html"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Gallery Page">Gallery Page</span></a>
          </li>
          <li><a href="media-hover-effects.html"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Media Hover Effects">Media Hover Effects</span></a>
          </li>
        </ul>
      </div>
    </li>
    
  </ul>
  <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->
<header class="page-topbar" id="header">
  <div class="navbar navbar-fixed"> 
    <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
      <div class="nav-wrapper">
          <form class=""  action="{{ route('search') }}" method="get" role="search">
            {{ csrf_field()}}    
          <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
            <input class="header-search-input z-depth-2" type="text" name="topic" placeholder="Search for Subject" data-search="template-list" value="{{request()->query('topic')}}">
            <ul class="search-list collection display-none"></ul>

          </div>
          <button class="btn btn-default btnsearch" style="height: 44px;margin-top: -4px;" type="submit"><i class="fa fa-search" style="margin-top: -9px;"></i></button>
        
          <ul class="navbar-list right">
            <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
            <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online" style="margin-right: 53px;margin-bottom: 10px;"><img src="{{asset('assets/student/app-assets/images/avatar/avatar-7.png')}}" alt="avatar"><i></i></span></a></li>
          </ul>
        </form>
        <!-- translation-button-->
        <ul class="" id="translation-dropdown">
        </ul>
        <!-- notifications-dropdown-->
        <ul class="dropdown-content" id="notifications-dropdown">
          <li>
          </li>
          <li class="divider"></li>
          </li>
        </ul>
        <!-- profile-dropdown-->
        <ul class="dropdown-content" id="profile-dropdown" style="width: 211px;left: 1106px;">
          <li><a class="grey-text text-darken-1" href="{{route('student.profile.show')}}"><i class="material-icons">person_outline</i> Profile</a></li>
          <li><a class="grey-text text-darken-1" href="{{route('student.learning.session.archives')}}"><i class="material-icons">chat_bubble_outline</i> Session Archives</a></li>
          <li><a class="grey-text text-darken-1" href="{{route('student.paymentHistory')}}"><i class="material-icons">help_outline</i>Payment History</a></li>
          <li class="divider"></li>
          <li><a class="grey-text text-darken-1" href="{{route('student.setting')}}"><i class="material-icons">lock_outline</i> Settings</a></li>
          <li><a class="grey-text text-darken-1" href="{{ route('student.logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">keyboard_tab</i> Logout</a></li>
        <!-- Form for logout -->
        <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
        </ul>
      </div>
      
    </nav>
  </div>
</header>


