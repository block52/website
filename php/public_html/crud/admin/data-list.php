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

// $p       = page number
$_GET['p']  = @$match['params']['p'];

// used to redirect forms to the current active list
$_SESSION['active_list_url'] = $_SERVER['REQUEST_URI'];

include_once ADMIN_DIR . 'class/crud/Elements.php';
$element   = new Elements($item);
$table     = $element->table;
$desc      = ucfirst($table) . ' list';
$canonical = ADMIN_URL . $item;
if (!empty($_GET['p'])) {
    $desc      .= ' - page ' . $_GET['p'];
}


// lock page
// user must have [restricted|all] READ rights on $table
Secure::lock($table, 'restricted');

$item_class                = $element->item_class;
$item_class_with_namespace = $element->item_class_with_namespace;
ElementsFilters::register($table);
include_once ADMIN_DIR . 'class/crud/' . $item_class . '.php';
$object = new $item_class_with_namespace($element);

// store requested page number
$page_var = $table . '-page';
$_SESSION[$page_var] = $_GET['p'];

// sidebar
include_once 'inc/sidebar.php';

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
$template         = $twig->load($item . '.html');
$template_sidebar = $twig->load('sidebar.html');
$template_footer  = $twig->load('footer.html');
$template_js      = $twig->load('data-lists-js.html');
$msg = '';
if (isset($_SESSION['msg'])) {
    // catch registered message & reset.
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME . ' Admin Dashboard - ' . $desc; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="<?php echo  $canonical; ?>" />
    <meta name="description" content="'Bootstrap 4 dashboard - '<?php echo $desc; ?> - PHP CRUD Admin Panel - <?php echo SITENAME; ?>.">
    <?php
        include_once 'inc/css-includes.php';
    ?>
</head>
<body class="<?php echo DEFAULT_BODY_CLASS; ?>">
    <?php include_once 'inc/header.php'; ?>
    <div class="page-container mb-5">
        <?php echo $template_sidebar->render(array('sidebar' => $sidebar)); ?>
        <div class="content-wrapper">
            <div id="msg"><?php echo $msg; ?></div>
            <div class="row">
                <div class="col">
                    <?php
                        echo $template->render(array('object' => $object, 'session' => $_SESSION));
                    ?>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end content-wrapper -->
    </div> <!-- end container -->
    <?php
        echo $template_footer->render(array('object' => $object));
        include_once 'inc/js-includes.php';
        echo $template_js->render(array('object' => $object));
    ?>
</body>
</html>
