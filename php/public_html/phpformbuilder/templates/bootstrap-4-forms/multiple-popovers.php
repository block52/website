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
                'filter_values'   => 'contact-form-popover-mp'
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
                'filter_values'   => 'join-us-popover-form-mp'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('join-us-popover-form-mp');
        }
    }
}

/* ==================================================
    The Contact Form
================================================== */

$form = new Form('contact-form-popover-mp', 'horizontal', 'data-fv-no-icon=true, novalidate');
// $form->setMode('development');

$form->startFieldset('Please fill in this form to contact us');
$form->addHtml('<p class="text-warning">All fields are required</p>');
$form->groupInputs('user-name', 'user-first-name');
$form->setCols(0, 6);
$form->addIcon('user-name', '<i class="fa fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Name, required');
$form->addIcon('user-first-name', '<i class="fa fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-first-name', '', '', 'placeholder=First Name, required');
$form->setCols(0, 12);
$form->addIcon('user-email', '<i class="fa fa-envelope" aria-hidden="true"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Email, required');
$form->addIcon('user-phone', '<i class="fa fa-phone" aria-hidden="true"></i>', 'before');
$form->addHelper('Enter a valid US phone number', 'user-phone');
$form->addInput('text', 'user-phone', '', '', 'placeholder=Phone, data-fv-phone, data-fv-phone-country=US, required');

// Set custom class for the vertical label
$options = array(
        'horizontalLabelClass' => 'col-form-label w-100 ml-3'
);
$form->setOptions($options);
$form->addTextarea('message', '', 'Your message', 'cols=30, rows=4, required');
$form->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));

// revert to default label
$options = array(
        'horizontalLabelClass' => 'col-form-label'
);
$form->setOptions($options);
$form->addCheckbox('newsletter', 'Suscribe to Newsletter', 1, 'checked=checked');
$form->printCheckboxGroup('newsletter', '');
$form->setCols(3, 9);
$form->addInput('text', 'captcha', '', 'Type the following characters :', 'size=15');
$form->addPlugin('captcha', '#captcha');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="fa fa-envelope ml-2" aria-hidden="true"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->endFieldset();

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'green']);

// popover plugin
$form->popover('#popover-link');

// jQuery validation
$form->addPlugin('formvalidation', '#contact-form-popover-mp');

/* ==================================================
    The Join Us Form
================================================== */

$form_2 = new Form('join-us-popover-form-mp', 'horizontal', 'data-fv-no-icon=true, novalidate');
// $form->setMode('development');

$form_2->setCols(0, 12);

$form_2->startFieldset();
$form_2->addHtml('<h4>Get Free Email Updates!<br><small>Join us for FREE to get instant email updates!</small></h4>');
$form_2->addIcon('join-us-user-name', '<i class="fa fa-user" aria-hidden="true"></i>', 'before');
$form_2->addInput('text', 'join-us-user-name', '', '', 'placeholder=Your Name, required');
$form_2->addIcon('join-us-user-email', '<i class="fa fa-envelope" aria-hidden="true"></i>', 'before');
$form_2->addInput('email', 'join-us-user-email', '', '', 'placeholder=Email, required');
$form_2->addHtml('<p class="text-right mb-5"><small><i class="fa fa-lock fa-fw"></i>Your Information is Safe With us!</small></p>');
$form_2->centerButtons(true);
$form_2->addBtn('submit', 'join-us-submit-btn', 1, 'Get Access Today<i class="fa fa-unlock fa-lg fa-fw pull-right"></i>', 'class=btn btn-lg btn-success ladda-button mb-2, data-style=zoom-in');
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4 Multiple popover forms - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap 4 Form Generator - how to create several popover forms on same page with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/multiple-popovers.php" />

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
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <?php
                if (isset($sent_message)) {
                    echo $sent_message;
                }
                ?>
                <a href="#" id="popover-link" data-width="600" data-placement="left" class="btn btn-primary text-white btn-lg">Contact Us</a>
                <a href="#" id="popover-link-2" data-width="600" data-placement="right" class="btn btn-primary text-white btn-lg">Join Us</a>
                <?php
                    $form->render();
                    $form_2->render();
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
