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
            $search_result = '<p class="alert alert-danger">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="alert alert-success"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-1']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-1');
    } elseif (isset($_POST['search-form-2']) && Form::testToken('search-form-2') === true) {
        if ($_POST['search-input-2'] == '') {
            $search_result = '<p class="alert alert-danger">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="alert alert-success"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-2']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-2');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('search-form-1', 'vertical', 'class=mb-5, novalidate');
// $form->setMode('development');

$form->startFieldset('1<sup>st</sup> Search Form - search in json list');

$addon = '<button class="btn btn-success ladda-button" data-style="zoom-in" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>';
$form->addAddon('search-input-1', $addon, 'after');
$form->addHelper('Type for example "A"', 'search-input-1');
$form->addInput('text', 'search-input-1', '', 'Search something:', 'placeholder=Search here ...');

$form->endFieldset();

$languages_list = ['%availableTags%' => '"ActionScript", "AppleScript", "Asp", "BASIC", "C", "C++", "Clojure", "COBOL", "ColdFusion", "Erlang", "Fortran", "Groovy", "Haskell", "Java", "JavaScript", "Lisp", "Perl", "PHP", "Python", "Ruby", "Scala", "Scheme"'];
$form->addPlugin('autocomplete', '#search-input-1', 'default', $languages_list);

$form->addPlugin('ladda', '#search-form-1 .btn');

/* 2nd form (Ajax search) */

$form_2 = new Form('search-form-2', 'vertical', 'data-fv-no-icon=true, novalidate');
$form_2->setMode('development');

$form_2->startFieldset('2<sup>nd</sup> Search Form - search with ajax request');

$addon = '<button class="btn btn-success ladda-button" data-style="zoom-in" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>';
$form_2->addAddon('search-input-2', $addon, 'after');
$form_2->addHelper('Type at lease 2 characters', 'search-input-2');
$form_2->addInput('text', 'search-input-2', '', 'First name:', 'placeholder=Search here ...');

$form_2->endFieldset();

$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_2->addPlugin('autocomplete', '#search-input-2', 'remote', $replacements);

$form->addPlugin('ladda', '#search-form-2 .btn');

/* 3rd form (Ajax search with select multiple & tags) */

$form_3 = new Form('search-form-3', 'vertical', 'data-fv-no-icon=true, novalidate');
$form_3->setMode('development');

$form_3->startFieldset('3<sup>rd</sup> Search Form - Ajax search with multiple tags results');

$addon = '<button class="btn btn-success ladda-button" data-style="zoom-in" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>';
$form_3->addAddon('search-input-3', $addon, 'after');
$form_3->addHelper('Type at lease 2 characters', 'search-input-3');
$form_3->addInput('text', 'search-input-3', '', 'First name:', 'data-placeholder=Search here ...');

$form_3->endFieldset();

$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_3->addPlugin('autocomplete', '#search-input-3', 'remote-tags', $replacements);

$form->addPlugin('ladda', '#search-form-3 .btn');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4 Autocomplete Search Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap 4 Form Generator - how to create an autocompleting Search Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/search-form.php" />

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font awesome icons -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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
    <h1 class="text-center">Php Form Builder - Search Form<br><small>with JSON or Ajax  autocomplete</small></h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
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

    <!-- Bootstrap 4 JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
