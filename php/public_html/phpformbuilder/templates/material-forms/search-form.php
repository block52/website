<?php
use phpformbuilder\Form;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check which form has been posted

    if (isset($_POST['search-form-1']) && Form::testToken('search-form-1') === true) {
        if ($_POST['search-input-1'] == '') {
            $search_result = '<p class="card-panel red darken-1">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="card-panel teal accent-3"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-1']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-1');
    } elseif (isset($_POST['search-form-2']) && Form::testToken('search-form-2') === true) {
        if ($_POST['search-input-2'] == '') {
            $search_result = '<p class="card-panel red darken-1">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="card-panel teal accent-3"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-2']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-2');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('search-form-1', 'vertical', 'novalidate', 'material');
// $form->setMode('development');

$form->startFieldset('1<sup>st</sup> Search Form - search in json list');

$addon = '<button class="btn waves-effect waves-light ladda-button" data-style="zoom-in" type="submit"><i class="material-icons">search</i></button>';
$form->addAddon('search-input-1', $addon, 'after');
$form->addInput('text', 'search-input-1', '', 'Search something:', 'placeholder=Type for example \'A\'');

$form->endFieldset();
$complete_list = [
    '%availableTags%' =>
    '
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
    "Scheme"
    '
];
$form->addPlugin('autocomplete', '#search-input-1', 'default', $complete_list);

/* 2nd form (Ajax search) */

$form_2 = new Form('search-form-2', 'vertical', 'novalidate', 'material');
$form_2->setMode('development');

$form_2->startFieldset('2<sup>nd</sup> Search Form - search with ajax request');

$addon = '<button class="btn waves-effect waves-light ladda-button" data-style="zoom-in" type="submit"><i class="material-icons">search</i></button>';
$form_2->addAddon('search-input-2', $addon, 'after');
$form_2->addInput('text', 'search-input-2', '', 'First name:', 'placeholder=Type at lease 2 characters');

$form_2->endFieldset();
$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_2->addPlugin('autocomplete', '#search-input-2', 'remote', $replacements);

/* 3rd form (Ajax search with select multiple & tags) */

$form_3 = new Form('search-form-3', 'vertical', 'novalidate', 'material');
$form_3->setMode('development');

$form_3->startFieldset('3<sup>rd</sup> Search Form - Ajax search with multiple tags results');

$addon = '<button class="btn waves-effect waves-light ladda-button" data-style="zoom-in" type="submit"><i class="material-icons">search</i></button>';
$form_3->addAddon('search-input-3', $addon, 'after');
$form_3->addHelper('Type at lease 2 characters', 'search-input-3');
$form_3->addInput('text', 'search-input-3', '', 'First name:', 'data-placeholder=Search here ...');

$form_3->endFieldset();

$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_3->addPlugin('autocomplete', '#search-input-3', 'remote-tags', $replacements);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Autocomplete Search Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create an autocompleting Search Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/search-form.php" />

    <!-- Materialize CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Material icons CSS -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php
    $form->printIncludes('css');
    $form_3->printIncludes('css');
    ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Material Design Search Form<br><small>with JSON or Ajax  autocomplete</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m11 l10">
            <?php
            if (isset($search_result)) {
                echo $search_result;
            }
            $form->render();
            $form_2->render();
            $form_3->render();
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?php
        $form->printIncludes('js');
        $form_3->printIncludes('js');
        $form->printJsCode();
        $form_2->printJsCode();
        $form_3->printJsCode();
    ?>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
