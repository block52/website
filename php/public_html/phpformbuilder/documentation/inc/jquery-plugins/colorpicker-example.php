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

$form_id = 'plugins-colorpicker-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'my-color', '', 'Pick a color:');

$form->addPlugin('colorpicker', '#my-color');


$output['title'][]      = 'color code inside the input field';
$output['form_code'][]  = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'my-color\', \'\', \'Pick a color:\');

$form->addPlugin(\'colorpicker\', \'#my-color\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-colorpicker-form-2';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'my-color-2', '', 'Pick a color:');

$form->addPlugin('colorpicker', '#my-color-2', 'colored-input');


$output['title'][]      = 'color rendered as field background';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'my-color-2\', \'\', \'Pick a color:\');

$form->addPlugin(\'colorpicker\', \'#my-color-2\', \'colored-input\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
