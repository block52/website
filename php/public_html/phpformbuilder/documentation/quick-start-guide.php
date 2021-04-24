<!doctype html>
<html lang="en">

<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder - Quick Start Guide',
            'description' => 'PHP Form Builder - Quick Users Guide to Start building your forms easily',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/quick-start-guide.php',
            'screenshot'  => 'quick-start-guide.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}h1,h2{margin-top:0;margin-bottom:.5rem}h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2,h3{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2,h3{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}h3{font-size:26.25px}.lead{font-size:1.25rem;font-weight:300}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.nav-pills .nav-link.active{color:#fff;background-color:#007bff}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.d-inline-block{display:inline-block!important}.mb-4{margin-bottom:1.5rem!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.mr-1{margin-right:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.mb-4,h3{margin-bottom:1.5rem!important}h2{margin-bottom:3rem!important}.mb-6{margin-bottom:6.25rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.pt-1{padding-top:.25rem!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.ml-auto{margin-left:auto!important}.text-center{text-align:center!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>a.active{background-color:#a93030}[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}h1,h2,h3{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}h3{font-weight:300;color:#a9a398}h3{font-variant:small-caps}p.lead{font-weight:400;color:#696359}strong{font-weight:500}section>h2{padding:1rem;border-bottom:1px solid #ddd}section>h3{white-space:nowrap}section>h3:after,section>h3:before{content:'';display:inline-block;width:8px;height:8px;background:#ffc107;margin-bottom:3px}section>h3:before{margin-right:10px}section>h3:after{margin-left:12px}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.dmca-badge{min-height:100px}
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
            <li class="nav-item"><a class="nav-link" href="#requirements">Requirements</a></li>
            <li class="nav-item"><a class="nav-link" href="#installation">Installation</a></li>
            <li class="nav-item"><a class="nav-link" href="#how-it-works">How it works</a></li>
            <li class="nav-item"><a class="nav-link" href="#sample-page-code">Sample page code</a></li>
            <li class="nav-item"><a class="nav-link" href="#validate-posted-values">Validate user's posted values and send email</a></li>
            <li class="nav-item"><a class="nav-link" href="#database-recording">Database recording</a></li>
            <li class="nav-item"><a class="nav-link" href="#complete-page-code">Complete page code</a></li>
            <li class="nav-item"><a class="nav-link" href="#to-go-further">To go further</a></li>
        </ul>
        <div class="text-center mb-xs"><a href="//www.dmca.com/Protection/Status.aspx?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" title="DMCA.com Protection Status" class="dmca-badge"><img data-src="//images.dmca.com/Badges/dmca-badge-w100-1x1-01.png?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="lazyload" alt="DMCA.com Protection Status" width="100" height="100"></a><script defer src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
        </div>
        <div class="text-center mb-7">
            <a href="https://www.hack-hunt.com" title="Send DMCA Takedown Notice" class="text-white">www.hack-hunt.com</a>
        </div>
        <!-- navbar-left -->
    </div>
    <!-- /main sidebar -->

    <div class="container">

        <?php include_once 'inc/top-section.php'; ?>

        <h1>Quick Start Guide</h1>

        <section class="mb-7">

            <h2 id="home">Welcome to PHP Form Builder's Quick start Guide</h2>
            <p class="lead mb-5"><strong>To get started with PHP Form Builder you have several entry points according to your preferred approach:</strong></p>

            <h3>The Drag and drop form generator</h3>
            <p>Create your forms by simple drag and drop, then copy and paste the code into your page.</p>
            <p class="mb-5">The <a href="../drag-n-drop-form-builder/index.html">Drag and drop</a> method is the quickest & easiest way to build your forms.</p>

            <h3>The built-in PHP functions</h3>
            <p>Create your forms using the PHP functions provided for this purpose, simple, documented and explained throughout this project.</p>
            <p>Numerous <a href="../templates/index.php">templates</a> and <a href="../documentation/code-samples.php">code examples</a>, the <a href="../documentation/functions-reference.php">function reference</a> and <a href="../documentation/class-doc.php">class documentation</a> are available to help you.</p>

            <div class="alert alert-info has-icon">
                <p><strong>If you use Visual Studio Code or Sublime Text:</strong></p>

                <ul>
                    <li><a href="https://marketplace.visualstudio.com/items?itemName=Miglisoft.phpformbuilder">Download the PHP Form Builder extension for Visual Studio Code</a></li>
                    <li><a href="https://packagecontrol.io/packages/PHP%20Form%20Builder">Download the PHP Form Builder plugin for Sublime Text</a></li>
                </ul>
            </div>
            <hr class="my-5">
            <p>If you're not very comfortable coding in PHP, A detailed step-by-step tutorial is available here: <a href="beginners-guide.php">PHP Beginners Guide</a></p>
        </section>

        <section class="mb-7">

            <h2 id="requirements">Requirements</h3>
            <p><strong>All you need is a PHP server running with PHP 5.5+.</strong></p>
        </section>

        <section class="mb-7">
            <h2 id="installation" class="mb-5">Installation</h3>
            <p class="lead text-pink"><strong>Don't upload upload all the files and folders on your production server.</strong></p>
            <p><strong>PHP Form Builder's package includes the Form Builder itself, the documentation and all the templates.</strong></p>
            <p class="mb-sm"><strong>Documentation and Templates are available online at <a href="https://www.phpformbuilder.pro/">https://www.phpformbuilder.pro/</a>.<br>There's no need to upload them on your production server.</strong></p>
            <p>In the same way, you can use the <a href="../drag-n-drop-form-builder/index.html">online Drag & Drop Form Generator</a></p>
            <hr>
            <ol class="numbered">
                <li class="mb-5">
                    <p><strong>Add <span class="file-path">phpformbuilder</span> folder at the root of your project.</strong></p>
                    <p>Your directory structure should be similar to this :</p>
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
                                            <li><a href="#" class="file">register.php</a></li>
                                            <li><a href="#" class="file">server.php</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <p class="h5">Minimum required files</p>
                    <ul>
                        <li><span class="file-path">mailer</span> folder if you send emails</li>
                        <li><span class="file-path">Validator</span> folder (for server-side validation)</li>
                        <li><span class="file-path">Form.php</span></li>
                        <li><span class="file-path">register.php</span> - delete it once registered</li>
                    </ul>
                    <p>If you use any plugin, add its folder & xml file, for example <code class="language-php">phpformbuilder/plugins/select2</code> and <code class="language-php">phpformbuilder/plugins-config/select2.xml</code></p>
                    <hr>
                    <p>More details about folders, files and required files on production server here: <a href="/index.html#package-structure">../index.html#package-structure</a></p>
                </li>
                <li class="mb-5" id="registration">
                    <p class="h5">Registration</p>
                    <p><strong>Open <span class="file-path">phpformbuilder/register.php</span> in your browser, enter your purchase code to activate your copy.</strong></p>
                    <p>Each purchased license allows to install PHP Form Builder on 2 different domains:</p>
                    <ul>
                        <li>1 install for localhost</li>
                        <li>1 install for your production server</li>
                    </ul>
                    <p><strong>Once you activated your purchase, remove <span class="file-path">register.php</span> from your production server to avoid any unwanted access.</strong></p>
                </li>
                <li><strong>You're ready to go.</strong></li>
            </ol>
        </section>

        <section class="mb-7">
            <h2 id="how-it-works">How it works</h3>
            <p><strong>You need 4 PHP blocks in your page :</strong></p>
            <ol class="numbered">
                <li>
                    <strong>1<sup>st</sup> block at the very beginning of your page to :</strong>
                    <ul>
                        <li class="mb-1">create your form</li>
                        <li class="mb-1">validate if posted</li>
                        <li class="mb-1">send email (or record results in database, ...) if validated</li>
                    </ul>
                </li>
                <li><strong>2<sup>nd</sup> block just before <code class="language-php">&lt;/head&gt;</code></strong> to include css files required by plugins</li>
                <li><strong>3<sup>rd</sup> between <code class="language-php">&lt;body&gt;&lt;/body&gt;</code> to render your form</strong></li>
                <li><strong>4<sup>th</sup> just before <code class="language-php">&lt;/body&gt;</code> to include js files &amp; code required by plugins</strong></li>
            </ol>
        </section>

        <section class="mb-7">
            <h2 id="sample-page-code">Sample page code</h3>
            <pre class="line-numbers"><code class="language-php">&lt;?php

/*============================================
=            1st block - the form            =
============================================*/

use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
session_start();
include_once rtrim($_SERVER[&#039;DOCUMENT_ROOT&#039;], DIRECTORY_SEPARATOR) . &#039;/phpformbuilder/Form.php&#039;;
$form = new Form(&#039;test-form&#039;, &#039;horizontal&#039;, &#039;novalidate&#039;);
$form-&gt;addInput(&#039;text&#039;, &#039;user-name&#039;, &#039;&#039;, &#039;Name :&#039;, &#039;required, placeholder=Name&#039;);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;Yes&#039;, 1);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;No&#039;, 0);
$form-&gt;printRadioGroup(&#039;is-all-ok&#039;, &#039;Is all ok ?&#039;, false, &#039;required&#039;);
$form-&gt;addBtn(&#039;submit&#039;, &#039;submit-btn&#039;, 1, &#039;Send&#039;, &#039;class=btn btn-success&#039;);

// iCheck plugin
$form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square&#039;, &#039;%color%&#039; =&gt; &#039;red&#039;));

/*=====  End of 1st block  ======*/

?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Test Form&lt;/title&gt;
&lt;!-- Latest compiled and minified Bootstrap CSS --&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css&quot; integrity=&quot;sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7&quot; crossorigin=&quot;anonymous&quot;&gt;
&lt;?php

/*============================================================
=            2nd block - css includes for plugins            =
============================================================*/

$form-&gt;printIncludes(&#039;css&#039;);

/*=====  End of 2nd block  ======*/

?&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt;My first form&lt;/h1&gt;
&lt;?php

/*======================================================================================================
=            3rd block - render the form and the feedback message if the form has been sent            =
======================================================================================================*/

if (isset($sent_message)) {
echo $sent_message;
}
$form-&gt;render();

/*=====  End of 3rd block  ======*/

?&gt;
&lt;!-- Latest compiled and minified jQuery --&gt;
&lt;script   src=&quot;https://code.jquery.com/jquery-2.2.4.min.js&quot; integrity=&quot;sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=&quot;   crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;!-- Latest compiled and minified Bootstrap JS --&gt;
&lt;script src=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js&quot; integrity=&quot;sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS&quot; crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
&lt;?php

/*========================================================================
=            4th block - js includes for plugins and js code (domready)            =
========================================================================*/

$form-&gt;printIncludes(&#039;js&#039;);
$form-&gt;printJsCode();

/*=====  End of 4th block ======*/

?&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
            <p class="alert alert-info has-icon">All functions and arguments to build your form, setup layout, add plugins are detailed in <a href="class-doc.php">Class Documentation</a> and <a href="functions-reference.php">Functions Reference</a>.</p>
        </section>

        <section class="mb-7">
            <h2 id="validate-posted-values">Validate user's posted values and send email</h3>
            <p><strong>Add this php block just after <code class="language-php">include_once [...] . &#039;/phpformbuilder/Form.php&#039;;</code> :</strong></p>
            <pre><code class="language-php">if ($_SERVER[&quot;REQUEST_METHOD&quot;] == &quot;POST&quot; &amp;&amp; Form::testToken(&#039;test-form&#039;) === true) {

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
        </section>

        <section class="mb-7">
            <h2 id="database-recording">Database recording</h3>
            <p><strong><a href="http://www.phpclasses.org/ultimatemysql">Jeff L. Williams&#39;s Mysql class</a> is in <span class="file-path">database</span> folder.</a></strong></p>
            <p><strong>You'll find all documentation and insert / edit / delete examples here : <a href="class-doc.php#database-main">class-doc.php#database-main</a></strong></p>
        </section>

        <section class="mb-7">
            <h2 id="complete-page-code">Complete page code</h3>
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
&#039;filter_values&#039;   =&gt; &#039;test-form&#039;
);
$sent_message = Form::sendMail($email_config);
Form::clear(&#039;test-form&#039;);
}
}
$form = new Form('test-form', 'horizontal', 'novalidate');
$form->addInput('text', 'user-name', '', 'Name :', 'required, placeholder=Name');
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;Yes&#039;, 1);
$form-&gt;addRadio(&#039;is-all-ok&#039;, &#039;No&#039;, 0);
$form-&gt;printRadioGroup(&#039;is-all-ok&#039;, &#039;Is all ok ?&#039;, false, &#039;required&#039;);
$form-&gt;addPlugin(&#039;icheck&#039;, &#039;input&#039;, &#039;default&#039;, array(&#039;%theme%&#039; =&gt; &#039;square&#039;, &#039;%color%&#039; =&gt; &#039;red&#039;));
$form->addBtn('submit', 'submit-btn', 1, 'Send', 'class=btn btn-success');
?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Test Form&lt;/title&gt;
&lt;!-- Latest compiled and minified Bootstrap CSS --&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css&quot; integrity=&quot;sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7&quot; crossorigin=&quot;anonymous&quot;&gt;
&lt;?php $form-&gt;printIncludes(&#039;css&#039;); ?&gt;
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
        </section>

        <section class="mb-7">
            <h2 id="to-go-further">To go further</h2>
            <p><strong>Now you've learned the basics ; Several resources will help to add other fields, plugins, validate different values and build more complex layouts :</strong></p>

            <ul>
                <li><a href="../templates/index.php">Templates</a></li>
                <li><a href="code-samples.php">Code Samples</a></li>
                <li><a href="functions-reference.php">Functions Reference</a></li>
                <li><a href="class-doc.php">Class Doc.</a></li>
            </ul>
        </section>

    </div>
    <?php require_once 'inc/js-includes.php'; ?>
</body>

</html>
