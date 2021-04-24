<?php

use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

$form_id = 'ajax-contact-form-1';

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken($form_id) === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate($form_id);

    // additional validation
    $validator->maxLength(100)->validate('message');
    $validator->email()->validate('user-email');

    // recaptcha validation
    $validator->recaptcha('6Ldg0QkUAAAAALUTA_uzlAEJP4fvm2SWtcGZ33Gc', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors'][$form_id] = $validator->getAllErrors();
    } else {
        $_POST['message'] = nl2br($_POST['message']);
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Contact from Php Form Builder',
            'filter_values'   => $form_id
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear($form_id);
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form($form_id, 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#' . $form_id);


// enable Ajax loading
$form->setOptions(['ajax' => true]);

$form->startFieldset('Please fill in this form to contact us');
$form->addHtml('<p class="text-warning">All fields are required</p>');
$form->groupInputs('user-name', 'user-first-name');
$form->setCols(0, 6, 'sm');
$form->addIcon('user-name', '<i class="fa fa-lg fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Name, required');
$form->addIcon('user-first-name', '<i class="fa fa-lg fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-first-name', '', '', 'placeholder=First Name, required');
$form->setCols(0, 12, 'xs');
$form->addIcon('user-email', '<i class="fa fa-lg fa-envelope" aria-hidden="true"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Email, required');
$form->addIcon('user-phone', '<i class="fa fa-lg fa-phone" aria-hidden="true"></i>', 'before');
$form->addInput('tel', 'user-phone', '', '', 'data-intphone=true, data-fv-intphonenumber=true, required');
$form->addTextarea('message', '', '', 'cols=30, rows=4, placeholder=Message, required');
$form->setCols(6, 6, 'xs');
$form->addCheckbox('newsletter', '', '1', 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=yellow, checked');
$form->printCheckboxGroup('newsletter', 'Suscribe to Newsletter');
$form->setCols(0, 12, 'xs');
$form->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha', true);
$form->centerButtons(true);
$form->addBtn('reset', 'reset-btn', 1, 'Reset <i class="fa fa-ban" aria-hidden="true"></i>', 'class=btn btn-warning', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <i class="fa fa-envelope ml-2" aria-hidden="true"></i>', 'class=btn btn-success, data-style=zoom-in', 'my-btn-group');
$form->printBtnGroup('my-btn-group');
$form->endFieldset();

// word-character-count plugin
$form->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));

// jQuery validation
$form->addPlugin('formvalidation', '#' . $form_id);

if (isset($sent_message)) {
    echo $sent_message;
}
$form->render();
