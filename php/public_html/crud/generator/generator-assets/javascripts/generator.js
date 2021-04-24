/* jshint jquery: true, browser: true, globalstrict: true, unused:false */
/* global window, document */

/* global $, adminUrl, generatorUrl, console, loadjs */
'use strict';


/* Global variables
-------------------------------------------------- */

var inst,
    validationAutoLoaded = false;;

loadjs([
    generatorUrl + 'generator-assets/stylesheets/generator.min.css',
    adminUrl + 'assets/stylesheets/fa-svg-with-js.min.css',
    generatorUrl + 'generator-assets/lib/remodal/remodal.css',
    generatorUrl + 'generator-assets/lib/remodal/remodal-default-theme.css',
    adminUrl + 'assets/stylesheets/qtip.min.css',
    adminUrl + 'assets/stylesheets/ripple.min.css'
]
);

loadjs([
    adminUrl + 'assets/javascripts/jquery-3.2.1.min.js',
    adminUrl + 'assets/javascripts/popper.min.js',
    adminUrl + 'assets/javascripts/bootstrap.min.js'
], 'core',
    {
        async: false
    }
);

// CORE loaded
loadjs.ready('core', function () {
    loadjs([
        adminUrl + 'assets/javascripts/plugins/ripple.min.js'
    ], 'bundleA'
    );
    loadjs([
        adminUrl + 'assets/javascripts/plugins/jquery.qtip.min.js'
    ], 'bundleB'
    );
    loadjs([
        generatorUrl + 'generator-assets/lib/remodal/remodal.min.js'
    ], 'bundleC'
    );
    loadjs([
        adminUrl + 'assets/javascripts/fontawesome-all.min.js'
    ]
    );

    var $actionInput = $('input[name="action"]'),
        actionValue = $actionInput.val();
    if (actionValue === undefined || actionValue === '') {
        actionValue = 'build_read';
        $actionInput.val(actionValue);
    }
    $('#form-select-table select[name="table"]').on('change', function () {
        // transmit the selected table to the table-reset form
        $('input[name="table-to-reset"]').val($(this).val());
        $('button[name="btn-reset-table"]').find('em').text($(this).val());
    });

    $('input[name="list_type"]').on('change', function (e) {
        if ($('input[value="build_paginated_list"]').prop('checked') === true) {
            $('div[data-show-values="build_paginated_list"]')
                .removeClass('off')
                .addClass('on');
            $('div[data-show-values="build_single_element_list"]')
                .removeClass('on')
                .addClass('off');
        } else if ($('input[value="build_single_element_list"]').prop('checked') === true) {
            $('div[data-show-values="build_paginated_list"]')
                .removeClass('on')
                .addClass('off');
            $('div[data-show-values="build_single_element_list"]')
                .removeClass('off')
                .addClass('on');
        }
    });

    $('input[value="build_read"]').trigger('change');

    $('#reload-db-structure-link').on('click', function () {
        $.ajax({
            url: generatorUrl + 'inc/reload-db-structure.php',
            type: 'GET'
        })
            .done(function (data) {
                location.reload();
            });
    });

    // intercept form post and delete unused fields before POST to avoid PHP max_post_size issue
    $('button[name="form-select-fields-submit-btn"]').on('click', function (e) {
        e.preventDefault();
        var $form = $('#form-select-fields');
        $.when($form.find('.hidden-wrapper.off').remove()).then(function () {
            $form.submit();
        });
    });

    // skip fields
    $('input[name^="rp_others_"]').on('change', function (e) {
        var skippable = $(this)
            .closest('div.form-group')
            .siblings('.skippable');
        if ($(this).val() === 'skip') {
            skippable.slideUp();
        } else {
            skippable.slideDown();
        }
    });

    $('input[name^="rp_others_"]:checked').trigger('change');

    // close buttons
    $('.card-header .close').on('click', function () {
        $(this)
            .closest('.card')
            .remove();
    });

    // read paginated list
    $('select[name^="rp_value_type_"]').on('change', function () {
        var value = $(this).val(),
            $fgroup = $(this).closest('.form-group');
        if (value == 'array' || value == 'image' || value == 'file' || value == 'password') {
            $fgroup
                .find('select[name^="rp_jedit_"]')
                .val('')
                .trigger('change')
                .attr('disabled', true)
                .closest('label')
                .addClass('disabled');
        } else {
            $fgroup
                .find('select[name^="rp_jedit_"]')
                .removeAttr('disabled')
                .closest('label')
                .removeClass('disabled');
        }
    });

    // change on load
    $('select[name^="rp_value_type_"]').trigger('change');

    // form create/edit
    $('select[name^="cu_field_type_"]').on('change', function () {
        var value = $(this).val(),
            $col = $(this)
                .closest('.form-group')
                .parent('div[class^="col-"]'),
            $date_placeholder,
            $widthSelect = $col.find('select[name^="cu_field_width_"]');
        if (value != 'textarea') {
            $col
                .find('.tinymce')
                .prop('checked', false)
                .attr('disabled', true)
                .closest('label')
                .addClass('disabled');
        } else {
            $col
                .find('.tinymce')
                .removeAttr('disabled')
                .closest('label')
                .removeClass('disabled');
        }
        if (value == 'image') {
            $(this)
                .closest('.form-group')
                .find('.cu_special_image_wrapper')
                .show();
        } else {
            $(this)
                .closest('.form-group')
                .find('.cu_special_image_wrapper')
                .hide();
        }
        if (value == 'date' || value == 'datetime' || value == 'time' || value == 'month') {
            if (value == 'date' || value == 'datetime' || value == 'month') {
                if (value == 'date' || value == 'datetime') {
                    $date_placeholder = 'dddd mmmm yyyy';
                } else if (value == 'month') {
                    $date_placeholder = 'mmmm';
                }
                $col
                    .find('.cu_special_date_wrapper')
                    .find('label[for^="cu_special_date_"]')
                    .show();
                $col
                    .find('.cu_special_date_wrapper')
                    .find('input[name^="cu_special_date_"]')
                    .attr('placeholder', $date_placeholder)
                    .parent('div[class^="col-"]')
                    .show();
            } else {
                $col
                    .find('.cu_special_date_wrapper')
                    .find('label[for^="cu_special_date_"]')
                    .hide();
                $col
                    .find('.cu_special_date_wrapper')
                    .find('input[name^="cu_special_date_"]')
                    .parent('div[class^="col-"]')
                    .hide();
            }
            if (value == 'datetime' || value == 'time') {
                $col
                    .find('.cu_special_date_wrapper')
                    .find('label[for^="cu_special_time_"]')
                    .show();
                $col
                    .find('.cu_special_date_wrapper')
                    .find('input[name^="cu_special_time_"]')
                    .attr('placeholder', 'H:i a')
                    .parent('div[class^="col-"]')
                    .show();
            } else {
                $col
                    .find('.cu_special_date_wrapper')
                    .find('label[for^="cu_special_time_"]')
                    .hide();
                $col
                    .find('.cu_special_date_wrapper')
                    .find('input[name^="cu_special_time_"]')
                    .parent('div[class^="col-"]')
                    .hide();
            }
            $col.find('.cu_special_date_wrapper').show();
        } else {
            $col.find('.cu_special_date_wrapper').hide();
        }
        if (value == 'password') {
            $col.find('.cu_special_password_wrapper').show();
        } else {
            $col.find('.cu_special_password_wrapper').hide();
        }
        if (value == 'input' || value == 'textarea') {
            $col
                .find('.char-count')
                .removeAttr('disabled')
                .closest('label')
                .removeClass('disabled');
        } else {
            $col
                .find('.char-count')
                .prop('checked', false)
                .attr('disabled', true)
                .closest('label')
                .addClass('disabled');
        }
        // disable 33% width if datetime
        if (value == 'datetime') {
            $widthSelect.find('option[value^="33%"]').attr('disabled', true);
        } else {
            $widthSelect.find('option[value^="33%"]').removeAttr('disabled');
        }
    });

    // link bulk cascade delete to cascade delete
    if ($('input[name^="bulk_constrained_tables_"]')[0]) {
        $('input[name^="bulk_constrained_tables_"]').on('change', function () {
            var cascade_delete_input_id = $(this).attr('id').replace('bulk_', '');
            $('#' + cascade_delete_input_id).prop("checked", true);
        });
        $('input[name^="constrained_tables_"]').on('change', function () {
            var bulk_cascade_delete_input_id = 'bulk_' + $(this).attr('id');
            $('#' + bulk_cascade_delete_input_id).prop("checked", true);
        });
    }

    // custom validation dynamic elements
    var validationContainers = $('[id^="validation-custom-ajax-elements-container-"]');
    var updateArgumentsHelper = function () {
        $('select[name^="cu_validation_function_"]').on('change', function () {
            var index = $(this).attr('data-index'),
                columnName = $(this).attr('data-column-name'),
                target = $('#ajax-update-validation-helper');
            $.ajax({
                url: generatorUrl + 'inc/update-validation-helper.php',
                data: {
                    columnName: columnName,
                    index: index,
                    value: $(this).val()
                }
            })
                .done(function (data) {
                    target.html(data);
                    var run = window['go'];
                    setTimeout(run, 0);
                })
                .fail(function (data, statut, error) {
                    console.log(error);
                });
        });
    };
    // trigger on load
    updateArgumentsHelper();

    // Remove dynamic validation action
    var removeDynamicValidation = function (target, btnRemove, countInput) {
        var currentIndex = parseInt($(btnRemove).attr('data-index')); // index of removed dynamic
        var dfIndex = parseInt(countInput.val());
        // Transfer upper dynamics values to each previous
        var transferUpperValues = function () {
            var previousDynamic = target.find('.validation-dynamic[data-index="' + currentIndex + '"]'),
                previousFields = $(previousDynamic).find('input, textarea, select, radio, checkbox');
            $(previousFields).each(function (i, field) {
                var followingField = '',
                    newValue = '';
                var followingFieldId = $(field)
                    .attr('id')
                    .replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                followingField = $('#' + followingFieldId);
                if ($(field).is('select')) {
                    newValue = followingField.val();
                    $(field)
                        .val(newValue)
                        .trigger('change');
                    // console.log('currentIndex : ' + currentIndex);
                    // console.log('currentId : ' + $(field).attr('id'));
                    // console.log('followingFieldId : ' + followingFieldId);
                    // console.log('newValue : ' + newValue);
                    // console.log('FIELD VALUE = ' + $(field).val());
                } else {
                    newValue = followingField.val();
                    $(field).val(newValue);
                }
            });
        };
        // if upper dynamic sections
        if (target.find('.validation-dynamic')[currentIndex]) {
            while (target.find($('.validation-dynamic')[currentIndex]).length > 0) {
                transferUpperValues();
                currentIndex++;
            }
        }
        // decrement dynamic-fields-index
        dfIndex -= 1;
        countInput.val(dfIndex);
        // remove last dynamic container
        target
            .find('.validation-remove-element-button:last')
            .closest('.validation-dynamic')
            .remove();
    };
    $(validationContainers).each(function (index, value) {
        // target to receive dynamic fields
        var target = $(this),
            columnName = $(this)
                .attr('id')
                .replace('validation-custom-ajax-elements-container-', '');
        // hidden field to store dynamic fields index
        var countInput = $('input[name="validation-dynamic-fields-index-' + columnName + '"]'),
            dfIndex;
        $(this)
            .siblings()
            .find('.validation-add-element-button')
            .on('click', function () {
                // increment index & dynamic-fields-index
                dfIndex = parseInt(countInput.val());
                dfIndex++;
                countInput.val(dfIndex);
                // ajax call
                $.ajax({
                    url: generatorUrl + 'inc/validation-custom-dynamic-elements.php',
                    data: {
                        columnName: columnName,
                        index: dfIndex
                    }
                })
                    .done(function (data) {
                        target.append(data);
                        var run = window.run;
                        if (typeof run != 'undefined') {
                            // the run function set the new form token value registered in session by filters-dynamic-elements.php
                            setTimeout(run, 0);
                        }
                        // $('.validation-dynamic select').selectpicker({ container: 'body' });
                        updateArgumentsHelper();
                        target
                            .find('.validation-remove-element-button')
                            .removeClass('hidden')
                            .off('click')
                            .on('click', function () {
                                removeDynamicValidation(target, this, countInput);
                            });
                    })
                    .fail(function (data, statut, error) {
                        console.log(error);
                    });
            });
        // activate remove buttons on load
        $(this)
            .find('.validation-remove-element-button')
            .on('click', function () {
                removeDynamicValidation(target, this, countInput);
            });
    });
    // debug
    if ($('#debug')[0]) {
        var debug = $('#debug');
        var debugWidth = $('#debug').outerWidth();
        $('#btn-debug').on('click', function () {
            if (debug.hasClass('on')) {
                debug.removeClass('on').animate({ left: $(window).outerWidth() }, 200);
            } else {
                debug.addClass('on').animate({ left: $(window).outerWidth() - debugWidth }, 200);
            }
        });
    }
    // lock|unlock admin
    if ($('#lock-admin-link')[0]) {
        $('#lock-admin-link').on('click', function (e) {
            e.preventDefault();
            $('form#lock-unlock-admin').submit();
            return false;
        });
    }

    // auto validation ajax
    var $columnFields = $('select[name^="cu_field_type_"], select[name^="cu_special_password_"]');

    $columnFields.on('change', function (e) {
        // dependent fields triggers the change event
        // we don't want this so we have to wait until they're loaded
        if ($('body').hasClass('dependent-fields-loaded')) {
            // target to receive ajax
            var columnIndex = $(e.target).attr('data-index'),
                columnName = $(e.target)
                    .attr('id')
                    .replace('cu_field_type_', '')
                    .replace('cu_special_password_', ''),
                target = $('div[id="validation-auto-ajax-elements-container-' + columnName + '"]'),
                fieldType = $('select[name="cu_field_type_' + columnName + '"]').val(),
                passwordValue = $('select[name^="cu_special_password_' + columnName + '"]').val();
            $.ajax({
                url: generatorUrl + 'inc/validation-auto-ajax-elements.php',
                async: true,
                data: {
                    columnName: columnName,
                    fieldType: fieldType,
                    passwordValue: passwordValue
                }
            })
                .done(function (data) {
                    // add auto validation fields (disabled)
                    target.html(data);
                })
                .fail(function () {
                    console.log('error');
                });
        }
    });

    var loadValidationAuto = function () {
        if ($('body').hasClass('dependent-fields-loaded')) {
            $columnFields.each(function () {
                var validation_radio = $(this)
                    .attr('name')
                    .replace('cu_field_type_', 'cu_validation_type_');
                // trigger validation auto ajax if 'auto' is checked
                if ($('input[name="' + validation_radio + '"]')[0]) {
                    if ($('input[name="' + validation_radio + '"]:checked').val() == 'auto') {
                        $(this).trigger('change');
                    }
                }
            });
            validationAutoLoaded = true;
        } else {
            // wait for dependent fields loaded
            setTimeout(loadValidationAuto, 600);
        }
    };

    $('.choose-action-radio').on('click', function () {
        actionValue = $(this).attr('id');
        $actionInput.val(actionValue).trigger('change');
        $('.choose-action-radio.active')
            .removeClass('bg-pink-500 active')
            .addClass('bg-dark');
        $('#' + actionValue)
            .removeClass('bg-dark')
            .addClass('bg-pink-500 active');

        if (actionValue == 'build_create_edit' && validationAutoLoaded === false) {
            loadValidationAuto();
        }

        return false;
    });

    $('#' + actionValue).trigger('click');
});

// CORE + Ripple loaded
loadjs.ready(['core', 'bundleA'], function () {
    $('.legitRipple').ripple();
});

// CORE + qTip
loadjs.ready(['core', 'bundleB'], function () {
    // tooltips
    $('[data-tooltip]').each(function () {
        // reset to default options for each tooltip
        var defaults = {
            style: 'qtip-dark',
            title: ''
        };

        // defaults events
        if ($(this).is('input')) {
            defaults.showEvent = 'focus';
            defaults.hideEvent = 'unfocus';
        } else {
            defaults.showEvent = 'mouseenter';
            defaults.hideEvent = 'mouseleave';
        }
        var options = defaults;

        // replace default options with data-attr in exist
        for (var key in defaults) {
            if ($(this).data(key) !== undefined) {
                options[key] = $(this).data(key);
            } else {
                options[key] = defaults[key];
            }
        }

        // tooltip placement (default top)
        options.position = {
            my: 'bottom center',
            at: 'top center',
            adjust: {
                x: 0,
                y: 0
            }
        };
        if ($(this).data('position') !== undefined) {
            var position = $(this).data('position');
            if (position == 'right') {
                options.position = {
                    my: 'left center',
                    at: 'right center'
                };
            } else if (position == 'bottom') {
                options.position = {
                    my: 'top center',
                    at: 'bottom center'
                };
            } else if (position == 'left') {
                options.position = {
                    my: 'right center',
                    at: 'left center'
                };
            }
        }
        if ($(this).data('adjust-x') !== undefined) {
            var adjustX = $(this).data('adjust-x');
            options.position.adjust.x = adjustX;
        }
        if ($(this).data('adjust-y') !== undefined) {
            var adjustY = $(this).data('adjust-y');
            options.position.adjust.y = adjustY;
        }

        // tooltip dimensions
        options.maxWidth = {};
        if ($(this).data('max-width') !== undefined) {
            options.maxWidth = $(this).data('max-width');
        }

        options.maxHeight = {};
        if ($(this).data('max-height') !== undefined) {
            options.maxHeight = $(this).data('max-height');
        }

        // if data-tooltip refers an html element
        var selector = $(this).data('tooltip');
        try {
            options['content'] = $(selector).html();
        } catch (error) { }

        // else (content text from data-tooltip attr)
        if (options.content === undefined) {
            options.content = {
                title: options.title,
                attr: 'data-tooltip'
            };
        }
        $(this).qtip({
            content: options.content,
            position: options.position,
            show: {
                event: options.showEvent,
                effect: function (offset) {
                    $(this).fadeIn(200);
                }
            },
            hide: {
                event: options.hideEvent,
                delay: 500,
                effect: function (offset) {
                    $(this).fadeOut(200);
                }
            },
            style: {
                classes: options.style
            },
            events: {
                show: function (event, api) {
                    $(this).css({
                        'max-width': options.maxWidth,
                        'max-height': options.maxHeight
                    });
                }
            }
        });
    });
});

// CORE + Remodal loaded
loadjs.ready(['core', 'bundleC'], function () {
    if ($('div[data-remodal-id="modal"]')[0]) {
        inst = $('div[data-remodal-id="modal"]').remodal();
    }

    // select values (remodal)
    $('button[name^="rp_jedit_select_modal"], button[name^="cu_select_modal"]').on('click', function () {
        var column = $(this).attr('data-column'),
            origin = $(this).attr('data-origin'); // rp_jedit|create-edit
        $.ajax({
            url: generatorUrl + 'inc/select-values.php',
            type: 'GET',
            data: {
                column: column,
                action: 'select-table'
            }
        })
            .done(function (data) {
                $('#remodal-content')
                    .html(data)
                    .find('.select2')
                    .select2();
                inst.open();
                // register values in generator on confirmation
                $(document)
                    .off('confirmation')
                    .on('confirmation', '.remodal', function () {
                        var selectFrom = $('input[name="select-from-' + column + '"]:checked').val(),
                            selectFromTable = '',
                            selectFromValue = '',
                            selectFromField1 = '',
                            selectFromField2 = '',
                            selectCustomNames = '',
                            selectCustomValues = '',
                            selectMultiple = $('input[name="select_multiple-' + column + '"]:checked').val();
                        if (selectFrom == 'from_table') {
                            selectFromTable = $('select[name="table-' + column + '"]').val();
                            selectFromValue = $('select[name="value-' + column + '"]').val();
                            selectFromField1 = $('select[name="field-1-' + column + '"]').val();
                            selectFromField2 = $('select[name="field-2-' + column + '"]').val();
                        } else if (selectFrom == 'custom_values') {
                            selectCustomNames = $('input[name^="custom_name-"]').serializeArray();
                            selectCustomValues = $('input[name^="custom_value-"]').serializeArray();
                        }
                        $.ajax({
                            url: generatorUrl + 'inc/register-select-values.php',
                            type: 'POST',
                            data: {
                                column: column,
                                origin: origin,
                                select_from: selectFrom,
                                select_from_table: selectFromTable,
                                select_from_value: selectFromValue,
                                select_from_field_1: selectFromField1,
                                select_from_field_2: selectFromField2,
                                select_custom_names: selectCustomNames,
                                select_custom_values: selectCustomValues,
                                select_multiple: selectMultiple
                            }
                        })
                            .done(function (data) {
                                if (origin == 'rp_jedit') {
                                    $('#rp_select-values-' + column).html(data);
                                } else if (origin == 'create-edit') {
                                    $('#cu_select-values-' + column).html(data);
                                }
                            })
                            .fail(function () {
                                console.log('error');
                            });
                    });
            })
            .fail(function (data, statut, error) {
                console.log(error);
            });
    });

    /* =============================================
        filters dynamic elements
    ============================================= */
    // target to receive dynamic fields
    var target = $('#filters-ajax-elements-container');
    // hidden field to store dynamic fields index
    var countInput = $('input[name="filters-dynamic-fields-index"]'),
        dfIndex = parseInt(countInput.val());
    var enableRemoveDynamic = function () {
        // Remove action
        $('.filters-remove-element-button')
            .removeClass('hidden')
            .off('click')
            .on('click', function () {
                var currentIndex = parseInt($(this).attr('data-index')); // index of removed dynamic
                // Transfer upper dynamics values to each previous
                var transferUpperValues = function () {
                    var previousDynamic = $('.filters-dynamic[data-index="' + currentIndex + '"]'),
                        previousFields = $(previousDynamic).find('input, textarea, select, radio, checkbox');
                    $(previousFields).each(function (i, field) {
                        if ($(field).attr('data-activates') === undefined) {
                            // specific condition for material select
                            var followingField = '',
                                newValue = '';
                            if ($(field).is('input[type="radio"]')) {
                                var followingFieldName = $(field)
                                    .attr('name')
                                    .replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                                followingField = $('input[name="' + followingFieldName + '"]:checked');
                                newValue = followingField.val();
                                if ($(field).val() == newValue) {
                                    $(field).prop('checked', true);
                                } else {
                                    $(field).prop('checked', false);
                                }
                            } else {
                                var followingFieldId = $(field)
                                    .attr('id')
                                    .replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                                followingField = $('#' + followingFieldId);
                                if ($(field).is('select')) {
                                    newValue = followingField.find('option:selected').val();
                                    $(field).val(newValue);
                                    // console.log('currentIndex : ' + currentIndex);
                                    // console.log('currentId : ' + $(field).attr('id'));
                                    // console.log('followingFieldId : ' + followingFieldId);
                                    // console.log('newValue : ' + newValue);
                                } else {
                                    newValue = followingField.val();
                                    $(field).val(newValue);
                                }
                            }
                        }
                    });
                };
                // if upper dynamic sections
                if ($('.filters-dynamic')[currentIndex]) {
                    while ($($('.filters-dynamic')[currentIndex]).length > 0) {
                        transferUpperValues();
                        currentIndex++;
                    }
                }
                // decrement dynamic-fields-index
                dfIndex -= 1;
                countInput.val(dfIndex);
                // remove last dynamic container
                $('.filters-remove-element-button:last')
                    .closest('.filters-dynamic')
                    .remove();
            });
    };
    var enableDaterangeAjaxToggle = function () {
        // disable ajax on daterange filters
        $('input[name^="filter-daterange-"]').off('change').on('change', function (e) {
            var index = $(e.target).attr('name').replace('filter-daterange-', ''),
                value = $(e.target).val();
            if (value > 0) {
                $('input[name="filter-ajax-' + index + '"][value=""]').prop('checked', true);
                $('input[name="filter-ajax-' + index + '"]').prop('disabled', true);
            } else {
                $('input[name="filter-ajax-' + index + '"]').prop('disabled', false);
            }
        });
        $('input[name^="filter-mode-"]').on('change', function (e) {
            var index = $(e.target).attr('name').replace('filter-mode-', ''),
                value = $(e.target).val();
            if (value === 'advanced') {
                $('input[name="filter-ajax-' + index + '"]').prop('disabled', false);
            } else {
                $('input[name="filter-daterange-' + index + '"]:checked').trigger('change');
            }
        });
    }
    $('.filters-add-element-button').on('click', function () {
        // increment index & dynamic-fields-index
        dfIndex++;
        countInput.val(dfIndex);
        // ajax call
        $.ajax({
            url: generatorUrl + 'inc/filters-dynamic-elements.php',
            data: {
                index: dfIndex
            }
        })
            .done(function (data) {
                target.append(data);
                var run = window.run;
                if (typeof run != 'undefined') {
                    // the run function set the new form token value registered in session by filters-dynamic-elements.php
                    setTimeout(run, 0);
                }
                $('.filters-dynamic .hidden-wrapper').dependentFields();
                $('.filters-dynamic').niceCheck();
                $('.filters-dynamic select').select2();
                enableRemoveDynamic();
                enableFilterTest();

                enableDaterangeAjaxToggle();
            })
            .fail(function (data, statut, error) {
                console.log(error);
            });
    });
    // enable remove filter buttons
    enableRemoveDynamic();

    // enable date range ajax toggle
    enableDaterangeAjaxToggle();
    $('input[name^="filter-daterange-"]').each(function () {
        if ($(this).is(':checked')) {
            $(this).trigger('change');
        }
    });

    // filters test
    // 'test_filter_' are generated by class/phpformbuilder/FormExtended.php
    var enableFilterTest = function () {
        if ($('button[name^="filter_test-"]')[0]) {
            $('button[name^="filter_test-"]')
                .off('click')
                .on('click', function () {
                    var i = $(this).val(),
                        data = {},
                        jsonKey = 'test_filter_' + i;
                    data[jsonKey] = 'all';
                    if ($('select[name="test_filter_' + i + '"]')[0]) {
                        data[jsonKey] = $('select[name="test_filter_' + i + '"]').val();
                    }
                    data.index = i;
                    data.filter_mode = $('input[name="filter-mode-' + i + '"]:checked').val();
                    data.filter_A = $('select[name="filter_field_A-' + i + '"]').val();
                    data.select_label = $('input[name="filter_select_label-' + i + '"]').val();
                    data.option_text = $('input[name="filter_option_text-' + i + '"]').val();
                    data.fields = $('input[name="filter_fields-' + i + '"]').val();
                    data.field_to_filter = $('input[name="filter_field_to_filter-' + i + '"]').val();
                    data.from = $('input[name="filter_from-' + i + '"]').val();
                    data.type = $('input[name="filter_type-' + i + '"]').val();
                    $.ajax({
                        url: generatorUrl + 'inc/filter-test.php',
                        type: 'POST',
                        data: data
                    })
                        .done(function (data) {
                            $('#remodal-content').html(data);
                            $('button[data-remodal-action="cancel"]').css({ position: 'absolute', left: '-100000px' });
                            inst.open();
                            $('#remodal-content button[name="cancel_filters"]').attr('disabled', true);
                            $('#remodal-content button[name="submit_filters"]').attr('disabled', true);
                            $(document).on('confirmation', '.remodal', function () {
                                $('button[data-remodal-action="cancel"]').css('display', 'inline-block');
                            });
                        })
                        .fail(function (data, statut, error) {
                            console.log(error);
                        });
                });
        }
    };
    enableFilterTest();

    // reset table ajax modal
    if ($('button[name="btn-reset-table"]')) {
        $('button[name="btn-reset-table"]').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: generatorUrl + 'inc/reset-table-form.php',
                type: 'POST',
                data: {
                    table: $('input[name="table-to-reset"]').val()
                }
            })
                .done(function (data) {
                    $('#remodal-content').html(data);
                    $('#remodal-content').niceCheck();
                    inst.open();
                    $('input[name="reset-data-choices"]').on('click', function () {
                        $('input[name="reset-data"]').val($('input[name="reset-data-choices"]:checked').val());
                    });
                    $(document).on('confirmation', '.remodal', function () {
                        $('#form_reset_table').submit();
                    });
                })
                .fail(function (data, statut, error) {
                    console.log(error);
                });
            return false;
        });
    }

    // remove authentification module
    if ($('#remove-authentification-module')[0]) {
        $('#remove-authentification-module').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: generatorUrl + 'inc/remove-authentification-module.php',
                type: 'GET',
                data: {}
            })
                .done(function (data) {
                    $('#remodal-content').html(data);
                    $('#form-remove-authentification-module').niceCheck();
                    inst.open();
                    // register values in generator on confirmation
                    $(document)
                        .off('confirmation')
                        .on('confirmation', '.remodal', function () {
                            $('#form-remove-authentification-module').submit();
                        });
                })
                .fail(function (data, statut, error) {
                    console.log(error);
                });
        });
    }
});
