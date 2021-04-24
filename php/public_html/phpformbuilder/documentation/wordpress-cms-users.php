<!doctype html>
<html lang="en">
<head>
    <?php
        $meta = array(
            'title'       => 'PHP Form Builder for Wordpress and others CMS',
            'description' => 'How to build PHP forms for Wordpress, Joomla, Drupal and others CMS with PHP Form Builder',
            'canonical'   => 'https://www.phpformbuilder.pro/documentation/wordpress-cms-users.php',
            'screenshot'  => 'wordpress-cms-users.png'
        );
        include_once 'inc/page-head.php';
    ?>
    <style type="text/css">
        @-ms-viewport{width:device-width}h1{margin-top:0;margin-bottom:.5rem}h1{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}@font-face{font-family:icomoon;font-display: swap;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-display: swap;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-display: swap;font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}h1{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}p{margin-top:0;margin-bottom:1rem}.lead{font-size:1.25rem;font-weight:300}p.lead{font-weight:400;color:#696359}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}nav,section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2{margin-top:0;margin-bottom:.5rem}ul{margin-top:0;margin-bottom:1rem}small{font-size:80%}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}h1,h2{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}h2{font-size:30px}small{font-size:80%;font-weight:400}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:15px;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.form-control{-webkit-transition:none;-o-transition:none;transition:none}}.form-control::-ms-expand{background-color:transparent;border:0}.form-control::-webkit-input-placeholder{color:#6c757d;opacity:1}.form-control:-ms-input-placeholder{color:#6c757d;opacity:1}.form-control::-ms-input-placeholder{color:#6c757d;opacity:1}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-danger{color:#fff;background-color:#fc4848;border-color:#fc4848;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.nav-pills .nav-link{border-radius:0}.nav-pills .nav-link.active{color:#fff;background-color:#007bff}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.d-inline-block{display:inline-block!important}.mb-5{margin-bottom:3rem!important}.bg-dark{background-color:#343a40!important}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}h1{color:#007bff!important}.text-danger{color:#dc3545!important}.bg-dark{background-color:#23211e!important}.bg-white{background-color:#fff!important}.btn .icon-circle,.d-inline-block{display:inline-block!important}.d-flex{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.flex-column{-webkit-box-orient:vertical!important;-webkit-box-direction:normal!important;-ms-flex-direction:column!important;flex-direction:column!important}.flex-grow-1{-webkit-box-flex:1!important;-ms-flex-positive:1!important;flex-grow:1!important}.justify-content-between{-webkit-box-pack:justify!important;-ms-flex-pack:justify!important;justify-content:space-between!important}.align-items-center{-webkit-box-align:center!important;-ms-flex-align:center!important;align-items:center!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.w-100{width:100%!important}.mr-1{margin-right:.25rem!important}.ml-2{margin-left:.5rem!important}.mr-3{margin-right:1rem!important}.mb-4{margin-bottom:1.5rem!important}.mb-5,h2{margin-bottom:3rem!important}.mb-7{margin-bottom:12.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.pt-1{padding-top:.25rem!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-2{padding-left:.5rem!important}.p-4{padding:1.5rem!important}.pt-4{padding-top:1.5rem!important}.pb-4{padding-bottom:1.5rem!important}.ml-auto{margin-left:auto!important}.text-center{text-align:center!important}.text-white{color:#fff!important}.text-muted{color:#6c757d!important}h1{color:#0e73cc!important}.text-danger{color:#fc4848!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}#navbar-left-wrapper~.container{padding-left:230px}@media (min-width:992px){#navbar-left-wrapper{display:block}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}#navbar-left-wrapper~.container{padding-left:15px}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}#navbar-left{z-index:100;position:relative;width:100%;color:#fff;background-color:#23211e;-webkit-box-shadow:0 1px 0 #030303;box-shadow:0 1px 0 #030303}#navbar-left li{margin:0;padding:0}#navbar-left>li>a{padding:12px 20px 12px 18px;border-top:1px solid #3e3b36;border-bottom:1px solid #0d0c0b;text-shadow:1px 1px 0 #3e3b36;color:#fff;background-color:#312e2a;font-size:13px;font-weight:400}#navbar-left>li>a.active{background-color:#a93030}[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}html{position:relative;min-height:100%}body{counter-reset:section}h1,h2{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h1 small{font-size:1.3125rem;font-weight:300;line-height:1;margin-left:.75rem}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}section>h2{padding:1rem;border-bottom:1px solid #ddd}.btn .icon-circle{width:24px;height:24px;line-height:24px;border-radius:50%}.dmca-badge{min-height:100px}
    </style>
    <?php require_once 'inc/css-includes.php'; ?>
    <style type="text/css">.iframe-wrapper{position:relative;padding-bottom:56.25%;padding-top:25px;height:0}.iframe-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%}</style>
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
            <li class="nav-item"><a class="nav-link" href="#installation">Installation</a></li>
            <li class="nav-item"><a class="nav-link" href="#ajax-forms-folder">Ajax Forms Folder</a></li>
            <li class="nav-item"><a class="nav-link" href="#create-your-form">Create your form</a></li>
            <li class="nav-item"><a class="nav-link" href="#add-the-form-to-your-page">Add the form to your page</a></li>
            <li class="nav-item"><a class="nav-link" href="#live-examples">Live examples</a></li>
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

        <h1 id="home" class="mb-4">Wordpress, Joomla, Drupal<br><small class="text-muted">and others CMS</small></h1>
        <section>
            <div class="iframe-wrapper">
                <iframe src="https://www.youtube.com/embed/yDoZN1LjJOA" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
            </div>
            <h2 class="mb-5">How to build forms for Wordpress, Joomla, Drupal and others CMS with PHP Form Builder</h2>
            <p class="lead">PHP forms can be very easily integrated into any HTML page with the use of Ajax.</p>
            <p>This method is suitable for any CMS: Wordpress, Joomla, Drupal or other.</p>
            <p class="mb-5">No additional plugin is usually required, just add Javascript code in the body of your page.</p>
            <p>Here's how it works:</p>
        </section>

        <section class="mb-6">
            <h3 id="installation" class="numbered-title">Installation</h3>
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
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <p>PHP Form Builder's package includes the Form Builder itself, the documentation and all the templates.</p>
            <p class="alert alert-warning has-icon">You don't have to upload all the files and folders on your production server.</p>
            <p><strong>Documentation and Templates are available online at <a href="https://www.phpformbuilder.pro/">https://www.phpformbuilder.pro/</a>.<br>There's no need to upload them on your production server.</strong></p>
            <p>More details about folders, files and required files on production server here: <a href="/index.html#package-structure">../index.html#package-structure</a></p>
        </section>
        <section class="mb-6">
            <h3 id="ajax-forms-folder" class="numbered-title">Ajax Forms Folder</h3>
            <p><strong>Create a new directory named <span class="file-path">ajax-forms</span> at the root of your project.</strong></p>
            <p class="small">You can choose another name and another location, in which case you'll just have to change the URL called with Ajax in step 4.</p>
        </section>
        <section class="mb-6">
            <h3 id="create-your-form" class="numbered-title">Create your form</h3>
            <p><strong>Create your form in a new PHP file and save it into your <span class="file-path">/ajax-forms</span> folder.</strong></p>
            <div class="alert alert-info has-icon">
                <p>You can see example of such form files in templates:</p>
                <ul>
                    <li>templates/bootstrap-3-forms/ajax-forms/contact-form-1.php</li>
                    <li>templates/bootstrap-4-forms/ajax-forms/contact-form-1.php</li>
                    <li>templates/foundation-forms/ajax-forms/contact-form-1.php</li>
                    <li>templates/material-forms/ajax-forms/contact-form-1.php</li>
                </ul>
            </div>
        </section>
        <section class="mb-6">
            <h3 id="add-the-form-to-your-page" class="numbered-title">Add the form to your page</h3>
            <div class="alert alert-success has-icon mb-4">
                <p><strong>Your CMS has to allow <code class="language-php">&lt;script&gt;&lt;/script&gt;</code> tags on pages/posts.</strong></p>
                <p>Many plugins for Wordpress, Joomla, Drupal allowing the use of scripts on pages and posts are available for free.</p>
            </div>
            <ul>
                <li class="mb-4">Open your CMS page/post editor</li>
                <li class="mb-4">Add a block container where you want your form to be displayed: <pre class="line-numbers"><code class="language-php">&lt;div id=&quot;ajax-form&quot;&gt;&lt;/div&gt;</code></pre></li>
                <li class="mb-4">Add the following Javascript code after your container ;<br>replace <span class="badge badge-light">contact-form-1.php</span> in the following code with the name of your form<pre class="line-numbers"><code class="language-php">&lt;!-- Ajax form loader --&gt;

&lt;script type=&quot;text/javascript&quot;&gt;
var $head= document.getElementsByTagName(&apos;head&apos;)[0],
    target = &apos;#ajax-form&apos;;

var loadData = function(data, index) {
    if (index &lt;= $(data).length) {
        var that = $(data).get(index);
        if ($(that).is(&apos;script&apos;)) {
            // output script
            var script = document.createElement(&apos;script&apos;);
            script.type = &apos;text/javascript&apos;;
            if (that.src != &apos;&apos;) {
                script.src = that.src;
                script.onload = function() {
                    loadData(data, index + 1);
                };
                $head.append(script);
            } else {
                script.text = that.text;
                $(&apos;body&apos;).append(script);
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
        url: &apos;ajax-forms/contact-form-1.php&apos;,
        type: &apos;GET&apos;
    }).done(function(data) {
        $.holdReady(true);
        loadData(data, 0);
    }).fail(function(data, statut, error) {
        console.log(error);
    });
});
&lt;/script&gt;</code></pre></li>
            </ul>
        </section>
        <section class="mb-6">
            <h3 id="live-examples">Live examples</h3>
            <ul>
                <li>
                    <a href="../templates/bootstrap-3-forms/ajax-loaded-contact-form-1.html">bootstrap-3-forms/ajax-loaded-contact-form-1.html</a>
                </li>
                <li>
                    <a href="../templates/bootstrap-4-forms/ajax-loaded-contact-form-1.html">bootstrap-4-forms/ajax-loaded-contact-form-1.html</a>
                </li>
                <li>
                    <a href="../templates/foundation-forms/ajax-loaded-contact-form-1.html">foundation-forms/ajax-loaded-contact-form-1.html</a>
                </li>
                <li>
                    <a href="../templates/material-forms/ajax-loaded-contact-form-1.html">material-forms/ajax-loaded-contact-form-1.html</a>
                </li>
            </ul>
        </section>
    </div>
    <?php require_once 'inc/js-includes.php'; ?>
</body>
</html>
