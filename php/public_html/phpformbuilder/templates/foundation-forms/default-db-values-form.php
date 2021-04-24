<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;

ini_set('display_errors', 1);
/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('user-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('user-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['user-form'] = $validator->getAllErrors();
    } else {
/*      (disabled in demo - no database enabled)
        require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/db-connect.php';
        require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/Mysql.php';

        $db = new Mysql();
        $filter['user_id']         = Mysql::sqlValue($_POST['user_id'], Mysql::SQLVALUE_NUMBER);
        $update['civility']        = Mysql::SQLValue($_POST['civility']);
        $update['user-name']       = Mysql::SQLValue($_POST['user-name']);
        $update['user-first-name'] = Mysql::SQLValue($_POST['user-first-name']);
        $update['user-email']      = Mysql::SQLValue($_POST['user-email']);
        $skills                     = json_encode($_POST['skills']);
        $update['skills']          = Mysql::SQLValue($skills);
        $update['validated']       = Mysql::SQLValue(0); // default value if un-checked
        if(isset()) {
            $update['validated'] = Mysql::SQLValue(1);
        }

        if (!$db->UpdateRows('users', $update, $filter)) {
            $msg = '<p class="alert alert-danger">' . $db->error() . '<br>' . $db->getLastSql() . '</p>' . "\n";
        } else {
*/
            $msg = '<p class="callout success">Database updated successfully !</p>'. " \n";

            // disabled in demo - no database enabled
            // $db->UpdateRows('users', $update, $filter);
            // $msg = '<p class="alert alert-success">Database updated successfully !<br>Last query : <strong>' . $db->getLastSql() . '</strong></p>'. " \n";
/*
       }
*/
    }
}

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (!isset($_SESSION['errors']['user-form']) || empty($_SESSION['errors']['user-form'])) { // If no error posted
    /* Retrieve values from db (disabled in demo - no database enabled)

    $db = new Mysql();
    $columns = $db->getColumnNames("users");
    $qry = "SELECT * FROM users WHERE user_id='$user_id'";
    $db->query($qry);
    $row = $db->Row();
    foreach ($columns as $columnName) {
        if($columnName == 'skills') {
            $_SESSION['user-form'][$columnName] = json_decode($row->$columnName);
        } else {
            $_SESSION['user-form'][$columnName] = $row->$columnName;
        }
    }

    */

    // values for demo
    $user_id = 1;
    $_SESSION['user-form']['civility']        = 'Ms.';
    $_SESSION['user-form']['user-name']       = 'Wilson';
    $_SESSION['user-form']['user-first-name'] = 'Susan';
    $_SESSION['user-form']['user-email']      = 'swilsone@squarespace.com';
    $_SESSION['user-form']['validated']       = 1;
    $_SESSION['user-form']['skills']          = array('HTML5', 'Bootstrap', 'PHP');
}

$form = new Form('user-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');
$form->startFieldset('Update User');
$form->addInput('hidden', 'user_id', $user_id);
$form->addRadio('civility', 'M.', 'M.');
$form->addRadio('civility', 'Mrs.', 'Mrs.');
$form->addRadio('civility', 'Ms.', 'Ms.');
$form->printRadioGroup('civility', 'Civility : ');
$form->addInput('text', 'user-name', '', 'Name', 'size=60, required');
$form->addInput('text', 'user-first-name', '', 'First Name', 'size=60, required');
$form->addInput('email', 'user-email', '', 'user-email : ', 'size=60, required');
$form->addCheckbox('validated', '', 1, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=orange, checked');
$form->printCheckboxGroup('validated', 'Validated');
$form->addOption('skills[]', 'HTML5', 'HTML5');
$form->addOption('skills[]', 'CSS3', 'CSS3');
$form->addOption('skills[]', 'Javascript', 'Javascript');
$form->addOption('skills[]', 'jQuery', 'jQuery');
$form->addOption('skills[]', 'Bootstrap', 'Bootstrap');
$form->addOption('skills[]', 'PHP', 'PHP');
$form->addOption('skills[]', 'Mysql', 'Mysql');
$form->addHelper('(multiple choices)', 'skills[]');
$form->addSelect('skills[]', 'Skills', 'class=select2, multiple, required');
$form->addBtn('button', 'cancel', 0, '<span class="fi fi-x prepend"></span>Cancel', 'class=button warning, data-dismiss=modal', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit <span class="fi fi-check append"></span>', 'class=success button', 'btn-group');
$form->printBtnGroup('btn-group');
$form->endFieldset();

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'red']);

// jQuery validation
$form->addPlugin('formvalidation', '#user-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Form - Retrieve form values from database</title>
    <meta name="description" content="Foundation Form Generator - how to retrieve default fields values from database with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/default-db-values-form.php" />

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
    <h1 class="text-center">Php Form Builder - Form using Database values<br><small>Retrieve default field values from database</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
            <?php
            if (isset($msg)) {
                echo $msg;
            }
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
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
