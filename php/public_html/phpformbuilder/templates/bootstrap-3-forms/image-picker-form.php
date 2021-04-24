<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

 @session_start();
 include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

 /* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('image-picker-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('image-picker-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['image-picker-form'] = $validator->getAllErrors();
    } else {
        // replace images URLs with html img code
        $values = [];
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $value[$k] = preg_replace('`^https://(.*)`', '<img src="https://$1" />', $v);
                }
                $values[$key] = $value;
            } else {
                $values[$key] = preg_replace('`^https://(.*)`', '<img src="https://$1" />', $value);
            }
        }

        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Selected Images from Php Form Builder',
            'values'          => $values,
            'filter_values'   => 'image-picker-form'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('image-picker-form');
    }
}
$form = new Form('image-picker-form', 'vertical', 'novalidate', 'bs3');
// $form->setMode('development');

// Single image
$form->startFieldset('Single image select');
for ($i=0; $i < 10; $i++) {
    $form->addOption('animal', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/animals-' . $i . '.jpg', '', '', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/animals-' . $i . '.jpg, data-img-alt=Animal ' . $i);
}
$form->addSelect('animal', 'Choose your preferred animal', 'required');
$form->endFieldset();

// Multiple select
$form->startFieldset('Multiple select');
$form->addHelper('Multiple choices', 'landscapes');
for ($i=0; $i < 10; $i++) {
    $form->addOption('landscapes[]', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/landscapes/landscape-' . $i . '.jpg', '', '', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/landscapes/landscape-' . $i . '.jpg, data-img-alt=Landscape ' . $i);
}
$form->addSelect('landscapes[]', 'Choose your preferred landscapes', 'multiple, required');
$form->endFieldset();

// Multiple select with limit
$form->startFieldset('Multiple select with limit');
$form->addHelper('Maximum 2', 'cities');
for ($i=0; $i < 10; $i++) {
    $form->addOption('cities[]', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/cities/city-' . $i . '.jpg', '', '', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/cities/city-' . $i . '.jpg, data-img-alt=City image ' . $i);
}
$form->addSelect('cities[]', 'Choose your preferred cities', 'multiple, data-limit=2, required');
$form->endFieldset();

// Single image with labels
$form->startFieldset('Single image with labels');
for ($i=0; $i < 10; $i++) {
    $form->addOption('single-image', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/sports/sport-' . $i . '.jpg', '', '', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/sports/sport-' . $i . '.jpg, data-img-label=Sport ' . $i . ', data-img-alt=Sport' . $i);
}
$form->addSelect('single-image', 'Choose your favourite sport', 'class=show_label, required');
$form->endFieldset();

// Single image with  grouped options
$form->startFieldset('Single image with grouped options');
for ($i=0; $i < 5; $i++) {
    $form->addOption('animal-2', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/cats/cat-' . $i . '.jpg', '', 'Cats', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/cats/cat-' . $i . '.jpg, data-img-alt=Cat ' . $i);
}
for ($i=0; $i < 5; $i++) {
    $form->addOption('animal-2', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/dogs/dog-' . $i . '.jpg', '', 'Dogs', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/dogs/dog-' . $i . '.jpg, data-img-alt=Dog ' . $i);
}
for ($i=0; $i < 5; $i++) {
    $form->addOption('animal-2', 'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/animals-' . $i . '.jpg', '', 'Other animals', 'data-img-src=https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/animals-' . $i . '.jpg, data-img-alt=Others ' . $i);
}
$form->addSelect('animal-2', 'Choose your preferred animal', 'required');
$form->endFieldset();

$form->addInput('email', 'user-email', '', 'Your Email', 'placeholder=Email, required');

$form->addBtn('button', 'cancel', 0, 'Cancel', 'class=btn btn-warning', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success', 'btn-group');
$form->printBtnGroup('btn-group');

// image picker plugin
$form->addPlugin('image-picker', 'select');

// jQuery validation
$form->addPlugin('formvalidation', '#image-picker-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Image picker Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create an Image picker Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/image-picker-form.php" />
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
    <h1 class="text-center">Php Form Builder - Bootstrap Image picker Form<br><small>with captions &amp; multiple selects</small></h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
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
