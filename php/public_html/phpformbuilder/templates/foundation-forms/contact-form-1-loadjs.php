<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

$is_loadjs_form = true;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('contact-form-1-loadjs') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('contact-form-1-loadjs');

    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('user-email');

    // recaptcha validation
    $validator->recaptcha('6LeNWaQUAAAAAOnei_86FAp7aRZCOhNwK3e2o2x2', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['contact-form-1-loadjs'] = $validator->getAllErrors();
    } else {
        $_POST['message'] = nl2br($_POST['message']);
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Contact from Php Form Builder',
            'filter_values'   => 'contact-form-1-loadjs',
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('contact-form-1-loadjs');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('contact-form-1-loadjs', 'horizontal', 'novalidate', 'foundation');

// development mode is suitable when we use loadJs
$form->setMode('development');

// enable Loadjs loading & wait for the core bundle
$form->useLoadJs('core');

$form->startFieldset('Please fill in this form to contact us', 'class=fieldset');
$form->addHtml('<p class="text-warning">All fields are required</p>');
$form->groupInputs('user-name', 'user-first-name');
$form->setCols(0, 6, 'md');
$form->addIcon('user-name', '<i class="input-group-label fi-torso"></i>', 'before');
$form->addInput('text', 'user-name', '', '', 'class=input-group-field, placeholder=Name, required');
$form->addIcon('user-first-name', '<i class="input-group-label fi-torso"></i>', 'before');
$form->addInput('text', 'user-first-name', '', '', 'class=input-group-field, placeholder=First Name, required');
$form->setCols(0, 12, 'xs');
$form->addIcon('user-email', '<i class="input-group-label fi-mail"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'class=input-group-field, placeholder=Email, required');
$form->addIcon('user-phone', '<i class="input-group-label fi-telephone"></i>', 'before');
$form->addInput('tel', 'user-phone', '', '', 'class=input-group-field, data-intphone=true, data-fv-intphonenumber=true, required');
$form->addTextarea('message', '', '', 'cols=30, rows=4, placeholder=Message, required');
$form->setCols(6, 6, 'xs');
$form->addCheckbox('newsletter', '', '1', 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=yellow, checked');
$form->printCheckboxGroup('newsletter', 'Suscribe to Newsletter');
$form->setCols(0, 12, 'xs');
$form->addRecaptchaV3('6LeNWaQUAAAAAGO_c1ORq2wla-PEFlJruMzyH5L6');
$form->addHtml('<p>&nbsp;</p>');
$form->centerButtons(true);
$form->addBtn('reset', 'reset-btn', 1, 'Reset <i class="fi-x append"></i>', 'class=button warning', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="fi-mail append"></i>', 'class=success button', 'my-btn-group');
$form->printBtnGroup('my-btn-group');
$form->endFieldset();

// word-character-count plugin
$form->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));

// jQuery validation
$form->addPlugin('formvalidation', '#contact-form-1-loadjs');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Contact Form loaded with LoadJs - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Contact Form with LoadJs and Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/contact-form-1-loadjs.php" />

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
</head>
<body>
    <h1 class="text-center">Php Form Builder - Foundation Horizontal Contact Form<br><small>with icons &amp; placeholders<br>Loaded with LoadJs Library</small></h1>
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

    <!-- LoadJs -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/loadjs/3.5.5/loadjs.min.js"></script>

    <script defer type="text/javascript">
        // loading jQuery & Bootstrap JS with loadJs (core bundle)
        loadjs([
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'
        ], 'core',
        {
            async: false
        });

        // Core's loaded - do any stuff
        loadjs.ready('core', function() {
           console.log('jQuery');
        });
    </script>
    <?php
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
