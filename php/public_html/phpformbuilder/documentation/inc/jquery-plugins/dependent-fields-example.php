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

$form_id = 'plugins-dependent-fields-form-1';

$form = new Form($form_id, 'horizontal');


$form->addOption('subject', '', 'Your request concerns:');
$form->addOption('subject', 'Support', 'Support');
$form->addOption('subject', 'Other', 'Other');
$form->addHelper('if other, please tell us more', 'subject');
$form->addSelect('subject');

$form->startDependentFields('subject', 'Other');
$form->addInput('text', 'request-more', '', '', 'required, placeholder=Please tell more about your request ...');
$form->endDependentFields();


$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addOption(\'subject\', \'\', \'Your request concerns:\');
$form->addOption(\'subject\', \'Support\', \'Support\');
$form->addOption(\'subject\', \'Other\', \'Other\');
$form->addHelper(\'if other, please tell us more\', \'subject\');
$form->addSelect(\'subject\');

$form->startDependentFields(\'subject\', \'Other\');
$form->addInput(\'text\', \'request-more\', \'\', \'\', \'required, placeholder=Please tell more about your request ...\');
$form->endDependentFields();');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
