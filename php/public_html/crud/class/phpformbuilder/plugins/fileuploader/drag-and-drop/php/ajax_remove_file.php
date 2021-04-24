<?php
session_start();

include_once('../../secure_upload.php');

if (isset($_POST['filename']) && isset($_POST['upload_dir'])) {
    $filename   = $_POST['filename'];
    $upload_dir = $_POST['upload_dir'];
    $file       = $upload_dir . $filename;
    if (file_exists($file)) {
        unlink($file);
    }
}
