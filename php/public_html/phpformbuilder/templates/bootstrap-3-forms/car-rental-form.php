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
            'filter_values'   => 'car-rental-form'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('car-rental-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('car-rental-form', 'horizontal', 'data-fv-debug=true, novalidate', 'bs3');
// $form->setMode('development');
$form->startFieldset('Rent a car');

/*----------  BS3 Panel 1  ----------*/

$form->addHtml('<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Main rental informations <span class="caret"></span>
                </a>
            </h4>
        </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">');

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
$form->addSelect('pick-up-location', 'Pick up location', 'class=selectpicker, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, data-live-search=true, required');

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

$form->addSelect('drop-off-location', 'Drop off location', 'class=selectpicker, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, data-live-search=true, required');

$form->setCols(0, 3, 'md');
$form->addHelper('Drop-off Date', 'drop-off-date');
$form->addInput('text', 'drop-off-date', '', '', 'readonly, required');

$form->setCols(0, 2, 'md');
$form->addHelper('Drop-off Time', 'drop-off-time');
$form->addInput('text', 'drop-off-time', '', '', 'required');
$form->addPlugin('pickadate', '#drop-off-time', 'pickatime');

// hidden input to show the date/time validation errors
$form->addHtml('<div class="form-group">
    <div id="date-time-message-wrapper" class="col-sm-5 col-sm-offset-7" style="padding-right: 40px;">
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

$form->addHtml('        </div> <!-- END panel-body -->
        </div> <!-- END panel-collapse -->
    </div> <!-- END panel -->');

/*----------  BS3 Panel 2  ----------*/

$form->addHtml('  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Extras <span class="caret"></span>
            </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">');

/* Form Second part */

$form->addRadio('with', 'GPS navigation system', 'GPS navigation system');
$form->addRadio('with', 'Booster', 'Booster');
$form->addRadio('with', 'Child safety seat', 'Child safety seat');
$form->addRadio('with', 'Additional driver', 'Additional driver');
$form->printRadioGroup('with', 'With', false);
$form->addTextarea('additional-requests', '', 'Additional Requests');

$form->addHtml('        </div> <!-- END panel-body -->
        </div> <!-- END panel-collapse -->
    </div> <!-- END panel -->');

/*----------  BS3 Panel 3  ----------*/

$form->addHtml('  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Personal informations <span class="caret"></span>
            </a>
        </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">');

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
$form->addInput('text', 'area-code', '', 'Phone Number', 'placeholder=303, pattern=^[+0-9-]+$, data-fv-regexp___message=Please enter a valid Area Code, required');
$form->setCols(0, 7, 'md');
$form->addHelper('Enter a valid US phone number', 'user-phone');
$form->addInput('text', 'user-phone', '', '', 'placeholder=202-555-0165, data-fv-phone, data-fv-phone-country=US, required');

/*----------  Close BS3 Panel  ----------*/

$form->addHtml('        </div> <!-- END panel-body -->
        </div> <!-- END panel-collapse -->
    </div> <!-- END panel -->
</div> <!-- END panel-group -->');

$form->setCols(0, 12, 'md');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success ladda-button, data-style=zoom-in');
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
    <title>Bootstrap Car Rental Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Car Rental Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/car-rental-form.php" />
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
    <style type="text/css">
        .form-group > [class*="col-"] {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1 class="text-center bg-primary">Car Rental Form</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
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
    <script type="text/javascript">
        $(document).ready(function () {

            /* open panel where we found the first error */

            if (!$('#collapseOne .has-error')[0] && $('#collapseThree .has-error')[0]) {
                $('#collapseOne').collapse('hide');
                $('#collapseThree').collapse('show');
            }
        });
    </script>
</body>
</html>
