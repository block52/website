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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('order-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('order-form');

    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['order-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['email']),
            'subject'         => 'Php Form Builder - Order Form',
            'filter_values'   => 'order-form',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('order-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('order-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

$form->setCols(0, 12);
$form->startFieldset('Order Form');
$form->addHtml('<label>Full name</label>');
$form->groupInputs('first-name', 'last-name');
$form->addInput('text', 'first-name', '', 'First name', 'required');
$form->addInput('text', 'last-name', '', 'Last name', 'required');
$form->addHtml('<div class="row">');
$form->addHtml('<div class="col m6">');
$form->addHtml('<label>Email</label>');
$form->addInput('email', 'email', '', 'Email');
$form->addHtml('<label>Contact Number</label>');
$form->setCols(0, 4);
$form->groupInputs('area-code', 'phone-number');
$form->addInput('text', 'area-code', '', 'Area Code', 'data-fv-regexp, data-fv-regexp-regexp=[+0-9-]+, data-fv-regexp-message=Please enter a valid Area Code');
$form->setCols(0, 8);
$form->addInput('text', 'phone-number', '', 'Valid US Phone Number', 'data-fv-phone, data-fv-phone-country=US');
$form->addHtml('</div>');
$form->addHtml('<div class="col m6">');
$form->addHtml('<label>Payment Method</label>');
$form->setCols(0, 12);
$form->addRadio('payment-method', '<img src="../assets/img/cb.png" alt="credit card">', 'credit-card');
$form->addRadio('payment-method', '<img src="../assets/img/paypal.png" alt="paypal">', 'paypal');
$form->printRadioGroup('payment-method', '', false);
$form->addHtml('</div>');
$form->addHtml('</div>');
$form->setCols(0, 2);
$form->addHtml('<label>Billing Address</label>');
$form->setCols(0, 12);
$form->addInput('text', 'street-address', '', 'Street Address', 'required');
$form->addInput('text', 'street-address-2', '', 'Street Address Line 2');
$form->setCols(0, 6);
$form->groupInputs('city', 'state');
$form->addInput('text', 'city', '', 'City', 'required');
$form->addInput('text', 'state', '', 'State / Province');
$form->groupInputs('zip-code', 'country');
$form->addInput('text', 'zip-code', '', 'Postal / Zip Code', 'required');
$form->addHelper('Country', 'country');

// preselect US
if (!isset($_SESSION['order-form']['country'])) {
    $_SESSION['order-form']['country'] = 'US';
}
$form->addCountrySelect('country', '', '', array('flag_size' => 16, 'return_value' => 'code', 'placeholder' => 'Select your country'));
$form->setCols(0, 12);

// Inverted Dependent field - if non-US selected
$form->startDependentFields('country', 'US', true);
$form->addHtml('<label>Additional informations</label>');
$form->addTextarea('additional-informations');
$form->endDependentFields();
$form->setCols(4, 8);
$form->addBtn('submit', 'submit-btn', 1, 'Proceed <i class="material-icons right">check</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#order-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Order Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create an Material Design Order Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/order-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Order Form<br><small>with Country select &amp; helpers</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m11 l10">
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

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

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
