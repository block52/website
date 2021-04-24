/* global define, console, $, jQuery, lozad, loadjs, player */
'use strict';

loadjs([
    '/assets/javascripts/plugins/loaders/lozad.min.js'
], function () {
    loadjs.done('bundleA');
});

loadjs([
    '/assets/javascripts/plugins/loaders/pace.min.js',
    '/assets/javascripts/jquery-3.3.1.min.js',
    '/assets/javascripts/popper.min.js',
    '/assets/javascripts/bootstrap.min.js'
], 'core',
    {
        async: false
    }
);

// lazyload loaded
loadjs.ready(['bundleA'], function () {
    var observer = lozad('.lazyload');
    observer.observe();
});

loadjs.ready('core', function () {
    $('a[href^="#"]').on('click', function (e) {
        var anchor = $.attr(this, 'href').substr(1);
        if (anchor.length < 1) {
            e.preventDefault();
            return;
        }
        var $targetLink = $('#' + $.attr(this, 'href').substr(1)),
            dataToggle = $(this).attr('data-toggle');
        if ($targetLink[0] && dataToggle != 'modal' && dataToggle != 'collapse') {
            $('html, body').animate(
                {
                    scrollTop: $targetLink.offset().top - 56
                },
                500
            );
        }

        return;
    });

    if (location.hash != '' && $(location.hash)[0]) {
        Pace.on('hide', () => {
            var $link = $(location.hash),
                $targetLink = $($link.attr('href'));
            if ($targetLink[0] && $targetLink.hasClass('collapse')) {
                $targetLink.on('shown.bs.collapse', function () {
                    $('html, body').animate(
                        {
                            scrollTop: $link.offset().top - 56
                        },
                        500,
                        function () {
                            $link.off('shown.bs.collapse');
                        }
                    );
                    return false;
                });
                $targetLink.collapse('show');
            }
        });
    }

    if ($('#navbar-left-collapse')[0]) {
        $('#navbar-left-collapse').on('click', function () {
            $('#navbar-left-wrapper').css('display', 'none');
        });
        $('#navbar-left-toggler').on('click', function () {
            $('#navbar-left-wrapper').css('display', 'block');
        });

        var resizeTimer;

        $(window).on('resize', function (e) {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                // Run code here, resizing has "stopped"
                if ($(document).width() > 991) {
                    $('#navbar-left-wrapper').css('display', 'block');
                }
            }, 250);
        });
    }

    if ($('#video-nav')[0]) {
        $('#video-nav a').on('click', function (e) {
            e.preventDefault();
            var seconds = $(this).attr('data-time');
            player.seekTo(seconds);

            return false;
        });
    }

    if ($('#search-form')[0]) {
        $('#search-form').on('submit', function () {
            $('#search-submit i').removeClass('fas fa-search').addClass('fas fa-spinner fa-spin');
        })
    }
});
