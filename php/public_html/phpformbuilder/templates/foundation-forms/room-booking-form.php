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
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('room-booking-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('room-booking-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');

$form->startFieldset('Book a Room', 'class=fieldset');
$form->setCols(3, 4, 'md');
$form->groupInputs('first-name', 'last-name');
$form->addHelper('First name', 'first-name');
$form->addInput('text', 'first-name', '', 'Full Name : ', 'required');
$form->setCols(0, 5, 'md');
$form->addHelper('Last name', 'last-name');
$form->addInput('text', 'last-name', '', '', 'required');
$form->setCols(3, 9, 'md');
$form->addInput('email', 'user-email', '', 'E-Mail : ', 'placeholder=email@example.com, required');
$form->addInput('text', 'phone-number', '', 'Phone Number : ', 'required');
$form->addPlugin('pickadate', '#arrival-date');
$form->addInput('text', 'arrival-date', '', 'Arrival Date', 'required');
$form->groupInputs('number-of-nights', 'number-of-guests');
for ($i=1; $i <= 30; $i++) {
    $form->addOption('number-of-nights', $i, $i);
}
$form->addOption('number-of-nights', 'more than 30', '30 +');
$form->setCols(3, 3, 'md');
$form->addIcon('number-of-nights', '<i class="input-group-label fi-cloud"></i>', 'before');
$form->addSelect('number-of-nights', 'Number of Nights', 'class=input-group-field, required');
for ($i=1; $i <= 10; $i++) {
    $form->addOption('number-of-guests', $i, $i);
}
$form->addOption('number-of-guests', 'more than 10', '10 +');
$form->addIcon('number-of-guests', '<i class="input-group-label fi-torsos"></i>', 'before');
$form->addSelect('number-of-guests', 'Number of Guests', 'class=input-group-field, required');
$form->addPlugin('tinymce', '#additional-informations', 'contact-config');
$form->setCols(3, 9, 'md');
$form->addTextarea('additional-informations', '', 'Additional Informations');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=success button');
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
    <title>Foundation Room Booking Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Room Booking Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/room-booking-form.php" />

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
    <h1 class="text-center">Php Form Builder - Room Booking Form<br><small>with Rich Text Editor and date picker</small></h1>
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
