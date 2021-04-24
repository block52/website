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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('date-range-picker-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('date-range-picker-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['date-range-picker-form'] = $validator->getAllErrors();
    } else {

        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Date range picker form from Php Form Builder',
            'filter_values'   => 'date-range-picker-form'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('date-range-picker-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form->setMode('development');

// Simple date picker
$form->startFieldset('Simple date picker');
$form->addInput('text', 'date-picker', '', 'Choose a date', 'class=litepick, data-number-of-months=1, data-number-of-columns=1, required');
$form->endFieldset();

// Simple date range picker
$form->startFieldset('Simple date range picker');
$form->addInput('text', 'daterange-picker', '', 'Choose a date', 'class=litepick, data-single-mode=false, required');
$form->endFieldset();

// Date range picker with min & max date
// set minimum date
$now      = new DateTime('now');
$date_min = $now->format('Y-m-d');

// set maximum date
$max      = $now->add(new DateInterval('P1M'));
$date_max = $now->format('Y-m-d');

$form->startFieldset('Date range picker with minimum &amp; maximum date');
$form->addHelper('The minimum date is set to the current day, the maximum date is one month later.', 'daterange-picker-min-max');
$form->addInput('text', 'daterange-picker-min-max', '', 'Choose a date', 'class=litepick, data-single-mode=false, data-min-date=' . $date_min . ', data-max-date=' . $date_max . ', required');
$form->endFieldset();

// Change the date format
$form->startFieldset('Change the date format');
$form->addHelper('The plugin documentation about date formats is available here: <a href="https://wakirin.github.io/Litepicker/#option-format">https://wakirin.github.io/Litepicker/#option-format</a>', 'daterange-picker-date-format');
$form->addInput('text', 'daterange-picker-date-format', '', 'Choose a date', 'class=litepick, data-single-mode=false, data-format=YYYY-MM-DD, required');
$form->endFieldset();

// Change the language
$form->startFieldset('Change the language');
$form->addInput('text', 'daterange-picker-language', '', 'Choisissez une date', 'class=litepick, data-single-mode=false, data-lang=fr-FR, required');
$form->endFieldset();


// Date range with range restricted to minimum 6 days + reset / submit buttons
$form->startFieldset('Date range with range restricted to minimum 6 days + reset / submit buttons');

$form->addInput('text', 'daterange-picker-6-days', '', 'Choose start / end dates', 'class=litepick, data-single-mode=false, data-min-days=5, data-auto-apply=false, data-use-reset-btn=true, required');
$form->endFieldset();

// Date range in 2 separate fields + formatted dates
$form->startFieldset('Date range in 2 separate fields + formatted dates');
$date_start_field_name = 'date-start';
$date_end_field_name   = 'date-end';

$form->groupInputs($date_start_field_name, $date_end_field_name);

$form->setCols(4, 4);
$form->addInput('text', $date_start_field_name, '', 'Choose start / end dates', 'class=litepick, data-single-mode=false, data-format=YYYY-MM-DD, data-element-end=' . $date_end_field_name . ', required');
$form->setCols(0, 4);
$form->addInput('text', $date_end_field_name, '', '', 'readonly, required');
$form->endFieldset();

// Date range in 2 separate fields + formatted dates + independent pickers + disabled dates
$form->startFieldset('Date range in 2 separate fields + formatted dates + independent pickers + disabled dates');
$date_start_field_name = 'date-start-2';
$date_end_field_name   = 'date-end-2';

// set booked days from (now + 5 days) to (now + 10 days)
$now             = new DateTime('now');
$now_plus_5days  = $now->add(new DateInterval('P5D'));
$booked_start    = $now_plus_5days->format('Y-m-d');

$now             = new DateTime('now');
$now_plus_10days = $now->add(new DateInterval('P10D'));
$booked_end      = $now_plus_10days->format('Y-m-d');

// add a single booked date
$now             = new DateTime('now');
$now_plus_15days = $now->add(new DateInterval('P15D'));
$booked_single   = $now_plus_15days->format('Y-m-d');

$form->groupInputs($date_start_field_name, $date_end_field_name);

$form->setCols(4, 4);
$form->addInput('text', $date_start_field_name, '', 'Choose start / end dates', 'class=litepick, data-single-mode=false, data-format=YYYY-MM-DD, data-element-end=' . $date_end_field_name . ', data-disallow-booked-days-in-range=true, data-booked-days=[[\'' . $booked_start . '\'\, \'' . $booked_end . '\']\, \'' . $booked_single . '\'], required');
$form->setCols(0, 4);
$form->addInput('text', $date_end_field_name, '', '', 'readonly, required');
$form->endFieldset();

$form->startFieldset();
$form->setCols(4, 8);
$form->addInput('email', 'user-email', '', 'Your Email', 'placeholder=Email, required');

$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#date-range-picker-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Date range picker Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Date range picker Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/date-range-picker-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Date range picker Form<br><small>with the <em>litepicker</em> picker plugin</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m11 l10">
                <p>The <em>Litepicker</em> plugin (date range plugin) has a lot of options available. This form shows examples of common use cases.<br>More options and explanations are available <a href="https://www.phpformbuilder.pro/documentation/jquery-plugins.php#litepicker-example">in the documentation</a></p>
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
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
