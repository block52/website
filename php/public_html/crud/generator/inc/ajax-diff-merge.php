<?php
if (!file_exists('../../conf/conf.php')) {
    exit('Configuration file not found (5)');
}
include_once '../../conf/conf.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['merge']) && isset($_POST['filepath']) && $_POST['action'] == 'register_merged_content' && file_exists(ADMIN_DIR . $_POST['filepath'])) {
    $new_content = implode("\n", $_POST['merge']);
    file_put_contents(ADMIN_DIR . $_POST['filepath'], $new_content);
}
