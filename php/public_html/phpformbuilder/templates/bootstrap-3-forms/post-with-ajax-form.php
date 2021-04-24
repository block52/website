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

$form = new Form('post-with-ajax-form', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');

$form->startFieldset('Subscribe to our newsletter');

$form->addInput('email', 'user-email', '', 'Your Email', 'required');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Subscribe <i class="fa fa-envelope fa-lg fa-fw ml-2"></i>', 'class=btn btn-lg btn-success ladda-button, data-style=zoom-in');

$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#post-with-ajax-form');



/* ==================================================
    2nd form - without the formvalidation plugin
================================================== */

$form2 = new Form('post-with-ajax-form-2', 'horizontal', 'novalidate', 'bs3');
// $form2->setMode('development');

$form2->startFieldset('Subscribe to our newsletter');

$form2->addInput('email', 'user-email-2', '', 'Your Email', 'required');
$form2->centerButtons(true);
$form2->addBtn('submit', 'submit-btn-2', 1, 'Subscribe <i class="fa fa-envelope fa-lg fa-fw ml-2"></i>', 'class=btn btn-lg btn-success ladda-button, data-style=zoom-in');

$form2->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap Newsletter Subscribe Form - Ajax POST - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to POST a form with Ajax and Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/post-with-ajax-form.php" />

    <!-- Bootstrap 3 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- demo styles -->

    <link rel="stylesheet" href="../assets/css/code-preview-styles.min.css">

    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center mb-md-5">Php Form Builder - BS3 Newsletter Subscribe Form<br><small>posted with Ajax</small></h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h2 class="h3">1st form - posted with Ajax<br><small class="text-secondary">with the formvalidation plugin</small></h2>
                <div id="ajax-response"></div>
                <?php
                // 1st form
                $form->render();
                ?>

                <hr>

                <h2 class="h3">2nd form - posted with Ajax<br><small class="text-secondary">without the formvalidation plugin</small></h2>
                <div id="ajax-response-2"></div>
                <?php
                // 2nd form
                $form2->render();
                ?>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            var target = '#ajax-response-2';
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
                    $('#post-with-ajax-form-2').find('.has-error').removeClass('has-error');
                    $('#post-with-ajax-form-2').find('.text-danger').remove();
                });

                return false;
            });
        });
    </script>
</body>
</html>
