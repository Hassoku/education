@extends('tutor.layout.app')
@section('pageTitle', 'Communication')
@section('body_class_atr')class="main"@endsection
@section('tutor_layout_topnavbar')
    @include('tutor.layout.topnavbar',['is_from_individual_chat' => true])
@endsection
@section('content')
    <main role="main">
        @include('tutor.communication',[
            'is_from_individual_chat' => true,
            'student' => $student,
            'chatCollection' => $chatCollection,
            'twilio_chat_access' => $twilio_chat_access,
            'twilio_chat_channel_sid' => $twilio_chat_channel_sid,
            'twilio_chat_channel_unique_name' => $twilio_chat_channel_unique_name,
            'twilio_chat_channel_friendly_name' => $twilio_chat_channel_friendly_name
        ])
        @include('tutor.layout.footer') {{--including footer--}}
    </main>
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery-throttle.min.js') }}"></script>
    <script src="{{ asset('assets/tutor/js/vendor/jquery.loadTemplate-1.4.4.min.js') }}"></script>
        <script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
        <script src="https://media.twiliocdn.com/sdk/js/chat/v2.2/twilio-chat.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/common/releases/0.1.5/twilio-common.js"></script>
{{--    <script src="//media.twiliocdn.com/sdk/js/chat/releases/0.11.1/twilio-chat.js"></script>--}}
    <script src="{{ asset('assets/tutor/js/dateformatter.js') }}"></script>
    <script>
            var tc = {};
            tc.currentChannel = "";

            var GENERAL_CHANNEL_UNIQUE_NAME = "{{$twilio_chat_channel_unique_name}}";
            var GENERAL_CHANNEL_NAME = "{{$twilio_chat_channel_friendly_name}}";
            var MESSAGES_HISTORY_LIMIT = 50;

            var $inputText;
            var $mediaFile;
            var $fileShowDiv = $('#file-show-div');
            var $sendBtn;
            var $mediaBtn;

            tc.$messageList = $('#message-list');
            $mediaBtn = $('#select-media-btn');
            $mediaBtn.on('click', function () {
                document.getElementById("select-media-file").click();
            });
            $mediaFile = $('#select-media-file');
            $mediaFile.change(function (e) {
                var fileName = e.target.files[0].name;
                var content =
                    "<p>" +
                    "<i class=\"far fa-file text-danger\"></i> "+fileName+
                    "</p>" +
                    "<div class=\"btn btn-link text-danger\" onclick='removeSelectedFile()'><i class=\"fas fa-times\"></i></div>";
                $fileShowDiv.html(content);
            });
            function removeSelectedFile() {
                $fileShowDiv.html("");
                $mediaFile.val('');
            }

            $inputText = $('#input-text');
            // send msg on enter in text area
            $inputText.on('keypress', handleInputTextKeypress);
            $sendBtn = $('#send-btn');
            // send msg on send-btn
            $sendBtn.on('click', function (event) {

                if($mediaFile.val().localeCompare('') == 0){
                    // simple message
                    if($inputText.val().localeCompare("") == 0){
                        // empty
                    }else{
                        tc.currentChannel.sendMessage($inputText.val());
                        event.preventDefault();
                        $inputText.val('');
                    }
                }else{
                    // file selected
                    const formData = new FormData();
                    formData.append('file', $mediaFile[0].files[0]);
                    tc.currentChannel.sendMessage(formData);
                    // empty
                    removeSelectedFile()
                }
            });

            tc.username = '{{$twilio_chat_access["identity"]}}';
            connectMessagingClient('{{$twilio_chat_access["token"]}}');
            /////////////////////////////////////////

            // send msg on enter in text area
            function handleInputTextKeypress(event) {
                if (event.keyCode === 13) {
                    // simple message
                    if($inputText.val().localeCompare("") == 0){
                        // empty message
                    }else{
                        tc.currentChannel.sendMessage($inputText.val());
                        event.preventDefault();
                        $inputText.val('');
                    }
                }
                else {
                    // notifyTyping();
                }
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

                tc.messagingClient.getSubscribedChannels().then(function(channels) {
                //tc.messagingClient.getPublicChannelDescriptors().then(function(channels) {
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
                        tc.generalChannel = channel;
                        tc.loadChannelList(tc.joinGeneralChannel);
                    }).catch(function (error) {
                        tc.messagingClient.getChannelByUniqueName(GENERAL_CHANNEL_UNIQUE_NAME)
                            .then(function (channel) {
                                tc.generalChannel = channel;
                                tc.loadChannelList(tc.joinGeneralChannel);
                            });
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
                        //return joinedChannel;
                    }).catch(function (error) {
                        tc.currentChannel = _channel;
                        tc.loadMessages();
                        return _channel;
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
@endsection
