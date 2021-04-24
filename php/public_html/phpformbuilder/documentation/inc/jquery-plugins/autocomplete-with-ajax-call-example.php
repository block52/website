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

$form_id = 'plugins-search-form-2';

$form = new Form($form_id, 'vertical', 'novalidate');

$addon = '<button class="btn btn-success" type="submit">
    <i class="fa fa-search" aria-hidden="true"></i>
</button>';
$form->addAddon('search-input-2', $addon, 'after');
$form->addHelper('Type at lease 2 characters', 'search-input-2');
$form->addInput('text', 'search-input-2', '', 'First name:', 'placeholder=Search here ...');

$replacements = [
    '%remote%' => '../templates/bootstrap-4-forms/search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];

$form->addPlugin('autocomplete', '#search-input-2', 'remote', $replacements);


$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\', \'novalidate\');

$addon = \'<button class="btn btn-success" type="submit">
    <i class="fa fa-search" aria-hidden="true"></i>
</button>\';
$form->addAddon(\'search-input-2\', $addon, \'after\');
$form->addHelper(\'Type at lease 2 characters\', \'search-input-2\');
$form->addInput(\'text\', \'search-input-2\', \'\', \'First name:\', \'placeholder=Search here ...\');

$replacements = [
    \'%remote%\' => \'../templates/bootstrap-4-forms/search-form-autocomplete/complete.php\',
    \'%minLength%\' => \'2\'
];

$form->addPlugin(\'autocomplete\', \'#search-input-2\', \'remote\', $replacements);');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-search-form-3';

$form = new Form($form_id, 'vertical', 'novalidate');

$addon = '<button class="btn btn-success ladda-button" data-style="zoom-in" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>';
$form->addAddon('search-input-3', $addon, 'after');
$form->addHelper('Type at lease 2 characters', 'search-input-3');
$form->addInput('text', 'search-input-3', '', 'First name:', 'data-placeholder=Search here ...');

$replacements = [
    '%remote%' => '../templates/bootstrap-4-forms/search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form->addPlugin('autocomplete', '#search-input-3', 'remote-tags', $replacements);

$output['title'][]     = 'Ajax search with select multiple & tags';
$output['form_code'][] = htmlspecialchars('$form = new Form($form_id, \'vertical\', \'novalidate\');

$addon = \'<button class="btn btn-success ladda-button" data-style="zoom-in" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>\';
$form->addAddon(\'search-input-3\', $addon, \'after\');
$form->addHelper(\'Type at lease 2 characters\', \'search-input-3\');
$form->addInput(\'text\', \'search-input-3\', \'\', \'First name:\', \'data-placeholder=Search here ...\');

$replacements = [
    \'%remote%\' => \'../templates/bootstrap-4-forms/search-form-autocomplete/complete.php\',
    \'%minLength%\' => \'2\'
];
$form->addPlugin(\'autocomplete\', \'#search-input-3\', \'remote-tags\', $replacements);');
$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
