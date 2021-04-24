/* jshint jquery: true, browser: true, strict: global, unused:false */
/* global window, document, dirPath, loadjs, Prism */
'use strict';
var myScroll;

var coreFunctions = function () {
    if (top != window.self || location.hostname !== 'www.phpformbuilder.pro') {
        $('#buy').remove();
        // $('#subscribe').css('display', 'none');
        $('a[href="#subscribe"]').remove();
    }

    if (top == window.self || location.hostname == 'www.phpformbuilder.pro') {
        $('#buyer-contact').html('');
    }

    //handle external links (new window)
    $('a[href^=http]').bind('click', function () {
        window.open($(this).attr('href'));
        return false;
    });

    // anchors smooth scroll
    $('a[href^="#"]').on('click', function () {
        var anchor = $.attr(this, 'href').substr(1);
        if (anchor.length < 1) {
            return;
        }
        var $targetLink = $('#' + $.attr(this, 'href').substr(1)),
            dataToggle = $(this).attr('data-toggle');
        if ($targetLink[0] && dataToggle != 'modal' && dataToggle != 'collapse') {
            $('html, body').animate({
                scrollTop: $targetLink.offset().top - 80
            }, 200);
        }

        return;
    });

    if (location.hash != '' && $('a[href="' + location.hash + '"]')[0]) {
        $('a[href="' + location.hash + '"]').trigger('click').closest('.collapse').collapse('show');
    }


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
};

/* =============================================
    <!-- lazyload -->
    <script src="<?php echo $dir_path; ?>assets/javascripts/plugins/loaders/lazyload.min.js"></script>
    <!-- project -->
    <script src="<?php echo $dir_path; ?>assets/javascripts/project.js"></script>
    <!-- Syntax Highlighting -->
    <script src="<?php echo $dir_path; ?>assets/javascripts/prism.min.js" data-manual></script>
============================================= */

loadjs([
    dirPath + 'assets/javascripts/jquery-3.3.1.min.js',
    dirPath + 'assets/javascripts/popper.min.js',
    dirPath + 'assets/javascripts/bootstrap.min.js',
    dirPath + 'assets/javascripts/plugins/loaders/pace.min.js'
], 'core', {
    async: false
});

loadjs.ready('core', function () {
    coreFunctions();
    loadjs([dirPath + 'assets/javascripts/plugins/nicescroll/jquery.nicescroll.min.js'], function () {
        loadjs.done('bundleB');
    });
    loadjs([dirPath + 'assets/javascripts/plugins/loaders/lazyload.min.js'], function () {
        loadjs.done('bundleC');
    });
    $('#search-form').on('submit', function () {
        $(this).find('svg').replaceWith('<i class="fas fa-spinner fa-spin text-white"></i>');
    });
});

// core + nicescroll loaded
loadjs.ready(['bundleB'], function () {
    // nav scroller
    myScroll = $('#navbar-left-wrapper').niceScroll({
        cursorcolor: '#ccc',
        cursorborder: '1px solid #212121',
        cursorborderradius: '0px'
    });
    var niceScroll = $('#navbar-left-wrapper').getNiceScroll();

    if ($(document).width() < 992) {
        niceScroll.hide();
    }

    // left navbar collapse
    if ($('#navbar-left-collapse')[0]) {
        $('#navbar-left-collapse').on('click', function () {
            $('#navbar-left-wrapper').css('display', 'none');
            niceScroll.hide();
        });
        $('#navbar-left-toggler').on('click', function () {
            $('#navbar-left-wrapper').css('display', 'block');
            setTimeout(function () {
                niceScroll.resize().show();
            }, 1000);
        });
    }
});

// core + lazyload loaded
loadjs.ready(['bundleC'], function () {
    $('img.lazyload').lazyload();
    // get Google reviews
    if ($('#google-reviews')[0]) {
        var target = $('#google-reviews');
        $.ajax({
            url: 'ajax-google-reviews.php',
            type: 'GET'
        }).done(function (data) {
            target.html(data);
            var run = window.run;
            if (typeof run != 'undefined') {
                setTimeout(run, 0);
            }
        }).fail(function (data, statut, error) {
            console.log(error);
        });
    }
});

// core + essential bundles loaded
window.onload = function () {
    loadjs(['css!' + dirPath + 'assets/stylesheets/prism.min.css']);
    loadjs([dirPath + 'assets/javascripts/prism.min.js'], function () {
        loadjs.done('bundleD');
    });
    loadjs([dirPath + 'assets/javascripts/plugins/loaders/lazyload.min.js'], function () {
        loadjs.done('bundleE');
    });
};

loadjs.ready(['bundleD'], function () {
    if (!$('#jquery-plugins-container')[0]) {
        Prism.highlightAll(true);
    }

    // trigger on load
    setTimeout(function () {
        if ($(window.location.hash)[0]) {
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top - 80
            }, 200);
            $('#navbar-left-wrapper').getNiceScroll(0).doScrollTop($('#navbar-left-wrapper a.nav-link.active').position().top - 80, 200);
        }
    }, 1000);
});
