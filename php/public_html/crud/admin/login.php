<?php
use secure\Secure;
use phpformbuilder\Form;
use phpformbuilder\FormExtended;
use phpformbuilder\Validator\Validator;

session_start();
include_once '../conf/conf.php';
include_once ADMIN_DIR . 'secure/conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';
include_once CLASS_DIR . 'phpformbuilder/Form.php';
include_once CLASS_DIR . 'phpformbuilder/database/Mysql.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('login-form') === true) {
    include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
    include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
    $required = array('user-email', 'user-password');
    foreach ($required as $required) {
        $validator->required()->validate($required);
    }
    $validator->email()->validate('user-email');

    if ($validator->hasErrors()) {
        $_SESSION['errors']['login-form'] = $validator->getAllErrors();
    } else {
        Secure::testUser();
    }
}
$form = new FormExtended('login-form', 'vertical', '', 'bs4');
$form->setAction(ADMIN_URL . 'login');
$form->addIcon('user-email', '<i class="' . ICON_USER . ' text-muted"></i>', 'before');
$form->addInput('text', 'user-email', '', '', 'placeholder=' . EMAIL . ', required');
$form->addIcon('user-password', '<i class="' . ICON_PASSWORD . ' text-muted"></i>', 'before');
$form->addInput('password', 'user-password', '', '', 'placeholder=' . PASSWORD . ', required');
$form->addBtn('submit', 'submit-btn', 1, SIGN_IN . ' <i class="' . ICON_ARROW_RIGHT_CIRCLE . ' fa-lg position-right"></i>', 'class=btn btn-primary btn-block');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo ADMIN . ' ' . SITENAME; ?></title>
    <meta name="description" content="<?php echo ADMIN . ' ' . SITENAME; ?> Login page">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_once 'inc/css-includes.php'; ?>
</head>
<body class="bg-slate-700">

    <!-- Page container -->
    <div class="container mt-5 pt-5">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-lg-4">
                <!-- Simple login form -->
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="icon-object border-slate-400 text-slate-400"><i class="<?php echo ICON_DASHBOARD; ?> fa-3x"></i></div>
                            <h1 class="h5"><?php echo LOGIN_TO_YOUR_ACCOUNT; ?> <small class="d-block mt-1 mb-4"><?php echo ENTER_YOUR_CREDENTIALS_BELOW; ?></small></h1>
                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                            $form->render(); ?>
                            <!-- <a href="login_password_recover.html"><?php echo FORGOT_PASSWORD; ?> ?</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /simple login form -->
    </div>

    <!-- /page container -->
    <p class="text-center fixed-bottom"><a href="https://www.phpcrudgenerator.com" class="text-light" title="&copy; www.phpcrudgenerator.com">&copy; www.phpcrudgenerator.com</a></p>
    <?php include_once 'inc/js-includes.php'; ?>
    <script src="assets/javascripts/fontawesome-all.min.js"></script>
</body>
</html>
