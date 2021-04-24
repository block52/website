<?php
use phpformbuilder\Form;

include_once '../../../phpformbuilder/Form.php';
include_once 'render.php';

$output = array(
    'title'       => array(),
    'form_code'   => array(),
    'form'        => array(),
    'html_code'   => array()
);

$form_id = 'plugins-lcswitch-form-1';

$form = new Form($form_id, 'horizontal');


$form->addCheckbox('my-checkbox-group', 'Checkbox 1', 'value-1', 'class=lcswitch');
$form->addCheckbox('my-checkbox-group', 'Checkbox 2', 'value-2', 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red, checked');
$form->printCheckboxGroup('my-checkbox-group', '', false);

$form->addRadio('my-radio-group', 'Radio 1', 'value-1', 'class=lcswitch');
$form->addRadio('my-radio-group', 'Radio 2', 'value-2', 'class=lcswitch, data-ontext=True, data-offtext=False, data-theme=blue, checked');
$form->printRadioGroup('my-radio-group', 'Main label:');


$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addCheckbox(\'my-checkbox-group\', \'Checkbox 1\', \'value-1\', \'class=lcswitch\');
$form->addCheckbox(\'my-checkbox-group\', \'Checkbox 2\', \'value-2\', \'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red, checked\');
$form->printCheckboxGroup(\'my-checkbox-group\', \'\', false);

$form->addRadio(\'my-radio-group\', \'Radio 1\', \'value-1\', \'class=lcswitch\');
$form->addRadio(\'my-radio-group\', \'Radio 2\', \'value-2\', \'class=lcswitch, data-ontext=True, data-offtext=False, data-theme=blue, checked\');
$form->printRadioGroup(\'my-radio-group\', \'Main label:\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
