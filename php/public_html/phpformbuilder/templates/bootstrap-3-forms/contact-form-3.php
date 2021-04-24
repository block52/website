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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('contact-form-3') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('contact-form-3');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['contact-form-3'] = $validator->getAllErrors();
        var_dump($_SESSION['errors']['contact-form-3']);
    } else {
        $_POST['message'] = nl2br($_POST['message']);
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Contact from Php Form Builder',
            'filter_values'   => 'contact-form-3'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('contact-form-3');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('contact-form-3', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->setCols(0, 12);
$form->startFieldset('Please fill in this form to contact us');
$form->setCols(0, 6);
$form->groupInputs('user-name', 'user-first-name');
$form->addIcon('user-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Name*, required');
$form->addInput('text', 'user-first-name', '', '', 'placeholder=First Name');
$form->setCols(0, 12);
$form->addIcon('user-email', '<span class="glyphicon glyphicon-envelope"></span>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Email, required*');
$form->addIcon('user-phone', '<span class="glyphicon glyphicon-earphone"></span>', 'before');
$form->addInput('tel', 'user-phone', '', '', 'data-intphone=true, data-fv-intphonenumber=true, required');
$form->addHelper('If other, please tell us more ... ', 'subject');
$form->addOption('subject', '', 'Your request concerns ...');
$form->addOption('subject', 'Support', 'Support', '', 'data-icon=glyphicon glyphicon-info-sign text-warning');
$form->addOption('subject', 'Sales', 'Sales', '', 'data-icon=glyphicon glyphicon-usd text-warning');
$form->addOption('subject', 'Other', 'Other', '', 'data-icon=glyphicon glyphicon-question-sign text-warning');
$form->addSelect('subject', '', 'class=selectpicker, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok');
$form->startDependentFields('subject', 'Other');
$form->addInput('text', 'subject-other', '', '', 'placeholder=Please tell more about your request ..., required');
$form->endDependentFields();
$form->addTextarea('message', 'Your message ...', '', 'cols=30, rows=4, required');
$form->addPlugin('tinymce', '#message', 'contact-config');
$form->setCols(6, 6, 'xs');
$form->addCheckbox('newsletter', '', '1', 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=gray-dark, checked');
$form->printCheckboxGroup('newsletter', 'Suscribe to Newsletter');
$form->addHtml('<p>&nbsp;</p>');
$form->setCols(0, 12, 'xs');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Send <span class="glyphicon glyphicon-envelope append"></span>', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->endFieldset();
$form->addHtml('<p class="text-warning">* Required fields</p>');

// jQuery validation
$form->addPlugin('formvalidation', '#contact-form-3');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Contact Form with Rich Text Editor - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Contact Form with Rich Text Editor using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/contact-form-3.php" />
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
</head>
<body>
    <h1 class="text-center">Php Form Builder - Contact Form<br><small>with Rich Text Editor and Dependent Field</small></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
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

    <!-- Bootstrap JavaScript -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
