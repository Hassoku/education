<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Education+ Administration</title>
    <meta name="description" content="Duroos Administration Portal" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- for ios 7 style, multi-resolution icon of 152x152
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    {{-- <link rel="apple-touch-icon" href="{{asset('assets/admin/images/admin/favicon.png')}}"> --}}
    <meta name="apple-mobile-web-app-title" content="Duroos">
     for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" sizes="196x196" href="{{asset('assets/admin/images/educationpluslogo.jpeg')}}">

    <!-- style -->
    
    <link rel="stylesheet" href="{{asset('assets/admin/css/animate.css/animate.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/admin/fonts/glyphicons/glyphicons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/admin/fonts/font-awesome/css/font-awesome.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/admin/fonts/material-design-icons/material-design-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap/bootstrap.min.css')}}" type="text/css" />
    <!-- build:css ../assets/styles/app.min.css -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/styles/app.css')}}" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/styles/font.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/test.css')}}" type="text/css" />
    @yield('styles')
</head>
<body>
<div class="app" id="app">
    {{-- <div id="content" class="app-content box-shadow-z0" role="main">

        @include('admin.layout.header')
        @include('admin.layout.footer')

        @yield('content')
    </div> --}}
    @if(Auth::guard('admin')->check())
        <!-- ############ LAYOUT START-->
        @include('admin.layout.left')

        <div id="content" class="app-content box-shadow-z0" role="main">

            @include('admin.layout.header')
            @include('admin.layout.footer')

            @yield('content')

        </div>
        <!-- ############ LAYOUT END-->
    @else
        @yield('content')
    @endif

</div>

<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
<script src="{{asset('assets/admin/js/jquery/jquery/jquery.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/admin/js/jquery/tether/tether.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery/bootstrap/bootstrap.js')}}"></script>
<!-- core -->
<script src="{{asset('assets/admin/js/jquery/underscore/underscore-min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery/jQuery-Storage-API/jquery.storageapi.min.js')}}"></script>

<script src="{{asset('assets/admin/js/scripts/config.lazyload.js')}}"></script>
<!--script src="{{asset('assets/admin/js/scripts/palette.js')}}"></script-->

<script src="{{asset('assets/admin/js/scripts/ui-form.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-load.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-jp.js')}}"></script>

<script src="{{asset('assets/admin/js/scripts/ui-include.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-device.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-screenfull.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-scroll-to.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-toggle-class.js')}}"></script>

<!-- core -->
<script src="{{asset('assets/admin/js/jquery/PACE/pace.min.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ui-nav.js')}}"></script>
@yield('scripts')
<script src="{{asset('assets/admin/js/scripts/app.js')}}"></script>


<!-- ajax -->
<!--script src="{{asset('assets/admin/js/jquery/jquery-pjax/jquery.pjax.js')}}"></script>
<script src="{{asset('assets/admin/js/scripts/ajax.js')}}"></script-->

<!-- endbuild -->
</body>
</html>