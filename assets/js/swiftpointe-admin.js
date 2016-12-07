var test = [];

(function ($) {
    $('.swp-print .tab-label').click(function (e) {
        $('.swp-print .tab-label.active').removeClass('active');
        $(this).addClass('active');
        $('.swp-print .tab.active').removeClass('active');
        $('#' + $(this).data('target')).addClass('active');
    });

    $('[name="swp_submit_button"]').prop("disabled", false);
    $('#swp-form').ajaxForm({
        beforeSubmit: function (arr, $form, options) {
            var swp_print_header_html = arr.filter(function (elem) {
                return elem.name == 'swp_print_header_html';
            });
            var swp_print_footer_html = arr.filter(function (elem) {
                return elem.name == 'swp_print_footer_html';
            });

            if (tinyMCE.get('swp_print_header_html')) {
                swp_print_header_html[0].value = tinyMCE.get("swp_print_header_html").save();
            } else {
                swp_print_header_html[0].value = $('#swp_print_header_html').val();
            }

            if (tinyMCE.get('swp_print_footer_html')) {
                swp_print_footer_html[0].value = tinyMCE.get("swp_print_footer_html").save();
            } else {
                swp_print_footer_html[0].value = $('#swp_print_footer_html').val();
            }
        },
        success: function (data) {
            if (data) {
                console.log(data.success);
                alert("Options Saved!");
            }
        }
    });


    $('#swp-print-color').ColorPicker({
        onSubmit: function (hsb, hex, rgb, el) {
            $(el).val(hex);
            $(el).ColorPickerHide();
        },
        onChange: function (hsb, hex, rgb) {
            $('#swp-print-color').css('backgroundColor', '#' + hex);
            $('#swp-print-color').val('#' + hex);
        },
        onBeforeShow: function () {
            $('#swp-print-color').ColorPickerSetColor(this.value);
        }
    })

    /* General rules for all the switches in demo 5 */
    new DG.OnOffSwitchAuto({
        cls: '.custom-switch',
        textOn: "YES",
        height: 24,
        textOff: "NO",
        textSizeRatio: 0.35
    });

})(jQuery);