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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('customer-feedback-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('customer-feedback-form');

    // additional validation
    $validator->required('<br>Please rate')->validate('company-rating');
    $validator->required('<br>Please rate')->validate('support-rating');
    $validator->required('Please choose one or several product(s)')->validate('product-choice.0');
    $validator->email()->validate('customer-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['customer-feedback-form'] = $validator->getAllErrors();
    } else {
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['customer-email']),
            'subject'         => 'Php Form Builder - Customer Feedback Form',
            'filter_values'   => 'customer-feedback-form'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('customer-feedback-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('customer-feedback-form', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->startFieldset('Customer Feedback Form');
$form->addHtml('<p class="text-primary text-center">You are encouraged to use the online feedback form below to send us your comments as well as any queries about our products.</p><br>');

// 1st row - left col
$form->addHtml('<div class="row">');
$form->addHtml('<div class="col-md-6">');
$form->addInput('text', 'customer-name', '', 'Customer Name', 'required');
$form->addInput('email', 'customer-email', '', 'E-Mail Address', 'required');
$form->addInput('text', 'organization', '', 'Organization');
$form->addHtml('</div>');

// 1st row - right col
$form->addHtml('<div class="col-md-6">');
$form->addOption('product-choice[]', 'Computers', 'Computers', '', 'data-icon=glyphicon-hdd');
$form->addOption('product-choice[]', 'Games', 'Games', '', 'data-icon=glyphicon-send');
$form->addOption('product-choice[]', 'Books', 'Books', '', 'selected, data-icon=glyphicon-book');
$form->addOption('product-choice[]', 'Music', 'Music', '', 'selected, data-icon=glyphicon-headphones');
$form->addOption('product-choice[]', 'Photos', 'Photos', '', 'data-icon=glyphicon-picture');
$form->addOption('product-choice[]', 'Films', 'Films', '', 'data-icon=glyphicon-film');
$form->addHelper('(multiple choices)', 'product-choice[]');
$form->addSelect('product-choice[]', 'What products are you interested in ?', 'class=selectpicker, data-icon-base=glyphicon, multiple, required');
$form->addHtml('</div>');
$form->addHtml('</div>');

// 2nd row - left col
$form->addHtml('<div class="row">');
$form->addHtml('<div class="col-md-6">');
$form->addRadio('company-rating', 'Very High', 'Very High');
$form->addRadio('company-rating', 'High', 'High');
$form->addRadio('company-rating', 'Neutral', 'Neutral', 'checked=checked');
$form->addRadio('company-rating', 'Low', 'Low');
$form->addRadio('company-rating', 'Very Low', 'Very Low');
$form->printRadioGroup('company-rating', 'How would you rate our company ?', false, 'required');
$form->addHtml('</div>');

// 2nd row - right col
$form->addHtml('<div class="col-md-6">');
$form->addRadio('support-rating', 'Excellent', 'Excellent');
$form->addRadio('support-rating', 'Good', 'Good', 'checked=checked');
$form->addRadio('support-rating', 'Fair', 'Fair');
$form->addRadio('support-rating', 'Poor', 'Poor');
$form->addRadio('support-rating', 'Terrible', 'Terrible');
$form->printRadioGroup('support-rating', 'How would you rate our support ?', false, 'required');
$form->addHtml('</div>');
$form->addHtml('</div>');

$form->setCols(2, 10);
$form->addTextarea('comment', '', 'Do you have other comments for us ?');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success');

$form->endFieldset();
$form->addHtml('<p class="pull-right"><strong class="text-danger">*</strong> Required fields</p>');

// iCheck plugin
$form->addPlugin('icheck', 'input', 'default', array('%theme%' => 'square', '%color%' => 'red'));

// jQuery validation
$form->addPlugin('formvalidation', '#customer-feedback-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Customer Feedback Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Customer Feedback Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/customer-feedback-form.php" />
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
    <h1 class="text-center">Php Form Builder - Customer Feedback Form</h1>
    <div class="container">
        <?php
        if (isset($sent_message)) {
            echo $sent_message;
        }
        $form->render();
        ?>
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
