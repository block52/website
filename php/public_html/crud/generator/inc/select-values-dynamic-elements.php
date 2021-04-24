<?php
use phpformbuilder\Form;

if (!isset($_GET['index']) || !is_numeric($_GET['index'])) {
    exit();
}
include_once '../../conf/conf.php';

$index = $_GET['index'];

$form = new Form('elements', 'horizontal', 'novalidate', 'bs4');
$form->setCols(2, 3);
$form->groupInputs('custom_name-' . $index, 'custom_value-' . $index, 'remove-btn');
$form->addInput('text', 'custom_name-' . $index, '', NAME);
$form->addInput('text', 'custom_value-' . $index, '', VALUE);
$form->setCols(0, 2);
$form->addBtn('button', 'remove-btn', '', '<i class="' . ICON_DELETE . '"></i>', 'class=btn btn-sm btn-danger remove-element-button, data-index=' . $index);

/* render elements */

/* !!! Don't remove dynamic div, required to delete elements using jQuery !!! */

echo '<div class="dynamic mb-2 clearfix">' . $form->html . '</div>';
