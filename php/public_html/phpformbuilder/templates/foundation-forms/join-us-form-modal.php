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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('join-us-modal-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('join-us-modal-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['join-us-modal-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Join Us Modal Form',
            'filter_values'   => 'join-us-modal-form',
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('join-us-modal-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('join-us-modal-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form->setCols(0, 12);

$form->startFieldset();

$form->addHtml('<h4>Get Free Email Updates!<br><small>Join us for FREE to get instant email updates!</small></h4>');
$form->addIcon('user-name', '<i class="input-group-label fi-torso"></i>', 'before');
$form->addInput('text', 'user-name', '', '', 'class=input-group-field, required, placeholder=Your Name');
$form->addIcon('user-email', '<i class="input-group-label fi-mail"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'class=input-group-field, required, placeholder=Email');
$form->addHtml('<p class="float-right"><small><i class="fi fi-lock"></i>Your Information is Safe With us!</small></p>');
$form->setCols(-1, -1);
$form->centerButtons(true);
$form->addBtn('button', 'cancel-btn', 1, 'Cancel', 'class=button secondary, data-modal-close=modal-target', 'submit_group');
$form->addBtn('submit', 'submit-btn', 1, 'Get Access Today<i class="fi fi-unlock append"></i>', 'class=success button', 'submit_group');
$form->printBtnGroup('submit_group');

$form->endFieldset();

// modal plugin
$form->modal('#modal-target');

// jQuery validation
$form->addPlugin('formvalidation', '#join-us-modal-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Join Us Modal Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Join Us Modal Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/join-us-form-modal.php" />

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
    <h1 class="text-center">Php Form Builder - Join Us Modal Form<br><small>click to open Modal</small></h1>
    <div class="container">
        <div class="grid-x grid-padding-x">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            ?>
            <!-- Button trigger modal -->
            <div class="text-center">
                <a class="button primary large" href="#" data-remodal-target="modal-target">Join us for FREE<i class="fi fi-unlock append"></i></a>
            </div>

            <?php
                $form->render();
            ?>
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
