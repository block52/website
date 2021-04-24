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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('room-booking-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('room-booking-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['room-booking-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Room Booking Form',
            'filter_values'   => 'room-booking-form',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('room-booking-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('room-booking-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

$form->startFieldset('Book a Room');
$form->setCols(3, 4);
$form->groupInputs('first-name', 'last-name');
$form->addHelper('First name', 'first-name');
$form->addInput('text', 'first-name', '', 'Full Name : ', 'required');
$form->setCols(0, 5);
$form->addHelper('Last name', 'last-name');
$form->addInput('text', 'last-name', '', '', 'required');
$form->setCols(3, 9);
$form->addInput('email', 'user-email', '', 'E-Mail : ', 'placeholder=email@example.com, required');
$form->addInput('text', 'phone-number', '', 'Phone Number : ', 'required');
$form->addPlugin('material-datepicker', '#arrival-date');
$form->addInput('text', 'arrival-date', '', 'Arrival Date', 'required');
$form->groupInputs('number-of-nights', 'number-of-guests');
for ($i=1; $i <= 30; $i++) {
    $form->addOption('number-of-nights', $i, $i);
}
$form->addOption('number-of-nights', 'more than 30', '30 +');
$form->setCols(3, 3);
$form->addIcon('number-of-nights', '<i class="material-icons" aria-hidden="true">hotel</i>', 'before');
$form->addSelect('number-of-nights', 'Number of Nights', ' required');
for ($i=1; $i <= 10; $i++) {
    $form->addOption('number-of-guests', $i, $i);
}
$form->addOption('number-of-guests', 'more than 10', '10 +');
$form->addIcon('number-of-guests', '<i class="material-icons" aria-hidden="true">person_add</i>', 'before');
$form->addSelect('number-of-guests', 'Number of Guests', ' required');
$form->addPlugin('tinymce', '#additional-informations', 'contact-config');
$form->setCols(3, 9);
$form->addTextarea('additional-informations', '', 'Additional Informations');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#room-booking-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Room Booking Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Room Booking Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/room-booking-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Room Booking Form<br><small>with Rich Text Editor and date picker</small></h1>
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
           $('#room-booking-form select').formSelect();
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
