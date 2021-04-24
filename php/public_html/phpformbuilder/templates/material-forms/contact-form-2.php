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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('contact-form-2') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('contact-form-2');

    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('user-email');

    // recaptcha validation
    $validator->recaptcha('6LcSY1oUAAAAAHXz7K72uP2thZT7xhZ5zc9Q5Vgc', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['contact-form-2'] = $validator->getAllErrors();
    } else {
        $_POST['message'] = nl2br($_POST['message']);
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Contact from Php Form Builder',
            'filter_values'   => 'contact-form-2',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('contact-form-2');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('contact-form-2', 'vertical', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Please fill in this form to contact us')->addInput('text', 'user-name', '', 'Your name : ', 'required')
    ->addInput('email', 'user-email', '', 'Your email : ', 'required')
    ->addHelper('Enter a valid US phone number', 'user-phone')
    ->addInput('text', 'user-phone', '', 'Your phone : ', 'data-intphone=true, data-fv-intphonenumber=true, data-initial-country=us, data-allow-dropdown=false, required')
    ->addTextarea('message', '', 'Your message : ', 'cols=30, rows=4, required')
    ->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100))
    ->addCheckbox('newsletter', '', 1, 'class=lcswitch mb-3, data-ontext=Yes, data-offtext=No, data-theme=yellow, checked=checked')
    ->printCheckboxGroup('newsletter', 'Suscribe to Newsletter')
    ->addInvisibleRecaptcha('6LcSY1oUAAAAAE6UUHkyTivIZvAO6DSU9Daqry8h')
    ->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in')
    ->endFieldset()

    // jQuery validation
    ->addPlugin('formvalidation', '#contact-form-2');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Contact Form Vertical - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Contact Form Vertical with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/contact-form-2.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Contact Form Vertical</h1>
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
