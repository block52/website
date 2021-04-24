<?php
if (!file_exists("install.lock")) {
    header("Location: do-install.php");
    exit;
} else {
    header("Location: /");
    exit;
}
