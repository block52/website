<?php
use secure\Secure;
use crud\ElementsFilters;
use crud\Elements;
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;

session_start();

include_once '../conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';
include_once CLASS_DIR . 'phpformbuilder/Form.php';

// $item    = lowercase compact table name
$item = $match['params']['item'];

// create|edit|delete
$action = $match['params']['action'];

$canonical = ADMIN_URL . $item . '/' . $action;

if ($action == 'edit' || $action == 'delete') {
    // primary key = record to edit
    $pk         = $match['params']['primary_key'];
    $canonical .= '/' . $pk;
}

$element    = new Elements($item);
$table      = $element->table;
$item_class = $element->item_class;

// lock page
if ($action == 'edit' && Secure::canUpdate($table) !== true && Secure::canUpdateRestricted($table) !== true) {
    Secure::logout();
} elseif (($action == 'create' || $action == 'delete') && (Secure::canCreate($table) !== true && Secure::canCreateRestricted($table) !== true)) {
    Secure::logout();
}

// info label
$info_label       = '';
$info_label_class = '';
if ($action == 'create') {
    $info_label       = ADD_NEW;
    $info_label_class = 'primary';
    $desc             = $info_label . ' ' . $table;
} elseif ($action == 'edit') {
    $info_label       = EDIT;
    $info_label_class = 'warning';
    $desc             = $info_label . ' ' . $table . ' ' . $pk;
} elseif ($action == 'delete') {
    $info_label       = DELETE_ACTION;
    $info_label_class = 'danger';
    $desc             = $info_label . ' ' . $table . ' ' . $pk;
}

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
}
$template_sidebar = $twig->load('sidebar.html');
$template_footer  = $twig->load('footer.html');
$template_js      = $twig->load('data-forms-js.html');

if (!file_exists('inc/forms/' . $item . '-' . $action . '.php')) {
    exit('inc/forms/' . $item . '-' . $action . '.php : ' . ERROR_FILE_NOT_FOUND);
}

include_once 'inc/forms/' . $item . '-' . $action . '.php';
$form->useLoadJs('core');
$form->setMode('development');

$msg = '';
if (isset($_SESSION['msg'])) {
    // catch registered message & reset.
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

$back_url = ADMIN_URL . $item;
if (isset($_SESSION['active_list_url'])) {
    $back_url = $_SESSION['active_list_url'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo SITENAME . ' ' . ADMIN . ' - ' . $desc; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="<?php echo  $canonical; ?>" />
    <meta name="description" content="<?php echo SITENAME; ?> - Bootstrap admin panel - CRUD PHP MySQL - <?php echo $desc; ?>.">
    <?php
        include_once 'inc/css-includes.php';
    ?>
</head>

<body class="<?php echo DEFAULT_BODY_CLASS; ?>">
    <?php include_once 'inc/header.php'; ?>
    <div class="page-container admin-form">
        <?php echo $template_sidebar->render(array('sidebar' => $sidebar)); ?>
        <div class="content-wrapper">
            <div id="msg"><?php echo $msg; ?></div>
            <div class="row">
                <div class="col">
                    <div class="card <?php echo DEFAULT_CARD_CLASS; ?>">
                        <div class="card-header <?php echo DEFAULT_CARD_HEADING_CLASS; ?>">
                            <p class="text-semibold no-margin"><a href="<?php echo $back_url; ?>"><i class="<?php echo ICON_BACK; ?> position-left"></i></a><?php echo $element->item_label; ?></p>
                            <div class="heading-elements">
                                <span class="label label-<?php echo $info_label_class; ?> mt-5"><?php echo $info_label; ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $form->render();
                            /*echo '$item : ' . $item . '<br>';
                            echo '$action : ' . $action . '<br>';
                            if($action == 'edit' || $action == 'delete') {
                                echo '$pk : ' . $pk . '<br>';
                            }*/
                            ?>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end content-wrapper -->
    </div> <!-- end container -->
    <?php
        include_once 'inc/js-includes.php';
        $form->printJsCode('core');
        echo $template_js->render(array('object' => ''));
        echo $template_footer->render(array('object' => ''));

        // load form javascript if exists
    if (file_exists('inc/forms/' . $item . '.js')) {
        ?>
    <script type="text/javascript" src="<?php echo ADMIN_URL . 'inc/forms/' . $item . '.js'; ?>"></script>
    <?php
    }
    ?>
</body>

</html>
