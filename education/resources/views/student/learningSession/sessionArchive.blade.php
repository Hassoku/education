@extends('student.layout.app')
@section('pageTitle', 'Session Archive')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <div class="container-fluid h-100">
        <div class="row h-100">
                <div class="col-md-9 session-area d-flex justify-content-around" id="media-div">
                    @if(!$recordingsCollection['error'])
                        @foreach($recordingsCollection as $identity => $recordings )
                            @if($identity == 'student')
                                <div class="outgoing-video">
                                    <video style="max-width:250px; max-height:150px" class="media align-middle" controls>
                                        <source id="myvideo" src="{{$recordings['media']['video']}}">
                                        <audio id="myaudio" controls>
                                            <source src="{{$recordings['media']['audio']}}"/>
                                        </audio>
                                    </video>
                                </div>
                            @elseif($identity == 'tutor')
                                <div class="incoming-video h-75">
                                    <div class="name ">{{$recordings['name']}}</div>
                                    <div class="controls ">
                                        <button class="btn btn-danger">
                                            <i class="fas fa-microphone-slash"></i>
                                        </button>
                                        <button class="btn btn-success">
                                            <i class="fas fa-video"></i>
                                        </button>
                                    </div>
                                    <video class="media align-middle" controls>
                                        <source id="myvideo" src="{{$recordings['media']['video']}}">
                                        <audio id="myaudio" controls>
                                            <source src="{{$recordings['media']['audio']}}"/>
                                        </audio>
                                    </video>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="text-align: center; color: white" class=" h-100">
                            {{$recordingsCollection['msg']}}
                        </div>
                    @endif
                </div>
                <div class="col-md-3 chat-area">
                    <div id="message-list" class="chats p-2" >
                                <!--div class="message-container incoming">
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
                                <div-- class="message-container incoming">
                                    <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                                    <div class="chatter-message">
                                        <p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p>
                                    </div>
                                </div-->
                    </div>

                    <div class="chat-form p-3">
                        <form class="">
                        </form>
                    </div>
                </div>
        </div>
        {{--including footer--}}
        @include('student.layout.footer')
    </div>
@endsection
@section('own_js')
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
        <script src="{{ asset('assets/student/js/vendor/jquery-throttle.min.js') }}"></script>
        <script src="{{ asset('assets/student/js/vendor/jquery.loadTemplate-1.4.4.min.js') }}"></script>
        <script src="//media.twiliocdn.com/sdk/js/common/releases/0.1.5/twilio-common.js"></script>
        <script src="//media.twiliocdn.com/sdk/js/chat/releases/0.11.1/twilio-chat.js"></script>
    {{--    <script src="{{asset('assets/student/js/twiliochat.js')}}"></script>--}}

        <script src="{{ asset('assets/student/js/dateformatter.js') }}"></script>
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
                $.post('{{route('student.learning.session.chat.token')}}',
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
                    tc.channelArray = tc.sortChannelsByName(channels.items);
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
            tc.sortChannelsByName = function(channels) {
                return channels.sort(function(a, b) {
                    if (a.friendlyName === GENERAL_CHANNEL_NAME) {
                        return -1;
                    }
                    if (b.friendlyName === GENERAL_CHANNEL_NAME) {
                        return 1;
                    }
                    return a.friendlyName.localeCompare(b.friendlyName);
                });
            };
            function addChannel(channel) {
                if (channel.uniqueName === GENERAL_CHANNEL_UNIQUE_NAME) {
                    tc.generalChannel = channel;
                }
            }
            function scrollToMessageListBottom() {
                tc.$messageList.scrollTop(tc.$messageList[0].scrollHeight);
            }
        </script>

        <script>
            var myvideo = document.getElementById("myvideo");
            var myaudio = document.getElementById("myaudio");
            myvideo.onplay  = function() { myaudio.play();  }
            myvideo.onpause = function() { myaudio.pause(); }
        </script>
@endsection
