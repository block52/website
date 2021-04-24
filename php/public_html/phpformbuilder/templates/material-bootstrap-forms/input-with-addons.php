<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* ==================================================
    The Form
================================================== */

$form = new Form('input-with-addons', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#input-with-addons');

/* Input with icon
-------------------------------------------------- */

$form->startFieldset('Input with icon', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$form->setCols(3, 9);

$form->addIcon('input-with-icon-after', '<i class="fa fa-lg fa-user"></i>', 'after');
$form->addInput('text', 'input-with-icon-after', '', 'Your name');

$form->addIcon('input-with-icon-before', '<i class="fa fa-lg fa-user"></i>', 'before');
$form->addInput('text', 'input-with-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-icon-and-helper', '<i class="fa fa-lg fa-user"></i>', 'after');
$form->addHelper('Your name', 'input-with-icon-and-helper');
$form->addInput('text', 'input-with-icon-and-helper', '', '');

$form->addIcon('input-with-icon-and-placeholder', '<i class="fa fa-lg fa-user"></i>', 'after');
$form->addInput('text', 'input-with-icon-and-placeholder', '', 'Your name');

$form->endFieldset();

/* Input with Button
-------------------------------------------------- */

$form->startFieldset('Input with button', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$form->setCols(3, 9);

$addon = '<button class="btn btn-secondary" style="width:auto" type="button" onclick="$(\'#input-with-button-after\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-after', $addon, 'after');
$form->addInput('text', 'input-with-button-after', '', 'Your name');

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-before\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-before', $addon, 'before');
$form->addInput('text', 'input-with-button-before', '', 'Your name');

$form->setCols(0, 12);

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-and-helper\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-helper', $addon, 'after');
$form->addHelper('Your name', 'input-with-button-and-helper');
$form->addInput('text', 'input-with-button-and-helper', '', '');

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-and-placeholder\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-placeholder', $addon, 'after');
$form->addInput('text', 'input-with-button-and-placeholder', '', 'Your name');

$form->endFieldset();


/* Input with Text
-------------------------------------------------- */

$form->startFieldset('Input with text', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$form->setCols(3, 9);

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-after', $addon, 'after');
$form->addInput('number', 'input-with-text-after', '', 'Number');

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-before', $addon, 'before');
$form->addInput('number', 'input-with-text-before', '', 'Number');

$form->setCols(0, 12);

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-and-helper', $addon, 'after');
$form->addHelper('Number', 'input-with-text-and-helper');
$form->addInput('number', 'input-with-text-and-helper', '', '');

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-and-placeholder', $addon, 'after');
$form->addInput('number', 'input-with-text-and-placeholder', '', 'Number');

$form->endFieldset();

/* Input with Button & icon
-------------------------------------------------- */

$form->startFieldset('Input with button & icon', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$form->setCols(3, 9);

$form->addIcon('input-with-button-and-icon-after', '<i class="fa fa-lg fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-after\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-after', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-after', '', 'Your name');

$form->addIcon('input-with-button-and-icon-before', '<i class="fa fa-lg fa-user"></i>', 'after');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-before\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-before', $addon, 'before');
$form->addInput('text', 'input-with-button-and-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-button-and-icon-and-helper', '<i class="fa fa-lg fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-and-helper\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-and-helper', $addon, 'after');
$form->addHelper('Your name', 'input-with-button-and-icon-and-helper');
$form->addInput('text', 'input-with-button-and-icon-and-helper', '', '');

$form->addIcon('input-with-button-and-icon-and-placeholder', '<i class="fa fa-lg fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-and-placeholder\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-and-placeholder', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-and-placeholder', '', 'Your name');

$form->endFieldset();

/* Input with date picker &amp; cancel button
-------------------------------------------------- */

$form->startFieldset('Input with date picker &amp; cancel button', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$form->setCols(3, 9);

$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#date-pickup\').val(\'\');">cancel</button>';
$form->addAddon('date-pickup', $addon, 'after');
$form->addInput('text', 'date-pickup', '', 'Pick a date please');
$form->addPlugin('material-datepicker', '#date-pickup');

$form->endFieldset();

/* Select with Button
-------------------------------------------------- */

$form->startFieldset('Select with button', 'class=border-bottom mb-4 pb-4', 'class=text-muted pb-4');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-after', $addon, 'after');
$form->addOption('select-with-button-after', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-after', 'Mr', 'Mr');
$form->addOption('select-with-button-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-after', 'Prefix', 'required');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-before', $addon, 'before');
$form->addOption('select-with-button-before', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-before', 'Mr', 'Mr');
$form->addOption('select-with-button-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-before', 'Prefix', 'required');

$form->endFieldset();

/* Select with Button + icon
-------------------------------------------------- */

$form->startFieldset('Select with button &amp; icon', 'class=mb-5 pb-5', 'class=text-muted pb-4');
// $(\'#select-with-button-and-icon-after\').formSelect();
$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-and-icon-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-after', $addon, 'after');
$form->addIcon('select-with-button-and-icon-after', '<i class="fa fa-lg fa-user"></i>', 'before');
$form->addOption('select-with-button-and-icon-after', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-after', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-after', 'Prefix', 'required');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-and-icon-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-before', $addon, 'before');
$form->addIcon('select-with-button-and-icon-before', '<i class="fa fa-lg fa-user"></i>', 'after');
$form->addOption('select-with-button-and-icon-before', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-before', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-before', 'Prefix', 'required');

$form->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Bootstrap 4 - Input with Addons examples  - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Bootstrap 4 Form Generator - how to create input and select with icon, button and text Addons with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/input-with-addons.php" />

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font awesome icons -->

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Material Design Bootstrap 4 Input and select with icon, button and text Addons</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-bootstrap-forms-notice.php';
        ?>

        <div class="row justify-content-center">
            <div class="col-sm-8">
            <?php
            $form->render();
            ?>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <!-- Bootstrap 4 JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <?php
            $form->printIncludes('js');
            $form->printJsCode();
        ?>
        <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
