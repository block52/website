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

$form_id = 'plugins-captcha-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'captcha', '', 'Type the characters please:', 'size=15');

$form->addPlugin('captcha', '#captcha');


$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

// captcha validation - this code goes in the form validation part
// if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken(\'your-form-name-here\') === true) {
//     $validator->captcha()->validate(\'captcha\');
// }
// END of validation

$form->addInput(\'text\', \'captcha\', \'\', \'Type the characters please:\', \'size=15\');

$form->addPlugin(\'captcha\', \'#captcha\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
