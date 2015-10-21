//// TODO add validation for new username
//var _self;
//$(document).ready(function () {
//    "use strict";
//
//    var $form = $('.js-form');
//
//    $form.submit(function(e){
//        e.preventDefault();
//        var args =$(this).serializeArray();
//        $.ajax({
//            url: 'http://www.chat.io/public/user/login',
//            method: 'POST',
//            dataType: 'text',
//            data: {
//                username: args[0].value,
//                token: args[1].value
//            },
//            success: function(data){
//                console.log(data);
//            }
//        });
//
//
//    });
//});

//$(document).ready(function(){
    "use strict";

    var wsUrl = "ws://127.0.0.1:5000/www.chat.io/public/server.php";
    var ws = new WebSocket(wsUrl);

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
        console.log(evt.data);

    }
    function onError(evt){
        console.log(evt);
    }
    ws.onopen = function(evt) { onOpen(evt) };
    ws.onclose = function(evt) { onClose(evt) };
    ws.onmessage = function(evt) { onMessage(evt) };
    ws.onerror = function(evt) { onError(evt) };


//});