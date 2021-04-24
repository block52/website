<?php
use phpformbuilder\Form;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';
define('NUMBER_OF_STEPS', 5);

// Create a form to load plugins CSS & JS files
$form = new Form('cs-step-plugins-loader', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->addPlugin('bootstrap-select', '.selectpicker');
$form->addPlugin('ladda', '.ladda-button');
$form->addPlugin('icheck', 'input', 'default', array('%theme%' => 'flat', '%color%' => 'red'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Customer Satisfaction Step Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Customer Satisfaction Step Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/customer-satisfaction-step-form.php" />
    <!-- Link to Bootstrap css here -->
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
            AND REPLACE WITH BOOTSTRAP CSS
            FOR EXAMPLE <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <!-- Loading plugins CSS for all steps -->
    <?php $form->printIncludes('css'); ?>
    <!-- Step Form css -->
    <style type="text/css">
        #ajax-form {
            width: 100%;
            min-height: 500px;
            overflow: hidden;
        }
        #slide {
            width: <?php echo 100 * NUMBER_OF_STEPS ?>%;
        }
        .step {
            width: <?php echo 100 / NUMBER_OF_STEPS ?>%;
        }
        .step:not(#step-1) {
            opacity: 0;
        }
        .radio-label-vertical-wrapper {
            padding-bottom: 13px;
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }
        .radio-label-vertical-wrapper label:not(.radio-label-vertical) {
          display: block;
          width: 100%;
        }
        .radio-label-vertical {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            padding: 0 20px;
            text-align: center;
        }
        .radio-label-vertical input {
            position: absolute;
            top: 28px;
            left: 50%;
            margin-left: -6px;
            display: block;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Customer Satisfaction Step Form<br><small>Step Form with Slide Effect</small></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                <?php
                if (isset($sent_message)) {
                    echo $sent_message;
                }
                ?>
                <legend>Customer Satisfaction Slide Step Form</legend>
                <div id="ajax-form">
                    <div id="slide">
                        <div class="step pull-left" id="step-1"></div>
                        <div class="step pull-left" id="step-2"></div>
                        <div class="step pull-left" id="step-3"></div>
                        <div class="step pull-left" id="step-4"></div>
                        <div class="step pull-left clearfix" id="step-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Loading plugins JS for all steps -->
    <?php $form->printIncludes('js'); ?>
    <script type="text/javascript">
        var stepWidth,
            targetIndex;

        var initFormEvents = function(formID) {
            $('#' + formID).off('submit').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'customer-satisfaction-step-form/cs-steps.php',
                    type: 'POST',
                    data: $(this).serialize()
                }).done(function (data) {
                    // DEBUG:
                    // uncomment the following "console.log" to show the loaded content in the browser console
                    // console.log(data);
                    targetIndex = $(data).find('button[name="submit-btn"]').val();
                    $('#step-' + (targetIndex - 1)).animate({'opacity': 0}, 600);
                    $('#step-' + targetIndex).html(data).animate({'opacity': 1}, 600);
                    stepWidth = $('#step-1').width();
                    $('#slide').animate({
                        'margin-left': (-(stepWidth * (targetIndex - 1)))
                    }, 600);
                });
            });
            var $backButton = $('#' + formID + ' button[name="back-btn"]');
            if ($backButton[0]) {
                $backButton.on('click', function (e) {
                    e.preventDefault();
                    targetIndex = ($(this).val() - 1);
                    $.ajax({
                        url: 'customer-satisfaction-step-form/cs-steps.php',
                        type: 'POST',
                        data: {
                            'back_to_step': targetIndex
                        }
                    }).done(function (data) {
                        targetIndex = parseInt($(data).find('button[name="submit-btn"]').val());
                        $('#step-' + (targetIndex + 1)).animate({'opacity': 0}, 600);
                        $('#step-' + targetIndex).html(data).animate({'opacity': 1}, 600);
                        stepWidth = $('#step-1').width();
                        $('#slide').animate({
                            'margin-left': (-(stepWidth * (targetIndex - 1)))
                        }, 600);
                    });
                });
            }
            $(window).on('resize', function() {
                stepWidth = $('#step-1').width();
                $('#slide').css('margin-left', (-(stepWidth * (targetIndex - 1))));
            });
        }
        $(document).ready(function () {
            $.ajax({
                url: 'customer-satisfaction-step-form/cs-steps.php',
                async: true
            })
            .done(function (data) {
                $('#step-1').html(data);
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
