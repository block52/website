<?php
use fileuploader\server\FileUploader;
use phpformbuilder\database\Mysql;
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('customer-support-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('customer-support-form');

    // additional validation
    $validator->email()->validate('user-email');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['customer-support-form'] = $validator->getAllErrors();
    } else {
        /* Send email with attached file(s) */

        $path = ROOT . '/file-uploads/';
        $attachments = '';
        if (isset($_POST['attachment']) && !empty($_POST['attachment'])) {
            $posted_file = FileUploader::getPostedFiles($_POST['attachment']);
            $attachments = $path . $posted_file[0]['file'];
        }
        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'Php Form Builder - Customer Support Form',
            'attachments'     =>  $attachments,
            'filter_values'   => 'customer-support-form, attachment'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('customer-support-form');
    }
}


/* =============================================
    Select the products categories
============================================= */

require_once ROOT . '/phpformbuilder/database/db-connect.php';
require_once ROOT . '/phpformbuilder/database/Mysql.php';

$categories = array();

$qry = 'SELECT
    productlines.productLine
FROM
    productlines
ORDER BY
    productlines.productLine DESC';
$db = new Mysql();
$db->query($qry);
$db_count = $db->rowCount();
if (!empty($db_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $categories[] = $row->productLine;
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('customer-support-form', 'horizontal', 'novalidate', 'foundation');
// $form->setMode('development');
$form->startFieldset('Please fill the form below');
$form->setCols(4, 4);
$form->groupInputs('first-name', 'last-name');
$form->addHelper('First name', 'first-name');
$form->addInput('text', 'first-name', '', 'Full Name: ', 'required');
$form->setCols(0, 4);
$form->addHelper('Last name', 'last-name');
$form->addInput('text', 'last-name', '', '', 'required');
$form->setCols(4, 8);
$form->addInput('email', 'user-email', '', 'E-Mail: ', 'required');
$form->groupInputs('department', 'urgency');
$form->setCols(4, 3);
$form->addRadio('department', 'Technical', 'Technical');
$form->addRadio('department', 'Sales', 'Sales');
$form->addRadio('department', 'Billing', 'Billing');
$form->addRadio('department', 'Feedback', 'Feedback');
$form->printRadiogroup('department', 'Department', 'required');
$form->setCols(2, 3);
$form->addRadio('urgency', 'Low', 'Low');
$form->addRadio('urgency', 'Medium', 'Medium');
$form->addRadio('urgency', 'High', 'High');
$form->printRadiogroup('urgency', 'Urgency', 'required');
$form->setCols(4, 8);

// empty option for select2 plkaceholder
$form->addOption('category', '', '');

for ($i=0; $i < $db_count; $i++) {
    $form->addOption('category', $categories[$i], $categories[$i]);
}
$form->addSelect('category', 'Category', 'class=select2, data-placeholder=Choose a category, data-minimum-results-for-search=Infinity, required');
$form->addSelect('product', 'Product', 'class=select2, data-placeholder=Choose a category first, disabled, required');
$form->addTextarea('message', '', 'Please describe your problem', 'cols=20, rows=8, required');
$form->addHelper('Accepted File Types : .pdf, .doc[x], .xls[x], .txt', 'attachment', 'after');

// reload the previously posted file if the form was posted with errors
$current_file = '';
if (isset($_POST['attachment']) && !empty($_POST['attachment'])) {
    $posted_file = FileUploader::getPostedFiles($_POST['attachment']);
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
    'limit'         => 1, // max. number of files
    'file_max_size' => 5, // each file's maximal size in MB {null, Number}
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
    'debug'         => true // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
);
$form->addFileUpload('file', 'attachment', '', 'Attach a file', '', $fileUpload_config, $current_file);
$form->setCols(0, 12);
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=success button ladda-button, data-style=zoom-in');
$form->endFieldset();

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'purple']);

// jQuery validation
$form->addPlugin('formvalidation', '#customer-support-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Foundation Customer Support Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a Customer Support Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/customer-support-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Foundation Customer Support</h1>
    <div class="container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
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
    <?php
        $form->printIncludes('js');
        $form->printJsCode();
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var $selectTarget = $('select[name="product"]');
            $('select[name="category"]').on('change', function(e) {
                $.ajax({
                    url: 'customer-support-form/ajax-products.php',
                    type: 'POST',
                    data: {
                        'category': $(e.target).val()
                    }
                }).done(function(data) {
                    var options = $(data).html();
                    $selectTarget.html(options);

                    // enable select & update select2 options
                    $selectTarget.attr('disabled', false).trigger('change');
                }).fail(function(data, statut, error) {
                    console.log(error);
                });
            });
            if($('select[name="category"]').val() != '') {
                $('select[name="category"]').trigger('change');
            }
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
