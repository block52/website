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

$form_id = 'plugins-nice-check-form-1';

$form = new Form($form_id, 'horizontal');


$form->addRadio('vertical-radio', 'One', 1);
$form->addRadio('vertical-radio', 'Two', 2, 'checked');
$form->printRadioGroup('vertical-radio', 'Vertical radio buttons', false);

$form->addCheckbox('vertical-checkbox', 'First', 1);
$form->addCheckbox('vertical-checkbox', 'Second', 2, 'checked');
$form->addCheckbox('vertical-checkbox', 'Third', 3);
$form->printCheckboxGroup('vertical-checkbox', 'Vertical checkboxes', false);

$form->addRadio('horizontal-radio', 'One', 1, 'checked');
$form->addRadio('horizontal-radio', 'Two', 2, 'checked');
$form->printRadioGroup('horizontal-radio', 'horizontal radio buttons', true);

$form->addCheckbox('horizontal-checkbox', 'First', 1);
$form->addCheckbox('horizontal-checkbox', 'Second', 2);
$form->addCheckbox('horizontal-checkbox', 'Third', 3, 'checked');
$form->printCheckboxGroup('horizontal-checkbox', 'Horizontal checkboxes', true);

$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'red']);


$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addRadio(\'vertical-radio\', \'One\', 1);
$form->addRadio(\'vertical-radio\', \'Two\', 2, \'checked\');
$form->printRadioGroup(\'vertical-radio\', \'Vertical radio buttons\', false);

$form->addCheckbox(\'vertical-checkbox\', \'First\', 1);
$form->addCheckbox(\'vertical-checkbox\', \'Second\', 2, \'checked\');
$form->addCheckbox(\'vertical-checkbox\', \'Third\', 3);
$form->printCheckboxGroup(\'vertical-checkbox\', \'Vertical checkboxes\', false);

$form->addRadio(\'horizontal-radio\', \'One\', 1, \'checked\');
$form->addRadio(\'horizontal-radio\', \'Two\', 2, \'checked\');
$form->printRadioGroup(\'horizontal-radio\', \'horizontal radio buttons\', true);

$form->addCheckbox(\'horizontal-checkbox\', \'First\', 1);
$form->addCheckbox(\'horizontal-checkbox\', \'Second\', 2);
$form->addCheckbox(\'horizontal-checkbox\', \'Third\', 3, \'checked\');
$form->printCheckboxGroup(\'horizontal-checkbox\', \'Horizontal checkboxes\', true);

$form->addPlugin(\'nice-check\', \'form\', \'default\', [\'%skin%\' => \'red\']);');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
