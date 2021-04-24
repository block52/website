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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('special-offer-sign-up') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('special-offer-sign-up');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['special-offer-sign-up'] = $validator->getAllErrors();
    } else {
        /* Database insert (disabled for demo) */

        /*require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/db-connect.php';
        require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/Mysql.php';

        $db = new Mysql();
        $insert['ID'] = Mysql::SQLValue('');
        $insert['user_first_name'] = Mysql::SQLValue($_POST['user-first-name']);
        $insert['user_name'] = Mysql::SQLValue($_POST['user-name']);
        $insert['user_email'] = Mysql::SQLValue($_POST['user-email']);
        if (!$db->insertRow('YOUR_TABLE', $insert)) {
            $user_message = '<p class="alert alert-danger">' . $db->error() . '<br>' . $db->getLastSql() . '</p>' . "\n";
        } else {
            $user_message = '<p class="alert alert-success">Thanks for suscribe !</p>' . "\n";
            Form::clear('special-offer-sign-up');
        }*/
        Form::clear('special-offer-sign-up'); // just for demo ; delete this line if real database recording.
        $user_message = '<p class="alert alert-success">Thanks for signing up !</p>' . "\n"; // just for demo ; delete this line if real database recording.
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('special-offer-sign-up', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form->setCols(0, 6);
$form->addHtml('<h3>Special Offer Sign Up<br><small>Enter your Name and Email to get Special Deals</small></h3>');
$form->addHtml('<label>Full Name<sup>* </sup></label>');
$form->groupInputs('user-first-name', 'user-name');
$form->addIcon('user-first-name', '<i class="input-group-label fi-torso" aria-hidden="true"></i>', 'before');
$form->addHelper('First Name', 'user-first-name');
$form->addInput('text', 'user-first-name', '', '', 'class=input-group-field, required');
$form->addHelper('Last Name', 'user-name');
$form->addInput('text', 'user-name', '', '', 'required');
$form->addHtml('<label>E-mail<sup>* </sup></label></label>');
$form->setCols(0, 12);
$form->addIcon('user-email', '<i class="input-group-label fi-mail" aria-hidden="true"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'class=input-group-field, required');
$form->setCols(-1, -1);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Sign Up <i class="fi fi-arrow-right append" aria-hidden="true"></i>', 'class=button primary');

// jQuery validation
$form->addPlugin('formvalidation', '#special-offer-sign-up');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Special Offer Sign Up Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Special Offer Sign Up with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/special-offer-sign-up.php" />

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
    <h1 class="text-center">Php Form Builder - Special Offer Sign Up Form<br><small>vertical form with helpers</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
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
