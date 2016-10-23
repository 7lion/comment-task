var post_comment_url = '/_/comments';
var get_comments_url = '/_/comments';

$("body").on("submit", "#comment", function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        dataType: "json",
        url: post_comment_url,
        data: $(this).serialize()
    }).fail(function (jqXHR, textStatus, errorThrown) {
        printError(jqXHR);
        refreshCaptcha();
    }).done(function (response) {
        var html = '<div class="alert alert-success">Comment added</div>';
        $('.add-comment').find('.error').empty().append(html);
        $('#comment')[0].reset();
        loadComments();
    });
});

$(document).ready(function () {
    loadComments();
});

function loadComments() {
    $.ajax({
        method: "get",
        dataType: "json",
        url: get_comments_url
    }).fail(function (jqXHR) {
        printError(jqXHR);
    }).done(function (response) {
        $("#list-comment").empty();

        response.forEach(function (object) {
            var html =
                '<div class="col-sm-1">' +
                '   <div class="thumbnail">' +
                '       <img class="img-responsive user-photo" src="/avatar.png">' +
                '   </div>' +
                '</div>' +
                '<div class="col-sm-5">' +
                '   <div class="panel panel-default">' +
                '       <div class="panel-heading">' +
                '           <strong>' + object.user.name + '</strong>' +
                '            ' + object.user.email +
                '           <span class="text-muted">commented ' + timeSince(new Date(object.createdAt)) + ' ago</span>' +
                '       </div>' +
                '        <div class="panel-body">' +
                '            ' + object.text + '' +
                '       </div>' +
                '   </div>' +
                '</div>';
            $("#list-comment").append(html);
        });
    });
}

function refreshCaptcha() {
    var captchaSrc = $(".captcha_image").attr("src");
    $(".captcha_image").attr("src", captchaSrc + "&time=" + Math.random());
}

function printError(jqXHR) {
    $(".error").empty();

    if (jqXHR.status === 422) {
        $.each(jqXHR.responseJSON, function(field, message) {
            var html = '<div class="alert alert-danger">' +
                '<strong>' + field + '</strong> ' +
                '' + message + '</div>';
            $(".error").append(html);

        });
    } else {
        $(".error").append('<div class="alert alert-danger">Error code - ' + object.status + '</div>');
    }
}

function timeSince(date) {
    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = Math.floor(seconds / 31536000);
    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}