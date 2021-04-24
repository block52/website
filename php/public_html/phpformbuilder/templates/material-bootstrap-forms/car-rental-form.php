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

$form = new Form('car-rental-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#car-rental-form');

$form->startFieldset('Rent a car');

/*----------  BS4 collapse 1 ----------*/

$form->addHtml('<div id="accordion" role="tablist">
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Main rental informations <span class="caret"></span>
                </a>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">');

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

$form->addHtml('            </div> <!-- END card-body -->
        </div> <!-- END collapseOne -->
    </div> <!-- END card -->');

/*----------  BS4 collapse 2 ----------*/

$form->addHtml('    <div class="card">
        <div class="card-header" role="tab" id="headingTwo">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Extras <span class="caret"></span>
                </a>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">');

/* Form Second part */

$form->addRadio('with', 'GPS navigation system', 'GPS navigation system');
$form->addRadio('with', 'Booster', 'Booster');
$form->addRadio('with', 'Child safety seat', 'Child safety seat');
$form->addRadio('with', 'Additional driver', 'Additional driver');
$form->printRadioGroup('with', 'With', false);
$form->setCols(0, 12, 'md');
$form->addTextarea('additional-requests', '', 'Additional Requests');

$form->addHtml('            </div> <!-- END card-body -->
        </div> <!-- END collapseTwo -->
    </div> <!-- END card -->');

/*----------  BS4 collapse 3 ----------*/

$form->addHtml('    <div class="card">
    <div class="card-header" role="tab" id="headingThree">
        <h5 class="mb-0">
            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Personal informations <span class="caret"></span>
            </a>
        </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">');

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

/*----------  Close BS4 collapse ----------*/

$form->addHtml('            </div> <!-- END card-body -->
        </div> <!-- END collapseThree -->
    </div> <!-- END card -->
</div> <!-- END accordion -->');

$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success mt-4');
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
    <title>Material Design Bootstrap 4 Car Rental Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Bootstrap 4 Form Generator - how to create a Car Rental Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/car-rental-form.php" />

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Material Design Bootstrap 4 Car Rental Form</h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-bootstrap-forms-notice.php';
        ?>

        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
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

    <!-- Bootstrap 4 JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
    <script type="text/javascript">        $(document).ready(function () {

            /* open panel where we found the first error */

            if (!$('#collapseOne .invalid')[0] && $('#collapseThree .invalid')[0]) {
                $('#collapseThree').collapse('show');
            }
        });
    </script>
</body>
</html>
