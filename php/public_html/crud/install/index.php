<?php
if (!file_exists('install.lock')) {
    header('Location: do-install.php');
    exit;
} else {
    echo 'Installer is locked.<br>Remove install.lock from your server then retry.';
    exit;
}
