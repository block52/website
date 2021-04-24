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
$form->addBtn('submit', 'submit-btn', 1, 'Subscribe <i class="material-icons right">email</i>', 'class=btn btn-large waves-effect waves-light ladda-button, data-style=zoom-in');

$form->endFieldset();

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
$form2->addBtn('submit', 'submit-btn-2', 1, 'Subscribe <i class="material-icons right">email</i>', 'class=btn btn-large waves-effect waves-light ladda-button, data-style=zoom-in');

$form2->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Material Design Newsletter Subscribe Form - Ajax POST - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to POST a form with Ajax and Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/material-forms/post-with-ajax-form.php" />

    <!-- Materialize CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Material icons CSS -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- demo styles -->

    <link rel="stylesheet" href="../assets/css/code-preview-styles.min.css">

    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Material Design Newsletter Subscribe Form<br><small>posted with Ajax</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>
        <div class="row">
            <div class="col m8 offset-m2 l6 offset-l3">
                <h2>1st form - posted with Ajax<br><small>with the formvalidation plugin</small></h2>
                <div id="ajax-response"></div>
                <?php
                // 1st form
                $form->render();
                ?>

                <p>&nbsp;</p>

                <h2>2nd form - posted with Ajax<br><small>without the formvalidation plugin</small></h2>
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

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
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
                    document.getElementById("post-with-ajax-form").reset();
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

    <script>$('#material-collapsible-notice').collapsible();</script>
</body>
</html>
