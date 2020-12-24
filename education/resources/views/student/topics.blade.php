@extends('student.layout.app')
@section('pageTitle', 'Topics')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar',['topics' => true])
@endsection
@section('content')
    @php
        $levelFrequency = $topicsCollection['levelFrequency'];
        $parentFrequency = $topicsCollection['parentFrequency'];
        $idWiseTopics = $topicsCollection['idWiseTopics'];
        $topicWiseTutors = $topicsCollection['topicWiseTutors'];
        $iniParent = 0;
    @endphp

    {{--@foreach($topicWiseTutors[4] as $tutor)--}}
        {{--{{$tutor->tutor_profile->tutor->name}} <br>--}}
    {{--@endforeach--}}

    <div id="data-id_wise_topics" data-id_wise_topics="{{json_encode($idWiseTopics)}}" ></div>
    <div id="data-topic_id_wise_tutors" data-topic_id_wise_tutors="{{json_encode($topicWiseTutors)}}" ></div>
    <div id="data-parent_frequency" data-parent_frequency="{{json_encode($parentFrequency)}}" ></div>
    <div id="data-last_parent_frequency" data-last_parent_frequency="{{$iniParent}}" ></div>
    <main role="main" class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-1 left-area pl-3"></div>
            <div class="col-md-9 border-right">
                <nav id="topics-breadcrumb" aria-label="breadcrumb">
                    <ol id="topics-breadcrumb-list" class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Topics</li>
                    </ol>
                </nav>

                <div id="sub-topic-title-div"></div>
                <div id="topics-div">
                    @foreach($parentFrequency[$iniParent] as $childTopic)
                        <div class="card" style="width: 18rem; float: left; margin-right: 10px; margin-bottom: 10px;">
                            <div class="card-body">
                                <h5 class="card-title">{{$childTopic->topic}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted text-truncate">{{$childTopic->description}}</h6>
                                {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                                <a href="#" class="card-link" onclick="openTopic( '{{$childTopic->id}}','{{$childTopic->topic}}','{{$childTopic->parent}}')">Open</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="clear: both;">
                    <div id="related-tutor-title-div"></div>
                    <div id="related-tutor-div"></div>
                </div>

                <div style="clear: both; padding-top: 20px">
                    <div class="btn btn-primary" onclick="backTopic()">Back</div>
                </div>
            </div>

            {{--Remaining Minutes Aside--}}
            @include('student.layout.remainingMinutesAsideBar')

        </div>
        @include('student.layout.footer') {{--including footer--}}
    </main>
@endsection
@section('own_js')
    {{--Pusher--}}
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

            //console.log(tutor);
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


    <script>
        function openTopic(topicID, topic, lastParenFrequency) {

            /*
            * setting last parent frequency
            * */
            $('#data-last_parent_frequency').data('last_parent_frequency', lastParenFrequency);
            console.log($('#data-last_parent_frequency').data('last_parent_frequency'));

            /*
            * Getting Child topics
            * */
            var $parentTopics = $('#data-parent_frequency').data('parent_frequency');
            var $childTopics = $parentTopics[topicID];
            console.log('length: ' + $childTopics.length);

            if($childTopics.length > 0){
                $('#sub-topic-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Sub Topics</h4>");
                $('#related-tutor-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Tutors</h4>");
            }else{
                $('#sub-topic-title-div').empty();
                $('#related-tutor-title-div').empty();
            }

            /*
            * Adding to child to topics-div
            * */
            var $topics_div = $("#topics-div");
            var $content = "";
            $.each($childTopics, function (i, $topic) {
                $content += "<div class=\"card\" style=\"width: 18rem; float: left; margin-right: 10px; margin-bottom: 10px;\">\n" +
                    "                            <div class=\"card-body\">\n" +
                    "                                <h5 class=\"card-title\">"+$topic.topic+"</h5>\n" +
                    "                                <h6 class=\"card-subtitle mb-2 text-muted text-truncate\">"+$topic.description+"</h6>\n" +
                    "                                <a href=\"#\" class=\"card-link\" onclick=\"openTopic( '"+$topic.id+"','"+$topic.topic+"','"+$topic.parent+"')\">Open</a>\n" +
                    "                            </div>\n" +
                    "                        </div>";
            });
            $topics_div.empty().html($content);

            /*
            * Adding tutors
            * */
            var $tutor_div = $('#related-tutor-div');
            $content = "";
            var $topicWiseTutors = $('#data-topic_id_wise_tutors').data('topic_id_wise_tutors');
            var $tutors = $topicWiseTutors[topicID];
            if($tutors){
                if($tutors.length > 0){
                    $('#related-tutor-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Tutors</h4>");
                }else{
                    $('#related-tutor-title-div').empty();
                }
            }
            $.each($tutors , function (i, tutor) {
                //console.log(tutor);
                var tutor_rating = tutor.profile.rating;

                // css conditioned classes
                var classForOnlineStatus = (tutor.online_status == 0) ? 'text-muted ' : 'text-success ';
                var forMakingSessionCall = (tutor.online_status == 0) ? 'disabled="disabled"' : 'href="{{route('student.learningSession.request.tutor',['tutor_id' => 0])}}'+tutor.id+'"';

                var tutorSpecializations = "";
                $.each(tutor.profile.tutor_specializations, function (i, tutor_specialization) {
                    if( i < (tutor.profile.tutor_specializations).length){
                        tutorSpecializations += tutor_specialization.topic + ", ";
                    }else{
                        if( i < (tutor.profile.tutor_specializations).length){
                            tutorSpecializations += tutor_specialization.topic + ".";
                        }
                    }
                });
                
                $content += '' +
                    '<div class="profileCard">\n' +
                        '<div style="position: relative" class="">\n' +
                            '<i style="position: absolute; bottom: 12px; left: 89px; color: #eeeeee; font-size: 18px" class="fas fa-circle"></i>\n' +
                            '<small style="position: absolute; bottom: 9px; left: 91px;" class=" online-'+tutor.email+' '+classForOnlineStatus +'">\n' +
                                '<i class="fas fa-circle"></i>\n' +
                            '</small>\n' +
                            '<img src="'+tutor.profile.picture+'" class="circle" alt=" '+tutor.name+' '+tutor.last_name+' " style="width:50%; padding: 5%">\n' +
                         '</div>\n' +
                        '<div class="text-primary mr-1"><i class="text-success fas fa-star"></i> '+tutor_rating.total_rating+' ('+tutor_rating.total_raters+')</div>\n' +
                        '<h4 class="text-truncate">'+tutor.name+' '+tutor.last_name+'</h4>\n' +
                        '<p class="title text-truncate"> '+tutorSpecializations+' </p>\n' +
                        '<div class="row action-icons">\n' +
                            '<a class="col-md-3" title="Profile" href="{{route('student.tutorProfile.show',['tutor_id' => 0])}}'+tutor.id+'">\n' +
                                '<i class="fas fa-user"></i>\n' +
                            '</a>\n' +
                            '<a class=" a-'+tutor.email+' col-md-3" title="Call for session" '+forMakingSessionCall+'>\n' +
                                '<i class="fas fa-phone"></i>\n' +
                            '</a>\n' +
                            '<a class="col-md-3" title="Messages" href="{{route('student.individual.chat',['tutor_id' => 0])}}'+tutor.id+'">\n' +
                                '<i class="fas fa-comments"></i>\n' +
                            '</a>\n' +
                            '<a class="col-md-3" title="Reserve for a session" href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}"><i class="fas fa-clock"></i></a>\n' +
                        '</div>\n' +
                    '</div>\n';
            });
            $tutor_div.empty().append($content);

            /*
            * Updating breadcurmb
            * */
            var $topics_breadcrumb_list = $('#topics-breadcrumb-list');
                var newItem = "<li class=\"breadcrumb-item active\" aria-current=\"page\">"+topic+"</li>";
                $topics_breadcrumb_list.append(newItem);
        }

        /*
        * Back function
        * */
        function backTopic() {
            var idWiseTopics = $("#data-id_wise_topics").data('id_wise_topics');
            var lastParentFrequency = $("#data-last_parent_frequency").data('last_parent_frequency');

            /*
            * Getting Child topics
            * */
            var $parentTopics = $('#data-parent_frequency').data('parent_frequency');
            var $childTopics = $parentTopics[lastParentFrequency];

            /*
            * Parent of Parent will be the next parentFrequency of back
            * but 0 parent has no parent so
            * idWiseTopics[$childTopics[0].parent].parent
            * */
            if(lastParentFrequency != 0){
                $("#data-last_parent_frequency").data('last_parent_frequency', idWiseTopics[$childTopics[0].parent].parent);
                var updatedLastParentFrequency = $("#data-last_parent_frequency").data('last_parent_frequency');

                $('#sub-topic-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Sub Topics</h4>");
                $('#related-tutor-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Tutors</h4>");
            }else{
                $('#sub-topic-title-div').empty();
                $('#related-tutor-title-div').empty();
            }

            /*
            * Adding to child to topics-div
            * */
            var $topics_div = $("#topics-div");
            var $content = "";
            $.each($childTopics, function (i, $topic) {
                $content += "<div class=\"card\" style=\"width: 18rem; float: left; margin-right: 10px; margin-bottom: 10px;\">\n" +
                    "                            <div class=\"card-body\">\n" +
                    "                                <h5 class=\"card-title\">"+$topic.topic+"</h5>\n" +
                    "                                <h6 class=\"card-subtitle mb-2 text-muted text-truncate\">"+$topic.description+"</h6>\n" +
                    "                                <a href=\"#\" class=\"card-link\" onclick=\"openTopic( '"+$topic.id+"','"+$topic.topic+"','"+$topic.parent+"')\">Open</a>\n" +
                    "                            </div>\n" +
                    "                        </div>";
            });
            $topics_div.empty().html($content);

            /*
           * Adding tutors
           * */
            var $tutor_div = $('#related-tutor-div');
            $content = "";
            var $topicWiseTutors = $('#data-topic_id_wise_tutors').data('topic_id_wise_tutors');
            var $tutors = $topicWiseTutors[lastParentFrequency];
            if($tutors){
                if($tutors.length > 0){
                    $('#related-tutor-title-div').empty().html("<h4 class=\"text-primary border-bottom\">Tutors</h4>");
                }else{
                    $('#related-tutor-title-div').empty();
                }
            }
            $.each($tutors , function (i, tutor) {
                console.log(tutor);
                var tutor_rating = tutor.profile.rating;

                // css conditioned classes
                var classForOnlineStatus = (tutor.online_status == 0) ? 'text-muted ' : 'text-success ';
                var forMakingSessionCall = (tutor.online_status == 0) ? 'disabled="disabled"' : 'href="{{route('student.learningSession.request.tutor',['tutor_id' => 0])}}'+tutor.id+'"';

                var tutorSpecializations = "";
                $.each(tutor.profile.tutor_specializations, function (i, tutor_specialization) {
                    if( i < (tutor.profile.tutor_specializations).length){
                        tutorSpecializations += tutor_specialization.topic + ", ";
                    }else{
                        if( i < (tutor.profile.tutor_specializations).length){
                            tutorSpecializations += tutor_specialization.topic + ".";
                        }
                    }
                });

                $content += '' +
                    '<div class="profileCard">\n' +
                    '<div style="position: relative" class="">\n' +
                    '<i style="position: absolute; bottom: 12px; left: 89px; color: #eeeeee; font-size: 18px" class="fas fa-circle"></i>\n' +
                    '<small style="position: absolute; bottom: 9px; left: 91px;" class=" online-'+tutor.email+' '+classForOnlineStatus +'">\n' +
                    '<i class="fas fa-circle"></i>\n' +
                    '</small>\n' +
                    '<img src="'+tutor.profile.picture+'" class="circle" alt=" '+tutor.name+' '+tutor.last_name+' " style="width:50%; padding: 5%">\n' +
                    '</div>\n' +
                    '<div class="text-primary mr-1"><i class="text-success fas fa-star"></i> '+tutor_rating.total_rating+' ('+tutor_rating.total_raters+')</div>\n' +
                    '<h4>'+tutor.name+' '+tutor.last_name+'</h4>\n' +
                    '<p class="title text-truncate"> '+tutorSpecializations+' </p>\n' +
                    '<div class="row action-icons">\n' +
                    '<a class="col-md-3" title="Profile" href="{{route('student.tutorProfile.show',['tutor_id' => 0])}}'+tutor.id+'">\n' +
                    '<i class="fas fa-user"></i>\n' +
                    '</a>\n' +
                    '<a class=" a-'+tutor.email+' col-md-3" title="Call for session" '+forMakingSessionCall+'>\n' +
                    '<i class="fas fa-phone"></i>\n' +
                    '</a>\n' +
                    '<a class="col-md-3" title="Messages" href="{{route('student.individual.chat',['tutor_id' => 0])}}'+tutor.id+'">\n' +
                    '<i class="fas fa-comments"></i>\n' +
                    '</a>\n' +
                    '<a class="col-md-3" title="Reserve for a session" href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}"><i class="fas fa-clock"></i></a>\n' +
                    '</div>\n' +
                    '</div>\n';
            });
            $tutor_div.empty().append($content);

            /*
            * removing from breadcrumb
            * */
            if($('#topics-breadcrumb-list').children().length > 1){
                $('li', '#topics-breadcrumb-list').last().remove();
            }
        }
    </script>
@endsection
