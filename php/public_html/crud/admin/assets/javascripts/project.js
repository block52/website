/* global $, adminUrl, console, loadjs */
'use strict';

var files = [
    adminUrl + 'assets/javascripts/jquery-3.2.1.min.js',
    adminUrl + 'assets/javascripts/popper.min.js',
    adminUrl + 'assets/javascripts/bootstrap.min.js',
    adminUrl + 'assets/javascripts/plugins/pace.min.js',
    adminUrl + 'assets/javascripts/plugins/ripple.min.js'
];

// if (datetimepickersStyle == 'material') {
// material-pickers-base has to be always loaded for modals (bulk delete)
files.push(classUrl + 'phpformbuilder/plugins/material-pickers-base/dist/css/material-pickers-base.min.css', classUrl + 'phpformbuilder/plugins/material-pickers-base/dist/js/material-pickers-base.min.js');
// }
loadjs(files, 'core', {
    async: false
});

loadjs.ready('core', function () {
    /*===============================
    =            Sidebar            =
    ===============================*/

    var resizeContent = function () {
        setTimeout(function () {
            if ($(window).width() > 991) {
                $('.content-wrapper').css('width', 'calc(100% - ' + (
                    $('#sidebar-main').outerWidth() + 40) + 'px');
            } else {
                $('.content-wrapper').css('width', '100%');
            }
        }, 50);
    };

    if ($('.sidebar')[0]) {
        if ($(window).width() > 991) {
            $('.sidebar').removeClass('collapse');

            // Expand the 1st category
            if ($('.sidebar-category .dropdown-toggle[aria-expanded="true"]').length < 1) {
                var firstDropdown = $('#sidebar-main').find('.dropdown-toggle').get(0);
                if ($(firstDropdown)[0]) {
                    $(firstDropdown).trigger('click');
                }
            }
            if ($('#filters-list')[0]) {
                $('#filters-list select').on('change', resizeContent);
            }

            // collapse others on category click if COLLAPSE_INACTIVE_SIDEBAR_CATEGORIES
            if ($('.category-content.collapse')[0]) {
                $('#sidebar-main .category-title a.dropdown-toggle').not('[href="#sidebarFiltersNav"]').on('click', function (e) {
                    var hrefId = $(e.target).attr('aria-controls');
                    $('#sidebar-main .category-content').not('[id="sidebarFiltersNav"]').not('[id="' + hrefId + '"]').collapse('hide');
                });
            }
        }
        $(window).on('resize', function () {
            setTimeout(function () {
                if ($(window).width() > 991) {
                    $('.sidebar').removeClass('collapse').addClass('show');
                    $('.sidebar-toggler').removeClass('collapsed').attr('aria-expanded', 'true');
                } else {
                    $('.sidebar').addClass('collapse').removeClass('show');
                    $('.sidebar-toggler').addClass('collapsed').attr('aria-expanded', 'false');
                }
                setTimeout(resizeContent, 400);
            }, 100);
        }).resize();

        // sidebar mini toggle
        if ($('.sidebar-mini-toggler')[0]) {
            $('.sidebar-mini-toggler').on('click', function () {
                if ($('#sidebarFiltersNav')[0]) {
                    $('#sidebarFiltersNav').prev('.category-title').find('a.dropdown-toggle:not(.collapsed)').trigger('click');
                }
                $(this).closest('.sidebar-container').toggleClass('has-mini').find('.sidebar').toggleClass('sidebar-mini');
                setTimeout(resizeContent, 250);
            });
        }
    }
});
