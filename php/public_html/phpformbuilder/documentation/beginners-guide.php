<!doctype html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder - PHP Beginners guide',
            'description' => 'PHP Form Builder - Tutorial and detailed instructions for php beginners',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/beginners-guide.php',
            'screenshot'  => 'beginners-guide.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}nav,section{display:block}h1,h2{margin-top:0;margin-bottom:.5rem}h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h2{margin-bottom:3rem!important}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}article,nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2,h3,h4{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}code,pre{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2,h3,h4{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}h3{font-size:26.25px}h4{font-size:22.5px}code{font-size:87.5%;color:#e83e8c;word-break:break-word}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.nav-pills .nav-link.active{color:#fff;background-color:#007bff}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.d-inline-block{display:inline-block!important}.mr-1{margin-right:.25rem!important}.mb-4{margin-bottom:1.5rem!important}.mb-5{margin-bottom:3rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.file-path,.mr-1{margin-right:.25rem!important}.file-path{margin-left:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}h4{margin-bottom:1rem!important}.mb-4,h3{margin-bottom:1.5rem!important}.mb-5,h2{margin-bottom:3rem!important}.mb-6{margin-bottom:6.25rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0,pre>code[class*=language]{padding-right:0!important}.px-0,pre>code[class*=language]{padding-left:0!important}.pt-1{padding-top:.25rem!important}code[class*=language]{padding-right:.25rem!important}code[class*=language]{padding-left:.25rem!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.ml-auto{margin-left:auto!important}.text-center{text-align:center!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>a.active{background-color:#a93030}[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}h1,h2,h3,h4{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}h3,h4{font-weight:300;color:#a9a398}h3{font-variant:small-caps}code,code[class*=language],pre{font-size:.75rem}strong{font-weight:500}section>h2{padding:1rem;border-bottom:1px solid #ddd}article>h3:before{content:'';display:inline-block;width:8px;height:8px;margin-right:10px;margin-bottom:3px;border-radius:50%;background:#00c2db}article>h3:before{background:#00c2db}section ul:not(.list-unstyled):not(.tree-list):not(.list-inline):not(.picker__list):not(.select2-selection__rendered)>li{position:relative;list-style:none;margin-bottom:.5rem}section ul:not(.list-unstyled):not(.tree-list):not(.list-inline):not(.picker__list):not(.select2-selection__rendered)>li:before{content:' ';width:6px;height:6px;background:#a9a398;display:inline-block;position:absolute;left:-30px;top:.55em}.numbered-title:before{counter-increment:section;content:counter(section);border-radius:50%;width:1.5em;height:1.5em;text-align:center;line-height:1.5em;background:#007e8f;color:#fff}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.dmca-badge{min-height:100px}.file-path{font-size:93.33333333333333%}.file-path{display:inline-block;padding:.15em .5em;font-weight:400;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline}.file-path.file-path{border-radius:.2rem;color:#212529;background-color:#f4f3f1}code[class*=language-]{position:relative;color:#ccc;background:0 0;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;-ms-hyphens:none;hyphens:none}:not(pre)>code[class*=language-]{background:#2d2d2d}:not(pre)>code[class*=language-]{padding:.1em;border-radius:.25rem!important;white-space:normal}
    </style>
    <?php require_once 'inc/css-includes.php'; ?>
</head>
<body style="padding-top:76px;" data-spy="scroll" data-target="#navbar-left-wrapper" data-offset="180">

    <!-- Main navbar -->

    <!--LSHIDE-->

    <nav id="website-navbar" class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand mr-3" href="https://www.phpformbuilder.pro"><img src="assets/images/phpformbuilder-logo.png" width="60" height="60" class="mr-3" alt="PHP Form Builder" title="PHP Form Builder">PHP Form Builder</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">

                    <!-- https://www.phpformbuilder.pro navbar -->

                    <li class="nav-item" role="presentation"><a class="nav-link" href="../index.html">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../drag-n-drop-form-builder/index.html">Drag &amp; drop Form Builder</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="quick-start-guide.php">Quick Start Guide</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../templates/index.php">Form Templates</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="jquery-plugins.php">jQuery Plugins</a></li>
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
            <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#php-server">Install and run a local PHP server</a></li>
            <li class="nav-item"><a class="nav-link" href="#php-version">Check your PHP version</a></li>
            <li class="nav-item"><a class="nav-link" href="#upload-phpformbuilder-folders">Upload phpformbuilder folders</a></li>
            <li class="nav-item"><a class="nav-link" href="#include-required-files">Include required files on your page to build form</a></li>
            <li class="nav-item"><a class="nav-link" href="#build-your-first-form">Build your first form</a></li>
            <li class="nav-item"><a class="nav-link" href="#validate-posted-values">Validate user's posted values and send email</a></li>
            <li class="nav-item"><a class="nav-link" href="#complete-page-code">Complete page code</a></li>
            <li class="nav-item"><a class="nav-link" href="#to-go-further">To go further</a></li>
        </ul>
        <div class="text-center mb-xs"><a href="//www.dmca.com/Protection/Status.aspx?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" title="DMCA.com Protection Status" class="dmca-badge"><img data-src="//images.dmca.com/Badges/dmca-badge-w100-1x1-01.png?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="lazyload" alt="DMCA.com Protection Status" width="100" height="100"></a><script defer src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"></script></div>
        <div class="text-center mb-7">
            <a href="https://www.hack-hunt.com" title="Send DMCA Takedown Notice" class="text-white">www.hack-hunt.com</a>
        </div>
    </div>

    <!-- /main sidebar -->

    <div class="container">

        <?php include_once 'inc/top-section.php'; ?>

        <h1>PHP Beginners Guide</h1>
        <section class="mb-6">
            <h2 id="home">Welcome to PHP Form Builder's Beginners Guide</h2>
            <p>Here you'll learn in a few steps how to:</p>
            <ul class="mb-5">
                <li><a href="#php-server">Install and run a local PHP server</a></li>
                <li><a href="#php-version">Check your PHP version</a></li>
                <li><a href="#include-required-files">Include required files on your page to build form</a></li>
                <li><a href="#build-your-first-form">Build your first form</a></li>
                <li><a href="#validate-posted-values">Validate user's posted values and send email</a></li>
                <li><a href="#complete-page-code">Complete page code</a></li>
                <li><a href="#to-go-further">To go further</a></li>
            </ul>
            <h4 class="mt-lg">For any question or request</h4>
            <p>Please </p>
            <ul>
                <li>contact me through <a href="http://codecanyon.net/item/php-form-builder/8790160/comments">PHP Form Builder's comments on Codecanyon</a></li>
                <li>E-mail me at <a href="https://www.miglisoft.com/#contact">https://www.miglisoft.com/#contact</a></li>
            </ul>
        </section>
        <section class="mb-6">
            <article class="mb-6">
                <h3 id="php-server" class="numbered-title">Install and run a local PHP server</h3>
                <div class="pl-4">
                    <p><strong>Download and install a php server - this is required to run php on your computer.</strong></p>
                    <p>Most well-known are:</p>
                    <ul>
                        <li><a href="https://www.apachefriends.org/index.html">XAMPP</a> (WINDOWS | OSX | LINUX)</li>
                        <li><a href="http://www.wampserver.com">WAMP</a> (WINDOWS)</li>
                        <li><a href="https://www.mamp.info">MAMP</a> (OSX)</li>
                    </ul>
                    <p class="alert alert-info has-icon">You'll find numerous pages and videos about how to install and run your php server.</p>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="php-version" class="numbered-title">Check your PHP version</h3>
                <div class="pl-4">
                    <ol class="numbered">
                        <li>
                            <p><strong>Create a new empty file at the root of your project, named for example <span class="file-path">test-form.php</span>.</strong></p>
                        </li>
                        <li>
                            <p><strong>Add the following line into your file:</strong></p>
                            <pre><code class="language-php">&lt;?php phpinfo(); ?&gt;</code></pre>
                        </li>
                        <li>
                            <p><strong>Open your favorite browser and go to your file's url, for example: <span class="file-path">http://localhost/my-project/test-form.php</span></strong></p>
                        </li>
                        <li>
                            <p><strong>If your version is php 5.3 or newer, you're on the right track.</strong></p>
                            <p>If not, you've got to upgrade your php to a most recent version.</p>
                        </li>
                    </ol>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="upload-phpformbuilder-folders" class="numbered-title">Upload phpformbuilder folder</h3>
                <div class="pl-4">
                    <ul>
                        <li>
                            <p><strong>Add <span class="file-path">phpformbuilder</span> folder at the root of your project.</strong></p>
                            <p>Your directory structure should be similar to this:</p>
                            <div class="tree mb-5">
                                <ul class="tree-list">
                                    <li><a href="#" class="folder">my-project</a>
                                        <ul class="tree-list">
                                            <li><a href="#" class="folder">phpformbuilder</a>
                                                <ul class="tree-list">
                                                    <li><a href="#" class="folder">database</a></li>
                                                    <li><a href="#" class="folder">mailer</a></li>
                                                    <li><a href="#" class="folder">plugins</a></li>
                                                    <li><a href="#" class="folder">plugins-config</a></li>
                                                    <li><a href="#" class="folder">plugins-config-custom</a></li>
                                                    <li><a href="#" class="folder">Validator</a></li>
                                                    <li><a href="#" class="file">Form.php</a></li>
                                                    <li><a href="#" class="file">FormExtended.php</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#" class="file">test-form.php</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <p>PHP Form Builder's package includes the Form Builder itself, the documentation and all the templates.</p>
                            <p class="alert alert-warning has-icon">You don't have to upload all the files and folders on your production server.</p>
                            <p><strong>Documentation and Templates are available online at <a href="https://www.phpformbuilder.pro/">https://www.phpformbuilder.pro/</a>.<br>There's no need to upload them on your production server.</strong></p>
                            <p>More details about folders, files and required files on production server here: <a href="/index.html#package-structure">../index.html#package-structure</a></p>
                        </li>
                    </ul>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="include-required-files" class="numbered-title">Include required files on your page to build form</h3>
                <div class="pl-4">
                    <ol class="numbered">
                        <li class="mb-5">
                            <p><strong>Open the <span class="file-path">test-form.php</span> that you created on <a href="#php-version">step n°2</a> with your favourite editor (Sublime Text, Notepad++, Atom, ...)</strong></p>
                        </li>
                        <li class="mb-5">
                            <p><strong>Add html basic markup:</strong></p>
                            <pre class="line-numbers"><code class="language-php">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Test Form&lt;/title&gt;
&lt;!-- Latest compiled and minified Bootstrap CSS --&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css&quot; integrity=&quot;sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7&quot; crossorigin=&quot;anonymous&quot;&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt;My first form&lt;/h1&gt;
&lt;!-- Latest compiled and minified jQuery --&gt;
&lt;script   src=&quot;https://code.jquery.com/jquery-2.2.4.min.js&quot;   integrity=&quot;sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=&quot;   crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;!-- Latest compiled and minified Bootstrap JS --&gt;
&lt;script src=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js&quot; integrity=&quot;sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS&quot; crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                    </li>
                    <li class="mb-5">
                        <p><strong>Now add the following code at the very beginning of your file:</strong></p>
                        <pre class="line-numbers"><code class="language-php">&lt;?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
session_start();
include_once rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR) . &#039;/phpformbuilder/Form.php&#039;;
?&gt;</code></pre>
                            <p class="alert alert-success has-icon">This code will be the same for all pages containing forms.</p>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-include" aria-expanded="false" aria-controls="code-hint-include">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-include">
                                <div class="well">
                                    <pre class="line-numbers"><code class="language-php">&lt;?php
// Following 2 lines are required since php 5.3 to set namespaces.
// more details here: http://php.net/manual/en/language.namespaces.php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

// Following line starts php session. That's to say we'll memorize variables in php session.
session_start();

// Then we include main form class, which contains all functions to build forms.
include_once rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR) . &#039;/phpformbuilder/Form.php&#039;;
?&gt;</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Refresh your <span class="file-path">test-form.php</span> in your browser (<span class="file-path">http://localhost/my-project/test-form.php</span>)</strong></p>
                            <p>If you see a blank page, all is ok, you can <a href="#build-your-first-form">go on to next step</a></p>
                            <p id="error500">If your browser throws an error 500, click button below to solve this.</p>
                            <p><a class="btn btn-danger" role="button" data-toggle="collapse" href="#code-hint-error-500" aria-expanded="false" aria-controls="code-hint-error-500">How to solve error 500 <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-error-500">
                                <div class="well">
                                    <p><strong>Your browser has thrown this error because php can't find <span class="file-path">Form.php</span>.</strong></p>
                                    <p><code class="language-php">rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR)</code> should lead to the root of your project.<br>If works fine if your server is well configured, but it seems that's not the case.</p>
                                    <p>To solve this, open <a href="../phpformbuilder/server.php">../phpformbuilder/server.php</a> in your browser and follow the instructions.</p>
                                    <p>More explainations about error 500 are available at <a href="https://www.phpformbuilder.pro/documentation/help-center.php#warning-include_once">https://www.phpformbuilder.pro/documentation/help-center.php#warning-include_once</a></p>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="build-your-first-form" class="numbered-title">Build your first form</h3>
                <div class="pl-4">
                    <p><strong>So let's start building the form.</strong></p>
                    <ol class="numbered">
                        <li class="mb-5">
                            <p><strong>To create a new form, add this line just after the <code class="language-php">include_once</code> statement Line 5 in your <span class="file-path">test-form.php</span>:</strong></p>
                            <pre class="line-numbers" data-start="6"><code class="language-php">$form = new Form('test-form', 'horizontal', 'novalidate');</code></pre>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-new-form" aria-expanded="false" aria-controls="code-hint-new-form">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-new-form">
                                <div class="well">
                                    <pre><code class="language-php">$form = new Form(&#039;test-form&#039;, &#039;horizontal&#039;, &#039;novalidate&#039;);
// this function creates a new form object.

// arguments:
//      &#039;test-form&#039; : this is the form name
//      &#039;horizontal&#039;: this will add class=&quot;form-horizontal&quot;
//      &#039;novalidate&#039;: this will add &#039;novalidate&#039; attribute. It prevents browser to use browser&#039;s html5 built-in validation.

// You can skip &#039;novalidate&#039; argument if you want to use browser&#039;s html5 built-in validation.

// If you want Material Design style, instanciate this way:
$form = new Form(&#039;test-form&#039;, &#039;horizontal&#039;, &#039;novalidate&#039;, &#039;material&#039;);

// or without html5 validation:
$form = new Form(&#039;test-form&#039;, &#039;horizontal&#039;, &#039;&#039;, &#039;material&#039;);</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Add the following line to create an input field:</strong></p>
                            <pre class="line-numbers" data-start="7"><code class="language-php">$form->addInput('text', 'user-name', '', 'Name:', 'required, placeholder=Name');</code></pre>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-add-input" aria-expanded="false" aria-controls="code-hint-add-input">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-add-input">
                                <div class="well">
                                    <pre><code class="language-php">$form-&gt;addInput(&#039;text&#039;, &#039;user-name&#039;, &#039;&#039;, &#039;Name:&#039;, &#039;required, placeholder=Name&#039;);
// this function adds an input to your form.

// arguments:
//      &#039;text&#039;     : the html input type. can be for example &#039;text&#039; or &#039;hidden&#039;, &#039;email&#039;, &#039;number&#039;, ...
//      &#039;user-name&#039;: the html &quot;name&quot; attribute
//      &#039;Name:&#039;   : label content displayed on screen
//      &#039;required, placeholder=Name&#039;: can be any html addributes, separated with commas and without quotes.</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Add the following line to create 2 radio buttons with iCheck plugin</strong></p>
                            <pre class="line-numbers" data-start="8"><code class="language-php">$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;Yes&#039;, 1);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;No&#039;, 0);
$form-&gt;printRadioGroup(&#039;is-all-ok&#039;, &#039;Is all ok?&#039;, false, &#039;required&#039;);
$form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square&#039;, &#039;%color%&#039; =&gt; &#039;red&#039;));</code></pre>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-add-radio" aria-expanded="false" aria-controls="code-hint-add-radio">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-add-radio">
                                <div class="well">
                                    <pre><code class="language-php">// add 2 radio buttons.
// arguments:
//      &#039;is-all-ok&#039;  : radio groupname
//      &#039;Yes&#039;        : radio label
//      1                      : radio value
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;Yes&#039;, 1);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;No&#039;, 0);

// render radio group
// arguments:
//      &#039;is-all-ok&#039;  : radio groupname
//      &#039;Is all ok?&#039;: radio group  label
//      false                  : inline (true or false)
//      &#039;required&#039;   : this will add 'required' attribute. can contain any html attribute(s), separated with commas.
$form-&gt;printRadioGroup(&#039;is-all-ok&#039;, &#039;Is all ok?&#039;, false, &#039;required&#039;);

// Add iCheck plugin (beautiful radio buttons)
// arguments:
//      &#039;input&#039;  : plugin's target (jQuery selector)
//      &#039;default&#039;: plugin's config (see class doc for details please)
//      array([...])       : arguments sended to plugin (see class doc for details please)
$form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square&#039;, &#039;%color%&#039; =&gt; &#039;red&#039;));</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Add the submit button:</strong></p>
                            <pre class="line-numbers" data-start="12"><code class="language-php">$form->addBtn('submit', 'submit-btn', 1, 'Send', 'class=btn btn-success');</code></pre>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-add-submit" aria-expanded="false" aria-controls="code-hint-add-submit">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-add-submit">
                                <div class="well">
                                    <pre><code class="language-php">$form-&gt;addBtn(&#039;submit&#039;, &#039;submit-btn&#039;, 1, &#039;Send&#039;, &#039;class=btn btn-success&#039;);
// this function adds a button to your form.

// arguments:
//      &#039;submit&#039;     : the html button type.
//      &#039;submit-btn&#039; : the html &quot;name&quot; attribute
//      &#039;Send:&#039;     : Button text content displayed on screen
//      &#039;class=btn btn-success&#039;: can be any html addributes, separated with commas and without quotes.</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Well done. Now the form is ready with an input and a submit button.</strong></p>
                            <p><strong>Last step is to render it on page.We'll add 3 php blocks.</strong></p>
                            <ol class="spaced">
                                <li>
                                    <p>Just before <code class="language-php">&lt;/head&gt;</code>:</p>
                                    <pre><code class="language-php">&lt;?php $form-&gt;printIncludes(&#039;css&#039;); ?&gt;</code></pre>
                                </li>
                                <li>
                                <p>Anywhere between <code class="language-php">&lt;body&gt;&lt;/body&gt;</code>: (at the place you want the form to be displayed)</p>
                                    <pre><code class="language-php">&lt;?php
if (isset($sent_message)) {
echo $sent_message;
}
$form-&gt;render();
?&gt;</code></pre>
                                </li>
                                <li>
                                    <p>Just before <code class="language-php">&lt;/body&gt;</code>:</p>
                                    <pre><code class="language-php">&lt;?php
    $form-&gt;printIncludes(&#039;js&#039;);
    $form-&gt;printJsCode();
    ?&gt;</code></pre>
                                </li>
                            </ol>
                            <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-render" aria-expanded="false" aria-controls="code-hint-render">What's going on here? <span class="caret"></span></a></p>
                            <div class="collapse" id="code-hint-render">
                                <div class="well">
                                    <pre><code class="language-php">// Following lines will include jQuery plugin's css files if your form uses plugins.
&lt;?php $form-&gt;printIncludes(&#039;css&#039;); ?&gt;

// following lines will render the form in your page, and display success / error message if form has been posted by user.
&lt;?php
if (isset($sent_message)) {
echo $sent_message;
}
$form-&gt;render();
?&gt;

// Following lines will include jQuery plugin's js files if your form uses plugins.
&lt;?php $form-&gt;printIncludes(&#039;js&#039;); ?&gt;</code></pre>
                                </div>
                            </div>
                        </li>
                        <li class="mb-5">
                            <p><strong>Refresh your <span class="file-path">test-form.php</span> in your browser (<span class="file-path">http://localhost/my-project/test-form.php</span>)</strong></p>
                            <p>your form should be displayed.</p>
                        </li>
                    </ol>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="validate-posted-values" class="numbered-title">Validate user's posted values and send email</h3>
                <div class="pl-4">
                    <p><strong>Add this php block just after <code class="language-php">include_once [...] . &#039;/phpformbuilder/Form.php&#039;;</code>:</strong></p>
                    <pre><code class="language-php">if ($_SERVER[&quot;REQUEST_METHOD&quot;] == &quot;POST&quot;) {

// create validator &amp; auto-validate required fields
$validator = Form::validate(&#039;test-form&#039;);

// check for errors
if ($validator-&gt;hasErrors()) {
$_SESSION[&#039;errors&#039;][&#039;test-form&#039;] = $validator-&gt;getAllErrors();
} else {
$email_config = array(
&#039;sender_email&#039;    =&gt; &#039;contact@my-site.com&#039;,
&#039;sender_name&#039;     =&gt; &#039;PHP Form Builder&#039;,
&#039;recipient_email&#039; =&gt; &#039;recipient-email@my-site.com&#039;,
&#039;subject&#039;         =&gt; &#039;PHP Form Builder - Test form email&#039;,
&#039;filter_values&#039;   =&gt; &#039;test-form&#039;
);
$sent_message = Form::sendMail($email_config);
Form::clear(&#039;test-form&#039;);
}
}</code></pre>
                    <div class="alert alert-info has-icon">
                        <p>Email sending may fail on your localhost, depending on your configuration.</p>
                        <p>It should work anyway on production server.</p>
                    </div>
                    <p><a class="btn btn-primary" role="button" data-toggle="collapse" href="#code-hint-validate" aria-expanded="false" aria-controls="code-hint-validate">What's going on here? <span class="caret"></span></a></p>
                    <div class="collapse" id="code-hint-validate">
                        <div class="well">
                            <pre><code class="language-php">// if form has been posted
if ($_SERVER[&quot;REQUEST_METHOD&quot;] == &quot;POST&quot; &amp;&amp; Form::testToken(&#039;test-form&#039;) === true) {

// create a new validator object &amp; auto-validate required fields
$validator = Form::validate(&#039;test-form&#039;);

// store errors in session if any
if ($validator-&gt;hasErrors()) {
$_SESSION[&#039;errors&#039;][&#039;test-form&#039;] = $validator-&gt;getAllErrors();
} else {

// all is ok, send email
// PHP Form Builder will add all posted labels and values to your message,
// no need to do anything manually.
$email_config = array(
    &#039;sender_email&#039;    =&gt; &#039;contact@my-site.com&#039;,
    &#039;sender_name&#039;     =&gt; &#039;PHP Form Builder&#039;,
    &#039;recipient_email&#039; =&gt; &#039;recipient-email@my-site.com&#039;,
    &#039;subject&#039;         =&gt; &#039;PHP Form Builder - Test form email&#039;,
    // filter_values are posted values you don&#039;t want to include in your message. Separated with commas.
    &#039;filter_values&#039;   =&gt; &#039;test-form&#039;
);

// send message
$sent_message = Form::sendMail($email_config);

// clear session values: next time your form is displayed it&#039;ll be emptied.
Form::clear(&#039;test-form&#039;);
}
}</code></pre>
                        </div>
                    </div>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="complete-page-code" class="numbered-title">Complete page code</h3>
                <div class="pl-4">
                    <pre class="line-numbers"><code class="language-php">&lt;?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
session_start();
include_once rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR) . &#039;/phpformbuilder/Form.php&#039;;
if ($_SERVER[&quot;REQUEST_METHOD&quot;] == &quot;POST&quot; &amp;&amp; Form::testToken(&#039;test-form&#039;) === true) {

// create validator &amp; auto-validate required fields
$validator = Form::validate(&#039;test-form&#039;);

// check for errors
if ($validator-&gt;hasErrors()) {
$_SESSION[&#039;errors&#039;][&#039;test-form&#039;] = $validator-&gt;getAllErrors();
} else {
$email_config = array(
    &#039;sender_email&#039;    =&gt; &#039;contact@my-site.com&#039;,
    &#039;sender_name&#039;     =&gt; &#039;PHP Form Builder&#039;,
    &#039;recipient_email&#039; =&gt; &#039;recipient-email@my-site.com&#039;,
    &#039;subject&#039;         =&gt; &#039;PHP Form Builder - Test form email&#039;,
    // filter_values are posted values you don&#039;t want to include in your message. Separated with commas.
    &#039;filter_values&#039;   =&gt; &#039;test-form&#039;
);

// send message
$sent_message = Form::sendMail($email_config);
Form::clear(&#039;test-form&#039;);
}
}
$form = new Form('test-form', 'horizontal', 'novalidate');
$form->addInput('text', 'user-name', '', 'Name:', 'required, placeholder=Name');
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;Yes&#039;, 1);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;No&#039;, 0);
$form-&gt;printRadioGroup(&#039;is-all-ok&#039;, &#039;Is all ok?&#039;, false, &#039;required&#039;);
$form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square&#039;, &#039;%color%&#039; =&gt; &#039;red&#039;));
$form->addBtn('submit', 'submit-btn', 1, 'Send', 'class=btn btn-success');
?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Test Form&lt;/title&gt;
&lt;!-- Latest compiled and minified Bootstrap CSS --&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css&quot; integrity=&quot;sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7&quot; crossorigin=&quot;anonymous&quot;&gt;
&lt;?php $form-&gt;printIncludes(&#039;css&#039;);?&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt;My first form&lt;/h1&gt;
&lt;?php
if (isset($sent_message)) {
echo $sent_message;
}
$form-&gt;render();
?&gt;
&lt;!-- Latest compiled and minified jQuery --&gt;
&lt;script   src=&quot;https://code.jquery.com/jquery-2.2.4.min.js&quot;   integrity=&quot;sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=&quot;   crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;!-- Latest compiled and minified Bootstrap JS --&gt;
&lt;script src=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js&quot; integrity=&quot;sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS&quot; crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;?php
$form-&gt;printIncludes(&#039;js&#039;);
$form-&gt;printJsCode();
?&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                </div>
            </article>
            <article class="mb-6">
                <h3 id="to-go-further" class="numbered-title">To go further</h3>
                <div class="pl-4">
                    <p><strong>Now you've learned the basics ; Several resources will help to add other fields, plugins, validate different values and build more complex layouts:</strong></p>
                    <ul>
                        <li><a href="../templates/index.php">Templates</a></li>
                        <li><a href="code-samples.php">Code Samples</a></li>
                        <li><a href="functions-reference.php">Functions Reference</a></li>
                        <li><a href="class-doc.php">Class Doc.</a></li>
                    </ul>
                </div>
            </article>
        </section>
        </div>
    <?php require_once 'inc/js-includes.php'; ?>
</body>
</html>
