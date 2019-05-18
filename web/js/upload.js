$(document).ready(function () {
    "use strict";
    $(".upload-form").on('submit', (function (e) {
        e.preventDefault();
        let form = $(this);
        let err = form.parent().find('.err');
        $.ajax({
            url: "/course/upload",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                err.fadeOut();
            },
            success: function (data) {
                if (data == 'invalid') {
                    err.html("Érvénytelen fájl formátum!").fadeIn();
                } else {
                    location.reload();
                }
            },
            error: function (e) {
                err.html(e).fadeIn();
            }
        });
    }));
});