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

$form_id = 'plugins-word-char-count-form-1';

$form = new Form($form_id, 'vertical');


$form->addTextarea('word-char-count-textarea', '', 'Enter content here', 'cols=100, rows=10');

$form->addPlugin('word-character-count', '#word-char-count-textarea', 'default', array('%maxAuthorized%' => 100));


$output['title'][]      = '';
$output['form_code'][]  = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->addTextarea(\'word-char-count-textarea\', \'\', \'Enter content here\', \'cols=100, rows=20\');

$form->addPlugin(\'word-character-count\', \'#word-char-count-textarea\', \'default\', array(\'%maxAuthorized%\' => 100));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
