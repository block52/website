// Resize reCAPTCHA to fit width of container
// Since it has a fixed width, we're scaling
// using CSS3 transforms
// ------------------------------------------
// captchaScale = containerWidth / elementWidth

// from https://codepen.io/dloewen/pen/jbgeZj

function scaleCaptcha(elementWidth) {
    // Width of the reCAPTCHA element, in pixels

    var $recaptcha = jQuery('.g-recaptcha');
    $recaptcha.each(function(index) {
        var $recaptchaWrapper = jQuery(this).parent('.recaptcha-wrapper'),
            reCaptchaWidth    = 304,
            recaptchaHeight   = 78,
            captchaScale      = 1;

        // Get the containing element's width
        var containerWidth  = $recaptchaWrapper.width(),
            containerHeight = $recaptchaWrapper.height();

        // Force minimum reasonable dimensions for recaptcha if container is smaller ; 304*78 => 200 x 60
        if(containerWidth < 200) {
            containerWidth = 200;
            $recaptchaWrapper.css({
                'min-width': '200px',
                'min-height': '60px'
            });
        } else if(containerHeight < 78) {
            containerHeight = 78;
            $recaptchaWrapper.css('min-height', '78px'); //230/304*78
        }

        // Only scale the reCAPTCHA if it won't fit
        // inside the container
        if(reCaptchaWidth > containerWidth) {

            // Calculate the scale
            captchaScale = containerWidth / reCaptchaWidth;

            // Apply the transformation
            jQuery(this).css({
                'position': 'absolute',
                'width': containerWidth,
                'height': recaptchaHeight,
                'transform':'scale('+captchaScale+')'
            });
        } else {
            jQuery('.g-recaptcha').css({
                'position': 'inherit',
                'width': 'auto',
                'height': 'auto',
                'transform':'scale(1)'
            });
        }
        $recaptchaWrapper.css({
            'min-height': recaptchaHeight * captchaScale
        });
    });
}

jQuery(document).ready(function($) {

    // Update scaling on window resize
    $(window).resize($.throttle(100, scaleCaptcha));

});