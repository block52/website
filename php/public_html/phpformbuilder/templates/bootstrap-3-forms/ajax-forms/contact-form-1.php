<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

$form_id = 'ajax-contact-form-1';

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
            'filter_values'   => 'contact-form-1'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear($form_id);
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form($form_id, 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');

// enable Ajax loading
$form->setOptions(['ajax' => true]);

$form->startFieldset('Please fill in this form to contact us');
$form->addHtml('<p class="text-warning">All fields are required</p>');
$form->groupInputs('user-name', 'user-first-name');
$form->setCols(0, 6);
$form->addIcon('user-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form->addInput('text', 'user-name', '', '', 'placeholder=Name, required');
$form->addIcon('user-first-name', '<span class="glyphicon glyphicon-user"></span>', 'before');
$form->addInput('text', 'user-first-name', '', '', 'placeholder=First Name, required');
$form->setCols(0, 12);
$form->addIcon('user-email', '<span class="glyphicon glyphicon-envelope"></span>', 'before');
$form->addInput('email', 'user-email', '', '', 'placeholder=Email, required');
$form->addIcon('user-phone', '<span class="glyphicon glyphicon-earphone"></span>', 'before');
$form->addInput('tel', 'user-phone', '', '', 'data-intphone=true, data-fv-intphonenumber=true, required');
$form->addTextarea('message', '', '', 'cols=30, rows=4, placeholder=Message, required');
$form->setCols(6, 6);
$form->addCheckbox('newsletter', '', '1', 'class=lcswitch, data-ontext=Yes, data-offtext=No, checked');
$form->printCheckboxGroup('newsletter', 'Suscribe to Newsletter');
$form->addHtml('<p>&nbsp;</p>');
$form->setCols(0, 12);
$form->addRecaptchaV2('6Ldg0QkUAAAAABmXaV1b9qdOnyIwVPRRAs4ldoxe', 'recaptcha', true);
$form->centerButtons(true);
$form->addBtn('reset', 'reset-btn', 1, 'Reset <span class="glyphicon glyphicon-erase append"></span>', 'class=btn btn-warning', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <span class="glyphicon glyphicon-envelope append"></span>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'my-btn-group');
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
