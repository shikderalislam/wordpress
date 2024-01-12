jQuery(document).ready(function($) {
    // Define default settings
    var settings = {
        color: 'linear-gradient(#4df8b6, #b94df7)',
        size: '10px',
        position: 'right', // or 'left'
    };

    // Check if custom settings exist in local storage
    if (localStorage.getItem('scrollbar-settings')) {
        settings = JSON.parse(localStorage.getItem('scrollbar-settings'));
    }

    // Apply custom settings
    var scrollbarStyle = '::-webkit-scrollbar-thumb {' +
        'background: ' + settings.color + ';' +
        'border-radius: 100px;' +
        'width: ' + settings.size + ';' +
        '}';
    var scrollbarPosition = settings.position === 'left' ? 'left' : 'right';

    $('<style>')
        .prop('type', 'text/css')
        .html('::-webkit-scrollbar {' +
            'background-color: transparent;' +
            'width: ' + settings.size + ';' +
            '}' +
            scrollbarStyle
        )
        .appendTo('head');

    // Scroll event
    $(window).scroll(function() {
        var scrollPosition = $(this).scrollTop();
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();

        var scrollPercentage = (scrollPosition / (documentHeight - windowHeight)) * 100;

        // Apply position style
        if (settings.position === 'left') {
            $('.animated-scroll-bar').css('left', '0');
        }

        $('.animated-scroll-bar').css('width', scrollPercentage + '%');
    });
});
