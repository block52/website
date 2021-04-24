<?php
use secure\Secure;

session_start();
include_once '../conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';

// lock page
Secure::lock();

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
$template         = $twig->load('home.html');
$template_sidebar = $twig->load('sidebar.html');
$template_js      = $twig->load('data-home-js.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?> Admin Dashboard - Home</title>
    <meta name="description" content="<?php echo SITENAME; ?> - Website admin panel - CRUD Home Page.">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_once 'inc/css-includes.php'; ?>
</head>
<body class="<?php echo DEFAULT_BODY_CLASS; ?>">
    <?php include_once 'inc/header.php'; ?>
    <div class="page-container">
        <?php echo $template_sidebar->render(array('sidebar' => $sidebar)); ?>
        <div class="content-wrapper">
            <div class="row">
                <div class="col">
                    <?php
                        echo $template->render(array());
                    ?>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end content-wrapper -->
    </div> <!-- end container -->
    <?php
        include_once 'inc/js-includes.php';
        echo $template_js->render(array('object' => ''));
    ?>
</body>
</html>
