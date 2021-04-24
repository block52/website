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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('employment-application-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('employment-application-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['employment-application-form'] = $validator->getAllErrors();
    } else {
        /* Send email with attached file(s) */

        $path = ROOT . '/file-uploads/images/thumbs/md/';
        $attachments = array();
        if (isset($_POST['uploaded-images']) && !empty($_POST['uploaded-images'])) {
            $images = FileUploader::getPostedFiles($_POST['uploaded-images']);
            foreach ($images as $f) {
                $attachments[] = $path . $f['file'];
            }
            $attachments = implode(', ', $attachments);
        }
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Employment Application Form',
            'attachments'     => $attachments,
            'filter_values'   => 'employment-application-form, uploaded-images',
            'sent_message'    => '<p class="card-panel teal accent-2">Your message has been successfully sent !</p>'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('employment-application-form');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('employment-application-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');
$form->startFieldset('Employment Application Form');
$form->addHtml('<p class="lead">Please fill-in this form to get in touch with us</p>');
$form->addOption('position-applying-for', '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('position-applying-for', 'Interface Designer', 'Interface Designer');
$form->addOption('position-applying-for', 'Software Engineer', 'Software Engineer');
$form->addOption('position-applying-for', 'System Administrator', 'System Administrator');
$form->addOption('position-applying-for', 'Office Manager', 'Office Manager');
$form->addSelect('position-applying-for', 'Which position are you applying for ?', 'required');
$form->addRadio('relocate', 'Yes', 'Yes');
$form->addRadio('relocate', 'No', 'No');
$form->printRadioGroup('relocate', 'Are you willing to relocate ?', true, 'required');
$form->addPlugin('pickadate', '#start-date');
$form->addInput('text', 'start-date', '', 'When can you start ?', 'required');
$form->addIcon('salary-requirements', '<i class="material-icons" aria-hidden="true">monetization_on</i>', 'before');
$form->addInput('text', 'salary-requirements', '', 'Salary Requirements', 'data-fv-integer');
$form->endFieldset();
$form->addHtml('<p>&nbsp;</p>');

// Portfolio
$form->startFieldset('Your Portfolio');

$form->addHelper('3 files max. Accepted File Types : .jp[e]g, .png, .gif<br>The uploader will generate large, medium &amp; small thumbnails for each uploaded image.<br>Click on the uploaded preview image to crop/rotate.', 'uploaded-images');

// reload the previously posted file if the form was posted with errors
$current_images = array();
if (isset($_POST['uploaded-images']) && !empty($_POST['uploaded-images'])) {
    $posted_images = FileUploader::getPostedFiles($_POST['uploaded-images']);
    foreach ($posted_images as $f) {
        $current_file_path = ROOT . '/file-uploads/images/';
        $current_file_name = $f['file'];
        if (file_exists($current_file_path . $current_file_name)) {
            $current_file_size = filesize($current_file_path . $current_file_name);
            $current_file_type = mime_content_type($current_file_path . $current_file_name);
            $current_file = array(
                'name' => $current_file_name,
                'size' => $current_file_size,
                'type' => $current_file_type,
                'file' => '/file-uploads/images/' . $current_file_name, // url of the file
                'data' => array(
                    'listProps' => array(
                    'file' => $current_file_name
                    )
                )
            );
            $current_images[] = $current_file;
        }
    }
}

$fileUpload_config = array(
    'xml'           => 'image-upload',                          // the uploader's config in phpformbuilder/plugins-config/fileuploader.xml
    'uploader'      => 'ajax_upload_file.php',              // the uploader file in phpformbuilder/plugins/fileuploader/[xml]/php
    'upload_dir'    => '../../../../../file-uploads/images/',   // the directory to upload the files. relative to [plugins dir]/fileuploader/image-upload/php/ajax_upload_file.php
    'limit'         => 3,                                       // max. number of files
    'file_max_size' => 2,                                       // each file's maximal size in MB {null, Number}
    'extensions'    => ['jpg', 'jpeg', 'png', 'gif'],           // allowed extensions
    'thumbnails'    => true,                                    // the thumbs directories must exist. thumbs config. is done in phpformbuilder/plugins/fileuploader/image-upload/php/ajax_upload_file.php
    'editor'        => true,                                    // allows the user to crop/rotate the uploaded image
    'width'         => 960,                                     // the uploaded image maximum width
    'height'        => 720,                                     // the uploaded image maximum height
    'crop'          => false,
    'debug'         => true                                     // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);
$form->addFileUpload('file', 'uploaded-images', '', 'Upload up to 3 images', '', $fileUpload_config, $current_images);

$form->addInput('text', 'portfolio-web-site', '', 'Portfolio Web Site', 'placeholder=http://, data-fv-uri, required');
$form->endFieldset();
$form->addHtml('<p>&nbsp;</p>');

// Contact Information
$form->startFieldset('Your Contact Information');
$form->setCols(3, 4);
$form->groupInputs('user-first-name', 'user-last-name');
$form->addHelper('First Name', 'user-first-name');
$form->addInput('text', 'user-first-name', '', 'Your Name', 'required');
$form->setCols(0, 5);
$form->addHelper('Last Name', 'user-last-name');
$form->addInput('text', 'user-last-name', '', '', 'required');
$form->setCols(3, 9);
$form->addInput('email', 'user-email', '', 'Your E-mail', '');
$form->addBtn('submit', 'submit-btn', 1, 'Send', 'class=btn btn-primary');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#employment-application-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Employment Application Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create an Employment Application Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/employment-application-form.php" />

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
    <h1 class="center-align">Php Form Builder - Material Design Employment Application Form<br><small>with File uploader &amp; date picker</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m10 offset-m1">
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

    <!-- Materialize JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <?php
            $form->printIncludes('js');
            $form->printJsCode();
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
               $('#employment-application-form select').formSelect();
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
