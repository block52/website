<?php
$dir_path = 'https://www.phpformbuilder.pro/documentation/';
if ($_SERVER['HTTP_HOST'] != 'www.phpformbuilder.pro') {
    if (strpos($_SERVER['REQUEST_URI'], 'templates/') || strpos($_SERVER['REQUEST_URI'], 'phpformbuilder/') || strpos($_SERVER['REQUEST_URI'], 'drag-n-drop-form-generator/')) {
        $dir_path = '../documentation/';
    } elseif (!strpos($_SERVER['REQUEST_URI'], 'documentation')) {
        $dir_path = 'documentation/';
    } else {
        $dir_path = '';
    }
}
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    ?>
    <link rel="stylesheet" href="<?php echo $dir_path; ?>assets/stylesheets/pace-theme-minimal.min.css">
    <link rel="stylesheet" href="<?php echo $dir_path; ?>assets/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $dir_path; ?>assets/stylesheets/project.css">
<?php
} else {
?>
    <link rel="preload" href="<?php echo $dir_path; ?>assets/stylesheets/all.min.css" as="style" onload="this.rel='stylesheet'">
    <noscript><link type="text/css" media="screen" rel="stylesheet" href="<?php echo $dir_path; ?>assets/stylesheets/all.min.css" /></noscript>
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
<?php
}
?>
