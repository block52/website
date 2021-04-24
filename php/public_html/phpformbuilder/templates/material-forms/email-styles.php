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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('email-styles') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('email-styles');

    // additional validation
    $validator->email()->validate('user-email');

    // recaptcha validation
    $validator->recaptcha('6LeNWaQUAAAAAOnei_86FAp7aRZCOhNwK3e2o2x2', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['email-styles'] = $validator->getAllErrors();
    } else {
        $replacements = array();

        // bogart theme
        if (in_array('bogart', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-bogart-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-bogart.png) repeat #1d2326',
                'tpl-content-dark-background'   => '#6a6a61',
                'tpl-content-light-background'  => '#dddcc5',
                'tpl-content-dark-text'         => '#1d2326',
                'tpl-content-light-text'        => '#dddcc5',
                'tpl-content-accent-text'       => '#dddcc5',
                'tpl-content-accent-background' => '#611427',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }

        // coffee theme
        if (in_array('coffee', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-coffee-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-coffee.png) repeat #4d3e39',
                'tpl-content-dark-background'   => '#222222',
                'tpl-content-light-background'  => '#f3f0e6',
                'tpl-content-dark-text'         => '#222222',
                'tpl-content-light-text'        => '#f3f0e6',
                'tpl-content-accent-text'       => '#ffffff',
                'tpl-content-accent-background' => '#db7447',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }

        // honey-pot theme
        if (in_array('honey-pot', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-honey-pot-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-honey-pot.png) repeat #191919',
                'tpl-content-dark-background'   => '#ffd34e',
                'tpl-content-light-background'  => '#fffad5',
                'tpl-content-dark-text'         => '#444444',
                'tpl-content-light-text'        => '#a6721a',
                'tpl-content-accent-text'       => '#fffad5',
                'tpl-content-accent-background' => '#bd4932',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }

        // sandy-stone theme
        if (in_array('sandy-stone', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-sandy-stone-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-sandy-stone.png) repeat #002f2f',
                'tpl-content-dark-background'   => '#a7a37e',
                'tpl-content-light-background'  => '#f9f8e9',
                'tpl-content-dark-text'         => '#333333',
                'tpl-content-light-text'        => '#f9f8e9',
                'tpl-content-accent-text'       => '#f9f8e9',
                'tpl-content-accent-background' => '#198181',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }

        // vintage theme
        if (in_array('vintage', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-vintage-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-vintage.png) repeat #2f343b',
                'tpl-content-dark-background'   => '#703030',
                'tpl-content-light-background'  => '#e3cda4',
                'tpl-content-dark-text'         => '#2f343b',
                'tpl-content-light-text'        => '#e3cda4',
                'tpl-content-accent-text'       => '#e3cda4',
                'tpl-content-accent-background' => '#e55e3d',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }

        // zen theme
        if (in_array('zen', $_POST['theme'])) {
            $replacements[] = array(
                'tpl-header-image'              => 'https://www.phpformbuilder.pro/assets/images/phpformbuilder-zen-600-160.png',
                'tpl-page-background'           => 'url(https://www.phpformbuilder.pro/assets/images/noisy-zen.png) repeat #10222b',
                'tpl-content-dark-background'   => '#bdd684',
                'tpl-content-light-background'  => '#e2f0d6',
                'tpl-content-dark-text'         => '#10222b',
                'tpl-content-light-text'        => '#f6ffe0',
                'tpl-content-accent-text'       => '#f6ffe0',
                'tpl-content-accent-background' => '#10222b',
                'user-name'                     => 'Name',
                'user-first-name'               => 'First name',
                'user-email'                    => 'Email'
            );
        }
        $count = count($replacements);

        // posted template
        if ($_POST['template'] == 'default-styled') {
            $template = 'default-styled.html';
        } else {
            $template = 'contact-styled.html';
        }

        // send an email for each posted theme
        for ($i=0; $i < $count; $i++) {
            $email_config = array(
                'sender_email'        => 'contact@phpformbuilder.pro',
                'sender_name'         => 'Php Form Builder',
                'recipient_email'     => addslashes($_POST['user-email']),
                'subject'             => 'Contact From Php Form Builder',
                'filter_values'       => 'email-styles',
                'template'            => $template,
                'values'              => $_POST,
                'custom_replacements' => $replacements[$i],
                'debug'               => true,
                'sent_message'        => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
            );
            $sent_message = Form::sendMail($email_config);
        }
        Form::clear('email-styles');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('email-styles', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Please fill in this form to contact us');
$form->addHtml('<p class="text-warning text-right">All fields are required</p>');
$form->addInput('text', 'user-name', '', 'Name:', 'required');
$form->addInput('text', 'user-first-name', '', 'First name:', 'required');
$form->addInput('email', 'user-email', '', 'Email:', 'required');
$form->addTextarea('message', '', 'Message:', 'cols=30, rows=4, required');

$form->addOption('theme[]', 'bogart', 'Bogart', '', 'data-icon\=\'../assets/img/email-styles-bogart.png\'');
$form->addOption('theme[]', 'coffee', 'Coffee', '', 'data-icon\=\'../assets/img/email-styles-coffee.png\'');
$form->addOption('theme[]', 'honey-pot', 'Honey pot', '', 'data-icon\=\'../assets/img/email-styles-honey-pot.png\'');
$form->addOption('theme[]', 'sandy-stone', 'Sandy Stone', '', 'data-icon\=\'../assets/img/email-styles-sandy-stone.png\'');
$form->addOption('theme[]', 'vintage', 'Vintage', '', 'data-icon\=\'../assets/img/email-styles-vintage.png\'');
$form->addOption('theme[]', 'zen', 'Zen', '', 'data-icon\=\'../assets/img/email-styles-zen.png\'');
$form->addHelper('If you choose several themes you\'ll receive an email for each one', 'theme');
$form->addSelect('theme[]', 'Choose theme(s):', 'class=icons, multiple, required');

$form->addRadio('template', '<span class="pr-5">Default styled</span>', 'default-styled');
$form->addRadio('template', 'Contact styled', 'contact-styled');
$form->addHtml('<p><small class="grey-text">Default styled will add all posted values to the email in a table.<br>Contact styled will send a custom message from contact template.</small></p>', 'template');
$form->printRadioGroup('template', 'Choose your template', true, 'required');
$form->addHtml('<p>&nbsp;</p>');
$form->addRecaptchaV3('6LeNWaQUAAAAAGO_c1ORq2wla-PEFlJruMzyH5L6', 'material-email-styles');
$form->addBtn('reset', 'reset-btn', 1, 'Reset <i class="material-icons right">cancel</i>', 'class=btn orange darken-1 waves-effect waves-light', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="material-icons right">done</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'my-btn-group');
$form->printBtnGroup('my-btn-group');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#email-styles');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Styled Email Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to send different styled emails with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/email-styles.php" />

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
    <h1 class="center-align">Php Form Builder - Bootstrap Styled Email Form<br><small>send different styled emails using HTML/CSS templates</small></h1>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#email-styles select').formSelect();
        });
    </script>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
