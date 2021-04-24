<?php
session_start();
if (isset($_POST['table'])) {
    $table = $_POST['table'];
    $_SESSION['rp_search_string'][$table] = '';
}
