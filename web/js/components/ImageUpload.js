!function ($) {
    'use strict';

    var ImageUpload = function (element) {
        this.$inputBlock = $('.ImageUpload-InputBlock', element);
        this.$progress = $('.ImageUpload-Progress', element);
        this.$error = $('.ImageUpload-Error', element);
        this.$form = $('.ImageUpload-Form', element);
        this.$iframe = $('.ImageUpload-Iframe', element);
        this.$imageUrl = $('.ImageUpload-ImageUrl', element);
        this.$template = $('.ImageUpload-Input', this.$inputBlock).clone();

        this.$inputBlock.on('change', this.submit.bind(this));
        this.$iframe.on('load', this.onload.bind(this));
    };

    ImageUpload.prototype.submit = function() {
        var $input = $('.ImageUpload-Input', this.$inputBlock);
        this.$progress.removeClass('hidden');
        this.$error.addClass('hidden');

        this.$form.append($input);
        this.$form.submit();
    };

    ImageUpload.prototype.onload = function() {
        this.$form.empty();
        this.$template.clone().appendTo(this.$inputBlock);
        this.$progress.addClass('hidden');

        try {
            var resp = $.parseJSON(this.$iframe.contents().find("body").text());

            if(resp.status === 200) {
                this.$imageUrl.val(resp.data);
                return;
            }
        } catch (e) {}

        this.$error.removeClass('hidden');
    };

    /* PLUGIN DEFINITION
     * ============================== */

    $.fn.ImageUpload = function (option) {
        return this.each(function () {
            new ImageUpload(this, option);
        });
    };

    /* DATA-API
     * ==================== */

    $(function () {
        $('[data-component=ImageUpload]').ImageUpload();
    })
}(window.jQuery);
