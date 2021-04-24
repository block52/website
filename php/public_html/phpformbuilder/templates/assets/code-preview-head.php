<?php
use phpformbuilder\Form;

/* =============================================
    Bootstrap Theme Switcher
============================================= */

$bs3_theme = '';
if (isset($form) && $form->framework == 'bs3') {
    $bs3_available_themes = array(
        'phpformbuilder' => 'Soft & clean',
        'cerulean'       => 'A calm blue sky',
        'cosmo'          => 'An ode to Metro',
        'cyborg'         => 'Jet black and electric blue',
        'darkly'         => 'Flatly in night mode',
        'flatly'         => 'Flat & modern',
        'journal'        => 'Crisp like a new sheet of paper',
        'lumen'          => 'Light & shadow',
        'paper'          => 'Material is the metaphor',
        'readable'       => 'Optimized for legibility',
        'sandstone'      => 'A touch of warmth',
        'simplex'        => 'Mini & minimalmist',
        'slate'          => 'Shades of gunmetal gray',
        'solar'          => 'A spin on solarized',
        'superhero'      => 'Silvery & sleek',
        'united'         => 'The brave & the blue',
        'yeti'           => 'A friendly foundation'
    );
    if (isset($_GET['theme']) && preg_match('`[a-z]+`', $_GET['theme'])) {
        $bs3_theme = $_GET['theme'];

        // store user prefered theme
        @setcookie('bs3_theme', $bs3_theme);
        $_SESSION['theme-switcher']['theme'] = $bs3_theme;
    } elseif (isset($_COOKIE['bs3_theme']) && preg_match('`[a-z]+`', $_COOKIE['bs3_theme'])) {
        $bs3_theme = $_COOKIE['bs3_theme'];
        $_SESSION['theme-switcher']['theme'] = $bs3_theme;
    } else {
        $bs3_theme = 'phpformbuilder';
    }
    $form_theme_switcher = new Form('theme-switcher', 'vertical', 'class=novalidate');

    $form_theme_switcher->setMethod('GET');
    $options = array(
            'elementsWrapper' => '<div class="form-group text-center"></div>',
    );
    $form_theme_switcher->setOptions($options);
    foreach ($bs3_available_themes as $key => $value) {
        $palette = '<div class\=\'palette ' . $key . '\'><span class\=\'default\'></span><span class\=\'primary\'></span><span class\=\'success\'></span><span class\=\'info\'></span><span class\=\'warning\'></span><span class\=\'danger\'></span></div>';
        $form_theme_switcher->addOption('theme', $key, '', '', 'data-content=' . ucfirst($key) . '<small class\=\'text-muted\'> - ' . $value . '</small>' . $palette);
    }
    $form_theme_switcher->addSelect('theme', '', 'class=selectpicker, title=Choose your theme ..., data-width=auto, data-container=#theme-switcher-container');
    $form_theme_switcher_output       = '<div class="row" id="theme-switcher-container"><div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">' . addslashes($form_theme_switcher->render(false, false) . '</div></div>');

    /* =============================================
        Bootstrap 3 css
    ============================================= */

    if ($bs3_theme == 'phpformbuilder') {
        $bootstrap_css_link = '<!-- Change the link to bootstrap.min.css according to your directory structure -->' . "\n" . '    <link rel="preload" href="../assets/css/bootstrap.min.css" as="style" onload="this.rel=\'stylesheet\'">';
    } else {
        $bootstrap_css_link = '<link rel="preload" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.7/' . $bs3_theme . '/bootstrap.min.css" as="style" onload="this.rel=\'stylesheet\'">';
    }
    echo $bootstrap_css_link;
    $form_theme_switcher->printIncludes('css');
}

/* =============================================
    Code preview
============================================= */

// avoid foundation warning
if (!isset($bootstrap_css_link)) {
    $bootstrap_css_link = '';
}

$source_code = file_get_contents(rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . $_SERVER['PHP_SELF']);
$title = 'Source Code';
if (preg_match('`<title>([^<]+)</title>`', $source_code, $out)) {
    $title = $out[1] . ' Source Code';
    $find                       = array('`\n(\s)+<\?php([\n\t\s/\*=]+)CODE PREVIEW([^\?]+)\?>`', '`<!-- Link to Bootstrap css here -->`', '`6Ldg0QkUAAAAALUTA_uzlAEJP4fvm2SWtcGZ33Gc`', '`6Lc2olQUAAAAAEMrlEZmO80k3C6PLZKNjveIEqGf`', '`\$is_loadjs_form = true;([\n]{2})`');
    $replace                    = array('', $bootstrap_css_link, 'YOUR_RECAPTCHA_SECRET_CODE', 'YOUR_RECAPTCHA_SECRET_CODE', '');
}
$source_code                = htmlspecialchars(preg_replace($find, $replace, $source_code));
$code_preview_inline_styles = preg_replace('/[\r\n]*/', '', file_get_contents('../assets/css/code-preview-styles.min.css'));
if ($bs3_theme == 'phpformbuilder') {
    echo '<link href="//fonts.googleapis.com/css?family=Dosis:300,400,700" rel="preload" as="style" onload="this.rel=\'stylesheet\'">';
}
?>
<?php
if ($_SERVER['HTTP_HOST'] !== 'www.phpformbuilder.pro') {
    ?>
<meta name="robots" content="noindex, nofollow">
    <?php
} // end if
?>
<style type="text/css"><?php echo $code_preview_inline_styles; ?></style>
<link rel="preload" href="../assets/css/prism.min.css" as="style" onload="this.rel='stylesheet'">
<script type="text/javascript">
    /*! loadCSS. [c]2017 Filament Group, Inc. MIT License - https://github.com/filamentgroup/loadCSS */
    (function(w){"use strict";if(!w.loadCSS){w.loadCSS=function(){}}
var rp=loadCSS.relpreload={};rp.support=(function(){var ret;try{ret=w.document.createElement("link").relList.supports("preload")}catch(e){ret=!1}
return function(){return ret}})();rp.bindMediaToggle=function(link){var finalMedia=link.media||"all";function enableStylesheet(){link.media=finalMedia}
if(link.addEventListener){link.addEventListener("load",enableStylesheet)}else if(link.attachEvent){link.attachEvent("onload",enableStylesheet)}
setTimeout(function(){link.rel="stylesheet";link.media="only x"});setTimeout(enableStylesheet,3000)};rp.poly=function(){if(rp.support()){return}
var links=w.document.getElementsByTagName("link");for(var i=0;i<links.length;i++){var link=links[i];if(link.rel==="preload"&&link.getAttribute("as")==="style"&&!link.getAttribute("data-loadcss")){link.setAttribute("data-loadcss",!0);rp.bindMediaToggle(link)}}};if(!rp.support()){rp.poly();var run=w.setInterval(rp.poly,500);if(w.addEventListener){w.addEventListener("load",function(){rp.poly();w.clearInterval(run)})}else if(w.attachEvent){w.attachEvent("onload",function(){rp.poly();w.clearInterval(run)})}}
if(typeof exports!=="undefined"){exports.loadCSS=loadCSS}
else{w.loadCSS=loadCSS}}(typeof global!=="undefined"?global:this))
</script>
<!-- Bootstrap 4 style for footer on others frameworks -->
<style>footer{display:block}footer p{margin-top:0;margin-bottom:1rem}footer ul{margin-top:0;margin-bottom:1rem}footer a{color:#007bff;text-decoration:none;background-color:transparent}footer img{vertical-align:middle;border-style:none}footer .h4{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}footer .h4{font-size:1.5rem}footer .list-unstyled{padding-left:0;list-style:none}footer img{page-break-inside:avoid}footer p{orphans:3;widows:3}footer .pl-3,footer .px-3{padding-left:1rem!important}footer .pr-3,footer .px-3{padding-right:1rem!important}footer .d-block{display:block!important}footer .mb-4,footer .my-4{margin-bottom:1.5rem!important}footer .align-items-center{-ms-flex-align:center!important;align-items:center!important}footer .justify-content-center{-ms-flex-pack:center!important;justify-content:center!important}footer .d-flex{display:-ms-flexbox!important;display:flex!important}footer.mt-5,footer .my-5{margin-top:3rem!important}footer.border-secondary, footer .border-secondary{border-color:#6c757d!important}footer.border-top, footer .border-top{border-top:1px solid #dee2e6!important}footer.bg-light{background-color:#f8f9fa!important}footer .text-secondary{color:#6c757d!important}footer .text-center{text-align:center!important}footer .pb-4,footer .py-4{padding-bottom:1.5rem!important}footer .pt-4,footer .py-4{padding-top:1.5rem!important}footer .mb-0,footer .my-0{margin-bottom:0!important}footer .text-dark{color:#343a40!important}footer .container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}footer .row{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}footer .col,footer .col-md-3,footer .col-sm-6{position:relative;width:100%;padding-right:15px;padding-left:15px}footer .col{-ms-flex-preferred-size:0;flex-basis:0%;-ms-flex-positive:1;flex-grow:1;max-width:100%}@media (min-width:576px){footer .container{max-width:540px}footer .col-sm-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}}@media (min-width:768px){footer .container{max-width:720px}footer.text-md-left{text-align:left!important}footer .col-md-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}}</style>
