<!-- aside -->
<div id="aside" class="app-aside modal fade nav-dropdown">
    <!-- fluid app aside -->
    <div class="left navside dark dk" layout="column">
        <div class="navbar no-radius">
            <!-- brand -->
            <a class="navbar-brand">
                <img src="{{asset('assets/admin/images/educationpluslogo.jpeg')}}" alt="." class="" style="margin-left: -19px;width: 203px;margin-top: 0px;">
            </a>
            <!-- / brand -->
        </div>
        <div flex class="hide-scroll">
            <nav class="scroll nav-light">
                <ul class="nav" ui-nav>
                    <li class="nav-header hidden-folded"> <small class="text-muted">Education+ Administrator</small> </li>
                    <li @if(stripos(url()->current() , 'dashboard') !== false ) class="active" @endif> <a href="{{route('admin.dashboard')}}" > <span class="nav-icon"> <i class="material-icons">&#xe3fc; </i> </span> <span class="nav-text">Dashboard</span> </a> </li>
                    <li @if(stripos(url()->current() , 'students') !== false ) class="active" @endif>
                        <a href="{{route('admin.students')}}" >
{{--                            <span class="nav-label"><b class="label label-sm accent">8</b></span>--}}
                            <span class="nav-icon">
                                <i class="material-icons">person_outline</i>
                            </span>
                            <span class="nav-text">Manage Students</span>
                        </a>
                    </li>
                    <li @if(stripos(url()->current() , 'tutors') !== false ) class="active" @endif> <a href="{{route('admin.tutors')}}" > <span class="nav-icon"> <i class="material-icons">person</i> </span> <span class="nav-text">Manage Tutors</span> </a> </li>
                    {{--<li @if(stripos(url()->current() , 'sessions') !== false ) class="active" @endif> <a href="{{route('admin.sessions')}}" > <span class="nav-icon"> <i class="material-icons">question_answer</i> </span> <span class="nav-text">Manage Sessions</span> </a> </li>--}}
                    {{--<li @if(stripos(url()->current() , 'sessions') !== false ) class="active" @endif> <a href="{{route('admin.sessions')}}" > <span class="nav-icon"> <i class="material-icons">voice_chat</i> </span> <span class="nav-text">Manage Sessions</span> </a> </li>--}}
                    <li @if(stripos(url()->current() , 'subjects') !== false ) class="active" @endif> <a href="{{route('admin.subjects')}}" > <span class="nav-icon"> <i class="material-icons">subject</i> </span> <span class="nav-text">Manage Subjects</span> </a> </li>
                    <li @if(stripos(url()->current() , 'topics') !== false ) class="active" @endif> <a href="{{route('admin.topics')}}" > <span class="nav-icon"> <i class="material-icons">filter_list</i> </span> <span class="nav-text">Manage Topics</span> </a> </li>
                    <li @if(stripos(url()->current() , 'reports') !== false ) class="active" @endif> <a href="{{route('admin.reports')}}" > <span class="nav-icon"> <i class="material-icons">insert_drive_file</i> </span> <span class="nav-text">Manage Reports</span> </a> </li>
                    <li @if(stripos(url()->current() , 'reporting') !== false ) class="active" @endif> <a href="{{route('admin.tut_std.reporting')}}" > <span class="nav-icon"> <i class="material-icons">report</i> </span> <span class="nav-text">Tut/Std Reporting</span> </a> </li>
                    <li @if(stripos(url()->current() , 'settings') !== false ) class="active" @endif> <a href="{{route('admin.settings')}}" > <span class="nav-icon"> <i class="material-icons">settings</i> </span> <span class="nav-text">Settings</span> </a> </li>
                </ul>
            </nav>
        </div>
{{--        <div flex-no-shrink class="b-t">
            <div class="nav-fold">
                <a href="{{route('help')}}">
                    <div class="row">
                        <div class="col-md-2">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="col-md-4">
                            Help
                        </div>
                    </div>
                </a>
            </div>
        </div>--}}
    </div>
</div>
<!-- / -->