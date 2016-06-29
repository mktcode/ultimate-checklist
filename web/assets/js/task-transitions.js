$(function() {
    'use strict';
    var smoothStateContainer = $('#content'),
        transition = 'next';
    smoothStateContainer.smoothState({
        prefetch: true,
        onBefore: function($anchor, $container) {
            transition = $anchor.data('animation');
            console.log('before');
        },
        onStart: {
            duration: 500,
            render: function ($container) {
                if (transition == 'next') {
                    $container.find('#task').addClass('uk-animation-slide-left uk-animation-reverse');
                } else {
                    $container.find('#task').addClass('uk-animation-slide-right uk-animation-reverse');
                }
            }
        },
        onReady: {
            duration: 500,
            render: function ($container, $newContent) {
                $container.html($newContent);
                if (transition == 'next') {
                    $container.find('#task').addClass('uk-animation-slide-right');
                } else {
                    $container.find('#task').addClass('uk-animation-slide-left');
                }
            }
        },
        onAfter: function($container, $newContent) {
            $container.find('#task').removeClass('uk-animation-slide-right uk-animation-slide-left');
        }
    });
});