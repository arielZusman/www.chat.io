function updateUserList(users) {
    var userEl = '';
    var $users = $('.users');
    $users.empty();
    for (var userID in users) {
        if (users.hasOwnProperty(userID)) {
            userEl = '<li class="user__item userID-';
            userEl += userID + '">';
            userEl += users[userID] + '</li>';
            $users.append(userEl);
        }
    }
}
$(document).ready(function() {
    "use strict";
    // var wsUrl = "ws://127.0.0.1:5000/chatServer2.php";    
    var wsUrl = "ws://www.chat.io:5000/src/core/chatServer2.php";
    var ws = new WebSocket(wsUrl);
    ws.onopen = function(evt) {
        console.log(ws);
        // var msg = JSON.stringify({
        //     action: 'getOnlineUsers',
        //     msg: ''
        // });
        // ws.send(msg);
    };
    ws.onclose = function(evt) {
        console.log(evt);
        console.log('Closed');
    };
    ws.onmessage = function(evt) {
        console.log(evt);
        var msg = JSON.parse(evt.data);
        if ('online' in msg) {
            console.log(msg.online);
            updateUserList(msg.online);
        }
    };
    ws.onerror = function(evt) {
        console.log(evt);
    };
    $('.loginForm').submit(function(e) {
        e.preventDefault();
        var msg = JSON.stringify({
            action: 'login',
            msg: $('#username').val()
        });
        ws.send(msg);
    });
});