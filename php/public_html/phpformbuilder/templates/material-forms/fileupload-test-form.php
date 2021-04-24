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
Delete all uploaded files on load to keep my server clean
(Remove this if you don't want to delete uploaded files)
============================================= */

function cleanDir($dir)
{
    $files = glob($dir); // get all file names present in folder
    foreach ($files as $file) { // iterate files
        if (is_file($file) && basename($file) != 'art-creative-metal-creativity.jpg') {
            if (time() - filectime($file) > 3600) { // if file is 1 hour (3600 seconds) old then delete it
                unlink($file); // delete the file
            }
        }
    }
}

cleanDir(ROOT . '/file-uploads/images/thumbs/lg/*');
cleanDir(ROOT . '/file-uploads/images/thumbs/md/*');
cleanDir(ROOT . '/file-uploads/images/thumbs/sm/*');
cleanDir(ROOT . '/file-uploads/images/*');
cleanDir(ROOT . '/file-uploads/*');

// copy the demo image in file-uploads if it's been deleted by some user
if ($_SERVER['SERVER_NAME'] == 'www.phpformbuilder.pro') {
    if (!file_exists(ROOT . '/file-uploads/images/art-creative-metal-creativity.jpg')) {
        copy(ROOT . '/assets/images/art-creative-metal-creativity.jpg', ROOT . '/file-uploads/images/art-creative-metal-creativity.jpg');
    }
}

$form = new Form('fileupload-test-form', 'horizontal', 'novalidate', 'material');
// $form->setMode('development');

/* ==================================================
    Single file upload
================================================== */

$fileUpload_config = array(
    'upload_dir'    => '../../../../../file-uploads/', // the directory to upload the files. relative to phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php
    'limit'         => 1, // max. number of files
    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
    'debug'         => true // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);

$form->startFieldset('Single file upload');
$form->addHelper('Accepted File Types : .pdf, .doc[x], .xls[x], .txt', 'single-file', 'after');
$form->addFileUpload('file', 'single-file', '', 'Attach a file', '', $fileUpload_config);
$form->endFieldset();

/* ==================================================
    Multiple files upload
================================================== */

$fileUpload_config = array(
    'upload_dir'    => '../../../../../file-uploads/', // the directory to upload the files. relative to phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php
    'limit'         => 3, // max. number of files
    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
    'debug'         => true // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);

$form->startFieldset('Multiple files upload');
$form->addHelper('3 files maximum. Accepted File Types : .pdf, .doc[x], .xls[x], .txt', 'multiple-files', 'after');
$form->addFileUpload('file', 'multiple-files', '', 'Upload your documents', '', $fileUpload_config);
$form->endFieldset();

/* ==================================================
    Images upload
================================================== */

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

$form->startFieldset('Multiple images upload with resizing, thumbnails and image editor (crop/rotate)');
$form->addHtml('<p>The uploader resizes the uploaded image (960px * 720px), then generates large, medium &amp; small thumbnails for each uploaded image.</p>');
$form->addHelper('3 files max. Accepted File Types : .jp[e]g, .png, .gif<br>Click on the uploaded preview image to crop/rotate.', 'uploaded-images');
$form->addFileUpload('file', 'uploaded-images', '', 'Upload up to 3 images', '', $fileUpload_config);
$form->endFieldset();

/* ==================================================
    Prefilled upload with existing image
================================================== */

$current_file = ''; // default empty

$current_file_path = ROOT . '/file-uploads/images/';
$current_file_name = 'art-creative-metal-creativity.jpg';

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
}
$fileUpload_config = array(
    'xml'           => 'image-upload', // the thumbs directories must exist
    'uploader'      => 'ajax_upload_file.php', // the uploader file in phpformbuilder/plugins/fileuploader/[xml]/php
    'upload_dir'    => '../../../../../file-uploads/images/', // the directory to upload the files. relative to [plugins dir]/fileuploader/image-upload/php/ajax_upload_file.php
    'limit'         => 1, // max. number of files
    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
    'extensions'    => ['jpg', 'jpeg', 'png'],
    'thumbnails'    => true,
    'editor'        => true,
    'width'         => 960,
    'height'        => 720,
    'crop'          => false,
    'debug'         => true
);

$form->startFieldset('Prefilled upload with existing image');
$form->addHelper('Accepted File Types : Accepted File Types : .jp[e]g, .png, .gif', 'prefilled-uploader', 'after');
$form->addFileUpload('file', 'prefilled-uploader', '', 'Your image', '', $fileUpload_config, $current_file);
$form->endFieldset();

/*=====================================
=            Drag and drop            =
=====================================*/

$fileUpload_config = array(
    'xml'           => 'drag-and-drop',
    'upload_dir'    => '../../../../../file-uploads/', // the directory to upload the files. relative to phpformbuilder/plugins/fileuploader/default/php/ajax_upload_file.php
    'limit'         => 2, // max. number of files
    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
    'debug'         => true // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);

$form->startFieldset('Drag and drop');
$form->addHelper('Accepted File Types : .pdf, .doc[x], .xls[x], .txt', 'drag-and-drop', 'after');
$form->addFileUpload('file', 'drag-and-drop', '', 'Drag and drop', '', $fileUpload_config);
$form->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design File Upload Form - How to create PHP forms easily</title>
    <meta name="description" content="Material Design Form Generator - how to create a File Upload with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/material-forms/fileupload-test-form.php" />

    <!-- Materialize CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Material icons CSS -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style type="text/css">
        form fieldset {
            background: #fafafa;
            padding: 0 20px;
            margin-bottom: 60px;
        }
        fieldset legend {
            padding: 10px 20px;
            margin: 0 -20px 20px;
            width: calc(100% + 40px);
            color: #fff;
            background: #3E5DC2;
        }
    </style>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="center-align">Php Form Builder - Material Design File Upload Form<br><small>Upload documents or images</small></h1>
    <div class="container">
        <?php
            // information for users - remove this in your forms
            include_once '../assets/material-forms-notice.php';
        ?>

        <div class="row">
            <div class="col m11 l10">
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
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
