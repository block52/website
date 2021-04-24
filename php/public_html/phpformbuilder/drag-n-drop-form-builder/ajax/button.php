<?php
use phpformbuilder\Form;
session_start();
include_once '../../phpformbuilder/Form.php';
$json = json_decode($_POST['data']);

foreach ($json as $var => $val) {
    ${$var} = $val;
}

$form = new Form('fg-element', 'horizontal');
if (!empty($icon)) {
    $icon_link = '<i class="' . $icon . '" aria-label="hidden"></i>';
    if ($iconPosition === 'before') {
        $label = $icon_link . ' ' . $label;
    } else {
        $label .= ' ' . $icon_link;
    }
}
$form->addBtn($type, $name, $value, $label, $attr);
echo $form->html;
