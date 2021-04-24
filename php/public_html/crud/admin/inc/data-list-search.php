<?php
use secure\Secure;
use crud\ElementsFilters;
use crud\Elements;
use phpformbuilder\Form;

session_start();
include_once '../conf/conf.php';
include_once CLASS_DIR . 'phpformbuilder/Form.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';


// $item    = lowercase compact table name
$item       = $match['params']['item'];

include_once ADMIN_DIR . 'class/crud/Elements.php';
$element   = new Elements($item);
$table     = $element->table;

// lock page
// user must have [restricted|all] READ rights on $table
Secure::lock($table, 'restricted');

$item_class                = $element->item_class;
$item_class_with_namespace = $element->item_class_with_namespace;
ElementsFilters::register($table);
include_once ADMIN_DIR . 'class/crud/' . $item_class . '.php';
$object = new $item_class_with_namespace($element);

require_once ROOT . 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig   = new \Twig\Environment($loader, array(
    'debug' => DEBUG,
));
include_once ROOT . 'vendor/twig/twig/src/Extension/CrudTwigExtension.php';
$twig->addExtension(new CrudTwigExtension());
if (ENVIRONMENT == 'development') {
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $twig-> enableDebug();
}
$template = $twig->load($item . '.html');

$output = $template->renderBlock('object_list', array('object' => $object, 'session' => $_SESSION));

echo json_encode($output);
