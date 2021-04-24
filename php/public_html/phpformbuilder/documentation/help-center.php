<!doctype html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder Help Center: Contact, Troubleshooting and Common issues',
            'description' => 'PHP Form Builder - How to solve common issues',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/help-center.php',
            'screenshot'  => 'help-center.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}nav,section{display:block}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}article,nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}strong{font-weight:bolder}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-warning{color:#856404;background-color:#fff3cd;border-color:#ffeeba}.d-inline-block{display:inline-block!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.mr-1{margin-right:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.mb-4{margin-bottom:1.5rem!important}.has-separator,h2{margin-bottom:3rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.pt-1{padding-top:.25rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.pb-5{padding-bottom:3rem!important}.pb-7{padding-bottom:12.5rem!important}.ml-auto{margin-left:auto!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.has-icon{position:relative}.has-icon.alert{padding-left:70px}.has-icon.alert:before{padding:13px 0 0 13px;content:' '}.has-icon:before{position:absolute;top:0;left:0;display:inline-block;width:50px;height:100%;border-radius:3px 0 0 3px;background-repeat:no-repeat;background-position:center center}.has-icon.alert:after{position:absolute;top:calc(50% - 6px);left:50px;width:0;height:0;content:' ';border-width:6px 0 6px 6px;border-style:solid}.has-icon.alert-warning:before{background-color:#ffc107;background-image:url("data:image/svg+xml,%3Csvg aria-hidden='true' data-fa-processed='' data-prefix='fas' data-icon='exclamation-triangle' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' class='svg-inline--fa fa-exclamation-triangle fa-w-18'%3E%3Cpath fill='%23fff' d='M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z' class=''%3E%3C/path%3E%3C/svg%3E");background-size:33.75%}.has-icon.alert-warning:after{border-color:transparent transparent transparent #ffc107}.alert{position:relative;border:none}.alert :first-child{margin-top:0}.alert p{margin-bottom:.5em}html{position:relative;min-height:100%}body{counter-reset:section}h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}strong{font-weight:500}section>h2{padding:1rem;border-bottom:1px solid #ddd}section ul:not(.list-unstyled):not(.tree-list):not(.list-inline):not(.picker__list):not(.select2-selection__rendered)>li{position:relative;list-style:none;margin-bottom:.5rem}section ul:not(.list-unstyled):not(.tree-list):not(.list-inline):not(.picker__list):not(.select2-selection__rendered)>li:before{content:' ';width:6px;height:6px;background:#a9a398;display:inline-block;position:absolute;left:-30px;top:.55em}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.has-separator{display:block;position:relative}.has-separator:after,.has-separator:before{position:absolute;left:50%;height:1px;content:'';background:#c6c2bb}.has-separator:before{bottom:-16px;width:12%;margin-left:-6%}.has-separator:after{bottom:-13px;width:20%;margin-left:-10%}
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
                    <li class="nav-item" role="presentation"><a class="nav-link" href="functions-reference.php">Functions Reference</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="help-center.php">Help Center</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--/LSHIDE-->

    <div id="navbar-left-wrapper" class="w3-animate-left">
        <a href="#" id="navbar-left-collapse" class="d-inline-block d-lg-none d-xlg-none float-right text-white p-4"><i class="fas fa-times"></i></a>
        <ul id="navbar-left" class="nav nav-pills flex-column pt-1 mb-4" role="tablist" aria-orientation="vertical">
            <li class="nav-item"><a class="nav-link" href="#contact">Contact us</a></li>
            <li class="nav-item"><a class="nav-link" href="#licensing-system">The licensing system</a></li>
            <li class="nav-item"><a class="nav-link" href="#installation-error">Installation error</a></li>
            <li class="nav-item"><a class="nav-link" href="#cant-connect-to-licensing-server">Can't connect to licensing server</a></li>
            <li class="nav-item"><a class="nav-link" href="#reinstall-phpfb">Reinstall PHP Form Builder</a></li>
            <li class="nav-item"><a class="nav-link" href="#white-page">White page / Error 500</a></li>
            <li class="nav-item"><a class="nav-link" href="#warning-include_once">Warning: include_once(...)</a></li>
            <li class="nav-item"><a class="nav-link" href="#fatal-error">Fatal error: Class 'phpformbuilder\Form' not found</a></li>
            <li class="nav-item"><a class="nav-link" href="#mb-string">Fatal error: Call to undefined function phpformbuilder\mb_strtolower()</a></li>
            <li class="nav-item"><a class="nav-link" href="#plugins-don-t-work">Plugins don't work</a></li>
            <li class="nav-item"><a class="nav-link" href="#i-do-not-receive-the-emails-sent">I do not receive the emails sent</a></li>
            <li class="nav-item"><a class="nav-link" href="#css-issues">CSS issues</a></li>
            <li class="nav-item"><a class="nav-link" href="#can-t-submit-form">Can't Submit form (using jQuery validation plugin)</a></li>
        </ul>
    </div>
    <div class="container">

        <?php include_once 'inc/top-section.php'; ?>

        <h1 id="home">Help, Troubleshooting &amp; Common issues</h1>
        <section id="contact" class="pb-5 mb-7 has-separator">
            <h2 class="mt-lg">For any question or request</h2>
            <p>Please first see if you can find a solution on this page.</p>
            <p>If your problem isn't solved:</p>
            <ul>
                <li>Contact me through <a href="http://codecanyon.net/item/php-form-builder/8790160/comments">PHP Form Builder's comments on Codecanyon</a></li>
                <li>E-mail me at <a href="https://www.miglisoft.com/#contact">https://www.miglisoft.com/#contact</a></li>
                <li>Chat on <a href="https://www.phpformbuilder.pro">www.phpformbuilder.pro</a></li>
            </ul>
            <div class="alert alert-warning has-icon">
                <p id="ask-for-help" class="h3 text-yellow-700">Important:</p>
                <p>I am available to solve any problems you may encounter. These can be related to the configuration of your server (PHP version and extensions, apache configuration, ...).</p>
                <p>For that reason, it will most of the time be necessary to send me your FTP access and the url of your form.</p>
                <p>If you are working on a local server, you can either place your project on a remote server, or contact me by chat on this site, which allows screen sharing for live help.</p>
                <hr>
                <p><strong>If you refuse to give me access to your project I won't be able to test, so I might not be able to help you.</strong></p>
                <hr>
                <p><strong>If you feel lost or have any trouble, please contact me before dropping any rating</strong></p>
                <ul>
                    <li>I can build you a form for free, or for a small fee if your form is really complex</li>
                    <li>I can propose a refund if PHP Form Builder doesn't match what you intended</li>
                </ul>
            </div>
        </section>

        <section id="licensing-system" class="pb-5 mb-7 has-separator">
            <h2 class="mt-lg">The licensing system</h2>
            <h3>Here's how the licensing system works:</h3>

            <p><strong>1 license = 1 domain + any subdomain</strong></p>

            <h4>Registration:</h4>
                <ul>
                    <li>
                        <h5>on production server</h5>
                        <ul>
                            <li>You have to open phpformbuilder/register.php in your browser on your main domain url and enter your email & purchase code.</li>
                        </ul>
                    </li>
                    <li>
                        <h5>on localhost</h5>
                        <ul>
                            <li>Open phpformbuilder/register.php in your browser and enter your email & purchase code.</li>
                            <li>The licensing system does not allow urls with different IP addresses.</li>
                            <li>Different IPs are not a problem, but the access URL must be unique.</li>
                            <li>virtualhost & alias allows to access your project with a unique URL.</li>
                        </ul>
                    </li>
                </ul>

            <p>When you register 2 things are done:</p>
            <ul>
                <li>a request is sent to register your copy on the licensing server</li>
                <li>the registration data is written in <span class="file-path">phpformbuilder/<em class="text-secondary">[your-domain]</em>/license.php</span></li>
            </ul>

            <p>That's why you need to register both on your localhost & prod. server.</p>
            <p class="alert alert-info has-icon">The <span class="file-path">license.php</span> content depends on your registration URL, & you must not overwrite your production <span class="file-path">license.php</span> with the localhost one.</p>

            <h4>License check system</h4>

            <p>PHP Form Builder is checking your registration in 2 different ways:</p>
            <ul>
                <li>
                    <p>A basic verification is done each time you load a form, using your <span class="file-path">license.php</span></p>
                    <p>This one generates the ugly danger message if something's wrong.</p>
            </li>
                <li>
                    <p>The real strong verification is done once a week or month on the licensing server</p>
                    <p>If you pass the verification 1 time (post your form successfully) you can be 100% sure that all is definitely ok.</p>
                </li>
            </ul>

            <p>Both will accept any subdomain, but you can't use different domain names extensions.</p>
            <p>This means that you have to buy a license for domain.xxx & another one for domain.yyy<br>& register both with their purchase number.</p>
            <p>You can then use any subdomain on both.</p>
        </section>

        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h2 id="installation-error">Installation error</h2>
                <p>If you see the message "<em>An error occurred during the registration process.</em>", or any PHP error, or white page:</p>
                <p>You just have to <a href="https://www.google.com/search?q=enable+php+curl" target="_blank" title="How to enable PHP CURL extension">enable PHP CURL extension</a>.</p>
                <p>Restart your php server, then the installer will work.</p>
            </article>
        </section>
        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h2 id="cant-connect-to-licensing-server">Can't connect to licensing server</h2>
                <p>You entered your purchase code with a trailing space.</p>
            </article>
        </section>

        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h2 id="reinstall-phpfb">Reinstall PHP Form Builder</h2>
                <p>A Regular license allows 2 installations - 1 for your localhost &amp; the other for production server.</p>
                <p>If you want to change the installation URL (domain, folder, ...) you have first to uninstall PHP Form Builder from your initial URL, then reinstall on the new one.</p>
                <p><strong>To uninstall PHP Form Builder</strong>:</p>
                <ol class="numbered">
                    <li>Open your registration URL  - <span class="file-path">phpformbuilder/register.php</span><br>You should see a message saying that <em>Your PHP Form Builder copy is already registered on this domain</em>.</li>
                    <li>Enter your purchase code & click the <em>Unregister</em> button</li>
                    <li>You can register again on a different domain / URL.</li>
                </ol>
                <p>If for any reason you can't unregister your copy &amp; want to reinstall, please <a href="https://www.miglisoft.com/#contact">contact me</a>,<br>send me your purchase code &amp; <strong>delete <span class="file-path">phpformbuilder/<em class="text-secondary">[your-domain]</em>/license.php</span> from your server</strong>.<br>I'll remove your installation license from the server then you'll be able to reinstall elsewhere.</p>
            </article>
        </section>
        <section class="pb-7">
            <article class="pb-5 mb-7 has-separator">
                <h2 id="white-page">White page / Error 500</h2>
                <p>If your page is absolutely white or returns "HTTP ERROR 500" it means <strong>you have a php error</strong>.</p>
                <p>To display error message, you have to enable php display errors.</p>
                <ol class="numbered">
                    <li>
                        <strong>Add the following code just after use statements</strong> :<br>
                        <pre class="line-numbers"><code class="language-php">&lt;?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

// add the line below to your code :
ini_set(&#039;display_errors&#039;, 1);</code></pre>
                    </li>
                    <li><strong>Refresh your page</strong>, then you'll see what error is thrown, and probably find solution in other parts of this document.<br>Once you solved your problem, <strong>remove the ini_set()</strong> line if you don't want errors to be displayed anymore.</li>
                </ol>
                <p>If the <strong>ini_set()</strong> function does not work on your server, you have to turn display_errors On in your <span class="file-path">php.ini</span></p>
            </article>
        </section>
        <section class="pb-7">
            <h2 id="warning-include_once">Warning: include_once([...]): failed to open stream: No such file or directory</h2>
            <article class="pb-5 mb-7 has-separator">
                <p>PHP Form Builder requires a single file, which is called using <strong>php include_once() function</strong> :</p>
                <pre class="line-numbers"><code class="language-php">&lt;?php
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';</code></pre>
                <p>If the path to file inside parenthesis is wrong, file is not found.</p>
                <p><strong>You've got to find the right path leading to your <span class="file-path">phpformbuilder</span> directory</strong>.</p>
                <p class="alert alert-success has-icon"><strong>To solve this, Open <a href="../phpformbuilder/server.php"><span class="file-path">../phpformbuilder/server.php</span></a> in your browser and follow the instructions.</strong></p>
                <p><strong>OR</strong> Try one of the followings, depending on your situation :</p>
                <ol class="numbered">
                    <li>If <span class="file-path">phpformbuilder</span> directory is not at the root of your project, add beginning directory(ies) to your paths :<br>
                        <pre class="line-numbers"><code class="language-php">&lt;?php

// replace "your-dir" with yours in the following line
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/your-dir/phpformbuilder/Form.php';</code></pre>
                    </li>
                    <li>Use a relative path, leading from the original file (your form) to phpformbuilder dir. You can for example try one of the followings :
                        <pre class="line-numbers"><code class="language-php">&lt;?php

// with a structure like :
// contact-form.php
// phpformbuilder/Form.php
include_once 'phpformbuilder/Form.php';

// with a structure like :
// subfolder/contact-form.php
// phpformbuilder/Form.php
include_once '../phpformbuilder/Form.php';</code></pre></li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="fatal-error">Fatal error: Class 'phpformbuilder\Form' not found</h2>
                <p>See <a href="#warning-include_once">Warning: include_once([...])</a> (same error, same solution)</p>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="mb-string">Fatal error: Call to undefined function phpformbuilder\mb_strtolower()</h2>
                <p>PHP Form Builder uses the PHP <span class="var-valur">mb_string</span> extension to send emails with the correct encoding.</p>
                <p>PHP mb_string extension allows to work with multi-bytes encoding (UTF-8, ...).</p>
                <p>PHP mb_string extension is not a default PHP extension, but is enabled on most servers.</p>
                <p>If it's not enabled on yours, you've got 2 solutions:</p>
                <ol class="numbered">
                    <li class="mb-5"><strong>(Best solution)</strong> Install/Enable PHP <span class="var-value">mb_string</span>.<br>Many explanations are available on the web to know how to proceed, and it depends on your server and system.</li>
                    <li>
                        <ol>
                            <li>Open <span class="file-path">phpformbuilder/Form.php</span> and replace all occurrences of <span class="var-value">mb_strtolower</span> with <span class="var-value">strtolower</span>.</li>
                            <li>If your PHP Form Builder version is <= 3.5.2, replace <pre><code class="language-php">$charset = mb_detect_encoding($mergedHtml);</code></pre> with: <pre><code class="language-php">charset = 'iso-8859-1';
if (function_exists('mb_detect_encoding')) {
    $charset = mb_detect_encoding($mergedHtml);
}</code></pre>You'll find your version number in comments at the beginning of phpformbuilder/Form.php</li>
                            <li><strong>Warning:</strong> you may experiment encoding issues with multi-bytes encoded characters (accents, special characters) when sending emails.</li>
                        </ol>
                    </li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="plugins-don-t-work">Plugins don't work</h2>
                <ol class="numbered">
                    <li>
                        <p>Open your browser's console (<a href="http://webmasters.stackexchange.com/questions/8525/how-to-open-the-javascript-console-in-different-browsers">instructions here</a>)</p>
                        <p><strong>You have to solve all errors you see in console</strong>. Errors probably come from your page content, not from phpformbuilder itself.</p>
                        <p>Be sure you include first jQuery, <strong>THEN</strong> Bootstrap js, <strong>THEN</strong> phpformbuilder plugins code :</p>
                        <pre class="line-numbers"><code class="language-php">&lt;!-- jQuery --&gt;
&lt;script src=&quot;//code.jquery.com/jquery.js&quot;&gt;&lt;/script&gt;
&lt;!-- Bootstrap JavaScript --&gt;
&lt;script src=&quot;//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js&quot;&gt;&lt;/script&gt;
&lt;?php
    $form-&gt;printIncludes(&#039;js&#039;);
    $form-&gt;printJsCode();
?&gt;</code></pre>
                        <p>&nbsp;</p>
                    </li>
                    <li>
                        <p><strong>PHP Form Builder is optimized for fast loading.</strong></p>
                        <p>This means that all the required plugins files (CSS &amp; Javascript) are <strong>automatically minified &amp; concacenated</strong>.</p>
                        <p>When you make changes to the form these files are automatically regenerated.</p>
                        <p>The minified/concatendated files are located in <code class="language-php">phpformbuilder/plugins/min/[css|js]</code></p>
                        <p><strong>You can always safely remove the css &amp; js files located in these 2 folders</strong>.<br>They'll be regenerated and refreshed, this can in some cases solve cache issues.</p>
                        <p><strong>When you're in development, you can call the unminified unconcatenated files this way:</strong></p>
                        <pre class="line-numbers"><code class="language-php">// This will load the unminified unconcatenated files
$form->setMode('development');</code></pre>
                    </li>
                    <li>
                        <p>In a few cases, your server may not be correctly configured. Consequence is that the plugins URLs are wrong.</p>
                        <p>Solution is to set the URL to plugins directory manually:</p>
                        <pre class="line-numbers"><code class="language-php">// Set URL to match your plugins directory
$form->setPluginsUrl('http://phpformbuilder/plugins/');</code></pre>
                    </li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="i-do-not-receive-the-emails-sent">I do not receive the emails sent</h2>
                <ol class="numbered">
                    <li>Check that the <strong>sender_email</strong> address is from your domain (<strong>anything@your-domain.com</strong>).<br>When you send emails <strong>you must always use an email address from your domain as the sender</strong>.<br>Otherwise you will not pass the spam filters, which will assume that you have usurped an identity.<br><br>You can add a <strong>reply_to_email</strong> option to set whom the reply will be sent.</li>
                    <li>Edit phpformbuilder/mailer/email-sending-test.php:<br>Replace the sender email address L.16 with an email address from your domain.<br>Open the file in your browser and fill-in the form to send an email.<br>If you still don't receive the message, contact your hosting provider and ask him to setup php to send email with the function <strong>mail()</strong>.</li>
                </ol>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="css-issues">CSS issues</h2>
                <p>Included templates use a <strong>custom version of Bootstrap's css</strong>. You'll find it in <code>phpformbuilder/templates/assets/stylesheets/bootstrap.min.css</code>.</p>
                <p>Set the correct path from your form to this css :</p>
                <pre class="line-numbers"><code class="language-php">&lt;!-- Bootstrap CSS - Change path with your own --&gt;
&lt;link href=&quot;assets/assets/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot;&gt;</code></pre>
                <p>... Or replace with Bootstrap CDN :</p>
                <pre class="line-numbers"><code class="language-php">&lt;!-- Bootstrap CSS CDN --&gt;
&lt;link href=&quot;//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot;&gt;</code></pre>
            </article>
            <article class="pb-5 mb-7 has-separator">
                <h2 id="can-t-submit-form">Can't Submit form (using jQuery validation plugin)</h2>
                <p>jQuery validation plugin is complex and can have unexpected behaviors if it encounters configuration issues or malformed html.</p>
                <p>To solve this : </p>
                <ol class="numbered">
                    <li>Don't use any input, button or other form element named "submit". It's not compatible with jQuery validation (reserved name).</li>
                    <li>Validate your code <a href="https://validator.w3.org/">W3C validator</a></li>
                    <li>Open your browser's console (F12) and look for errors.</li>
                    <li>Open <span class="file-path">phpformbuilder/plugins-config/formvalidation.xml</span> and use <code class="language-php">console.log</code> (un-comment) to find out what's going on</li>
                </ol>
            </article>
        </section>
    </div>
    <!-- container-->
    <?php require_once 'inc/js-includes.php'; ?>
</body>
</html>
