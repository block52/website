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


/* Input with icon
-------------------------------------------------- */

$form->startFieldset('Input with icon');

$form->setCols(3, 9);

$form->addIcon('input-with-icon-after', '<i class="material-icons" aria-hidden="true">person</i>', 'after');
$form->addInput('text', 'input-with-icon-after', '', 'Your name');

$form->addIcon('input-with-icon-before', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form->addInput('text', 'input-with-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-icon-after-2', '<i class="material-icons" aria-hidden="true">person</i>', 'after');
$form->addInput('text', 'input-with-icon-after-2', '', 'Your name');

$form->addIcon('input-with-icon-before-2', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form->addInput('text', 'input-with-icon-before-2', '', 'Your name');

$form->endFieldset();

/* Input with Button
-------------------------------------------------- */

$form->startFieldset('Input with button');

$form->setCols(3, 9);

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-after\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-after', $addon, 'after');
$form->addInput('text', 'input-with-button-after', '', 'Your name');

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-before\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-before', $addon, 'before');
$form->addInput('text', 'input-with-button-before', '', 'Your name');

$form->setCols(0, 12);

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-after-2\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-after-2', $addon, 'after');
$form->addInput('text', 'input-with-button-after-2', '', 'Your name');

$addon = '<button class="btn btn-secondary" type="button" onclick="$(\'#input-with-button-before-2\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-before-2', $addon, 'before');
$form->addInput('text', 'input-with-button-before-2', '', 'Your name');

$form->endFieldset();


/* Input with Text
-------------------------------------------------- */

$form->startFieldset('Input with text');

$form->setCols(3, 9);

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-after', $addon, 'after');
$form->addInput('number', 'input-with-text-after', '', 'Number');

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-before', $addon, 'before');
$form->addInput('number', 'input-with-text-before', '', 'Number');

$form->setCols(0, 12);

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-after-2', $addon, 'after');
$form->addInput('number', 'input-with-text-after-2', '', 'Number');

$addon = '<span class="input-group-text">$</span>';
$form->addAddon('input-with-text-before-2', $addon, 'before');
$form->addInput('number', 'input-with-text-before-2', '', 'Number');

$form->endFieldset();

/* Input with Button & icon
-------------------------------------------------- */

$form->startFieldset('Input with button & icon');

$form->setCols(3, 9);

$form->addIcon('input-with-button-and-icon-after', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$addon = '<button class="btn red" type="button" onclick="$(\'#input-with-button-and-icon-after\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-after', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-after', '', 'Your name');

$form->addIcon('input-with-button-and-icon-before', '<i class="material-icons" aria-hidden="true">person</i>', 'after');
$addon = '<button class="btn red" type="button" onclick="$(\'#input-with-button-and-icon-before\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-before', $addon, 'before');
$form->addInput('text', 'input-with-button-and-icon-before', '', 'Your name');

$form->setCols(0, 12);

$form->addIcon('input-with-button-and-icon-after-2', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$addon = '<button class="btn red" type="button" onclick="$(\'#input-with-button-and-icon-after-2\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-after-2', $addon, 'after');
$form->addInput('text', 'input-with-button-and-icon-after-2', '', 'Your name');

$form->addIcon('input-with-button-and-icon-before-2', '<i class="material-icons" aria-hidden="true">person</i>', 'after');
$addon = '<button class="btn red" type="button" onclick="$(\'#input-with-button-and-icon-before-2\').val(\'\');">cancel</button>';
$form->addAddon('input-with-button-and-icon-before-2', $addon, 'before');
$form->addInput('text', 'input-with-button-and-icon-before-2', '', 'Your name');

$form->endFieldset();

/* Input with date picker &amp; cancel button
-------------------------------------------------- */

$form->startFieldset('Input with date picker &amp; cancel button');

$addon = '<button class="btn red" type="button" onclick="$(\'#date-pickup\').val(\'\');">cancel</button>';
$form->addAddon('date-pickup', $addon, 'after');
$form->addInput('text', 'date-pickup', '', 'Pick a date please');
$form->addPlugin('material-datepicker', '#date-pickup');

$form->endFieldset();

/* Select with Button
-------------------------------------------------- */

$form->startFieldset('Select with button');

$addon = '<button class="btn orange darken-1 waves-effect waves-light" type="button" onclick="$(\'#select-with-button-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-after', $addon, 'after');
$form->addOption('select-with-button-after', '', 'Choose a prefix ...', '', 'disabled, selected');
$form->addOption('select-with-button-after', 'Mr', 'Mr');
$form->addOption('select-with-button-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-after', '', 'required');

$addon = '<button class="btn orange darken-1 waves-effect waves-light" type="button" onclick="$(\'#select-with-button-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-before', $addon, 'before');
$form->addOption('select-with-button-before', '', 'Choose a prefix ...', '', 'disabled, selected');
$form->addOption('select-with-button-before', 'Mr', 'Mr');
$form->addOption('select-with-button-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-before', '', 'required');

$form->endFieldset();

/* Select with Button + icon
-------------------------------------------------- */

$form->startFieldset('Select with button &amp; icon');

$addon = '<button class="btn orange darken-1 waves-effect waves-light" type="button" onclick="$(\'#select-with-button-and-icon-after\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-after', $addon, 'after');
$form->addIcon('select-with-button-and-icon-after', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form->addOption('select-with-button-and-icon-after', '', 'Choose a prefix ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-after', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-after', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-after', '', 'required');

$addon = '<button class="btn orange darken-1 waves-effect waves-light" type="button" onclick="$(\'#select-with-button-and-icon-before\').val(null).trigger(\'change\');">cancel</button>';
$form->addAddon('select-with-button-and-icon-before', $addon, 'before');
$form->addIcon('select-with-button-and-icon-before', '<i class="material-icons" aria-hidden="true">person</i>', 'after');
$form->addOption('select-with-button-and-icon-before', '', 'Choose a prefix ...', '', 'disabled, selected');
$form->addOption('select-with-button-and-icon-before', 'Mr', 'Mr');
$form->addOption('select-with-button-and-icon-before', 'Mrs', 'Mrs');
$form->addSelect('select-with-button-and-icon-before', '', 'required');

$form->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design - Input with Addons examples  - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create input and select with icon, button and text Addons with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/input-with-addons.php" />

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
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Material Design Input and select with icon, button and text Addons</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m10 offset-m1">
            <?php
            $form->render();
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
            $form->printJsCode();
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
               $('#input-with-addons select').formSelect();
            });
        </script>
        <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
