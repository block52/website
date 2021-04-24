<?php
@ini_set('display_errors', 1);

/*==========================================================
=            Protection against unauthorized access            =
==========================================================*/

/*  TO AUTHORIZE ACCESS:
                -   REPLACE false WITH true LINE 15
                -   OPEN (OR REFRESH) THIS FILE IN YOUR BROWSER

    IMPORTANT:  WHEN YOU HAVE FINISHED REPLACE true WITH false on LINE 15 TO LOCK THE ACCESS.
                THIS FILE MUST NOT STAY UNLOCKED ON YOUR PRODUCTION SERVER;
*/
define('AUTHORIZE', false);

/*=====  End of Protection against unauthorized access  ======*/

if (AUTHORIZE === true) {
    $form_class_path = dirname(__FILE__);
    $plugins_path = $form_class_path . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR;

    // reliable document_root (https://gist.github.com/jpsirois/424055)
    $root_path = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);

    // reliable document_root with symlinks resolved
    $info = new \SplFileInfo($root_path);

    // var_dump($info);
    $real_root_path = $info->getRealPath();

    // sanitize directory separator
    $form_class_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $form_class_path);
    $real_root_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $real_root_path);

    $plugins_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . ltrim(str_replace(array($real_root_path, DIRECTORY_SEPARATOR), array('', '/'), $plugins_path), '/');

    $current_dir = str_replace(basename(__FILE__), '', $_SERVER['SCRIPT_NAME']);
    $phpformbuilder_include_code = 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'' . $current_dir . 'Form.php\';';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Php Form Builder - Help file for include and other paths</title>
    <meta name="description" content="Php Form Builder - Help file for include and other paths">
    <meta name="author" content="Gilles Migliori">
    <meta name="copyright" content="Gilles Migliori">
    <meta name="robots" content="noindex">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <style>.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#ffc107;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}.mb-5{margin-bottom:3rem!important}.ml-5{margin-left:3rem!important}.text-white{color:#fff!important}.bg-red{background-color:#fc4848!important}.bg-red{color:#fff}*,*::before,*::after{-webkit-box-sizing:border-box;box-sizing:border-box}section{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:.9375rem;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1,h2,h3{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}dl{margin-top:0;margin-bottom:1rem}dt{font-weight:500}dd{margin-bottom:.5rem;margin-left:0}strong{font-weight:bolder}pre,code{font-family:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto}h1,h2,h3{margin-bottom:.5rem;font-weight:500;line-height:1.2}h1{font-size:2.5rem}h2{font-size:1.875rem}h3{font-size:1.64063rem}.lead{font-size:1.25rem;font-weight:300}code{font-size:87.5%;color:#e83e8c;word-break:break-word}pre{display:block;font-size:87.5%;color:#212529}pre code{font-size:inherit;color:inherit;word-break:normal}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}@media (min-width:768px){.container{max-width:720px}}@media (min-width:992px){.container{max-width:960px}}@media (min-width:1200px){.container{max-width:1140px}}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-danger{color:#832525;background-color:#fedada;border-color:#fecccc}.mb-5{margin-bottom:3rem!important}.ml-5{margin-left:3rem!important}.mb-6{margin-bottom:6.25rem!important}.text-white{color:#fff!important}@media print{*,*::before,*::after{text-shadow:none!important;-webkit-box-shadow:none!important;box-shadow:none!important}pre{white-space:pre-wrap!important}pre{border:1px solid #8c8476;page-break-inside:avoid}p,h2,h3{orphans:3;widows:3}h2,h3{page-break-after:avoid}body{min-width:992px!important}.container{min-width:992px!important}}.var-value{margin-right:0.25rem!important}.var-value{margin-left:0.25rem!important}h3{margin-bottom:1.5rem!important}.mb-5,h2{margin-bottom:3rem!important}.ml-5{margin-left:3rem!important}pre>code[class*='language']{padding-right:0!important}pre>code[class*='language']{padding-left:0!important}code[class*='language']{padding-right:0.25rem!important}code[class*='language']{padding-left:0.25rem!important}.text-white{color:#fff!important}h1{color:#007bff!important}h1{color:#007bff!important}.bg-red{background-color:#fc4848!important}.bg-red{color:#fff}.var-value{margin-right:0.25rem!important}.var-value{margin-left:0.25rem!important}h3{margin-bottom:1.5rem!important}.mb-5,h2{margin-bottom:3rem!important}.ml-5{margin-left:3rem!important}.mb-6{margin-bottom:6.25rem!important}pre>code[class*='language']{padding-right:0!important}pre>code[class*='language']{padding-left:0!important}code[class*='language']{padding-right:0.25rem!important}code[class*='language']{padding-left:0.25rem!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}h1{color:#0e73cc!important}.bg-red{background-color:#fc4848!important}.bg-red{color:#fff}.has-icon{position:relative}.has-icon.alert{padding-left:70px}.has-icon.alert:before{padding:13px 0 0 13px;content:" "}.has-icon:before{position:absolute;top:0;left:0;display:inline-block;width:50px;height:100%;border-radius:3px 0 0 3px;background-repeat:no-repeat;background-position:center center}.has-icon.alert:after{position:absolute;top:calc(50% - 6px);left:50px;width:0;height:0;content:" ";border-width:6px 0 6px 6px;border-style:solid}.has-icon.alert-danger:before{background-color:#fc4848;background-image:url("data:image/svg+xml,%3Csvg aria-hidden='true' data-fa-processed='' data-prefix='fas' data-icon='exclamation-circle' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='svg-inline--fa fa-exclamation-circle fa-w-16'%3E%3Cpath fill='%23fff' d='M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z' class=''%3E%3C/path%3E%3C/svg%3E");background-size:30%}.has-icon.alert-danger:after{border-color:transparent transparent transparent #fc4848}.alert{position:relative;border:none}.alert :first-child{margin-top:0}body{counter-reset:section}h1,h2,h3{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h2{font-weight:300;color:#8c8476;border-bottom:1px solid #8c8476}h3{font-weight:300;color:#a9a398}h3{font-variant:small-caps}p.lead{font-weight:400;color:#696359}pre,code,code[class*='language']{font-size:.75rem}strong{font-weight:500}section>h2{padding:1rem;border-bottom:1px solid #ddd}section>h3{white-space:nowrap}section>h3:before,section>h3:after{content:'';display:inline-block;width:8px;height:8px;background:#ffc107;margin-bottom:3px}section>h3:before{margin-right:10px}section>h3:after{margin-left:12px}dt{font-weight:500}dl.dl-horizontal{display:table;table-layout:fixed;margin-bottom:60px}dl.dl-horizontal dt,dl.dl-horizontal dd{width:auto;overflow:visible}dl.dl-horizontal dt{display:table-cell;text-align:right;white-space:nowrap;font-weight:500;padding:7px 20px 7px 0}dl.dl-horizontal dd{display:table-cell;padding:7px 0}dl.dl-horizontal dd.line-break{display:table-row}@media (min-width:936px){.dl-horizontal dt{min-width:220px}}.var-value{font-size:93.33333333333333%}.var-value{display:inline-block;padding:.15em .5em;font-weight:400;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline}.var-value.var-value{border-radius:.2rem;background:#e2e0dd;color:#151412}code[class*=language-],pre[class*=language-]{position:relative;color:#ccc;background:none;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;text-align:left;white-space:pre;word-spacing:normal;word-break:normal;word-wrap:normal;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;-webkit-hyphens:none;-ms-hyphens:none;hyphens:none}pre[class*=language-]{padding:1em;margin:.5em 0;overflow:auto;border-radius:.25rem!important}:not(pre)>code[class*=language-],pre[class*=language-]{background:#2d2d2d}:not(pre)>code[class*=language-]{padding:.1em;border-radius:.25rem!important;white-space:normal}.token.comment{color:#999}.token.punctuation{color:#ccc}.token.function{color:#f08d49}.token.constant{color:#f8c555}.token.keyword{color:#cc99cd}.token.string{color:#7ec699}.token.operator{color:#67cdcc}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-warning{color:#856404;background-color:#fff3cd;border-color:#ffeeba}.has-icon.alert-warning:before{background-color:#ffc107;background-image:url("data:image/svg+xml,%3Csvg aria-hidden='true' data-fa-processed='' data-prefix='fas' data-icon='exclamation-triangle' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' class='svg-inline--fa fa-exclamation-triangle fa-w-18'%3E%3Cpath fill='%23fff' d='M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z' class=''%3E%3C/path%3E%3C/svg%3E");background-size:33.75%}.has-icon.alert-warning:after{border-color:transparent transparent transparent #ffc107}</style>
</head>
<body>

    <div class="container">

        <h1>Php Form Builder - Help file for include and other paths</h1>
        <?php if (AUTHORIZE === true) { ?>
        <section class="mb-6">
            <h2>PHP Version</h2>
            <p class="lead ml-5">Your PHP Version is <?php echo phpversion(); ?></p>
        </section>
        <section class="mb-6">
            <h2>Solve Error 500</h2>
            <p class="lead ml-5">The correct include statement to include <strong>Form.php</strong> is the following:</p>
            <pre class="ml-5 mb-5"><code class="language-php"><?php echo $phpformbuilder_include_code; ?></code></pre>
            <?php if ($phpformbuilder_include_code != 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/phpformbuilder/Form.php\';') { ?>
            <hr>
            <p class="ml-5 mb-5"><strong>You have to replace the following code:<br> <code class="language-php">include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';</code><br>in your forms - the template files or your own forms php files - with the correct include statement shown above.</strong></p>
            <?php } else { ?>
                <p class="ml-5 mb-5"><strong>This is the default path used in all templates. You've got nothing to change.</strong></p>
            <?php } // end if ?>
            <p class="alert alert-danger has-icon ml-5">Don't forget to revert <strong class="var-value bg-red text-white">true</strong> to <strong class="var-value bg-red text-white">false</strong> Line 15 to protect this file against unauthorized access</p>
        </section>
        <section class="mb-6">
            <h3>The variables below provide some useful debugging information about your server configuration</h3>
            <dl class="dl-horizontal">
                <dt>$plugins_path</dt>
                <dd><code class="language-php"><?php echo $plugins_path; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$_SERVER['SCRIPT_NAME']</dt>
                <dd><code class="language-php"><?php echo $_SERVER['SCRIPT_NAME']; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$_SERVER['SCRIPT_FILENAME']</dt>
                <dd><code class="language-php"><?php echo $_SERVER['SCRIPT_FILENAME']; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$root_path</dt>
                <dd><code class="language-php"><?php echo $root_path; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$real_root_path</dt>
                <dd><code class="language-php"><?php echo $real_root_path; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$form_class_path</dt>
                <dd><code class="language-php"><?php echo $form_class_path; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$real_root_path</dt>
                <dd><code class="language-php"><?php echo $real_root_path; ?></code></dd>
                <dd class="line-break"></dd>
                <dt>$plugins_url</dt>
                <dd><code class="language-php"><?php echo $plugins_url; ?></code></dd>
                <dd class="line-break"></dd>
            </dl>
        </section>
        <?php } else { ?>
        <p class="alert alert-warning has-icon">This file is protected against unauthorized access.</p>
        <p><strong>To allow access and display information, open this file in your code editor and replace <strong class="var-value">false</strong> with <strong class="var-value">true</strong> Line 15.</p>
        <?php } // end if ?>
    </div>
</body>
</html>
