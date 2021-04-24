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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('validation-with-jquery-example-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('validation-with-jquery-example-form');

    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['validation-with-jquery-example-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Validation with jQuery Example Form',
            'filter_values'   => 'validation-with-jquery-example-form, captcha',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('validation-with-jquery-example-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('validation-with-jquery-example-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Validation using Native HTML5 fieldtypes / attributes');

/* =============================================
    Validation using Native HTML5 fieldtypes
============================================= */

// Not Empty
$form->addInput('text', 'required-field', '', 'Not Empty', 'required');

// Email
$form->addInput('email', 'user-email', '', 'Email', 'required');

// URL
$form->addInput('url', 'user-url', '', 'Url', 'required');

// Textarea Not Empty
$form->addTextarea('message', '', 'Textarea Not Empty', 'required');

// Range
$form->addHelper('Range between 5 &amp; 50', 'user-range');
$form->addInput('range', 'user-range', '', 'Range', 'min=5, max=50');

// Color
$form->addInput('color', 'user-color', '#33cc33', 'Color');

// Min
$form->addInput('number', 'user-min-number', '', 'Number Min. 50', 'min=50');

// Max
$form->addInput('number', 'user-max-number', '', 'Number Max. 50', 'max=50');

// Min Length / Max Length
$form->addInput('text', 'minlenght-maxlength-field', '', 'Min / Max Length', 'minlength=10, maxlength=20');

// Pattern
$form->addHelper('Lowercase only', 'user-pattern');
$form->addInput('text', 'user-pattern', '', 'Pattern', 'pattern=^[a-z]+$');

// Radio
$form->addRadio('radio-buttons', 'Yes', 'Yes');
$form->addRadio('radio-buttons', 'No', 'No');
$form->printRadioGroup('radio-buttons', 'Radio buttons', true, 'required');

$form->endFieldset();
$form->startFieldset('Validation using Custom HTML5 attributes (data)');


/* =============================================
    Validation using Custom HTML5 attributes
============================================= */

// Choices
$form->addHelper('1 - 3 programming languages', 'choices');
$form->addCheckbox('choices', 'Java', 'Java', 'data-fv-choice, data-fv-choice___min=1, data-fv-choice___max=3, data-fv-choice___message=Please choose 1 - 3 programming languages');
$form->addCheckbox('choices', 'C/C++', 'C/C++');
$form->addCheckbox('choices', 'PHP', 'PHP');
$form->addCheckbox('choices', 'Perl', 'Perl');
$form->addCheckbox('choices', 'Ruby', 'Ruby');
$form->addCheckbox('choices', 'Python', 'Python');
$form->printCheckboxGroup('choices', 'Choices', true, 'required');

// Credit card number
$form->addInput('text', 'user-ccnum', '', 'Credit card number', 'data-fv-credit-card');

// Different
$form->addInput('text', 'user-different-fields-1', '', 'Different field 1');
$form->addInput('text', 'user-different-fields-2', '', 'Different field 2');

// Digits
$form->addInput('text', 'user-digits', '', 'Digits', 'data-fv-digits');

// EAN
$form->addInput('text', 'user-ean', '', 'EAN', 'data-fv-ean');

// Greater than
$form->addInput('number', 'user-number-greater-than', '', 'Number greater than 50', 'data-fv-greater-than, data-fv-greater-than___min=50');

// Hexadecimal number
$form->addInput('text', 'user-hex', '', 'Hexadecimal number', 'data-fv-hex');

// Identical
$form->addInput('password', 'user-pass', '', 'Password');
$form->addInput('password', 'user-pass-confirm', '', 'Confirm Password');

// Integer
$form->addInput('number', 'user-number', '', 'Integer', 'data-fv-integer');

// IP
$form->addInput('text', 'user-ip', '', 'IP', 'data-fv-ip');

// Phone
$form->addInput('text', 'user-phone', '', 'Phone (US)', 'data-fv-phone, data-fv-phone___country=US');

// Siren
$form->addInput('text', 'user-siren', '', 'SIREN', 'data-fv-siren');

// Siret
$form->addInput('text', 'user-siret', '', 'SIRET', 'data-fv-siret');

// lowercase
$form->addInput('text', 'user-lowercase', '', 'lowercase', 'data-fv-string-case, data-fv-string-case___case=lower');

// UPPERCASE
$form->addInput('text', 'user-uppercase', '', 'UPPERCASE', 'data-fv-string-case, data-fv-string-case___case=upper');

// Min/Max length
$form->addInput('text', 'user-stringlength', '', 'Min/Max length', 'data-fv-string-length, data-fv-string-length___min=10, data-fv-string-length___max=20');

// VAT
$form->addInput('text', 'user-vat', '', 'VAT (GB)', 'data-fv-vat, data-fv-vat___country=GB');

// Iban
$form->addInput('text', 'user-Iban', '', 'IBAN', 'placeholder=Iban, data-fv-iban');

// Zipcode
$form->addInput('text', 'user-zipcode', '', 'Zipcode (GB)', 'data-fv-zip-code, data-fv-zip-code___country=GB');

// Reset / Submit
$form->setCols(4, 9, 'sm');
$form->addBtn('reset', 'reset-btn', 1, 'Reset <i class="material-icons right">cancel</i>', 'class=btn orange darken-1 waves-effect waves-light', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="material-icons right">done</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'my-btn-group');
$form->printBtnGroup('my-btn-group');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#validation-with-jquery-example-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Form with jQuery Live Validation - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create form with jQuery live validation using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/validation-with-jquery-example-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Form with jQuery Live Validation<br><small>real time validation using jQuery validator plugin</small></h1>
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
            ?>
            <div class="alert alert-info">
                <p>Validation methods &amp; arguments complete list available in <a href="https://www.phpformbuilder.pro/documentation/class-doc.html#jquery-validation-available-methods">Php Form Builder Class Doc</a></p>
            </div>
            <?php
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

        /* create a callback function to add the validators that we can't add with data-attributes */

        var fvCallback = function() {

            /* add the "different" validator to "user-different-fields-2" */

            var form = forms['validation-with-jquery-example-form'];
            form.fv.addField(
                'user-different-fields-2',
                {
                    validators: {
                        different: {
                            compare: function() {
                                return $('#user-different-fields-1').val();
                            },
                            message: 'The "Different field 2" must not be the same as "Different field 1"'
                        }
                    }
                }
            );
            form.fv.addField(
                'user-pass-confirm',
                {
                    validators: {
                        identical: {
                            compare: function() {
                                return $('#user-pass').val();
                            },
                            message: '"Password" & "Confirm Password" must be identical'
                        }
                    }
                }
            );
        };
    </script>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
