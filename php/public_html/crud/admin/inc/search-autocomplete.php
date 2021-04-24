<?php
use secure\Secure;
use crud\Elements;

session_start();
include_once '../../conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';

$suggestions = ['suggestions' => array('value' => '', 'data' => '')];

if (!isset($_POST['item']) || !isset($_POST['search_field']) || !isset($_POST['search_string'])) {
    exit(json_encode($suggestions));
}

// $item    = lowercase compact table name
$item       = $_POST['item'];

include_once ADMIN_DIR . 'class/crud/Elements.php';
$element   = new Elements($item);
$table     = $element->table;

$search_field = $_POST['search_field'];

// store the search field in session
// the search string is stored in the table object only if posted
$_SESSION['rp_search_field'][$table] = $search_field;

// lock page
// user must have [restricted|all] READ rights on $table
Secure::lock($table, 'restricted');

$item_class                = $element->item_class;
$item_class_with_namespace = $element->item_class_with_namespace;
include_once ADMIN_DIR . 'class/crud/' . $item_class . '.php';
$object = new $item_class_with_namespace($element);

if (is_array($object->$search_field)) {
    $uniq_results = array_unique($object->$search_field);
    $search_results = [];
    foreach ($uniq_results as $value) {
        $search_results[] = array(
            'value' => $value,
            'data' => $value
        );
    }
    $suggestions = ['suggestions' => $search_results];
}

echo json_encode($suggestions);

/* echo '{"suggestions": [
    { "value": "United Arab Emirates", "data": "AE" },
    { "value": "United Kingdom",       "data": "UK" },
    { "value": "United States",        "data": "US" }
]}'; */
