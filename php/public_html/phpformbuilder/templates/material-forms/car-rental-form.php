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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('car-rental-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('car-rental-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['car-rental-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Car Rental Form',
            'filter_values'   => 'car-rental-form',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('car-rental-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('car-rental-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Rent a car');

/*----------  Materialize collapse 1 ----------*/

$form->addHtml('<ul class="collapsible">
    <li id="collapseOne" class="active">
        <div class="collapsible-header">Main rental informations<i class="material-icons right">arrow_drop_down</i></div>
        <div class="collapsible-body"><span>');

/* Form First part */

// Locations lists
$locations = array(
    'Alabama',
    'Alaska',
    'Arizona',
    'Arkansas',
    'California',
    'Colorado',
    'Connecticut',
    'Delaware',
    'District of Columbia',
    'Florida',
    'Georgia',
    'Hawaii',
    'Idaho',
    'Illinois',
    'Indiana',
    'Iowa',
    'Kansas',
    'Kentucky',
    'Louisiana',
    'Maine',
    'Maryland',
    'Massachusetts',
    'Michigan',
    'Minnesota',
    'Mississippi',
    'Missouri',
    'Montana',
    'Nebraska',
    'Nevada',
    'New Hampshire',
    'New Jersey',
    'New Mexico',
    'New York',
    'North Carolina',
    'North Dakota',
    'Ohio',
    'Oklahoma',
    'Oregon',
    'Pennsylvania',
    'Rhode Island',
    'South Carolina',
    'South Dakota',
    'Tennessee',
    'Texas',
    'Utah',
    'Vermont',
    'Virginia',
    'Washington',
    'West Virginia',
    'Wisconsin',
    'Wyoming'
);

/* Pick up */

$form->setCols(3, 4, 'md');
$form->groupInputs('pick-up-location', 'pick-up-date', 'pick-up-time');

$form->setCols(3, 4, 'md');
$form->groupInputs('pick-up-location', 'pick-up-date', 'pick-up-time');

foreach ($locations as $loc) {
    $form->addOption('pick-up-location', $loc, $loc);
}

$form->addSelect('pick-up-location', 'Pick up location', 'required');

// set minimum date
$now      = new DateTime('now');
$date_min = $now->format('Y-m-d');

$form->setCols(0, 3, 'md');
$form->addHelper('Pick-up Date', 'pick-up-date');
$form->addInput('text', 'pick-up-date', '', '', 'class=litepick, data-single-mode=false, data-min-date=' . $date_min . ', data-format=YYYY-MM-DD, data-element-end=drop-off-date, data-split-view=true, required');

$form->setCols(0, 2, 'md');
$form->addPlugin('pickadate', '#pick-up-time', 'pickatime');
$form->addHelper('Pick-up Time', 'pick-up-time');
$form->addInput('text', 'pick-up-time', '', '', 'required');

/* Drop Off */

$form->setCols(3, 4, 'md');
$form->groupInputs('drop-off-location', 'drop-off-date', 'drop-off-time');

foreach ($locations as $loc) {
    $form->addOption('drop-off-location', $loc, $loc);
}

$form->addSelect('drop-off-location', 'Drop off location', 'required');

$form->setCols(0, 3, 'md');
$form->addHelper('Drop-off Date', 'drop-off-date');
$form->addInput('text', 'drop-off-date', '', '', 'readonly, required');

$form->setCols(0, 2, 'md');
$form->addHelper('Drop-off Time', 'drop-off-time');
$form->addInput('text', 'drop-off-time', '', '', 'required');
$form->addPlugin('pickadate', '#drop-off-time', 'pickatime');

// hidden input to show the date/time validation errors
$form->addHtml('<div class="row form-group">
    <div id="date-time-message-wrapper" class="input-field col s12" style="line-height:2.5rem;">
        <input type="hidden" name="date-time-validation-message" />
    </div>
</div>');

/* Car type */

$form->setCols(3, 9, 'md');
$form->addRadio('car-type', 'Standart Cars', 'Standart Cars');
$form->addRadio('car-type', 'Convertibles', 'Convertibles');
$form->addRadio('car-type', 'Luxury Cars', 'Luxury Cars');
$form->addRadio('car-type', 'Vans', 'Vans');
$form->addRadio('car-type', 'SUVs', 'SUVs');
$form->printRadioGroup('car-type', 'Car Type', false, 'required');

$form->addHtml('        </span></div> <!-- END collapsible-body -->
    </li> <!-- END collapse -->');

/*----------  Materialize collapse 2 ----------*/

$form->addHtml('    <li id="collapseTwo">
        <div class="collapsible-header">Extras<i class="material-icons right">arrow_drop_down</i></div>
        <div class="collapsible-body"><span>');

/* Form Second part */

$form->addRadio('with', 'GPS navigation system', 'GPS navigation system');
$form->addRadio('with', 'Booster', 'Booster');
$form->addRadio('with', 'Child safety seat', 'Child safety seat');
$form->addRadio('with', 'Additional driver', 'Additional driver');
$form->printRadioGroup('with', 'With', false);
$form->setCols(0, 12, 'md');
$form->addTextarea('additional-requests', '', 'Additional Requests');

$form->addHtml('        </span></div> <!-- END collapsible-body -->
    </li> <!-- END collapse -->');

/*----------  Materialize collapse 3 ----------*/

$form->addHtml('    <li id="collapseThree">
        <div class="collapsible-header">Personal informations<i class="material-icons right">arrow_drop_down</i></div>
        <div class="collapsible-body"><span>');

/* Form Third part */

$form->groupInputs('prefix', 'first-name', 'last-name');
$form->setCols(3, 2, 'md');
$form->addOption('prefix', 'Mr', 'Mr');
$form->addOption('prefix', 'Mrs', 'Mrs');
$form->addSelect('prefix', 'Full Name', 'required');
$form->setCols(0, 3, 'md');
$form->addInput('text', 'first-name', '', '', 'placeholder=First Name, required');
$form->setCols(0, 4, 'md');
$form->addInput('text', 'last-name', '', '', 'placeholder=Last Name, required');
$form->setCols(3, 9, 'md');
$form->addInput('email', 'user-email', '', 'E-Mail', 'required');
$form->groupInputs('area-code', 'user-phone');
$form->setCols(3, 2, 'md');
$form->addInput('text', 'area-code', '', 'Phone Number', 'placeholder=303, data-fv-regexp, data-fv-regexp-regexp=[+0-9-]+, data-fv-regexp-message=Please enter a valid Area Code, required');
$form->setCols(0, 7, 'md');
$form->addHelper('Enter a valid US phone number', 'user-phone');
$form->addInput('text', 'user-phone', '', '', 'placeholder=202-555-0119, data-fv-phone, data-fv-phone-country=US, required');

/*----------  Close Materialize collapse ----------*/

$form->addHtml('        </span></div> <!-- END collapsible-body -->
    </li> <!-- END collapse -->
</ul> <!-- END collapsible -->');

$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn waves-effect waves-light mt-4');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#car-rental-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Car Rental Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Car Rental Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/car-rental-form.php" />

    <!-- Bootstrap 4 CSS -->

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
    <h1 class="center-align">Material Design Car Rental Form</h1>
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
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').formSelect();
            $('.collapsible').collapsible();
            var instance = M.Collapsible.getInstance($('.collapsible'));

            /* open panel where we found the first error */

            if (!$('#collapseOne .invalid')[0] && $('#collapseThree .invalid')[0]) {

                instance.close(0);
                instance.open(2);
            }
        });
    </script>
</body>
</html>
