<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

// define the form name globally
$form_id = 'dynamic-fields-form-2';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken($form_id) === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate($form_id);

    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors'][$form_id] = $validator->getAllErrors();

        // register errors in a custom session variable to transmit to ajax dynamic form
        // because errors will be registered & cleared when we construct the form
        $_SESSION['ajax-errors'][$form_id] = $_SESSION['errors'][$form_id];
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Dynamic fields Form 2',
            'filter_values'   => $form_id,
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear($form_id);
        if (isset($_SESSION['ajax-errors'][$form_id])) {
            unset($_SESSION['ajax-errors'][$form_id]);
        }
    }
}

// clear dynamic errors on page load
if ($_SERVER["REQUEST_METHOD"] !== "POST" && isset($_SESSION['ajax-errors'][$form_id])) {
    unset($_SESSION['ajax-errors'][$form_id]);
}

/* ==================================================
    The Form
================================================== */

$form = new Form($form_id, 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$options = array(
        'elementsWrapper' => '<div class="form-group row justify-content-start"></div>'
);
$form->setOptions($options);
$form->setCols(2, 8, 'md');
$form->addInput('email', 'user-email', '', 'Your email', 'placeholder=Email, required');
$form->setCols(2, 3, 'md');

$form->groupInputs('job-1', 'person-1');

$form->addOption('job-1', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('job-1', 'Content writer', 'Content writer');
$form->addOption('job-1', 'Tech Support / Technical Leader', 'Tech Support / Technical Leader');
$form->addOption('job-1', 'Office Assistant', 'Office Assistant');
$form->addOption('job-1', 'Secretary', 'Secretary');
$form->addOption('job-1', 'Team Leader', 'Team Leader');
$form->addOption('job-1', 'Data Analyst', 'Data Analyst');
$form->addOption('job-1', 'Safety Officer', 'Safety Officer');
$form->addOption('job-1', 'Delivery Boy', 'Delivery Boy');
$form->addOption('job-1', 'Admin Assistant', 'Admin Assistant');
$form->addSelect('job-1', 'Job', 'class=job, required');

$form->addOption('person-1', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('person-1', 'Adam Bryant', 'Adam Bryant');
$form->addOption('person-1', 'Lillian Riley', 'Lillian Riley');
$form->addOption('person-1', 'Paula Day', 'Paula Day');
$form->addOption('person-1', 'Kelly Stephens', 'Kelly Stephens');
$form->addOption('person-1', 'Russell Hawkins', 'Russell Hawkins');
$form->addOption('person-1', 'Carl Watson', 'Carl Watson');
$form->addOption('person-1', 'Judith White', 'Judith White');
$form->addOption('person-1', 'Tina Cook', 'Tina Cook');
$form->addSelect('person-1', 'Person', 'class=person, required');

// Dynamic fields - container + add button

$form->addHtml('<div id="ajax-elements-container"></div>');
$form->addHtml('<div class="row"><div class="col m2"><p>&nbsp;</p></div>');
$form->addHtml('<div class="col m3"><button type="button" class="btn btn-primary add-element-button"><i class="material-icons" aria-hidden="true">add_circle</i></button><p>&nbsp;</p></div>');
$form->addHtml('</div>');

// End Dynamic fields

// cancel/submit
$form->setCols(0, 12);
$form->centerButtons(true);
$form->addBtn('button', 'cancel', 0, 'Cancel', 'class=btn orange darken-1 waves-effect waves-light', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'btn-group');
$form->printBtnGroup('btn-group');

// jQuery validation
$form->addPlugin('formvalidation', '#' . $form_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Php Form with Ajax dynamic fields - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to load dynamic fields on the fly with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/dynamic-fields-form-2.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Form with dynamic ajax-loaded fields<br><small>Click "+" or "-" buttons to add or remove fields</small></h1>
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

        /* =============================================
            Dynamic fields standard code
            (No need to touch anything here)
        ============================================= */

        $(document).ready(function () {
            var form = forms['<?php echo $form_id; ?>'];

            $('#<?php echo $form_id; ?> select').formSelect();

            // target to receive dynamic fields
            var target = $('#ajax-elements-container');
            target.closest('form').prepend('<input type="hidden" name="dynamic-fields-index" value="1">');

            // first dynamic index is "1"
            var firstDynamicIndex       = 1,
                postedDynamicIndex      = 0,
                loadPostedDynamicFields = true;

            var countInput = $('input[name="dynamic-fields-index"]'),
                dfIndex  = parseInt(countInput.val());

            // hidden field to store dynamic fields index

            $('.add-element-button').on('click', function () {

                // increment index & dynamic-fields-index
                dfIndex ++;
                countInput.val(dfIndex);

                // ajax call
                $.ajax({
                    url: '<?php echo $form_id; ?>/dynamic-elements.php',
                    type: 'POST',
                    data: {
                        index: dfIndex
                    }
                }).done(function (data) {

                    target.append(data);

                    // material select
                    $('#dynamic-fields-form-2 select').formSelect();

                    // enable validator for the new fields
                    form.fv.addField(
                        'job-' + dfIndex,
                        {
                            validators: {
                                notEmpty: {}
                            }
                        }
                    );
                    form.fv.addField(
                        'person-' + dfIndex,
                        {
                            validators: {
                                notEmpty: {}
                            }
                        }
                    );

                    $('select[name="job-' + dfIndex + '"]').on('change', function() {
                        form.fv.revalidateField(this.name);
                    });

                    $('select[name="person-' + dfIndex + '"]').on('change', function() {
                        form.fv.revalidateField(this.name);
                    });

                    var run = window.run;
                    if(typeof(run) != 'undefined') {
                        setTimeout(run, 0);
                    }

                    // load posted dynamic fields
                    if (loadPostedDynamicFields === true && postedDynamicIndex > dfIndex) {
                        setTimeout(function() {
                            $('.add-element-button').trigger('click');
                        }, 100);
                    } else {
                        // all posted fields loaded
                        loadPostedDynamicFields = false;
                    }

                    // Remove action
                    $('.remove-element-button').removeClass('hidden').off('click').on('click', function () {
                        var currentIndex = parseInt($(this).attr('data-index')); // index of removed dynamic

                        // Transfer upper dynamics values to each previous
                        var transferUpperValues = function() {
                            var previousDynamic = $('.dynamic[data-index="' + (currentIndex) + '"]'),
                                previousFields  = $(previousDynamic).find('input, textarea, select, radio, checkbox');
                            $(previousFields).each(function(i, field) {

                                // skip input.select-dropdown created by materialize
                                if (!$(field).is('input.select-dropdown')) {
                                    var followingField = '',
                                        newValue = '';
                                    if($(field).is('input[type="radio"]')) {
                                        var followingFieldName = $(field).attr('name').replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                                        followingField = $('input[name="' + followingFieldName + '"]:checked');
                                        newValue = followingField.val();
                                        if($(field).val() == newValue) {
                                            $(field).prop('checked', true);
                                        } else {
                                            $(field).prop('checked', false);
                                        }
                                    } else {
                                        var followingFieldId = $(field).attr('id').replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                                        followingField = $('#' + followingFieldId);
                                        if($(field).is('select')) {
                                            newValue = followingField.find('option:selected').val();
                                            $(field).val(newValue).formSelect();
                                        } else  {
                                            newValue = followingField.val();
                                            $(field).val(newValue);
                                        }
                                    }
                                }
                            });
                        };

                        // if upper dynamic sections
                        var upperIndex = currentIndex - firstDynamicIndex;
                        if($('.dynamic')[upperIndex]) {
                            while ($($('.dynamic')[upperIndex]).length > 0) {
                                transferUpperValues();
                                currentIndex ++;
                                upperIndex ++;
                            }
                        }

                        // Ajax call to unset removed fields from form required fields
                        $.ajax({
                            url: '<?php echo $form_id; ?>/unset-ajax-elements.php',
                            data: {
                                'index': dfIndex
                            }
                        }).done(function (data) {
                            // remove validator for the removed fields

                            form.fv.removeField('job-' + (dfIndex + 1));
                            form.fv.removeField('person-' + (dfIndex + 1));
                        });

                        // decrement dynamic-fields-index
                        dfIndex -= 1;
                        countInput.val(dfIndex);

                        // remove last dynamic container
                        $('.remove-element-button:last').closest('.dynamic').remove();
                    });
                }).fail(function (data, statut, error) {
                    console.log(error);
                });
            });

            // reload posted fields
            <?php
                $index = 1;
            if (isset($_POST['dynamic-fields-index']) && isset($_SESSION['ajax-errors'][$form_id])) {
                $index = $_POST['dynamic-fields-index'];
            }
            if ($index > 1) {
            ?>
            postedDynamicIndex = <?php echo $index; ?>;
            setTimeout(function() {
                $('.add-element-button').trigger('click');
            }, 200);
            <?php
            } // end if
            ?>
            $('select[name="job-' + dfIndex + '"]').on('change', function() {
                form.fv.revalidateField(this.name);
            });

            $('select[name="person-' + dfIndex + '"]').on('change', function() {
                form.fv.revalidateField(this.name);
            });
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
