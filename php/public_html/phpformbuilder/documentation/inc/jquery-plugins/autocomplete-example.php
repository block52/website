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

$form_id = 'plugins-search-form-1';

$form = new Form($form_id, 'vertical');


$addon = '<button class="btn btn-success" type="submit">
    <i class="fa fa-search" aria-hidden="true"></i>
</button>';
$form->addAddon('search-input-1', $addon, 'after');
$form->addHelper('Type for example "A"', 'search-input-1');
$form->addInput('text', 'search-input-1', '', 'Search something:', 'placeholder=Search here ...');

$languages_list = [
    '%availableTags%' => '
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"'
];

$form->addPlugin('autocomplete', '#search-input-1', 'default', $languages_list);

$output['title'][] = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$addon = \'<button class="btn btn-success" type="submit">
    <i class="fa fa-search" aria-hidden="true"></i>
</button>\';
$form->addAddon(\'search-input-1\', $addon, \'after\');
$form->addHelper(\'Type for example "A"\', \'search-input-1\');
$form->addInput(\'text\', \'search-input-1\', \'\', \'Search something:\', \'placeholder=Search here ...\');

$languages_list = [
    \'%availableTags%\' => \'
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"\'
];

$form->addPlugin(\'autocomplete\', \'#search-input-1\', \'default\', $languages_list);');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
