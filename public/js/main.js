function onOpen(evt) {
    console.log(evt);
    console.log('Connected');
}

function onClose(evt){
    console.log(evt);
    console.log('Closed');
}

function onMessage(evt){
    console.log(evt);
    var msg = JSON.parse(evt.data);
    if ( 'online' in msg ) {
        console.log(msg.online);
        updateUserList(msg.online);
    } 
}
function onError(evt){
    console.log(evt);
}

function updateUserList(users){
    var userEl = '';
    var $users = $('.users');

    $users.empty();
    
    for (var userID in users) {
      if( users.hasOwnProperty( userID ) ) {        
        userEl = '<li class="user__item userID-';
        userEl += userID + '">';
        userEl += users[userID] + '</li>';
        $users.append(userEl);
      } 
    }    
}
$(document).ready(function(){
    "use strict";

    var wsUrl = "ws://127.0.0.1:5000/www.chat.io/public/chatServer2.php";
    var ws = new WebSocket(wsUrl);

    
    ws.onopen = function(evt) { onOpen(evt); };
    ws.onclose = function(evt) { onClose(evt); };
    ws.onmessage = function(evt) { onMessage(evt); };
    ws.onerror = function(evt) { onError(evt); };

    $('.loginForm').submit(function(e) {
        e.preventDefault();
        var msg = JSON.stringify({
            action: 'login',
            username: $('#username').val()
        });
        ws.send(msg);
    });
});