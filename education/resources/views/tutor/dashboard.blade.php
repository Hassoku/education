@extends('tutor.layout.app')
@section('pageTitle', 'Tutor Dashboard')
@section('body_class_atr')class="main"@endsection
@section('tutor_layout_topnavbar')
    @include('tutor.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div id="dash-content"></div>
        @include('tutor.layout.footer') {{--including footer--}}
    </main>
@endsection
@section('own_js')
    {{--For #communication--}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery-throttle.min.js') }}"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery.loadTemplate-1.4.4.min.js') }}"></script>
        <script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
        <script src="https://media.twiliocdn.com/sdk/js/chat/v2.2/twilio-chat.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/common/releases/0.1.5/twilio-common.js"></script>
{{--    <script src="//media.twiliocdn.com/sdk/js/chat/releases/0.11.1/twilio-chat.js"></script>--}}
    <script src="{{ asset('assets/tutor/js/dateformatter.js') }}"></script>

    {{--Block Back button--}}
    <script language="javascript" type="text/javascript">
        if(window.history && history.pushState){ // check for history api support
            window.addEventListener('load', function(){
                // create history states
                history.pushState(-1, null); // back state
                history.pushState(0, null); // main state
                history.pushState(1, null); // forward state
                history.go(-1); // start in main state

                this.addEventListener('popstate', function(event, state){
                    // check history state and fire custom events
                    if(state = event.state){

                        event = document.createEvent('Event');
                        event.initEvent(state > 0 ? 'next' : 'previous', true, true);
                        this.dispatchEvent(event);

                        var r = confirm("Oops Sorry In-valid Action");
                        if(r==true) {

                        } else {

                        }
                        // reset state
                        history.go(-state);

                    }
                }, false);
            }, false);
        }
    </script>
    <script>
	    window.addEventListener("beforeunload", function (e) {
            // offline
            let status = false;
		    $.post(
			    "{{route('tutor.availability.post')}}",
			    /*$(this).closest('form').serialize(), // form data*/
			    {
				    'status' : status
			    }
			    ,
			    function (data) {
				    console.log(data.online_status);
			    }, 'json').fail(function (xhr, textStatus, errorThrown) {
			    console.log('post error.', xhr);
		    });
	    });
    </script>
@endsection
