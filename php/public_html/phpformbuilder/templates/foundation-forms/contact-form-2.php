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
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('contact-form-2');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('contact-form-2', 'vertical', 'novalidate', 'foundation');
// $form->setMode('development');
$form->startFieldset('Please fill in this form to contact us')
    ->addInput('text', 'user-name', '', 'Your name : ', 'class=input, required')
    ->addInput('email', 'user-email', '', 'Your email : ', 'required')
    ->addHelper('Enter a valid US phone number', 'user-phone')
    ->addInput('tel', 'user-phone', '', 'Your phone : ', 'data-intphone=true, data-fv-intphonenumber=true, data-initial-country=us, data-allow-dropdown=false, required')
    ->addTextarea('message', '', '', 'cols=30, rows=4, required')
    ->addCheckbox('newsletter', '', 1, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=yellow, checked=checked')
    ->printCheckboxGroup('newsletter', 'Suscribe to Newsletter', true)
    ->addInvisibleRecaptcha('6LcSY1oUAAAAAE6UUHkyTivIZvAO6DSU9Daqry8h')
    ->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=button primary')
    ->endFieldset()

    // word-character-count plugin
    ->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100))

    // jQuery validation
    ->addPlugin('formvalidation', '#contact-form-2');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Contact Form Vertical - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Contact Form Vertical with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/contact-form-2.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Foundation Contact Form Vertical</h1>
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
