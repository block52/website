<?php
use phpformbuilder\Form;
session_start();
include_once '../../phpformbuilder/Form.php';
$json = json_decode($_POST['data']);

foreach ($json as $var => $val) {
    ${$var} = $val;
}

$form = new Form('fg-element', 'horizontal');
if (!empty($helper)) {
    $form->addHelper($helper, $name);
}
if (empty($label)) {
    $form->setCols(0, 12);
}
if (!empty($icon)) {
    $icon_link = '<i class="' . $icon . '" aria-label="hidden"></i>';
    $form->addIcon($name, $icon_link, $iconPosition);
}
$form->addInput($type, $name, $value, $label, $attr);
echo $form->html;
