<?php
use phpformbuilder\Form;

session_start();
include_once '../phpformbuilder/Form.php';

$forms = array();
$output = array();
?>
<!doctype html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder - jQuery plugins - documentation, examples with code',
            'description' => 'PHP Form Builder Library includes the very best jQuery plugins. Add any plugin to your form with a single line of code - Save and recall your jQuery plugin configurations',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/jquery-plugins.php',
            'screenshot'  => 'jquery-plugins.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}.dmca-badge{min-height:100px}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}article,nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2,h3{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}small{font-size:80%}sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sup{top:-.5em}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}code,pre{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}img{vertical-align:middle;border-style:none}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button,input,optgroup,select{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}[type=submit],button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h4,h1,h2,h3{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}h3{font-size:26.25px}.h4{font-size:22.5px}small{font-size:80%;font-weight:400}code{font-size:87.5%;color:#e83e8c;word-break:break-word}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;box-shadow:inset 0 1px 1px rgba(0,0,0,.075);transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}select.form-control:not([size]):not([multiple]){height:calc(2.25rem + 2px)}.form-group{margin-bottom:1rem}.form-check-input{position:absolute;margin-top:.3rem;margin-left:-1.25rem}.form-check-inline .form-check-input{position:static;margin-top:0;margin-right:.3125rem;margin-left:0}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-success{color:#fff;background-color:#0f9e7b;border-color:#0f9e7b;box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.btn-group{position:relative;display:inline-flex;vertical-align:middle}.btn-group>.btn{position:relative;flex:0 1 auto}.btn-group .btn+.btn{margin-left:-1px}.btn-group>.btn:first-child{margin-left:0}.btn-group>.btn:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.nav{display:flex;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.nav-pills .nav-link.active{color:#fff;background-color:#007bff}.navbar{position:relative;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.d-inline-block{display:inline-block!important}.mb-4,.my-4{margin-bottom:1.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.d-none{display:none!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:flex!important}.flex-column{flex-direction:column!important}.flex-grow-1{flex-grow:1!important}.justify-content-between{justify-content:space-between!important}.align-items-center{align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.mr-1{margin-right:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.h4{margin-bottom:1rem!important}.my-4{margin-top:1.5rem!important}.mb-4,.my-4,h3{margin-bottom:1.5rem!important}.has-separator,h2{margin-bottom:3rem!important}.mb-6{margin-bottom:6.25rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0,pre>code[class*=language]{padding-right:0!important}.px-0,pre>code[class*=language]{padding-left:0!important}.pt-1{padding-top:.25rem!important}code[class*=language]{padding-right:.25rem!important}code[class*=language]{padding-left:.25rem!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.pb-5{padding-bottom:3rem!important}.pb-7{padding-bottom:12.5rem!important}.ml-auto{margin-left:auto!important}.text-center{text-align:center!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:flex;flex-wrap:nowrap;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;justify-content:center;align-items:stretch;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;animation:.4s animateleft}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>a.active{background-color:#a93030}[class^=icon-]{font-family:icomoon;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}.h4,h1,h2,h3{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1#jquery-plugins-title span,h1::first-letter{font-size:2em;font-weight:500}h1#jquery-plugins-title::first-letter{font-size:1em;font-weight:400}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}.h4,h3{font-weight:300;color:#a9a398}h3{font-variant:small-caps}.h4 small{font-size:1rem;font-weight:300;line-height:1;font-variant:normal}code,code[class*=language],pre{font-size:.75rem}article>h3:before{content:'';display:inline-block;width:8px;height:8px;margin-right:10px;margin-bottom:3px;border-radius:50%;background:#00c2db}article>h3:before{background:#00c2db}.output-code>pre:after{font-family:Roboto;font-size:.8125rem;position:absolute;top:0;right:0;padding:0 15px;height:24px;line-height:24px;background:#46423b;color:#fff;border-radius:0 .25rem}.output-code{position:relative}.output-code>pre:after{content:'output-code'}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.has-separator{display:block;position:relative}.has-separator:after,.has-separator:before{position:absolute;left:50%;height:1px;content:'';background:#c6c2bb}.has-separator:before{bottom:-16px;width:12%;margin-left:-6%}.has-separator:after{bottom:-13px;width:20%;margin-left:-10%}code[class*=language-],pre[class*=language-]{position:relative;color:#ccc;background:0 0;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;tab-size:4;-webkit-hyphens:none;hyphens:none}pre[class*=language-]{padding:1em;margin:.5em 0;overflow:auto;border-radius:.25rem!important}pre[class*=language-]{background:#2d2d2d}pre[class*=language-].line-numbers{padding-left:3.8em;counter-reset:a}pre[class*=language-].line-numbers>code{position:relative;white-space:inherit}select.selectpicker{display:none!important}
    </style>
    <?php require_once 'inc/css-includes.php'; ?>
</head>
<body style="padding-top:76px;" data-spy="scroll" data-target="#navbar-left-wrapper" data-offset="180">

    <!--LSHIDE-->

    <!-- Main navbar -->

    <nav id="website-navbar" class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand mr-3" href="https://www.phpformbuilder.pro"><img src="assets/images/phpformbuilder-logo.png" width="60" height="60" class="mr-3" alt="PHP Form Builder" title="PHP Form Builder">PHP Form Builder</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">

                    <!-- https://www.phpformbuilder.pro navbar -->

                    <li class="nav-item" role="presentation"><a class="nav-link" href="../index.html">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../drag-n-drop-form-builder/index.html">Drag &amp; drop Form Builder</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="quick-start-guide.php">Quick Start Guide</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../templates/index.php">Form Templates</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="jquery-plugins.php">jQuery Plugins</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="code-samples.php">Code Samples</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="class-doc.php">Class Doc.</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="functions-reference.php">Functions Reference</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="help-center.php">Help Center</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--/LSHIDE-->

    <!-- Main sidebar -->

    <div class="navbar-light p-2 d-lg-none d-xlg-none">
        <button id="navbar-left-toggler" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
    </div>
    <div id="navbar-left-wrapper" class="w3-animate-left">
        <a href="#" id="navbar-left-collapse" class="d-inline-block d-lg-none d-xlg-none float-right text-white p-4"><i class="fas fa-times"></i></a>
        <ul id="navbar-left" class="nav nav-pills flex-column pt-1 mb-4" role="tablist" aria-orientation="vertical">
            <li class="nav-item"><p class="h4 text-center my-4">jQuery Plugins<br><small>Overview</small></p></li>
            <li class="nav-item"><a class="nav-link active" href="#the-addplugin-function">The addPlugin Function</a></li>
            <li class="nav-item"><a class="nav-link" href="#plugins-overview">Activating a plugin</a></li>
            <li class="nav-item"><a class="nav-link" href="#plugin-files-and-configuration">Plugin files & configuration</a></li>
            <li class="nav-item"><a class="nav-link" href="#optimization">Optimization (CSS & JS)</a></li>
            <li class="nav-item"><a class="nav-link" href="#optimization-with-loadjs">Optimization with LoadJs</a></li>
            <li class="nav-item"><a class="nav-link" href="#customizing-plugins">Customizing plugins</a></li>
            <li class="nav-item"><a class="nav-link" href="#adding-your-own-plugins">Adding your own plugins</a></li>
            <li class="nav-item"><a class="nav-link" href="#credits">Credits (plugins list)</a></li>
            <li class="nav-item"><p class="h4 text-center my-4">jQuery Plugins<br><small>Usage & Code examples</small></p></li>
            <li class="nav-item"><a class="nav-link" href="#autocomplete-example">Autocomplete</a></li>
            <li class="nav-item"><a class="nav-link" href="#autocomplete-with-ajax-call-example">Autocomplete + Ajax</a></li>
            <li class="nav-item"><a class="nav-link" href="#bootstrap-select-example">Bootstrap Select</a></li>
            <li class="nav-item"><a class="nav-link" href="#captcha-example">Captcha</a></li>
            <li class="nav-item"><a class="nav-link" href="#colorpicker-example">Colorpicker</a></li>
            <li class="nav-item"><a class="nav-link" href="#dependent-fields-example">Dependent fields</a></li>
            <li class="nav-item"><a class="nav-link" href="#fileuploader">File Uploader</a></li>
            <li class="nav-item"><a class="nav-link" href="#formvalidation">Formvalidation</a></li>
            <li class="nav-item"><a class="nav-link" href="#icheck-example">Icheck</a></li>
            <li class="nav-item"><a class="nav-link" href="#image-picker-example">Image Picker</a></li>
            <li class="nav-item"><a class="nav-link" href="#intl-tel-input-example">Intl Tel Input<br>(International Phone Numbers)</a></li>
            <li class="nav-item"><a class="nav-link" href="#ladda-example">Ladda (Buttons spinners)</a></li>
            <li class="nav-item"><a class="nav-link" href="#lcswitch-example">LC-Switch</a></li>
            <li class="nav-item"><a class="nav-link" href="#litepicker-example">Litepicker<br>(Date / Daterange picker)</a></li>
            <li class="nav-item"><a class="nav-link" href="#material-design">Material Design plugin (Materialize)</a></li>
            <li class="nav-item"><a class="nav-link" href="#material-datepicker-example">Material Date Picker</a></li>
            <li class="nav-item"><a class="nav-link" href="#material-timepicker-example">Material Time Picker</a></li>
            <li class="nav-item"><a class="nav-link" href="#modal-example">Modal</a></li>
            <li class="nav-item"><a class="nav-link" href="#nice-check-example">Nice Check</a></li>
            <li class="nav-item"><a class="nav-link" href="#passfield-example">Passfield</a></li>
            <li class="nav-item"><a class="nav-link" href="#pickadate-example">Pickadate (Date Picker)</a></li>
            <li class="nav-item"><a class="nav-link" href="#pickadate-timepicker-example">Pickadate (Time Picker)</a></li>
            <li class="nav-item"><a class="nav-link" href="#popover-example">Popover</a></li>
            <li class="nav-item"><a class="nav-link" href="#invisible-recaptcha-example">Invisible Recaptcha</a></li>
            <li class="nav-item"><a class="nav-link" href="#recaptchav2-example">Recaptcha V2</a></li>
            <li class="nav-item"><a class="nav-link" href="#recaptchav3-example">Recaptcha V3</a></li>
            <li class="nav-item"><a class="nav-link" href="#select2-example">Select2</a></li>
            <li class="nav-item"><a class="nav-link" href="#signature-pad-example">Signature pad</a></li>
            <li class="nav-item"><a class="nav-link" href="#tinymce-example">TinyMce</a></li>
            <li class="nav-item"><a class="nav-link" href="#tooltip-example">Tooltip</a></li>
            <li class="nav-item"><a class="nav-link" href="#wordcharactercount-example">Word / Character counter</a></li>
        </ul>
        <div class="text-center mb-xs"><a href="//www.dmca.com/Protection/Status.aspx?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" title="DMCA.com Protection Status" class="dmca-badge"><img data-src="//images.dmca.com/Badges/dmca-badge-w100-1x1-01.png?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="lazyload" alt="DMCA.com Protection Status" width="100" height="100"></a><script defer src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"></script></div>
        <div class="text-center mb-7">
            <a href="https://www.hack-hunt.com" title="Send DMCA Takedown Notice" class="text-white">www.hack-hunt.com</a>
        </div>
        <!-- navbar-left -->
    </div>

    <!-- /main sidebar -->

    <div class="container" id="jquery-plugins-container">

        <?php include_once 'inc/top-section.php'; ?>

        <h1 id="jquery-plugins-title">j<span>Q</span>uery plugins</h1>
        <h2>Overview</h2>
        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="the-addplugin-function">The addPlugin Function</h3>
                <pre><code class="language-php">$form->addPlugin($plugin_name, $selector, [$js_config = 'default', $js_replacements = ''])</code></pre>
                <pre class="line-numbers mb-6"><code class="language-php">    /**
* Adds a javascript plugin to the selected field(s)
* @param string $plugin_name The name of the plugin,
*                            must be the name of the xml file
*                            in plugins-config dir
*                            without extension.
*                            Example: colorpicker
* @param string $selector The jQuery style selector.
*                         Examples: #colorpicker
*                                    .colorpicker
* @param string $js_config (Optional) The xml node where your plugin code is
*                                      in plugins-config/[your-plugin.xml] file
* @param array $js_replacements (Optional) An associative array containing
*                                          the strings to search as keys
*                                          and replacement values as data.
*                                          Strings will be replaced with data
*                                          in &lt;js_code&gt; xml node of your
*                                          plugins-config/[your-plugin.xml] file.
*/</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="plugins-overview">Activating a plugin</h3>
                <p class="lead">Adding plugins with PHP Form Builder is deadly fast and straightforward:</p>
                <ol class="list-timeline">
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">1</span>
                        <span class="timeline-content">Create your field. ie: <code class="language-php">$form->addInput('text', 'my-date', '', 'Pickup a date');</code></span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">2</span>
                        <span class="timeline-content">Add the plugin. ie: <code class="language-php">$form->addPlugin('pickadate', '#my-date');</code></span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">3</span>
                        <span class="timeline-content">Call <code class="language-php">$form->printIncludes('css');</code> in your <code class="language-php">&lt;head&gt;</code> section</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">4</span>
                        <span class="timeline-content">Call <code class="language-php">$form->printIncludes('js');</code> then <code class="language-php">$form->printJsCode();</code> just before <code class="language-php">&lt;/body&gt;</code></span>
                    </li>
                </ol>

                <p>This will add the <span class="var-value">pickadate</span> plugin to the input named <span class="var-value">my-date</span>.<br>The plugin will use its default configuration stored in <span class="file-path">phpformbuilder/plugins-config/pickadate.xml</span></p>
                <div class="alert alert-info has-icon my-5">
                    <p><code class="language-php">printIncludes('css')</code>, <code class="language-php">printIncludes('js')</code> and <code class="language-php">printJsCode()</code> must be called only once,<br>even if your form uses several plugins.</p>
                </div>
                <p><strong>You can easily:</strong></p>
                <ul class="ml-5">
                    <li><a href="#customizing-plugins">Customize and store several plugin configs for further use</a>,<br></li>
                    <li><a href="#adding-your-own-plugins">Add your own plugins</a>.</li>
                </ul>
            </article>
        </section>

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="plugin-files-and-configuration">Plugin files & configuration</h3>
                <div class="pl-5 mb-5">
                    <h4>Plugins</h4>
                    <p>The plugin files are located in <span class="file-path">phpformbuilder/phpformbuilder/plugins/</span></p>
                </div>
                <div class="pl-5 mb-5">
                    <h4>Plugins configuration (XML configuration files)</h4>
                    <p>The plugins XML configuration files are located in <span class="file-path">phpformbuilder/phpformbuilder/plugins-config/</span></p>
                </div>
                <div class="pl-5 mb-5">
                    <h4>CSS & JS dependencies</h4>
                    <p>Each plugin has its own dependencies in its folder inside <span class="file-path">phpformbuilder/phpformbuilder/plugins/</span></p>
                    <p>PHP Form Builder generates a single compiled and minified CSS file for each form which includes all the plugins css used by the form.</p>
                    <p>The plugins JS dependencies are compiled the same way.</p>
                    <p>These compiled files are located in <span class="file-path">phpformbuilder/plugins/min/css</span> and <span class="file-path">phpformbuilder/plugins/min/js</span> folders.</p>
                </div>
            </article>
        </section>

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="optimization">Optimization (CSS & JS dependencies)</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->setMode($mode);</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt><var>$mode</var> <span class="var-type">[String]</span></dt>
                            <dd><span class="var-value">'development'</span> or <span class="var-value">'production'</span><br>The default mode is 'production' until you change it with the <code class="language-php">setMode($mode)</code> function.</dd>
                        </dl>
                    </div>
                </div>
                <h4 class="mb-2">The development mode</h4>
                <p>When your form is in <span class="var-value">'development'</span> mode:</p>
                <ul class="ml-5">
                    <li><code class="language-php">$form->printIncludes('css');</code> will add each plugin CSS dependencies to your page</li>
                    <li><code class="language-php">$form->printIncludes('js');</code> will add each plugin Javascript dependencies to your page</li>
                </ul>
                <p class="mb-6">The <span class="var-value">'development'</span> mode is useful to inspect or debug your code, but you'll have many CSS & Javascript files to load, depending on the number of plugins that your form uses.</p>
                <h4 class="mb-2">The production mode</h4>
                <p>When your form is in <span class="var-value">production</span> mode:</p>
                <p>When you call <code class="language-php">$form->printIncludes('css');</code> or <code class="language-php">$form->printIncludes('js');</code>, all plugins assets (plugin's CSS and Javascript dependencies) are <strong>compressed and minified for fast loading</strong> in a single js|css file in <span class="file-path">phpformbuilder/plugins/min/[css|js]/[framework-][form-name].min.[css|js]</span>.</p>
                <p>Your form will load a single CSS file and a single Javascript file instead of a file for each plugin, which greatly improves performance.</p>
                <p class="alert alert-warning has-icon">Your <span class="file-path">phpformbuilder/plugins/min/[css|js]/</span> dir has to be writable (chmod 0755+)</p>
            </article>
        </section>

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="optimization-with-loadjs">Optimization with LoadJs</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->useLoadJs($bundle = '');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt><var>$bundle</var> <span class="var-type">[String]</span></dt>
                            <dd>Optional bundle name to wait for before triggering the domReady events</dd>
                        </dl>
                    </div>
                </div>
                <h4 class="mb-2">About LoadJs library</h4>
                <p><a href="https://github.com/muicss/loadjs" title="LoadJs library">LoadJs</a> is a tiny async loader / dependency manager for modern browsers (789 bytes)</p>
                <p>Used with PHP Form Builder it allows to load the plugins CSS & JS dependencies asynchronously without blocking your page rendering.</p>
                <p>Wen you enable LoadJs, <code class="language-php">$form->printJsCode();</code> will load all the CSS & JS dependencies.</p>
                <ul>
                    <li>Don't call <code class="language-php">$form->printIncludes('css');</code>: the CSS files will be loaded with LoadJs</li>
                    <li>Don't call <code class="language-php">$form->printIncludes('js');</code> except if your form uses Recaptcha or Invisible Recaptcha</li>
                </ul>
                <h4>Example</h4>
                <pre class="line-numbers mb-4"><code class="language-php">&lt;?php
$form = new Form('my-form', 'horizontal');

$form->useLoadJs();

$form->addInput('text', 'my-color', '', 'Pick a color:');
$form->addPlugin('colorpicker', '#my-color');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->render();
?&gt;
&lt;script src=&quot;https://cdnjs.cloudflare.com/ajax/libs/loadjs/3.5.5/loadjs.min.js&quot;&gt;&lt;/script&gt;

&lt;!-- The following line will load the plugins CSS & JS dependencies --&gt;

&lt;?php $form->printJsCode(); ?&gt;</code></pre>
                <h4>Example 2: wait for your bundle before triggering the domReady events</h4>
                <pre class="line-numbers mb-4"><code class="language-php">&lt;?php
$form = new Form('my-form', 'horizontal');

$form->useLoadJs('core');

$form->addInput('text', 'my-color', '', 'Pick a color:');
$form->addPlugin('colorpicker', '#my-color');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->render();
?&gt;

&lt;script src=&quot;https://cdnjs.cloudflare.com/ajax/libs/loadjs/3.5.5/loadjs.min.js&quot;&gt;&lt;/script&gt;

&lt;script&gt;
// loading jQuery with loadJs (core bundle)
loadjs(['assets/javascripts/jquery-3.3.1.min.js'], 'core');

// Core's loaded - do any stuff
loadjs.ready('core', function() {
   // ...
});
&lt;/script&gt;

&lt;!-- load the form CSS & JS dependencies
Trigger domready when the core bundle and the form JS dependencies are loaded --&gt;
&lt;?php $form->printJsCode('core'); ?&gt;</code></pre>
            </article>
        </section>

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="customizing-plugins">Customizing plugins</h3>
                <p>Each plugin has it's own XML configuration file in <span class="file-path">plugins-config</span> directory.</p>
                <p>The XML structure is always the same: </p>
                <pre class="line-numbers mb-4"><code class="language-php">&lt;root&gt;
    &lt;default&gt;
        &lt;includes&gt;
            &lt;css&gt;
                &lt;file&gt;../../phpformbuilder/plugins/[plugin dir]/[plugin].css&lt;/file&gt;
            &lt;/css&gt;
            &lt;js&gt;
                &lt;file&gt;../../phpformbuilder/plugins/[plugin dir]/[plugin].js&lt;/file&gt;
            &lt;/js&gt;
        &lt;/includes&gt;
        &lt;js_code&gt;
            &lt;![CDATA[
                $(&quot;%selector%&quot;).[function]();
            ]]&gt;
        &lt;/js_code&gt;
    &lt;/default&gt;
&lt;/root&gt;</code></pre>
                <ul class="ml-5 mb-5">
                    <li>The <code class="language-php">addPlugin</code> function has 4 arguments: <code class="language-php">$plugin_name</code>, <code class="language-php">$selector</code>, <code class="language-php">$js_config</code> and <code class="language-php">$js_replacements</code></li>
                    <li><code class="language-php">$js_config</code> indicates the XML node you targets. Default value: <span class="var-value">default</span>.</li>
                    <li><code class="language-php">$selector</code> will replace <code class="language-php">&quot;%selector%&quot;</code> in XML.</li>
                </ul>
                <h4>To customize your plugin:</h4>
                <p>To preserve <span class="file-path">plugins-config</span> folder intact the best way is to duplicate the plugin's xml file into <span class="file-path">plugins-config-custom</span> folder.<br>This way you'll be able to update PHP Form Builder's package without overwriting your personal config.</p>
                <p class="mb-md">Form will always look for a custom xml file in <span class="file-path">plugins-config-custom</span> folder, and load the default one in <span class="file-path">plugins-config</span> if custom doesn't exist.</p>
                <p class="alert alert-info has-icon my-5">You can use both default &amp; custom config in the same form. No need to duplicate default xml nodes in your custom xml file.</p>
                <ol class="list-timeline mb-5">
                    <li class="d-flex align-items-start pb-2">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">1</span>
                        <span class="timeline-content">Copy the <code class="language-php">&lt;default&gt;</code> node structure and give it a name<br>(for example, replace '<var>&lt;default&gt;</var>' with '<var>&lt;custom&gt;</var>')</span>
                    </li>
                    <li class="d-flex align-items-start pb-2">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">2</span>
                        <span class="timeline-content">if the <code class="language-php">&lt;includes&gt;</code> node has no need to be modified, delete it from your structure:<br>default's include node will be used instead.</span>
                    </li>
                    <li class="d-flex align-items-start pb-2">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">3</span>
                        <span class="timeline-content">Enter your js code in <code class="language-php">&lt;js_code&gt;</code> node</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">4</span>
                        <span class="timeline-content">If you need others replacements than <code class="language-php">%selector%</code> in your js code, use custom markup like <code class="language-php">%my-value%</code> in XML, than define them in <code class="language-php">$js_replacements</code> when you call <code class="language-php">addPlugin.</code>.</span>
                    </li>
                </ol>
                <h4>Customizing plugin example</h4>
                <pre class="line-numbers"><code class="language-php">$js_replacements = array('%my-value%' => 'replacement-text');
$form->addPlugin('captcha', '$captcha', 'custom', $js_replacements);</code></pre>
            </article>
        </section>

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="adding-your-own-plugins">Adding your own plugins</h3>
                <p class="lead">You can easily add any jQuery plugin to PHP Form Builder. Here's how to process:</p>
                <ol class="list-timeline">
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">1</span>
                        <span class="timeline-content">Upload your plugin in <span class="file-path">plugin</span> dir.</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">2</span>
                        <span class="timeline-content">Create an XML file with the name of your plugin in <span class="file-path">plugins-config-custom</span> dir,<br>using the tree described in <a href="#customizing-plugins">Customizing Plugins</a> section</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">3</span>
                        <span class="timeline-content">Call your plugin with <a href="#addPlugin"><code class="language-php">addPlugin</code></a> function</span>
                    </li>
                </ol>
            </article>
        </section>

        <section class="py-7">
            <h3 id="credits">Credits (plugins list)</h3>
            <p class="lead py-4">PHP Form Builder includes the following jQuery plugins:</p>
            <ul class="ml-5 mb-6">
                <li>autocomplete - <a href="http://jqueryui.com/autocomplete/">http://jqueryui.com/autocomplete/</a></li>
                <li>bootstrap-select - <a href="http://silviomoreto.github.io/bootstrap-select/">http://silviomoreto.github.io/bootstrap-select/</a></li>
                <li>captcha - <a href="http://keith-wood.name/realPerson.html">http://keith-wood.name/realPerson.html</a></li>
                <li>colorpicker - <a href="https://github.com/josedvq/colpick-jQuery-Color-Picker">https://github.com/josedvq/colpick-jQuery-Color-Picker</a></li>
                <li>dependent-fields - <span class="text-muted">PHP Form Builder custom plugin</span></li>
                <li>fileuploader - <a href="https://innostudio.de/fileuploader/">https://innostudio.de/fileuploader/</a></li>
                <li>formvalidation - <a href="https://formvalidation.io/">https://formvalidation.io/</a></li>
                <li>iCheck - <a href="http://icheck.fronteed.com">http://icheck.fronteed.com</a></li>
                <li>image-picker - <a href="https://github.com/rvera/image-picker">https://github.com/rvera/image-picker</a></li>
                <li>intl-tel-input - <a href="https://github.com/jackocnr/intl-tel-input">https://github.com/jackocnr/intl-tel-input</a></li>
                <li>invisible-recaptcha - <a href="https://developers.google.com/recaptcha/docs/invisible">https://developers.google.com/recaptcha/docs/invisible</a></li>
                <li>ladda - <a href="https://github.com/hakimel/Ladda">https://github.com/hakimel/Ladda</a></li>
                <li>lcswitch - <a href="https://lcweb.it/lc-switch-jquery-plugin">https://lcweb.it/lc-switch-jquery-plugin</a></li>
                <li>materialize - <a href="http://materializecss.com">http://materializecss.com</a></li>
                <li>modal - <a href="http://vodkabears.github.io/remodal/">http://vodkabears.github.io/remodal/</a></li>
                <li>nicecheck - <span class="text-muted">PHP Form Builder custom plugin</span></li>
                <li>passfield - <a href="http://antelle.github.io/passfield">http://antelle.github.io/passfield</a></li>
                <li>pickadate - <a href="http://amsul.ca/pickadate.js/">http://amsul.ca/pickadate.js/</a></li>
                <li>pickadate-material - <span class="text-muted">(customized from pickadate)</span></li>
                <li>popover - <a href="https://github.com/sandywalker/webui-popover">https://github.com/sandywalker/webui-popover</a></li>
                <li>recaptcha - <a href="https://www.google.com/recaptcha/intro/v3beta.html">https://www.google.com/recaptcha/intro/v3beta.html</a></li>
                <li>select2 - <a href="https://github.com/select2/select2">https://github.com/select2/select2</a></li>
                <li>timepicker - <a href="https://github.com/jonthornton/jquery-timepicker">https://github.com/jonthornton/jquery-timepicker</a></li>
                <li>tinymce - <a href="https://www.tiny.cloud/">https://www.tiny.cloud/</a></li>
                <li>tooltip - <a href="http://qtip2.com/">http://qtip2.com/</a></li>
                <li>word-character-count - <span class="text-muted">PHP Form Builder custom plugin</span></li>
            </ul>
            <p class="lead text-center has-separator">Thanks to all the authors for their great work</p>
        </section>

        <h2 id="autocomplete-example">jQuery Plugins <small>Usage & Code examples</small></h2>

        <!-- autocomplete -->

        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h3>Autocomplete - <small><a href="https://jqueryui.com/autocomplete/">https://jqueryui.com/autocomplete/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('autocomplete', '#selector', 'default', $complete_list);</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'autocomplete' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>'default' <span class="var-type">[String]</span></dt>
                            <dd><span class="var-value">'default'</span> configuration will use the following <code class="language-php">$complete_list</code> to autocomplete.</dd>
                            <dd class="line-break"></dd>
                            <dt>$complete_list <span class="var-type">[Array]</span></dt>
                            <dd><code class="language-php">$complete_list</code> is an associative array with <span class="var-value">'%availableTags%'</span> as single key, and terms for completion as value (see code below).</dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="autocomplete-example-wrapper" data-min-height="931">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>

            <!-- autocomplete + Ajax -->

            <article class="pb-5 mb-7 has-separator">
                <h3 id="autocomplete-with-ajax-call-example">Autocomplete with ajax call</h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('autocomplete', '#selector', $config, $replacements);</code></pre>
                        <h4 class="mb-2 border-bottom">Arguments: </h4>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'autocomplete' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>$config <span class="var-type">[String]</span></dt>
                            <dd><span class="var-value">'remote'</span> configuration will call a file using ajax to autocomplete.<br><span class="var-value">'remote-tags'</span> configuration will call a file using ajax to autocomplete and will fill the input with sortable tags.</dd>
                            <dd class="line-break"></dd>
                            <dt>$replacements <span class="var-type">[Array]</span></dt>
                            <dd>
                                An associative array with:
                                <dl class="dl-horizontal mb-0">
                                    <dt><span class="var-value">'%remote%'</span></dt>
                                    <dd>[url of your ajax file]</dd>
                                    <dd class="line-break"></dd>
                                    <dt><span class="var-value">'%minLength%'</span></dt>
                                    <dd>minimum number of characters filled to call ajax autocomplete</dd>
                                    <dd class="line-break"></dd>
                                </dl>
                            </dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Options: </h4>
                        <p>Options are available for the <span class="var-value">'remote-tags'</span> config only.<br>Pass options with data attributes. Example:</p>
                        <pre class="mb-4"><code class="language-php">$form->addInput('text', 'my-search-input', '', 'First name:', 'data-maxTags=3, data-placeholder=Search here ...');</code></pre>
                        <p class="mb-0">Data-attribute list is available at <a href="https://goodies.pixabay.com/jquery/tag-editor/demo.html">https://goodies.pixabay.com/jquery/tag-editor/demo.html</a></p>
                    </div>
                </div>
                <div id="autocomplete-with-ajax-call-example-wrapper" data-min-height="553">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- bootstrap-select -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="bootstrap-select-example">Bootstrap Select - <small><a href="http://silviomoreto.github.io/bootstrap-select/">http://silviomoreto.github.io/bootstrap-select/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addSelect($select_name, $label, 'class=selectpicker show-tick');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Bootstrap select</em> plugin, add the <em>selectpicker</em> class to the select element.<br>there is no need to call the <em>"addPlugin"</em> function.</p>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>$select_name <span class="var-type">[String]</span></dt>
                            <dd>The select field name</dd>
                            <dd class="line-break"></dd>
                            <dt>$label <span class="var-type">[String]</span></dt>
                            <dd>The select field label</dd>
                            <dd class="line-break"></dd>
                            <dt>$attr <span class="var-type">[String]</span></dt>
                            <dd>the select field attributes <a href="class-doc.html#attr" class="badge badge-secondary badge-lg ml-2"><i class="fa fa-link mr-2"></i>documentation</a></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Options: </h4>
                        <p>Pass options with data attributes. Example:</p>
                        <pre class="mb-4"><code class="language-php">$form->addSelect('select-name', 'Label', 'class=selectpicker, data-icon-base=glyphicon');</code></pre>
                        <p class="mb-0">Data-attribute list is available at <a href="https://developer.snapappointments.com/bootstrap-select/options/#bootstrap-version">https://developer.snapappointments.com/bootstrap-select/options/#bootstrap-version</a></p>
                    </div>
                </div>
                <div id="bootstrap-select-example-wrapper" data-min-height="2066">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- captcha -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="captcha-example">Captcha - <small><a href="http://keith-wood.name/realPerson.html">http://keith-wood.name/realPerson.html</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('captcha', '#selector');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'captcha' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                        </dl>
                    </div>
                </div>
                <div id="captcha-example-wrapper" data-min-height="388">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- colorpicker -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="colorpicker-example">Colorpicker - <small><a href="https://github.com/josedvq/colpick-jQuery-Color-Picker">https://github.com/josedvq/colpick-jQuery-Color-Picker</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('colorpicker', '#selector', 'default');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'colorpicker' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>'default' <span class="var-type">[String]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/colorpicker.xml</span> - see <em>Available configurations</em> below</dd>
                        </dl>
                        <p class="h4 mb-2 border-bottom">Available configurations:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'default' | null</dt>
                            <dd>default colorpicker</dd>
                            <dd class="line-break"></dd>
                            <dt>'colored-input'</dt>
                            <dd>The color is rendered inside the input field</dd>
                            <dd class="line-break"></dd>
                            <dt>'dark-sheme'</dt>
                            <dd>Custom dark colors</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="medium mb-0">You can add your own configurations in <span class="file-path">phpformbuilder/plugins-config/colorpicker.xml</span></p>
                    </div>
                </div>
                <div id="colorpicker-example-wrapper" data-min-height="742">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- dependent-fields -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="dependent-fields-example">Dependent Fields</h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->startDependentFields($parent_field, $show_values[, $inverse = false]);
// add the dependent fields here
$form->endDependentFields();
</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>$parent_field <span class="var-type">[String]</span></dt>
                            <dd>The name of the field which will trigger show/hide on dependent fields</dd>
                            <dd class="line-break"></dd>
                            <dt>$show_values <span class="var-type">[String]</span></dt>
                            <dd>The value(s) (single value or comma separated values) that will show the dependent fields if one is selected</dd>
                            <dd class="line-break"></dd>
                            <dt>$inverse <span class="text-secondary mx-2">[optional]</span> <span class="var-type">[Boolean]</span></dt>
                            <dd>if <span class="var-value">true</span>, dependent fields will be shown if any other value than <code class="language-php">$show_values</code> is selected.<br>default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="medium">The dependent fields block is hidden and will be shown if <code class="language-php">$parent_field</code> changes to one of <code class="language-php">$show_values</code>.</p>
                        <p class="medium">Don't forget to call <code class="language-php">endDependentFields</code> to end your Dependent Fields block.</p>
                        <p class="medium">Each Dependent fields block can include one or several dependent fields blocks.</p>
                        <p class="alert alert-warning has-icon mb-0">Dependent fields MUST NOT START with the same fieldname as their parent field.</p>
                    </div>
                </div>
                <div id="dependent-fields-example-wrapper" data-min-height="455">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- fileupload -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="fileuploader">FileUploader - <small><a href="https://innostudio.de/fileuploader/">https://innostudio.de/fileuploader/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addFileUpload($type, $name, $value, $label, $attr, $fileUpload_config, $current_file);</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>$type <span class="var-type">[String]</span></dt>
                            <dd>The field type<br>Usually: <span class="var-value">file</span></dd>
                            <dd class="line-break"></dd>
                            <dt>$name <span class="var-type">[String]</span></dt>
                            <dd>The field name</dd>
                            <dd class="line-break"></dd>
                            <dt>$value<span class="var-type">[String]</span></dt>
                            <dd>The field value</dd>
                            <dd class="line-break"></dd>
                            <dt>$label <span class="var-type">[String]</span></dt>
                            <dd>The field label</dd>
                            <dd class="line-break"></dd>
                            <dt>$attr <span class="var-type">[String]</span></dt>
                            <dd>The field attributes<a href="class-doc.html#attr" class="badge badge-secondary badge-lg ml-2"><i class="fa fa-link mr-2"></i>documentation</a></dd>
                            <dd class="line-break"></dd>
                            <dt>$fileUpload_config<span class="text-secondary ml-2">[optional]</span> <span class="var-type">[Array]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/fileuploader.xml</span><br>See <em>Ready-to-use configurations</em> below</dd>
                            <dd class="line-break"></dd>
                            <dt>$current_file  <span class="var-type">[Array]</span></dt>
                            <dd>File data if the uploader has to be loaded with an existing file.<br>Useful for update purpose.<br>Example of use here: <a href="../templates/bootstrap-4-forms/fileupload-test-form.php">templates/bootstrap-4-forms/fileupload-test-form.php</a></dd>
                            <dd class="line-break"></dd>
                        </dl>

                        <h4 class="mb-2 border-bottom">Ready-to-use configurations</h4>

                        <p>File Uploader is supplied with several ready xml configs:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'default'</dt>
                            <dd>uploader: <span class="file-path">phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php</span></dd>
                            <dd class="line-break"></dd>
                            <dt>'image-upload'</dt>
                            <dd>uploader: <span class="file-path">phpformbuilder/plugins/fileuploader/drag-and-drop/ajax_upload_file.php</span></dd>
                            <dd class="line-break"></dd>
                            <dt>'drag-and-drop'</dt>
                            <dd>uploader: <span class="file-path">phpformbuilder/plugins/fileuploader/image-upload/php/ajax_upload_file.php</span></dd>
                            <dd class="line-break"></dd>
                        </dl>

                        <h4 class="mb-2 border-bottom">$fileUpload_config - default configuration</h4>
                        <pre class="mb-4"><code class="language-php">$default_config = array(
    'xml'           => 'default',
    'uploader'      => 'ajax_upload_file.php',
    'upload_dir'    => '../../../../../file-uploads/',
    'limit'         => 1,
    'extensions'    => ['jpg', 'jpeg', 'png', 'gif'],
    'file_max_size' => 5,
    'thumbnails'    => false,
    'editor'        => false,
    'width'         => null,
    'height'        => null,
    'crop'          => false,
    'debug'         => false
);</code></pre>

                        <h4 class="mb-2 border-bottom">$fileUpload_config - arguments</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'xml' <span class="var-type ml-2">[String]</span></dt>
                            <dd>name of the XML configuration node called in <span class="file-path">phpformbuilder/plugins-config/fileuploader.xml</span></dd>
                            <dd class="line-break"></dd>
                            <dt>'uploader' <span class="var-type ml-2">[String]</span></dt>
                            <dd>name of the PHP uploader file in <span class="file-path">phpformbuilder/plugins/fileuploader/[xml-node-name]/</span></dd>
                            <dd class="line-break"></dd>
                            <dt>'upload_dir' <span class="var-type ml-2">[String]</span></dt>
                            <dd>path from the PHP uploader (ie: <span class="file-path">phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php</span>) to the upload directory</dd>
                            <dd class="line-break"></dd>
                            <dt>'limit' <span class="var-type ml-2">[Int]</span></dt>
                            <dd>Maximum number of uploaded files</dd>
                            <dd class="line-break"></dd>
                            <dt>'extensions'<span class="var-type ml-2">[Array]</span></dt>
                            <dd>Array with the allowed extensions</dd>
                            <dd class="line-break"></dd>
                            <dt>'file_max_size'<span class="var-type ml-2">[Int]</span></dt>
                            <dd>maximal file size in MB</dd>
                            <dd class="line-break"></dd>
                            <dt>'thumbnails'<span class="var-type ml-2">[Boolean]</span></dt>
                            <dd>For image upload - Create thumbnails (true|false) - thumbnails can be configured in the PHP image uploader in <span class="file-path">phpformbuilder/plugins/fileuploader/image-upload/php/ajax_upload_file.php</span></dd>
                            <dd class="line-break"></dd>
                            <dt>'editor'<span class="var-type ml-2">[Boolean]</span></dt>
                            <dd>For image upload - uploaded images can be clicked & edited by user (true|false)</dd>
                            <dd class="line-break"></dd>
                            <dt>'width'<span class="var-type ml-2">[Int|null]</span></dt>
                            <dd>For image upload - maximum image width in px. null = no limitation</dd>
                            <dd class="line-break"></dd>
                            <dt>'height'<span class="var-type ml-2">[Int|null]</span></dt>
                            <dd>For image upload - maximum image height in px. null = no limitation</dd>
                            <dd class="line-break"></dd>
                            <dt>'crop'<span class="var-type ml-2">[Boolean]</span></dt>
                            <dd>For image upload - crop image to fit the given width & height (true|false)</dd>
                            <dd class="line-break"></dd>
                            <dt>'debug'<span class="var-type ml-2">[Boolean]</span></dt>
                            <dd>log errors in the browser console (true|false)</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="alert alert-info medium has-icon">You can easily deal with uploaded files, thumbnails and images sizes in <span class="file-path">plugins/fileuploader/[xml]/php/[uploader].php</span></p>
                        <p class="alert alert-info medium has-icon">Other examples with code are available in <a href="../templates/index.php">Templates</a></p>
                    </div>
                </div>
                <div id="file-upload-example-wrapper" data-min-height="1146">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>

                <h4>Reference</h4>
                <pre class="line-numbers mb-6"><code class="language-php">/**
* Creates an input with fileuploader plugin.
*
* The fileuploader plugin generates complete html, js and css code.
* You'll just have to call printIncludes('css') and printIncludes('js')
* where you wants to put your css/js codes (generally in &lt;head&gt; and just before &lt;/body&gt;).
*
* @param string $type              The type of the input, usually 'file'
* @param string $name              The upload field name.
*                                  Use an array (ex : name[]) to allow multiple files upload
* @param string $value             (Optional) The input default value
* @param string $label             (Optional) The input label
* @param string $attr              (Optional) Can be any HTML input attribute or js event.
*                                  attributes must be listed separated with commas.
*                                  If you don't specify any ID as attr, the ID will be the name of the input.
*                                  Example : class=my-class,placeholder=My Text,onclick=alert(\'clicked\');.
* @param array  $fileUpload_config An associative array containing :
*                                  'xml'           [string]       => (Optional) The xml node where your plugin code is
*                                                                    in plugins-config/fileuploader.xml
*                                                                    Default: 'default'
*                                  'uploader'      [string]       => (Optional) The PHP uploader file in phpformbuilder/plugins/fileuploader/[xml-node-name]/php/
*                                                                    Default: 'ajax_upload_file.php'
*                                  'upload_dir'    [string]       => (Optional) the directory to upload the files.
*                                                                    Relative to phpformbuilder/plugins/fileuploader/[default]/php/[ajax_upload_file.php]
                                                          Default: '../../../../../file-uploads/' // = [project root]/file-uploads
*                                  'limit'         [null|Number]  => (Optional) The max number of files to upload
*                                                                    Default: 1
*                                  'extensions'    [null|array]   => (Optional) Allowed extensions or file types
*                                                                    example: ['jpg', 'jpeg', 'png', 'audio/mp3', 'text/plain']
*                                                                    Default: ['jpg', 'jpeg', 'png', 'gif']
*                                  'fileMaxSize'   [null|Number]  => (Optional) Each file's maximal size in MB,
*                                                                    Default: 5
*                                  'thumbnails'    [Boolean]      => (Optional) Defines Wether if the uploader creates thumbnails or not.
*                                                                    Thumbnails paths and sizing is done in the plugin php uploader.
*                                                                    Default: false
*                                  'editor'        [Boolean]      => (Optional)  Allows the user to crop/rotate the uploaded image
*                                                                    Default: false
*                                  'width'         [null|Number]  => (Optional) The uploaded image maximum width in px
*                                                                    Default: null
*                                  'height'        [null|Number]  => (Optional) The uploaded image maximum height in px
*                                                                    Default: null
*                                  'crop'          [Boolean]      => (Optional) Defines Wether if the uploader crops the uploaded image or not.
*                                                                    Default: false
*                                  'debug'         [Boolean]      => (Optional) log the result in the browser's console
*                                                                    and shows an error text on the page if the uploader fails to parse the json result.
*                                                                    Default: false
* @return $this
*
*/</code></pre>
            <h4>Uploaded file names and replacements</h4>
            <p>These options are set in <span class="file-path">phpformbuilder/plugins/fileuploader/<span class="text-muted">[default|drag-and-drop|image-upload]</span>/php/ajax_upload_file.php</span></p>
            <p>The uploader PHP documentation is available on the author website: <a href="https://innostudio.de/fileuploader/documentation/#php">https://innostudio.de/fileuploader/documentation/#php</a></p>
            <p class="mb-5">By default, if the uploaded file has the same name as an existing file, the uploaded file will be renamed with a suffix .<br> For instance "<em>my-file-1.jpg</em>".</p>
            <h4>To deal with the posted uploaded files:</h4>
            <pre class="line-numbers"><code class="language-php">// at the beginning of your file
use fileuploader\server\FileUploader;
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . 'phpformbuilder/plugins/fileuploader/server/class.fileuploader.php';

// once the form is validated
if (isset($_POST['user-logo']) && !empty($_POST['user-logo'])) {
    $posted_img = FileUploader::getPostedFiles($_POST['user-logo']);
    $filename   = $posted_img[0]['file'];
    // Then do what you want with the filename
}
</code></pre>
            </article>
        </section>

        <!-- Formvalidation -->

        <section class="py-7">
            <h3 id="formvalidation">Formvalidation - <small><a href="http://formvalidation.io/">http://formvalidation.io/</a></small></h3>
            <p>See <a href="class-doc.html#jquery-validation-getting-started">jQuery validation</a></p>
        </section>

        <!-- iCheck -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="icheck-example">iCheck - <small><a href="https://github.com/fronteed/icheck">https://github.com/fronteed/icheck</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('icheck', '#selector', 'default', $replacements;</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'icheck' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>$js_config <span class="var-type">[String]</span></dt>
                            <dd>the JS configuration  - see <em>Available configurations</em> below</dd>
                            <dd class="line-break"></dd>
                            <dt>$replacements <span class="var-type">[Array]</span></dt>
                            <dd><p class="mb-1">An associative array with:</p>
                                <dl class="dl-horizontal w-100 mb-0">
                                    <dt>'%theme%': </dt>
                                    <dd class="w-75">theme from <span class="file-path">plugins/icheck/skins/</span>.<br>Available themes: flat, futurico, line, minimal, polaris, square</dd>
                                    <dd class="line-break"></dd>
                                    <dt>'%color%': </dt>
                                    <dd class="w-75">color from <span class="file-path">plugins/icheck/skins/[theme]/</span>.<br>Available colors: purple, blue, flat, green, grey, orange, pink, purple, red, yellow</dd>
                                    <dd class="line-break"></dd>
                                </dl>
                            </dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="h4 mb-2 border-bottom">Available configurations:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'default'</dt>
                            <dd>config. for flat, minimal or square themes</dd>
                            <dd class="line-break"></dd>
                            <dt>'theme'</dt>
                            <dd>config. for futurico or polaris themes</dd>
                            <dd class="line-break"></dd>
                            <dt>'line'</dt>
                            <dd>config. for line theme</dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="icheck-example-wrapper" data-min-height="2253">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- image-picker -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="image-picker-example">Image Picker - <small><a href="https://rvera.github.io/image-picker/">https://rvera.github.io/image-picker/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('image-picker', 'select');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'image-picker' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p>The Image Picker plugin applies on <code class="language-php">&lt;select&gt;</code> elements.</p>
                                <p class="mb-0">Options are available with data-attributes and CSS class on the <code class="language-php">&lt;Select&gt;</code> field and its <code class="language-php">&lt;Option&gt;</code> tags.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes & CSS class:</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt><code class="language-php">&lt;Option&gt;</code> data-attributes:</dt>
                            <dd>
                                <dl class="dl-horizontal w-100 mb-0">
                                    <dt class="w-50">data-img-src: <span class="var-type">[String]</span></dt>
                                    <dd>the URL of the source image</dd>
                                    <dd class="line-break"></dd>
                                    <dt class="w-50">data-img-alt: <span class="var-type">[String]</span></dt>
                                    <dd>the alternative text</dd>
                                    <dd class="line-break"></dd>
                                    <dt class="w-50">data-img-label: <span class="var-type">[String]</span></dt>
                                    <dd>image label (the parent select must have the <code class="language-php">show_label</code> class</dd>
                                    <dd class="line-break"></dd>
                                </dl>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt><code class="language-php">&lt;Select&gt;</code> data-attributes:</dt>
                            <dd>
                                <dl class="dl-horizontal w-100 mb-0">
                                    <dt class="w-50">data-limit: <span class="var-type">[Number]</span></dt>
                                    <dd>limit maximum selection in multiple select</dd>
                                    <dd class="line-break"></dd>
                                    <dt class="w-50">data-img-alt: <span class="var-type">[String]</span></dt>
                                    <dd>the alternative text</dd>
                                    <dd class="line-break"></dd>
                                </dl>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt><code class="language-php">&lt;Select&gt;</code> class:</dt>
                            <dd>
                                <dl class="dl-horizontal w-100 mb-0">
                                    <dt class="w-50">show_label: </dt>
                                    <dd>enable label for each option (image)</dd>
                                    <dd class="line-break"></dd>
                                </dl>
                            </dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="image-picker-example-wrapper" data-min-height="499">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
                <p>Other examples with option groups & multiple selections are available at <a href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/image-picker-form.php">https://www.phpformbuilder.pro/templates/bootstrap-4-forms/image-picker-form.php</a></p>
            </article>
        </section>

        <!-- Intl Tel Input -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="intl-tel-input-example">Intl Tel Input (International Phone Numbers) - <small><a href="https://github.com/jackocnr/intl-tel-input">https://github.com/jackocnr/intl-tel-input</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addInput('tel', $name, $value, $label, 'data-intphone=true');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Intl Tel Input</em> plugin, add the <em>data-intphone=true</em> attribute to the input element.<br>there is no need to call the <em>"addPlugin"</em> function.</p>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'tel' <span class="var-type">[String]</span></dt>
                            <dd>the input type</dd>
                            <dd class="line-break"></dd>
                            <dt>$name <span class="var-type">[String]</span></dt>
                            <dd>the input name</dd>
                            <dd class="line-break"></dd>
                            <dt>$value <span class="var-type">[String]</span></dt>
                            <dd>the default value (can be an empty string)</dd>
                            <dd class="line-break"></dd>
                            <dt>$label <span class="var-type">[String]</span></dt>
                            <dd>the input label</dd>
                            <dd class="line-break"></dd>
                            <dt>$attr <span class="var-type">[String]</span></dt>
                            <dd>the input field attributes <a href="class-doc.html#attr" class="badge badge-secondary badge-lg ml-2"><i class="fa fa-link mr-2"></i>documentation</a></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> field.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes:</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-allow-dropdown <span class="text-muted">[Boolean]</span></dt>
                            <dd>Whether or not to allow the dropdown. If disabled, there is no dropdown arrow, and the selected flag is not clickable. Also we display the selected flag on the right instead because it is just a marker of state.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-exclude-countries <span class="text-muted">[String]</span></dt>
                            <dd>In the dropdown, display all countries except the ones you specify here. You must enter countries codes separated with commas.</dd>
                            <dd class="line-break"></dd>
                            <dt>data-initial-country <span class="text-muted">[String]</span></dt>
                            <dd>Set the initial country selection by specifying it's country code. You can also set it to "auto", which will lookup the user's country based on their IP address<br>Example: <code class="language-php">'fr'</code><br>Default: <span class="var-value">'auto'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-only-countries <span class="text-muted">[String]</span></dt>
                            <dd>In the dropdown, display only the countries you specify. You must enter countries codes separated with commas.</dd>
                            <dd class="line-break"></dd>
                            <dt>data-preferred-countries <span class="text-muted">[String]</span></dt>
                            <dd>Specify the countries to appear at the top of the list. You must enter countries codes separated with commas.</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <div class="alert alert-info has-icon medium">
                            <p>If you use Intl Tel Input with the <strong>Formvalidation plugin</strong>,<br>add <code class="language-php">data-fv-intphonenumber=true</code> to the input attributes.</p>
                        </div>
                    </div>
                </div>
                <div id="intl-tel-input-example-wrapper" data-min-height="1538">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- Ladda -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="ladda-example">Ladda (Buttons spinners) - <small><a href="https://github.com/hakimel/Ladda">https://github.com/hakimel/Ladda</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addBtn('submit', 'submit-btn', 1, 'Send', 'class=btn btn-success ladda-button, data-style=zoom-in');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Ladda</em> plugin, simply add the <code class="language-php">ladda-button</code> class to the button element.<br>
there is no need to call the <code class="language-php">addPlugin</code> function.</p>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;button&gt;</code> tag.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes:</h4>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>data-style</dt>
                            <dd>
                                <ul class="list-inline list-unstyled">
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">expand-left</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">expand-right</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">expand-up</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">expand-down</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">contract</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">contract-overlay</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">zoom-in</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">zoom-out</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">slide-left</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">slide-right</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">slide-up</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">slide-down</li>
                                </li>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt>data-spinner-size</dt>
                            <dd>pixel dimensions of spinner, defaults to dynamic size based on the button height. Default <span class="var-value">40</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-spinner-color</dt>
                            <dd>A hex code or any named CSS color.</dd>
                            <dd class="line-break"></dd>
                            <dt>data-spinner-lines</dt>
                            <dd>The number of lines the for the spinner, defaults to <span class="var-value">12</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="ladda-example-wrapper" data-min-height="1564">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- LC-Switch -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="lcswitch-example">LC-Switch (Checkbox/radio switches) - <small><a href="https://lcweb.it/lc-switch-jquery-plugin">https://lcweb.it/lc-switch-jquery-plugin</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addCheckbox('my-checkbox-group', 'Checkbox 1', 'value-1', 'class=lcswitch');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>LC-Switch</em> plugin, simply add the <code class="language-php">lcswitch</code> class to the radio or checkbox element.<br>
there is no need to call the <em>"addPlugin"</em> function.</p>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;radio&gt;</code> or <code class="language-php">&lt;checkbox&gt;</code> element.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes:</h4>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>data-ontext</dt>
                            <dd>short 'On' text to fit into the switch width</dd>
                            <dd class="line-break"></dd>
                            <dt>data-offtext</dt>
                            <dd>short 'Off' text to fit into the switch width</dd>
                            <dd class="line-break"></dd>
                            <dt>data-theme</dt>
                            <dd>
                                <ul class="list-inline list-unstyled">
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">black</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">blue</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">blue-gray</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">cyan</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">gray</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">gray-dark</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">green</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">indigo</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">orange</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">pink</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">purple</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">red</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">teal</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">white</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">yellow</li>
                                </ul>
                            </dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="lcswitch-example-wrapper" data-min-height="558">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- Litepicker -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="litepicker-example">Litepicker (Date / Daterange picker) - <small><a href="https://wakirin.github.io/Litepicker/">https://wakirin.github.io/Litepicker/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addInput('text', 'daterange', '', '', 'class=litepick, data-single-mode=false');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Litepicker</em> plugin, simply add the <code class="language-php">litepick</code> class to the input element.<br>
there is no need to call the <em>"addPlugin"</em> function.</p>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> element.  Example:</p>
                                <pre><code class="language-php">$form->addInput('text', 'daterange', '', '', 'class=litepick, data-single-mode=false, data-format=YYYY-MM-DD');</code></pre>
                            </div>
                        </div>
                        <p class="h4 mb-2 border-bottom">Options: </p>
                        <p>The options list is available here on the plugin website at <a href="https://wakirin.github.io/Litepicker/">https://wakirin.github.io/Litepicker/</a></p>
                        <div class="alert alert-warning has-icon">
                            <ul>
                                <li>
                                    All the plugins options are available with <code class="language-php">data-attributes</code> except:
                                    <ul>
                                        <li>dropdowns</li>
                                        <li>buttonText</li>
                                        <li>tooltipText</li>
                                        <li>resetBtnCallback</li>
                                    </ul>
                                    <p class="mb-0">If you need to use them you can by setting the options in Javascript, as explained below.</p>
                                </li>
                                <li><p>The <code class="language-php">elementEnd</code> option using data-attributes is not the Javascript Element but the element id. For instance:</p>
                                <pre><code class="language-php">$form->addInput('text', 'daterange', '', '', 'class=litepick, data-single-mode=false, data-element-end=input-field-id');</code></pre></li>
                            </ul>
                        </div>
                        <p class="h4 mb-2 border-bottom">Access to the Javascript object and its events</p>
                        <p>PHP Form Builder creates a global <code class="language-php">litePickers</code> object, then each instance is registered with its input fieldname.<br>This allows to access to each instance individually and use the litepicker Events or functions.<br>For instance:</p>
                        <pre class="mb-4"><code class="language-javascript">let inputId = 'my-input';
litePickers[inputId].setOptions({'onSelect': function() {
    console.log(this.options);
    console.log(this.getDate());
    console.log($('#' + inputId).val());
}});</code></pre>
                    </div>
                </div>
                <div id="litepicker-example-wrapper" data-min-height="558">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
                <p>Other examples with different options are available at <a href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/date-range-picker-form.php">https://www.phpformbuilder.pro/templates/bootstrap-4-forms/date-range-picker-form.php</a></p>
            </article>
        </section>

        <!-- Material Design -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="material-design">Material Design plugin <small><a href="https://materializecss.com/">Materialize - https://materializecss.com/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate=true', 'material');</code></pre>
                        <p class="alert alert-info has-icon">To switch your form to Material Design theme, instanciate with <code class="language-php">material</code> as 4<sup>th</sup> argument.<br>See live examples with code in <a href="../templates/index.php">Templates</a></p>
                    </div>
                </div>
                <div id="material-example-wrapper" data-min-height="450">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- Material datepicker -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="material-datepicker-example">Material Datepicker - <small><a href="https://materializecss.com/pickers.html">https://materializecss.com/pickers.html</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('material-datepicker', '#selector');</code></pre>
                        <p class="alert alert-info has-icon">Material Datepicker plugin can be used with any framework (Bootstrap 3, Bootstrap 4, Material, Foundation)</p>
                        <div class="alert alert-warning has-icon">
                            <p>If you use the Material Datepicker plugin <strong>with Ajax</strong> AND <strong>without Material framework</strong>,<br>you have to load the 3 following files in your main page:</p>
                            <ul>
                                <li><code class="language-html">&lt;link rel=&quot;stylesheet&quot; href=&quot;/phpformbuilder/plugins/material-pickers-base/dist/css/material-pickers-base.min.css&quot;&gt;</code></li>
                                <li><code class="language-html">&lt;script src=&quot;/phpformbuilder/plugins/material-pickers-base/dist/js/material-pickers-base.min.js&quot;&gt;&lt;/script&gt;</code></li>
                                <li><code class="language-html">&lt;script src=&quot;/phpformbuilder/plugins/material-datepicker/dist/i18n/en_EN.js&quot;&gt;&lt;/script&gt;</code></li>
                            </ul>
                        </div>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> field.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-auto-close <span class="var-type">Boolean</span></dt>
                            <dd>Automatically close picker when date is selected.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-format <span class="var-type">String</span></dt>
                            <dd>The date output format for the input field value.<br>Default: <span class="var-value">'mmm dd, yyyy'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-default-date <span class="var-type">String</span></dt>
                            <dd>The initial date to view when first opened.<br>The date must be a string in Javascript <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date">Date Object format</a>.<br>Default: <span class="var-value">null</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-set-default-date <span class="var-type">Boolean</span></dt>
                            <dd>Make the defaultDate the initial selected value.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-disable-weekends <span class="var-type">Boolean</span></dt>
                            <dd>Prevent selection of any date on the weekend.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-first-day <span class="var-type">Number</span></dt>
                            <dd>First day of week (0: Sunday, 1: Monday etc).<br>Default: <span class="var-value">0</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-min-date <span class="var-type">String</span></dt>
                            <dd>The earliest date that can be selected.<br>The date must be a string in Javascript <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date">Date Object format</a>.<br>Default: <span class="var-value">null</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-max-date <span class="var-type">String</span></dt>
                            <dd>The latest date that can be selected.<br>The date must be a string in Javascript <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date">Date Object format</a>.<br>Default: <span class="var-value">null</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-year-range <span class="var-type">Number</span></dt>
                            <dd>Number of years either side, or array of upper/lower range.<br>Default: <span class="var-value">10</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-is-rtl <span class="var-type">Boolean</span></dt>
                            <dd>Changes Datepicker to RTL.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-show-month-after-year <span class="var-type">Boolean</span></dt>
                            <dd>Show month after year in Datepicker title.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-show-days-in-next-and-previous-months <span class="var-type">Boolean</span></dt>
                            <dd>Render days of the calendar grid that fall in the next or previous month.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-show-clear-btn <span class="var-type">Boolean</span></dt>
                            <dd>Show the clear button in the datepicker.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Translation (i18n)</h4>
                        <ol class="numbered">
                            <li>Add your language file in <span class="file-path">phpformbuilder/plugins/material-datepicker/dist/i18n/</span></li>
                            <li>Initialize the plugin with your language, for example:<br><pre class="mb-4"><code class="language-php">$form->addPlugin('material-datepicker', '#selector', 'default', array('%language%' => 'fr_FR'));</code></pre></li>
                        </ol>
                    </div>
                </div>
                <div id="material-datepicker-example-wrapper" data-min-height="1200">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- Material timepicker -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="material-timepicker-example">Material Timepicker - <small><a href="https://materializecss.com/pickers.html">https://materializecss.com/pickers.html</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('material-timepicker', '#selector');</code></pre>
                        <p class="alert alert-info has-icon">Material Timepicker plugin can be used with any framework (Bootstrap 3, Bootstrap 4, Material, Foundation)</p>
                        <div class="alert alert-warning has-icon">
                            <p>If you use the Material Timepicker plugin <strong>with Ajax</strong> AND <strong>without Material framework</strong>,<br>you have to load the 3 following files in your main page:</p>
                            <ul>
                                <li><code class="language-html">&lt;link rel=&quot;stylesheet&quot; href=&quot;/phpformbuilder/plugins/material-pickers-base/dist/css/material-pickers-base.min.css&quot;&gt;</code></li>
                                <li><code class="language-html">&lt;script src=&quot;/phpformbuilder/plugins/material-pickers-base/dist/js/material-pickers-base.min.js&quot;&gt;&lt;/script&gt;</code></li>
                                <li><code class="language-html">&lt;script src=&quot;/phpformbuilder/plugins/material-timepicker/dist/i18n/en_EN.js&quot;&gt;&lt;/script&gt;</code></li>
                            </ul>
                        </div>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> field.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-show-clear-btn <span class="var-type">Boolean</span></dt>
                            <dd>Show the clear button in the datepicker.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-default-time <span class="var-type">String</span></dt>
                            <dd>Default time to set on the timepicker 'now' or '13:14'.<br>Default: <span class="var-value">'now'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-from-now <span class="var-type">Number</span></dt>
                            <dd>Millisecond offset from the defaultTime..<br>Default: <span class="var-value">0</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-auto-close <span class="var-type">Boolean</span></dt>
                            <dd>Automatically close picker when minute is selected.<br>Default: <span class="var-value">false</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-twelve-hour <span class="var-type">Boolean</span></dt>
                            <dd>Use 12 hour AM/PM clock instead of 24 hour clock.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Translation (i18n)</h4>
                        <ol class="numbered">
                            <li>Add your language file in <span class="file-path">phpformbuilder/plugins/material-timepicker/dist/i18n/</span></li>
                            <li>Initialize the plugin with your language, for example:<br><pre class="mb-4"><code class="language-php">$form->addPlugin('material-timepicker', '#selector', 'default', array('%language%' => 'fr_FR'));</code></pre></li>
                        </ol>
                    </div>
                </div>
                <div id="material-timepicker-example-wrapper" data-min-height="1183">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- modal -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="modal-example">Modal - <small><a href="http://vodkabears.github.io/remodal/">http://vodkabears.github.io/remodal/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">// html modal link
<?php echo htmlspecialchars('<div class="text-center">
    <a data-remodal-target="modal-target" class="btn btn-primary text-white btn-lg">Sign Up</a>');
?>

&lt;?php
$form->modal('#modal-target');
?&gt;
<?php echo htmlspecialchars('</div>'); ?></code></pre>
                    </div>
                </div>
                <div id="modal-example-wrapper" data-min-height="530">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- nice-check -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="nice-check-example">Nice Check</h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'red']);</code></pre>
                        <h4 class="mb-2 border-bottom">Available skins:</h4>
                        <ul class="list-unstyled clearfix">
                            <li class="float-left w-50 p-1"><i class="fas fa-circle bg-black mr-2"></i>black</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#78909c"></i>blue-gray</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#268fff"></i>blue</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#3ab0c3"></i>cyan</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#5d5552"></i>gray-dark</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#c4bdb9"></i>gray</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#48b461"></i>green</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#7d34f4"></i>indigo</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#fd9137"></i>orange</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#eb5b9d"></i>pink</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#855eca"></i>purple</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#e15361"></i>red</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#41d1a7"></i>teal</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#fff;border:1px solid #ccc;border-radius:50%"></i>white</li>
                            <li class="float-left w-50 p-1"><i class="fas fa-circle mr-2" style="color:#ffca2c"></i>yellow</li>
                        </ul>
                        <p>Example with skins & code available here: <a href="../templates/bootstrap-3-forms/custom-radio-checkbox-css-form.php">Custom radio checkbox css form</a></p>
                    </div>
                </div>
                <div id="nice-check-example-wrapper" data-min-height="873">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- passfield -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="passfield-example">Passfield - <small><a href="https://antelle.net/passfield/">https://antelle.net/passfield/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('passfield', '#user-password', 'lower-upper-min6');</code></pre>
                        <h4 class="mb-2 border-bottom">Available patterns:</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>default</dt>
                            <dd><p>password must contain lowercase letters + numbers and be 8 characters long.</p>
                                <h5 class="h6">pattern validation</h5>
                                <pre><code class="language-php">$validator
->hasLowercase()
->hasNumber()
->minLength(8)
->validate('user-password');</code></pre>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt>lower-upper-min-x</dt>
                            <dd><p>password must contain lowercase + uppercase letters and be x characters long.</p>
                                <p class="h6">pattern validation</p>
                                <pre><code class="language-php">$validator
->hasLowercase()
->hasUppercase()
->minLength(x)
->validate('user-password');</code></pre>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt>lower-upper-number-min-x</dt>
                            <dd><p>password must contain lowercase + uppercase letters + numbers and be x characters long.</p>
                                <p class="h6">pattern validation</p>
                                <pre><code class="language-php">$validator
->hasLowercase()
->hasUppercase()
->hasNumber()
->minLength(x)
->validate('user-password');</code></pre></dd>
                            <dd class="line-break"></dd>
                            <dt>lower-upper-number-symbol-min-x</dt>
                            <dd><p>password must contain lowercase + uppercase letters + numbers + symbols and be x characters long.</p>
                                <p class="h6">pattern validation</p>
                                <pre><code class="language-php">$validator
->hasLowercase()
->hasUppercase()
->hasNumber()
->hasSymbol()
->minLength(x)
->validate('user-password');</code></pre>
                            </dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="text-center"><code class="language-php mr-2">x</code> is a number between 3 and 8.</p>
                        <p class="alert alert-info has-icon">You can easily add your own patterns into <span class="file-path">phpformbuilder/plugins-config/passfield.xml</span>.A pattern generator is available at <a href="https://antelle.net/passfield/demo.html">https://antelle.net/passfield/demo.html</a></p>
                    </div>
                </div>
                <div id="passfield-example-wrapper" data-min-height="400">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- pickadate -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="pickadate-example">Pickadate - <small><a href="http://amsul.ca/pickadate.js/">http://amsul.ca/pickadate.js/</a></small></h3>
                <h4>Date picker</h4>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('pickadate', '#selector', 'default');</code></pre>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-4">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> field.</p>
                                <p class="mb-0">The list of the date formats used by the Pickadate plugin is available here: <a href="https://amsul.ca/pickadate.js/date/#formatting-rules" title="Pickadate plugin date formats">https://amsul.ca/pickadate.js/date/#formatting-rules</a></p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-format <span class="var-type">String</span></dt>
                            <dd>The date output format for the input field value.<br>Default: <span class="var-value">'mmm dd, yyyy'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-format-submit <span class="var-type">String</span></dt>
                            <dd>Display a human-friendly format and use an alternate one to submit to the server.<br>This is done by creating a new hidden input element with the same name attribute as the original with <code class="language-php">_submit</code> suffix<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-select-years <span class="var-type">Boolean</span></dt>
                            <dd>Display select menu to pick the year.<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-select-months <span class="var-type">Boolean</span></dt>
                            <dd>Display select menu to pick the month.<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-first-day <span class="var-type">Number</span></dt>
                            <dd>First day of week (0: Sunday, 1: Monday etc).<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-min <span class="var-type">String</span></dt>
                            <dd>The earliest date that can be selected.<br>The date must be a string in Javascript <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date">Date Object format</a>.<br>Default: <span class="var-value">null</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-max <span class="var-type">String</span></dt>
                            <dd>The latest date that can be selected.<br>The date must be a string in Javascript <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date">Date Object format</a>.<br>Default: <span class="var-value">null</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-close-on-select <span class="var-type">Boolean</span></dt>
                            <dd>When a date is selected, the picker closes. To change this behavior, use the following option.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-close-on-clear <span class="var-type">Boolean</span></dt>
                            <dd>When the "clear" button is pressed, the picker closes. To change this behavior, use the following option.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Translation (i18n)</h4>
                        <ol class="numbered">
                            <li>Add your language file in <span class="file-path">phpformbuilder/plugins/pickadate/lib/translations/</span></li>
                            <li>Initialize the plugin with your language, for example:<br><pre class="mb-4"><code class="language-php">$form->addPlugin('pickadate', '#selector', 'default', array('%language%' => 'fr_FR'));</code></pre></li>
                        </ol>
                    </div>
                </div>
                <div id="pickadate-example-wrapper" data-min-height="1216">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
                <h4 id="pickadate-timepicker-example">Time picker</h4>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('pickadate', '#selector', 'pickatime');</code></pre>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;input&gt;</code> field.</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-format <span class="var-type">String</span></dt>
                            <dd>The time output format for the input field value.<br>Default: <span class="var-value">'h:i A'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-format-submit <span class="var-type">String</span></dt>
                            <dd>Display a human-friendly format and use an alternate one to submit to the server.<br>This is done by creating a new hidden input element with the same name attribute as the original with <code class="language-php">_submit</code> suffix<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-interval <span class="var-type">Number</span></dt>
                            <dd>Choose the minutes interval between each time in the list.<br>Default: <span class="var-value">30</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-min <span class="var-type">String</span></dt>
                            <dd>Set the minimum selectable times on the picker.<br>Arrays formatted as [HOUR,MINUTE] (see example below)<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-max <span class="var-type">String</span></dt>
                            <dd>Set the maximum selectable times on the picker.<br>Arrays formatted as [HOUR,MINUTE] (see example below)<br>Default: <span class="var-value">undefined</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-close-on-select <span class="var-type">Boolean</span></dt>
                            <dd>When a date is selected, the picker closes. To change this behavior, use the following option.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-close-on-clear <span class="var-type">Boolean</span></dt>
                            <dd>When the "clear" button is pressed, the picker closes. To change this behavior, use the following option.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Translation (i18n)</h4>
                        <ol class="numbered">
                            <li>Add your language file in <span class="file-path">phpformbuilder/plugins/pickadate/lib/translations/</span></li>
                            <li>Initialize the plugin with your language, for example:<br><pre class="mb-4"><code class="language-php">$form->addPlugin('pickadate', '#selector', 'pickatime', array('%language%' => 'fr_FR'));</code></pre></li>
                        </ol>
                    </div>
                </div>
                <div id="pickadate-timepicker-example-wrapper" data-min-height="759">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- popover -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="popover-example">Popover - <small><a href="https://github.com/sandywalker/webui-popover">https://github.com/sandywalker/webui-popover</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">// html link to the popover
<?php echo htmlspecialchars('<a href="#" id="popover-link" class="btn btn-primary text-white btn-lg">Sign Up</a>'); ?>

&lt;?php
$form->popover('#popover-link');
?&gt;</code></pre>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">Options are available with data-attributes on the <code class="language-php">&lt;a&gt;</code> tag (link to the popover).</p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data-attributes</h4>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>data-closeable <span class="var-type">Boolean</span></dt>
                            <dd>display close button or not.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-animation <span class="var-type">String</span></dt>
                            <dd>pop with animation,values: pop,fade<br>Default: <span class="var-value">'pop'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-placement <span class="var-type">String</span></dt>
                            <dd>values: <span class="var-value">auto</span> <span class="var-value">top</span> <span class="var-value">right</span> <span class="var-value">bottom</span> <span class="var-value">left</span> <span class="var-value">top-right</span> <span class="var-value">top-left</span> <span class="var-value">bottom-right</span> <span class="var-value">bottom-left</span> <span class="var-value">auto-top</span> <span class="var-value">auto-right</span> <span class="var-value">auto-bottom</span> <span class="var-value">auto-left</span> <span class="var-value">horizontal</span> <span class="var-value">vertical</span>.<br>Default: <span class="var-value">'auto'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-width <span class="var-type">String | Number</span></dt>
                            <dd>can be set with  number<br>Default: <span class="var-value">'auto'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-height <span class="var-type">String | Number</span></dt>
                            <dd>can be set with  number<br>Default: <span class="var-value">'auto'</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-backdrop <span class="var-type">Boolean</span></dt>
                            <dd>if backdrop is set to true, popover will use backdrop on open.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                            <dt>data-cache <span class="var-type">Boolean</span></dt>
                            <dd>if cache is set to false,popover will destroy and recreate.<br>Default: <span class="var-value">true</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="popover-example-wrapper" data-min-height="530">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- invisible recaptcha -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="invisible-recaptcha-example">Invisible Recaptcha - <small><a href="https://developers.google.com/recaptcha/docs/invisible">https://developers.google.com/recaptcha/docs/invisible</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addInvisibleRecaptcha('YOUR_RECAPTCHA_KEY_HERE');

// Validation after POST:
$validator->recaptcha('YOUR_RECAPTCHA_SECRET_KEY_HERE', 'Recaptcha Error')->validate('g-recaptcha-response');</code></pre>
                        <p class="alert alert-info">If you want several Recaptcha on the same page, you have to use Recaptcha V2</p>
                    </div>
                </div>
                <div id="invisible-recaptcha-example-wrapper" data-min-height="570">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- recaptcha V2 -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="recaptchav2-example">Recaptcha V2 - <small><a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-0"><code class="language-php">$form->addRecaptchav2('YOUR_RECAPTCHA_KEY_HERE');

// Validation after POST:
$validator->recaptcha('YOUR_RECAPTCHA_SECRET_KEY_HERE', 'Recaptcha Error')->validate('g-recaptcha-response');</code></pre>
                    </div>
                </div>
                <div id="recaptchav2-example-wrapper" data-min-height="668">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- recaptcha V3 -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="recaptchav3-example">Recaptcha V3 - <small><a href="https://developers.google.com/recaptcha/docs/v3">https://www.google.com/recaptcha/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addRecaptchav3('YOUR_RECAPTCHA_KEY_HERE');

// Validation after POST:
$validator->recaptcha('YOUR_RECAPTCHA_SECRET_KEY_HERE', 'Recaptcha Error')->validate('g-recaptcha-response');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>$sitekey <span class="var-type">[String]</span></dt>
                            <dd>Your Recaptcha V3 public key</dd>
                            <dd class="line-break"></dd>
                            <dt>$action <span class="var-type">[String]</span></dt>
                            <dd>Custom action name - lowercase, uppercase, underscores only.<br>default value: <code class="language-php">'g-recaptcha-response'</code></dd>
                            <dd class="line-break"></dd>
                            <dt>$xml_config <span class="var-type">[String]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/recaptcha-v3.xml</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="recaptchav3-example-wrapper">
                    <p>Live examples available in <a href="https://www.phpformbuilder.pro/templates/index.php">Templates</a></p>
                </div>
            </article>
        </section>

        <!-- Select2 -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="select2-example">Select2 - <small><a href="https://select2.org/">https://select2.org/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <pre class="mb-4"><code class="language-php">$form->addSelect($select_name, $label, 'class=select2');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Select2</em> plugin, add the <em>select2</em> class to the select element.<br>there is no need to call the <em>"addPlugin"</em> function.</p>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>$select_name <span class="var-type">[String]</span></dt>
                            <dd>The select field name</dd>
                            <dd class="line-break"></dd>
                            <dt>$label <span class="var-type">[String]</span></dt>
                            <dd>The select field label</dd>
                            <dd class="line-break"></dd>
                            <dt>$attr <span class="var-type">[String]</span></dt>
                            <dd>the select field attributes <a href="class-doc.html#attr" class="badge badge-secondary badge-lg ml-2"><i class="fa fa-link mr-2"></i>documentation</a></dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <h4 class="mb-2 border-bottom">Options: </h4>
                        <p>Pass options with data attributes. Example:</p>
                        <pre class="mb-4"><code class="language-php">$form->addSelect('select-name', 'Label', 'class=select2, data-width:100%');</code></pre>
                        <p>Data-attribute list is available at <a href="https://select2.org/configuration/options-api">https://select2.org/configuration/options-api</a></p>
                        <p class="mb-0">More details about data-attribute usage at <a href="https://select2.org/configuration/data-attributes">https://select2.org/configuration/data-attributes</a></p>
                        <hr>
                        <div class="alert alert-info has-icon mb-0">
                            <p>Instead of adding the <code class="language-php">select2</code> class to the select element you can call the <code class="language-php">addPlugin()</code> function.</p>
                            <p>This way you can call a custom node from the XML configuration file (<span class="file-path">phpformbuilder/plugins-config/select2.xml</span>).</p>
                            <p>This method allows you to store different custom select2 configurations, and for example change the <code class="language-php">buildTemplate</code> function which builds the options dropdown list.</p>
                        </div>
                    </div>
                </div>
                <div id="select2-example-wrapper" data-min-height="2536">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
                <div class="alert alert-info has-icon">
                    <h4 class="text-info-700">Quick Tips</h4>
                    <dl class="dl-horizontal">
                        <dt>Remove search box</dt>
                        <dd>Select2 adds a search box to the dropdowns. To remove the search box, add <code class="language-php">data-minimum-results-for-search=Infinity</code> to the select element attributes.</dd>
                        <dd class="line-break"></dd>
                        <dt>Placeholders</dt>
                        <dd>To add a placeholder, first add an empty option:<br><code class="language-php">$form->addOption('category', '', '');</code><br>Then use <code class="language-php">data-placeholder=Your placeholder text</code></dd>
                    </dl>
            </article>
        </section>

        <!-- signature-pad -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="signature-pad-example">Signature pad - <small><a href="https://github.com/szimek/signature_pad">https://github.com/szimek/signature_pad</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addInput('hidden', $input_name, $value, $label, 'class=signature-pad, data-background-color=#336699, data-pen-color=#fff, data-width=100%, data-clear-button=true, data-clear-button-class=btn btn-sm btn-warning, data-clear-button-text=clear, data-fv-not-empty___message=You must sign to accept the license agreement, required');</code></pre>
                        <p class="alert alert-info has-icon">To activate the <em>Signature pad</em> plugin, add the <em>signature-pad</em> class to the input element.<br>there is no need to call the <em>"addPlugin"</em> function.</p>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>$input_name <span class="var-type">[String]</span></dt>
                            <dd>the input field name</dd>
                            <dd class="line-break"></dd>
                            <dt>$value <span class="var-type">[String]</span></dt>
                            <dd>the input field value</dd>
                            <dd class="line-break"></dd>
                            <dt>$label <span class="var-type">[String]</span></dt>
                            <dd>the input field label</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">The signature value is sent with the hidden input. The value is a base64 png image (<code class="language-php">data:image/png;base64</code>).</p>
                                <p>Here's how to save the image on the server:</p>
                                <pre><code class="language-php">$data_uri = $_POST['fieldname'];
$encoded_image = explode(',', $data_uri)[1];
$decoded_image = base64_decode($encoded_image);
file_put_contents('signature.png', $decoded_image);</code></pre>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Options: </h4>
                        <p>Pass options with data attributes. Example:</p>
                        <pre class="mb-4"><code class="language-php">$form->addInput('hidden', 'user-signature', '', 'Sign to confirm your agreement', 'class=signature-pad, data-background-color=#336699, data-pen-color=#fff, data-width=100%, data-clear-button=true, data-clear-button-class=btn btn-sm btn-warning, data-clear-button-text=clear, required');</code></pre>
                        <p class="h4 mb-2 border-bottom">Available options:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>data-width <span class="var-type">[Number] | [percent]</span></dt>
                            <dd>the input field width. Accepts only number (in pixels) or percent value.</dd>
                            <dd class="line-break"></dd>
                            <dt>data-background-color <span class="var-type">[String]</span></dt>
                            <dd>the background color in valid CSS format</dd>
                            <dd class="line-break"></dd>
                            <dt>data-pen-color <span class="var-type">[String]</span></dt>
                            <dd>the pen color in valid CSS format</dd>
                            <dd class="line-break"></dd>
                            <dt>data-clear-button <span class="var-type">[Boolean]</span></dt>
                            <dd>show a button to clear the signature</dd>
                            <dd class="line-break"></dd>
                            <dt>data-clear-button-class <span class="var-type">[String]</span></dt>
                            <dd>the CSS classes for the <em>clear</em> button</dd>
                            <dd class="line-break"></dd>
                            <dt>data-clear-button-text <span class="var-type">[String]</span></dt>
                            <dd>the text of the <em>clear</em> button</dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="signature-pad-example-wrapper" data-min-height="1250"><div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div></div>
            </article>
        </section>

        <!-- tinyMce -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="tinymce-example">tinyMce - <small><a href="https://www.tiny.cloud/">https://www.tiny.cloud/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('tinymce', '#content', 'default');</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'tinymce' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>'default' <span class="var-type">[String]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/tinymce.xml</span></dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="tinymce-example-wrapper" data-min-height="1250"><div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div></div>
            </article>
        </section>

        <!-- tooltip -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="tooltip-example">Tooltip - <small><a href="http://qtip2.com/">http://qtip2.com/</a></small></h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('tooltip', '#selector', 'default'[, array('%style%' =&gt; 'qtip-tipsy')]);</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'tooltip' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated.<br>Usually <code class="language-php">[data-tooltip]</code></dd>
                            <dd class="line-break"></dd>
                            <dt>'default' <span class="var-type">[String]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/tooltip.xml</span></dd>
                            <dd class="line-break"></dd>
                            <dt>array('%style%' => 'qtip-tipsy') <span class="var-type">[Optional]</span> <span class="var-type">[Array]</span></dt>
                            <dd>default style for all the tooltips (see available styles below)</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <div class="my-5">
                            <p class="h5 medium bg-gray-200 px-4 py-2 mb-0 rounded-top font-weight-bold">Special notes:</p>
                            <div class="bg-gray-100 p-4 rounded-bottom">
                                <p class="mb-0">The Tooltip plugin can be used in many different ways, on any element, label, ...</p>
                                <p>You'll find many examples code in <a href="../templates/bootstrap-4-forms/tooltip-form.php">../templates/bootstrap-4-forms/tooltip-form.php</a></p>
                            </div>
                        </div>
                        <h4 class="mb-2 border-bottom">Available data attributes</h4>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>data-tooltip <span class="var-type">[String or jQuery selector]</span></dt>
                            <dd>
                                if <span class="var-type">String</span>: The text content of body's tooltip<br>
                                if <span class="var-type">jQuery selector</span>: jQuery selector of the hidden div which contains the tooltip html body.<br>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt>data-style <span class="var-type">[String]</span></dt>
                            <dd>
                                One of the followings:
                                <ul class="list-inline list-unstyled">
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-plain</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-light</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-dark</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-red</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-green</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-blue</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-shadow <sup class="text-red">*</sup></li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-rounded <sup class="text-red">*</sup></li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-bootstrap</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-tipsy</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-youtube</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-jtools</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-cluetip</li>
                                    <li class="list-inline-item bg-gray-100 px-2 py-1 m-2">qtip-tipped</li>
                                </ul>
                                    <p><sup class="text-red mr-1">*</sup> can be mixed with others</p>
                            </dd>
                            <dd class="line-break"></dd>
                            <dt>data-title <span class="var-type">[String]</span></dt>
                            <dd>The optional tooltip title</dd>
                            <dd class="line-break"></dd>
                            <dt>data-show-event <span class="var-type">[String]</span></dt>
                            <dd>Mouse event which triggers the tooltip<br>ie: click, mouseenter</dd>
                            <dd class="line-break"></dd>
                            <dt>data-hide-event <span class="var-type">[String]</span></dt>
                            <dd>Mouse event which hides the tooltip<br>ie: mouseleave</dd>
                            <dd class="line-break"></dd>
                            <dt>data-position <span class="var-type">[String]</span></dt>
                            <dd>top | right | bottom | left</dd>
                            <dd class="line-break"></dd>
                            <dt>data-adjust-x <span class="var-type">[Number]</span></dt>
                            <dd>Number to adjust tooltip on x axis</dd>
                            <dd class="line-break"></dd>
                            <dt>data-adjust-y <span class="var-type">[Number]</span></dt>
                            <dd>Number to adjust tooltip on y axis</dd>
                            <dd class="line-break"></dd>
                            <dt>data-max-width <span class="var-type">[String]</span></dt>
                            <dd>css max-width  (px|%)</dd>
                            <dd class="line-break"></dd>
                            <dt>data-max-height <span class="var-type">[String]</span></dt>
                            <dd>css max-height (px|%)</dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="tooltip-example-wrapper" data-min-height="768">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>

        <!-- wordcharactercount -->

        <section class="py-7">
            <article class="pb-5 mb-7 has-separator">
                <h3 id="wordcharactercount-example">Word / Character Count</h3>
                <div class="card mb-5">
                    <div class="card-body">
                        <p class="h4 mb-2 border-bottom">Function: </p>
                        <pre class="mb-4"><code class="language-php">$form->addPlugin('word-character-count', '#selector', 'default', array('%maxAuthorized%' =&gt; 100));</code></pre>
                        <p class="h4 mb-2 border-bottom">Arguments:</p>
                        <dl class="dl-horizontal medium mb-4">
                            <dt>'word-character-count' <span class="var-type">[String]</span></dt>
                            <dd>the plugin name</dd>
                            <dd class="line-break"></dd>
                            <dt>'#selector' <span class="var-type">[String]</span></dt>
                            <dd>the jQuery selector which defines the fields on which the plugin will be activated</dd>
                            <dd class="line-break"></dd>
                            <dt>'default' <span class="var-type">[String]</span></dt>
                            <dd>the plugin configuration node in <span class="file-path">phpformbuilder/plugins-config/word-character-count.xml</span><br>(see <em>Available configurations</em> below)</dd>
                            <dd class="line-break"></dd>
                            <dt>array('%maxAuthorized%' => 100) <span class="var-type">[Array]</span></dt>
                            <dd>The number of maximum authorized characters</dd>
                            <dd class="line-break"></dd>
                        </dl>
                        <p class="h4 mb-2 border-bottom">Available configurations:</p>
                        <dl class="dl-horizontal medium mb-0">
                            <dt>'default'</dt>
                            <dd>words + characters count</dd>
                            <dd class="line-break"></dd>
                            <dt>'word'</dt>
                            <dd>word count only</dd>
                            <dd class="line-break"></dd>
                            <dt>'character'</dt>
                            <dd>character count only</dd>
                            <dd class="line-break"></dd>
                        </dl>
                    </div>
                </div>
                <div id="word-character-count-example-wrapper" data-min-height="571">
                    <div class="loader text-center"><p><i class="fa fa-spinner fa-w-16 fa-spin fa-lg mr-2"></i><span class="text-muted">Loading all the page plugins ...</span></p><p class="text-muted">Just wait a few seconds ...</p></div>
                </div>
            </article>
        </section>
    </div>
    <?php require_once 'inc/js-includes.php';

        /*==========================================
        =            Load all the forms            =
        ==========================================*/

        $forms = array(
            'autocomplete-example',
            'autocomplete-with-ajax-call-example',
            'bootstrap-select-example',
            'captcha-example',
            'colorpicker-example',
            'dependent-fields-example',
            'file-upload-example',
            'icheck-example',
            'image-picker-example',
            'intl-tel-input-example',
            'ladda-example',
            'lcswitch-example',
            'litepicker-example',
            'material-example',
            'material-datepicker-example',
            'material-timepicker-example',
            'modal-example',
            'nice-check-example',
            'passfield-example',
            'pickadate-example',
            'pickadate-timepicker-example',
            'popover-example',
            'invisible-recaptcha-example',
            'recaptchav2-example',
            'select2-example',
            'signature-pad-example',
            'tinymce-example',
            'tooltip-example',
            'word-character-count-example'
        );
        $form_count = count($forms);
    ?>

    <!-- Ajax form loader -->

    <script type="text/javascript">
    var $head= document.getElementsByTagName('head')[0],
        formsCount = <?php echo $form_count; ?>;

    var loadData = function(data, target, index) {
        $('#' + target + '-wrapper .loader').remove();
        if (index <= $(data).length) {
            var that = $(data).get(index);
            if ($(that).is('script')) {
                // output script
                var script = document.createElement('script');
                script.type = 'text/javascript';
                if (that.src != '') {
                    script.src = that.src;
                    script.onload = function() {
                        loadData(data, target, index + 1);
                    };
                    $head.append(script);
                } else {
                    script.text = that.text;
                    $('body').append(script);
                    loadData(data, target, index + 1);
                }
            } else {
                // output form html
                $('#' + target + '-wrapper').append($(that));
                loadData(data, target, index + 1);
            }
        } else {
            $.holdReady(false);
            formsCount --;
            if (formsCount == 0) {
                $('button[data-toggle="collapse"]').on('click', function() {
                    $($(this).attr('data-target')).collapse('toggle');
                });

                setTimeout(function() {
                    Prism.highlightAllUnder(document.querySelector('#jquery-plugins-container'), true);
                }, 400);
                // console.timeEnd("LOADING");
            }
        }
    };

    loadjs.ready(['core'], function() {
        // console.log('LOADING STARTED');
        // console.time("LOADING");
        $('div[data-min-height]').each(function() {
            $(this).css('min-height', $(this).attr('data-min-height'));
        });
<?php
$timer = 3500;
$increase_time = 200;
foreach ($forms as $f) {
?>
        setTimeout(function() {
            $.ajax({
                url: 'inc/jquery-plugins/<?php echo $f; ?>.php',
                type: 'GET'
            }).done(function(data) {
                $.holdReady(true);
                loadData(data, '<?php echo $f; ?>', 0);
                // console.log('TIMER = <?php echo $timer; ?>');
            }).fail(function(data, statut, error) {
                console.log(error);
            });
        }, <?php echo $timer; ?>);
<?php
    $timer += $increase_time;
}
?>
    });
    </script>
</body>
</html>
