<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('dependent-fields') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('dependent-fields');

    // additional validation

    // recaptcha validation
    $validator->recaptcha('6LeNWaQUAAAAAOnei_86FAp7aRZCOhNwK3e2o2x2', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['dependent-fields'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => 'gilles.migliori@gmail.com',
            'subject'         => 'Php Form Builder - Contact Form',
            'filter_values'   => 'dependent-fields'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('dependent-fields');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('dependent-fields', 'horizontal', 'data-fv-no-icon=true, novalidate');
// $form->setMode('development');

/* Select */

$form->startFieldset('Hidden fields depend on Select value');
$form->addHelper('If other, please tell us more ... ', 'subject');
$form->addOption('subject', 'Support', 'Support', '', 'data-icon=fa fa-info-circle');
$form->addOption('subject', 'Sales', 'Sales', '', 'data-icon=fa fa-usd');
$form->addOption('subject', 'Other', 'Other', '', 'data-icon=fa fa-question-circle');
$form->addSelect('subject', 'Your request concerns ...', 'class=selectpicker, required');
$form->startDependentFields('subject', 'Other');
$form->addInput('text', 'subject-other', '', '', 'placeholder=Please tell more about your request ...');
$form->endDependentFields();

// preselect US
if (!isset($_SESSION['dependent-fields']['country'])) {
    $_SESSION['dependent-fields']['country'] = 'US';
}
$form->addHelper('Enter Additional informations if <strong>non-US</strong>', 'country');
$options = array(
    'plugin'       => 'bootstrap-select',
    'lang'         => 'en',
    'flags'        => true,
    'flag_size'    => 16,
    'return_value' => 'code',
);
$form->addCountrySelect('country', 'country: ', 'title=Select a country', $options);

// Inverted Dependent field - if non-US selected
$form->startDependentFields('country', 'US', true);
$form->addTextarea('additional-informations', '', 'Additional informations');
$form->endDependentFields();
$form->endFieldset();

/* Radio */

$form->startFieldset('Hidden fields depend on Radio value');
$form->setCols(0, 12);
$form->addRadio('radio_group_1', 'Show dependent fields', 1);
$form->addRadio('radio_group_1', 'Hide dependent fields', 0);
$form->printRadioGroup('radio_group_1', '', true, 'required');
$form->startDependentFields('radio_group_1', 1);
$form->groupInputs('civility', 'name');
$form->setCols(3, 2);
$form->addOption('civility', 'M.', 'M.');
$form->addOption('civility', 'Mrs', 'M<sup>rs</sup>');
$form->addOption('civility', 'Ms', 'M<sup>s</sup>');
$form->addSelect('civility', 'Civility', 'class=select2, required');
$form->setCols(2, 5);
$form->addInput('text', 'name', '', 'Name', 'required');
$form->setCols(3, 9);

// Dependent field inside previous one
$form->startDependentFields('civility', 'Mrs');
$form->addInput('text', 'maiden_name', '', 'Maiden Name');
$form->endDependentFields();
$form->endDependentFields();
$form->endFieldset();

/* Checkbox */

$form->startFieldset('Hidden fields depend on Checkbox value');
$form->addCheckbox('checkbox_group_1', 'Show', 1);
$form->addCheckbox('checkbox_group_1', 'Do nothing special', 0);
$form->printCheckboxGroup('checkbox_group_1', 'Show dependent field if "show" is checked');
$form->startDependentFields('checkbox_group_1', 1);
$form->addInput('text', 'your_name', '', 'Your Name');
$form->endDependentFields();

$form->addCheckbox('checkbox_group_2', 'Red', 'Red');
$form->addCheckbox('checkbox_group_2', 'Blue', 'Blue');
$form->addCheckbox('checkbox_group_2', 'Green', 'Green');
$form->addCheckbox('checkbox_group_2', 'Yellow', 'Yellow');
$form->printCheckboxGroup('checkbox_group_2', 'Show dependent field if any other than 1st is checked');
$form->startDependentFields('checkbox_group_2', 'Red', true);
$form->addRadio('are_you_sure', 'No', 0);
$form->addRadio('are_you_sure', 'Yes', 1);
$form->printRadioGroup('are_you_sure', 'Are you sure ?');
$form->endDependentFields();
$form->endFieldset();

/* Nested */

$form->startFieldset('Nested dependent fields');
$form->addRadio('level_1', 'Show level 1', 1);
$form->addRadio('level_1', 'Hide level 1', 0);
$form->printRadioGroup('level_1', '', true, 'required');

// START level 1
$form->startDependentFields('level_1', 1);

$form->addRadio('level_2', 'Show level 2', 1);
$form->addRadio('level_2', 'Hide level 2', 0);
$form->printRadioGroup('level_2', '', true, 'required');

// START level 2
$form->startDependentFields('level_2', 1);

$form->addInput('text', 'level-2-field', '', 'Level 2 field', 'required');


// END level 2
$form->endDependentFields();

// END level 1
$form->endDependentFields();

$form->setCols(3, 9, 'sm');
$form->addRecaptchaV3('6LeNWaQUAAAAAGO_c1ORq2wla-PEFlJruMzyH5L6', 'bs4-dependent-fields');
$form->addBtn('reset', 'reset-btn', 1, 'Reset <i class="fa fa-ban" aria-hidden="true"></i>', 'class=btn btn-warning', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="fa fa-envelope ml-2" aria-hidden="true"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'my-btn-group');
$form->printBtnGroup('my-btn-group');

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'purple']);

// jQuery validation
$form->addPlugin('formvalidation', '#dependent-fields');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4 Dependent fields Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap 4 Form Generator - how to create a Form with Dependent fields using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/dependent-fields.php" />

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
    <?php $form->printIncludes('css'); ?>
    <style type="text/css">
        fieldset {
            margin-bottom: 80px;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Bootstrap 4 Form with Dependent fields<br><small>Hidden fields shown if special values selected</small></h1>
    <div class="container">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
