<?php

//
// The Fileuploader PHP documentation is available here: https://innostudio.de/fileuploader/documentation/#php
//

use fileuploader\server\FileUploader;

session_start();

include('../../server/class.fileuploader.php');

include_once('../../secure_upload.php');

if (!is_writable($upload_config['upload_dir'])) {
    exit('UPLOAD ERROR: ' . $upload_config['upload_dir'] . ' IS NOT WRITABLE - Try to increase your CHMOD and double-check that your folder exists');
}

// initialize FileUploader
$FileUploader = new FileUploader($input_name, array(
    'limit'       => $upload_config['limit'],
    'maxSize'     => null,
    'fileMaxSize' => $upload_config['file_max_size'],
    'extensions'  => json_decode($upload_config['extensions']),
    'required'    => false,
    'uploadDir'   => $upload_config['upload_dir'],
    'title'       => 'name',
    'replace'     => false,
    'listInput'   => true,
    'files'       => null
));

// call to upload the files
$data = $FileUploader->upload();

// export to js
echo json_encode($data);
exit;
