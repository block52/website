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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('sign-up-popover-form-1') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('sign-up-popover-form-1');

    // additional validation
    $validator->hasLowercase()->hasUppercase()->hasNumber()->hasSymbol()->minLength(8)->validate('user-password');
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['sign-up-popover-form-1'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Sign Up Popover Form',
            'filter_values'   => 'sign-up-popover-form-1, captcha',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('sign-up-popover-form-1');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('sign-up-popover-form-1', 'vertical', 'novalidate', 'material');
// $form->setMode('development');

$form->setCols(0, 12);

$form->addInput('text', 'user-name', '', 'username', 'required');
$form->addInput('email', 'user-email', '', 'e-mail address', 'required');
$form->addPlugin('passfield', '#user-password', 'lower-upper-number-symbol-min8');
$form->addHelper('password must contain lowercase + uppercase letters + number + symbol and be 8 characters long', 'user-password');
$form->addInput('password', 'user-password', '', 'password', 'required');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Sign Up <i class="material-icons right">email</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in');

// popover plugin
$form->popover('#popover-link');

// jQuery validation
$form->addPlugin('formvalidation', '#sign-up-popover-form-1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Material Design Sign Up Popover Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Sign Up Popover Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/sign-up-form-popover.php" />

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
    <style type="text/css">
        body {
            min-height: 2000px;
        }
        #popover-link {
            position: fixed;
            left: 0;
            top: 48%;
        }
    </style>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Sign Up Modal Form<br><small>click to open Popover</small></h1>
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
            <!-- Button trigger popover -->
            <a href="#" id="popover-link" data-width="600" data-placement="right" class="waves-effect waves-light btn-large">Sign Up</a>
            <?php
                $form->render();
            ?>
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
