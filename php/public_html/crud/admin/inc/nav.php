<?php

$json = file_get_contents('crud-data/nav-data.json');
$json_data = json_decode($json, true);

/* =============================================
    To add a nav item : $nav->addLink('/admin/table_name.php', 'Displayed Label');
============================================= */

use bootstrap\nav\Nav;

$nav = new Nav('nav nav-tabs');
$nav->addLink('/admin/home', '<span class="icon-home"></span>');
foreach ($json_data as $item => $label) {
    $nav->addLink('/admin/' . $item, $label);
}
?>
<div class="page-header">
    <?php $nav->render(); ?>
</div>
