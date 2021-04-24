<?php
use phpformbuilder\database\Mysql;

if (!isset($_SESSION['generator_user_email']) || !isset($_SESSION['generator_purchase_code']) || !filter_var($_SESSION['generator_user_email'], FILTER_VALIDATE_EMAIL) || !preg_match('`[a-z0-9-]{36}`', $_SESSION['generator_purchase_code']) || !isset($_SESSION['generator_hash']) || $_SESSION['generator_hash'] != sha1($_SESSION['generator_purchase_code'] . $_SESSION['generator_user_email'])) {
    header('Location:login.php');
    exit;
}
