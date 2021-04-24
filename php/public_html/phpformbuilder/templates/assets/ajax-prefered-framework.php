<?php
if(!isset($_GET['framework']) || !preg_match('`[a-z-]+`', $_GET['framework'])) {
    exit;
} else {
    setcookie('prefered_framework', $_GET['framework'], time() + (86400 * 30), "/");
}
