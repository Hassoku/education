<div class="app-header white box-shadow">
    <div class="navbar">
        <!-- Open side - Naviation on mobile -->
        <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up">
            <i class="material-icons">&#xe5d2;</i>
        </a>
        <!-- / -->

        <!-- navbar right -->
        <ul class="nav navbar-nav pull-right">
            <li class="nav-item dropdown">
                <a class="nav-link" href data-toggle="dropdown">
              <span class="avatar w-32">
                <img src="{{asset('assets/admin/images/users/duroos_default_admin.png')}}" alt="...">
                <i class="on b-white bottom"></i>
              </span>
                    <span class="hidden-md-down nav-text m-l-sm text-left">
                <span class="_500">{{Auth::user()->name}}</span>
                <small class="text-muted">Administrator</small>
              </span>
                </a>

                <div class="dropdown-menu pull-right dropdown-menu-scale">
                    <a class="dropdown-item" href="{{route('admin.settings')}}">
                        <span>Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('help')}}">
                        Need help?
                    </a>
                    <!-- logout-->
                    <a class="dropdown-item" href="{{ route('tutor.logout') }}"
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <!-- Form for logout -->
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <!-- / logout-->
                </div>
            </li>
        </ul>
        <!-- / navbar right -->

        <!-- navbar collapse -->
        <div class="collapse navbar-toggleable-sm" id="navbar-5">
            <ul class="nav navbar-nav navbar-nav-inline text-center pull-left m-r text-hover">
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.students')}}"> <span class="nav-text"> <i class="material-icons">person_outline</i> <span class="text-xs">Students</span> </span> </a> </li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.tutors')}}"> <span class="nav-text"> <i class="material-icons">person</i> <span class="text-xs">Tutors</span> </span> </a> </li>
                {{--<li class="nav-item"> <a class="nav-link" href="{{route('admin.sessions')}}"> <span class="nav-text"> <i class="material-icons">question_answer</i> <span class="text-xs">Session</span> </span> </a> </li>--}}
                {{--<li class="nav-item"> <a class="nav-link" href="{{route('admin.sessions')}}"> <span class="nav-text"> <i class="material-icons">voice_chat</i> <span class="text-xs">Session</span> </span> </a> </li>--}}
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.subjects')}}"> <span class="nav-text"> <i class="material-icons">subject</i> <span class="text-xs">Subjects</span> </span> </a> </li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.topics')}}"> <span class="nav-text"> <i class="material-icons">filter_list</i> <span class="text-xs">Topics</span> </span> </a> </li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.reports')}}"> <span class="nav-text"> <i class="material-icons">insert_drive_file</i> <span class="text-xs">Reports</span> </span> </a> </li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.tut_std.reporting')}}"> <span class="nav-text"> <i class="material-icons">report</i> <span class="text-xs">Tut/Std Reporting</span> </span> </a> </li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.settings')}}"> <span class="nav-text"> <i class="material-icons">settings</i> <span class="text-xs">Settings</span> </span> </a> </li>
            </ul>
        </div>
        <!-- / navbar collapse -->
    </div>
</div>
