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
            'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('car-rental-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('car-rental-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');
$form->startFieldset('Rent a car');

/*----------  Foundation accordion 1 ----------*/

$form->addHtml('<ul id="accordion" class="accordion" data-accordion data-allow-all-closed="true">
    <li class="accordion-item" id="accordion-item-1" data-accordion-item>
        <a href="#" class="accordion-title">Main rental informations</a>
        <div class="accordion-content" data-tab-content>');

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

foreach ($locations as $loc) {
    $form->addOption('pick-up-location', $loc, $loc);
}
$form->addSelect('pick-up-location', 'Pick up location', 'class=select2, required');

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

$form->addSelect('drop-off-location', 'Drop off location', 'class=select2, required');

$form->setCols(0, 3, 'md');
$form->addHelper('Drop-off Date', 'drop-off-date');
$form->addInput('text', 'drop-off-date', '', '', 'readonly, required');

$form->setCols(0, 2, 'md');
$form->addHelper('Drop-off Time', 'drop-off-time');
$form->addInput('text', 'drop-off-time', '', '', 'required');
$form->addPlugin('pickadate', '#drop-off-time', 'pickatime');

// hidden input to show the date/time validation errors
$form->addHtml('<div class="grid-x grid-padding-x">
    <div id="date-time-message-wrapper">
        <input type="hidden" name="date-time-validation-message" />
    </div>
</div>');

/* Car type */

$form->setCols(3, 9);
$form->addRadio('car-type', 'Standart Cars', 'Standart Cars');
$form->addRadio('car-type', 'Convertibles', 'Convertibles');
$form->addRadio('car-type', 'Luxury Cars', 'Luxury Cars');
$form->addRadio('car-type', 'Vans', 'Vans');
$form->addRadio('car-type', 'SUVs', 'SUVs');
$form->printRadioGroup('car-type', 'Car Type', false, 'required');

$form->addHtml('        </div> <!-- END accordion-item -->
    </li> <!-- END accordion-content -->');

/*----------  Foundation accordion 2 ----------*/

$form->addHtml('    <li class="accordion-item" id="accordion-item-2" data-accordion-item>
        <a href="#" class="accordion-title">Extras</a>
        <div class="accordion-content" data-tab-content>');

/* Form Second part */

$form->addRadio('with', 'GPS navigation system', 'GPS navigation system');
$form->addRadio('with', 'Booster', 'Booster');
$form->addRadio('with', 'Child safety seat', 'Child safety seat');
$form->addRadio('with', 'Additional driver', 'Additional driver');
$form->printRadioGroup('with', 'With', false);
$form->addTextarea('additional-requests', '', 'Additional Requests');

$form->addHtml('        </div> <!-- END accordion-item -->
    </li> <!-- END accordion-content -->');

/*----------  Foundation accordion ----------*/

$form->addHtml('    <li class="accordion-item" id="accordion-item-3" data-accordion-item>
        <a href="#" class="accordion-title">Personal informations</a>
        <div class="accordion-content" data-tab-content>');

/* Form Third part */

$form->groupInputs('prefix', 'first-name', 'last-name');
$form->setCols(3, 2);
$form->addOption('prefix', 'Mr', 'Mr');
$form->addOption('prefix', 'Mrs', 'Mrs');
$form->addSelect('prefix', 'Full Name', 'required');
$form->setCols(0, 3);
$form->addInput('text', 'first-name', '', '', 'placeholder=First Name, required');
$form->setCols(0, 4);
$form->addInput('text', 'last-name', '', '', 'placeholder=Last Name, required');
$form->setCols(3, 9);
$form->addInput('email', 'user-email', '', 'E-Mail', 'required');
$form->groupInputs('area-code', 'user-phone');
$form->setCols(3, 2);
$form->addInput('text', 'area-code', '', 'Phone Number', 'placeholder=617, data-fv-regexp, data-fv-regexp-regexp=[+0-9-]+, data-fv-regexp-message=Please enter a valid Area Code, required');
$form->setCols(0, 7);
$form->addHelper('Enter a valid US phone number', 'user-phone');
$form->addInput('text', 'user-phone', '', '', 'placeholder=202-555-0165, data-fv-phone, data-fv-phone-country=US, required');

/*----------  Close Foundation accordion ----------*/

$form->addHtml('        </div> <!-- END accordion-item -->
    </li> <!-- END accordion-content -->
</ul> <!-- END accordion -->');
$form->setCols(-1, -1);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=success button');
$form->endFieldset();

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'yellow']);

// jQuery validation
$form->addPlugin('formvalidation', '#car-rental-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Car Rental Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Car Rental Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/car-rental-form.php" />

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
    <style type="text/css">
        #date-time-message-wrapper {
            padding-left: .9375rem;
        }
        #date-time-message-wrapper .fv-plugins-icon {
            margin-top: -1rem;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Car Rental Form</h1>
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
    <!-- Foundation JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/6.4.1/js/foundation.min.js"></script>
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
            $(document).foundation();
            var elem = new Foundation.Accordion($('#accordion'));

            /* open panel where we found the first error */

            if ($('#accordion-item-1 .form-error')[0] || !$('#accordion .form-error')[0]) {
                $('#accordion').foundation('down', $('#accordion-item-1 .accordion-content'));
            } else if($('#accordion-item-2 .form-error')[0]) {
                $('#accordion').foundation('down', $('#accordion-item-2 .accordion-content'));
            } else {
                $('#accordion').foundation('down', $('#accordion-item-3 .accordion-content'));
            }
        });
    </script>
</body>
</html>
