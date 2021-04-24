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

$form = new Form('newsletter-suscribe-form', 'vertical', 'novalidate', 'bs3');
// $form->setMode('development');

$form->startFieldset('Newsletter Suscribe Form');
$form->addHtml('<p>&nbsp;</p><p class="text-success text-center"><em>Subscribe to our Newsletter and receive exclusive offers, updates and news</em></p>');
$form->addIcon('user-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Your Name, required');
$form->addIcon('user-email', '<span class="glyphicon glyphicon-envelope"></span>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Your E-mail, required');
$form->addBtn('submit', 'submit-btn', 1, 'Suscribe <i class="fa fa-arrow-right fa-fw"></i>', 'class=btn btn-primary btn-block');
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
    <title>Bootstrap Newsletter Suscribe Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Newsletter Suscribe Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/newsletter-suscribe-form.php" />
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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
    <h1 class="text-center">Php Form Builder - Newsletter Form<br><small>Suscribe to our Newsletter</small></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
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
