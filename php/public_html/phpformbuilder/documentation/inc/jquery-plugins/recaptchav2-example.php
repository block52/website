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

$form_id = 'plugins-recaptcha-form-1';

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('recaptcha-form-1') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('recaptcha-form-1');

    // recaptcha validation
    $validator->recaptcha('6LcSY1oUAAAAAHXz7K72uP2thZT7xhZ5zc9Q5Vgc', 'Recaptcha Error')->validate('g-recaptcha-response');
}

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'rf-name', '', 'Your name');
$form->addRecaptcha('6LcSY1oUAAAAAE6UUHkyTivIZvAO6DSU9Daqry8h');
$form->addBtn('submit', 'rf-submit-btn', 1, 'Send <i class="fa fa-envelope append" aria-hidden="true"></i>', 'class=btn btn-success');



$output['title'][]      = '';
$output['form_code'][]  = htmlspecialchars('if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken(\'recaptcha-form-1\') === true) {

    // create validator & auto-validate required fields
    $validator = Form::validate(\'recaptcha-form-1\');

    // recaptcha validation
    $validator->recaptcha(\'6LcSY1oUAAAAAHXz7K72uP2thZT7xhZ5zc9Q5Vgc\', \'Recaptcha Error\')->validate(\'g-recaptcha-response\');
}

$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'rf-name\', \'\', \'Your name\');
$form->addRecaptcha(\'6LcSY1oUAAAAAE6UUHkyTivIZvAO6DSU9Daqry8h\');
$form->addBtn(\'submit\', \'rf-submit-btn\', 1, \'Send <i class="fa fa-envelope append" aria-hidden="true"></i>\', \'class=btn btn-success\');');


$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
