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
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('order-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('order-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form->setCols(0, 6, 'md');
$form->startFieldset('Order Form', 'class=fieldset');
$form->addHtml('<label>Full name</label>');
$form->groupInputs('first-name', 'last-name');
$form->addHelper('First name', 'first-name');
$form->addInput('text', 'first-name', '', '', 'required');
$form->addHelper('Last name', 'last-name');
$form->addInput('text', 'last-name', '', '', 'required');
$form->addHtml('<div class="grid-x grid-padding-x">');
$form->addHtml('<div class="medium-6 cell">');
$form->addHtml('<label>Email</label>');
$form->setCols(0, 12, 'md');
$form->addInput('email', 'email');
$form->addHtml('<label>Contact Number</label>');
$form->setCols(0, 4, 'md');
$form->groupInputs('area-code', 'phone-number');
$form->addHelper('Area Code', 'area-code');
$form->addInput('text', 'area-code', '', '', 'data-fv-regexp, data-fv-regexp-regexp=[+0-9-]+, data-fv-regexp-message=Please enter a valid Area Code');
$form->setCols(0, 8, 'md');
$form->addHelper('Valid US Phone Number', 'phone-number');
$form->addInput('text', 'phone-number', '', '', 'data-fv-phone, data-fv-phone-country=US');
$form->addHtml('</div>');
$form->addHtml('<div class="medium-6 cell">');
$form->addHtml('<label>Payment Method</label>');
$form->setCols(0, 12, 'md');
$form->addRadio('payment-method', '<img src="../assets/img/cb.png" alt="credit card">', 'credit-card');
$form->addRadio('payment-method', '<img src="../assets/img/paypal.png" alt="paypal">', 'paypal');
$form->printRadioGroup('payment-method', '', false);
$form->addHtml('</div>');
$form->addHtml('</div>');
$form->setCols(0, 2, 'md');
$form->addHtml('<label>Billing Address</label>');
$form->setCols(0, 12, 'md');
$form->addHelper('Street Address', 'street-address');
$form->addInput('text', 'street-address', '', '', 'required');
$form->addHelper('Street Address Line 2', 'street-address-2');
$form->addInput('text', 'street-address-2');
$form->setCols(0, 6, 'md');
$form->groupInputs('city', 'state');
$form->addHelper('City', 'city');
$form->addInput('text', 'city', '', '', 'required');
$form->addHelper('State / Province', 'state');
$form->addInput('text', 'state');
$form->groupInputs('zip-code', 'country');
$form->addHelper('Postal / Zip Code', 'zip-code');
$form->addInput('text', 'zip-code', '', '', 'required');
$form->addHelper('Country', 'country');

// preselect US
if (!isset($_SESSION['order-form']['country'])) {
    $_SESSION['order-form']['country'] = 'US';
}
$form->addCountrySelect('country', '', 'data-width=100%', array('flag_size' => 32, 'return_value' => 'code', 'placeholder' => 'Select your country'));
$form->setCols(0, 12);

// Inverted Dependent field - if non-US selected
$form->startDependentFields('country', 'US', true);
$form->addHtml('<label>Additional informations</label>');
$form->addTextarea('additional-informations');
$form->endDependentFields();
$form->setCols(4, 8);
$form->addBtn('submit', 'submit-btn', 1, 'Proceed <span class="fi fi-check append"></span>', 'class=success button');
$form->endFieldset();

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'red']);

// jQuery validation
$form->addPlugin('formvalidation', '#order-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Order Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create an Foundation Order Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/order-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">

    <!-- foundation icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Order Form<br><small>with Country select &amp; helpers</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
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

    <script src="//code.jquery.com/jquery.min.js"></script>
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
