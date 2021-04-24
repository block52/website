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

$form_id = 'plugins-popover-form-1';

$form = new Form($form_id, 'vertical');


$form->addInput('text', 'user-name-popover', '', 'username', 'required');
$form->addInput('email', 'user-email-popover', '', 'e-mail address', 'required');
$form->centerButtons(true);
$form->addBtn('button', 'cancel-btn-popover', 1, 'Cancel', 'class=btn btn-default, onclick=WebuiPopovers.hideAll();', 'submit_group');
$form->addBtn('submit', 'submit-btn-popover', 1, 'Send ', 'class=btn btn-success', 'submit_group');
$form->printBtnGroup('submit_group');

$form->popover('#popover-link');


$output['form_code'][] = htmlspecialchars('<?php
$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->addInput(\'text\', \'user-name-popover\', \'\', \'username\', \'required\');
$form->addInput(\'email\', \'user-email-popover\', \'\', \'e-mail address\', \'required\');
$form->centerButtons(true);
$form->addBtn(\'button\', \'cancel-btn-popover\', 1, \'Cancel\', \'class=btn btn-default, onclick=WebuiPopovers.hideAll();\', \'submit_group\');
$form->addBtn(\'submit\', \'submit-btn-popover\', 1, \'Send \', \'class=btn btn-success\', \'submit_group\');
$form->printBtnGroup(\'submit_group\');

$form->popover(\'#popover-link\');
?>

<div class="text-center">
    <a href="#" id="popover-link" class="btn btn-primary text-white btn-lg">Sign Up</a>
</div>');

$output['form'][] = $form;

$output['html_code'][]   = trim(htmlspecialchars('
<div class="hide hidden d-none">
    <div id="' . $form_id . '-content">
<form id="' . $form_id . '" class="form-horizontal popover-form">' . $form->cleanHtmlOutput($form->html) . '
</form>
    </div>
</div>'));

echo renderExample($output);
