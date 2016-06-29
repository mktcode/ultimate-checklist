$(function() {
    'use strict';
    var smoothStateContainer = $('#content-wrapper'),
        transition = '';
    smoothStateContainer.smoothState({
        prefetch: true,
        onBefore: function($anchor, $container) {
            transition = $anchor.data('animation');
            console.log('before');
        },
        onStart: {
            duration: 500,
            render: function ($container) {
                if (transition == 'nextTask') {
                    $container.find('#task').addClass('uk-animation-slide-left uk-animation-reverse');
                } else if (transition == 'prevTask') {
                    $container.find('#task').addClass('uk-animation-slide-right uk-animation-reverse');
                } else {
                    $container.find('#content').addClass('uk-animation-slide-bottom uk-animation-reverse');
                }
            }
        },
        onReady: {
            duration: 500,
            render: function ($container, $newContent) {
                $container.html($newContent);
                if (transition == 'nextTask') {
                    $container.find('#task').addClass('uk-animation-slide-right');
                } else if (transition == 'prevTask') {
                    $container.find('#task').addClass('uk-animation-slide-left');
                } else {
                    $container.find('#content').addClass('uk-animation-slide-bottom');
                }
            }
        },
        onAfter: function($container, $newContent) {
            $container.find('#task').removeClass('uk-animation-slide-right uk-animation-slide-left uk-animation-reverse');
            $container.find('#content').removeClass('uk-animation-slide-bottom uk-animation-slide-top uk-animation-reverse');
        }
    });
});