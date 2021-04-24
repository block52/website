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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('dynamic-fields-form-1') === true) {
    include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Validator/Validator.php';
    include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
    $required = array();

    // create validator & auto-validate required fields
    $validator = Form::validate('dynamic-fields-form-1');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['dynamic-fields-form-1'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Dynamic fields Form 1',
            'filter_values'   => 'dynamic-fields-form-1',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('dynamic-fields-form-1');
    }
}

// hidden field value to count posted jobs
if (!isset($_SESSION['dynamic-fields-form-1']['job-count'])) {
    $_SESSION['dynamic-fields-form-1']['job-count'] = 1;
}

/* ==================================================
    The Form
================================================== */

$form = new Form('dynamic-fields-form-1', 'horizontal', '', 'material');
// $form->setMode('development');
$form->setCols(2, 10);
$form->addInput('email', 'user-email', '', 'Your email', 'placeholder=Email, required');
$form->setCols(2, 4);
$form->groupInputs('job-1', 'person-1');
$form->addOption('job-1', '', 'Select a Job', '', 'selected disabled');
$form->addOption('job-1', 'Content writer', 'Content writer');
$form->addOption('job-1', 'Tech Support / Technical Leader', 'Tech Support / Technical Leader');
$form->addOption('job-1', 'Office Assistant', 'Office Assistant');
$form->addOption('job-1', 'Secretary', 'Secretary');
$form->addOption('job-1', 'Team Leader', 'Team Leader');
$form->addOption('job-1', 'Data Analyst', 'Data Analyst');
$form->addOption('job-1', 'Safety Officer', 'Safety Officer');
$form->addOption('job-1', 'Delivery Boy', 'Delivery Boy');
$form->addOption('job-1', 'Admin Assistant', 'Admin Assistant');
$form->addSelect('job-1', 'Job 1', 'class=job, required');

$form->addOption('person-1', '', 'Select a Person', '', 'selected disabled');
$form->addOption('person-1', 'Adam Bryant', 'Adam Bryant');
$form->addOption('person-1', 'Lillian Riley', 'Lillian Riley');
$form->addOption('person-1', 'Paula Day', 'Paula Day');
$form->addOption('person-1', 'Kelly Stephens', 'Kelly Stephens');
$form->addOption('person-1', 'Russell Hawkins', 'Russell Hawkins');
$form->addOption('person-1', 'Carl Watson', 'Carl Watson');
$form->addOption('person-1', 'Judith White', 'Judith White');
$form->addOption('person-1', 'Tina Cook', 'Tina Cook');
$form->addSelect('person-1', 'Person 1', 'class=person, required');
$form->addHtml('<div id="ajax-elements-container"></div>');

// hidden field to count posted jobs
$form->addInput('hidden', 'job-count', '');

// buttons add/remove
$form->setCols(0, 12);
$options = array(
        'btnGroupClass' => 'btn-group right-align'
);
$form->setOptions($options);
$form->addBtn('button', 'remove-btn', 0, 'Remove Element', 'class=btn red remove-element-button hide ladda-button, data-style=zoom-in', 'add-remove-group');
$form->addBtn('button', 'add-element', 1, 'Add Element', 'class=btn btn-primary add-element-button ladda-button', 'add-remove-group');
$form->printBtnGroup('add-remove-group');

// cancel/submit
$options = array(
        'btnGroupClass' => 'btn-group my-5'
);
$form->setOptions($options);
$form->centerButtons(true);
$form->addBtn('button', 'cancel', 0, 'Cancel', 'class=btn orange darken-1 waves-effect waves-light', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'btn-group');
$form->printBtnGroup('btn-group');

// jQuery validation
$form->addPlugin('formvalidation', '#dynamic-fields-form-1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Dynamic fields Form using Ajax - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a Php Form with Ajax dynamic fields using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/dynamic-fields-form-1.php" />

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
    <h1 class="center-align">Php Form Builder - Form with Ajax Dynamic fields<br><small>click "Add Element" button</small></h1>
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

    <script type="text/javascript">
        var addElement = function() {

            // target to receive dynamic fields
            var target = $('#ajax-elements-container');

            // ajax call
            $.ajax({
                url: 'dynamic-fields-form-1/ajax-elements.php',
                data: {
                    'job-index': parseInt($('input[name="job-count"]').val()) + 1
                }
            }).done(function (data) {
                target.append(data);
                Ladda.stopAll();

                // material select
                $('#dynamic-fields-form-1 select').formSelect();

                var form = forms['dynamic-fields-form-1'];

                // increment job-count
                var newIndex = parseInt($('input[name="job-count"]').val()) + 1;
                $('input[name="job-count"]').val(newIndex);

                // trigger each element on page load
                if(newIndex < <?php echo $_SESSION['dynamic-fields-form-1']['job-count']; ?>) {
                    addElement();
                }

                // enable validator for the new fields
                form.fv.addField(
                    'job-' + newIndex,
                    {
                        validators: {
                            notEmpty: {}
                        }
                    }
                );
                form.fv.addField(
                    'person-' + newIndex,
                    {
                        validators: {
                            notEmpty: {}
                        }
                    }
                );

                // show remove button if more than 1 job selector
                if(parseInt($('select.job').length) > 1) {
                    $('.remove-element-button').removeClass('hide').off('click').on('click', function () {
                        Ladda.stopAll();
                        $('#ajax-elements-container .form-group').last().remove();

                        // decrement job-count
                        $('input[name="job-count"]').val(parseInt($('input[name="job-count"]').val()) - 1);

                        // hide remove button if only 1 job selector
                        if(parseInt($('select.job').length) < 2) {
                            $('.remove-element-button').addClass('hide').off('click');
                        }

                        // Ajax call to unset removed fields from form required fields
                        $.ajax({
                            url: 'dynamic-fields-form-1/unset-ajax-elements.php',
                            data: {
                                'job-index': parseInt($('input[name="job-count"]').val()) + 1
                            }
                        }).done(function (data) {
                            // remove validator for the removed fields
                            var newIndex = parseInt($('input[name="job-count"]').val()) + 1;

                            form.fv.removeField('job-' + newIndex);
                            form.fv.removeField('person-' + newIndex);
                        });
                    });
                }
                var run = window.run;
                if(typeof(run) != 'undefined') {
                    setTimeout(run, 0);
                }
            }).fail(function (data, statut, error) {
                console.log(error);
            });
        };
        $(document).ready(function () {
            $('#dynamic-fields-form-1 select').formSelect();
            $('.add-element-button').on('click', addElement);
            <?php if ($_SESSION['dynamic-fields-form-1']['job-count'] > 1) { ?>
                $('input[name="job-count"]').val(1);
                addElement();
            <?php } ?>
        });
    </script>
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
