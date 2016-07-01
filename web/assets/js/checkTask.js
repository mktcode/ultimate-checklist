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

            var meta = $('#check-meta');
            meta.removeClass('uk-hidden');
            meta.find('.date').text(check.date);
            meta.find('.user').text(check.user);
        });
    });
});