<?php
use phpformbuilder\Form;
use phpformbuilder\FormExtended;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/FormExtended.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('extended-users-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('extended-users-form');

    // additional validation
    for ($i=1; $i < 4; $i++) {
        $validator->email()->validate('email_professional-' . $i);
    }

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['extended-users-form'] = $validator->getAllErrors();
    } else {
        $sent_message = FormExtended::sendContactEmail(addslashes($_POST['email_professional-1']), 'extended-users-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new FormExtended('extended-users-form', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');

for ($i=1; $i < 4; $i++) {
    $form->startFieldset('User ' . $i);
    $form->addIdentity($i);
    $form->addBirth($i);
    $form->addAddress($i);
    $form->addContact($i);
    $form->endFieldset();
}
$form->addCancelSubmit();

// jQuery validation
$form->addPlugin('formvalidation', '#extended-users-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Extended Users Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a complete Users Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/extended-users-form.php" />
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
    <h1 class="text-center">Php Form Builder - Extended Users Form<br><small>Build a complete users form with a very few lines of code</small></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            $form->render();
            ?>
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
    </div>
</body>
</html>
