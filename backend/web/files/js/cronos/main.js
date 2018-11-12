$(function() {
    /* ----- Загрузка любого контента AJAX ----- */
    var last_cslink = null;
    $('body').off('click', '.cs-link');
    $('body').on('click', '.cs-link', function (event) {
        event.preventDefault();
        var token = $('meta[name=csrf-token]').attr("content");
        var page = $(this).attr("href");
        if (last_cslink != null) {
            last_cslink.removeClass("active");
        }
        $("#" + page).parent().addClass("active");
        last_cslink = $("#" + page).parent();
        $.ajax({
            type: "POST",
            url: "/profile/loadajax/getpage/",
            data:{"_csrf-backend":token, page:page},
            status: startLoading("#dynamic_content"),
            success: function(data) {
                if (data != 101) {
                    $("#dynamic_content").html(data);
                    $("#dynamic_content").unblock();
                } else {
                    window.location.href = "/profile/authentication/";
                }
            },
        }).fail(function (xhr) {
            console.log(xhr. responseText);
        });
    });

    $('body').off('click', '.action-link');
    $('body').on('click', '.action-link', function (event) {
        event.preventDefault();
        var token = $('meta[name=csrf-token]').attr("content");
        var id = $(this).data("id");
        var info = $(this).data("info");
        var page = $(this).attr("href");
        $.ajax({
            type: "POST",
            url: "/profile/loadajax/getaction/",
            data:{"_csrf-backend":token, id:id, page:page, info:info},
            status: startLoading("#dynamic_content"),
            success: function(data) {
                if (data != 101) {
                    $("#dynamic_content").html(data);
                    $("#dynamic_content").unblock();
                } else {
                    window.location.href = "/profile/authentication/";
                }
            },
        }).fail(function (xhr) {
            console.log(xhr. responseText);
        });
    });

    $('body').on('click', '.filtr-link', function (event) {
        event.preventDefault();
        var token = $('meta[name=csrf-token]').attr("content");
        var id = $(this).data("id");
        var page = $(this).attr("href");
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "/profile/loadajax/filtrlink/",
            data:{"_csrf-backend":token, id:id, page:page},
            status: startLoading("#dynamic_content"),
            success: function(data) {
                if (data.type == "success") {
                    $('#' + page).trigger('click');
                } else {
                    window.location.href = "/profile/authentication/";
                }
            },
        }).fail(function (xhr) {
            console.log(xhr. responseText);
        });
    });

    function startLoading(block) {
        $(block).block({
            message: '<i class="icon-spinner4 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#3F9EC3',
                opacity: 1,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                color: '#fff',
                backgroundColor: 'transparent'
            }
        });
    }
});