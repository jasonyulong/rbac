// bootstrap响应式导航条 
(function ($, window, undefined) {
    var $allDropdowns = $();
    $.fn.dropdownHover = function (options) {
        $allDropdowns = $allDropdowns.add(this.parent());
        return this.each(function () {
            var $this = $(this).parent(),
                defaults = {
                    delay: 500,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                options = $.extend(true, {}, defaults, options, data),
                timeout;
            $this.hover(function () {
                if (options.instantlyCloseOthers === true) $allDropdowns.removeClass('open');
                window.clearTimeout(timeout);
                $(this).addClass('open');
            }, function () {
                timeout = window.setTimeout(function () {
                    $this.removeClass('open');
                }, options.delay);
            });
        });
    };
    $('[data-hover="dropdown"]').dropdownHover();
})(jQuery, this);

// 菜单
$(function () {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    var documentHeight = $(document).height();
    $("#page-wrapper").css("min-height", (documentHeight) + "px");

    $(window).bind("load resize", function () {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;

        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function () {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
