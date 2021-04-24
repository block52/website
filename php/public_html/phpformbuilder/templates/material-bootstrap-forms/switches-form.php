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

$form = new Form('switches-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#switches-form');

/* Checkboxes
-------------------------------------------------- */


$form->addHtml('<h2>Switches with Checkboxes - <small class="text-muted">Built using lcswitch plugin</small></h2>');

$form->startFieldset('Default checkbox switch');
$form->addCheckbox('vertical-checkbox', 'Label 1', 1, 'class=lcswitch mb-3');
$form->addCheckbox('vertical-checkbox', 'Label 2', 2, 'class=lcswitch mb-3, checked');
$form->printCheckboxGroup('vertical-checkbox', 'Vertical checkbox switch', false);
$form->addCheckbox('horizontal-checkbox', 'First', 1, 'class=lcswitch, checked');
$form->addCheckbox('horizontal-checkbox', 'Second', 2, 'class=lcswitch, checked');
$form->addCheckbox('horizontal-checkbox', 'Third', 3, 'class=lcswitch');
$form->printCheckboxGroup('horizontal-checkbox', 'Horizontal checkboxes');
$form->endFieldset();

$form->startFieldset('Dependent field - <small>Switch on the 1<sup>st</sup> switch to show the field below</small>');
$form->startDependentFields('vertical-checkbox', 1);
$form->addInput('text', 'name', 'value', 'label', 'required');
$form->endDependentFields();
$form->endFieldset();

$form->startFieldset('Styled checkbox switch');
$form->setCols(0, 12);
$form->addCheckbox('styled-checkbox', 'black', 1, 'class=lcswitch, data-theme=black, checked');
$form->addCheckbox('styled-checkbox', 'blue', 1, 'class=lcswitch, data-theme=blue, checked');
$form->addCheckbox('styled-checkbox', 'blue-gray', 1, 'class=lcswitch, data-theme=blue-gray, checked');
$form->addCheckbox('styled-checkbox', 'cyan', 1, 'class=lcswitch, data-theme=cyan, checked');
$form->addCheckbox('styled-checkbox', 'gray', 1, 'class=lcswitch, data-theme=gray, checked');
$form->addCheckbox('styled-checkbox', 'gray-dark', 1, 'class=lcswitch, data-theme=gray-dark, checked');
$form->addCheckbox('styled-checkbox', 'green', 1, 'class=lcswitch, data-theme=green, checked');
$form->addCheckbox('styled-checkbox', 'indigo', 1, 'class=lcswitch, data-theme=indigo, checked');
$form->addCheckbox('styled-checkbox', 'orange', 1, 'class=lcswitch, data-theme=orange, checked');
$form->addCheckbox('styled-checkbox', 'pink', 1, 'class=lcswitch, data-theme=pink, checked');
$form->addCheckbox('styled-checkbox', 'purple', 1, 'class=lcswitch, data-theme=purple, checked');
$form->addCheckbox('styled-checkbox', 'red', 1, 'class=lcswitch, data-theme=red, checked');
$form->addCheckbox('styled-checkbox', 'teal', 1, 'class=lcswitch, data-theme=teal, checked');
$form->addCheckbox('styled-checkbox', 'white', 1, 'class=lcswitch, data-theme=white, checked');
$form->addCheckbox('styled-checkbox', 'yellow', 1, 'class=lcswitch, data-theme=yellow, checked');
$form->printCheckboxGroup('styled-checkbox', '', true);
$form->endFieldset();

$form->startFieldset('Custom text checkbox switch + custom theme');
$form->setCols(3, 9);
$form->addCheckbox('horizontal-custom-checkbox', 'Apples?', 1, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red, checked');
$form->addCheckbox('horizontal-custom-checkbox', 'Bananas?', 2, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red');
$form->printCheckboxGroup('horizontal-custom-checkbox', 'Do you like:');
$form->endFieldset();


/* Radio buttons
-------------------------------------------------- */

$form->addHtml('<h2>Switches with Radio buttons - <small class="text-muted">Built using lcswitch plugin</small></h2>');

$form->startFieldset('Default radio switch');
$form->addRadio('vertical-radio', 'Label 1', 1, 'class=lcswitch, checked');
$form->addRadio('vertical-radio', 'Label 2', 2, 'class=lcswitch');
$form->printRadioGroup('vertical-radio', 'Vertical radio switch', false);
$form->addRadio('horizontal-radio', 'First', 1, 'class=lcswitch, checked');
$form->addRadio('horizontal-radio', 'Second', 2, 'class=lcswitch, checked');
$form->addRadio('horizontal-radio', 'Third', 3, 'class=lcswitch');
$form->printRadioGroup('horizontal-radio', 'Horizontal radios');
$form->endFieldset();

$form->startFieldset('Styled radio switch');
$form->setCols(0, 12);
$form->addRadio('styled-radio', 'black', 1, 'class=lcswitch, data-theme=black, checked');
$form->addRadio('styled-radio', 'blue', 1, 'class=lcswitch, data-theme=blue, checked');
$form->addRadio('styled-radio', 'blue-gray', 1, 'class=lcswitch, data-theme=blue-gray, checked');
$form->addRadio('styled-radio', 'cyan', 1, 'class=lcswitch, data-theme=cyan, checked');
$form->addRadio('styled-radio', 'gray', 1, 'class=lcswitch, data-theme=gray, checked');
$form->addRadio('styled-radio', 'gray-dark', 1, 'class=lcswitch, data-theme=gray-dark, checked');
$form->addRadio('styled-radio', 'green', 1, 'class=lcswitch, data-theme=green, checked');
$form->addRadio('styled-radio', 'indigo', 1, 'class=lcswitch, data-theme=indigo, checked');
$form->addRadio('styled-radio', 'orange', 1, 'class=lcswitch, data-theme=orange, checked');
$form->addRadio('styled-radio', 'pink', 1, 'class=lcswitch, data-theme=pink, checked');
$form->addRadio('styled-radio', 'purple', 1, 'class=lcswitch, data-theme=purple, checked');
$form->addRadio('styled-radio', 'red', 1, 'class=lcswitch, data-theme=red, checked');
$form->addRadio('styled-radio', 'teal', 1, 'class=lcswitch, data-theme=teal, checked');
$form->addRadio('styled-radio', 'white', 1, 'class=lcswitch, data-theme=white, checked');
$form->addRadio('styled-radio', 'yellow', 1, 'class=lcswitch, data-theme=yellow, checked');
$form->printRadioGroup('styled-radio', '', true);
$form->endFieldset();

$form->startFieldset('Custom text radio switch + custom theme');
$form->setCols(3, 9);
$form->addRadio('horizontal-custom-radio', 'Apples?', 1, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red, checked');
$form->addRadio('horizontal-custom-radio', 'Bananas?', 2, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=red');
$form->printRadioGroup('horizontal-custom-radio', 'Do you like:');
$form->endFieldset();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Form with radio buttons and checkboxes switches - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create switches from radio buttons and checkboxes">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/switches-form.php" />

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>

    <!-- Custom styles for demo -->
    <style type="text/css">
        label[for^="styled-checkbox"], label[for^="styled-radio"] {
            min-width: 180px;
            margin-left: 0 !important;
            padding-left: 0 !important;
        }
        fieldset {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Bootstrap Form<br><small>with radio and checkboxes switches</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-bootstrap-forms-notice.php';
        ?>

        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
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
