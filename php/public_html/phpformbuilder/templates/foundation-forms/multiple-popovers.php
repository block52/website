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
    if (Form::testToken('contact-form-popover-mp') === true) {
        /* contact-form-popover-mp validation & email */

        // create validator & auto-validate required fields
        $validator = Form::validate('contact-form-popover-mp');

        // additional validation
        $validator->maxLength(100)->validate('message');
        $validator->email()->validate('user-email');
        $validator->captcha('captcha')->validate('captcha');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['contact-form-popover-mp'] = $validator->getAllErrors();
        } else {
            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['user-email']),
                'subject'         => 'Php Form Builder - Contact Form',
                'filter_values'   => 'contact-form-popover-mp',
                'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('contact-form-popover-mp');
        }
    } elseif (Form::testToken('join-us-popover-form-mp') === true) {
        /*join-us-popover-form-mp validation & email */

        // create validator & auto-validate required fields
        $validator = Form::validate('join-us-popover-form-mp');

        // additional validation
        $validator->email()->validate('join-us-user-email');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['join-us-popover-form-mp'] = $validator->getAllErrors();
        } else {
            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['join-us-user-email']),
                'subject'         => 'Php Form Builder - Join Us Popover Form',
                'filter_values'   => 'join-us-popover-form-mp',
                'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('join-us-popover-form-mp');
        }
    }
}

/* ==================================================
    The Contact Form
================================================== */

$form = new Form('contact-form-popover-mp', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form->startFieldset('Please fill in this form to contact us');
$form->addHtml('<p class="text-warning">All fields are required</p>');
$form->groupInputs('user-name', 'user-first-name');
$form->setCols(0, 6, 'xs');
$form->addIcon('user-name', '<i class="input-group-label fi fi-torso"></i>', 'before');
$form->addInput('text', 'user-name', '', '', 'class=input-group-field, placeholder=Name, required');
$form->addIcon('user-first-name', '<i class="input-group-label fi-torso"></i>', 'before');
$form->addInput('text', 'user-first-name', '', '', 'class=input-group-field, placeholder=First Name, required');
$form->setCols(0, 12, 'xs');
$form->addIcon('user-email', '<i class="input-group-label fi fi-mail"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'class=input-group-field, placeholder=Email, required');
$form->addIcon('user-phone', '<i class="input-group-label fi fi-telephone"></i>', 'before');
$form->addHelper('Enter a valid US phone number', 'user-phone');
$form->addInput('text', 'user-phone', '', '', 'class=input-group-field, placeholder=Phone, data-fv-phone, data-fv-phone-country=US, required');
$form->addTextarea('message', '', 'Your message', 'cols=30, rows=4, required');
$form->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));
$form->addCheckbox('newsletter', 'Suscribe to Newsletter', 1, 'checked=checked');
$form->printCheckboxGroup('newsletter', '');
$form->setCols(3, 9, 'sm');
$form->addInput('text', 'captcha', '', 'Type the following characters :', 'size=15');
$form->addPlugin('captcha', '#captcha');
$form->setCols(-1, -1);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="fi-mail append"></i>', 'class=success button');
$form->endFieldset();

// popover plugin
$form->popover('#popover-link');

// nice check plugin
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'blue']);

// jQuery validation
$form->addPlugin('formvalidation', '#contact-form-popover-mp');

/* ==================================================
    The Join Us Form
================================================== */

$form_2 = new Form('join-us-popover-form-mp', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form_2->setCols(0, 12);

$form_2->startFieldset();
$form_2->addHtml('<h4>Get Free Email Updates!<br><small>Join us for FREE to get instant email updates!</small></h4>');
$form_2->addIcon('join-us-user-name', '<i class="input-group-label fi fi-torso"></i>', 'before');
$form_2->addInput('text', 'join-us-user-name', '', '', 'class=input-group-field, placeholder=Your Name, required');
$form_2->addIcon('join-us-user-email', '<i class="input-group-label fi fi-mail"></i>', 'before');
$form_2->addInput('email', 'join-us-user-email', '', '', 'class=input-group-field, placeholder=Email, required');
$form_2->addHtml('<p class="float-right"><small><i class="fi fi-lock prepend"></i>Your Information is Safe With us!</small></p>');
$form_2->centerButtons(true);
$form_2->addBtn('submit', 'join-us-submit-btn', 1, 'Get Access Today<i class="fi fi-unlock append"></i>', 'class=button primary');
$form_2->endFieldset();

// popover plugin
$form_2->popover('#popover-link-2');

// jQuery validation
$form_2->addPlugin('formvalidation', '#join-us-popover-form-mp');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Multiple popover forms - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create several popover forms on same page with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/multiple-popovers.php" />

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
    <style type="text/css">
        body {
            min-height: 2000px;
        }
        #popover-link {
            position: fixed;
            right: 0;
            top: 48%;
        }
    </style>
    <?php
        $form->printIncludes('css');
        $form_2->printIncludes('css');
    ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - several Popover Forms on same page<br><small>click to sign up or contact</small></h1>
    <div class="container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 column">
                <?php
                if (isset($sent_message)) {
                    echo $sent_message;
                }
                ?>
                <a href="#" id="popover-link" data-width="600" data-placement="left" class="button primary large">Contact Us</a>
                <a href="#" id="popover-link-2" data-width="600" data-placement="right" class="button primary large">Join Us</a>
                <?php
                    $form->render();
                    $form_2->render();
                ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>
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
