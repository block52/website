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

$form = new Form('input-with-addons', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');


/* Input with icon
-------------------------------------------------- */

$form->startFieldset('Input with icon', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

$form->setCols(3, 9);

$form->addIcon('input-with-icon-after', '<i class="fa fa-user"></i>', 'after');
$form->addInput('text', 'input-with-icon-after', '', 'Your name');

$form->addIcon('input-with-icon-before', '<i class="fa fa-user"></i>', 'before');
$form->addInput('text', 'input-with-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-icon-and-helper', '<i class="fa fa-user"></i>', 'after');
$form->addHelper('Your name', 'input-with-icon-and-helper');
$form->addInput('text', 'input-with-icon-and-helper', '', '');

$form->addIcon('input-with-icon-and-placeholder', '<i class="fa fa-user"></i>', 'after');
$form->addInput('text', 'input-with-icon-and-placeholder', '', '', 'placeholder=Your name');

$form->endFieldset();

/* Input with Button
-------------------------------------------------- */

$form->startFieldset('Input with button', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

$form->setCols(3, 9);

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-after\').val(\'\');">cancel</button>';
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
$form->addInput('text', 'input-with-button-and-placeholder', '', '', 'placeholder=Your name');

$form->endFieldset();


/* Input with Text
-------------------------------------------------- */

$form->startFieldset('Input with text', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

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
$form->addInput('number', 'input-with-text-and-placeholder', '', '', 'placeholder=Number');

$form->endFieldset();

/* Input with Button & icon
-------------------------------------------------- */

$form->startFieldset('Input with button & icon', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

$form->setCols(3, 9);

$form->addIcon('input-with-button-and-icon-after', '<i class="fa fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-after\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-after', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-after', '', 'Your name');

$form->addIcon('input-with-button-and-icon-before', '<i class="fa fa-user"></i>', 'after');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-before\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-before', $addon, 'before');
$form->addInput('text', 'input-with-button-and-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-button-and-icon-and-helper', '<i class="fa fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-and-helper\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-and-helper', $addon, 'after');
$form->addHelper('Your name', 'input-with-button-and-icon-and-helper');
$form->addInput('text', 'input-with-button-and-icon-and-helper', '', '');

$form->addIcon('input-with-button-and-icon-and-placeholder', '<i class="fa fa-user"></i>', 'before');
$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#input-with-button-and-icon-and-placeholder\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-and-placeholder', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-and-placeholder', '', '', 'placeholder=Your name');

$form->endFieldset();

/* Input with date picker &amp; cancel button
-------------------------------------------------- */

$form->startFieldset('Input with date picker &amp; cancel button', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

$form->setCols(3, 9);

$addon = '<button class="btn btn-danger" type="button" onclick="$(\'#date-pickup\').val(\'\');">cancel</button>';
$form->addAddon('date-pickup', $addon, 'after');
$form->addInput('text', 'date-pickup', '', 'Pick a date please');
$form->addPlugin('pickadate', '#date-pickup');

$form->endFieldset();

/* Select with Button
-------------------------------------------------- */

$form->startFieldset('Select with button', 'style=padding-bottom:3rem;margin-bottom:3rem;border-bottom:1px solid #ccc;', 'class=text-muted');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-after', $addon, 'after');
$form->addOption('select-with-button-after', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-after', 'Mr', 'Mr');
$form->addOption('select-with-button-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-after', 'Prefix', 'class=selectpicker, required');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-before', $addon, 'before');
$form->addOption('select-with-button-before', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-before', 'Mr', 'Mr');
$form->addOption('select-with-button-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-before', 'Prefix', 'class=selectpicker, required');

$form->endFieldset();

/* Select with Button + icon
-------------------------------------------------- */

$form->startFieldset('Select with button &amp; icon', 'class=mb-5 pb-5', 'class=text-muted');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-and-icon-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-after', $addon, 'after');
$form->addIcon('select-with-button-and-icon-after', '<i class="fa fa-user"></i>', 'before');
$form->addOption('select-with-button-and-icon-after', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-after', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-after', 'Prefix', 'class=selectpicker, required');

$addon = '<button class="btn btn-warning" type="button" onclick="$(\'#select-with-button-and-icon-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-before', $addon, 'before');
$form->addIcon('select-with-button-and-icon-before', '<i class="fa fa-user"></i>', 'after');
$form->addOption('select-with-button-and-icon-before', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-before', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-before', 'Prefix', 'class=selectpicker, required');

$form->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 3 Form - Input with Addons examples - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create input and select with icon, button and text Addons with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/input-with-addons.php" />
        <!-- Link to Bootstrap css here -->
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
            AND REPLACE WITH BOOTSTRAP CSS
            FOR EXAMPLE <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
    <h1 class="text-center">Php Form Builder - Input and select with icon, button and text Addons</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <?php
            $form->render();
            ?>
            </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
