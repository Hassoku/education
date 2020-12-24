var twiliochat = (function() {
  var tc = {};
    tc.username = "Furqan Talpur";

  var GENERAL_CHANNEL_UNIQUE_NAME = 'general';
  var GENERAL_CHANNEL_NAME = 'General Channel';
  var MESSAGES_HISTORY_LIMIT = 50;


  var $inputText;
  var $sendBtn;
  $(document).ready(function() {
    tc.$messageList = $('#message-list');
    $inputText = $('#input-text');
    // send msg on enter in text area
    $inputText.on('keypress', handleInputTextKeypress);
    $sendBtn = $('#send-btn');
    // send msg on send-btn
    $sendBtn.on('click', function () {
        tc.currentChannel.sendMessage($(this).val());
        event.preventDefault();
        $(this).val('');
    });
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


  function connectMessagingClient(token) {
    // Initialize the IP messaging client
    tc.accessManager = new Twilio.AccessManager(token);
    tc.messagingClient = new Twilio.Chat.Client(token);
    tc.messagingClient.initialize()
      .then(function() {
        updateConnectedUI();
        tc.loadChannelList(tc.joinGeneralChannel);
        tc.messagingClient.on('tokenExpired', refreshToken);
      });
  }

  function updateConnectedUI() {
    tc.$messageList.addClass('connected').removeClass('disconnected');
    $inputText.addClass('with-shadow');
  }
  tc.loadChannelList = function(handler) {
    if (tc.messagingClient === undefined) {
      console.log('Client is not initialized');
      return;
    }

    tc.messagingClient.getPublicChannels().then(function(channels) {
      tc.channelArray = tc.sortChannelsByName(channels.items);
      $channelList.text('');
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
    return _channel.join()
      .then(function(joinedChannel) {
        console.log('Joined channel ' + joinedChannel.friendlyName);
        tc.currentChannel = _channel;
        tc.loadMessages();
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
      username: message.author,
      date: dateFormatter.getTodayDate(message.timestamp),
      body: message.body
    });
    if (message.author === tc.username) {
      msgDiv.addClass('outgoing');
    }else {
        msgDiv.addClass('incoming');
    }

    tc.$messageList.append(rowDiv);
    scrollToMessageListBottom();
  };

  function scrollToMessageListBottom() {
    tc.$messageList.scrollTop(tc.$messageList[0].scrollHeight);
  }

  return tc;
})();
