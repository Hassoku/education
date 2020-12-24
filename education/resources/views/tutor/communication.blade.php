
<div id="communications" class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-3 ">
            <div class="left-area pl-3">
                {{--search--}}
                <div class="input-group search mt-3">
                    <input type="text" class="form-control" placeholder="Search Conversations">
                    <span class="input-group-append">
                       <button class="btn btn-outline-success" type="button">
                           <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>

                {{--Select Dropdown--}}
                <div class="text-right my-3">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Recent
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>

                {{--Chat list--}}
                <ul class="list-group mb-3">
                    @foreach($chatCollection as $chat)
                        <li class="list-group-item {{($chat->student->id == $student->id) ? 'active ' : ''}}"{{-- onclick="loadChat('{{$chat->twilio_chat_channel_unique_name}}','{{$chat->twilio_chat_channel_friendly_names}}')"--}}>
                            <a  class="text-dark" href="{{route('individual.chat',['student_id' => $chat->student->id,'device' => 'browser'])}}">
                                <div>
                                    <div style="position: relative" class="m-0 text-truncate">
                                        <img src="{{asset($chat->student->profile->picture)}}" class="circle" alt="{{$chat->student->name}} {{$chat->student->last_name}}" style="width:25%; /*padding: 5%;*/ border-radius: 100px">
                                        <i style="position: absolute; left: 2px; bottom: 3px; color: rgba(0,0,0,.1); font-size: 18px" class="fas fa-circle"></i>
                                        <small style="position: absolute; left: 4px; bottom: 0px;" class=" {{'online-'.$chat->student->email}} {{ ($chat->student->online_status == 0) ? 'text-muted ' : 'text-success ' }}">
                                            <i class="fas fa-circle"></i>
                                        </small>
                                        {{ $chat->student->name}} {{ $chat->student->last_name}}
                                    </div>
                                    <small class="text-muted">{{ date('d/m/Y', strtotime($chat->created_at.'')) }}</small>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    {{--<li class="list-group-item active">
                        <div>
                            <h6 class="m-0 text-truncate">
                                <small class="text-success">
                                    <i class="fas fa-circle"></i>
                                </small>
                                Julia, Ali, Matthew chin and many more etc</h6>
                            <small class="text-muted">21/12/2017</small>
                            <div>Basic Mathematics</div>
                        </div>
                    </li>
                    <li class="list-group-item ">
                        <div>
                            <h6 class="m-0 text-truncate">
                                <small class="text-muted">
                                    <i class="fas fa-circle"></i>
                                </small>
                                Julia, Ali, Matthew chin and many more etc</h6>
                            <small class="text-muted">21/12/2017</small>
                            <div>Basic Mathematics</div>
                        </div>
                    </li>--}}
                </ul>
            </div>
        </div>

        {{--Conversation--}}
        <div class="col-md-9 border-right">
            <div class="d-flex justify-content-between p-2">
                <h2 class="mr-auto font-weight-light" > {{$student->name}} {{$student->last_name}}</h2>
            </div>

            {{--Chat--}}
            <div class="chat-area wide">

                {{--messages--}}
                <div id="message-list" class="chats p-2" >
                    {{--                    <div class="message-container incoming">
                                            <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                                            <div class="chatter-message"><p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p></div>
                                        </div>
                                        <div class="message-container outgoing">
                                            <div class="chatter-details"><div class="chatter-name">Alex </div>
                                                <small class="text-muted">3 Min ago</small>
                                            </div>
                                            <div class="chatter-message">
                                                <p>Convey meaning through color with a handful of color utility classes. Includes support for
                                                    <br>
                                                    <strong>
                                                        <a href="#">
                                                            <i class="far fa-file-pdf text-danger"></i>
                                                            styling.pdf
                                                        </a>
                                                    </strong>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="chat-devider">
                                            <span>Thursday Jan 25 2019</span>
                                        </p>
                                        <div class="message-container incoming">
                                            <div class="chatter-details"><div class="chatter-name">Alex </div> <small class="text-muted">3 Min ago</small></div>
                                            <div class="chatter-message"><p>Convey meaning through color with a handful of color utility classes. Includes support for styling links with hover states, too. </p></div>
                                        </div>
                                        <div class="message-container outgoing">
                                            <div class="chatter-details"><div class="chatter-name">Alex </div>
                                                <small class="text-muted">3 Min ago</small>
                                            </div>
                                            <div class="chatter-message">
                                                <p>Convey meaning through color with a handful of color utility classes. Includes support for
                                                    <br>
                                                    <strong>
                                                        <a href="#">
                                                            <i class="far fa-file-pdf text-danger"></i>
                                                            styling.pdf
                                                        </a>
                                                    </strong>
                                                </p>
                                            </div>
                                        </div>--}}
                </div>

                {{--send messages--}}
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
                            <div id = "file-show-div" class="d-flex justify-content-between">
                                {{--<p>
                                    <i class="far fa-file text-danger"> styling.pdf </i>
                                </p>
                                <a class="btn btn-link text-danger" href="#" role="button" data-toggle="modal" data-target="#edit"><i class="fas fa-times"></i></a>--}}
                            </div>
                            <div id="send-btn"  class="btn btn-primary ">Send</div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@if(isset($is_from_individual_chat))
    {{-- Set --}}
@else
    {{-- Not Set --}}
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
@endif

