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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (Form::testToken('sign-up-modal-form-mp') === true) {
        // create validator & auto-validate required fields
        $validator = Form::validate('sign-up-modal-form-mp');

        // additional validation
        $validator->hasLowercase()->hasUppercase()->hasNumber()->hasSymbol()->minLength(8)->validate('sign-up-user-password');
        $validator->email()->validate('sign-up-user-email');

        // recaptcha validation
        $validator->recaptcha('6Ldg0QkUAAAAALUTA_uzlAEJP4fvm2SWtcGZ33Gc', 'Recaptcha Error')->validate('g-recaptcha-response');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['sign-up-modal-form-mp'] = $validator->getAllErrors();
        } else {
            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['sign-up-user-email']),
                'subject'         => 'Php Form Builder - Sign Up Modal Form',
                'filter_values'   => 'sign-up-modal-form-mp',
                'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('sign-up-modal-form-mp');
        }
    } elseif (Form::testToken('contact-form-modal-mp') === true) {
        // create validator & auto-validate required fields
        $validator = Form::validate('contact-form-modal-mp');

        // additional validation
        $validator->maxLength(100)->validate('message');
        $validator->email()->validate('user-email');

        // recaptcha validation
        $validator->recaptcha('6Ldg0QkUAAAAALUTA_uzlAEJP4fvm2SWtcGZ33Gc', 'Recaptcha Error')->validate('g-recaptcha-response');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['contact-form-modal-mp'] = $validator->getAllErrors();
        } else {
            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['user-email']),
                'subject'         => 'Php Form Builder - Contact Form',
                'filter_values'   => 'contact-form-modal-mp',
                'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('contact-form-modal-mp');
        }
    }
}

/* ==================================================
    The Sign Up Form
================================================== */

$form = new Form('sign-up-modal-form-mp', 'vertical', 'novalidate', 'material');
// $form->setMode('development');
$form->addInput('text', 'sign-up-user-name', '', 'username', 'required');
$form->addInput('email', 'sign-up-user-email', '', 'e-mail address', 'required');
$form->addPlugin('passfield', '#sign-up-user-password', 'lower-upper-number-symbol-min8');
$form->addHelper('password must contain lowercase + uppercase letters + number + symbol and be 8 characters long', 'sign-up-user-password');
$form->addInput('password', 'sign-up-user-password', '', 'password', 'required');
$form->centerButtons(true);
$form->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha', true);
$form->addBtn('button', 'sign-up-cancel-btn', 1, 'Cancel', 'class=btn btn-default, data-modal-close=modal-target', 'submit_group');
$form->addBtn('submit', 'sign-up-submit-btn', 1, 'Send <i class="material-icons right">done</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'submit_group');
$form->printBtnGroup('submit_group');

// modal plugin
$form->modal('#modal-target');

// jQuery validation
$form->addPlugin('formvalidation', '#sign-up-modal-form-mp');

/* ==================================================
    The Contact Form
================================================== */

$form_2 = new Form('contact-form-modal-mp', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$form_2->startFieldset('Please fill in this form to contact us');
$form_2->addHtml('<p class="text-warning">All fields are required</p>');
$form_2->groupInputs('user-name', 'user-first-name');
$form_2->setCols(0, 6);
$form_2->addIcon('user-name', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form_2->addInput('text', 'user-name', '', '', 'placeholder=Name, required');
$form_2->addIcon('user-first-name', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form_2->addInput('text', 'user-first-name', '', '', 'placeholder=First Name, required');
$form_2->setCols(0, 12);
$form_2->addIcon('user-email', '<i class="material-icons" aria-hidden="true">mail_outline</i>', 'before');
$form_2->addInput('email', 'user-email', '', '', 'placeholder=Email, required');
$form_2->addIcon('user-phone', '<i class="material-icons" aria-hidden="true">phone</i>', 'before');
$form_2->addHtml('<span class="help-block">Enter a valid US phone number</span>', 'user-phone', 'after');
$form_2->addInput('text', 'user-phone', '', '', 'placeholder=Phone, data-fv-phone, data-fv-phone-country=US, required');
$form_2->addTextarea('message', '', '', 'cols=30, rows=4, placeholder=Message, required');
$form_2->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));
$form_2->addCheckbox('newsletter', 'Suscribe to Newsletter', 1, 'checked=checked');
$form_2->printCheckboxGroup('newsletter', '');
$form_2->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha2', true);
$form_2->centerButtons(true);
$form_2->addBtn('reset', 'reset-btn', 1, 'Reset <i class="material-icons right">cancel</i>', 'class=btn orange darken-1 waves-effect waves-light', 'my-btn-group');
$form_2->addBtn('submit', 'submit-btn', 1, 'Send <i class="material-icons right">done</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'my-btn-group');
$form_2->printBtnGroup('my-btn-group');
$form_2->endFieldset();

// modal plugin
$form_2->modal('#modal-target-2');

// jQuery validation
$form_2->addPlugin('formvalidation', '#contact-form-modal-mp');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Multiple modal forms - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create several modal forms on same page with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/multiple-modals.php" />

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
    <?php $form_2->printIncludes('css'); ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - several Material Design Modal Forms on same page<br><small>click to sign up or contact</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            ?>
            <!-- Button trigger modal -->
            <div class="center-align">
                <a data-remodal-target="modal-target" class="waves-effect waves-light btn-large">Sign Up</a>
                <a data-remodal-target="modal-target-2" class="waves-effect waves-light btn-large">Contact Us</a>
            </div>
            <?php
                $form->render();
                $form_2->render();
            ?>
        </div>
    </div>

    <!-- jQuery -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?php
        $form->printIncludes('js');
        $form_2->printIncludes('js');
        $form->printJsCode();
        $form_2->printJsCode();
    ?>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
