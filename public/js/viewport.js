(function($) {

    $.fn.isOnScreen = function(options) {

        var settings = $.extend({
            increase: 650
        }, options);

        var win = $(window);

        //aumenta viewport;

        var viewport = {
            top: win.scrollTop() + settings.increase,
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };

}(jQuery));
