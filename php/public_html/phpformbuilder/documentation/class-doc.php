<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder Class Documentation',
            'description' => 'PHP Form Builder functions and arguments list with detailed descriptions and code samples',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/class-doc.php',
            'screenshot'  => 'class-doc.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}ul{margin-top:0;margin-bottom:1rem}.h4{margin-bottom:1rem!important}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}.mb-7{margin-bottom:12.5rem!important}.dmca-badge{min-height:100px}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ol,ul{margin-top:0;margin-bottom:1rem}ul ul{margin-bottom:0}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}code,pre{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input,optgroup{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h4,h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}.h4{font-size:22.5px}.lead{font-size:1.25rem;font-weight:300}.small{font-size:80%;font-weight:400}code{font-size:87.5%;color:#e83e8c;word-break:break-word}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.dropdown-toggle::after{display:inline-block;width:0;height:0;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.badge{display:inline-block;padding:.15em .5em;font-size:75%;font-weight:500;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.2rem}.d-inline-block{display:inline-block!important}.mr-1{margin-right:.25rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.file-path,.mr-1{margin-right:.25rem!important}.file-path{margin-left:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.h4,ol li{margin-bottom:1rem!important}.my-4{margin-top:1.5rem!important}.mb-4,.my-4{margin-bottom:1.5rem!important}h2{margin-bottom:3rem!important}.px-0,pre>code[class*=language]{padding-right:0!important}.px-0,pre>code[class*=language]{padding-left:0!important}.pt-1,.py-1{padding-top:.25rem!important}code[class*=language]{padding-right:.25rem!important}.py-1{padding-bottom:.25rem!important}code[class*=language]{padding-left:.25rem!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.pb-7{padding-bottom:12.5rem!important}.ml-auto{margin-left:auto!important}.text-center{text-align:center!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}.text-gray-300{color:#c6c2bb!important}.bg-gray-800{background-color:#23211e!important}.bg-gray-800{color:#fff}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li,#navbar-left ul{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>ul>li{width:100%}#navbar-left>li>ul>li a{font-size:13px;font-weight:300;line-height:20px;display:block;padding:5px 22px 5px 30px;text-decoration:none;text-shadow:none;border-top:1px solid #4c4841;border-bottom:1px solid #151412;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#393631}#navbar-left>li>ul>li a .badge{text-shadow:none;text-transform:uppercase}#navbar-left>li>ul>li:first-child a{border-top:none}#navbar-left>li>ul>li:last-child a{border-bottom:none}.dropdown-toggle:not(.sidebar-toggler):after{line-height:22.5px;position:absolute;top:calc(50% - 7px);right:1rem;display:block;width:7px;height:14px;margin:0;content:' ';-webkit-transition:-webkit-transform .2s ease-in-out;transition:-webkit-transform .2s ease-in-out;-o-transition:transform .2s ease-in-out;transition:transform .2s ease-in-out;transition:transform .2s ease-in-out,-webkit-transform .2s ease-in-out;-webkit-transform:rotate(0);-ms-transform:rotate(0);transform:rotate(0);border:none;background-repeat:no-repeat}.dropdown-toggle{position:relative;padding-right:2.5rem!important}.dropdown-toggle:not(.dropdown-light):after{background-image:url("data:image/svg+xml,%3Csvg aria-hidden='true' data-fa-processed='' data-prefix='fas' data-icon='angle-right' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 512' class='svg-inline--fa fa-angle-right fa-w-8 fa-2x'%3E%3Cpath fill='%23a9a398' d='M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z' class=''%3E%3C/path%3E%3C/svg%3E")}[class^=icon-]{font-family:icomoon;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}.h4,h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}.h4{font-weight:300;color:#a9a398}p.lead{font-weight:400;color:#696359}code,code[class*=language],pre{font-size:.75rem}strong{font-weight:500}section>h2{padding:1rem;border-bottom:1px solid #ddd}.badge:not(.badge-circle){border-radius:0}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.file-path{font-size:93.33333333333333%}.file-path{display:inline-block;padding:.15em .5em;font-weight:400;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline}.file-path.file-path{border-radius:.2rem;color:#212529;background-color:#f4f3f1}code[class*=language-]{position:relative;color:#ccc;background:0 0;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;-ms-hyphens:none;hyphens:none}:not(pre)>code[class*=language-]{background:#2d2d2d}:not(pre)>code[class*=language-]{padding:.1em;border-radius:.25rem!important;white-space:normal}
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
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="class-doc.php">Class Doc.</a></li>
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

            <li class="nav-item"><p class="h4 text-center my-4">Settings</p></li>

            <li class="nav-item"><a class="nav-link" href="#overview">Overview</a></li>
            <li class="nav-item"><a class="nav-link" href="#frameworks">Frameworks</a></li>
            <li class="nav-item"><a class="nav-link" href="#about-optimization">About optimization</a></li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#collapseOptions" role="button" data-toggle="collapse" data-parent="#navbar-left-wrapper" aria-controls="collapseOptions" aria-expanded="false">Options</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseOptions">
                    <li class="nav-item"><a class="nav-link" href="#options-overview">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" href="#options-default">Default options (Bootstrap / Material Design)</a></li>
                    <li class="nav-item"><a class="nav-link" href="#options-customizing">Customizing for other framework</a></li>
                </ul>
            </li>

            <li class="nav-item"><p class="h4 text-center my-4">Main functions</p></li>

            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" data-toggle="collapse" href="#collapseGeneral" aria-controls="collapseGeneral" aria-expanded="false">General</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseGeneral">
                    <li class="nav-item"><a class="nav-link" href="#construct">construct</a></li>
                    <li class="nav-item"><a class="nav-link" href="#setMode">setMode</a></li>
                    <li class="nav-item"><a class="nav-link" href="#setOptions">setOptions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#setMethod">setMethod</a></li>
                    <li class="nav-item"><a class="nav-link" href="#setAction">setAction</a></li>
                    <li class="nav-item"><a class="nav-link" href="#startFieldset">startFieldset</a></li>
                    <li class="nav-item"><a class="nav-link" href="#endFieldset">endFieldset</a></li>
                    <li class="nav-item"><a class="nav-link" href="#startDependentFields">startDependentFields</a></li>
                    <li class="nav-item"><a class="nav-link" href="#endDependentFields">endDependentFields</a></li>
                    <li class="nav-item"><a class="nav-link" href="#attr">$attr argument</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#collapseElements" role="button" data-toggle="collapse" aria-controls="collapseElements" aria-expanded="false">Elements</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseElements">
                    <li class="nav-item"><a class="nav-link" href="#addInput">addInput</a></li>
                    <li class="nav-item"><a class="nav-link" href="#groupInputs">groupInputs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#addTextarea">addTextarea<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">textarea</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addOption">addOption<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">select</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addSelect">addSelect<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">select</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addCountrySelect">addCountrySelect<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">select</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addRadio">addRadio<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">radio</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#printRadioGroup">printRadioGroup<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">radio</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addCheckbox">addCheckbox<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">checkbox</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#printCheckboxGroup"><span class="small">printCheckboxGroup</span><span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">checkbox</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addBtn">addBtn<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">button</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#printBtnGroup">printBtnGroup<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">button</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addHtml">addHtml<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">HTML</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#addInputWrapper">addInputWrapper<span class="badge bg-gray-800 text-gray-300 px-2 py-1 float-right ml-2">HTML</span></a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#collapseRendering" role="button" data-toggle="collapse" aria-controls="collapseRendering" aria-expanded="false">Rendering</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseRendering">
                    <li class="nav-item"><a class="nav-link" href="#render">render</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ajax-loading">Ajax loading</a></li>
                    <li class="nav-item"><a class="nav-link" href="#useLoadJs">useLoadJs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#printIncludes">printIncludes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#printJsCode">printJsCode</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#collapseShortcuts" role="button" data-toggle="collapse" aria-controls="collapseShortcuts" aria-expanded="false">Shortcut functions</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseShortcuts">
                    <li class="nav-item"><a class="nav-link" href="#set-cols">setCols</a></li>
                    <li class="nav-item"><a class="nav-link" href="#add-helper">addHelper</a></li>
                    <li class="nav-item"><a class="nav-link" href="#add-addon">addAddon</a></li>
                    <li class="nav-item"><a class="nav-link" href="#add-icon">addIcon</a></li>
                    <li class="nav-item"><a class="nav-link" href="#center-buttons">centerButtons</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#collapseEmailSending1" role="button" data-toggle="collapse" aria-controls="collapseEmailSending1" aria-expanded="false">Email sending</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseEmailSending1">
                    <li class="nav-item"><a class="nav-link" href="#mainFunctionsSendMail">sendMail</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#collapseRegisteringClearingValues" role="button" data-toggle="collapse" aria-controls="collapseRegisteringClearingValues" aria-expanded="false">Registering / Clearing values</a>
                <ul class="nav nav-pills nav-stacked collapse" id="collapseRegisteringClearingValues">
                    <li class="nav-item"><a class="nav-link" href="#global-registration-process">Global registration process</a></li>
                    <li class="nav-item"><a class="nav-link" href="#registerValues">registerValues (static)</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mergeValues">mergeValues (static)</a></li>
                    <li class="nav-item"><a class="nav-link" href="#clear">clear (static)</a></li>
                </ul>
            </li>

            <li class="nav-item"><p class="h4 text-center my-4">Form Validation</p></li>

            <li class="nav-item"><a class="nav-link" href="#validation-overview">Overview</a></li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#php-validation" role="button" data-toggle="collapse" aria-controls="php-validation" aria-expanded="false">PHP Validation</a>
                <ul class="nav nav-pills nav-stacked collapse" id="php-validation">
                    <li class="nav-item"><a class="nav-link" href="#php-validation-basics">Basics</a></li>
                    <li class="nav-item"><a class="nav-link" href="#dependent-fields-validation">Dependent fields validation</a></li>
                    <li class="nav-item"><a class="nav-link" href="#php-validation-methods">Available methods</a></li>
                    <li class="nav-item"><a class="nav-link" href="#php-validation-examples">Examples</a></li>
                    <li class="nav-item"><a class="nav-link" href="#php-validation-multilanguage">Multilanguage support</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" class="collapsible-child" href="#jquery-validation" role="button" data-toggle="collapse" aria-controls="jquery-validation" aria-expanded="false">Real time Validation (jQuery)</a>
                <ul class="nav nav-pills nav-stacked collapse" id="jquery-validation">
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-getting-started">Getting started</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-available-methods">Available methods</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-callback-api">Callback & API</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-examples">Examples</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-multilanguage">Multilanguage support</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jquery-validation-more">More</a></li>
                </ul>
            </li>

            <li class="nav-item"><p class="h4 text-center my-4">E-mail sending</p></li>

            <li class="nav-item"><a class="nav-link" href="#sendMail">sendMail</a></li>
            <li class="nav-item"><a class="nav-link" href="#attachmentsExamples">Attachments examples</a></li>

            <li class="nav-item"><p class="h4 text-center my-4">Database utilities</p></li>

            <li class="nav-item"><a class="nav-link" href="#database-main">Main class</a></li>
            <li class="nav-item"><a class="nav-link" href="#database-select">Select example</a></li>
            <li class="nav-item"><a class="nav-link" href="#database-insert">Insert example</a></li>
            <li class="nav-item"><a class="nav-link" href="#database-update">Update example</a></li>
            <li class="nav-item"><a class="nav-link" href="#database-delete">Delete example</a></li>
            <li class="nav-item">

            <li class="nav-item"><p class="h4 text-center my-4">Security</p></li>

            <li class="nav-item"><a class="nav-link" href="#security">Main</a></li>
            <li class="nav-item"><a class="nav-link" href="#security-xss">XSS (Cross-Site Scripting)</a></li>
            <li class="nav-item"><a class="nav-link" href="#securityt-csrf">CSRF (Cross-Site Request Forgeries)</a></li>

            <li class="nav-item"><p class="h4 text-center my-4">~</p></li>

            <li class="nav-item"><a class="nav-link" href="#extending-main-class">Extending Main Class</a></li>
            <li class="nav-item"><a class="nav-link" href="#chaining-methods">Chaining methods</a></li>
            <li class="nav-item"><a class="nav-link" href="#credits">Sources &amp; Credits</a></li>
        </ul>
        <div class="text-center mb-xs"><a href="//www.dmca.com/Protection/Status.aspx?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" title="DMCA.com Protection Status" class="dmca-badge"><img data-src="//images.dmca.com/Badges/dmca-badge-w100-1x1-01.png?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="lazyload" alt="DMCA.com Protection Status" width="100" height="100"></a><script defer src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"></script></div>
        <div class="text-center mb-7">
            <a href="https://www.hack-hunt.com" title="Send DMCA Takedown Notice" class="text-white">www.hack-hunt.com</a>
        </div>
        <!-- navbar-left -->
    </div>

    <!-- /main sidebar -->

    <div class="container">

        <?php include_once 'inc/top-section.php'; ?>

        <section class="pb-7">
            <h1>Class Documentation</h1>
            <h2 id="overview">Overview</h2>
            <p class="lead">To build and display your form you'll have to include 4 php code blocks:</p>
            <ol>
                <li>First block at the very beginning of your page to include <span class="file-path">Form.php</span> and build the form.</li>
                <li>Second block in your <code class="language-php">&lt;head&gt;&lt;/head&gt;</code> section to call required css files for plugins.</li>
                <li>Third block in <code class="language-php">&lt;body&gt;&lt;/body&gt;</code> section to render your form.</li>
                <li>Fourth block just before <code class="language-php">&lt;/body&gt;</code> to call required js files and js code to activate plugins.</li>
            </ol>
            <p><strong>Here is an example of page containing a form:</strong></p>
            <pre class="line-numbers mb-4"><code class="language-php">&lt;?php

    // set namespace
    use phpformbuilder\Form;

    // start session
    session_start();

    // include Form.php
    include_once rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR) . &#039;/phpformbuilder/Form.php&#039;;

    // instanciate form and add fields
    $form = new Form(&#039;my-form&#039;, &#039;horizontal&#039;, &#039;novalidate&#039;, &#039;material&#039;);
    $form-&gt;addInput(&#039;text&#039;, &#039;user-name&#039;, &#039;Your Name&#039;, &#039;name&#039;, &#039;required=required&#039;);
    [...]
    &lt;!DOCTYPE html&gt;
    &lt;html&gt;
    &lt;head&gt;
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta http-equiv=&quot;X-UA-Compatible&quot; content=&quot;IE=edge&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;
    &lt;title&gt;My form&lt;/title&gt;

    &lt;!-- Bootstrap CSS --&gt;
    &lt;link href=&quot;../assets/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot;&gt;
    &lt;?php

    // call css files for plugins
    $form-&gt;printIncludes(&#039;css&#039;);
    ?&gt;
    &lt;/head&gt;
    &lt;body&gt;
    &lt;h1 class=&quot;text-center&quot;&gt;My form&lt;/h1&gt;
    &lt;div class=&quot;container&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3&quot;&gt;
    &lt;?php

    // render the form
    $form-&gt;render();
    ?&gt;
    &lt;/div&gt;
    &lt;/div&gt;
    &lt;/div&gt;
    &lt;!-- jQuery --&gt;
    &lt;script src=&quot;//code.jquery.com/jquery.js&quot;&gt;&lt;/script&gt;
    &lt;!-- Bootstrap JavaScript --&gt;
    &lt;script src=&quot;../assets/js/bootstrap.min.js&quot;&gt;&lt;/script&gt;
    &lt;?php

    // call required js files and js code to activate plugins
    $form-&gt;printIncludes(&#039;js&#039;);
    $form-&gt;printJsCode();
    ?&gt;
    &lt;/body&gt;
    &lt;/html&gt;

            </code></pre>
        </section>
        <section class="pb-7">
            <h2 id="frameworks">Frameworks</h2>
            <p>All options are ready to use, and will generate HTML markup according to the chosen framework.</p>
            <p>The default framework is <strong>Bootstrap 4</strong>.</p>
            <article class="pb-5 mb-7 has-separator">
                <h3>Bootstrap 3</h3>
                <pre class="line-numbers mb-4"><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate', 'bs3');</code></pre>
                <h3>Bootstrap 4 <small class="badge badge-secondary ml-2">Default</small></h3>
                <pre class="line-numbers mb-4"><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate');</code></pre>
                <h3>Material Design</h3>
                <p>Material Design forms are built with <a href="https://materializecss.com/">Materialize framework</a>.</p>
                <p>Material Design forms forms can be used both on pages built with <strong>Materialize</strong> and on pages built with <strong>Bootstrap 4</strong>.</p>
                <ul class="mb-6">
                    <li>
                        If your website uses <strong>Materialize framework</strong>:
                        <pre><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate', 'material');</code></pre>
                    </li>
                    <li>
                        If your website uses <strong>Bootstrap 4 framework</strong>:
                        <pre><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate', 'material');

// materialize plugin
$form->addPlugin('materialize', '#my-form');</code></pre>
                    </li>
                </ul>
                <h3>Foundation - v6.4 or higher, with XY grid</h3>
                <pre class="line-numbers mb-4"><code class="language-php">$form = new Form('my-form', 'horizontal', 'novalidate', 'foundation');</code></pre>
                <p>More details about <code class="language-php">__construct()</code> here: <a href="#construct">Main functions > General > Construct</a></p>
            </article>
        </section>
        <section class="pb-7">
            <!--=====================================
            =            Section comment            =
            ======================================-->

            <!-- Ajouter instructions pour désactiver les icones:
                 $form = new Form('booking-form', 'horizontal', 'data-fv-no-icon=true, novalidate'); -->

            <!-- Ajouter instructions pour le mode DEBUG:
                 $form = new Form('booking-form', 'horizontal', 'data-fv-debug=true, novalidate'); -->

            <!--====  End of Section comment  ====-->

            <h2 id="about-optimization">About optimization (CSS & JS dependencies)</h2>
            <p><strong>Without PHP Form Builder, your page loads the plugin dependencies (CSS and Javascript files) one by one</strong>.<br>
                        If your form uses 5 plugins, you will need to call at least 10 files (5 CSS + 5 Javascript),<br>which considerably increases the loading time.</p>
            <p><strong>PHP Form Builder groups and compresses all the CSS and Javascript dependencies into a single CSS | Javascript file</strong>.</p>
            <p>Your page will therefore only call 2 dependency files. Efficiency is maximum, no matter how many plugins you use.</p>
            <p>Javascript dependencies can also be loaded with the excellent <a href="https://github.com/muicss/loadjs" target="_blank">loadjs library</a>.</p>
            <p>Detailed explanations are available here: <a href="jquery-plugins.php#optimization">Optimization (CSS & JS dependencies)</a></p>
        </section>
        <section class="pb-7">
            <h2 id="options-overview">Options</h2>
            <article class="pb-5 mb-7 has-separator">
                <h3>Overview</h3>
                <p>PHP Form Builder Options are defining HTML wrappers and classes.
                    <br>Default options are Bootstrap 4 options.
                    <br>Each can be overwritten the way you want to match other framework
                </p>
                <p>For example, with Bootstrap, each group (label + element) has to be wrapped into a <code class="language-php">&lt;div class=&quot;form-group&quot;&gt;&lt;/div&gt;</code> and to have a <code class="language-php">.form-control class</code></p>
                <p>We also need do add <code class="language-php">.col-sm-x</code> &amp; <code class="language-php">.control-label</code> to labels, <br>and to wrap elements with <code class="language-php">&lt;div class=&quot;col-sm-x&quot;&gt;&lt;/div&gt;</code>.</p>
                <p>All will be easily done with Form options.</p>
                <p>if needeed, wrappers can contain 2 html elements.<br>
                    This can be done with <var>elementsWrapper</var>, <var>checkboxWrapper</var> and <var>radioWrapper</var>.
                </p>
                <p>To add input wrapper, see <a href="#addInputWrapper">addInputWrapper</a> function.</p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="options-default">Default options (Bootstrap 4)</h3>
                <pre class="line-numbers mb-4"><code class="language-php">$options = array(
    'ajax'                         => false,
    'deferScripts'                 => true,
    'elementsWrapper'              => '&lt;div class=&quot;form-group&quot;&gt;&lt;/div&gt;&#039;,
    'formInlineClass'              => 'form-inline',
    'formHorizontalClass'          => 'form-horizontal',
    'formVerticalClass'            => '',
    'checkboxWrapper'              => '&lt;div class=&quot;form-check&quot;&gt;&lt;/div&gt;',
    'radioWrapper'                 => '&lt;div class=&quot;form-check&quot;&gt;&lt;/div&gt;',
    'helperWrapper'                => '&lt;small class=&quot;form-text text-muted&quot;&gt;&lt;/small&gt;',
    'buttonWrapper'                => '&lt;div class=&quot;form-group&quot;&gt;&lt;/div&gt;',
    'centeredButtonWrapper'        => '&lt;div class=&quot;form-group text-center&quot;&gt;&lt;/div&gt;',
    'centerButtons'                => false,
    'wrapElementsIntoLabels'       => false,
    'wrapCheckboxesIntoLabels'     => false,
    'wrapRadiobtnsIntoLabels'      => false,
    'elementsClass'                => 'form-control',
    'wrapperErrorClass'            => '',
    'elementsErrorClass'           => 'is-invalid',
    'textErrorClass'               => 'invalid-feedback',
    'verticalLabelWrapper'         => false,
    'verticalLabelClass'           => 'form-control-label',
    'verticalCheckboxLabelClass'   => 'form-check-label',
    'verticalRadioLabelClass'      => 'form-check-label',
    'horizontalLabelWrapper'       => false,
    'horizontalLabelClass'         => 'col-form-label',
    'horizontalLabelCol'           => 'col-sm-4',
    'horizontalOffsetCol'          => '',
    'horizontalElementCol'         => 'col-sm-8',
    'inlineCheckboxLabelClass'     => 'form-check-label',
    'inlineRadioLabelClass'        => 'form-check-label',
    'inlineCheckboxWrapper'        => '&lt;div class=&quot;form-check form-check-inline&quot;&gt;&lt;/div&gt;',
    'inlineRadioWrapper'           => '&lt;div class=&quot;form-check form-check-inline&quot;&gt;&lt;/div&gt;',
    'inputGroupAddonClass'         => 'input-group',
    'btnGroupClass'                => 'btn-group',
    'requiredMark'                 => '&lt;sup class=&quot;text-danger&quot;&gt;* &lt;/sup&gt;',
    'openDomReady'                 => 'jQuery(document).ready(function($) {',
    'closeDomReady'                => '});'
);</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example of generated HTML code for each option with Bootstrap 4 framework</h4>
                        <table class="table table-striped highlight">
                            <tbody>
                                <tr>
                                    <th class="medium">ajax</th>
                                    <td class="text-muted small">if <span class="var-value">true</span>, <code class="language-php">render()</code> will generate json code to load with Ajax</td>
                                </tr>
                                <tr>
                                    <th class="medium">deferScripts</th>
                                    <td class="text-muted small">if <span class="var-value">true</span> the plugins scripts loading will be deferred</td>
                                </tr>
                                <tr>
                                    <th class="medium">elementsWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class="form-group"&gt;</code><br>
                                        <span class="ml-3">[&lt;label&gt; ... &lt;/label&gt;]</span><br>
                                        <span class="ml-3">[&lt;input&gt;]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">formInlineClass</th>
                                    <td class="text-muted small">&lt;form class="<code class="language-php">form-inline</code>" [...]&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">formHorizontalClass</th>
                                    <td class="text-muted small">&lt;form class="<code class="language-php">form-horizontal</code>" [...]&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">formVerticalClass</th>
                                    <td class="text-muted small">&lt;form class="<code class="language-php">form-vertical</code>" [...]&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">checkboxWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class="checkbox"&gt;</code><br>
                                        <span class="ml-3">[&lt;label&gt;]</span><br>
                                        <span class="ml-3"><span class="ml-3">[&lt;input type="checkbox"&gt;[text]]</span></span><br>
                                        <span class="ml-3">[&lt;/label&gt;]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">radioWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class="radio"&gt;</code><br>
                                        <span class="ml-3">[&lt;label&gt;]</span><br>
                                        <span class="ml-3"><span class="ml-3">[&lt;input type="radio"&gt;]</span></span><br>
                                        <span class="ml-3">[&lt;/label&gt;]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">helperWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;span class=&quot;help-block&quot;&gt;</code>[Help text]<code class="language-php">&lt;/span&gt;
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">buttonWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class=&quot;form-group&quot;&gt;</code><br>
                                        <span class="ml-3">[&lt;label&gt; ... &lt;/label&gt;]</span><br>
                                        <span class="ml-3">[&lt;button&gt; ... &lt;/button&gt;]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">centeredButtonWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class=&quot;form-group text-center&quot;&gt;</code><br>
                                        <span class="ml-3">[button]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">centerButtons</th>
                                    <td class="text-muted small">if <span class="var-value">true</span>, the form buttons will be automatically centered horizontally.</td>
                                </tr>
                                <tr>
                                    <th class="medium">wrapElementsIntoLabels</th>
                                    <td class="text-muted small"><code class="language-php">&lt;label&gt;</code>[input | textarea | ...]<code class="language-php">&lt;/label&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">wrapCheckboxesIntoLabels</th>
                                    <td class="text-muted small"><code class="language-php">&lt;label&gt;</code>[checkbox]<code class="language-php">&lt;/label&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">wrapRadiobtnsIntoLabels</th>
                                    <td class="text-muted small"><code class="language-php">&lt;label&gt;</code>[radio]<code class="language-php">&lt;/label&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">elementsClass</th>
                                    <td class="text-muted small">&lt;input class="<code class="language-php">form-control</code>" [...]&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">wrapperErrorClass</th>
                                    <td class="text-muted small">&lt;div class="[form-group] <code class="language-php">has-error</code>"&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">elementsErrorClass</th>
                                    <td class="text-muted small">&lt;input class="[form-control] <code class="language-php">error-class</code>" [...]&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">textErrorClass</th>
                                    <td class="text-muted small">&lt;p class="<code class="language-php">text-danger</code>"&gt; ... &lt;/p&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">verticalLabelWrapper</th>
                                    <td class="text-muted small">if <span class="var-value">true</span>, the labels will be wrapped in a &lt;div class="<code class="language-php">verticalLabelClass</code>"&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">verticalLabelClass</th>
                                    <td class="text-muted small">&lt;div class="<code class="language-php">verticalLabelClass</code>"&gt;[label]&lt;/div&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">verticalCheckboxLabelClass</th>
                                    <td class="text-muted small">&lt;label for="[fieldname]" class="<code class="language-php">verticalCheckboxLabelClass</code>"&gt;[text]&lt;/label&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">verticalRadioLabelClass</th>
                                    <td class="text-muted small">&lt;label for="[fieldname]" class="<code class="language-php">verticalRadioLabelClass</code>"&gt;[text]&lt;/label&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">horizontalLabelWrapper</th>
                                    <td class="text-muted small">if <span class="var-value">true</span>, the labels will be wrapped in a div with the column class instead of having the column class themselves</td>
                                </tr>
                                <tr>
                                    <th class="medium">horizontalLabelClass,<br>horizontalLabelCol</th>
                                    <td class="text-muted small">&lt;label class="<code class="language-php">col-sm-4</code> <code class="language-php">control-label</code>"&gt;...&lt;/label&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">horizontalOffsetCol</th>
                                    <td class="text-muted small">
                                        // when label is empty, automaticaly offsetting field container<br>
                                        &lt;div class="<code class="language-php">col-sm-offset-4</code> [col-sm-8]"&gt;<br>
                                        <span class="ml-3">[&lt;input&gt;]</span><br>
                                        &lt;/div&gt;
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">horizontalElementCol</th>
                                    <td class="text-muted small">
                                        &lt;div class="<code class="language-php">col-sm-8</code>"&gt;<br>
                                        <span class="ml-3">[&lt;input&gt;]</span><br>
                                        &lt;/div&gt;
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">inlineRadioLabelClass</th>
                                    <td class="text-muted small">&lt;label class="<code class="language-php">radio-inline</code>"&gt;...&lt;/label&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">inlineCheckboxLabelClass</th>
                                    <td class="text-muted small">&lt;label class="<code class="language-php">checkbox-inline</code>"&gt;...&lt;/label&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">inlineCheckboxWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class="form-check form-check-inline"&gt;</code><br>
                                        <span class="ml-3">[input type="checkbox"]</span><br>
                                        <span class="ml-3">[label]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">inlineRadioWrapper</th>
                                    <td class="text-muted small">
                                        <code class="language-php">&lt;div class="form-check form-check-inline"&gt;</code><br>
                                        <span class="ml-3">[input type="radio"]</span><br>
                                        <span class="ml-3">[label]</span><br>
                                        <code class="language-php">&lt;/div&gt;</code>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">inputGroupAddonClass</th>
                                    <td class="text-muted small">&lt;div class="<code class="language-php">input-group</code>"&gt;[input with addon]&lt;/div&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">btnGroupClass</th>
                                    <td class="text-muted small">&lt;div class=&quot;<code class="language-php">btn-group</code>&quot;&gt;...&lt;/div&gt;</td>
                                </tr>
                                <tr>
                                    <th class="medium">requiredMark</th>
                                    <td class="text-muted small">
                                        // required markup is automaticaly added on required fields<br>
                                        &lt;label&gt;my required text<code class="language-php">&lt;sup class="text-danger"&gt; *&lt;/sup&gt;</code>&lt;/label&gt;
                                    </td>
                                </tr>
                                <tr>
                                    <th class="medium">openDomReady<br><span class="small">(if not using jQuery,<br>changes the code your plugins<br>will be wrapped in)</span></th>
                                    <td class="text-muted small"><code class="language-php">$(document).ready(function() {</code></td>
                                </tr>
                                <tr>
                                    <th class="medium">closeDomReady</th>
                                    <td class="text-muted small"><code class="language-php">});</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="options-customizing">Customizing for other framework</h3>
                <p>If you want to use PHP Form Builder with another framework like <strong>Semantic-UI, Pure, Skeleton, UIKit, Milligram, Susy, Bulma, Kube, ...</strong>, you have to change the options to match your framework HTML &amp; CSS classes:</p>
                <pre class="line-numbers mb-4"><code class="language-php">$options = array(
    // your options here
);

$form->setOptions($options);</code></pre>
                <p>If you always use the same framework, the best way is to create a custom function with your custom config in FormExtended class.</p>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="main-functions">Main functions</h2>
            <h3>General</h3>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="construct">construct</h3>
                <pre><code class="language-php">$form = new Form($form_ID, $layout = 'horizontal', $attr = '', $framework = 'bs4');</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Defines the layout (horizontal | vertical | inline).
    * Default is 'horizontal'
    * Clears values from session if self::clear has been called before
    * Catches posted errors
    * Adds hidden field with form ID
    * Sets elements wrappers
    *
    * @param string $form_ID   The ID of the form
    * @param string $layout    (Optional) Can be 'horizontal', 'vertical' or 'inline'
    * @param string $attr      (Optional) Can be any HTML input attribute or js event EXCEPT class
    *                          (class is defined in layout param).
    *                          attributes must be listed separated with commas.
    *                          Example : novalidate,onclick=alert(\'clicked\');
    * @param string $framework (Optional) bs3 | bs4 | material | foundation
    *                          (Bootstrap 3, Bootstrap 4, Material design, Foundation >= 6.4)
    * @return $this
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="setOptions">options</h3>
                <p>Call <code class="language-php">setOptions()</code> only if you change defaults options</p>
                <p>Go to <a href="#options-overview">Options</a> for more details</p>
                <pre><code class="language-php">$form->setOptions($options);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Sets form layout options to match your framework
    * @param array $user_options (Optional) An associative array containing the
    *                            options names as keys and values as data.
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="setMode">Mode (production vs. development)</h3>
                <p>Default mode is <code class="language-php">production</code>.</p>
                <pre><code class="language-php">$form->setMode($mode);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
     * set the form mode to 'development' or 'production'
     * in production mode, all the plugins dependencies are combined and compressed in a single css or js file.
     * the css | js files are saved in plugins/min/css and plugins/min/js folders.
     * these 2 folders have to be wrirable (chmod 0755+)
     * @param string $mode 'development' | 'production'
     * @return $this
     */</code></pre>
                <p>Detailed explanations available here: <a href="https://phpformbuilder.pro/documentation/jquery-plugins.php#optimization">Optimization (CSS & JS dependencies)</a></p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="setMethod">Method</h3>
                <p>Default method is <code class="language-php">POST</code>.</p>
                <p>Call <code class="language-php">setMethod()</code> only if you change default method</p>
                <pre><code class="language-php">$form->setMethod($method);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * set sending method
    * @param string $method POST|GET
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="setAction">Action</h3>
                <p>Default action is <code class="language-php">htmlspecialchars($_SERVER["PHP_SELF"])</code>.</p>
                <p><code class="language-php">htmlspecialchars</code> prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms (recommended on <a href="http://www.w3schools.com/php/php_form_validation.asp">http://www.w3schools.com/php/php_form_validation.asp</a>)</p>
                <p>Call <code class="language-php">setAction()</code> only if you change default action</p>
                <pre><code class="language-php">$form->setAction($url, [$add_get_vars = true]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Redefines form action
    *
    * @param boolean $add_get_vars (Optional) if $add_get_vars is set to false,
    *                              url vars will be removed from destination page.
    *                              Example: www.myUrl.php?var=value => www.myUrl.php
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="startFieldset">Start Fieldset</h3>
                <p>Start your fieldset with optional legend.<br>
                    Don't forget to call <code class="language-php">endFieldset</code> to end your fieldset.
                </p>
                <p>You can add several fieldsets on the same form.</p>
                <pre><code class="language-php">$form->startFieldset('legend', $fieldset_attr = '', $legend_attr = '');</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Starts a fieldset tag.
    * @param string $legend (Optional) Legend of the fieldset.
    * @param string $fieldset_attr (Optional) Fieldset attributes.
    * @param string $legend_attr (Optional) Legend attributes.
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="endFieldset">End Fieldset</h3>
                <pre><code class="language-php">$form->endFieldset();</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Ends a fieldset tag.
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="startDependentFields">startDependentFields</h3>
                <p>Start a dependent fields block.<br>
                    dependent fields block is hidden and will be shown if <code class="language-php">$parent_field</code> changes to one of <code class="language-php">$show_values</code>.<br>
                    Don't forget to call <code class="language-php">endDependentFields</code> to end your Dependent Fields block.
                </p>
                <p>if <code class="language-php">$inverse</code> is true, dependent fields will be shown if any other value than $show_values is selected</p>
                <p>Each Dependent fields block can include one or several dependent fields blocks.</p>
                <p class="alert alert-warning has-icon">Dependent fields MUST NOT START with the same fieldname as their parent field.</p>
                <pre><code class="language-php">$form->startDependentFields($parent_field, $show_values[, $inverse = false]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Start a hidden block
    * which can contain any element and html
    * Hiden block will be shown on $parent_field change
    * if $parent_field value matches one of $show_values
    * @param  string $parent_field name of the field which will trigger show/hide
    * @param  string $show_values  single value or comma separated values which will trigger show.
    * @param  boolean $inverse  if true, dependent fields will be shown if any other value than $show_values is selected.
    * @return void
    */</code></pre>
                <p>Live examples with code are available here: <a href="jquery-plugins.php#dependent-fields-example">jquery-plugins.php#dependent-fields-example</a></p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="endDependentFields">endDependentFields</h3>
                <pre><code class="language-php">$form->endDependentFields();</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Ends Dependent Fields block.
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="attr">$attr argument</h3>
                <p>Several element functions use a <code class="language-php">$attr</code> argument.</p>
                <p>The <code class="language-php">$attr</code> argument accepts <strong>any html attribute</strong> or <strong>javascript event</strong>.</p>
                <p>Use comma separated values (see examples below).</p>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Examples</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'name', '', 'Your name: ', 'id=my-id, placeholder=My Text, required=required');
    $form->addInput('password', 'pass', '', 'Your password: ', 'required=required, pattern=(.){7\,15}');
    $form->addTextarea('my-textarea', '', 'Your message: ', 'cols=30, rows=4');
    $form->addBtn('button', 'myBtnName', 1, 'Cancel', 'class=btn btn-danger, onclick=alert(\'cancelled\');');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="attr-form-example" action="class-doc.php#attr" method="post" class="form-horizontal">
                                <fieldset>
                                    <div class="form-group row justify-content-end">
                                        <label for="my-id" class="col-sm-4 col-form-label">
                                            Your name:  <sup class="text-danger">* </sup>
                                        </label>
                                        <div class="col-sm-8">
                                            <input id="my-id" name="name" type="text" value=""  placeholder="My Text" required="required" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <label for="pass" class="col-sm-4 col-form-label">
                                            Your password:  <sup class="text-danger">* </sup>
                                        </label>
                                        <div class="col-sm-8">
                                            <input id="pass" name="pass" type="password" value="" required="required" pattern="(.){7,15}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <label for="my-textarea" class="col-sm-4 col-form-label">
                                            Your message:
                                        </label>
                                        <div class="col-sm-8">
                                            <textarea id="my-textarea" name="my-textarea" cols="30" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <div class=" col-sm-8">
                                            <button type="button" name="myBtnName" value="1" class="btn btn-danger" onclick="alert('cancelled');">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <h3>Elements</h3>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addInput">Input</h3>
                <pre><code class="language-php">$form->addInput($type, $name [, $value = '', $label = '', $attr = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds input to the form
    *
    * @param string $type Accepts all input html5 types except checkbox and radio:
    *                      button, color, date, datetime, datetime-local,
    *                      email, file, hidden, image, month, number, password,
    *                      range, reset, search, submit, tel, text, time, url, week
    * @param string $name The input name
    * @param string $value (Optional) The input default value
    * @param string $label (Optional) The input label
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                                attributes must be listed separated with commas.
    *                                If you don't specify any ID as attr, the ID will be the name of the input.
    *                                Example: class=my-class,placeholder=My Text,onclick=alert(\'clicked\');
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="groupInputs">Input Groups</h3>
                <p>Input Groups allow to have several inputs / selects on the same line in horizontal forms.</p>
                <p>Up to 12 elements can be grouped.</p>
                <p><strong>2 ways to set arguments:</strong></p>
                <ul>
                    <li><pre class="line-numbers mb-4"><code class="language-php">    // 1st way: each fieldname as argument
    $form->groupInputs('street', 'zip', 'countries');</code></pre></li>
                    <li><pre class="line-numbers mb-4"><code class="language-php">    // 2nd way: a single array including all fieldnames as argument
    $fields = array('street', 'zip', 'countries');
    $form->groupInputs($fields);</code></pre></li>
                </ul>
                <p class="alert alert-warning has-icon">Always create your input group BEFORE creating the input elements.</p>
                <pre><code class="language-php">$form->groupInputs($input1, $input2 [, $input3 = '', $input4 = '', $input5 = '', $input6 = '', $input7 = '', $input8 = '', $input9 = '', $input10 = '', $input11 = '', $input12 = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Allows to group inputs in the same wrapper
    *
    * Arguments can be:
    *     -    a single array with fieldnames to group
    *     OR
    *     -    fieldnames given as string
    *
    * @param string|array $input1 The name of the first input of the group
    *                             OR
    *                             array including all fieldnames
    *
    * @param string $input2 The name of the second input of the group
    * @param string $input3 [optional] The name of the third input of the group
    * @param string $input4 [optional] The name of the fourth input of the group
    * @param string ...etc.
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Input Groups Example</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->startFieldset('Personal informations');
    $form->groupInputs('street', 'zip', 'countries');
    $form->setCols(3, 4);
    $form->addInput('text', 'street', '', 'Your address: ', 'placeholder=street,required=required');
    $form->setCols(0, 2);
    $form->addInput('text', 'zip', '', '', 'placeholder=zip code,required=required');
    $form->setCols(0, 3);
    $form->addOption('countries', '', 'Countries');
    $form->addOption('countries', 'United States', 'United States');
    $form->addOption('countries', 'Canada', 'Canada');
    $form->addOption('countries', 'France', 'France');
    $form->addSelect('countries', '', '');
    $form->endFieldset();</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="input-group-test" action="class-doc.php#groupInputs" method="post" class="form-horizontal">
                                <fieldset>
                                    <legend>
                                        Personal informations
                                    </legend>
                                    <div class="form-group row justify-content-end">
                                        <label for="street" class="col-sm-3 col-form-label">
                                            Your address:  <sup class="text-danger">* </sup>
                                        </label>
                                        <div class="col-sm-4">
                                            <input id="street" name="street" type="text" value="" placeholder="street" required="required" class="form-control">
                                        </div>
                                        <div class=" col-sm-2">
                                            <input id="zip" name="zip" type="text" value="" placeholder="zip code" required="required" class="form-control">
                                        </div>
                                        <div class=" col-sm-3">
                                            <select id="countries" name="countries"  class="form-control">
                                                <option value="" >
                                                    Countries
                                                </option>
                                                <option value="United States" >
                                                    United States
                                                </option>
                                                <option value="Canada" >
                                                    Canada
                                                </option>
                                                <option value="France" >
                                                    France
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addTextarea">Textarea</h3>
                <pre><code class="language-php">$form->addTextarea($name, $value [, $label, $attr]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds textarea to the form
    * @param string $name The textarea name
    * @param string $value (Optional) The textarea default value
    * @param string $label (Optional) The textarea label
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                                attributes must be listed separated with commas.
    *                                If you don't specify any ID as attr, the ID will be the name of the textarea.
    *                                Example: cols=30, rows=4;.
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addOption">Options for Select list</h3>
                <p class="alert alert-warning has-icon">Always add your options BEFORE creating the select element</p>
                <ol class="list-timeline">
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">1</span>
                        <span class="timeline-content">Add your options</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">2</span>
                        <span class="timeline-content">Create your select</span>
                    </li>
                </ol>
                <pre><code class="language-php">$form->addOption($selectName, $value, $txt [, $group_name, $attr]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds option to the $select_name element
    *
    * @param string $select_name The name of the select element
    * @param string $value The option value
    * @param string $txt The text that will be displayed
    * @param string $group_name (Optional) the optgroup name
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                                attributes must be listed separated with commas.
    *                                If you don't specify any ID as attr, the ID will be the name of the option.
    *                                Example: class=my-class
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addSelect">Select list</h3>
                <pre><code class="language-php">$form->addSelect($selectName, $label [, $attr = '', $displayGroupLabels = true]);</code></pre>
                <div class="alert alert-info has-icon mb-5">
                    <p><code class="language-php">addSelect()</code> function plays nice with <a href="jquery-plugins.php#bootstrap-select-example">bootstrap-select plugin</a> and <a href="jquery-plugins.php#select2-example">select2 plugin</a>.</p>
                    <p>Just add <span class="var-value">selectpicker</span> class for Bootstrap select or <span class="var-value">select2</span> class for Select2 plugin, data-attributes and phpformbuilder will do the job..</p>
                    <p class="mb-0">Don't forget to <a href="jquery-plugins.php#plugins-overview">activate your plugins</a> to add the required css/js files to your page.</p>
                </div>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds a select element
    *
    * IMPORTANT: Always add your options BEFORE creating the select element
    *
    * @param string $select_name The name of the select element
    * @param string $label (Optional) The select label
    * @param string $attr (Optional)  Can be any HTML input attribute or js event.
    *                                 attributes must be listed separated with commas.
    *                                 If you don't specify any ID as attr, the ID will be the name of the input.
    *                                 Example: class=my-class
    * @param string $displayGroupLabels (Optional) True or false.
    *                                              Default is true.
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example with optgroup</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addOption('select-with-groupnames', 'option-1', 'option 1', 'group 1');
    $form->addOption('select-with-groupnames', 'option-2', 'option 2', 'group 1', 'selected=selected');
    $form->addOption('select-with-groupnames', 'option-3', 'option 3', 'group 1');
    $form->addOption('select-with-groupnames', 'option-4', 'option 4', 'group 2');
    $form->addOption('select-with-groupnames', 'option-5', 'option 5', 'group 2');
    $form->addSelect('select-with-groupnames', 'Select please: ', '');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="select-test-2" action="class-doc.php#addSelect" method="post" class="form-horizontal">
                                <div class="form-group row justify-content-end">
                                    <label for="select-with-groupnames" class="col-sm-4 col-form-label">
                                        Select please:
                                    </label>
                                    <div class="col-sm-8">
                                        <select id="select-with-groupnames" name="select-with-groupnames"  class="form-control">
                                            <optgroup label="group 1">
                                                <option value="option-1" >
                                                    option 1
                                                </option>
                                                <option value="option-2" selected="selected">
                                                    option 2
                                                </option>
                                                <option value="option-3" >
                                                    option 3
                                                </option>
                                            </optgroup>
                                            <optgroup label="group 2">
                                                <option value="option-4" >
                                                    option 4
                                                </option>
                                                <option value="option-5" >
                                                    option 5
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example with multiple selections</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    for ($i=1; $i &lt; 11; $i++) {
        $form->addOption('myMultipleSelectName[]', $i, 'option ' . $i);
    }
    $form->addSelect('myMultipleSelectName[]', 'Select please:<br>(multiple selections)', 'multiple=multiple');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="select-test-2-form" action="class-doc.php#addSelect" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="myMultipleSelectName" class="col-sm-4 col-form-label">
                                        Select please:(multiple selections)
                                    </label>
                                    <div class="col-sm-8">
                                        <select id="myMultipleSelectName" name="myMultipleSelectName[]" multiple="multiple" class="form-control">
                                            <option value="1" >
                                                option 1
                                            </option>
                                            <option value="2" >
                                                option 2
                                            </option>
                                            <option value="3" >
                                                option 3
                                            </option>
                                            <option value="4" >
                                                option 4
                                            </option>
                                            <option value="5" >
                                                option 5
                                            </option>
                                            <option value="6" >
                                                option 6
                                            </option>
                                            <option value="7" >
                                                option 7
                                            </option>
                                            <option value="8" >
                                                option 8
                                            </option>
                                            <option value="9" >
                                                option 9
                                            </option>
                                            <option value="10" >
                                                option 10
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addCountrySelect">Country Select list</h3>
                <p class="alert alert-warning has-icon">Always add your options BEFORE creating the select element</p>
                <p class="alert alert-warning has-icon">Country Select uses the <a href="#bootstrap-select">bootstrap-select plugin</a>, which requires <a href="http://getbootstrap.com/javascript/#dropdowns">Bootstrap's dropdown</a> in your bootstrap.min.js</p>
                <pre><code class="language-php">$form->addCountrySelect($select_name [, $label = '', $attr = '', $user_options = array()]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * adds a country select list with flags
    * @param array  $select_name
    * @param string $label        (Optional) The select label
    * @param string $attr         (Optional)  Can be any HTML input attribute or js event.
    *                             attributes must be listed separated with commas.
    *                             If you don't specify any ID as attr, the ID will be the name of the input.
    *                             Example: class=my-class
    * @param array  $user_options (Optional):
    *                             lang          : MUST correspond to one subfolder of [PLUGINS_DIR]countries/country-list/country/cldr/
    *                             *** for example 'en', or 'fr_FR'              Default: 'en'
    *                             flags         : true or false.              Default: true
    *                             *** displays flags into option list
    *                             flag_size     : 16 or 32                    Default: 32
    *                             return_value  : 'name' or 'code'            Default: 'name'
    *                             *** type of the value that will be returned
    *                             show_tick     : true or false
    *                             *** shows a checkmark beside selected options Default: true
    *                             live_search   : true or false               Default: true
    */</code></pre>
                <p>Live examples with code are available here:<br>
                    <a href="jquery-plugins.php#bootstrap-select-example">jquery-plugins.php#bootstrap-select-example</a><br>
                    <a href="jquery-plugins.php#select2-example">jquery-plugins.php#select2-example</a>
                </p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addRadio">Radio Btns</h3>
                <ol>
                    <li>Add your radio buttons</li>
                    <li>Call printRadioGroup</li>
                </ol>
                <pre><code class="language-php">$form->addRadio($group_name, $label, $value [, $attr = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds radio button to $group_name element
    *
    * @param string $group_name The radio button groupname
    * @param string $label The radio button label
    * @param string $value The radio button value
    * @param string $attr  (Optional) Can be any HTML input attribute or js event.
    *                      attributes must be listed separated with commas.
    *                      Example: checked=checked
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="printRadioGroup">Print Radio Group</h3>
                <pre><code class="language-php">$form->printRadioGroup($group_name, $label [, $inline = true, $attr = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Prints radio buttons group.
    *
    * @param string $group_name The radio button group name
    * @param string $label (Optional) The radio buttons group label
    * @param string $inline (Optional) True or false.
    *                                  Default is true.
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                       attributes must be listed separated with commas.
    *                       If you don't specify any ID as attr, the ID will be the name of the input.
    *                       Example: class=my-class
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addRadio('myRadioBtnGroup', 'choice one', 'value 1');
    $form->addRadio('myRadioBtnGroup', 'choice two', 'value 2', 'checked=checked');
    $form->addRadio('myRadioBtnGroup', 'choice three', 'value 3');
    $form->printRadioGroup('myRadioBtnGroup', 'Choose one please', true, 'required=required');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="radio-test" action="class-doc.php#add-radio" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label required="required" class="main-label col-sm-4 col-form-label">
                                        Choose one please <sup class="text-danger">* </sup>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="myRadioBtnGroup_0" name="myRadioBtnGroup" value="value 1" required  class="form-check-input">
                                            <label for="myRadioBtnGroup_0"  class="form-check-label">
                                                choice one
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="myRadioBtnGroup_1" name="myRadioBtnGroup" value="value 2" required checked="checked" class="form-check-input">
                                            <label for="myRadioBtnGroup_1"  class="form-check-label">
                                                choice two
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="myRadioBtnGroup_2" name="myRadioBtnGroup" value="value 3" required  class="form-check-input">
                                            <label for="myRadioBtnGroup_2"  class="form-check-label">
                                                choice three
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <p>Several plugins are available to replace the ugly browser default radio buttons with nice ones:</p>
                <ul>
                    <li><a href="jquery-plugins.php#nice-check-example">Nice Check</a></li>
                    <li><a href="jquery-plugins.php#icheck-example">iCheck</a></li>
                    <li><a href="jquery-plugins.php#lcswitch-example">LcSwitch</a></li>
                </ul>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addCheckbox">Checkboxes</h3>
                <ol>
                    <li>Add your checkboxes</li>
                    <li>Call printCheckboxGroup</li>
                </ol>
                <pre><code class="language-php">$form->addCheckbox($group_name, $label, $value [, $attr = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds checkbox to $group_name
    *
    * @param string $group_name The checkbox groupname (will be converted to an array of indexed value)
    * @param string $label The checkbox label
    * @param string $value The checkbox value
    * @param string $attr  (Optional) Can be any HTML input attribute or js event.
    *                      attributes must be listed separated with commas.
    *                      Example: checked=checked
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="printCheckboxGroup">Print Checkbox Group</h3>
                <pre><code class="language-php">$form->printCheckboxGroup($group_name, $label [, $inline = true, $attr = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Prints checkbox group.
    *
    * @param string $var (Optional) description
    *
    * @param string $group_name The checkbox button group name
    * @param string $label (Optional) The checkbox group label
    * @param string $inline (Optional) True or false.
    *                                  Default is true.
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                       attributes must be listed separated with commas.
    *                       If you don't specify any ID as attr, the ID will be the name of the input.
    *                       Example: class=my-class
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addCheckbox('myCheckboxGroup', 'choice one', 'value 1');
    $form->addCheckbox('myCheckboxGroup', 'choice two', 'value 2', 'checked=checked');
    $form->addCheckbox('myCheckboxGroup', 'choice three', 'value 3', 'checked=checked');
    $form->printCheckboxGroup('myCheckboxGroup', 'Check please: ', true, 'required=required');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="checkbox-test" action="" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label required="required" class="main-label col-sm-4 col-form-label">
                                        Check please:  <sup class="text-danger">* </sup>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="myCheckboxGroup_0" name="myCheckboxGroup[]" value="value 1"  class="form-check-input">
                                            <label for="myCheckboxGroup_0" class="form-check-label">
                                                choice one
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="myCheckboxGroup_1" name="myCheckboxGroup[]" value="value 2" checked="checked" class="form-check-input">
                                            <label for="myCheckboxGroup_1" class="form-check-label">
                                                choice two
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="myCheckboxGroup_2" name="myCheckboxGroup[]" value="value 3" checked="checked" class="form-check-input">
                                            <label for="myCheckboxGroup_2" class="form-check-label">
                                                choice three
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <p>Several plugins are available to replace the ugly browser default checkboxes with nice ones:</p>
                <ul>
                    <li><a href="jquery-plugins.php#nice-check-example">Nice Check</a></li>
                    <li><a href="jquery-plugins.php#icheck-example">iCheck</a></li>
                    <li><a href="jquery-plugins.php#lcswitch-example">LcSwitch</a></li>
                </ul>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addBtn">Buttons</h3>
                <p>For a <strong>single button</strong>, just call <code class="language-php">addBtn()</code> and let <span class="var-value">$btnGroupName</span> empty.</p>
                <p>For <strong>button group</strong>, call <code class="language-php">addBtn()</code> for each button, give a name to <span class="var-value">$btnGroupName</span>, then call <code class="language-php">printBtnGroup()</code></p>
                <pre><code class="language-php">$form->addBtn($type, $name, $value, $text [, $attr = '', $btnGroupName = '']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds button to the form
    *
    * If $btnGroupName is empty, the button will be automaticaly displayed.
    * Otherwise, you'll have to call printBtnGroup to display your btnGroup.
    *
    * @param string $type The html button type
    * @param string $name The button name
    * @param string $value The button value
    * @param string $text The button text
    * @param string $attr (Optional) Can be any HTML input attribute or js event.
    *                                 attributes must be listed separated with commas.
    *                                 If you don't specify any ID as attr, the ID will be the name of the input.
    *                                 Example: class=my-class,onclick=alert(\'clicked\');
    * @param string $btnGroupName (Optional) If you want to group several buttons, group them then call printBtnGroup.
    *
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="printBtnGroup">Print Btn Group</h3>
                <pre><code class="language-php">$form->printBtnGroup($btnGroupName);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Prints buttons group.
    *
    * @param string $btnGroupName The buttons group name
    * @param string $label (Optional) The buttons group label
    *
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Single button example</h4>
                        <div class="code-example">
                            <pre><code class="language-php">$form->addBtn('submit', 'myBtnName', 1, 'Submit form', 'class=btn btn-primary');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <div class="form-group row justify-content-end">
                                <div class=" col-sm-8">
                                    <button type="submit" name="myBtnName" value="1" class="btn btn-primary">
                                        Submit form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Button group example</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addBtn('submit', 'mySubmitBtnName', 1, 'Submit form', 'class=btn btn-primary', 'myBtnGroup');
    $form->addBtn('button', 'myCancelBtnName', 0, 'Cancel', 'class=btn btn-danger, onclick=alert(\'cancelled\');', 'myBtnGroup');
    $form->printBtnGroup('myBtnGroup');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <div class="form-group row justify-content-end">
                                <div class=" col-sm-8">
                                    <div class="btn-group">
                                        <button type="submit" name="mySubmitBtnName" value="1" class="btn btn-primary">
                                            Submit form
                                        </button>
                                        <button type="button" name="myCancelBtnName" value="0" class="btn btn-danger" onclick="alert('cancelled');">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addHtml">Custom HTML</h3>
                <p>You can add some html code at any place you want when creating your form.</p>
                <p>This way, you can:</p>
                <ul>
                    <li><a href="#html-between-elements">Add HTML between elements</a></li>
                    <li><a href="#html-prepend-append">Prepend or append HTML to elements</a></li>
                    <li><a href="#addInputWrapper">Wrap elements with tags</a></li>
                </ul>
                <pre><code class="language-php">$form->addHtml($html [, $element_name = '', $pos = 'after']);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Adds HTML code at any place of the form
    *
    * @param string $html The html code to add.
    * @param string $element_name (Optional) If not empty, the html code will be inserted.
    *                                        just before or after the element.
    * @param string $pos (Optional) If $element_name is not empty, defines the position
    *                               of the inserted html code.
    *                               Values can be 'before' or 'after'.
    */</code></pre>
                <p class="alert alert-warning has-icon">When your HTML is linked to an element, always call <code class="language-php">addHtml()</code> BEFORE creating the element</p>
                <div class="alert alert-info has-icon">
                    <p>To add helper texts icons buttons or any input group addon it'll be even better to use the shortcut functions:</p>
                    <ul>
                        <li><a href="class-doc.php#add-helper">Add Helper</a></li>
                        <li><a href="class-doc.php#add-addon">Add Addon</a></li>
                        <li><a href="class-doc.php#add-icon">Add Icon</a></li>
                    </ul>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2" id="html-between-elements">Add HTML between elements</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'input-name', '', 'Your name: ');
    $form->addHtml('&lt;p class="alert alert-danger"&gt;Your e-mail address is required&lt;/p&gt;');
    $form->addInput('text', 'email', '', 'Your e-mail', 'required');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="html-test" action="class-doc.php#addHtml" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="input-name" class="col-sm-4 col-form-label">
                                        Your name:
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="input-name" name="input-name" type="text" value=""  class="form-control">
                                    </div>
                                </div>
                                <p class="alert alert-danger">
                                    Your e-mail address is required
                                </p>
                                <div class="form-group row justify-content-end">
                                    <label for="email" class="col-sm-4 col-form-label">
                                        Your e-mail <sup class="text-danger">* </sup>
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="email" name="email" type="text" value="" required class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2" id="html-prepend-append">Prepend or append HTML to elements</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'input-name-2', '', 'Your name: ');
    $form->addHtml('&lt;p class="form-text alert alert-danger"&gt;Your e-mail address is required&lt;/p&gt;', 'email-2', 'after');
    $form->addInput('text', 'email-2', '', 'Your e-mail', 'required');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="custom-html-test" action="" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="input-name-2" class="col-sm-4 col-form-label">
                                        Your name:
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="input-name-2" name="input-name-2" type="text" value=""  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-end">
                                    <label for="email-2" class="col-sm-4 col-form-label">
                                        Your e-mail <sup class="text-danger">* </sup>
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="email-2" name="email-2" type="text" value="" required class="form-control">
                                        <p class="form-text alert alert-danger">
                                            Your e-mail address is required
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="addInputWrapper">Custom html with input wrapper</h3>
                <p class="alert alert-warning has-icon">wrapper can be one or two html elements</p>
                <pre><code class="language-php">$form->addInputWrapper($html, $element_name);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Wraps the element with html code.
    *
    * @param string $html The html code to wrap the element with.
    *                     The html tag must be opened and closed.
    *                     Example: &lt;div class=&quot;my-class&quot;&gt;&lt;/div&gt;
    * @param string $element_name The form element to wrap.
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInputWrapper('&lt;div class="bg-dark rounded p-2"&gt;&lt;div class="bg-white rounded p-2"&gt;&lt;/div&gt;&lt;/div&gt;', 'imput-wrapped');
    $form->addInput('text', 'imput-wrapped', '', 'Input wrapped with custom divs');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="addInputWrapper-test" action="class-doc.php#addInputWrapper" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="imput-wrapped" class="col-sm-4 col-form-label">
                                        Input wrapped with custom divs
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="bg-dark rounded p-2">
                                            <div class="bg-white rounded p-2">
                                                <input id="imput-wrapped" name="imput-wrapped" type="text" value=""  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="render">Render</h3>
                <p>Renders the form.</p>
                <p>Set <code class="language-php">$debug</code> to <code class="language-php">true</code> if you wants to display HTML code</p>
                <p>Set <code class="language-php">$display</code> to <code class="language-php">false</code> if you wants to return HTML code but not display on page</p>
                <pre><code class="language-php">$form->render([$debug = false, $display = true]);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Renders the html code of the form.
    *
    * @param boolean $debug   (Optional) True or false.
    *                         If true, the html code will be displayed
    * @param boolean $display (Optional) True or false.
    *                         If false, the html code will be returned but not displayed.
    *
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="ajax-loading">Ajax loading</h3>
                <p>PHP Form Builder allows you to load your forms with Ajax.</p>
                <p>Loading in Ajax allows to:</p>
                <ul>
                    <li class="mb-3">integrate your forms in any html page</li>
                    <li class="mb-3">load the forms asynchronously, which is good for your page loading speed</li>
                </ul>
                <p class="h4">To load your form with Ajax:</p>
                <ol class="list-timeline">
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">1</span>
                        <span class="timeline-content">
                            Create your form using the built-in PHP functions and save it in a php file somewhere on your server.<br>Set the <code class="language-php">ajax</code> option to <code class="language-php">true</code> to enable Ajax loading.<br>Here's a sample code:
                            <pre class="line-numbers mb-4"><code class="language-php">&lt;?php

use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

$form_id = 'my-form';

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken($form_id) === true) {
    // do stuff
}

/* ==================================================
    The Form
================================================== */

$form = new Form($form_id, 'horizontal', 'data-fv-no-icon=true, novalidate');
// $form->setMode('development');

// enable Ajax loading
$form->setOptions(['ajax' => true]);

// add your fields & plugins here

// render the form
$form->render();
</code></pre>
                        </span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">2</span>
                        <span class="timeline-content">
                            In your main file (html):<br>Create a div with a specific id, for instance: <pre class="line-numbers mb-4"><code class="language-php">&lt;div id=&quot;ajax-form&quot;&gt;&lt;/div&gt;</code></pre>
                        </span>
                    </li>
                    <li class="d-flex align-items-start">
                        <span class="badge bg-yellow-300 text-yellow-600 badge-circle">3</span>
                        <span class="timeline-content">
                            In your main file (html):<br>
                            Add the Javascript code to load your form: <pre class="line-numbers mb-4"><code class="language-html"><!-- Ajax form loader -->

    &lt;script&gt;
    var $head= document.getElementsByTagName('head')[0],
        target = '#ajax-form'; // replace with the id of your div

    var loadData = function(data, index) {
        if (index <= $(data).length) {
            var that = $(data).get(index);
            if ($(that).is('script')) {
                // output script
                var script = document.createElement('script');
                script.type = 'text/javascript';
                if (that.src != '') {
                    script.src = that.src;
                    script.onload = function() {
                        loadData(data, index + 1);
                    };
                    $head.append(script);
                } else {
                    script.text = that.text;
                    $('body').append(script);
                    loadData(data, index + 1);
                }
            } else {
                // output form html
                $(target).append($(that));
                loadData(data, index + 1);
            }
        } else {
            $.holdReady(false);
        }
    };

    $(document).ready(function() {
        $.ajax({
            url: 'ajax-forms/contact-form-1.php', // replace with the url of your php form
            type: 'GET'
        }).done(function(data) {
            $.holdReady(true);
            loadData(data, 0);
        }).fail(function(data, statut, error) {
            console.log(error);
        });
    });
    &lt;/script&gt;</code></pre>
                        </span>
                    </li>
                </ol>
                <p>You'll find an example here: <a href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/ajax-loaded-contact-form-1.html">https://www.phpformbuilder.pro/templates/bootstrap-4-forms/ajax-loaded-contact-form-1.html</a></p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="useLoadJs">useLoadJs</h3>
                <p>Use the great LoadJs library to load CSS & Javascript plugins dependencies.</p>
                <p>This feature is great for optimization ; it requires to include the <a href="https://github.com/muicss/loadjs">LoadJs Javascript library</a> in your page</p>
                <p>Details &amp; sample codes here: <a href="jquery-plugins.php#optimization-with-loadjs">jquery-plugins.php#optimization-with-loadjs</a></p>
                <pre><code class="language-php">$form->useLoadJs($bundle = '');</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * load scripts with loadJS
    * https://github.com/muicss/loadjs
    * @param  string $bundle   optional loadjs bundle name to wait for
    * @return void
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="printIncludes">Print plugins includes</h3>
                <p>The <code class="language-php">printIncludes()</code> function is used to insert the CSS & Javascript files required by each plugin used in your form.</p>
                <p>Call <code class="language-php">printIncludes()</code> at the right places (generally css inside your <code class="language-php">&lt;head&gt;&lt;/head&gt;</code> section, and js just before <code class="language-php">&lt;/body&gt;</code>.</p>
                <p class="alert alert-warning has-icon">If your form contains no plugin, no need to call this function.</p>
                <pre><code class="language-php">printIncludes($type, $debug = false, $display = true, $combine_and_compress = true);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Prints html code to include css or js dependancies required by plugins.
    * i.e.:
    *     &lt;link rel=&quot;stylesheet&quot; ... /&gt;
    *     &lt;script src=&quot;...&quot;&gt;&lt;/script&gt;
    *
    * @param string  $type                 value : 'css' or 'js'
    * @param boolean $debug                (Optional) True or false.
    *                                      If true, the html code will be displayed
    * @param boolean $display              (Optional) True or false.
    *                                      If false, the html code will be returned but not displayed.
    * @param boolean $combine_and_compress (Optional) True or false.
    *                                      If true, dependancies are combined and compressed into plugins/min/ folder.
    * @return $this
    */</code></pre>
                <h4 class="mb-2">About optimization</h4>
                <p><strong>PHP Form Builder is conceived for maximum optimization and extremely fast loading time.</strong></p>
                <p>Detailed explanations available here: <a href="https://www.phpformbuilder.pro/documentation/jquery-plugins.php#optimization">Optimization (CSS & JS dependencies)</a></p>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example with colorpicker plugin</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'my-colorpicker', '', 'ColorPicker: ');
    $form->addPlugin('colorpicker', '#my-colorpicker');

    // call this just before &lt;/head&gt;
    $form->printIncludes('css');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <pre class="line-numbers mb-4"><code class="language-php">&lt;link href=&quot;../../phpformbuilder/plugins/colpick/css/colpick.css&quot; rel=&quot;stylesheet&quot; media=&quot;screen&quot;&gt;</code></pre>
                        </div>
                        <hr>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'my-colorpicker', '', 'ColorPicker: ');
    $form->addPlugin('colorpicker', '#my-colorpicker');

    // call this just before &lt;/body&gt;
    $form->printIncludes('js');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <pre class="line-numbers mb-4"><code class="language-php">&lt;script src=&quot;../../phpformbuilder/plugins/colpick/js/colpick.js&quot;&gt;&lt;/script&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="printJsCode">Print plugins JS code</h3>
                <p>Prints the JS code generated by the plugin.</p>
                <p class="alert alert-warning has-icon">If your form contains no plugin, no need to call this function.</p>
                <pre><code class="language-php">$form->printJsCode($debug = false);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Prints js code generated by plugins.
    * @param boolean $debug   (Optional) True or false.
    *                         If true, the html code will be displayed
    * @param boolean $display (Optional) True or false.
    *                         If false, the html code will be returned but not displayed.
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example with colorpicker plugin</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('text', 'my-colorpicker', '', 'ColorPicker: ');
    $form->addPlugin('colorpicker', '#my-colorpicker');
    $form->printJsCode();</code></pre>
                        </div>
                        <div class="output pt-5">
                            <pre class="line-numbers mb-4"><code class="language-php">    &lt;script type=&quot;text/javascript&quot;&gt;
        $(document).ready(function() {
            $(&quot;#my-colorpicker&quot;).colpick({
                onSubmit:function(hsb,hex,rgb,el) {
                    $(el).val(&#039;#&#039;+hex);
                    $(el).colpickHide();
                }
            });
        });
    &lt;/script&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="set-cols">Set Cols</h3>
                <p>The <code class="language-php">setCols()</code> function wraps label and fields with columns.</p>
                <p>The columns can only be set in horizontal forms.</p>
                <pre><code class="language-php">$form->setCols($labelsCols, $fieldsCols [, $breakpoint = 'sm']);</code></pre>
                <p class="alert alert-info has-icon"><strong>Bootstrap 4 auto column</strong><br>Bootstrap 4 allows automatic-width columns.<br>To build automatic-width columns, set <span class="var-value">$fieldsCols</span> to <span class="var-value">-1</span></p>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Shortcut for
    * $options = array(
    *        'horizontalLabelCol'       => 'col-' . $breakpoint . '-' . $labelsCols,
    *        'horizontalOffsetCol'      => 'col-' . $breakpoint . '-offset-' . $labelsCols,
    *        'horizontalElementCol'     => 'col-' . $breakpoint . '-' . $fieldsCols,
    * );
    * $form->setOptions($options);
    *
    * @param number $labelsCols number of columns for label
    * @param number $fieldsCols number of columns for fields
    * @param string $breakpoint Bootstrap's breakpoints: xs | sm | md |lg
    *
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre><code class="language-php">$form->setCols(3, 9);
$form->addInput('text', 'username', '', 'Name');</code></pre>
                        </div>
                        <div class="output pt-5">
                            Will generate the following markup:
                            <pre class="line-numbers mb-4"><code class="language-php">    &lt;div class="form-group row justify-content-end"&gt;
        &lt;label for="username" class="col-sm-3 col-form-label"&gt;
            Name
        &lt;/label&gt;
        &lt;div class="col-sm-9"&gt;
            &lt;input id="username" name="username" type="text" value=""  class="form-control"&gt;
        &lt;/div&gt;
    &lt;/div&gt;</code></pre>
                            Equivalent to:
                            <pre class="line-numbers mb-4"><code class="language-php">    $options = array(
        'horizontalLabelCol'       => 'col-sm-3',
        'horizontalElementCol'     => 'col-sm-9'
    );
    $form->setOptions($options);
    $form->addInput('text', 'username', '', 'Name');</code></pre>
                        </div>
                    </div>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Bootstrap 4 automatic-width example</h4>
                        <div class="code-example">
                            <pre><code class="language-php">    $form->setCols(-1, -1, 'sm');
    $form->groupInputs('user-name', 'user-first-name');
    $form->addInput('text', 'user-name', '', 'Name', 'required, placeholder=Name');
    $form->addInput('text', 'user-first-name', '', 'First name', 'required, placeholder=First Name');

    $form->setCols(-1, -1); // without breakpoint
    $form->addIcon('user-email', '&lt;i class=&quot;fa fa-envelope&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;', 'before');
    $form->addInput('email', 'user-email', '', '', 'required, placeholder=Email');</code></pre>
                        </div>
                        <div class="output pt-5">
                            Will generate the following markup:
                            <pre class="line-numbers mb-4"><code class="language-php">    &lt;div class=&quot;form-group row justify-content-end&quot;&gt;
        &lt;label for=&quot;user-name&quot; class=&quot;col-sm col-form-label&quot;&gt;
            Name &lt;sup class=&quot;text-danger&quot;&gt;* &lt;/sup&gt;
        &lt;/label&gt;
        &lt;div class=&quot;col-sm&quot;&gt;
            &lt;input id=&quot;user-name&quot; name=&quot;user-name&quot; type=&quot;text&quot; value=&quot;&quot; required placeholder=&quot;Name&quot; class=&quot;form-control fv-group&quot;&gt;
        &lt;/div&gt;
        &lt;label for=&quot;user-first-name&quot; class=&quot;col-sm col-form-label&quot;&gt;
            First name &lt;sup class=&quot;text-danger&quot;&gt;* &lt;/sup&gt;
        &lt;/label&gt;
        &lt;div class=&quot;col-sm&quot;&gt;
            &lt;input id=&quot;user-first-name&quot; name=&quot;user-first-name&quot; type=&quot;text&quot; value=&quot;&quot; required placeholder=&quot;First Name&quot; class=&quot;form-control fv-group&quot;&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;form-group row justify-content-end&quot;&gt;
        &lt;div class=&quot; col-sm&quot;&gt;
            &lt;div class=&quot;input-group&quot;&gt;
                &lt;div class=&quot;input-group-prepend&quot;&gt;
                    &lt;span class=&quot;input-group-text&quot;&gt;&lt;i class=&quot;fa fa-envelope&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;input id=&quot;user-email&quot; name=&quot;user-email&quot; type=&quot;email&quot; value=&quot;&quot; required placeholder=&quot;Email&quot; class=&quot;form-control&quot;&gt;
    &lt;/div&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="add-helper">Add Helper</h3>
                <p>Adds helper text after the chosen field</p>
                <pre><code class="language-php">$form->addHelper($helper_text, $element_name);</code></pre>
                <p class="alert alert-warning has-icon"><code class="language-php">addHelper()</code> MUST always be called BEFORE creating the element
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Shortcut to add element helper text
    *
    * @param string $helper_text    The helper text or html to add.
    * @param string $element_name   the helper text will be inserted just after the element.
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre><code class="language-php">    $form->addHelper('Enter your last name', 'last-name');
    $form->addInput('text', 'last-name', '', 'Last name', 'required');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="add-helper-form" action="" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="last-name" class="col-sm-4 col-form-label">
                                        Last name <sup class="text-danger">* </sup>
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="last-name" name="last-name" type="text" value="" required class="form-control">
                                        <small class="form-text text-muted">Enter your last name</small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="add-addon">Add Addon</h3>
                <p>Adds button or text addon before or after the chosen field</p>
                <pre><code class="language-php">$form->addAddon($input_name, $addon_html, $pos);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * shortcut to prepend or append button or text addon to an input
    * @param string $input_name the name of target input
    * @param string $addon_html  button or text addon html code
    * @param string $pos        before | after
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre><code class="language-php">    $addon = '&lt;button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-after\').val(\'\');"&gt;cancel&lt;/button&gt;';
    $form->addAddon('input-with-button-after', $addon, 'after');
    $form->addInput('text', 'input-with-button-after', '', 'Your name');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="add-addon-form" action="" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="input-with-button-after" class="col-sm-4 col-form-label">
                                        Your name
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="input-with-button-after" name="input-with-button-after" type="text" value=""  class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="$('#input-with-button-after').val('');">
                                                    cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="add-icon">Add Icon</h3>
                <p>Adds an icon before or after the chosen field</p>
                <pre><code class="language-php">$form->addIcon($input_name, $icon_html, $pos);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * shortcut to prepend or append icon to an input
    * @param string $input_name the name of target input
    * @param string $icon_html  icon html code
    * @param string $pos        before | after
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre><code class="language-php">    $form->addIcon('username', '&lt;i class="fa fa-user" aria-hidden="true"&gt;&lt;/i&gt;', 'before');
    $form->addInput('text', 'username', '', 'Name');</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="add-icon-form" action="" method="post" class="form-horizontal" >
                                <div class="form-group row justify-content-end">
                                    <label for="username" class="col-sm-4 col-form-label">
                                        Name
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            </div>
                                            <input id="username" name="username" type="text" value=""  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="center-buttons">centerButtons</h3>
                <p>Center buttons inside their wrapper</p>
                <pre><code class="language-php">$form->centerButtons($center);</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * @param  boolean $center
    */</code></pre>
                <div class="card mb-6">
                    <div class="card-body">
                        <p class="h4 mb-2">Example</p>
                        <div class="code-example">
                            <pre><code class="language-php">    $form-&gt;centerButtons(true);
    $form-&gt;addBtn(&#039;submit&#039;, &#039;submit-btn&#039;, 1, &#039;Submit&#039;, &#039;class=btn btn-success&#039;);</code></pre>
                        </div>
                        <div class="output pt-5">
                            <form id="center-buttons-form" action="" method="post" class="form-horizontal" >
                                <div class="form-group text-center">
                                    <div class=" col-sm-12">
                                        <button type="submit" name="submit-btn" value="1" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="mainFunctionsSendMail">E-mail Sending</h2>
                <h3>sendMail() function</h3>
                <pre class="mb-4"><code class="language-php">$sent_message = Form::send($options, $smtp_settings = array());</code></pre>
                <p>See details at <a href="#sendMail">E-mail Sending</a></p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="global-registration-process">Registering / Clearing values</h2>
                <h3>Global registration process</h3>
                <p>PHP Form Builder manages the memorization of fields and posted values without you needing to take any action.</p>
                <p>If your form is posted with errors (validation fails), the posted values are automatically displayed in the corresponding fields.</p>
                <p>To <strong>set the default value of a field</strong>, it must be saved in the PHP session in this way:</p>
                <pre><code class="language-php">$_SESSION['form-id']['field-name'] = 'my-value';</code></pre>
                <p class="mb-6">If the form is posted, the field will have the posted value. Otherwise it will have the default value registered in the PHP session.</p>
                <h4>Here's the global workflow:</h4>
                <ol class="numbered">
                    <li>You create your form and add fields.<br>
                        PHP Form Builder registers each field name in PHP session: <code class="language-php">$_SESSION['form-id']['fields'][] = 'field-name';</code>
                    </li>
                    <li>You post the form</li>
                    <li>You validate the posted values: <code class="language-php">$validator = Form::validate('form-id');</code></li>
                    <li>If the validation fails:<br>
                        The error messages are stored in PHP session: <code class="language-php">$_SESSION['errors'][$form_ID] as $field => $message</code>
                    </li>
                    <li>You instanciate your form again:<br>
                        PHP Form Builder registers the posted values in PHP session: <code class="language-php">$_SESSION['form-id']['field-name'] = $_POST['my-value'];</code><br>
                        PHP Form Builder gets and displays the session value and the possible error for each field.</li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="registerValues">registerValues (static function)</h3>
                <p class="alert alert-info has-icon">When you instantiate a form, it automatically stores corresponding posted values in session unless you called <a href="#clear">clear function</a> before creating your form.<br><br>Values are registered this way: <span class="var-value">$_SESSION['form-id']['field-name']</span></p>
                <p>You can call <code class="language-php">Form::registerValues('form-id')</code> manually at any time.</p>
                <pre><code class="language-php">Form::registerValues('form-id');</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * register all posted values in session
    * @param string $form_ID
    *
    * ex: $_SESSION['form-id']['field-name'] = $_POST['field-name'];
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="mergeValues">mergeValues (static function)</h3>
                <p class="alert alert-info has-icon">mergeValues is used to merge previously registered values in a single array.<br>Usefull for step forms to send all steps values by email or store into database for example.</span></p>
                <pre><code class="language-php">Form::mergeValues(array('step-form-1', 'step-form-2', 'step-form-3'));</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * merge previously registered session vars => values of each registered form
    * @param  array $forms_array array of forms IDs to merge
    * @return array pairs of names => values
    *                           ex: $values[$field_name] = $value
    */</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="clear">clear (static function)</h3>
                <p>Clears the corresponding previously registered values from session.</p>
                <pre><code class="language-php">Form::clear('form-id');</code></pre>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="validation-overview">Validation</h2>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="validation-overview">Overview</h3>
                <p>PHP Form Builder comes with <strong>2 distinct validation systems</strong>.</p>
                <ol>
                    <li><strong>PHP Validation</strong><br>Form is validated after being posted. This is a php validation, essential for security.</li>
                    <li><strong>jQuery Validation</strong><br>Fields are validated on the fly, for better User Experience.</li>
                </ol>
                <p class="alert alert-info has-icon">Never forget: The only way to avoid security issues is <strong>PHP Validation</strong>.<br>Users can easily disable Javascript, and get around jQuery validation.</p>
            </article>
            <h3 id="php-validation-basics">PHP Validation</h3>
            <article class="pb-5 mb-7 has-separator">
                <h3>Basics</h3>
                <p><strong>To create a new validator object and auto-validate required fields, use this standard-code</strong><br><small>(replace 'form-id' with your form ID)</small></p>
                <pre class="line-numbers mb-4"><code class="language-php">    /* =============================================
    validation if posted
    ============================================= */

    if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('form-id') === true) {

        // create validator & auto-validate required fields
        $validator = Form::validate('form-id');

        // additional validation
        $validator->maxLength(100)->validate('message');
        $validator->email()->validate('user-email');

        // check for errors
        if ($validator->hasErrors()) {
        $_SESSION['errors']['form-id'] = $validator->getAllErrors();
        } else {
            // validation passed, you can send email or do anything
        }
    }</code></pre>
                <dl class="dl-horizontal">
                    <dt><pre><code class="language-php">$validator = Form::validate('form-id');</code></pre></dt>
                    <dd>This loads Validator class, creates a new Validator object and validate required fields if any.<br><strong>Required fields validation is automatic</strong>, nothing more to do.</dd>
                    <dd class="line-break"></dd>
                    <dt><pre><code class="language-php">    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('user-email');</code></pre>
                    <dd>Then we use $validator native methods for others validations<br>(email, date, length, ...)</dd>
                    <dd class="line-break"></dd>
                    <dt><pre><code class="language-php">    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['form-id'] = $validator->getAllErrors();
    }</code></pre></dt>
                    <dd>If any error, we register them in session.<br>Error messages will be automatically displayed in form.</dd>
                    <dd class="line-break"></dd>
                </dl>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="dependent-fields-validation">Dependent fields validation</h3>
                <p>Dependent fields validation is something really magic.</p>
                <p><strong><code class="language-php">Form::validate()</code> validates the required dependent fields only if their parent field value matches the condition to display them</strong>.</p>
                <p>If you use additional validators, for example <code class="language-php">$validator->email()->validate('user-email');</code> you have to test if the field has to be validated or not according to your dependent fields conditions:</p>
                <pre class="line-numbers mb-4"><code class="language-php">    if ($_POST['parent-field'] == 'value') {
        $validator->email()->validate('user-email');
    }</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="php-validation-methods">Php Validator Methods</h3>
                <div class="alert alert-info has-icon">
                    <p>To validate array, use the <strong>dot syntax</strong>.<br><br>Example: <code class="language-php">&lt;select name=&quot;my-field[]&quot; multiple=&quot;multiple&quot;&gt;</code></p>
                    <pre class="line-numbers mb-4"><code class="language-php">    $validator->required()->validate('my-field.0');

    /* if at least 2 values must be selected: */

    $validator->required()->validate(array('my-field.0', 'my-field.1'));</code></pre>
                </div>
                <p>The validation is done with <a href="https://github.com/blackbelt/php-validation">blackbelt's php-validation class</a>.</p>
                <p>Complete documentation at <a href="https://github.com/blackbelt/php-validation">https://github.com/blackbelt/php-validation</a>.</p>
                <p>I just added these features:</p>
                <ul>
                    <li>Captcha validation support for the <a href="#captcha-example">included captcha plugin</a></li>
                    <li><a href="#php-validation-multilanguage">Multilanguage support</a></li>
                    <li>
                        Patterns validation for the <a href="#passfield-example">included passfield plugin</a>:
                        <ul>
                            <li>$validator->hasLowercase()->validate($field_name);</li>
                            <li>$validator->hasUppercase()->validate($field_name);</li>
                            <li>$validator->hasNumber()->validate($field_name);</li>
                            <li>$validator->hasSymbol()->validate($field_name);</li>
                            <li>$validator->hasPattern('/custom_regex/')->validate($field_name);</li>
                        </ul>
                    </li>
                </ul>
                <h3>Available methods: </h3>

                <dl class="dl-horizontal">
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">captcha(<em>$field, $message = null</em>)</code>
                    </dt>
                    <dd>Added to validate included captcha plugin.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">recaptcha(<em>$secret_key, $message = null</em>)</code>
                    </dt>
                    <dd>Added to validate included recaptcha plugin.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">required(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value is required.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">email(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value must be a valid email address string.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">float(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value must be a float.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">integer(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value must be an integer.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">digits(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value must be a digit (integer with no upper bounds).</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">min(<em>$limit, $include = TRUE, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be greater than $limit (numeric). $include defines if the value can be equal to the limit.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">max(<em>$limit, $include = TRUE, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be less than $limit (numeric). $include defines if the value can be equal to the limit.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">between(<em>$min, $max, $include = TRUE, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be between $min and $max (numeric). $include defines if the value can be equal to $min and $max.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">minLength(<em>$length, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be greater than or equal to $length characters.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">maxLength(<em>$length, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be less than or equal to $length characters.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">length(<em>$length, $message = null</em>)</code>
                    </dt>
                    <dd>The field must be $length characters long.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">matches(<em>$field, $label, $message = null</em>)</code>
                    </dt>
                    <dd>One field matches another one (i.e. password matching)</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">notMatches(<em>$field, $label, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must not match the value of $field.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">startsWith(<em>$sub, $message = null</em>)</code>
                    </dt>
                    <dd>The field must start with $sub as a string.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">notStartsWith(<em>$sub, $message = null</em>)</code>
                    </dt>
                    <dd>The field must not start with $sub as a string.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">endsWith(<em>$sub, $message = null</em>)</code>
                    </dt>
                    <dd>THe field must end with $sub as a string.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">notEndsWith(<em>$sub, $message = null</em>)</code>
                    </dt>
                    <dd>The field must not end with $sub as a string.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">ip(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value is a valid IP, determined using filter_var.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">url(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value is a valid URL, determined using filter_var.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">date(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value is a valid date, can be of any format accepted by DateTime()</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">minDate(<em>$date, $format, $message = null</em>)</code>
                    </dt>
                    <dd>The date must be greater than $date. $format must be of a format on the page <a href="http://php.net/manual/en/datetime.createfromformat.php">http://php.net/manual/en/datetime.createfromformat.php</a></dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">maxDate(<em>$date, $format, $message = null</em>)</code>
                    </dt>
                    <dd>The date must be less than $date. $format must be of a format on the page <a href="http://php.net/manual/en/datetime.createfromformat.php">http://php.net/manual/en/datetime.createfromformat.php</a></dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">ccnum(<em>$message = null</em>)</code>
                    </dt>
                    <dd>The field value must be a valid credit card number.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">oneOf(<em>$allowed, $message = null</em>)</code>
                    </dt>
                    <dd>The field value must be one of the $allowed values. $allowed can be either an array or a comma-separated list of values. If comma separated, do not include spaces unless intended for matching.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">hasLowercase(<em>$message = ''</em>)</code>
                    </dt>
                    <dd>The field value must contain at least 1 lowercase character.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">hasUppercase(<em>$message = ''</em>)</code>
                    </dt>
                    <dd>The field value must contain at least 1 uppercase character.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">hasNumber(<em>$message = ''</em>)</code>
                    </dt>
                    <dd>The field value must contain at least 1 numeric character.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">hasSymbol(<em>$message = ''</em>)</code>
                    </dt>
                    <dd>The field value must contain at least 1 symbol character.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Required</span><code class="language-php">hasPattern(<em>$pattern, $message = ''</em>)</code>
                    </dt>
                    <dd>The field value must match regex.</dd>
                    <dd class="line-break"></dd>
                    <dt class="w-50">
                        <span class="badge badge-secondary mr-2">Optional</span><code class="language-php">callback(<em>$callback, $message = '', $params = array()</em>)</code>
                    </dt>
                    <dd>Define your own custom callback validation function. $callback must pass an is_callable() check. $params can be any value, or an array if multiple parameters must be passed.</dd>
                    <dd class="line-break"></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt><span class="badge badge-secondary mr-2">Required</span></dt>
                    <dd>: Empty fields are <span class="text-danger">NOT VALID</span></dd>
                    <dd class="line-break"></dd>
                    <dt><span class="badge badge-secondary mr-2">Optional</span></dt>
                    <dd>: Empty fields are <span class="teal-text">VALID</span></dd>
                </dl>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="php-validation-examples">Validation examples</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Validation examples code</h4>
                        <h3>Main validation code</h3>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    if ($_SERVER["REQUEST_METHOD"] == "POST" &amp;&amp; Form::testToken('my-form-id') === true) {

        // create validator & auto-validate required fields
        $validator = Form::validate('contact-form-1');

        // additional validation
        $validator->email()->validate('email-field-name');

        // add custom message if you want:
        $validator->integer('You must enter a number')->validate('number-field-name');

        $validator->captcha('captcha')->validate('captcha-field-name');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['my-form-id'] = $validator->getAllErrors();
        }
    }</code></pre>
                        </div>
                        <hr>
                        <h3>Checkboxes validation</h3>
                        <p>If we want at least one checked:</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addCheckbox('chk_group', 'check 1', 1);
    $form->addCheckbox('chk_group', 'check 2', 2);
    $form->addCheckbox('chk_group', 'check 3', 3);
    $form->printCheckboxGroup('chk_group', 'check one: ');

    /* Validation: */

    if(!isset($_POST['chk_group']) || !is_array($_POST['chk_group'])) {

        /* if none posted, we register error */

        $validator->required('check at least one checkbox please')->validate('chk_group');
    }</code></pre>
                        </div>
                        <hr>
                        <h3>Trigger an error manually</h3>
                        <p>If we want at least 2 checked:</p>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addCheckbox('chk_group', 'check 1', 1);
    $form->addCheckbox('chk_group', 'check 2', 2);
    $form->addCheckbox('chk_group', 'check 3', 3);
    $form->printCheckboxGroup('chk_group', 'check at least 2: ');

    /* Validation: */

    if(!isset($_POST['chk_group']) || !is_array($_POST['chk_group']) || count($_POST['chk_group']) < 2) {

        /* if less than 2 posted, we create a tricky validation which always throws an error */

        $validator->maxLength(-1, 'Check at least 2 please')->validate('chk_group');
    }</code></pre>
                        </div>
                        <hr>
                        <h3>Radio validation</h3>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addRadio('rating', 'Good', 'Good');
    $form->addRadio('rating', 'Fair', 'Fair');
    $form->addRadio('rating', 'Poor', 'Poor');
    $form->printRadioGroup('rating', 'Rate please: ', false, 'required=required');

    /* Validation: */

    $validator->required('Please rate')->validate('rating');
    </code></pre>
                        </div>
                        <hr>
                        <h3>Multiple select validation</h3>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addOption('product-choice[]', 'Books', 'Books');
    $form->addOption('product-choice[]', 'Music', 'Music');
    $form->addOption('product-choice[]', 'Photos', 'Photos');
    $form->addSelect('product-choice[]', 'What products are you interested in ?<br><small>(multiple choices)</small>', 'required=required, multiple=multiple, style=min-height:130px');

    /* Validation: */

    $validator->required('Please choose one or several product(s)')->validate('product-choice.0');</code></pre>
                        </div>
                        <hr>
                        <h3 id="recaptcha-validation">Recaptcha validation</h3>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $form->addRecaptcha('YOUR_RECAPTCHA_KEY_HERE');

    /* Validation: */

    $validator->recaptcha('YOUR_RECAPTCHA_SECRET_KEY_HERE', 'Recaptcha Error')->validate('g-recaptcha-response');</code></pre>
                        </div>
                        <hr>
                        <h3>Conditional validation</h3>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    if ($_SERVER["REQUEST_METHOD"] == "POST" &amp;&amp; Form::testToken('my-form-id') === true) {

        // 'field_name' will be validated only if $_POST['parent_field_name'] === 'Yes'
        $_SESSION['my-form-id']['required_fields_conditions']['field_name'] = array(
            'parent_field'  => 'parent_field_name',
            'show_values'   => 'Yes',
            'inverse'       => false
        );

        // create validator & auto-validate required fields
        $validator = Form::validate('my-form-id');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['my-form-id'] = $validator->getAllErrors();
        }
    }</code></pre>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="php-validation-multilanguage">Validation multilanguage support</h3>
                <p>Default language is 'en' (English).</p>
                <p>Current available languages are:</p>
                <ul>
                    <li>de</li>
                    <li>en</li>
                    <li>es</li>
                    <li>fr</li>
                    <li>pt_br</li>
                </ul>
                <p>If you need other language support:
                <ol>
                    <li>Add your language to <span class="file-path">form/Validator/Validator.php</span> => <code class="language-php">_getDefaultMessage($rule, $args = null)</code></li>
                    <li>
                        instantiate with your language as second argument: <br>
                        <pre><code class="language-php">$validator = Form::validate('contact-form-1', 'fr');</code></pre>
                    </li>
                </ol>
                <p><strong>If you add your own language, please share it so it can benefit to other users.</strong></p>
            </article>
            <h3>Real time Validation (jQuery)</h3>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-getting-started">Getting started</h3>
                <p>Real time Validation is done with formvalidation plugin.</p>
                <ol class="numbered mb-6">
                    <li>Call plugin like you would do with any other plugin:<pre class="line-numbers mb-4"><code class="language-php">$form->addPlugin('formvalidation', '#my-form'); // replace "my-form" with your form name</code></pre></li>
                    <li>Fields with the following HTML5 types/attributes will be automatically validated:
    <pre class="line-numbers mb-4"><code class="language-php">    min="..."
    max="..."
    maxlength="..."
    minlength="..."
    pattern="..."
    required
    type="color"
    type="email"
    type="range"
    type="url"</code></pre>
    More details here: <a href="https://formvalidation.io/guide/plugins/declarative/#example-using-html-5-inputs-and-attributes">https://formvalidation.io/guide/plugins/declarative/#example-using-html-5-inputs-and-attributes</a></li>
                    <li>To add any custom validation, use HTML5 attributes with validatorname and validator option:<pre class="line-numbers mb-4"><code class="language-php">&lt;?php
    $form->addInput('text', 'username', 'Username', '', 'data-fv-not-empty, data-fv-not-empty___message=The username is required and cannot be empty');</code></pre>
                        <p class="alert alert-info has-icon">Complete list of HTML5 validation attributes available at <a href="https://formvalidation.io/guide/plugins/declarative/#example-using-html-5-inputs-and-attributes">https://formvalidation.io/guide/plugins/declarative/#example-using-html-5-inputs-and-attributes</a></p>
                    </li>
                </ol>
                <h4>Validator icons</h4>
                <p>The jQuery validation plugin is configured to show feedback valid/invalid icons on the right of each field.</p>
                <p>The default icons are:</p>
                <ul>
                    <li>Glyphicons for Bootstrap 3</li>
                    <li>Fontawesome icons for Bootstrap 4</li>
                    <li>Material icons for Material Design</li>
                    <li>Foundation icons for Foundation</li>
                </ul>
                You can disable them this way:
                <pre class="mb-6"><code class="language-php">$form = new Form('booking-form', 'horizontal', 'data-fv-no-icon=true, novalidate');</code></pre>
                <h4>DEBUG mode</h4>
                <p>In some complex cases you may want to see which fields are validated or not:</p>
                <ol class="numbered mb-5">
                    <li>Enable the <strong>DEBUG mode</strong>:<br>
                        <pre><code class="language-php">$form = new Form('booking-form', 'horizontal', 'data-fv-debug=true, novalidate');</code></pre>
                    </li>
                    <li>Open your browser's console, fill some fields and/or post your form</li>
                    <li>The form will not be submitted:<br><strong>in DEBUG mode submit is disabled</strong>.<br>You'll see instead the validation results in your browser's console:</li>
                </ol>
                <div class="text-center">
                    <img data-src="assets/images/jquery-validator-debug-console.png" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="jquery validator debug console" width="425" height="279" class="border rounded p1 lazyload">
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-available-methods">jQuery validation - Available methods</h3>
                <p>The complete list of validators mathods is available here: <a href="https://formvalidation.io/guide/validators/">https://formvalidation.io/guide/validators/</a></p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-callback-api">Callback & jQuery validation API</h3>
                <p>The callback function allows to enable/disable validators and use the <strong>Form Validation plugin API</strong> the way you want.</p>
                <p>Create a function named <span class="var-value">fvCallback</span> - The validator plugin will call it as soon as it's ready.<br>Then you can use all the <a href="https://formvalidation.io/guide/api/" title="jQuery validator API">validator API</a>.</p>
                <ul>
                    <li>The callback function name is <span class="var-value">fvCallback</span></li>
                    <li>The form validator instance can be found this way:
                        <pre><code class="language-php">var form = forms['my-form'];

// form.fv is the validator
form.fv.on('core.form.invalid', function() {
    // do stuff
});</code></pre></li>
                </ul>
                <p>example of use:</p>
                <pre><code class="language-php">&lt;script type="text/javascript"&gt;
var fvCallback = function() {
    var form = forms['my-form'];

    // form.fv is the validator
    // you can then use the formvalidation plugin API
    form.fv.on('core.form.invalid', function() {
        // do stuff
    });
};
&lt;/script&gt;</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-examples">Examples</h3>
                <ul>
                    <li><a href="../templates/bootstrap-4-forms/validation-with-jquery-example-form.php">validation-with-jquery-example-form.php (Bootstrap 4)</a></li>
                    <li><a href="../templates/bootstrap-4-forms/car-rental-form.php">Example with Callback (<span class="var-value">fvCallback</span> function)</a></li>
                    <li><a href="../templates/index.php">../templates/index.php</a></li>
                </ul>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-multilanguage">Multilanguage support</h3>
                <p><strong>jQuery Validation languages files</strong> are in <span class="file-path">phpformbuilder/plugins/formvalidation/dist/js/language/</span></p>
                <p><strong>To set your language:</strong></p>
                <ol class="numbered">
                    <li>Find your language file in <span class="file-path">phpformbuilder/plugins/formvalidation/dist/js/locales/</span></li>
                    <li>Add the validation plugin this way:<pre><code class="language-php">$js_replacements = array('%language%' => 'fr_FR');
$form->addPlugin('formvalidation', '#form-name', 'default', $js_replacements);</code></pre> where <span class="var-value">fr_FR</span> is the name of your language file.</li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="jquery-validation-more">More</h3>
                <p>Formvalidation plugin comes with rich &amp; complex features.</p>
                <p>You'll find complete documentation on <a href="http://formvalidation.io/">Formvalidation plugin official site</a></p>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="sendMail">E-mail Sending</h2>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="sendMail">sendMail function (static)</h3>
                <pre><code class="language-php">$sent_message = Form::send($options, $smtp_settings = array());</code></pre>
                <pre class="line-numbers mb-4"><code class="language-php">    /**
    * Send email with posted values and custom content
    *
    * Tests and secures values to prevent attacks (phpmailer/extras/htmlfilter.php => HTMLFilter)
    * Uses custom html/css template and replaces shortcodes - syntax : {fieldname} - in both html/css templates with posted|custom values
    * Creates an automatic html table with vars/values - shortcode : {table}
    * Merges html/css to inline style with Pelago Emogrifier
    * Sends email and catches errors with Phpmailer
    * @param  array  $options
    *                     sender_email                    : the email of the sender
    *                     sender_name [optional]          : the name of the sender
    *                     reply_to_email [optional]       : the email for reply
    *                     recipient_email                 : the email destination(s), separated with commas
    *                     cc [optional]                   : the email(s) of copies to send, separated with commas
    *                     bcc [optional]                  : the email(s) of blind copies to send, separated with commas
    *                     subject                         : The email subject
    *                     isHTML                          : Send the mail in HTML format or Plain text (default: true)
    *                     textBody                        : The email body if isHTML is set to false
    *                     attachments [optional]          : file(s) to attach : separated with commas, or array (see details inside function)
    *                     template [optional]             : name of the html/css template to use in phpformbuilder/mailer/email-templates/
                                                 (default: default.html)
    *                     human_readable_labels [optional]: replace '-' ans '_' in labels with spaces if true (default: true)
    *                     values                          : $_POST
    *                     filter_values [optional]        : posted values you don't want to include in the e-mail automatic html table
    *                     custom_replacements [optional]  : array to replace shortcodes in email template. ex : array('mytext' => 'Hello !') will replace {mytext} with Hello !
    *                     sent_message [optional]         : message to display when email is sent
    *                     debug [optional]                : displays sending errors (default: false)
    *                     smtp [optional]                 : use smtp (default: false)
    *
    * @param  array  $smtp_settings
    *                         host :       String      Specify main and backup SMTP servers - i.e: smtp1.example.com, smtp2.example.com
    *                         smtp_auth:   Boolean     Enable SMTP authentication
    *                         username:    String      SMTP username
    *                         password:    String      SMTP password
    *                         smtp_secure: String      Enable TLS encryption. Accepted values: tls|ssl
    *                         port:        Number      TCP port to connect to (usually 25 or 587)
    *
    * @return string sent_message
    *                         success or error message to display on the page
    */</code></pre>
                <p class="alert alert-info has-icon">The fields named <span class="var-type">*-token</span> and <span class="var-type">*submit-btn</span> are automatically filtered.<br>This means that the posted values will not appear in the email sent.</p>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Minimal Example</h4>
                        <p><strong>The following code will :</strong></p>
                        <ul>
                            <li>Load default email template <code class="language-php">phpformbuilder/mailer/email-templates/default[.html/.css]</code></li>
                            <li>Replace template shortcode <code class="language-php">{table}</code> with an automatic html table with vars/ posted values</li>
                            <li>Merge html/css to inline style with Pelago Emogrifier</li>
                            <li>Send email and catch errors with Phpmailer</li>
                        </ul>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $options = array(
        'sender_email'     =>  'contact@phpformbuilder.pro',
        'recipient_email'  =>  'john.doe@gmail.com',
        'subject'          =>  'contact from PHP Form Builder'
    );
    $sent_message = Form::sendMail($options);</code></pre>
                        </div>
                        <div class="output pt-5">
                            <p class="alert alert-success">Your message has been successfully sent !</p>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example with SMTP</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    $smtp_settings = array(
        host        => 'smtp1.example.com',
        smtp_auth   => true,
        username    => 'myname',
        password    => 'mypassword',
        smtp_secure => 'tls',
        port        => 25
    );

    $options = array(
        'sender_email'     =>  'contact@phpformbuilder.pro',
        'recipient_email'  =>  'john.doe@gmail.com',
        'subject'          =>  'contact from PHP Form Builder',
        'smtp'             =>  true
    );
    $sent_message = Form::sendMail($options, $smtp_settings);</code></pre>
                        </div>
                        <div class="output pt-5">
                            <p class="alert alert-success">Your message has been successfully sent !</p>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Full Example using styled template</h4>
                        <p><strong>The following code will :</strong></p>
                        <ul>
                            <li>Load a styled email template <code class="language-php">phpformbuilder/mailer/email-templates/contact[.html/.css]</code></li>
                            <li>Replace template shortcodes including header image and colors with the values set in <code class="language-php">$replacements</code></li>
                            <li>Replace others template shortcodes with posted values</li>
                            <li>Merge html/css to inline style with Pelago Emogrifier</li>
                            <li>Send email and catch errors with Phpmailer</li>
                        </ul>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">    // server path for attachments
    $path = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/images/uploads/';

    $replacements = array(
        'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-sandy-stone-600-160.png',
        'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-sandy-stone.png) repeat #002f2f',
        'tpl-content-dark-background'   => '#a7a37e',
        'tpl-content-light-background'  => '#f9f8e9',
        'tpl-content-dark-text'         => '#333333',
        'tpl-content-light-text'        => '#f9f8e9',
        'tpl-content-accent-text'       => '#f9f8e9',
        'tpl-content-accent-background' => '#198181',
        'user-name'                     => 'Name',
        'user-first-name'               => 'First name',
        'user-email'                    => 'Email'
    );

    $email_config = array(
        'sender_email'        => 'contact@phpformbuilder.pro',
        'sender_name'         => 'PHP Form Builder',
        'reply_to_email'      => 'contact@phpformbuilder.pro',
        'recipient_email'     => addslashes($_POST['user-email']),
        'cc'                  => 'john.doe@email.com, 2nd.cc@email.com',
        'bcc'                 => 'another.one@email.com',
        'subject'             => 'Contact From PHP Form Builder',
        'attachments'         => $path . $_POST['files'][0],
        'template'            => 'contact-styled.html',
        'filter_values'       => 'email-styles, submit-btn, token',
        'values'              => $_POST,
        'custom_replacements' => $replacements,
        'debug'               => true
    );
    $sent_message = Form::sendMail($email_config);</code></pre>
                        </div>
                        <div class="output pt-5">
                            <p class="alert alert-success">Your message has been successfully sent !</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info has-icon mb-6">
                    <p>See code example here : <a href="../templates/bootstrap-3-forms/email-styles.php">templates/bootstrap-4-forms/email-styles.php</a></p>
                </div>
                <h4>To create custom email templates:</h4>
                <ol class="numbered mb-6">
                    <li><strong>Copy/paste an existing html/css template from <span class="file-path">phpformbuilder/mailer/email-templates/</span></strong> and save it into <span class="file-path">phpformbuilder/mailer/email-templates-custom/</span> (or create a new html file + a new css file with both same name)</li>
                    <li><strong>Use the shortcode <span class="var-value">{table}</span> in your html template</strong> if you want to add an automatic html table with all posted values</li>
                    <li><strong>(And/Or) Put fieldnames between braces in your template</strong>.<br>They'll be replaced automatically with posted values.<br>For example: <span class="var-value">Hello {user-first-name} {user-name}</span></li>
                    <li>[optional] You can use the <span class="var-value">custom_replacements</span> option to replace specific texts in email with specific values</li>
                    <li><strong>Call <code class="language-php">sendMail()</code> function</strong> and set your html template in <span class="file-path">template</span> option</li>
                </ol>
                <h4>How to replace array values using sendMail() function</h4>
                <p>To replace values posted in array in custom email template, best way is to create non-array indexed values, then add them in sendMail <span class="var-value">custom_replacements</span> option</p>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Example using array values</h4>
                        <div class="code-example">
                            <pre class="line-numbers mb-4"><code class="language-php">&lt;?php
    /*
    Example with 3 posted colors
    Email template will use {color_1}, {color_2}, {color_3}
    */

    // create index
    $i = 1;

    // loop through posted values
    foreach ($_POST['color'] as $color) {

        // name indexed variable and give it posted value
        $var = 'color_' . $i;
        $$var = $color;

        // increment index
        $i++;
    }

    $options = array(
        // [...]
        'custom_replacements'  => array(
            'color_1' => $color_1,
            'color_2' => $color_2,
            'color_3' => $color_3
        ),
        // [...]
    );

    $sent_message = Form::sendMail($options);</code></pre>
                        </div>
                        <div class="output pt-5">
                            <p class="alert alert-success">Your message has been successfully sent !</p>
                        </div>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="attachmentsExamples">Attachments Examples</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Examples using FileUpload plugin</h4>
                        <div class="alert alert-info has-icon">
                            <p>The upload path is configured in<br><span class="file-path">phpformbuilder/plugins/jQuery-File-Upload/server/php/[YourFileUploadHandler].php.</span></p>
                            <p>The uploaded filename is sent using hidden field, for example <code class="language-php">$_POST['files']</code>.</p>
                        </div>
                        <p></p>
                        <p><strong>Single file:</strong></p>
                        <pre class="line-numbers mb-4"><code class="language-php">    $path = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/images/uploads/';

    $options = array(
        [...]
        'attachments' =>  $path . $_POST['files'][0]
    );

    $msg = Form::sendMail($options);</code></pre>
                        <p><strong>Multiple files separated with commas:</strong></p>
                        <pre class="line-numbers mb-4"><code class="language-php">    $attachments = $path . $_POST['files'][0] . ',' . $path . $_POST['files'][1];

    $options = array(
        [...]
        'attachments' => $attachments,
        [...]
    );

    $msg = Form::sendMail($options);</code></pre>
                    </div>
                </div>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Examples using input type="file"</h4>
                        <p><strong>Single file:</strong></p>
                        <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('file', 'myFile', '', 'file: ');

    $attachments = array(
        array(
            'file_path' => $_FILES['myFile']['tmp_name'],
            'file_name' => $_FILES['myFile']['name']
        )
    );

    $options = array(
        [...]
        'attachments' => $attachments,
        [...]
    );

    $msg = Form::sendMail($options);</code></pre>
                        <p><strong>Multiple files:</strong></p>
                        <pre class="line-numbers mb-4"><code class="language-php">    $form->addInput('file', 'myFile', '', 'file: ');
    $form->addInput('file', 'mySecondFile', '', 'file: ');

    $attachments = array(
        array(
            'file_path' => $_FILES['myFile']['tmp_name'],
            'file_name' => $_FILES['myFile']['name']
        ),
        array(
            'file_path' => $_FILES['mySecondFile']['tmp_name'],
            'file_name' => $_FILES['mySecondFile']['name']
        )
    );

    $options = array(
        [...]
        'attachments' => $attachments,
        [...]
    );
    $msg = Form::sendMail($options);</code></pre>
                    </div>
                </div>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="database-main">Database Utilities</h2>
            <p><a href="http://www.phpclasses.org/ultimatemysql">Jeff L. Williams&#39;s Mysql class</a> is in <span class="file-path">database</span> folder.</p>
            <p><strong>Complete Mysql class doc</strong> with <strong>examples queries</strong> is in <span class="file-path">phpformbuilder/documentation/mysql-class-doc/</span></p>
            <p>Available online here: <a href="https://www.phpformbuilder.pro/documentation/mysql-class-doc/Mysql-documentation.html">https://www.phpformbuilder.pro/documentation/mysql-class-doc/Mysql-documentation.html</a></p>
            <div class="alert alert-success has-icon mb-6">
                <p>Configure your localhost/production access in <span class="file-path">phpformbuilder/database/db-connect.php</span>, and you're ready to connect.</p>
            </div>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="database-select">Examples</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Database Select Example</h4>
                        <pre class="line-numbers mb-4"><code class="language-php">    use phpformbuilder\database\Mysql;

    require_once 'phpformbuilder/database/db-connect.php';
    require_once 'phpformbuilder/database/Mysql.php';

    $db = new Mysql();
    $qry = 'SELECT * FROM table';
    $db = new Mysql();
    $db->query($qry);
    $db_count = $db->rowCount();
    if (!empty($db_count)) {
        while (! $db->endOfSeek()) {
            $row = $db->row();
            $value_1[] = $row->field_1;
            $value_2[] = $row->field_2;
        }

        // remove comment to show $value_1
        // var_dump($value_1);
    }</code></pre>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="database-insert">Database Insert</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Database Insert Example</h4>
                        <pre class="line-numbers mb-4"><code class="language-php">    use phpformbuilder\database\Mysql;

    require_once 'phpformbuilder/database/db-connect.php';
    require_once 'phpformbuilder/database/Mysql.php';

    $db = new Mysql();
    $insert['ID'] = Mysql::SQLValue('');
    $insert['username'] = Mysql::SQLValue($_POST['username']);
    $insert['useremail'] = Mysql::SQLValue($_POST['useremail']);
    $insert['userphone'] = Mysql::SQLValue($_POST['userphone']);

    if (!$db->insertRow('YOUR_TABLE', $insert)) {
        $msg = &#039;&lt;p class=&quot;alert alert-danger&quot;&gt;&#039; . $db-&gt;error() . &#039;&lt;br&gt;&#039; . $db-&gt;getLastSql() . &#039;&lt;/p&gt;&#039; . &quot; \n&quot;;
    } else {
        $msg = &#039;&lt;p class=&quot;alert alert-success&quot;&gt;1 row inserted !&lt;/p&gt;&#039; . &quot; \n&quot;;
    }

    echo $msg;</code></pre>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="database-update">Database Update</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Database Update Example</h4>
                        <pre class="line-numbers mb-4"><code class="language-php">    use phpformbuilder\database\Mysql;

    require_once 'phpformbuilder/database/db-connect.php';
    require_once 'phpformbuilder/database/Mysql.php';

    $db = new Mysql();

    $filter['ID'] = Mysql::sqlValue($_POST['ID'], Mysql::SQLVALUE_NUMBER);

    $update['username'] = Mysql::SQLValue($_POST['username']);
    $update['useremail'] = Mysql::SQLValue($_POST['useremail']);
    $update['userphone'] = Mysql::SQLValue($_POST['userphone']);

    if (!$db->UpdateRows('YOUR_TABLE', $update, $filter)) {
        $msg = &#039;&lt;p class=&quot;alert alert-danger&quot;&gt;&#039; . $db-&gt;error() . &#039;&lt;br&gt;&#039; . $db-&gt;getLastSql() . &#039;&lt;/p&gt;&#039; . &quot; \n&quot;;
    } else {
        $msg = &#039;&lt;p class=&quot;alert alert-success&quot;&gt;Database updated successfully !&lt;/p&gt;&#039; . &quot; \n&quot;;
    }

    echo $msg;</code></pre>
                    </div>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
            <h3 id="database-delete">Database Delete</h3>
                <div class="card mb-6">
                    <div class="card-body">
                        <h4 class="mb-2">Database Delete Example</h4>
                        <pre class="line-numbers mb-4"><code class="language-php">    use phpformbuilder\database\Mysql;

    require_once 'phpformbuilder/database/db-connect.php';
    require_once 'phpformbuilder/database/Mysql.php';

    $db = new Mysql();

    $filter["ID"] = Mysql::sqlValue($_POST['ID'], Mysql::SQLVALUE_NUMBER);

    if (!$db->deleteRows('YOUR_TABLE', $filter)) {
        $msg = &#039;&lt;p class=&quot;alert alert-danger&quot;&gt;&#039; . $db-&gt;error() . &#039;&lt;br&gt;&#039; . $db-&gt;getLastSql() . &#039;&lt;/p&gt;&#039; . &quot; \n&quot;;
    } else {
        $msg = &#039;&lt;p class=&quot;alert alert-success&quot;&gt;1 row deleted successfully !&lt;/p&gt;&#039; . &quot; \n&quot;;
    }

    echo $msg;</code></pre>
                    </div>
                </div>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="security">Security</h2>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="security-xss">Protection against XSS (Cross-Site Scripting)</h3>
                <h4>How it works</h4>
                <ol class="numbered mb-5">
                    <li>When form is created, each fieldname is registered in session</li>
                    <li>When form is posted, each posted value is registered in session.</li>
                    <li>If validation is ok, call <code class="language-php">Form::clear('form-name');</code> to clear all previously registered values</li>
                    <li>If validation fails, form will fill fields using user posted values stored in session, protected using <code class="language-php">htmlspecialchars()</code>.</li>
                </ol>
                <div class="alert alert-info has-icon">
                    <p>To display posted values on your pages, always protect with htmlspecialchars(): <code class="language-php">htmlspecialchars($_POST['value'])</code></p>
                    <p>To register posted values into your database: </p>
                    <ul>
                        <li>protect with addslashes(): <code class="language-php">addslashes(htmlspecialchars($_POST['value']))</code></li>
                        <li>or just with addslashes id you want to keep html intact: <code class="language-php">addslashes($_POST['value'])</code></li>
                        <li>or use <a href="#database-insert">built-in Mysql class protection</a></li>
                    </ul>
                </div>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h3 id="securityt-csrf">Protection against CSRF (Cross-Site Request Forgeries)</h3>
                <p>Security token is automatically added to each form.</p>
                <p>Token is valid for 1800 seconds (30mn) without refreshing page.</p>
                <p>Validate posted token this way:</p>
                <pre class="line-numbers mb-4"><code class="language-php">    if(Form::testToken('my-form-id') === true) {
        // token valid, no CSRF.
    }</code></pre>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="extending-main-class">Extending main class</h2>
            <article class="pb-5 mb-7 has-separator">
                <p><strong>Extending PHP Form Builder allows to create a complete form or form parts using a single customized function.</strong></p>
                <p>Created form or parts can be validated the same way, using a single customized function.</p>
                <div class="alert alert-success has-icon">
                    <p>Very useful if you want for example:</p>
                    <ul>
                        <li>Create a complete contact form and use it on several projects</li>
                        <li>Create several similar fields in a single form</li>
                        <li>Create and reuse several fields in different forms</li>
                    </ul>
                </div>
                <p>See live examples with code in <a href="../templates/index.php">Templates</a></p>
                <p>See <span class="file-path">phpformbuilder/FormExtended.php</span> code</a></p>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="chaining-methods">Chaining methods</h2>
            <article class="pb-5 mb-7 has-separator">
                <p><strong>All public non-static methods can be chained.</strong></p>
                <h3>The classic way:</h3>
                <pre class="line-numbers mb-4"><code class="language-php">/* ==================================================
    The Form
    ================================================== */

    $form = new Form(&#039;contact-form-2&#039;, &#039;vertical&#039;, &#039;novalidate&#039;);
    $form-&gt;startFieldset(&#039;Please fill in this form to contact us&#039;);
    $form-&gt;addInput(&#039;text&#039;, &#039;user-name&#039;, &#039;&#039;, &#039;Your name: &#039;, &#039;required&#039;);
    $form-&gt;addInput(&#039;email&#039;, &#039;user-email&#039;, &#039;&#039;, &#039;Your email: &#039;, &#039;required&#039;);
    $form-&gt;addHelper(&#039;Enter a valid US phone number&#039;, &#039;user-phone&#039;);
    $form-&gt;addInput(&#039;text&#039;, &#039;user-phone&#039;, &#039;&#039;, &#039;Your phone: &#039;, &#039;required, data-fv-phone, data-fv-phone-country=US&#039;);
    $form-&gt;addTextarea(&#039;message&#039;, &#039;&#039;, &#039;Your message: &#039;, &#039;cols=30, rows=4, required&#039;);
    $form-&gt;addPlugin(&#039;word-character-count&#039;, &#039;#message&#039;, &#039;default&#039;, array(&#039;%maxAuthorized%&#039; =&gt; 100));
    $form-&gt;addCheckbox(&#039;newsletter&#039;, &#039;Suscribe to Newsletter&#039;, 1, &#039;checked=checked&#039;);
    $form-&gt;printCheckboxGroup(&#039;newsletter&#039;, &#039;&#039;);
    $form-&gt;addRecaptcha(&#039;recaptcha-code-here&#039;);
    $form-&gt;addBtn(&#039;submit&#039;, &#039;submit-btn&#039;, 1, &#039;Submit&#039;, &#039;class=btn btn-success&#039;);
    $form-&gt;endFieldset();
    $form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square-custom&#039;, &#039;%color%&#039; =&gt; &#039;green&#039;));

    // jQuery validation
    $form-&gt;addPlugin(&#039;formvalidation&#039;, &#039;#contact-form-2&#039;);</code></pre>
                <h3>Using chained methods:</h3>
                <pre class="line-numbers mb-4"><code class="language-php">$form = new Form(&#039;contact-form-2&#039;, &#039;vertical&#039;, &#039;novalidate&#039;);
$form-&gt;startFieldset(&#039;Please fill in this form to contact us&#039;)-&gt;addInput(&#039;text&#039;, &#039;user-name&#039;, &#039;&#039;, &#039;Your name: &#039;, &#039;required&#039;)
    -&gt;addInput(&#039;email&#039;, &#039;user-email&#039;, &#039;&#039;, &#039;Your email: &#039;, &#039;required&#039;)
    -&gt;addHelper(&#039;Enter a valid US phone number&#039;, &#039;user-phone&#039;)
    -&gt;addInput(&#039;text&#039;, &#039;user-phone&#039;, &#039;&#039;, &#039;Your phone: &#039;, &#039;required, data-fv-phone, data-fv-phone-country=US&#039;)
    -&gt;addTextarea(&#039;message&#039;, &#039;&#039;, &#039;Your message: &#039;, &#039;cols=30, rows=4, required&#039;)
    -&gt;addPlugin(&#039;word-character-count&#039;, &#039;#message&#039;, &#039;default&#039;, array(&#039;%maxAuthorized%&#039; =&gt; 100))
    -&gt;addCheckbox(&#039;newsletter&#039;, &#039;Suscribe to Newsletter&#039;, 1, &#039;checked=checked&#039;)
    -&gt;printCheckboxGroup(&#039;newsletter&#039;, &#039;&#039;)
    -&gt;addRecaptcha(&#039;recaptcha-code-here&#039;)
    -&gt;addBtn(&#039;submit&#039;, &#039;submit-btn&#039;, 1, &#039;Submit&#039;, &#039;class=btn btn-success&#039;)
    -&gt;endFieldset()
    -&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square-custom&#039;, &#039;%color%&#039; =&gt; &#039;green&#039;))

    // jQuery validation
    -&gt;addPlugin(&#039;formvalidation&#039;, &#039;#contact-form-2&#039;);</code></pre>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="credits">Sources &amp; Credits</h2>
            <p>
                Thanks so much to:
            </p>
            <ul>
                <li><a href="https://github.com/blackbelt/php-validation">blackbelt&#39;s php-validation class</a></li>
                <li><a href="http://www.phpclasses.org/ultimatemysql">Jeff L. Williams&#39;s Mysql class</a></li>
                <li><a href="http://www.responsivefilemanager.com/">http://www.responsivefilemanager.com/</a></li>
                <li><a href="http://www.tinymce.com">http://www.tinymce.com</a></li>
                <li><a href="http://jqueryui.com/datepicker/">http://jqueryui.com/datepicker/</a></li>
                <li><a href="https://github.com/jonthornton/jquery-timepicker">https://github.com/jonthornton/jquery-timepicker</a></li>
                <li><a href="http://amsul.ca/pickadate.js/">http://amsul.ca/pickadate.js/</a></li>
                <li><a href="http://keith-wood.name/realPerson.html">http://keith-wood.name/realPerson.html</a></li>
                <li><a href="https://innostudio.de/fileuploader/">https://innostudio.de/fileuploader/</a></li>
                <li><a href="https://github.com/PHPMailer/PHPMailer/">https://github.com/PHPMailer/PHPMailer</a></li>
                <li><a href="https://github.com/jjriv/emogrifier">https://github.com/jjriv/emogrifier</a></li>
                <li><a href="http://silviomoreto.github.io/bootstrap-select/">http://silviomoreto.github.io/bootstrap-select/</a></li>
                <li><a href="https://github.com/fronteed/icheck">http://fronteed.com/iCheck/</a></li>
                <li><a href="http://antelle.github.io/passfield/index.html">https://antelle.net/passfield/</a></li>
                <li><a href="http://vodkabears.github.io/remodal/">http://vodkabears.github.io/remodal/</a></li>
                <li><a href="https://github.com/sandywalker/webui-popover">https://github.com/sandywalker/webui-popover</a></li>
                <li><a href="http://materializecss.com/">http://materializecss.com/</a></li>
                <li><a href="https://github.com/Pixabay/jQuery-tagEditor">https://github.com/Pixabay/jQuery-tagEditor</a></li>
            </ul>
        </section>
    </div>
    <!-- container -->

    <?php require_once 'inc/js-includes.php'; ?>
</body>
</html>
