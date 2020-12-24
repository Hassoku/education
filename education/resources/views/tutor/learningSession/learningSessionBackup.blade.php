@extends('tutor.layout.app')
@section('pageTitle', ' Tutor Learning Session')
@section('body_class_atr')class="session p-2"@endsection
@section('content')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-9 h-100 session-area d-flex justify-content-around" id="media-div">
                <div class="absolute">
                    <div class="alert m-3 alert-danger alert-dismissible fade {{--show--}}" role="alert">
                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                {{--            <div class="outgoing-video"></div>--}}
                {{--<div class="incoming-video h-75">
                    <div class="name ">Alex Johns</div>
                    <div class="controls ">
                        <button class="btn btn-danger">
                            <i class="fas fa-microphone-slash"></i>
                        </button>
                        <button class="btn btn-success">
                            <i class="fas fa-video"></i>
                        </button>
                        <img src="images/video.jpg" class="media align-middle"\>
                    </div>
                </div>--}}
            </div>
            <div class="col-md-3 chat-area">
                <div id="message-list" class="chats p-2" >
{{--                    <div class="message-container incoming">
                        <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                        <div class="chatter-message">
                            <p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p>
                        </div>
                    </div>
                    <div class="message-container outgoing">
                        <div class="chatter-details"><div class="chatter-name">Alex </div><small class="text-muted">3 Min ago</small></div>
                        <div class="chatter-message">
                            <p>Convey meaning through color with a handful of color utility classes. Includes support for <br> <strong><a href="#"> <i class="far fa-file-pdf text-danger"></i> styling.pdf</a> </strong> </p>
                        </div>
                    </div>
                    <p class="chat-devider"><span>Thursday Jan 25 2018</span></p>
                    <div class="message-container incoming">
                        <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                        <div class="chatter-message">
                            <p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p>
                        </div>
                    </div>
                    <div class="message-container outgoing">
                        <div class="chatter-details"><div class="chatter-name">Alex </div><small class="text-muted">3 Min ago</small></div>
                        <div class="chatter-message">
                            <p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p>
                        </div>
                    </div>
                    <p class="chat-devider"><span>Thursday Jan 25 2018</span></p>
                    <div class="message-container incoming">
                        <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                        <div class="chatter-message">
                            <p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p>
                        </div>
                    </div>--}}
                </div>

                <div class="chat-form p-3">
                    <form class="">
                        <div class="form-group">
                            <div id="select-media-btn"  class="btn btn-link attachment">
                                <i class="fas fa-paperclip"></i>
                                <input type="file" id="select-media-file" style="display:none">
                            </div>
                            <textarea id = "input-text" class="form-control"   rows="3" placeholder="Write your Message..."></textarea>
                        </div>
                        <div class="">
                            <div id="send-btn"  class="btn btn-primary ">Send</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('twilio_room_js')

    <!-- video -->

    <script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <script>
        let isFirst = true;
        Twilio.Video.createLocalTracks({
            audio: true,
            video: { width: 250, height: 150 }
        }).then(function(localTracks) {
            return Twilio.Video.connect('{{ $access_token }}', {
                name: '{{ $twilio_room_unique_name }}',
                tracks: localTracks,
                video: { width: 250, height: 150 }
            });
        }).then(function(room) {
            console.log('Successfully joined a Room: ', room.name);
            room.participants.forEach(participantConnected);
            var previewContainer = document.getElementById(room.localParticipant.sid);
            if (!previewContainer || !previewContainer.querySelector('video')) {
                participantConnected(room.localParticipant);
            }
            room.on('participantConnected', function(participant) {
                console.log("Joining: '"  + participant.identity  + "'");
                participantConnected(participant);
            });
            room.on('participantDisconnected', function(participant) {
                console.log("Disconnected: '"  + participant.identity  + "'");
                participantDisconnected(participant);
            });
        });
        // additional functions will be added after this point
        function participantConnected(participant) {
            console.log('Participant "%s" connected', participant.identity);

            const div = document.createElement('div');
            div.id = participant.sid;
            console.log(' Slug %s',participant.identity.substring(0,3));
            if(participant.identity.substring(0,3).localeCompare("TUT")==0) {
                // creating tutor video div which is local video div
                div.classList.add("outgoing-video");
            }
            if(participant.identity.substring(0,3).localeCompare("STU")==0){
                // creating student video div which is from twilio
                div.classList.add("incoming-video");
                div.classList.add("h-75");
                const nameDiv = document.createElement('div');
                nameDiv.classList.add('name');
                nameDiv.innerHTML += participant.identity;
                div.appendChild(nameDiv);
                // controls button div
                const controlsDiv = document.createElement('div');
                controlsDiv.classList.add('controls');
                // mic button
                const btnMic = document.createElement('button');
                btnMic.classList.add('btn');
                btnMic.classList.add('btn-danger');
                const microphoneItem = document.createElement('i');
                microphoneItem.classList.add('fas');
                microphoneItem.classList.add('fa-microphone-slash');
                btnMic.appendChild(microphoneItem);
                // video btn
                const btnVid = document.createElement('button');
                btnVid.classList.add('btn');
                btnVid.classList.add('btn-success');
                const videoItem = document.createElement('i');
                videoItem.classList.add('fas');
                videoItem.classList.add('fa-video');
                btnVid.appendChild(videoItem);
                // call end btn
                const btnCEnd = document.createElement('button');
                btnCEnd.classList.add('btn');
                btnCEnd.classList.add('btn-danger');
                btnCEnd.setAttribute('onClick', "" +
                    "event.preventDefault(); " +
                    "document.getElementById('session-end"+participant.identity +"').submit(); ");
                const endItem = document.createElement('i');
                endItem.classList.add('fas');
                endItem.classList.add('fa-times');
                btnCEnd.appendChild(endItem);
                controlsDiv.appendChild(btnMic);
                controlsDiv.appendChild(btnVid);
                controlsDiv.appendChild(btnCEnd);
                div.appendChild(controlsDiv);
                // a post from for end session
                const endCallFrom =  document.createElement("form");
                endCallFrom.setAttribute('id',"session-end"+participant.identity);
                endCallFrom.setAttribute('method',"post");
                endCallFrom.setAttribute('action',"{{ route('tutor.learning.session.complete') }}");
                endCallFrom.setAttribute('style', "display: none;");
                const csrfToken = document.createElement("input"); //input element, text
                csrfToken.setAttribute('type',"hiden");
                csrfToken.setAttribute('name',"_token");
                csrfToken.setAttribute('value',"{{csrf_token()}}");
                endCallFrom.appendChild(csrfToken);
                const twilioRoomSid = document.createElement("input"); //input element, text
                twilioRoomSid.setAttribute('type',"hiden");
                twilioRoomSid.setAttribute('name',"twilio_room_sid");
                twilioRoomSid.setAttribute('value',"{{$twilio_room_sid}}");
                endCallFrom.appendChild(twilioRoomSid);
                div.appendChild(endCallFrom);
            }
            participant.tracks.forEach(function(track) {
                trackAdded(div, track)
            });
            participant.on('trackAdded', function(track) {
                trackAdded(div, track)
            });
            participant.on('trackRemoved', trackRemoved);
            // adding div to media-div
            document.getElementById('media-div').appendChild(div);
        }

        function participantDisconnected(participant) {
            console.log('Participant "%s" disconnected', participant.identity);
            participant.tracks.forEach(trackRemoved);
            document.getElementById(participant.sid).remove();

            // if session is 1 to 1
            location.href = '{{route('tutor.dashboard')}}';
        }

        function trackAdded(div, track) {
            div.appendChild(track.attach());
            var video = div.getElementsByTagName("video")[0];
            if (video) {
                if(isFirst){
                    video.setAttribute("style", "max-width:250px; max-height:150px");
                    video.classList.add('media');
                    video.classList.add('align-middle');
                    isFirst = false;
                }else{
                    /*                    video.setAttribute("style", "height:669px;");*/
                    video.classList.add('media');
                    video.classList.add('align-middle');
                }
            }
        }

        function trackRemoved(track) {
            track.detach().forEach( function(element) { element.remove() });
        }
    </script>


    <!-- msg temp-->
    <script type="text/html" id ="message-template">
        <div class="chatter-details">
            <div class="chatter-name" data-content="username"></div>
            <small class="text-muted" data-content="date"></small>
        </div>
        <div class="chatter-message">
            <p data-content="body"></p>
        </div>
    </script>

    <!-- chat -->
    <!-- Twilio Common helpers and Twilio Chat JavaScript libs from CDN. -->
{{--        <script src="http://media.twiliocdn.com/sdk/js/common/releases/0.1.7/twilio-common.min.js"></script>
        <script src="https://media.twiliocdn.com/sdk/js/chat/releases/2.2.0/twilio-chat.js"></script>--}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery-throttle.min.js') }}"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery.loadTemplate-1.4.4.min.js') }}"></script>
    <script src="//media.twiliocdn.com/sdk/js/common/releases/0.1.5/twilio-common.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/chat/releases/0.11.1/twilio-chat.js"></script>
{{--    <script src="{{asset('assets/tutor/js/twiliochat.js')}}"></script>--}}
    <script src="{{ asset('assets/tutor/js/dateformatter.js') }}"></script>
    <script>
        var tc = {};
        tc.currentChannel = "";

        // var GENERAL_CHANNEL_UNIQUE_NAME = 'general';
        // var GENERAL_CHANNEL_NAME = 'General Channel';
        var GENERAL_CHANNEL_UNIQUE_NAME = "{{$twilio_chat_channel_unique_name}}";
        var GENERAL_CHANNEL_NAME = "{{$twilio_chat_channel_friendly_name}}";
        var MESSAGES_HISTORY_LIMIT = 50;


        var $inputText;
        var $mediaFile;
        var $sendBtn;
        var $mediaBtn;
        $(document).ready(function() {
            ///////////////////////////////Request to track///////////////////////////////
            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            $.ajax({
                url: '{{route('tutor.learning.session.track')}}',
                type: "POST",
                data:{
                    'learningSession_id' : '{{$learningSession_id}}'
                },
                success: function (response) {
                    console.log("response: " + JSON.stringify(response));
                    // if session is 1 to 1  and student slots are end
                    location.href = '{{route('tutor.dashboard')}}';
                },
                error:function (error) {
                    console.log('Error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                },
                timeout: 0 // no time out
            });
            /////////////////////////////////////////////////////////////////////////
            tc.$messageList = $('#message-list');
            $mediaBtn = $('#select-media-btn');
                $mediaBtn.on('click', function () {
                    document.getElementById("select-media-file").click();
                });
             $mediaFile = $('#select-media-file');
            $inputText = $('#input-text');
            // send msg on enter in text area
            $inputText.on('keypress', handleInputTextKeypress);
            $sendBtn = $('#send-btn');
            // send msg on send-btn
            $sendBtn.on('click', function (event) {
                tc.currentChannel.sendMessage($inputText.val());
                event.preventDefault();
                $inputText.val('');
            });

            // fetching token
            fetchAccessToken('{{ Auth::user()->name}}', connectMessagingClient);
        });

        // send msg on enter in text area
        function handleInputTextKeypress(event) {
            if (event.keyCode === 13) {
                tc.currentChannel.sendMessage($(this).val());
                event.preventDefault();
                $(this).val('');
            }
            else {
                // notifyTyping();
            }
        }

        function fetchAccessToken(username, handler) {
            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            $.post('{{route('tutor.learning.session.chat.token')}}',
                {
//                    'identity': username,
                    'device': 'browser'
                },
                function(response) {
                    console.log("token " + response.token);
                    tc.username = response.identity;
                    handler(response.token);
                }, 'json')
                .fail(function(error) {
                    console.log('Failed to fetch the Access Token with error: ' + JSON.stringify(error));
                    console.log(error.responseText);
                    $('body').html(error.responseText);
                });
        }

        function connectMessagingClient(token) {
            // Initialize the IP messaging client
            tc.accessManager = new Twilio.AccessManager(token);
            tc.messagingClient = new Twilio.Chat.Client(token);
            tc.messagingClient.initialize()
                .then(function() {
                    tc.loadChannelList(tc.joinGeneralChannel);
                });
        }

        tc.loadChannelList = function(handler) {
            if (tc.messagingClient === undefined) {
                console.log('Client is not initialized');
                return;
            }

            tc.messagingClient.getPublicChannels().then(function(channels) {
                // tc.channelArray = tc.sortChannelsByName(channels.items);
                tc.channelArray = channels.items;
                tc.channelArray.forEach(addChannel);
                if (typeof handler === 'function') {
                    handler();
                }
            });
        };

        tc.joinGeneralChannel = function() {
            console.log('Attempting to join "general" chat channel...');
            if (!tc.generalChannel) {
                // If it doesn't exist, let's create it
                tc.messagingClient.createChannel({
                    uniqueName: GENERAL_CHANNEL_UNIQUE_NAME,
                    friendlyName: GENERAL_CHANNEL_NAME
                }).then(function(channel) {
                    console.log('Created general channel');
                    tc.generalChannel = channel;
                    tc.loadChannelList(tc.joinGeneralChannel);
                });
            }
            else {
                console.log('Found general channel:');
                setupChannel(tc.generalChannel);
            }
        };

        function initChannel(channel) {
            console.log('Initialized channel ' + channel.friendlyName);
            return tc.messagingClient.getChannelBySid(channel.sid);
        }

        function joinChannel(_channel) {
            console.log('joining channel');
            return _channel.join()
                .then(function(joinedChannel) {
                    console.log('Joined channel ' + joinedChannel.friendlyName);
                    tc.currentChannel = _channel;
                    tc.loadMessages();
                    console.log('joined channel');
                    return joinedChannel;
                });
        }

        function initChannelEvents() {
            console.log(tc.currentChannel.friendlyName + ' ready.');
            tc.currentChannel.on('messageAdded', tc.addMessageToList);
            $inputText.prop('disabled', false).focus();
        }

        function setupChannel(channel) {
            return leaveCurrentChannel()
                .then(function() {
                    return initChannel(channel);
                })
                .then(function(_channel) {
                    return joinChannel(_channel);
                })
                .then(initChannelEvents);
        }

        tc.loadMessages = function() {
            tc.currentChannel.getMessages(MESSAGES_HISTORY_LIMIT).then(function (messages) {
                messages.items.forEach(tc.addMessageToList);
            });
        };

        function leaveCurrentChannel() {
            if (tc.currentChannel) {
                return tc.currentChannel.leave().then(function(leftChannel) {
                    console.log('left ' + leftChannel.friendlyName);
                    leftChannel.removeListener('messageAdded', tc.addMessageToList);
                });
            } else {
                return Promise.resolve();
            }
        }

        tc.addMessageToList = function(message) {
            var msgDiv = $('<div>').addClass('message-container');
            msgDiv.loadTemplate($('#message-template'), {
                username: message.author.split('!#')[0].replace("_", " "), //Test_Account!#1001 to Test Account
                date: dateFormatter.getTodayDate(message.timestamp),
                body: message.body
            });
            if (message.author === tc.username) {
                msgDiv.addClass('outgoing');
            }else {
                msgDiv.addClass('incoming');
            }

            tc.$messageList.append(msgDiv);
            scrollToMessageListBottom();
        };

        // during testing with farrukh bhai:27:jan:2018
        // tc.sortChannelsByName = function(channels) {
        //     return channels.sort(function(a, b) {
        //         if (a.friendlyName === GENERAL_CHANNEL_NAME) {
        //             return -1;
        //         }
        //         if (b.friendlyName === GENERAL_CHANNEL_NAME) {
        //             return 1;
        //         }
        //         return a.friendlyName.localeCompare(b.friendlyName);
        //     });
        // };
        function addChannel(channel) {
            if (channel.uniqueName === GENERAL_CHANNEL_UNIQUE_NAME) {
                tc.generalChannel = channel;
            }
        }
        function scrollToMessageListBottom() {
            tc.$messageList.scrollTop(tc.$messageList[0].scrollHeight);
        }
    </script>

    {{--End session on back button--}}
    <script>
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

                        var r = confirm("Would you like to end video session?");
                        if(r==true) {
                            $.ajax({
                                url: '{{ route('tutor.learning.session.complete') }}',
                                type: "POST",
                                data: {
                                    "_token" : "{{csrf_token()}}",
                                    "twilio_room_sid" : "{{$twilio_room_sid}}",
                                },
                                success: function (response) {
                                    console.log("response: " + JSON.stringify(response));
                                },
                                error:function (error) {
                                    console.log('Error: ' + JSON.stringify(error));
                                    console.log(error.responseText);
                                }
                            });

                        } else {

                        }
                        // reset state
                        history.go(-state);
                    }
                }, false);
            }, false);
        }
    </script>
@endsection
