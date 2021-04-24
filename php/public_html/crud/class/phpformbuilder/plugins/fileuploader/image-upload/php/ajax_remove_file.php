<?php
session_start();

include_once('../../secure_upload.php');

if (isset($_POST['filename']) && isset($_POST['upload_dir'])) {
    $filename   = $_POST['filename'];
    $upload_dir = $_POST['upload_dir'];
    $thumbnails = $_POST['thumbnails'];
    $file       = $upload_dir . $filename;

    if (file_exists($file)) {
        unlink($file);
    }

    if ($thumbnails == 'true') {
        $thumb_lg   = $upload_dir . 'thumbs/lg/' . $filename;
        $thumb_md   = $upload_dir . 'thumbs/md/' . $filename;
        $thumb_sm   = $upload_dir . 'thumbs/sm/' . $filename;

        if (file_exists($thumb_lg)) {
            unlink($thumb_lg);
        }
        if (file_exists($thumb_md)) {
            unlink($thumb_md);
        }
        if (file_exists($thumb_sm)) {
            unlink($thumb_sm);
        }
    }
}
