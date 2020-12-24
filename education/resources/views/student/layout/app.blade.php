<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
  <meta name="author" content="ThemeSelect">
  <title>Dashboard Modern | Materialize - Material Design Admin Template</title>
    <link rel="icon" href="{{asset('assets/student/images/educationpluslogo.jpeg')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') - {{ config('app.name', 'Education+')}}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/student/css/bootstrap-reboot.min.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/student/css/fa-regular.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/student/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/student/css/bootstrap.min.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/css/custom.css')}}" rel="stylesheet"  >
        <link href="{{asset('assets/student/css/w3.css')}}" rel="stylesheet"  >
    <!-- Mobile Number Field CSS -->
    <link rel="stylesheet" href="{{asset('assets/student/mobile_number_field/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/student/mobile_number_field/css/demo.css')}}">

    {{-- old css end  --}}

    <link rel="apple-touch-icon" href="../../../app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="icon" href="{{asset('assets/student/images/educationpluslogo.jpeg')}}">
    
    <!-- BEGIN: VENDOR CSS-->
    <link href="{{asset('assets/student/app-assets/vendors/vendors.min.css')}}" rel="stylesheet" >
    {{-- FullCalendar --}}
    <link href="{{asset('assets/student/app-assets/vendors/flag-icon/css/flag-icon.min.css  ')}}" rel="stylesheet" >
    <link href="{{asset('assets/student/app-assets/vendors/fullcalendar/css/fullcalendar.min.css  ')}}" rel="stylesheet" >
    <link href="{{asset('assets/student/app-assets/vendors/fullcalendar/daygrid/daygrid.min.css  ')}}" rel="stylesheet" >
    <link href="{{asset('assets/student/app-assets/vendors/fullcalendar/timegrid/timegrid.min.css  ')}}" rel="stylesheet" >

{{-- End Full Calendar --}}


    <link href="{{asset('assets/student/app-assets/vendors/animate-css/animate.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/app-assets/vendors/chartist-js/chartist.min.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/app-assets/vendors/chartist-js/chartist-plugin-tooltip.css')}}" rel="stylesheet"  >
    <!-- END: VENDOR CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
      <link href="{{asset('assets/student/css/custom.css')}}" rel="stylesheet"  >
    <link rel="stylesheet" type="text/css" href="{{asset('assets/student/app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    {{-- <link href="{{asset('assets/student/app-assets/css/themes/vertical-modern-menu-template/materialize.min.css')}}" rel="stylesheet"  >     --}}
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256- 
DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous">
</script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/student/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/student/app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/student/app-assets/css/pages/data-tables.css')}}">

    <!-- BEGIN: Page Level CSS-->
    <link href="{{asset('assets/student/app-assets/css/themes/vertical-modern-menu-template/materialize.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/app-assets/css/themes/vertical-modern-menu-template/style.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/app-assets/css/pages/dashboard-modern.css')}}" rel="stylesheet"  >
    <link href="{{asset('assets/student/app-assets/css/pages/intro.css')}}" rel="stylesheet"  >
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/student/app-assets/css/custom/custom.css')}}">
    <!-- END: Custom CSS-->
    @yield('ownCSS')
<style>
    a{text-decoration: none;!important} 
</style>
</head>
<body class=" @yield('body_class_atr') vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns" data-open="click" data-menu="vertical-modern-menu" data-col="2-columns" style="text-decoration:none">
       <!-- Navigation Bar -->
       @yield('student_layout_topnavbar')

                <!-- Dashboard-->
        <!-- Content -->
        @yield('content')

 

            @if(!Auth::guest())
                {{--buyMinutes-modal--}}
                
            @endif

    <!-- Optional JavaScript -->
    @yield('own_js')
    <script src="{{asset('assets/student/app-assets/js/vendors.min.js')}}"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('assets/student/app-assets/vendors/chartjs/chart.min.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/vendors/chartist-js/chartist.min.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/vendors/chartist-js/chartist-plugin-tooltip.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

    <script src="{{asset('assets/student/app-assets/js/scripts/app-calendar.js  ')}}" ></script>


    {{-- Full Calendar --}}
    <script href="{{asset('assets/student/app-assets/vendors/fullcalendar/lib/moment.min.js  ')}}"  ></script>
    <script href="{{asset('assets/student/app-assets/vendors/fullcalendar/js/fullcalendar.min.js  ')}}"  ></script>
    <script href="{{asset('assets/student/app-assets/vendors/fullcalendar/daygrid/daygrid.min.js  ')}}"  ></script>
    <script href="{{asset('assets/student/app-assets/vendors/fullcalendar/timegrid/timegrid.min.js  ')}}"  ></script>
    <script href="{{asset('assets/student/app-assets/vendors/fullcalendar/interaction/interaction.min.js  ')}}"  ></script>

{{-- End Full Calendar --}}


    {{-- datatable js --}}
    
    <script src="{{asset('assets/student/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- BEGIN THEME  JS-->
    <script src="{{asset('assets/student/app-assets/js/plugins.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/js/search.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/js/custom/custom-script.js')}}"></script>
    <script src="{{asset('assets/student/app-assets/js/scripts/customizer.js')}}"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
		<script src="{{asset('assets/student/app-assets/js/scripts/dashboard-modern.js')}}"></script>
		<script src="{{asset('assets/student/app-assets/js/scripts/intro.js')}}"></script>

    <!-- END PAGE LEVEL JS-->
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

  <script>
      // Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});
  </script>

         {{--Mobile Number Field JS--}}
         <script src="{{asset('assets/student/mobile_number_field/js//intlTelInput.js')}}"></script>
         @if(!Auth::guest())
             <!-- dashboard -->
             <script>
                 // buy minutes
                    /*   function buyMinutes(subscription_package_id) {
                     // buy minutes
                     $.ajax({
                         {{--url: '{{route('student.ajax.buy.subscription.package')}}',--}}
                         type: "POST",
                         data:{
                             'subscription_package_id' : subscription_package_id
                         },
                         success: function (response) {
                             console.log(response);
                             var $status = response.status;
                             var $msg = response.msg;

                             if($status.localeCompare('success') == 0){
                                 alert($msg);
                                 var remainingSlots = response.remaining_slots;
                                 var remainingMinutes = response.remaining_minutes;
                                 var $type = response.type;

                                 if($type.localeCompare('individual') == 0){
                                     $('#individual-remaining-mins-span').empty().text('' + remainingMinutes);
                                 }
                             }else{
                                 if($status.localeCompare('error') == 0){
                                     alert($msg);
                                 }
                             }
                             // hide modal
                             $('#buyMinutes-modal').modal('hide');
                         },
                         error: function (error) {
                             console.log('Error: ' + JSON.stringify(error));
                             console.log(error.responseText);
                         }
                     });
                 }*/
                
             </script>
         @endif
          @yield('own_js')
</body>
</html>
