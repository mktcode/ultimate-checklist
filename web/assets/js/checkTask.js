$(function () {
    $(document).on('click', '.check-task', function (e) {
        e.preventDefault();
        var btn = $(this);
        // btn.find('i').removeClass('uk-icon-square-o uk-icon-check-square-o').addClass('uk-icon-spinner uk-icon-spin');
        $.get(btn.attr('href'), function (check) {
            // btn.find('i').removeClass('uk-icon-spinner uk-icon-spin');
            check = $.parseJSON(check);
            if (check.checked) {
                btn.find('i').removeClass('uk-icon-square-o').addClass('uk-icon-check-square-o');
            } else {
                btn.find('i').removeClass('uk-icon-check-square-o').addClass('uk-icon-square-o');
            }

            // update meta (last change and user)
            var meta = $('#check-meta');
            meta.removeClass('uk-hidden');
            meta.find('.date').text(check.date);
            meta.find('.user').text(check.user);

            // update percentage of progressbar
            var progress = $('.uk-progress');
            progress.find('.uk-progress-bar').css('width', check.percentage + '%').text(check.percentage + '%');
            check.percentage == 100
                ? progress.addClass('uk-progress-success')
                : progress.removeClass('uk-progress-success')
            ;
        });
    });

    $(document).on('keyup', '#noteform textarea', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        delay(function(){
            $.post($('#noteform').attr('action'), data);
        }, 300);
    });

    var delay = (function() {
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
});