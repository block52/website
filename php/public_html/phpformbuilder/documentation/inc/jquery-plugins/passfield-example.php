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

$form_id = 'plugins-passfield-form-1';

$form = new Form($form_id, 'horizontal');


$form->addHelper('<span class="help-block">password must contain lowercase + uppercase letters and be 6 characters long</span>', 'user-passfield');
$form->addInput('password', 'user-passfield', '', 'password', 'required=required');

$form->addPlugin('passfield', '#user-passfield', 'lower-upper-min-6');


$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addHelper(\'<span class="help-block">password must contain lowercase + uppercase letters and be 6 characters long</span>\', \'user-passfield\');
$form->addInput(\'password\', \'user-passfield\', \'\', \'password\', \'required=required\');

$form->addPlugin(\'passfield\', \'#user-passfield\', \'lower-upper-min-6\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
