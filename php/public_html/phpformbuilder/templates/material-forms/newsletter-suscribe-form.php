<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('newsletter-suscribe-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('newsletter-suscribe-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['newsletter-suscribe-form'] = $validator->getAllErrors();
    } else {
        /* Database insert (disabled for demo) */

        /*require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/db-connect.php';
        require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/Mysql.php';

        $db = new Mysql();
        $insert['ID'] = Mysql::SQLValue('');
        $insert['user_name'] = Mysql::SQLValue($_POST['user-name']);
        $insert['user_email'] = Mysql::SQLValue($_POST['user-email']);
        if (!$db->insertRow('YOUR_TABLE', $insert)) {
            $user_message = '<p class="alert alert-danger">' . $db->error() . '<br>' . $db->getLastSql() . '</p>' . "\n";
        } else {
            $user_message = '<p class="alert alert-success">Thanks for suscribe !</p>' . "\n";
            Form::clear('newsletter-suscribe-form');
        }*/
        Form::clear('newsletter-suscribe-form'); // just for demo ; delete this line if real database recording.
        $user_message = '<p class="alert alert-success">Thanks for suscribe !</p>' . "\n"; // just for demo ; delete this line if real database recording.
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('newsletter-suscribe-form', 'vertical', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Newsletter Suscribe Form');
$form->addHtml('<p class="text-success text-center mt-4"><em>Subscribe to our Newsletter and receive exclusive offers, updates and news</em></p>');
$form->addIcon('user-name', '<i class="material-icons" aria-hidden="true">person</i>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Your Name, required');
$form->addIcon('user-email', '<i class="material-icons" aria-hidden="true">mail_outline</i>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Your E-mail, required');
$form->addBtn('submit', 'submit-btn', 1, 'Suscribe <i class="material-icons right">arrow_forward_ios</i>', 'class=btn btn-primary btn-block');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#newsletter-suscribe-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Newsletter Suscribe Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Newsletter Suscribe Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/newsletter-suscribe-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Newsletter Form<br><small>Suscribe to our Newsletter</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m8 offset-m2 l6 offset-l3">
            <?php
            if (isset($user_message)) {
                echo $user_message;
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
