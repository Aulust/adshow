!function ($) {
    'use strict';

    var SelectToggle = function (element) {
        this.$el = $(element);
        this.$selectOptions = this.$el.find('option');

        this.$el.on('change', function() {
            this.$selectOptions.each(function() {
                var target = $(this).attr('data-target');
                $(target).toggleClass('hidden');
            });
        }.bind(this));
    };

    /* PLUGIN DEFINITION
     * ============================== */

    $.fn.selectToggle = function (option) {
        return this.each(function () {
            new SelectToggle(this, option);
        });
    };

    /* DATA-API
     * ==================== */

    $(function () {
        $('[data-component=SelectToggle]').selectToggle();
    })
}(window.jQuery);
