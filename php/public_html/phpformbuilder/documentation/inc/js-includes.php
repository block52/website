<?php
$dir_path = 'https://www.phpformbuilder.pro/documentation/';
if ($_SERVER['HTTP_HOST'] != 'www.phpformbuilder.pro') {
    if (strpos($_SERVER['REQUEST_URI'], 'templates/') || strpos($_SERVER['REQUEST_URI'], 'phpformbuilder/')) {
        $dir_path = '../documentation/';
    } elseif (!strpos($_SERVER['REQUEST_URI'], 'documentation')) {
        $dir_path = 'documentation/';
    } else {
        $dir_path = '';
    }
}
?>
<script>const dirPath = '<?php echo $dir_path; ?>';</script>
<script src="<?php echo $dir_path; ?>assets/javascripts/loadjs.min.js"></script>
<script src="<?php echo $dir_path; ?>assets/javascripts/project.min.js"></script>
<!-- fontawesome -->
<script async defer src="<?php echo $dir_path; ?>assets/javascripts/fontawesome-free-5.0.12/svg-with-js/js/fontawesome-all.min.js"></script>


<!-- schema.org -->

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebApplication",
  "name": "PHP Form Builder",
  "url": "https://www.phpformbuilder.pro",
  "description": "PHP Form Builder - Form Generator including 20+ jQuery plugins, Live validation + Server-side validation, Email and Database features.",
  "applicationCategory": "Forms",
  "applicationSubCategory": "PHP",
  "about": {
    "@type": "Thing",
    "description": "PHP, form"
  },
  "browserRequirements": "Requires JavaScript. Requires HTML5.",
  "softwareVersion": "4.3",
  "softwareHelp": {
    "@type": "CreativeWork",
    "url": "https://www.miglisoft.com/#contact"
  },
  "operatingSystem": "All",
  "releaseNotes": "https://www.phpformbuilder.pro/#changelog",
  "image": "https://www.phpformbuilder.pro/documentation/assets/images/phpformbuilder-preview.png",
  "offers": {
    "@type": "Offer",
    "price": "20.00",
    "priceCurrency": "USD",
    "url": "https://codecanyon.net/item/php-form-builder/8790160"
  },
  "aggregateRating": {
    "@type": "aggregateRating",
    "ratingValue": "4.83",
    "reviewCount": "179"
  }
}
</script>

<script type='application/ld+json'>
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "Miglisoft",
  "url": "https://www.miglisoft.com",
  "logo": "https://www.miglisoft.com/assets/images/migli-logo.png",
  "sameAs": [
    "https://www.facebook.com/miglisoft/",
    "https://twitter.com/miglisoft",
    "https://plus.google.com/+GillesMiglioriMigli",
    "https://www.linkedin.com/in/gilles-migliori-ab661626/"
    ]
  }
  </script>

  <script type='application/ld+json'>
  {
    "@context": "http://schema.org",
    "@type": "Product",
    "category": "Forms",
    "url": "https://www.phpformbuilder.pro",
    "description": "PHP Form Builder New version 4 Build now Materialize AND Material Bootstrap forms New Material Date/time picker plugin New Very fast and 100% optimized loading with LoadJs New Visual Studio Code extension Easy powerful jQuery plugins integration including jQuery Validator (50$ value) jQuery Fileuploader (12$ value) Save up to 50% with the Extended license   What is PHP Form Builder? PHP Form Builder is a complete library based on a PHP class, which allows you to program any type of form and layout them using simple functions.",
    "name": "PHP Form Builder",
    "image": "https://www.phpformbuilder.pro/documentation/assets/images/phpformbuilder-preview.png",
    "offers": {
        "@type": "Offer",
        "availability": "http://schema.org/InStock",
        "Price": "20.00",
        "priceValidUntil": "<?php echo date('Y-m-d', strtotime('+1 year')); ?>",
        "priceCurrency": "USD",
        "url": "https://www.phpformbuilder.pro"
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.83",
      "reviewCount": "179"
    }
  }
</script>
    <?php
    if ($_SERVER['HTTP_HOST'] == 'www.phpformbuilder.pro') {
        $share_url = 'https://www.phpformbuilder.pro' . $_SERVER['REQUEST_URI'];
        $share_title = 'PHP Form Builder';
        $share_text = 'Create PHP Forms with strong code and the very best jQuery plugins';
        $hash_tags = '#php#bootstrap#form#phpformbuilder';
        ?>
    <div id="share-wrapper">
        <input type="checkbox" name="share-checkbox" id="share-checkbox" class="d-none" />
        <label id="share" class="mb-2 d-flex justify-content-center align-items-center" for="share-checkbox" data-toggle="tooltip" data-placement="left" title="Click to share">
            <i class="fa fa-share-alt"></i>
        </label>
        <ul class="list-unstyled d-flex flex-wrap">

            <!-- facebook -->

            <li>
                <a id="share-facebook" class="mb-2 d-flex justify-content-center align-items-center" href="https://www.facebook.com/sharer.php?u=<?php echo $share_url ?>&amp;t=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>

            <!-- twitter -->

            <li>
                <a id="share-twitter" class="mb-2 d-flex justify-content-center align-items-center tw" href="https://twitter.com/share?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Tweet this page!">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>

            <!-- pinterest -->

            <li>
                <a id="share-pinterest" class="mb-2 d-flex justify-content-center align-items-center pt" href="https://pinterest.com/pin/create/button/?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Pinterest">
                    <i class="fab fa-pinterest pt"></i>
                </a>
            </li>

            <!-- linkedin -->

            <li>
                <a id="share-linkedin" class="mb-2 d-flex justify-content-center align-items-center li" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>

            <!-- reddit -->

            <li>
                <a id="share-reddit" class="mb-2 d-flex justify-content-center align-items-center li" href="https://reddit.com/submit?url=<?php echo $share_url ?>&title=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Reddit">
                    <i class="fab fa-reddit"></i>
                </a>
            </li>

            <!-- google bookmarks -->

            <li>
                <a id="share-google-bookmarks" class="mb-2 d-flex justify-content-center align-items-center li" href="https://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo $share_url ?>&title=<?php echo $share_title; ?>&annotation=<?php echo $share_text; ?>&labels=<?php echo $hash_tags; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Google Bookmarks">
                    <i class="fab fa-google"></i>
                </a>
            </li>

            <!-- mix -->

            <li>
                <a id="share-mix" class="mb-2 d-flex justify-content-center align-items-center li" href="https://mix.com/add?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Mix">
                    <i class="fab fa-mix"></i>
                </a>
            </li>

            <!-- pocket -->

            <li>
                <a id="share-pocket" class="mb-2 d-flex justify-content-center align-items-center li" href="https://getpocket.com/edit?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Pocket">
                    <i class="fab fa-get-pocket"></i>
                </a>
            </li>

            <!-- digg -->

            <li>
                <a id="share-digg" class="mb-2 d-flex justify-content-center align-items-center li" href="http://digg.com/submit?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Digg">
                    <i class="fab fa-digg"></i>
                </a>
             </li>

            <!-- blogger -->

            <li>
                <a id="share-blogger" class="mb-2 d-flex justify-content-center align-items-center li" href="https://www.blogger.com/blog-this.g?u=<?php echo $share_url ?>&n=<?php echo $share_title; ?>&t=<?php echo $share_text; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Blogger">
                    <i class="fab fa-blogger"></i>
                </a>
            </li>

            <!-- tumblr -->

            <li>
                <a id="share-tumblr" class="mb-2 d-flex justify-content-center align-items-center li" href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $share_url ?>&title=<?php echo $share_title; ?>&caption=CAPTIONTOSHARE&tags=<?php echo $hash_tags; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Tumblr">
                    <i class="fab fa-tumblr"></i>
                </a>
            </li>

            <!-- flipboard -->

            <li>
                <a id="share-flipboard" class="mb-2 d-flex justify-content-center align-items-center li" href="https://share.flipboard.com/bookmarklet/popout?v=2&url=<?php echo $share_url ?>&title=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Flipboard">
                    <i class="fab fa-flipboard"></i>
                </a>
            </li>

            <!-- hacker news -->

            <li>
                <a id="share-hacker-news" class="mb-2 d-flex justify-content-center align-items-center li" href="https://news.ycombinator.com/submitlink?u=<?php echo $share_url ?>&t=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Hacker News">
                    <i class="fab fa-hacker-news"></i>
                </a>
            </li>
        </ul>
    </div>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5e994d8569e9320caac48144/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- fb like -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script>
    <div class="fb-like" data-href="<?php echo $_SERVER['REQUEST_URI']; ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
    <!-- mailchimp -->
    <a href="//eepurl.com/dnG5Fz" id="mailchimp-subscribe">subscribe</a>
    <!-- GA -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153115730-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-153115730-1');
    </script>

    <?php
    }
    ?>
