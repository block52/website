/* sizing Material selects with icons | addons */
var resizeSelect = function($select) {
    if ($select.parent('.select-wrapper')[0]) {
        var $selectWrapper = $select.parent('.select-wrapper'),
            addonsWidth = 0,
            inputLeft = 0;
        $selectWrapper.siblings('.addon-before, .icon-after, .addon-after').each(function() {
            addonsWidth += $(this).outerWidth();
            if ($(this).hasClass('addon-before')) {
                inputLeft += $(this).outerWidth() + 10;
            }
            if ($(this).hasClass('addon-before') || $(this).hasClass('addon-after')) {
                addonsWidth += 10;
            }
            if ($(this).hasClass('icon-after')) {
                $(this)
                    .siblings('.select-wrapper')
                    .find('.caret')
                    .css('right', '3rem');
            }
        });
        $selectWrapper.find('input.select-dropdown').attr('style', 'width:calc(100% - ' + addonsWidth + 'px) !important;margin-left:' + inputLeft + 'px');
    }
};
$(document).ready(function() {
    if ($('.addon-before, .addon-after, .icon-after')[0]) {
        $('.addon-before, .addon-after, .icon-after').each(function() {
            var addonsWidth = 0,
                inputLeft = 0;

            $(this)
                .siblings('.prefix, .addon-before, .addon-after')
                .addBack()
                .each(function() {
                    if (!$(this).hasClass('icon-before') || !$(this).siblings('.select-wrapper')[0]) {
                        addonsWidth += $(this).outerWidth();
                        if ($(this).hasClass('addon-before') || $(this).hasClass('addon-after')) {
                            addonsWidth += 10;
                        }
                        if ($(this).hasClass('addon-before') || $(this).hasClass('icon-before')) {
                            inputLeft += $(this).outerWidth();
                            if ($(this).hasClass('addon-before')) {
                                inputLeft += 10;
                            }
                        }
                    }
                });
            if ($(this).siblings('.select-wrapper')[0]) {
                $(this)
                    .siblings('.select-wrapper')
                    .find('input.select-dropdown')
                    .attr('style', 'width:calc(100% - ' + addonsWidth + 'px) !important;margin-left:' + inputLeft + 'px');
                if ($(this).hasClass('icon-after')) {
                    $(this)
                        .siblings('.select-wrapper')
                        .find('.caret')
                        .css('right', '3rem');
                }
            } else {
                $(this)
                    .siblings('.has-addon-before, .has-addon-after, .has-icon-after')
                    .css({ width: 'calc(100% - ' + addonsWidth + 'px)', 'margin-left': inputLeft + 'px' });
                $(this)
                    .siblings('.has-addon-before')
                    .nextAll('label')
                    .css({ 'margin-left': inputLeft + 'px' });
            }
        });
    }

    $('select').on('change', function() {
        if ($(this).siblings('.select-dropdown')[0]) {
            $(this).formSelect();
            resizeSelect($(this));
        }
    });
});
