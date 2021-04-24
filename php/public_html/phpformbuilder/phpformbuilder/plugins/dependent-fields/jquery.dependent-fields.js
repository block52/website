/*=========================================================
            phpformbuilder dependent fields for jQuery
            Author : Gilles Migliori
            Version : 1.0.1
=========================================================*/

(function($) {
    $.fn.dependentFields = function(options) {
        var settings = $.extend({
                // defaults settings.
                wrapperClass: 'hidden-wrapper',
                showClass: 'on',
                hideClass: 'off',
                parentData: 'data-parent',
                showValuesData: 'data-show-values',
                inverseData: 'data-inverse'
            }, options),
            i;
        $(this).each(function() {
            var parentFieldClean = $(this).attr(settings.parentData).replace('[]', ''),
                parentFieldFull = parentFieldClean,
                showValues = $(this).attr(settings.showValuesData),
                inverseData = $(this).attr(settings.inverseData),
                that = this;

            if ($('*[name="' + parentFieldClean + '[]"]').get(0)) {
                parentFieldFull = parentFieldClean + '[]';
            }

            // don't split doubled-escaped commas
            // https://codepen.io/migli/pen/qPOvZM/
            showValues = showValues.replace('\\,', '{comma}');
            showValues = showValues.split(/,\s*/);
            for (var i = 0; i < showValues.length; i++) {
                showValues[i] = showValues[i].replace('{comma}', ',');
            }

            // convert to boolean
            inverseData = inverseData == 'true' || inverseData > 0;

            // enable LCSwitch events
            if ($('.lcswitch')[0]) {
                $('body').delegate('.lcswitch', 'lcs-statuschange', function() {
                    $(this).trigger('change');
                });
            }

            // ifChanged = iCheck event, changed.bs.select = bootstrap-select event
            $('*[name="' + parentFieldFull + '"]').on('change ifChanged changed.bs.select', function() {
                var isRadio = $(this).is(':radio'),
                    isCheckbox = $(this).is(':checkbox'),
                    value;

                /*
                    If inverseData: value is the first non-showValues found, or undefined if none
                    else, value is the first showValues found, or undefined if none
                */

                if (inverseData !== true) {
                    if (isRadio) {
                        // undefined if none checked. Else, checked value.
                        value = $('input[name="' + parentFieldFull + '"]:checked').val();
                    } else if (isCheckbox) {
                        value = [];
                        $('input[name="' + parentFieldFull + '"]:checked').each(function() {
                            value.push($(this).val());
                        });
                        if (value.length < 1) {
                            value = undefined;
                        }
                    } else {
                        value = $(this).val();
                    }

                    // if checkbox or multiple select, we loop into selected values to find one corresponding to showValues
                    if ((typeof value == 'object') & (value !== null)) {
                        for (i = value.length - 1; i >= 0; i--) {
                            if ($.inArray(value[i], showValues) > -1) {
                                value = value[i];
                                i = -1;
                            }
                        }
                    }
                } else {
                    value = undefined;

                    /* =============================================
                        register any value non-matching with showValues
                    ============================================= */

                    if (isRadio) {
                        // if checked value is not in showValues.
                        if ($.inArray($('input[name="' + parentFieldFull + '"]:checked').val(), showValues) < 0) {
                            value = $('input[name="' + parentFieldFull + '"]:checked').val();
                        }
                    } else if (isCheckbox) {
                        value = [];
                        $('input[name="' + parentFieldFull + '"]:checked').each(function() {
                            if ($.inArray($(this).val(), showValues) < 0) {
                                value.push($(this).val());
                            }
                        });
                        if (value.length < 1) {
                            value = undefined;
                        }
                    } else {
                        if ($.inArray($(this).val(), showValues) < 0) {
                            value = $(this).val();
                        }
                    }

                    // if checkbox or multiple select, keep only first value as string
                    if (typeof value == 'object') {
                        value = value[0];
                    }
                }
                // console.log(parentFieldFull + ' value = ' + value);

                if ($.inArray(value, showValues) > -1) {
                    // if value found in showValues
                    if (inverseData !== true) {
                        // Show
                        $(that).removeClass(settings.hideClass).addClass(settings.showClass);
                        $(that).children().not('.hidden-wrapper').prop('disabled', false);
                    }
                } else {
                    // if value NOT found in showValues
                    if (inverseData === true && value !== undefined) {
                        // Show
                        $(that).removeClass(settings.hideClass).addClass(settings.showClass);
                        $(that).children().not('.hidden-wrapper').prop('disabled', false);
                    } else {
                        // Hide
                        $(that).removeClass(settings.showClass).addClass(settings.hideClass);
                        $(that).children().not('.hidden-wrapper').prop('disabled', true);
                    }
                }

                return;
            });
            var arr = [];
            var $current = $('*[name="' + parentFieldFull + '"]');
            $current.each(function() {
                if ($.inArray(parentFieldClean, arr) === -1) {
                    if ($(this).next('.iCheck-helper').length > 0 && $(this).is(':checked')) {
                        // if ICheck
                        $(this).trigger('ifChanged');
                        arr.push(parentFieldClean);
                    } else if ($(this).parent('.bootstrap-select').length > 0 && $(this).val() !== '') {
                        // if bootstrap-select
                        $(this).trigger('changed.bs.select');
                        arr.push(parentFieldClean);
                    } else {
                        if ($(this).is(':checked') || ($(this).val() !== '' && !$(this).is(':checkbox') && !$(this).is(':radio'))) {
                            $(this).trigger('change');
                            arr.push(parentFieldClean);
                        }
                    }
                }
            });
        });
    };
})(jQuery);
