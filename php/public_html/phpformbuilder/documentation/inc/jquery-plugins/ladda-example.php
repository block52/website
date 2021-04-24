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

$form_id = 'plugins-ladda-form-1';

$form = new Form($form_id, 'vertical');


$form->centerButtons(true);

$form->startFieldset('expand-left', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-1', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-style=expand-left');
$form->endFieldset();

$form->startFieldset('contract', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-2', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-style=contract');
$form->endFieldset();

$form->startFieldset('contract-overlay', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-3', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-style=contract-overlay');
$form->endFieldset();

$form->startFieldset('zoom-in', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-4', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-style=zoom-in');
$form->endFieldset();

$form->startFieldset('slide-left', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-5', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-style=slide-left');

$form->startFieldset('data-spinner-color=tomato, data-spinner-lines=6', 'class=bg-gray-100 mb-5', 'class=small text-center py-2 mb-3 bg-gray-200');
$form->addBtn('button', 'my-btn-6', 1, 'Send <span class="fa fa-envelope ml-2"></span>', 'class=btn btn-secondary ladda-button, data-spinner-color=tomato, data-spinner-lines=6');
$form->endFieldset();


$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->centerButtons(true);

$form->startFieldset(\'expand-left\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-1\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-style=expand-left\');
$form->endFieldset();

$form->startFieldset(\'contract\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-2\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-style=contract\');
$form->endFieldset();

$form->startFieldset(\'contract-overlay\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-3\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-style=contract-overlay\');
$form->endFieldset();

$form->startFieldset(\'zoom-in\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-4\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-style=zoom-in\');
$form->endFieldset();

$form->startFieldset(\'slide-left\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-5\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-style=slide-left\');

$form->startFieldset(\'data-spinner-color=tomato, data-spinner-lines=6\', \'class=bg-gray-100 mb-5\', \'class=small text-center py-2 mb-3 bg-gray-200\');
$form->addBtn(\'button\', \'my-btn-6\', 1, \'Send <span class="fa fa-envelope ml-2"></span>\', \'class=btn btn-secondary ladda-button, data-spinner-color=tomato, data-spinner-lines=6\');
$form->endFieldset();');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
