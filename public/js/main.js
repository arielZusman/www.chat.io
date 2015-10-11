// TODO add validation for new username
var _self;
$(document).ready(function () {
    "use strict";

    var $form = $('.js-form');

    $form.submit(function(e){
        e.preventDefault();
        var args =$(this).serializeArray();
        $.ajax({
            url: '/public/user/login',
            method: 'POST',
            dataType: 'text',
            data: {
                username: args[0].value,
                token: args[1].value
            },
            success: function(data){
                console.log(data);
            }
        });


    });
});