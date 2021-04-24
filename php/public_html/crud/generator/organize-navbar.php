<?php
use phpformbuilder\Form;

error_reporting('E_ALL');
ini_set('display_errors', 1);

if (!file_exists('../conf/conf.php')) {
    exit('Configuration file not found (8)');
}
include_once '../conf/conf.php';
session_start();

// lock access on production server
if (ENVIRONMENT !== 'localhost' && GENERATOR_LOCKED === true) {
    include_once 'inc/protect.php';
}

$nav_data = array();
$db_data  = array();
if (file_exists(ADMIN_DIR . 'crud-data/nav-data.json') && file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
    $json      = file_get_contents(ADMIN_DIR . 'crud-data/nav-data.json');
    $nav_data = json_decode($json, true);

    $json      = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
    $db_data = json_decode($json, true);

    if (!is_null($nav_data)) {
        $has_wrong_table_data = false;
        $list = '<ol id="sortable-nav">';
        foreach ($nav_data as $root => $navcat) {
            $tables_count = count($navcat['tables']);

            // Sidebar categories items
            if ($tables_count > 0) {
                $list .= '<li class="parent border border-primary-900 d-flex bg-white px-3 py-2 m-3">';
                $list .= '<div class="d-flex flex-column align-content-stretch">';
                $list .= '  <div class="editable">';
                $list .= '      <p class="small mb-1">' . CLICK_TO_EDIT . '</p>';
                $list .= '      <p class="cat-name text-semibold px-3 py-2">' . $navcat['name'] . '</p>';
                $list .= '  </div>';
                $list .= '  <div class="mt-auto mb-1">';
                $list .= '      <button type="btn" class="btn btn-primary btn-sm btn-block drag-me"><i class="fas fa-arrows-alt mr-3"></i>' . DRAG_ME . '</button>';
                $list .= '  </div>';
                $list .= '</div>';
                $list .= '<ol>';
                for ($i=0; $i < $tables_count; $i++) {
                    $table       = $navcat['tables'][$i];
                    // if the table structure is not registered in db_data
                    // (it may have been reset or the table may have been removed, or anything)
                    if (!isset($db_data[$table]) || !isset($db_data[$table]['table_label'])) {
                        $list .= '<li class="child border d-flex justify-content-between bg-slate-100 px-1 py-1 m-1 disabled" id="' . $table . '"><span class="text-danger">' . $table . ':' . WRONG_TABLE_DATA . '<span class="font-weight-bold">*</strong></span></li>';
                        $has_wrong_table_data = true;
                    } else {
                        $is_disabled = $navcat['is_disabled'][$i];
                        $title = $db_data[$table]['table_label'];
                        $icon  = $db_data[$table]['icon'];
                        $disabled_class = '';
                        if ($is_disabled == 'true') {
                            $disabled_class = ' disabled';
                        }
                        $list .= '<li class="child border d-flex justify-content-between bg-slate-100 px-1 py-1 m-1' . $disabled_class . '" id="' . $table . '"><p class="drag-me mb-0 pr-5"><span class="badge badge-light mr-3 disable-icon" title="' . REMOVE_FROM_NAVBAR . '"><i class="fas fa-minus-circle text-danger mr-2"></i>' . REMOVE_FROM_NAVBAR . '</span><span class="badge badge-light mr-3"><i class="fas fa-arrows-alt"></i></span>' . $title . '</p><input type="text" class="iconpicker" value="' . $icon . '" name="' . $table . '-icon" id="' . $table . '-icon" /></li>';
                    }
                }
                $list .= '</ol>';
            }
            $list .= '</li>';
        }
        $list .= '</ol>';
        if ($has_wrong_table_data == true) {
            $list .= WRONG_TABLE_DATA_MESSAGE;
        }
    } else {
        // if empty
        $list = '<p class="alert alert-warning text-center my-5 has-icon">Your navbar is empty</p>';
    }
    $new_list_html = '<li class="parent border border-primary-900 d-flex bg-white px-3 py-2 m-3">';
    $new_list_html .= '<div class="d-flex flex-column align-content-stretch">';
    $new_list_html .= '  <div class="editable">';
    $new_list_html .= '      <p class="small mb-1">' . CLICK_TO_EDIT . '</p>';
    $new_list_html .= '      <p class="cat-name text-semibold px-3 py-2">' . CLICK_TO_EDIT . '</p>';
    $new_list_html .= '  </div>';
    $new_list_html .= '  <div class="mt-auto mb-1">';
    $new_list_html .= '      <button type="btn" class="btn btn-primary btn-sm btn-block drag-me"><i class="fas fa-arrows-alt mr-3"></i>' . DRAG_ME . '</button>';
    $new_list_html .= '  </div>';
    $new_list_html .= '</div>';
    $new_list_html .= '<ol></ol>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Generator - <?php echo ORGANIZE_ADMIN_NAVBAR; ?></title>
    <meta name="description" content="Organize your admin panel navbar: create categories, drag and drop your elements and add personalized icons - PHP CRUD Generator">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/ripple.min.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/fa-svg-with-js.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/stylesheets/generator.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/lib/jquery-sortable/jquery-sortable.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/lib/font-icon-picker/jquery.fonticonpicker.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/lib/font-icon-picker/jquery.fonticonpicker.crud.min.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-5">
                <h1 class="mb-4">PHP CRUD Generator</h1>
                <div class="card">
                    <div class="card-header"><h2 class="card-title h4 text-semibold mb-0"><?php echo ORGANIZE_ADMIN_NAVBAR; ?></h2></div>
                    <div class="card-body">
                        <div id="result"></div>
                        <p class="text-semibold"><?php echo DRAG_AND_DROP_HELP; ?></p>
                        <?php
                        if (DEMO === true) {
                            ?>
                                <div class="alert alert-info has-icon">
                                    <p class="h4 mb-0">The Navbar module is disabled in this demo.</p>
                                </div>
                            <?php
                        }
                        ?>
                        <button type="button" id="add-category-btn" class="btn btn-sm btn-primary ml-5"><?php echo ADD_CATEGORY; ?><i class="<?php echo ICON_PLUS; ?> position-right"></i></button>
                        <?php
                            echo $list;
                        ?>
                        <div class="text-center mt-4">
                            <button type="button" id="save-changes-btn" class="btn btn-primary"><?php echo SAVE_CHANGES; ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/pace.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/ripple.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/fontawesome-all.min.js"></script>
    <script type="text/javascript" defer src="<?php echo GENERATOR_URL; ?>generator-assets/lib/jquery-sortable/jquery-sortable-min.js"></script>
    <script type="text/javascript" defer src="<?php echo GENERATOR_URL; ?>generator-assets/lib/font-icon-picker/jquery.fonticonpicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.iconpicker').fontIconPicker({
                iconsPerPage : 60,
                theme: 'fip-bootstrap',
                source: {"Accessibility":["fab fa-accessible-icon","fas fa-american-sign-language-interpreting","fas fa-assistive-listening-systems","fas fa-audio-description","fas fa-blind","fas fa-braille","fas fa-closed-captioning","far fa-closed-captioning","fas fa-deaf","fas fa-low-vision","fas fa-phone-volume","fas fa-question-circle","far fa-question-circle","fas fa-sign-language","fas fa-tty","fas fa-universal-access","fas fa-wheelchair"],"Arrows":["fas fa-angle-double-down","fas fa-angle-double-left","fas fa-angle-double-right","fas fa-angle-double-up","fas fa-angle-down","fas fa-angle-left","fas fa-angle-right","fas fa-angle-up","fas fa-arrow-alt-circle-down","far fa-arrow-alt-circle-down","fas fa-arrow-alt-circle-left","far fa-arrow-alt-circle-left","fas fa-arrow-alt-circle-right","far fa-arrow-alt-circle-right","fas fa-arrow-alt-circle-up","far fa-arrow-alt-circle-up","fas fa-arrow-circle-down","fas fa-arrow-circle-left","fas fa-arrow-circle-right","fas fa-arrow-circle-up","fas fa-arrow-down","fas fa-arrow-left","fas fa-arrow-right","fas fa-arrow-up","fas fa-arrows-alt","fas fa-arrows-alt-h","fas fa-arrows-alt-v","fas fa-caret-down","fas fa-caret-left","fas fa-caret-right","fas fa-caret-square-down","far fa-caret-square-down","fas fa-caret-square-left","far fa-caret-square-left","fas fa-caret-square-right","far fa-caret-square-right","fas fa-caret-square-up","far fa-caret-square-up","fas fa-caret-up","fas fa-cart-arrow-down","fas fa-chart-line","fas fa-chevron-circle-down","fas fa-chevron-circle-left","fas fa-chevron-circle-right","fas fa-chevron-circle-up","fas fa-chevron-down","fas fa-chevron-left","fas fa-chevron-right","fas fa-chevron-up","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-download","fas fa-exchange-alt","fas fa-expand-arrows-alt","fas fa-external-link-alt","fas fa-external-link-square-alt","fas fa-hand-point-down","far fa-hand-point-down","fas fa-hand-point-left","far fa-hand-point-left","fas fa-hand-point-right","far fa-hand-point-right","fas fa-hand-point-up","far fa-hand-point-up","fas fa-hand-pointer","far fa-hand-pointer","fas fa-history","fas fa-level-down-alt","fas fa-level-up-alt","fas fa-location-arrow","fas fa-long-arrow-alt-down","fas fa-long-arrow-alt-left","fas fa-long-arrow-alt-right","fas fa-long-arrow-alt-up","fas fa-mouse-pointer","fas fa-play","fas fa-random","fas fa-recycle","fas fa-redo","fas fa-redo-alt","fas fa-reply","fas fa-reply-all","fas fa-retweet","fas fa-share","fas fa-share-square","far fa-share-square","fas fa-sign-in-alt","fas fa-sign-out-alt","fas fa-sort","fas fa-sort-alpha-down","fas fa-sort-alpha-up","fas fa-sort-amount-down","fas fa-sort-amount-up","fas fa-sort-down","fas fa-sort-numeric-down","fas fa-sort-numeric-up","fas fa-sort-up","fas fa-sync","fas fa-sync-alt","fas fa-text-height","fas fa-text-width","fas fa-undo","fas fa-undo-alt","fas fa-upload"],"Audio & Video":["fas fa-audio-description","fas fa-backward","fas fa-circle","far fa-circle","fas fa-closed-captioning","far fa-closed-captioning","fas fa-compress","fas fa-eject","fas fa-expand","fas fa-expand-arrows-alt","fas fa-fast-backward","fas fa-fast-forward","fas fa-file-audio","far fa-file-audio","fas fa-file-video","far fa-file-video","fas fa-film","fas fa-forward","fas fa-headphones","fas fa-microphone","fas fa-microphone-slash","fas fa-music","fas fa-pause","fas fa-pause-circle","far fa-pause-circle","fas fa-phone-volume","fas fa-play","fas fa-play-circle","far fa-play-circle","fas fa-podcast","fas fa-random","fas fa-redo","fas fa-redo-alt","fas fa-rss","fas fa-rss-square","fas fa-step-backward","fas fa-step-forward","fas fa-stop","fas fa-stop-circle","far fa-stop-circle","fas fa-sync","fas fa-sync-alt","fas fa-undo","fas fa-undo-alt","fas fa-video","fas fa-volume-down","fas fa-volume-off","fas fa-volume-up","fab fa-youtube"],"Business":["fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-archive","fas fa-balance-scale","fas fa-birthday-cake","fas fa-book","fas fa-briefcase","fas fa-building","far fa-building","fas fa-bullhorn","fas fa-bullseye","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-certificate","fas fa-chart-area","fas fa-chart-bar","far fa-chart-bar","fas fa-chart-line","fas fa-chart-pie","fas fa-clipboard","far fa-clipboard","fas fa-coffee","fas fa-columns","fas fa-compass","far fa-compass","fas fa-copy","far fa-copy","fas fa-copyright","far fa-copyright","fas fa-cut","fas fa-edit","far fa-edit","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-envelope-square","fas fa-eraser","fas fa-fax","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-globe","fas fa-industry","fas fa-paperclip","fas fa-paste","fas fa-pen-square","fas fa-pencil-alt","fas fa-percent","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-registered","far fa-registered","fas fa-save","far fa-save","fas fa-sitemap","fas fa-sticky-note","far fa-sticky-note","fas fa-suitcase","fas fa-table","fas fa-tag","fas fa-tags","fas fa-tasks","fas fa-thumbtack","fas fa-trademark"],"Chess":["fas fa-chess","fas fa-chess-bishop","fas fa-chess-board","fas fa-chess-king","fas fa-chess-knight","fas fa-chess-pawn","fas fa-chess-queen","fas fa-chess-rook","fas fa-square-full"],"Code":["fas fa-archive","fas fa-barcode","fas fa-bath","fas fa-bug","fas fa-code","fas fa-code-branch","fas fa-coffee","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-file-code","far fa-file-code","fas fa-filter","fas fa-fire-extinguisher","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-keyboard","far fa-keyboard","fas fa-microchip","fas fa-qrcode","fas fa-shield-alt","fas fa-sitemap","fas fa-terminal","fas fa-user-secret","fas fa-window-close","far fa-window-close","fas fa-window-maximize","far fa-window-maximize","fas fa-window-minimize","far fa-window-minimize","fas fa-window-restore","far fa-window-restore"],"Communication":["fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-american-sign-language-interpreting","fas fa-assistive-listening-systems","fas fa-at","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fab fa-bluetooth","fab fa-bluetooth-b","fas fa-bullhorn","fas fa-comment","far fa-comment","fas fa-comment-alt","far fa-comment-alt","fas fa-comments","far fa-comments","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-envelope-square","fas fa-fax","fas fa-inbox","fas fa-language","fas fa-microphone","fas fa-microphone-slash","fas fa-mobile","fas fa-mobile-alt","fas fa-paper-plane","far fa-paper-plane","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-rss","fas fa-rss-square","fas fa-tty","fas fa-wifi"],"Computers":["fas fa-desktop","fas fa-download","fas fa-hdd","far fa-hdd","fas fa-headphones","fas fa-keyboard","far fa-keyboard","fas fa-laptop","fas fa-microchip","fas fa-mobile","fas fa-mobile-alt","fas fa-plug","fas fa-power-off","fas fa-print","fas fa-save","far fa-save","fas fa-server","fas fa-tablet","fas fa-tablet-alt","fas fa-tv","fas fa-upload"],"Currency":["fab fa-bitcoin","fab fa-btc","fas fa-dollar-sign","fas fa-euro-sign","fab fa-gg","fab fa-gg-circle","fas fa-lira-sign","fas fa-money-bill-alt","far fa-money-bill-alt","fas fa-pound-sign","fas fa-ruble-sign","fas fa-rupee-sign","fas fa-shekel-sign","fas fa-won-sign","fas fa-yen-sign"],"Date & Time":["fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-clock","far fa-clock","fas fa-hourglass","far fa-hourglass","fas fa-hourglass-end","fas fa-hourglass-half","fas fa-hourglass-start","fas fa-stopwatch"],"Design":["fas fa-adjust","fas fa-clone","far fa-clone","fas fa-copy","far fa-copy","fas fa-crop","fas fa-crosshairs","fas fa-cut","fas fa-edit","far fa-edit","fas fa-eraser","fas fa-eye","fas fa-eye-dropper","fas fa-eye-slash","far fa-eye-slash","fas fa-object-group","far fa-object-group","fas fa-object-ungroup","far fa-object-ungroup","fas fa-paint-brush","fas fa-paste","fas fa-pencil-alt","fas fa-save","far fa-save","fas fa-tint"],"Editors":["fas fa-align-center","fas fa-align-justify","fas fa-align-left","fas fa-align-right","fas fa-bold","fas fa-clipboard","far fa-clipboard","fas fa-clone","far fa-clone","fas fa-columns","fas fa-copy","far fa-copy","fas fa-cut","fas fa-edit","far fa-edit","fas fa-eraser","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-font","fas fa-heading","fas fa-i-cursor","fas fa-indent","fas fa-italic","fas fa-link","fas fa-list","fas fa-list-alt","far fa-list-alt","fas fa-list-ol","fas fa-list-ul","fas fa-outdent","fas fa-paper-plane","far fa-paper-plane","fas fa-paperclip","fas fa-paragraph","fas fa-paste","fas fa-pencil-alt","fas fa-print","fas fa-quote-left","fas fa-quote-right","fas fa-redo","fas fa-redo-alt","fas fa-reply","fas fa-reply-all","fas fa-share","fas fa-strikethrough","fas fa-subscript","fas fa-superscript","fas fa-sync","fas fa-sync-alt","fas fa-table","fas fa-tasks","fas fa-text-height","fas fa-text-width","fas fa-th","fas fa-th-large","fas fa-th-list","fas fa-trash","fas fa-trash-alt","far fa-trash-alt","fas fa-underline","fas fa-undo","fas fa-undo-alt","fas fa-unlink"],"Files":["fas fa-archive","fas fa-clone","far fa-clone","fas fa-copy","far fa-copy","fas fa-cut","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-file-archive","far fa-file-archive","fas fa-file-audio","far fa-file-audio","fas fa-file-code","far fa-file-code","fas fa-file-excel","far fa-file-excel","fas fa-file-image","far fa-file-image","fas fa-file-pdf","far fa-file-pdf","fas fa-file-powerpoint","far fa-file-powerpoint","fas fa-file-video","far fa-file-video","fas fa-file-word","far fa-file-word","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-paste","fas fa-save","far fa-save","fas fa-sticky-note","far fa-sticky-note"],"Genders":["fas fa-genderless","fas fa-mars","fas fa-mars-double","fas fa-mars-stroke","fas fa-mars-stroke-h","fas fa-mars-stroke-v","fas fa-mercury","fas fa-neuter","fas fa-transgender","fas fa-transgender-alt","fas fa-venus","fas fa-venus-double","fas fa-venus-mars"],"Hands":["fas fa-hand-lizard","far fa-hand-lizard","fas fa-hand-paper","far fa-hand-paper","fas fa-hand-peace","far fa-hand-peace","fas fa-hand-point-down","far fa-hand-point-down","fas fa-hand-point-left","far fa-hand-point-left","fas fa-hand-point-right","far fa-hand-point-right","fas fa-hand-point-up","far fa-hand-point-up","fas fa-hand-pointer","far fa-hand-pointer","fas fa-hand-rock","far fa-hand-rock","fas fa-hand-scissors","far fa-hand-scissors","fas fa-hand-spock","far fa-hand-spock","fas fa-handshake","far fa-handshake","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up"],"Health":["fab fa-accessible-icon","fas fa-ambulance","fas fa-h-square","fas fa-heart","far fa-heart","fas fa-heartbeat","fas fa-hospital","far fa-hospital","fas fa-medkit","fas fa-plus-square","far fa-plus-square","fas fa-stethoscope","fas fa-user-md","fas fa-wheelchair"],"Images":["fas fa-adjust","fas fa-bolt","fas fa-camera","fas fa-camera-retro","fas fa-clone","far fa-clone","fas fa-compress","fas fa-expand","fas fa-eye","fas fa-eye-dropper","fas fa-eye-slash","far fa-eye-slash","fas fa-file-image","far fa-file-image","fas fa-film","fas fa-id-badge","far fa-id-badge","fas fa-id-card","far fa-id-card","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-sliders-h","fas fa-tint"],"Interfaces":["fas fa-ban","fas fa-barcode","fas fa-bars","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-bug","fas fa-bullhorn","fas fa-bullseye","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-certificate","fas fa-check","fas fa-check-circle","far fa-check-circle","fas fa-check-square","far fa-check-square","fas fa-circle","far fa-circle","fas fa-clipboard","far fa-clipboard","fas fa-clone","far fa-clone","fas fa-cloud","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-coffee","fas fa-cog","fas fa-cogs","fas fa-copy","far fa-copy","fas fa-cut","fas fa-database","fas fa-dot-circle","far fa-dot-circle","fas fa-download","fas fa-edit","far fa-edit","fas fa-ellipsis-h","fas fa-ellipsis-v","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-exclamation","fas fa-exclamation-circle","fas fa-exclamation-triangle","fas fa-external-link-alt","fas fa-external-link-square-alt","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-filter","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-frown","far fa-frown","fas fa-hashtag","fas fa-heart","far fa-heart","fas fa-history","fas fa-home","fas fa-i-cursor","fas fa-info","fas fa-info-circle","fas fa-language","fas fa-magic","fas fa-meh","far fa-meh","fas fa-microphone","fas fa-microphone-slash","fas fa-minus","fas fa-minus-circle","fas fa-minus-square","far fa-minus-square","fas fa-paste","fas fa-pencil-alt","fas fa-plus","fas fa-plus-circle","fas fa-plus-square","far fa-plus-square","fas fa-qrcode","fas fa-question","fas fa-question-circle","far fa-question-circle"],"Maps":["fas fa-ambulance","fas fa-anchor","fas fa-balance-scale","fas fa-bath","fas fa-bed","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-bicycle","fas fa-binoculars","fas fa-birthday-cake","fas fa-blind","fas fa-bomb","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-briefcase","fas fa-building","far fa-building","fas fa-car","fas fa-coffee","fas fa-crosshairs","fas fa-dollar-sign","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-fighter-jet","fas fa-fire","fas fa-fire-extinguisher","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-flask","fas fa-gamepad","fas fa-gavel","fas fa-gift","fas fa-glass-martini","fas fa-globe","fas fa-graduation-cap","fas fa-h-square","fas fa-heart","far fa-heart","fas fa-heartbeat","fas fa-home","fas fa-hospital","far fa-hospital","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-industry","fas fa-info","fas fa-info-circle","fas fa-key","fas fa-leaf","fas fa-lemon","far fa-lemon","fas fa-life-ring","far fa-life-ring","fas fa-lightbulb","far fa-lightbulb","fas fa-location-arrow","fas fa-low-vision","fas fa-magnet","fas fa-male","fas fa-map","far fa-map","fas fa-map-marker","fas fa-map-marker-alt","fas fa-map-pin","fas fa-map-signs","fas fa-medkit","fas fa-money-bill-alt","far fa-money-bill-alt","fas fa-motorcycle","fas fa-music","fas fa-newspaper","far fa-newspaper","fas fa-paw","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-plane","fas fa-plug","fas fa-plus","fas fa-plus-square","far fa-plus-square","fas fa-print","fas fa-recycle","fas fa-road","fas fa-rocket","fas fa-search","fas fa-search-minus","fas fa-search-plus","fas fa-ship","fas fa-shopping-bag","fas fa-shopping-basket","fas fa-shopping-cart","fas fa-shower","fas fa-street-view","fas fa-subway","fas fa-suitcase","fas fa-tag","fas fa-tags","fas fa-taxi","fas fa-thumbtack"],"Objects":["fas fa-ambulance","fas fa-anchor","fas fa-archive","fas fa-balance-scale","fas fa-bath","fas fa-bed","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bicycle","fas fa-binoculars","fas fa-birthday-cake","fas fa-bomb","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-briefcase","fas fa-bug","fas fa-building","far fa-building","fas fa-bullhorn","fas fa-bullseye","fas fa-bus","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-camera","fas fa-camera-retro","fas fa-car","fas fa-clipboard","far fa-clipboard","fas fa-cloud","fas fa-coffee","fas fa-cog","fas fa-cogs","fas fa-compass","far fa-compass","fas fa-copy","far fa-copy","fas fa-cube","fas fa-cubes","fas fa-cut","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-eye","fas fa-eye-dropper","fas fa-fax","fas fa-fighter-jet","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-film","fas fa-fire","fas fa-fire-extinguisher","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-flask","fas fa-futbol","far fa-futbol","fas fa-gamepad","fas fa-gavel","fas fa-gem","far fa-gem","fas fa-gift","fas fa-glass-martini","fas fa-globe","fas fa-graduation-cap","fas fa-hdd","far fa-hdd","fas fa-headphones","fas fa-heart","far fa-heart","fas fa-home","fas fa-hospital","far fa-hospital","fas fa-hourglass","far fa-hourglass","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-industry","fas fa-key","fas fa-keyboard","far fa-keyboard","fas fa-laptop","fas fa-leaf","fas fa-lemon","far fa-lemon","fas fa-life-ring","far fa-life-ring","fas fa-lightbulb","far fa-lightbulb","fas fa-lock","fas fa-lock-open","fas fa-magic","fas fa-magnet","fas fa-map","far fa-map","fas fa-map-marker","fas fa-map-marker-alt"],"Payments & Shopping":["fab fa-amazon-pay","fab fa-apple-pay","fas fa-bell","far fa-bell","fas fa-bookmark","far fa-bookmark","fas fa-bullhorn","fas fa-camera","fas fa-camera-retro","fas fa-cart-arrow-down","fas fa-cart-plus","fab fa-cc-amazon-pay","fab fa-cc-amex","fab fa-cc-apple-pay","fab fa-cc-diners-club","fab fa-cc-discover","fab fa-cc-jcb","fab fa-cc-mastercard","fab fa-cc-paypal","fab fa-cc-stripe","fab fa-cc-visa","fas fa-certificate","fas fa-credit-card","far fa-credit-card","fab fa-ethereum","fas fa-gem","far fa-gem","fas fa-gift","fab fa-google-wallet","fas fa-handshake","far fa-handshake","fas fa-heart","far fa-heart","fas fa-key","fab fa-paypal","fas fa-shopping-bag","fas fa-shopping-basket","fas fa-shopping-cart","fas fa-star","far fa-star","fab fa-stripe","fab fa-stripe-s","fas fa-tag","fas fa-tags","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up","fas fa-trophy"],"Shapes":["fas fa-bookmark","far fa-bookmark","fas fa-calendar","far fa-calendar","fas fa-certificate","fas fa-circle","far fa-circle","fas fa-cloud","fas fa-comment","far fa-comment","fas fa-file","far fa-file","fas fa-folder","far fa-folder","fas fa-heart","far fa-heart","fas fa-map-marker","fas fa-play","fas fa-square","far fa-square","fas fa-star","far fa-star"],"Spinners":["fas fa-asterisk","fas fa-certificate","fas fa-circle-notch","fas fa-cog","fas fa-compass","far fa-compass","fas fa-crosshairs","fas fa-life-ring","far fa-life-ring","fas fa-snowflake","far fa-snowflake","fas fa-spinner","fas fa-sun","far fa-sun","fas fa-sync"],"Sports":["fas fa-baseball-ball","fas fa-basketball-ball","fas fa-bowling-ball","fas fa-football-ball","fas fa-futbol","far fa-futbol","fas fa-golf-ball","fas fa-hockey-puck","fas fa-quidditch","fas fa-table-tennis","fas fa-volleyball-ball"],"Status":["fas fa-ban","fas fa-battery-empty","fas fa-battery-full","fas fa-battery-half","fas fa-battery-quarter","fas fa-battery-three-quarters","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-cart-arrow-down","fas fa-cart-plus","fas fa-exclamation","fas fa-exclamation-circle","fas fa-exclamation-triangle","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-info","fas fa-info-circle","fas fa-lock","fas fa-lock-open","fas fa-minus","fas fa-minus-circle","fas fa-minus-square","far fa-minus-square","fas fa-plus","fas fa-plus-circle","fas fa-plus-square","far fa-plus-square","fas fa-question","fas fa-question-circle","far fa-question-circle","fas fa-shield-alt","fas fa-shopping-cart","fas fa-sign-in-alt","fas fa-sign-out-alt","fas fa-thermometer-empty","fas fa-thermometer-full","fas fa-thermometer-half","fas fa-thermometer-quarter","fas fa-thermometer-three-quarters","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up","fas fa-toggle-off","fas fa-toggle-on","fas fa-unlock","fas fa-unlock-alt"],"Users & People":["fab fa-accessible-icon","fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-bed","fas fa-blind","fas fa-child","fas fa-female","fas fa-frown","far fa-frown","fas fa-id-badge","far fa-id-badge","fas fa-id-card","far fa-id-card","fas fa-male","fas fa-meh","far fa-meh","fas fa-power-off","fas fa-smile","far fa-smile","fas fa-street-view","fas fa-user","far fa-user","fas fa-user-circle","far fa-user-circle","fas fa-user-md","fas fa-user-plus","fas fa-user-secret","fas fa-user-times","fas fa-users","fas fa-wheelchair"],"Vehicles":["fab fa-accessible-icon","fas fa-ambulance","fas fa-bicycle","fas fa-bus","fas fa-car","fas fa-fighter-jet","fas fa-motorcycle","fas fa-paper-plane","far fa-paper-plane","fas fa-plane","fas fa-rocket","fas fa-ship","fas fa-shopping-cart","fas fa-space-shuttle","fas fa-subway","fas fa-taxi","fas fa-train","fas fa-truck","fas fa-wheelchair"],"Writing":["fas fa-archive","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-edit","far fa-edit","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-keyboard","far fa-keyboard","fas fa-newspaper","far fa-newspaper","fas fa-paper-plane","far fa-paper-plane","fas fa-paperclip","fas fa-paragraph","fas fa-pen-square","fas fa-pencil-alt","fas fa-quote-left","fas fa-quote-right","fas fa-sticky-note","far fa-sticky-note","fas fa-thumbtack"]}
            }).on('change', function(e) {
                setTimeout(function() {
                    if($(e.currentTarget).siblings('.icons-selector').find('.selector-popup').css('display') != 'block') {
                        $("#sortable-nav").sortable('enable');
                        $("#sortable-nav ol").sortable('enable');
                    }
                }, 500);
            });
            $('.selector-button').on('click', function(e) {
                $("#sortable-nav").sortable('disable');
                $("#sortable-nav ol").sortable('disable');
                $("#sortable-nav").on('click', function() {
                    $("#sortable-nav").sortable('enable');
                    $("#sortable-nav ol").sortable('enable');
                    $("#sortable-nav").off('click');
                });
            });;

            /* Disable items */

            $('.disable-icon').on('mousedown', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $("#sortable-nav ol").sortable('disable');
                $(this).closest('li').toggleClass('disabled');
                if ($(this).closest('li').hasClass('disabled')) {
                    $(this).attr('title', '<?php echo ADD_TO_NAVBAR; ?>').html('<i class="fas fa-plus-circle text-success mr-2"></i><?php echo ADD_TO_NAVBAR; ?>');
                } else {
                    $(this).attr('title', '<?php echo REMOVE_FROM_NAVBAR; ?>').html('<i class="fas fa-minus-circle text-danger mr-2"></i><?php echo REMOVE_FROM_NAVBAR; ?>');
                }
                setTimeout(function() {
                    $("#sortable-nav ol").sortable('enable');
                }, 200);

                return;
            });

            /* Sortable */

            var makeSortable = function() {
                $("#sortable-nav").sortable({
                    nested: false,
                    distance: 20,
                    delay: 200,
                    containerSelector: "ol",
                    handle: ".drag-me",
                    onDragStart: function($item, container, _super) {
                        if($item.hasClass('parent')) {
                            $item.find('ol').sortable('disable');
                        } else {
                            $('.parent').closest('ol').sortable('disable');
                        }
                        _super($item, container);
                    },
                      onDrop: function($item, container, _super) {
                        if($item.hasClass('parent')) {
                            $item.find('ol').sortable('enable');
                        } else {
                            $('.parent').closest('ol').sortable('enable');
                        }
                        _super($item, container);
                    }
                });

                $("#sortable-nav ol").sortable({
                    group: 'nested'
                });
            };
            makeSortable();


            /* Content Editable */

            $('.cat-name').attr('contentEditable', true);

            /* Add new category */

            $('#add-category-btn').on('click', function() {
                var $lastElement = $('#sortable-nav ol li:last-child').detach();
                $('#sortable-nav').append('<?php echo $new_list_html; ?>');
                $('#sortable-nav > li:last-child').find('ol').append($lastElement);
                $('.cat-name').attr('contentEditable', true);
                makeSortable();
            });

            /* Ajax POST */

            $('#save-changes-btn').on('click', function() {
                var navCats      = new Object(),
                    tablesIcons  = new Object(),
                    i = 0;
                $('#sortable-nav > li').each(function() {
                    var catIndex   = "navcat-" + i.toString();
                    navCats[catIndex] = new Object();
                    navCats[catIndex]["name"] = $(this).find('.cat-name').text();

                    navCats[catIndex]["tables"]      = new Array();
                    navCats[catIndex]["is_disabled"] = new Array();

                    $(this).find('ol > li').each(function() {
                        // register table icon
                        var table = $(this).attr('id'),
                            iconValue = $(this).find('.iconpicker').val();
                        tablesIcons[table] = iconValue;

                        // register table in nav category
                        navCats[catIndex]["tables"].push(table);
                        navCats[catIndex]["is_disabled"].push($(this).hasClass('disabled'));
                    });

                    i++;
                });
                var target = $('#result');
                $.ajax({
                    url: 'inc/ajax-organize-navbar.php',
                    type: 'POST',
                    data: {
                        navCats: navCats,
                        tablesIcons: tablesIcons
                    },
                }).done(function(data) {
                    target.html(data);
                    $('html,body').animate({scrollTop: 0},'slow');
                }).fail(function(data, statut, error) {
                    console.log(error);
                });
            });

        }, 5000);
    </script>
</body>
</html>
