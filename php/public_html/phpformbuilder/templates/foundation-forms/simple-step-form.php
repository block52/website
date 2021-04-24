<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

$current_step = 1; // default if nothing posted
if (isset($_POST['back-btn'])) {
    $current_step = $_POST['back-btn'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form-step-1']) && Form::testToken('form-step-1') === true) {
        /* Validate step 1 */

        // create validator & auto-validate required fields
        $validator = Form::validate('form-step-1');

        // additional validation
        $validator->notStartsWith('robot', '<div class="callout warning">Sorry, I don\' really like robots ...</div>')->validate('human-or-robot');
        if ($validator->hasErrors()) {
            $current_step = 1;
            $_SESSION['errors']['form-step-1'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('form-step-1');
            $current_step = 2;
        }
    } elseif (isset($_POST['form-step-2']) && Form::testToken('form-step-2') === true) {
        /* Validate step 2 */

        // create validator & auto-validate required fields
        $validator = Form::validate('form-step-2');
        if ($validator->hasErrors()) {
            $current_step = 2;
            $_SESSION['errors']['form-step-2'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('form-step-2');
            $current_step = 3;
        }
    } elseif (isset($_POST['form-step-3']) && Form::testToken('form-step-3') === true) {
        /* Validate step 3 */

        // create validator & auto-validate required fields
        $validator = Form::validate('form-step-3');

        // additional validation
        $validator->email()->validate('user-email');
        if ($validator->hasErrors()) {
            $current_step = 3;
            $_SESSION['errors']['form-step-3'] = $validator->getAllErrors();
        } elseif ($_POST['are-informations-correct'] < 1) { // back to step 1 with user message (wrong informations)
            $current_step = 1;
            $user_message = '<div class="callout warning"><strong>Wrong informations ! </strong> Please try again ...</div>' . "\n";
        } else { // send email & go back to step 1 with user message (email sended)
            Form::registerValues('form-step-3');
            $user_values = Form::mergeValues(array('form-step-1', 'form-step-2', 'form-step-3'));

            /* translate boolean values to text */

            $find                                    = array('/0/', '/1/');
            $replace                                 = array('No', 'Yes');
            $user_values['human-or-robot']           = preg_replace($find, $replace, $user_values['human-or-robot']);
            $user_values['are-informations-correct'] = preg_replace($find, $replace, $user_values['are-informations-correct']);

            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => addslashes($_POST['user-email']),
                'subject'         => 'contact from Php Form Builder',
                'values'          => $user_values,
                'filter_values'   => 'form-step-1, form-step-2, form-step-3',
                'sent_message'    => '<div class="success callout"><p>Your message has been successfully sent !</p></div>'
            );
            $user_message = Form::sendMail($email_config);
            $current_step = 1;
        }
    }
}
if ($current_step == 1) {
    /* ==================================================
        Step 1
    ================================================== */

    $form_id = 'form-step-1';
    $form = new Form('form-step-1', 'horizontal', 'novalidate', 'foundation');
    // $form->setMode('development');
    $form->addRadio('human-or-robot', 'I\'m a real human', 'real human');
    $form->addRadio('human-or-robot', 'I\'m a robot', 'robot');
    $form->printRadioGroup('human-or-robot', 'Are you a human or a robot ?', false, 'required');
    $form->addBtn('submit', 'submit-btn', 1, 'Next <i class="fi fi-arrow-right append"></i>', 'class=button success');
} elseif ($current_step == 2) {
    /* ==================================================
        Step 2
    ================================================== */

    $form_id = 'form-step-2';
    $form = new Form('form-step-2', 'horizontal', 'novalidate', 'foundation');
    // $form->setMode('development');
    $form->addOption('how-did-you-come-here', 'By foot', 'By foot');
    $form->addOption('how-did-you-come-here', 'By plane', 'By plane');
    $form->addOption('how-did-you-come-here', 'By car', 'By car');
    $form->addOption('how-did-you-come-here', 'By boat', 'By boat');
    $form->addOption('how-did-you-come-here', 'By bike', 'By bike');
    $form->addSelect('how-did-you-come-here', 'How did you come here ?', 'class=select2, required');
    $form->addBtn('submit', 'back-btn', 1, '<span class="fi fi-arrow-left prepend"></span> Back', 'class=button warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 2, 'Next <i class="fi fi-arrow-right append"></i>', 'class=button success', 'btns');
    $form->printBtnGroup('btns');
} elseif ($current_step == 3) {
    /* ==================================================
        Step 3
    ================================================== */

    $form_id = 'form-step-3';
    $form = new Form('form-step-3', 'horizontal', 'novalidate', 'foundation');
    // $form->setMode('development');
    $form->addHtml('<p class="lead"><strong>You are human, you came here ' . strtolower($_SESSION['form-step-2']['how-did-you-come-here']) . '.</strong></p>');
    $form->addRadio('are-informations-correct', 'Yes, Excellent', 1);
    $form->addRadio('are-informations-correct', 'Absolutely not', 0);
    $form->printRadioGroup('are-informations-correct', 'Are these informations correct ?', false, 'required');
    $form->addHelper('Enter your real e-mail if you want to receive results', 'user-email');
    $form->addInput('email', 'user-email', '', 'E-mail', 'required');
    $form->addBtn('submit', 'back-btn', 2, '<span class="fi fi-arrow-left prepend"></span> Back', 'class=button warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 3, 'Submit <i class="fi fi-arrow-right append"></i>', 'class=button success', 'btns');
    $form->printBtnGroup('btns');
}
$form->addPlugin('icheck', 'input', 'default', array('%theme%' => 'square', '%color%' => 'green'));

// jQuery validation
$form->addPlugin('formvalidation', '#' . $form_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Simple Step Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a simple Step Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/simple-step-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">

    <!-- foundation icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Simple Step Form<br><small>follow steps to complete</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
            <?php
            if (isset($user_message)) {
                echo $user_message;
            }
            ?>
            <legend>Simple Step Form</legend>
            <?php
            $form->render();
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>
    <?php
        $form->printIncludes('js');
        $form->printJsCode();
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            // destroy the validator if we click a back button
            $('button[name="back-btn"]').on('click', function() {
                var form = forms['<?php echo $form_id; ?>'];
                form.fv.destroy();
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
