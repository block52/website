<?php
use fileuploader\server\FileUploader;

include('../../server/class.fileuploader.php');

if (isset($_POST['fileuploader']) && isset($_POST['_file']) && isset($_POST['_editor']) && isset($_POST['upload_dir'])) {
    $file = $_POST['upload_dir'] . $_POST['_file'];

    if (is_file($file)) {
        $editor = json_decode($_POST['_editor'], true);
        Fileuploader::resize($file, null, null, $file, (isset($editor['crop']) ? $editor['crop'] : null), 100, (isset($editor['rotation']) ? $editor['rotation'] : null));
    }
}
