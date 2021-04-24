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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('booking-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('booking-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['booking-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Booking Form',
            'filter_values'   => 'booking-form, date_submit, time_submit'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('booking-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('booking-form', 'horizontal', 'novalidate', 'material');
$form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#booking-form');

$form->startFieldset('Please fill the form below');
$form->setCols(0, 6);
$form->groupInputs('first-name', 'last-name');
$form->addInput('text', 'first-name', '', 'First name', 'required');
$form->addInput('text', 'last-name', '', 'Last name', 'required');
$form->setCols(0, 12);
$form->addInput('email', 'user-email', '', 'E-Mail', 'required');
$form->addHelper('Enter a valid phone number', 'phone-number');
$form->addInput('tel', 'phone-number', '', '', 'placeholder=Phone Number, data-intphone=true, data-fv-intphonenumber=true, required');
$form->addInput('number', 'number-of-guests', '', 'Number of Guests:', 'data-fv-integer, required');
$form->setCols(0, 8);
$form->groupInputs('date', 'time');
$form->addInput('text', 'date', '', 'Date', 'data-min-date=' . date('Y-m-d') . ', required');
$form->setCols(0, 4);
$form->addInput('text', 'time', '', 'Time', 'required');
$form->setCols(0, 12);
$form->addOption('reservation-type', 'Dinner', 'Dinner', '', 'data-icon=fa fa-cutlery');
$form->addOption('reservation-type', 'Birthday/ Anniversary', 'Birthday/ Anniversary', '', 'data-icon=fa fa-birthday-cake');
$form->addOption('reservation-type', 'Nightlife', 'Nightlife', '', 'data-icon=fa fa-moon-o');
$form->addOption('reservation-type', 'Private', 'Private', '', 'data-icon=fa fa-user-secret');
$form->addOption('reservation-type', 'Wedding', 'Wedding', '', 'data-icon=fa fa-heart');
$form->addOption('reservation-type', 'Corporate', 'Corporate', '', 'data-icon=fa fa-briefcase');
$form->addOption('reservation-type', 'Other', 'Other', '', 'data-icon=fa fa-star');
$form->addSelect('reservation-type', 'Reservation Type', 'class=select2 browser-default no-autoinit, data-minimum-results-for-search=-1, required');
$form->startDependentFields('reservation-type', 'Other');
$form->addInput('text', 'reservation-type-other', '', '', 'placeholder=Please tell more ..., required');
$form->endDependentFields();
$form->addTextarea('special-request', '', 'Any Special Request ? ');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit <i class="fa fa-arrow-right fa-fw"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->endFieldset();

// material datepicker
$form->addPlugin('material-datepicker', '#date');

// material timepicker
$form->addPlugin('material-timepicker', '#time');

// jQuery validation
$form->addPlugin('formvalidation', '#booking-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Bootstrap 4 Booking Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Bootstrap 4 Form Generator - how to create a Booking Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/booking-form.php" />

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
    <h1 class="text-center">Php Form Builder - Material Design Bootstrap 4 Booking Form</h1>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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
