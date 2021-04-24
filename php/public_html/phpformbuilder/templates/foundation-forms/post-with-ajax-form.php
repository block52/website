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

$form = new Form('post-with-ajax-form', 'horizontal', 'novalidate', 'foundation');
$form->setMode('development');

$form->startFieldset('Subscribe to our newsletter');

$form->addInput('email', 'user-email', '', 'Your Email', 'required');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Subscribe <i class="fi fi-mail append"></i>', 'class=success button');

$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#post-with-ajax-form');



/* ==================================================
    2nd form - without the formvalidation plugin
================================================== */

$form2 = new Form('post-with-ajax-form-2', 'horizontal', 'novalidate', 'foundation');
// $form2->setMode('development');

$form2->startFieldset('Subscribe to our newsletter');

$form2->addInput('email', 'user-email-2', '', 'Your Email', 'required');
$form2->centerButtons(true);
$form2->addBtn('submit', 'submit-btn-2', 1, 'Subscribe <i class="fi fi-mail append"></i>', 'class=success button');

$form2->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Foundation Newsletter Subscribe Form - Ajax POST - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to POST a form with Ajax and Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/post-with-ajax-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">

    <!-- foundation icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">

    <!-- demo styles -->

    <link rel="stylesheet" href="../assets/css/code-preview-styles.min.css">

    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Foundation Newsletter Subscribe Form<br><small>posted with Ajax</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                <h2>1st form - posted with Ajax<br><small class="text-secondary">with the formvalidation plugin</small></h2>
                <div id="ajax-response"></div>
                <?php
                // 1st form
                $form->render();
                ?>

                <hr class="my-5">

                <h2>2nd form - posted with Ajax<br><small class="text-secondary">without the formvalidation plugin</small></h2>
                <div id="ajax-response2"></div>
                <?php
                // 2nd form
                $form2->render();
                ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.min.js"></script>
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
                    if (data.hasError) {
                        // if any error we reload the page to refresh the form
                        // errors have been registered in PHP SESSION by PHP Form Builder
                        location.reload();
                    }
                    // else we show the message in the target div
                    $(target).html(data.msg);
                    // & reset the form
                    document.getElementById('post-with-ajax-form-2').reset();
                    $('#post-with-ajax-form-2').find('.is-invalid-input').removeClass('is-invalid-input');
                    $('#post-with-ajax-form-2').find('.form-error').remove();
                });

                return false;
            });
        });
    </script>
</body>
</html>
