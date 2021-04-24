<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;

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
            $msg = '<p class="alert alert-success">Database updated successfully !</p>'. " \n";

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
    $_SESSION['user-form']['skills']          = array('HTML5', 'Bootstrap 4', 'PHP');
}

$form = new Form('user-form', 'horizontal', 'novalidate', 'material');
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
$form->addOption('skills[]', 'Bootstrap 4', 'Bootstrap 4');
$form->addOption('skills[]', 'PHP', 'PHP');
$form->addOption('skills[]', 'Mysql', 'Mysql');
$form->addSelect('skills[]', 'Skills', 'multiple, required');
$form->addBtn('button', 'cancel', 0, '<i class="material-icons right">cancel</i>Cancel', 'class=btn orange darken-1 waves-effect waves-light, data-dismiss=modal', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Submit <i class="material-icons right">check</i>', 'class=btn waves-effect waves-light ladda-button, data-style=zoom-in', 'btn-group');
$form->printBtnGroup('btn-group');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#user-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Form - Retrieve form values from database</title>
    <meta name="description" content="Material Design Form Generator - how to retrieve default fields values from database with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/default-db-values-form.php" />

    <!-- Materialize CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Material icons CSS -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Material Design Form using Database values<br><small>Retrieve default field values from database</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m11 l10">
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

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?php
        $form->printIncludes('js');
        $form->printJsCode();
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
           $('select').formSelect();
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
