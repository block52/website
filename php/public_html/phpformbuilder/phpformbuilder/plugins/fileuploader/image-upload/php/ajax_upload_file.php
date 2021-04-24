<?php
use fileuploader\server\FileUploader;

session_start();

include('../../server/class.fileuploader.php');

include_once('../../secure_upload.php');

$upload_dir = $upload_config['upload_dir'];
$thumbnails = $_POST['thumbnails'];
$width      = $_POST['width'];
$height     = $_POST['height'];
$crop       = $_POST['crop'];

$fileuploader_title = 'name';
$fileuploader_replace = false;

// if after editing
if (isset($_POST['_namee']) && isset($_POST['_editorr'])) {
    $fileuploader_title = $_POST['_namee'];
    $fileuploader_replace = true;
}

if (!is_writable($upload_dir)) {
    exit('UPLOAD ERROR: ' . $upload_dir . ' IS NOT WRITABLE - Try to increase your CHMOD and double-check that your folder exists');
}

// initialize FileUploader
$FileUploader = new FileUploader($input_name, array(
    'limit'       => $upload_config['limit'],
    'maxSize'     => null,
    'fileMaxSize' => $upload_config['file_max_size'],
    'extensions'  => json_decode($upload_config['extensions']),
    'required'    => false,
    'uploadDir'   => $upload_dir,
    'title'       => $fileuploader_title,
    'replace'     => $fileuploader_replace,
    'listInput'   => true,
    'files'       => null
));

// call to upload the files
$data = $FileUploader->upload();


/* resize & generate thumbnails
-------------------------------------------------- */

if ($data['isSuccess']) {
    $filename = $data['files'][0]['name'];
    $source = $data['files'][0]['file'];

    // get uploaded image info
    $uploaded_image_info = getimagesize($source);

    // store image information
    list($image_width, $image_height, $image_type) = $uploaded_image_info;

    // center crop horizontally & vertically
    if ($crop == 'true') {
        $crop = array(
            '_paramCrop' => array(
                'left' => ($image_width - $width) / 2,
                'top' => ($image_height - $height) / 2,
                'width' => $width,
                'height' => $height
            )
        );
    }
    $thumbs = array();
    $original = array(
        // original resized
        'width'       => $width,
        'height'      => $height,
        'destination' => $upload_dir . $filename,
        'crop'        => $crop
    );

    FileUploader::resize($source, $original['width'], $original['height'], $original['destination'], $original['crop'], 90, 0);

    // get resized image info
    $resized_image_info = getimagesize($source);

    // store image information
    list($image_width, $image_height, $image_type) = $resized_image_info;

    /* define the thumnails sizes
    -------------------------------------------------- */

    $lg_thumb_width  = 526;
    $lg_thumb_height = 526;

    $md_thumb_width  = 288;
    $md_thumb_height = 288;

    $sm_thumb_width  = 208;
    $sm_thumb_height = 208;

    if ($thumbnails == 'true') {
        $thumbs = array(
            // large thumb
            array(
                'width'       => $lg_thumb_width,
                'height'      => $lg_thumb_height,
                'destination' => $upload_dir . 'thumbs/lg/' . $filename,
                'dest_folder' => $upload_dir . 'thumbs/lg',
                'crop'        => false
            ),
            // medium thumb
            array(
                'width'       => $md_thumb_width,
                'height'      => $md_thumb_height,
                'destination' => $upload_dir . 'thumbs/md/' . $filename,
                'dest_folder' => $upload_dir . 'thumbs/md',
                'crop'        => false
            ),
            // small thumb
            array(
                'width'       => $sm_thumb_width,
                'height'      => $sm_thumb_height,
                'destination' => $upload_dir . 'thumbs/sm/' . $filename,
                'dest_folder' => $upload_dir . 'thumbs/sm',
                'crop'        => false
            )
        );
        $has_error = false;
        $error_log = '';
        foreach ($thumbs as $key => $thumb) {
            if (!file_exists($thumb['dest_folder'])) {
                $has_error = true;
                $error_log .= 'Thumbnail folder doesn\' exist: ' . $thumb['dest_folder'] . "\n";
            }
        }
        if ($has_error === true) {
            echo $error_log;
            exit;
        }
    }
    foreach ($thumbs as $thumb) {
        FileUploader::resize($source, $thumb['width'], $thumb['height'], $thumb['destination'], false, 90, 0);
    }
}

// export to js
echo json_encode($data);
exit;