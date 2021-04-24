<?php
if (!isset($_POST['filename'])||
    !isset($_POST['filehash']) ||
    !isset($_POST['filepath']) ||
    !preg_match('`[a-z0-9]+`', $_POST['filehash']) ||
    preg_match('`\.\.`', $_POST['filename'])) {
    exit('1');
}
$salt = '%t$qPP';
if (hash('sha256', $_POST['filename'] . $salt) !== $_POST['filehash']) {
    exit('2');
}
if (!preg_match('`^[A-Za-z0-9\s\\\/_-]+$`', $_POST['filepath'])) {
    // echo $_POST['filepath'] . "\n";
    exit('WRONG FILE PATH');
}

$filepath = preg_replace('`(.*)json-forms`', '../json-forms', $_POST['filepath']);
$filepath = rtrim($filepath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$filepath = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $filepath);

if (!file_exists(($filepath . $_POST['filename']))) {
    exit('3');
}
$out = array();

if (unlink($filepath . $_POST['filename'])) {
    $out = array(
        'status' => 'success',
        'msg'    => 'The form has been deleted'
    );
} else {
    $out = array(
        'status' => 'danger',
        'msg'    => 'Failed to delete the form file.<br>Try to increase your CHMOD'
    );
}

echo json_encode($out);
