<?php
use altorouter\AltoRouter;

header("Content-Type: text/html");

include_once '../conf/conf.php';

include __DIR__ . '/class/altorouter/AltoRouter.php';
$router = new AltoRouter();
$router->setBasePath(ROOT_RELATIVE_URL . basename(__DIR__));
// $router->setBasePath('/' . basename(__DIR__));
// '-' not allowed in table names - would break edit in place links
$router->addMatchTypes(array('pk' => '[0-9a-zA-Z_]+'));

$json    = file_get_contents('crud-data/db-data.json');
$db_data = json_decode($json, true);
$editable_tables = array();

// get table names & url alias
foreach ($db_data as $key => $value) {
    $editable_tables[$key] = $value['item'];
}

// Main routes that non-customers see
$router->map('GET', '/home', 'home.php', 'home');

$router->map('GET|POST', '/login', 'login.php', 'login');

$router->map('GET', '/logout', 'logout.php', 'logout');

// Lists
$router->map('GET|POST', '/[' . implode('|', $editable_tables) . ':item]', 'data-list.php', 'data-list');

// Paginated Lists
$router->map('GET|POST', '/[' . implode('|', $editable_tables) . ':item]/p[i:p]', 'data-list.php', 'data-paginated-list');

// Ajax Search Lists
$router->map('POST', '/search/[' . implode('|', $editable_tables) . ':item]', 'inc/data-list-search.php', 'data-list-search');

// Create
$router->map('GET|POST', '/[' . implode('|', $editable_tables) . ':item]/[create:action]', 'data-forms.php', 'data-forms-create');

// Update|Delete
$router->map('GET|POST', '/[' . implode('|', $editable_tables) . ':item]/[edit|delete:action]/[pk:primary_key]', 'data-forms.php', 'data-forms-edit-delete');

// Register URL query string parameters in $_GET since Altorouter ROUTE doesn't deal with these.
$parts = parse_url($_SERVER['REQUEST_URI']);
if (isset($parts['query'])) {
    parse_str($parts['query'], $_GET);
}

/* Match the current request */
$match = $router->match();
if ($match) {
    require $match['target'];
} else {
    header("HTTP/1.0 404 Not Found");
    require '404.html';
}
