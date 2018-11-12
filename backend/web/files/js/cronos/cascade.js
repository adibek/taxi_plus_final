$(function() {
    $('body').off('click', '.cascade-open');
    $('body').on('click', '.cascade-open', function (e) {
        e.preventDefault();
        var current = $(this);
        var child = current.parent().parent().find('ul').first();
        if (current.hasClass('closed')) {
            child.show(function () {});
            current.removeClass("closed");
            current.find('i').removeClass('icon-arrow-right32');
            current.find('i').addClass('icon-arrow-down32');
        } else {
            child.hide(function () {});
            current.addClass("closed");
            current.find('i');
            current.find('i').removeClass('icon-arrow-down32');
            current.find('i').addClass('icon-arrow-right32');
        }
    });

    dragula([document.getElementById('media-list-target-left'), document.getElementById('media-list-target-right')], {
        //moves: moves
        mirrorContainer: document.querySelector('.media-list-container'),
        moves: function (el, container, handle) {
            return handle.classList.contains('dragula-handle');
        }
    }).on('drop', drop);
    /*dragula([document.getElementById('media-list-target-left'), document.getElementById('media-list-target-right')], {
        mirrorContainer: document.querySelector('.media-list-container'),

    });*/
    function moves (el, from) {
        //return from === a;
    }
    function drop (el, to, from) {
        //var id = el.data("id");
        //if (to === b) {
        //     el.parentElement.removeChild(el);
        //  }
        console.log(el.id);
    }
});