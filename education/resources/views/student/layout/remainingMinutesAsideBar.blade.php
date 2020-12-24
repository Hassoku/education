 <!-- BEGIN: SideNav-->
 <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
  <div class="brand-sidebar">
    <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="index.html"><img class="hide-on-med-and-down" src="{{asset('assets/student/images/educationpluslogo.jpeg')}}" alt="materialize logo"/><img class="show-on-medium-and-down hide-on-med-and-up" src="{{asset('assets/student/images/educationpluslogo.jpg')}}" alt="materialize logo"/><span class="logo-text hide-on-med-and-down">Materialize</span></a></h1>
  </div>
  <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
    <li class="active bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Student Dashboard</span></a>
      <div class="collapsible-body">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
          
          <li class="active"><a class="active" href="#"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Dashboard</span></a>
          </li>
          <li><a  href="{{route('student.dashboard.page',['p_code' => 'ttr'])}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="eCommerce">All Teachers  </span></a>
          </li>
          <li><a href="#"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Reservations</span></a>
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