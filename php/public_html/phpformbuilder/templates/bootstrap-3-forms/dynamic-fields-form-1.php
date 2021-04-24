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
            'filter_values'   => 'dynamic-fields-form-1'
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

$form = new Form('dynamic-fields-form-1', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->setCols(2, 10);
$form->addInput('email', 'user-email', '', 'Your email', 'placeholder=Email, required');
$form->setCols(2, 4);
$form->groupInputs('job-1', 'person-1');
$form->addOption('job-1', 'Content writer', 'Content writer');
$form->addOption('job-1', 'Tech Support / Technical Leader', 'Tech Support / Technical Leader');
$form->addOption('job-1', 'Office Assistant', 'Office Assistant');
$form->addOption('job-1', 'Secretary', 'Secretary');
$form->addOption('job-1', 'Team Leader', 'Team Leader');
$form->addOption('job-1', 'Data Analyst', 'Data Analyst');
$form->addOption('job-1', 'Safety Officer', 'Safety Officer');
$form->addOption('job-1', 'Delivery Boy', 'Delivery Boy');
$form->addOption('job-1', 'Admin Assistant', 'Admin Assistant');
$form->addSelect('job-1', 'Job 1', 'class=selectpicker job, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, title=Select a Job ..., required');
$form->addOption('person-1', 'Adam Bryant', 'Adam Bryant');
$form->addOption('person-1', 'Lillian Riley', 'Lillian Riley');
$form->addOption('person-1', 'Paula Day', 'Paula Day');
$form->addOption('person-1', 'Kelly Stephens', 'Kelly Stephens');
$form->addOption('person-1', 'Russell Hawkins', 'Russell Hawkins');
$form->addOption('person-1', 'Carl Watson', 'Carl Watson');
$form->addOption('person-1', 'Judith White', 'Judith White');
$form->addOption('person-1', 'Tina Cook', 'Tina Cook');
$form->addSelect('person-1', 'Person 1', 'class=selectpicker person, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, title=Select a Person ..., required');
$form->addHtml('<div id="ajax-elements-container"></div>');

// hidden field to count posted jobs
$form->addInput('hidden', 'job-count', '');

// buttons add/remove
$form->setCols(0, 12);
$options = array(
        'btnGroupClass' => 'btn-group pull-right'
);
$form->setOptions($options);
$form->addBtn('button', 'remove-btn', 0, 'Remove Element', 'class=btn btn-danger remove-element-button hidden ladda-button, data-style=zoom-in', 'add-remove-group');
$form->addBtn('button', 'add-element', 1, 'Add Element', 'class=btn btn-primary add-element-button ladda-button', 'add-remove-group');
$form->printBtnGroup('add-remove-group');

// cancel/submit
$form->addHtml('<p>&nbsp;
</p><p>&nbsp;</p>');
$options = array(
        'btnGroupClass' => 'btn-group'
);
$form->setOptions($options);
$form->centerButtons(true);
$form->addBtn('button', 'cancel', 0, 'Cancel', 'class=btn btn-warning', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success ladda-button, data-style=zoom-in', 'btn-group');
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
    <title>Bootstrap 3 Dynamic fields Form using Ajax - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap 3 Form Generator - how to create a Php Form with Ajax dynamic fields using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/dynamic-fields-form-1.php" />
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
</head>
<body>
    <h1 class="text-center">Php Form Builder - Form with Ajax Dynamic fields<br><small>click "Add Element" button</small></h1>
    <div class="container">
        <div class="row">
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

    <script src="//code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Select Destinations / Hotels -->
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

                var form = forms['dynamic-fields-form-1'];

                // increment job-count
                var newIndex = parseInt($('input[name="job-count"]').val()) + 1;
                $('input[name="job-count"]').val(newIndex);

                // trigger each element on page load
                if(newIndex < <?php echo $_SESSION['dynamic-fields-form-1']['job-count']; ?>) {
                    addElement();
                }
                // enable selectpicker for new fields
                $(".selectpicker").selectpicker({container: 'body'});

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
                if (parseInt($('select.job').length) > 1) {
                    $('.remove-element-button').removeClass('hidden').off('click').on('click', function () {
                        Ladda.stopAll();
                        $('#ajax-elements-container .form-group').last().remove();

                        // decrement job-count
                        $('input[name="job-count"]').val(parseInt($('input[name="job-count"]').val()) - 1);

                        // hide remove button if only 1 job selector
                        if(parseInt($('select.job').length) < 2) {
                            $('.remove-element-button').addClass('hidden').off('click');
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
