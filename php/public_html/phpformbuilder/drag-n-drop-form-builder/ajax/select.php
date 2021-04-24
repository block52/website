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
if (!empty($placeholder)) {
    $form->addOption($name, '', $placeholder, '', 'disabled, selected');
}
foreach ($selectOptions as $opt) {
    $selected = '';
    if ($opt->value === $value) {
        $selected = 'selected';
    }
    $form->addOption($name, $opt->value, $opt->text, $opt->groupname, $selected);
}
$form->addSelect($name, $label, $attr);
echo $form->html;
