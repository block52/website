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
                'filter_values'   => 'sign-up-modal-form-mp'
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
            $from_email = 'contact@phpformbuilder.pro';
            $address = addslashes($_POST['user-email']);
            $subject = 'phpformbuilder - Contact Form 1';
            $filter_values = 'contact-form-modal-mp, captcha, captchaHash';
            $sent_message = Form::sendMail($from_email, $address, $subject, $filter_values);

            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['user-email']),
                'subject'         => 'Php Form Builder - Contact Form',
                'filter_values'   => 'contact-form-modal-mp'
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('contact-form-modal-mp');
        }
    }
}

/* ==================================================
    The Sign Up Form
================================================== */

$form = new Form('sign-up-modal-form-mp', 'vertical', 'novalidate', 'bs3');
// $form->setMode('development');
$form->startFieldset('Create your account');
$form->addInput('text', 'sign-up-user-name', '', 'username', 'required');
$form->addInput('email', 'sign-up-user-email', '', 'e-mail address', 'required');
$form->addPlugin('passfield', '#sign-up-user-password', 'lower-upper-number-symbol-min8');
$form->addHelper('password must contain lowercase + uppercase letters + number + symbol and be 8 characters long', 'sign-up-user-password');
$form->addInput('password', 'sign-up-user-password', '', 'password', 'required');
$form->centerButtons(true);
$form->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha', true);
$form->addBtn('button', 'sign-up-cancel-btn', 1, 'Cancel', 'class=btn btn-default, data-modal-close=modal-target', 'submit_group');
$form->addBtn('submit', 'sign-up-submit-btn', 1, 'Send <span class="glyphicon glyphicon-envelope append"></span>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'submit_group');
$form->printBtnGroup('submit_group');
$form->endFieldset();

// modal plugin
$form->modal('#modal-target');

// jQuery validation
$form->addPlugin('formvalidation', '#sign-up-modal-form-mp');

/* ==================================================
    The Contact Form
================================================== */

$form_2 = new Form('contact-form-modal-mp', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');

$form_2->startFieldset('Please fill in this form to contact us');
$form_2->addHtml('<p class="text-warning">All fields are required</p>');
$form_2->groupInputs('user-name', 'user-first-name');
$form_2->setCols(0, 6, 'xs');
$form_2->addIcon('user-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form_2->addInput('text', 'user-name', '', '', 'placeholder=Name, required');
$form_2->addIcon('user-first-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form_2->addInput('text', 'user-first-name', '', '', 'placeholder=First Name, required');
$form_2->setCols(0, 12, 'xs');
$form_2->addIcon('user-email', '<span class="glyphicon glyphicon-envelope"></span>', 'before');
$form_2->addInput('email', 'user-email', '', '', 'placeholder=Email, required');
$form_2->addIcon('user-phone', '<span class="glyphicon glyphicon-earphone"></span>', 'before');
$form_2->addHtml('<span class="help-block">Enter a valid US phone number</span>', 'user-phone', 'after');
$form_2->addInput('text', 'user-phone', '', '', 'placeholder=Phone, data-fv-phone, data-fv-phone-country=US, required');
$form_2->addTextarea('message', '', '', 'cols=30, rows=4, placeholder=Message, required');
$form_2->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));
$form_2->addCheckbox('newsletter', 'Suscribe to Newsletter', 1, 'checked=checked');
$form_2->printCheckboxGroup('newsletter', '');
$form_2->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha2', true);
$form_2->centerButtons(true);
$form_2->addBtn('reset', 'reset-btn', 1, 'Reset <span class="glyphicon glyphicon-erase append"></span>', 'class=btn btn-warning', 'my-btn-group');
$form_2->addBtn('submit', 'submit-btn', 1, 'Send <span class="glyphicon glyphicon-envelope append"></span>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'my-btn-group');
$form_2->printBtnGroup('my-btn-group');
$form_2->endFieldset();

// icheck plugin
$form_2->addPlugin('icheck', 'input', 'default', array('%theme%' => 'square-custom', '%color%' => 'green'));

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
    <title>Bootstrap Multiple modal forms - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create several modal forms on same page with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/multiple-modals.php" />
    <!-- Link to Bootstrap css here -->
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
            AND REPLACE WITH BOOTSTRAP CSS
            FOR EXAMPLE <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
    <?php $form_2->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - several Modal Forms on same page<br><small>click to sign up or contact</small></h1>
    <div class="container">
        <div class="row">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            ?>
            <!-- Button trigger modal -->
            <div class="text-center">
                <a data-remodal-target="modal-target" class="btn btn-primary btn-lg">Sign Up</a>
                <a data-remodal-target="modal-target-2" class="btn btn-primary btn-lg">Contact Us</a>
            </div>
            <?php
                $form->render();
                $form_2->render();
            ?>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
