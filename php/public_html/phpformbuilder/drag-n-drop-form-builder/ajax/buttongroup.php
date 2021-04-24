<?php
use phpformbuilder\Form;
session_start();
include_once '../../phpformbuilder/Form.php';
$json = json_decode($_POST['data']);
foreach ($json as $var => $val) {
    ${$var} = $val;
}

$form = new Form('fg-element', 'horizontal');

foreach ($buttons as $btn) {
    if (!empty($btn->icon)) {
        $icon_link = '<i class="' . $btn->icon . '" aria-label="hidden"></i>';
        if ($btn->iconPosition === 'before') {
            $btn->label = $icon_link . ' ' . $btn->label;
        } else {
            $btn->label .= ' ' . $icon_link;
        }
    }
    $form->addBtn($btn->type, $btn->name, $btn->value, $btn->label, 'class=' . $btn->clazz, $name);
}
$form->printBtnGroup($name);
echo $form->html;
