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

$form_id = 'plugins-modal-form-1';

$form = new Form($form_id, 'vertical');



$form->addInput('text', 'user-name-modal', '', 'username', 'required');
$form->addInput('email', 'user-email-modal', '', 'e-mail address', 'required');
$form->centerButtons(true);
$form->addBtn('button', 'cancel-btn-modal', 1, 'Cancel', 'class=btn btn-default, data-modal-close=modal-target', 'submit_group');
$form->addBtn('submit', 'submit-btn-modal', 1, 'Send ', 'class=btn btn-success', 'submit_group');
$form->printBtnGroup('submit_group');

$form->modal('#modal-target');


$output['form_code'][] = htmlspecialchars('<?php
$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->addInput(\'text\', \'user-name-modal\', \'\', \'username\', \'required\');
$form->addInput(\'email\', \'user-email-modal\', \'\', \'e-mail address\', \'required\');
$form->centerButtons(true);
$form->addBtn(\'button\', \'cancel-btn-modal\', 1, \'Cancel\', \'class=btn btn-default, data-modal-close=modal-target\', \'submit_group\');
$form->addBtn(\'submit\', \'submit-btn-modal\', 1, \'Send \', \'class=btn btn-success\', \'submit_group\');
$form->printBtnGroup(\'submit_group\');

$form->modal(\'#modal-target\');
?>

<div class="text-center">
    <a data-remodal-target="modal-target" class="btn btn-primary text-white btn-lg">Sign Up</a>
</div>');

$output['form'][] = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
