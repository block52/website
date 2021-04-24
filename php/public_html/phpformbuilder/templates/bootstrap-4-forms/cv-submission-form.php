<?php
use fileuploader\server\FileUploader;
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

define('ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR));

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once ROOT . '/phpformbuilder/Form.php';

// include the fileuploader
include_once ROOT . '/phpformbuilder/plugins/fileuploader/server/class.fileuploader.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('cv-submission-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('cv-submission-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['cv-submission-form'] = $validator->getAllErrors();
    } else {
        /* Send email with attached file(s) */

        $path = ROOT . '/file-uploads/';
        $attachments = array();
        if (isset($_POST['cv']) && !empty($_POST['cv'])) {
            $cv = FileUploader::getPostedFiles($_POST['cv']);
            foreach ($cv as $f) {
                $attachments[] = $path . $f['file'];
            }
            $attachments = implode(', ', $attachments);
        }

        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - CV Submission Form',
            'attachments'    =>  $attachments,
            'filter_values'   => 'cv-submission-form, cv'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('cv-submission-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('cv-submission-form', 'horizontal', 'data-fv-no-icon=true, novalidate');
$form->setMode('development');
$form->setCols(3, 9);
$form->startFieldset('CV Submission');
$form->addHtml('<h3>Do you want to work with us? <small>Please fill in your details below</small>.</h3><p>&nbsp;</p>');
$form->addIcon('user-name', '<i class="fa fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-name', '', 'Name', 'required');
$form->addIcon('user-first-name', '<i class="fa fa-user" aria-hidden="true"></i>', 'before');
$form->addInput('text', 'user-first-name', '', 'Firstname', 'required');
$form->addIcon('user-email', '<i class="fa fa-envelope" aria-hidden="true"></i>', 'before');
$form->addInput('email', 'user-email', '', 'Email', 'required');
$form->addInput('text', 'position-applying-for', '', 'Position Applying For');
$form->addPlugin('tinymce', '#additional-information', 'contact-config');
$form->addTextarea('additional-information', '', 'Additional Information');

$form->addHelper('Your CV is required. 3 files max. Accepted File Types : .pdf, .doc[x], .xls[x], .txt', 'cv');

// reload the previously posted file if the form was posted with errors
$current_file = '';
if (isset($_POST['cv']) && !empty($_POST['cv']) && isset($_SESSION['errors']['cv-submission-form']) && !empty($_SESSION['errors']['cv-submission-form'])) {
    $posted_file = FileUploader::getPostedFiles($_POST['cv']);
    $current_file_path = ROOT . '/file-uploads/';
    $current_file_name = $posted_file[0]['file'];
    if (file_exists($current_file_path . $current_file_name)) {
        $current_file_size = filesize($current_file_path . $current_file_name);
        $current_file_type = mime_content_type($current_file_path . $current_file_name);
        $current_file = array(
            'name' => $current_file_name,
            'size' => $current_file_size,
            'type' => $current_file_type,
            'file' => '/file-uploads/' . $current_file_name, // url of the file
            'data' => array(
                'listProps' => array(
                'file' => $current_file_name
                )
            )
        );
    }
}

$fileUpload_config = array(
    'upload_dir'    => '../../../../../file-uploads/', // the directory to upload the files. relative to phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php
    'limit'         => 3, // max. number of files
    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'jpg'],
    'debug'         => true // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);
$form->addFileUpload('file', 'cv', '', 'Upload your CV &amp; Other Testmonials (e.g Certificates)', 'required', $fileUpload_config, $current_file);

$form->addBtn('submit', 'submit-btn', 1, 'Submit CV', 'class=btn btn-success ladda-button, data-style=zoom-in');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#cv-submission-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4 CV Submission Form - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap 4 Form Generator - how to create a CV Submission Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-4-forms/cv-submission-form.php" />

    <!-- Bootstrap 4 CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font awesome icons -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - CV Submission Form<br><small>with File upload and Rich Text Editor</small></h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
