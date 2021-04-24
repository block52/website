<!doctype html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder - Functions reference',
            'description' => 'PHP Form Builder - Quick reminder with all available methods to build your forms',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/functions-reference.php',
            'screenshot'  => 'functions-reference.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}.col-sm-3,.col-sm-8{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}article,nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2{margin-top:0;margin-bottom:.5rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}code{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}code{font-size:87.5%;color:#e83e8c;word-break:break-word}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.col-sm-1,.col-sm-3,.col-sm-8{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}@media (min-width:576px){.col-sm-1{-webkit-box-flex:0;-ms-flex:0 0 8.33333%;flex:0 0 8.33333%;max-width:8.33333%}.col-sm-3{-webkit-box-flex:0;-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}.col-sm-8{-webkit-box-flex:0;-ms-flex:0 0 66.66667%;flex:0 0 66.66667%;max-width:66.66667%}}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-primary{color:#fff;background-color:#0e73cc;border-color:#0e73cc;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.btn-sm{padding:.25rem .5rem;font-size:13.125px;line-height:1.5;border-radius:.2rem}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.nav-pills .nav-link.active{color:#fff;background-color:#007bff}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.badge{display:inline-block;padding:.15em .5em;font-size:75%;font-weight:500;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.2rem}.badge-secondary{color:#fff;background-color:#696359}.d-inline-block{display:inline-block!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.mt-1{margin-top:.25rem!important}.mr-1{margin-right:.25rem!important}.mb-2{margin-bottom:.5rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.mb-4{margin-bottom:1.5rem!important}.has-separator,h2{margin-bottom:3rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.pt-1{padding-top:.25rem!important}code[class*=language]{padding-right:.25rem!important}code[class*=language]{padding-left:.25rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.pb-5{padding-bottom:3rem!important}.ml-auto{margin-left:auto!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>a.active{background-color:#a93030}[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}code,code[class*=language]{font-size:.75rem}strong{font-weight:500}.badge:not(.badge-circle){border-radius:0}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.has-separator{display:block;position:relative}.has-separator:after,.has-separator:before{position:absolute;left:50%;height:1px;content:'';background:#c6c2bb}.has-separator:before{bottom:-16px;width:12%;margin-left:-6%}.has-separator:after{bottom:-13px;width:20%;margin-left:-10%}code[class*=language-]{position:relative;color:#ccc;background:0 0;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;-ms-hyphens:none;hyphens:none}:not(pre)>code[class*=language-]{background:#2d2d2d}:not(pre)>code[class*=language-]{padding:.1em;border-radius:.25rem!important;white-space:normal}
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="quick-start-guide.php">Quick Start Guide</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../templates/index.php">Form Templates</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="jquery-plugins.php">jQuery Plugins</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="code-samples.php">Code Samples</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="class-doc.php">Class Doc.</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="functions-reference.php">Functions Reference</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="help-center.php">Help Center</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--/LSHIDE-->

    <div id="navbar-left-wrapper" class="w3-animate-left">
        <a href="#" id="navbar-left-collapse" class="d-inline-block d-lg-none d-xlg-none float-right text-white p-4"><i class="fas fa-times"></i></a>
        <ul id="navbar-left" class="nav nav-pills flex-column pt-1 mb-4" role="tablist" aria-orientation="vertical">
            <li class="nav-item"><a class="nav-link active" href="#general">General</a></li>
            <li class="nav-item"><a class="nav-link" href="#elements">Elements</a></li>
            <li class="nav-item"><a class="nav-link" href="#rendering">Rendering</a></li>
            <li class="nav-item"><a class="nav-link" href="#shortcut-functions">Shortcut functions</a></li>
            <li class="nav-item"><a class="nav-link" href="#plugins">Plugins</a></li>
            <li class="nav-item"><a class="nav-link" href="#popover-modal">Popover &amp; Modal</a></li>
            <li class="nav-item"><a class="nav-link" href="#email-sending">Email sending</a></li>
        </ul>
    </div>
    <div class="container">

        <?php include_once 'inc/top-section.php'; ?>

        <h1 id="home">Functions reference</h1>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="general">General</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>__construct</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form = new Form($form_ID, $layout = 'horizontal', $attr = '', $framework = 'bs4');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#construct" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>setMode</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->setMode($mode);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#setMode" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>setOptions</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->setOptions($user_options = array());</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#setOptions" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>setMethod</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->setMethod($method);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#setMethod" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>setAction</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->setAction($url, $add_get_vars = true);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#setAction" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>startFieldset</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->startFieldset($legend = '', $fieldset_attr = '', $legend_attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#startFieldset" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>endFieldset</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->endFieldset();</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#endFieldset" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>startDependentFields</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->startDependentFields($parent_field, $show_values[, $inverse = false]);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#startDependentFields" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>endDependentFields</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->endDependentFields();</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#endDependentFields" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>clear</strong> <span class="badge badge-secondary mt-1 float-right">static</span></div>
                <div class="col-sm-8 mb-2"><code class="language-php">Form::clear($form_ID);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#clear" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>registerValues</strong> <span class="badge badge-secondary mt-1 float-right">static</span></div>
                <div class="col-sm-8 mb-2"><code class="language-php">Form::registerValues($form_ID);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#registerValues" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>mergeValues</strong> <span class="badge badge-secondary mt-1 float-right">static</span></div>
                <div class="col-sm-8 mb-2"><code class="language-php">Form::mergeValues($form_names_array);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#mergeValues" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>testToken</strong> <span class="badge badge-secondary mt-1 float-right">static</span></div>
                <div class="col-sm-8 mb-2"><code class="language-php">Form::testToken($form_ID);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#securityt-csrf" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="elements">Elements</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addInput</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addInput($type, $name, $value = '', $label = '', $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addInput" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>groupInputs</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->groupInputs($input1, $input2, $input3 = '', $input4 = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#groupInputs" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addTextarea</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addTextarea($name, $value = '', $label = '', $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addTextarea" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addOption</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addOption($select_name, $value, $txt, $group_name = '', $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addOption" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addSelect</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addSelect($select_name, $label = '', $attr = '', $displayGroupLabels = true);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addSelect" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addCountrySelect</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addCountrySelect($select_name, $label = '', $attr = '', $user_options = array());</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addCountrySelect" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addRadio</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addRadio($group_name, $label, $value, $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addRadio" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>printRadioGroup</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->printRadioGroup($group_name, $label = '', $inline = true, $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#printRadioGroup" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addCheckbox</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addCheckbox($group_name, $label, $value, $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addCheckbox" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>printCheckboxGroup</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->printCheckboxGroup($group_name, $label = '', $inline = true, $attr = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#printCheckboxGroup" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addBtn</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addBtn($type, $name, $value, $text, $attr = '', $btnGroupName = '')</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addBtn" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>printBtnGroup</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->printBtnGroup($btnGroupName, $label = '')</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#printBtnGroup" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addHtml</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addHtml($html, $element_name = '', $pos = 'after');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addHtml" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addInputWrapper</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addInputWrapper($html, $element_name);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#addInputWrapper" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="rendering">Rendering</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>render</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->render([$debug = false, $display = true]);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#render" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>useLoadJs</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->useLoadJs($bundle = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#useLoadJs" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>printIncludes</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->printIncludes($type, $debug = false, $display = true);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#printIncludes" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>printJsCode</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->printJsCode($debug = false);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#printJsCode" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="shortcut-functions">Shortcut functions</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>setCols</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->setCols($labelsCols, $fieldsCols, $breakpoint = 'sm');</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#set-cols" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addHelper</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addHelper($helper_text, $element_name);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#add-helper" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addAddon</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addAddon($input_name, $addon_html, $pos);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#add-addon" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addIcon</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addIcon($input_name, $icon_html, $pos);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#add-icon" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>centerButtons</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->centerButtons($center);</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#center-buttons" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="plugins">Plugins</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addPlugin</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addPlugin($plugin_name, $selector, $js_content = 'default', $js_replacements = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#plugins-overview" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addFileUpload</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addFileUpload($type, $name, $value = '', $label = '', $attr = '', $fileUpload_config = '', $current_file = '');</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#fileuploader" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addRecaptcha</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addRecaptcha($key);</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#recaptcha-example" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>addInvisibleRecaptcha</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->addInvisibleRecaptcha($key);</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#invisible-recaptcha-example" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="popover-modal">Popover &amp; Modal</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>popover</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->popover('#popover-link', $popover_options);</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#popover-example" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>modal</strong></div>
                <div class="col-sm-8 mb-2"><code class="language-php">$form->modal('#modal-target');</code></div>
                <div class="col-sm-1 mb-2"><a href="jquery-plugins.php#modal-example" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
        <article class="pb-5 mb-7 has-separator">
            <h2 id="email-sending">Email sending</h2>
            <div class="row">
                <div class="col-sm-3 mb-2"><strong>sendMail</strong> <span class="badge badge-secondary mt-1 float-right">static</span></div>
                <div class="col-sm-8 mb-2"><code class="language-php">Form::sendMail($options, $smtp_settings = array());</code></div>
                <div class="col-sm-1 mb-2"><a href="class-doc.php#sendMail" class="btn btn-sm btn-primary">doc.</a></div>
            </div>
        </article>
    </div>
    <!-- container -->
    <?php require_once 'inc/js-includes.php'; ?>
</body>
</html>
