<?php
use phpformbuilder\Form;

include_once '../../../phpformbuilder/Form.php';
include_once 'render.php';

$output = array(
    'title'       => array(),
    'form_code'   => array(),
    'form'        => array(),
    'html_code'   => array()
);

$form_id = 'plugins-file-upload-form-1';

$form = new Form($form_id, 'horizontal');


$fileUpload_config = array(
    'upload_dir'    => '../../../../../file-uploads/',
    'limit'         => 1,
    'file_max_size' => 2,
    'extensions'    => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
    'debug'         => true
);
$form->addHelper('Allowed files: .pdf, .doc[x], .xls[x], .txt', 'single-file');
$form->addFileUpload('file', 'single-file', '', 'Attach a file', '', $fileUpload_config);


$output['title'][]     = 'Upload a single document';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$fileUpload_config = array(
    \'upload_dir\'    => \'../../../../../file-uploads/\',
    \'limit\'         => 1,
    \'file_max_size\' => 2,
    \'extensions\'    => [\'pdf\', \'doc\', \'docx\', \'xls\', \'xlsx\', \'txt\'],
    \'debug\'         => true
);
$form->addHelper(\'Allowed files: .pdf, .doc[x], .xls[x], .txt\', \'single-file\');
$form->addFileUpload(\'file\', \'single-file\', \'\', \'Attach a file\', \'\', $fileUpload_config);');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-file-upload-form-2';

$form = new Form($form_id, 'horizontal');


$fileUpload_config = array(
    'xml'           => 'image-upload',
    'uploader'      => 'ajax_upload_file.php',
    'upload_dir'    => '../../../../../file-uploads/images/',
    'limit'         => 3,
    'file_max_size' => 2,
    'extensions'    => ['jpg', 'jpeg', 'png', 'gif'],
    'thumbnails'    => true,
    'editor'        => true,
    'width'         => 960,
    'height'        => 720,
    'crop'          => false
);
$form->addFileUpload('file', 'uploaded-images', '', 'Upload up to 3 images', '', $fileUpload_config);


$output['title'][]     = 'Image upload multiple with resizing, thumbnails & editor';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$fileUpload_config = array(
    \'xml\'           => \'image-upload\',
    \'uploader\'      => \'ajax_upload_file.php\',
    \'upload_dir\'    => \'../../../../../file-uploads/images/\',
    \'limit\'         => 3,
    \'file_max_size\' => 2,
    \'extensions\'    => [\'jpg\', \'jpeg\', \'png\', \'gif\'],
    \'thumbnails\'    => true,
    \'editor\'        => true,
    \'width\'         => 960,
    \'height\'        => 720,
    \'crop\'          => false
);
$form->addFileUpload(\'file\', \'uploaded-images\', \'\', \'Upload up to 3 images\', \'\', $fileUpload_config);');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
