<?php
use secure\Secure;

session_start();
include_once '../conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';
Secure::logout();