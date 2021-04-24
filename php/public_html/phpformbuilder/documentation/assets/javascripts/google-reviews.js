if (top == window.self || location.hostname == 'www.phpformbuilder.pro') {
    // get Google reviews
    if ($('#google-reviews')[0]) {
        var target = $('#google-reviews');
        $.ajax({
            url: 'ajax-google-reviews.php',
            type: 'GET'
        })
            .done(function(data) {
                target.html(data);
                var run = window.run;
                if (typeof run != 'undefined') {
                    setTimeout(run, 0);
                }
            })
            .fail(function(data, statut, error) {
                console.log(error);
            });
    }
}
