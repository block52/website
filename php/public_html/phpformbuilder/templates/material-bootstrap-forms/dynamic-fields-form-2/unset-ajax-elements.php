<?php
session_start();

if (!isset($_GET['index']) || !is_numeric($_GET['index'])) {
    exit();
}
$index = $_GET['index'];

$form_ID = 'dynamic-fields-form-2';
$fields = array(
    'job-' . $index,
    'person-' . $index
);

foreach ($fields as $field) {
    // unset removed fields from form required fields
    unset($_SESSION[$form_ID]['fields'][$field]);
    if (in_array($field, $_SESSION[$form_ID]['required_fields'])) {
        $key = array_search($field, $_SESSION[$form_ID]['required_fields']);
        unset($_SESSION[$form_ID]['required_fields'][$key]);
    }
    if (in_array($field, $_SESSION[$form_ID]['required_fields_conditions'])) {
        $key = array_search($field, $_SESSION[$form_ID]['required_fields_conditions']);
        unset($_SESSION[$form_ID]['required_fields_conditions'][$key]);
    }
}
