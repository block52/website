<?php
use phpformbuilder\Form;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';



/* ==================================================
    1st form - with the formvalidation plugin
================================================== */

$form = new Form('post-with-ajax-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

$form->startFieldset('Subscribe to our newsletter');

$form->addInput('email', 'user-email', '', 'Your Email', 'required');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Subscribe<i class="fa fa-envelope fa-lg fa-fw ml-2"></i>', 'class=btn btn-lg btn-success ladda-button, data-style=zoom-in');

$form->endFieldset();

// materialize plugin
$form->addPlugin('materialize', '#post-with-ajax-form');

// jQuery validation
$form->addPlugin('formvalidation', '#post-with-ajax-form');



/* ==================================================
    2nd form - without the formvalidation plugin
================================================== */

$form2 = new Form('post-with-ajax-form-2', 'horizontal', 'novalidate', 'material');
// $form2->setMode('development');

$form2->startFieldset('Subscribe to our newsletter');

$form2->addInput('email', 'user-email-2', '', 'Your Email', 'required');
$form2->centerButtons(true);
$form2->addBtn('submit', 'submit-btn-2', 1, 'Subscribe<i class="fa fa-envelope fa-lg fa-fw ml-2"></i>', 'class=btn btn-lg btn-success ladda-button, data-style=zoom-in');

$form2->endFieldset();

// materialize plugin
$form->addPlugin('materialize', '#post-with-ajax-form-2');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Material Design Bootstrap 4 Newsletter Subscribe Form - Ajax POST - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Bootstrap 4 Form Generator - how to POST a form with Ajax and Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-bootstrap-forms/post-with-ajax-form.php" />

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- demo styles -->

    <link rel="stylesheet" href="../assets/css/code-preview-styles.min.css">

    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center mb-md-5">Php Form Builder - Newsletter Subscribe Form<br><small>posted with Ajax</small></h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6">
                <h2 class="h3 mb-5">1st form - posted with Ajax<br><small class="text-secondary">with the formvalidation plugin</small></h2>
                <div id="ajax-response"></div>
                <?php
                // 1st form
                $form->render();
                ?>

                <hr class="my-5">

                <h2 class="h3 mb-5">2nd form - posted with Ajax<br><small class="text-secondary">without the formvalidation plugin</small></h2>
                <div id="ajax-response2"></div>
                <?php
                // 2nd form
                $form2->render();
                ?>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <!-- Bootstrap 4 JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <?php
        $form->printIncludes('js');
        $form->printJsCode();
        $form2->printJsCode();
    ?>
    <script type="text/javascript">

        /* 1st form - with the formvalidation plugin
        -------------------------------------------------- */

        var fvCallback = function() {
            var form = forms['post-with-ajax-form'],
                target = '#ajax-response';
            // form.fv is the validator
            // you can then use the formvalidation plugin API
            form.fv.on('core.form.valid', function() {
                $.ajax({
                    url: 'ajax-forms/post-with-ajax-form.php',
                    type: 'POST',
                    data: $('#post-with-ajax-form').serialize()
                }).done(function (data) {
                    data = JSON.parse(data);
                    // remove button spinner
                    $('button[name="submit-btn"]').removeAttr('data-loading');
                    if (data.hasError) {
                        // if any error we reload the page to refresh the form
                        // errors have been registered in PHP SESSION by PHP Form Builder
                        location.reload();
                    }
                    // else we show the message in the target div
                    $(target).html(data.msg);
                    // & reset the form
                    document.getElementById('post-with-ajax-form').reset();
                });
                return false;
            });
        };

        $(document).ready(function () {
            $('#post-with-ajax-form').on('submit', function (e) {
                e.preventDefault();
                return false;
            });
        });
    </script>



    <script type="text/javascript">

        /* 2nd form - without the formvalidation plugin
        -------------------------------------------------- */

        $(document).ready(function () {
            var target = '#ajax-response2';
            $('#post-with-ajax-form-2').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'ajax-forms/post-with-ajax-form-2.php',
                    type: 'POST',
                    data: $('#post-with-ajax-form-2').serialize()
                }).done(function (data) {
                    data = JSON.parse(data);
                    // remove button spinner
                    $('button[name="submit-btn-2"]').removeAttr('data-loading');
                    if (data.hasError) {
                        // if any error we reload the page to refresh the form
                        // errors have been registered in PHP SESSION by PHP Form Builder
                        location.reload();
                    }
                    // else we show the message in the target div
                    $(target).html(data.msg);
                    // & reset the form
                    document.getElementById('post-with-ajax-form-2').reset();
                    $('#post-with-ajax-form-2').find('.is-invalid').removeClass('is-invalid');
                    $('#post-with-ajax-form-2').find('.invalid-feedback').remove();
                });

                return false;
            });
        });
    </script>
</body>
</html>
