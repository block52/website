<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use fileuploader\server\FileUploader;

/* =============================================
    Internal functions for installation
============================================= */

/**
 * get the database connection infos from connection file
 * @return array $db_info of Boolean false on failure
 * NOTE: the database constants MUST NOT be used in this file because the connection file may be rewritten.
 */
function getDbInfo()
{
    $fp = file_get_contents(CLASS_DIR . 'phpformbuilder/database/db-connect.php');
    $reg = '`define\(\'(?:DBUSER|DBPASS|DBHOST|DBNAME)\',[\s]?\'([^\']*)\'\);`';
    preg_match_all($reg, $fp, $out);
    $results = $out[1];
    if (isset($results[7])) {
        $db_info = array(
            'localhost' => array(
                'user' => $results[0],
                'pass' => $results[1],
                'host' => $results[2],
                'name' => $results[3]
           ),
            'production' => array(
                'user' => $results[4],
                'pass' => $results[5],
                'host' => $results[6],
                'name' => $results[7]
           )
        );

        return $db_info;
    } else {
        $error_msg       = '<p class="mb-0">Unable to parse ' . CLASS_DIR . 'phpformbuilder/database/db-connect.php' . '<br><br>Please restore the package\'s original file then retry</p>';
        $_SESSION['msg'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>' . $error_msg . '</div>';

        return false;
    }
}

function registerDbInfo()
{
    $error_msg = '';
    $db_connect_template = GENERATOR_DIR . 'generator-templates/db-connect.txt';
    $fp                  = file_get_contents($db_connect_template);
    $find                = array();
    $replace             = array();
    if ($_POST['db-target'] == 'localhost') {
        array_push($find, '%localhost-user%', '%localhost-pass%', '%localhost-host%', '%localhost-name%');
        array_push($replace, $_POST['localhost-user'], $_POST['localhost-pass'], $_POST['localhost-host'], $_POST['localhost-name']);
    } elseif ($_POST['db-target'] == 'production') {
        array_push($find, '%production-user%', '%production-pass%', '%production-host%', '%production-name%');
        array_push($replace, $_POST['production-user'], $_POST['production-pass'], $_POST['production-host'], $_POST['production-name']);
    }
        $db_connect_content = str_replace($find, $replace, $fp);
    if (file_put_contents(CLASS_DIR . 'phpformbuilder/database/db-connect.php', $db_connect_content) === false) {
        $error_msg = 'Unable to write content in <code>' . CLASS_DIR . 'phpformbuilder/database/db-connect.php</code><br>Please check the write permissions of this folder (chmod >= 0755)';
    } else {
        // Check connection to database
        $db = getDbInfo();
        $server = 'production'; // default
        if (ENVIRONMENT == 'development') {
            $server = 'localhost';
        }
        $db_host = $db[$server]['host'];
        $db_user = $db[$server]['user'];
        $db_pass = $db[$server]['pass'];
        $db_name = $db[$server]['name'];
        @$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_error()) {
            $error_msg = 'Unable to connect to MySQL (' . mysqli_connect_errno() . '):<br>'. mysqli_connect_error() . '<br>Please check your connection settings<br><hr>';
            $error_msg .= '<span style="display:inline-block;width:120px">ENVIRONMENT:</span> ' . ENVIRONMENT;
            if (ENVIRONMENT == 'development') {
                $error_msg .= ' (localhost)';
            }
            $error_msg .= '<br><span style="display:inline-block;width:120px">DBHOST:</span> ' . $db_host;
            $error_msg .= '<br><span style="display:inline-block;width:120px">DBUSER:</span> ' . $db_user;
            $error_msg .= '<br><span style="display:inline-block;width:120px">DBPASS:</span> ' . $db_pass;
            $error_msg .= '<br><span style="display:inline-block;width:120px">DBNAME:</span> ' . $db_name;
        } else {
            require_once CLASS_DIR . 'phpformbuilder/Validator/Token.php';
            $purchase_verification = aplVerifyEnvatoPurchase(trim($_POST['user-purchase-code']));
            if (!empty($purchase_verification)) { //protected script can't connect to your licensing server
                $error_msg = 'Connection to remote server can\'t be established';
            }
            if (empty($error_msg)) {
                mysqli_query($mysqli, "SET SESSION sql_mode='NO_ENGINE_SUBSTITUTION'");
                mysqli_set_charset($mysqli, "utf8");
                $token_notifications_array = installToken(BASE_URL . 'class/phpformbuilder', $_POST['user-email'], trim($_POST['user-purchase-code']), $mysqli);
                if ($token_notifications_array['notification_case'] !== "notification_license_ok") {
                    // if script is already installed, return true instead of error
                    // if ($token_notifications_array['notification_text'] != 'Script is already installed (or database not empty).') {
                        $error_msg = 'Unfortunately, installation failed because of this reason: ' . $token_notifications_array['notification_text'];
                    // }
                }
            }
        }
    }
    if (!empty($error_msg)) {
        return $error_msg;
    }

    return true;
}

function updateConf($constant, $value, $conf_file = 'conf/user-conf.json')
{
    $user_conf = json_decode(file_get_contents(ROOT . $conf_file), true);
    $user_conf[$constant] = $value;
    $user_conf = json_encode($user_conf);
    if (!file_put_contents(ROOT . $conf_file, $user_conf)) {
            return false;
    }

        return true;
}

function demoSqlQuery($sql_file, $db)
{
    $fp = file($sql_file);
    $queries = '';
    foreach ($fp as $l) {
        if ($l != '' && substr(trim($l), 0, 2) != '--') {  // Remove the — style comments and empty lines
            $queries .= $l;
        }
    }

    $queries = str_replace('phpcg', DBNAME, $queries);

    // Remove empty lines
    $queries = preg_replace('/^[ \t]*[\r\n]+/m', '', $queries);

    // Remove line breaks after ';'
    $queries = preg_replace('%[;]{1}[\r\n]%', ';', $queries);

    $queries = explode(';', $queries);

    // var_dump($queries);
    // exit();

    foreach ($queries as $qry) {
        if (!empty($qry)) {
            if ($db->query($qry . ';') === false) {
                return false;
            }
        }
    }

    return true;
}

function checkWritePermissions($files)
{
    $errors = [];
    foreach ($files as $filename) {
        if (file_exists($filename)) {
            // test only existing files/folders, as the generator may not be uploaded on production server
            if (!is_writable($filename)) {
                $errors[] = str_replace('../', '', $filename);
            }
        }
    }
    if (!empty($errors)) {
        return 'The following file(s)/folder(s) must be writable:<br><br>' . implode('<br>', $errors) . '<br><br>You\'ve got to increase your CHMOD.';
    }

    return true;
}

function getMimeType($file)
{
    $realpath = realpath($file);
    // Try a couple of different ways to get the mime-type of a file, in order of preference
    if ($realpath && function_exists('finfo_file') && function_exists('finfo_open') && defined('FILEINFO_MIME_TYPE')) {
        // As of PHP 5.3, this is how you get the mime-type of a file; it uses the Fileinfo
        // PECL extension
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $realpath);
    } elseif (function_exists('mime_content_type')) {
        // Before this was deprecated in PHP 5.3, this was how you got the mime-type of a file
        return mime_content_type($file);
    } else {
        // Worst-case scenario has happened, use the file extension to infer the mime-type
        $mimeTypes = array(
            'gif' => 'image/gif',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'tif' => 'image/tiff',
            'tiff' => 'image/tiff',
            'xbm' => 'image/x-xbitmap',
        );
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (isset($mimeTypes[$ext])) {
            return $mimeTypes[$ext];
        }
    }
    return false;
}

session_start();

$_SESSION['msg']    = '';
$already_registered = false;
$just_unregistered  = false;

if (!file_exists("install.lock")) {
    if (!file_exists('../conf/conf.php')) {
        $error_msg       = '<p style="color: #721c24;background-color: #f8d7da;padding: .75rem 1.25rem;border-radius: .25rem;">' . '../conf/conf.php' . '<br><br><strong>Configuration file not found (2)</strong></p>';
        exit($error_msg);
    } else {
        include_once '../conf/conf.php';

        if (!file_exists(CLASS_DIR . 'phpformbuilder/database/db-connect.php')) {
            $error_msg       = '<p class="mb-0">' . CLASS_DIR . 'phpformbuilder/database/db-connect.php' . '<br><br>Connection file not found</p>';
            $error_msg = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>' . $error_msg . '</div>';
            exit($error_msg);
        }


        /* check if package is already installed
        -------------------------------------------------- */

        $db_info = getDbInfo();

        if ($db_info !== false && !isset($_POST['step-3-global-settings'])) {
            $server = false;
            if (($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') && strstr($db_info['localhost']['user'], '%') === false && strstr($db_info['localhost']['host'], '%') === false) {
                $server = 'localhost';
            } elseif (strstr($db_info['production']['user'], '%') === false && strstr($db_info['production']['host'], '%') === false) {
                $server = 'production';
            }

            if ($server !== false) {
                $db_host = $db_info[$server]['host'];
                $db_user = $db_info[$server]['user'];
                $db_pass = $db_info[$server]['pass'];
                $db_name = $db_info[$server]['name'];

                $db = new Mysql(true, $db_name, $db_host, $db_user, $db_pass);
                $tables = $db->GetTables();
                if (is_array($tables) && in_array('user_data', $tables)) {
                    $already_registered = true;
                } else {
                    if (!is_array($tables)) {
                        $error_msg = '<p class="mb-0">Unable to connect to database - please check your connection settings in ' . CLASS_DIR . 'phpformbuilder/database/db-connect.php</p>';
                    } else {
                        $error_msg = '<p class="mb-0">Table user_data not found</p><p>Replace ' . CLASS_DIR . 'phpformbuilder/database/db-connect.php original file to reset your installation</p>';
                    }
                    $_SESSION['msg'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>' . $error_msg . '</div>';
                }
            }
        }


        if ($already_registered === true) {
            //

            /* =============================================
                Already registered
            ============================================= */

            if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['unregister-form'])) {
                $validator = Form::validate('unregister-form');

                if ($validator->hasErrors()) {
                    $_SESSION['errors']['unregister-form'] = $validator->getAllErrors();
                } else {
                    //

                    /* Uninstall
                    -------------------------------------------------- */

                    require_once CLASS_DIR . 'phpformbuilder/Validator/Token.php';
                    $purchase_verification = aplVerifyEnvatoPurchase(trim($_POST['user-purchase-code']));
                    if (!empty($purchase_verification)) { //protected script can't connect to your licensing server
                        $error_msg = 'Connection to remote server can\'t be established';
                    }
                    if (empty($error_msg)) {
                        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
                        if (mysqli_connect_error()) {
                            $error_msg = 'Unable to connect to MySQL (' . mysqli_connect_errno() . '):<br>'. mysqli_connect_error() . '<br>Please check your connection settings<br><hr>';
                        } else {
                            mysqli_query($mysqli, "SET SESSION sql_mode='NO_ENGINE_SUBSTITUTION'");
                            mysqli_set_charset($mysqli, "utf8");
                            $token_notifications_array = aplUninstallToken($mysqli);
                            if ($token_notifications_array['notification_case'] !== "notification_license_ok") {
                                $error_msg = 'Unfortunately, uninstaller failed because of this reason: ' . $token_notifications_array['notification_text'];
                            } else {
                                // reset db connection
                                $db_connect_template = GENERATOR_DIR . 'generator-templates/db-connect.txt';
                                $fp                  = file_get_contents($db_connect_template);
                                if (file_put_contents(CLASS_DIR . 'phpformbuilder/database/db-connect.php', $fp) === false) {
                                    $error_msg = 'Unable to write content in <code>' . CLASS_DIR . 'phpformbuilder/database/db-connect.php</code><br>Please check the write permissions of this folder (chmod >= 0755)';
                                } else {
                                    // All ok - uninstall successful
                                    $just_unregistered = true;
                                    $_SESSION['msg'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>PHP CRUD Generator license has been successfully removed.</div>';
                                }
                            }
                        }
                    }
                    if (!empty($error_msg)) {
                        $_SESSION['msg'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>' . $error_msg . '</div>';
                    }
                }
            }

            if ($just_unregistered !== true) {
                $form = new Form('unregister-form', 'horizontal', 'novalidate', 'bs4');
                $form->startFieldset('Fill-in the form below to unregister your copy');
                $form->addHtml('<p class="mb-5"></p>');
                $form->addInput('text', 'user-purchase-code', '', 'Enter your purchase code', 'class=mb-5, required');
                $form->centerButtons(true);
                $form->addBtn('submit', 'submit-btn', 1, 'Unregister', 'class=btn btn-warning ladda-button, data-style=zoom-in');
            }
        } else {
            //

            /* =============================================
                Not yet registered
            ============================================= */

            $current_step = 1; // default if nothing posted
            if ($_SERVER["REQUEST_METHOD"] == 'GET' || (isset($_POST['back-btn']) && $_POST['back-btn'] == 1)) {
                //

                /* Check server settings
                -------------------------------------------------- */

                $files_to_check = array(
                    '../admin/assets/images',
                    '../admin/class/crud',
                    '../admin/crud-data',
                    '../admin/inc/forms',
                    '../admin/secure/conf/conf.php',
                    '../admin/secure/install',
                    '../admin/templates',
                    '../class/phpformbuilder/database/db-connect.php',
                    '../class/phpformbuilder/plugins/min',
                    '../conf',
                    '../conf/conf.php',
                    '../conf/user-conf.json',
                    '../generator/backup-files/class',
                    '../generator/backup-files/crud-data',
                    '../generator/backup-files/database',
                    '../generator/backup-files/inc',
                    '../generator/backup-files/templates',
                    '../generator/database',
                    '../generator/update/cache',
                    '../generator/update/temp',
                    '../install'
                );

                $user_server = array(
                    'php_version' => array(
                        'label' => 'PHP Version',
                        'value' => phpversion(),
                        'ok'    => false,
                        'error_msg' => 'Your PHP version must be 5.5 or higher'
                   ),
                    'file_perms' => array(
                        'label' => 'Files/folders write permissions',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => ''
                   ),
                    'allow_url_fopen' => array(
                        'label' => 'PHP allow_url_fopen',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => 'PHP allow_url_fopen is disabled in your php.ini and is required by PHP CRUD Generator.<br>Open your php.ini and turn on the allow_url_fopen directive.'
                   ),
                    'mysqli_extension' => array(
                        'label' => 'PHP MySQLI extension',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => 'PHP MySQLI extension is required and is not installed/enabled on your server.'
                   ),
                    'curl_extension' => array(
                        'label' => 'PHP CURL extension',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => 'PHP CURL extension is required and is not installed/enabled on your server.'
                   ),
                    'dom_extension' => array(
                        'label' => 'PHP dom extension',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => 'PHP DOM extension is required and is not installed/enabled on your server.'
                   ),
                    'gd_extension' => array(
                        'label' => 'PHP GD extension',
                        'value' => '',
                        'ok'    => 'warning',
                        'error_msg' => 'PHP GD extension is required for images upload and is not enabled on your server.'
                   ),
                    'mb_string_extension' => array(
                        'label' => 'PHP mb_string extension',
                        'value' => '',
                        'ok'    => false,
                        'error_msg' => 'PHP mb_string extension is required and is not installed/enabled on your server.'
                   ),
                    'zip_extension' => array(
                        'label' => 'PHP ZIP extension',
                        'value' => '',
                        'ok'    => 'warning',
                        'error_msg' => 'PHP ZIP extension is required for auto-update system and is not enabled on your server.<br>You will not be able to install the future PHPCG versions with the auto-update system.'
                   ),
                    'intl_extension' => array(
                        'label' => 'PHP intl extension',
                        'value' => '',
                        'ok'    => 'warning',
                        'error_msg' => 'PHP intl extension is suitable but not required.<br>Intl extension is used for automatic date &amp; time translation in the admin panel READ lists.<br>If not present, dates &amp; times will be in English.'
                   )
                );

                // PHP Version
                if (version_compare($user_server['php_version']['value'], '5.5', '>=')) {
                    $user_server['php_version']['ok'] = true;
                }

                // Write permissions
                $permissions = checkWritePermissions($files_to_check);
                if ($permissions === true) {
                    $user_server['file_perms']['ok'] = true;
                } else {
                    $user_server['file_perms']['error_msg'] = $permissions;
                }

                if (ini_get('allow_url_fopen') == true) {
                    $user_server['allow_url_fopen']['ok'] = true;
                }

                $php_extensions = get_loaded_extensions();

                // PHP GD extension
                if (in_array('mysqli', $php_extensions)) {
                    $user_server['mysqli_extension']['ok'] = true;
                }

                // PHP CURL extension
                if (in_array('curl', $php_extensions)) {
                    $user_server['curl_extension']['ok'] = true;
                }

                // PHP DOM extension
                if (in_array('dom', $php_extensions)) {
                    $user_server['dom_extension']['ok'] = true;
                }

                // PHP GD extension
                if (in_array('gd', $php_extensions)) {
                    $user_server['gd_extension']['ok'] = true;
                }

                // PHP mb_string extension
                if (in_array('mbstring', $php_extensions)) {
                    $user_server['mb_string_extension']['ok'] = true;
                }

                // PHP ZIP extension
                if (in_array('zip', $php_extensions)) {
                    $user_server['zip_extension']['ok'] = true;
                }

                // PHP intl extension
                if (in_array('intl', $php_extensions)) {
                    $user_server['intl_extension']['ok'] = true;
                }
            } elseif ($_SERVER["REQUEST_METHOD"] == 'POST') {
                //

                // default step for POST
                $current_step = 2;
                if (isset($_POST['back-btn'])) {
                    $current_step = $_POST['back-btn'];
                } elseif (isset($_POST['step-2-db-info'])) {
                    //

                    /* Validate step 2
                    -------------------------------------------------- */

                    $validator = Form::validate('step-2-db-info');

                    // additional validation
                    $validator->email()->validate('user-email');

                    if ($validator->hasErrors()) {
                        $current_step = 2;
                        $_SESSION['errors']['step-2-db-info'] = $validator->getAllErrors();
                    } else {
                        //

                        /* Register DB connection(s)
                        -------------------------------------------------- */

                        $result =registerDbInfo();
                        if ($result === true) {
                            $_SESSION['msg'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>Database connection successful</div>';
                            $current_step = 3;
                        } else {
                            $_SESSION['msg'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>' . $result . '</div>';
                        }
                    }
                } elseif (isset($_POST['step-3-global-settings'])) {
                    //

                    /* Validate step 3
                    -------------------------------------------------- */

                    $current_step = 3;

                    $validator = Form::validate('step-3-global-settings');

                    if ($validator->hasErrors()) {
                        $_SESSION['errors']['step-3-global-settings'] = $validator->getAllErrors();
                    } else {
                        //

                        /* Register CONF
                        -------------------------------------------------- */

                        $has_conf_error = false;
                        $has_db_error   = false;
                        if (updateConf('sitename', $_POST['user-sitename']) !== true) {
                            $has_conf_error = true;
                        }
                        if (updateConf('lang', $_POST['user-language']) !== true) {
                            $has_conf_error = true;
                        }
                        if (isset($_POST['user-logo']) && !empty($_POST['user-logo'])) {
                            include_once CLASS_DIR . 'phpformbuilder/plugins/fileuploader/server/class.fileuploader.php';

                            $posted_img = FileUploader::getPostedFiles($_POST['user-logo']);
                            if (updateConf('admin_logo', $posted_img[0]['file']) !== true) {
                                $has_conf_error = true;
                            }
                        }
                        if ($has_conf_error !== true) {
                            //

                            /* install demo database
                            -------------------------------------------------- */

                            if (isset($_POST['install-demo-db']) && $_POST['install-demo-db'] > 0) {
                                include_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
                                $db = new Mysql();
                                $sql_files = array(
                                    'phpcg-demo-db/phpcg-shema.sql',
                                    'phpcg-demo-db/phpcg-db-data/actor.sql',
                                    'phpcg-demo-db/phpcg-db-data/address.sql',
                                    'phpcg-demo-db/phpcg-db-data/category.sql',
                                    'phpcg-demo-db/phpcg-db-data/city.sql',
                                    'phpcg-demo-db/phpcg-db-data/country.sql',
                                    'phpcg-demo-db/phpcg-db-data/customer.sql',
                                    'phpcg-demo-db/phpcg-db-data/film.sql',
                                    'phpcg-demo-db/phpcg-db-data/film_actor.sql',
                                    'phpcg-demo-db/phpcg-db-data/film_category.sql',
                                    'phpcg-demo-db/phpcg-db-data/inventory.sql',
                                    'phpcg-demo-db/phpcg-db-data/language.sql',
                                    'phpcg-demo-db/phpcg-db-data/payment.sql',
                                    'phpcg-demo-db/phpcg-db-data/rental.sql',
                                    'phpcg-demo-db/phpcg-db-data/staff.sql',
                                    'phpcg-demo-db/phpcg-db-data/store.sql'
                                );
                                $db->throw_exceptions = true;
                                try {
                                    $db->transactionBegin();
                                    foreach ($sql_files as $sql_file) {
                                        if (demoSqlQuery($sql_file, $db) === false) {
                                            throw new \Exception();
                                            break;
                                        }
                                    }
                                    $db->transactionEnd();
                                } catch (\Exception $e) {
                                    $has_db_error = true;
                                    $db->transactionRollback();
                                    exit($e->getMessage() . '<br><pre>' . $db->getLastSql() . '</pre>');
                                }
                            }

                            // create lock file
                            if ($has_db_error != true) {
                                if (file_put_contents('install.lock', '') === false) {
                                    exit('Unable to write lock file');
                                }
                            }

                            $current_step = 4;
                        }
                    }
                }
            } // End if ($_SERVER["REQUEST_METHOD"] == 'POST')

            if ($current_step == 2) {
                //

                /* ==================================================
                    Step 2
                ================================================== */

                /* Get db connection infos from phpformbuilder/database/db-connect.php
                -------------------------------------------------- */

                if ($db_info !== false) {
                    $form = new Form('step-2-db-info', 'horizontal', 'novalidate', 'bs4');
                    $val = 'localhost'; // default
                    if (isset($_POST['db-target']) && ($_POST['db-target'] == 'localhost' || $_POST['db-target'] == 'production')) {
                        $val = $_POST['db-target'];
                    }
                    $form->addInput('hidden', 'db-target', $val);
                    $form->addHtml('<label class="control-label">Choose your installation server</label>');
                    $form->addHtml('<div class="card-deck mb-3">
                        <a href="#" class="choose-db-target-radio card bg-dark" id="localhost">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h6 class="card-title text-center text-white my-4"><span class="rounded-circle bg-pink-400"><i class="' . ICON_CHECKMARK . '"></i></span>Localhost</h6>
                            </div>
                        </a>
                        <a href="#" class="choose-db-target-radio card bg-dark" id="production">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h6 class="card-title text-center text-white my-4"><span class="rounded-circle bg-pink-400"><i class="' . ICON_CHECKMARK . '"></i></span>Production Server</h6>
                            </div>
                        </a>
                    </div>');
                    $form->startDependentFields('db-target', 'localhost');
                    $form->startFieldset('Database Localhost connection', 'class=mb-4');
                    $form->addInput('text', 'localhost-host', $db_info['localhost']['host'], 'Host', 'required');
                    $form->addInput('text', 'localhost-user', $db_info['localhost']['user'], 'User', 'required');
                    $form->addInput('text', 'localhost-pass', $db_info['localhost']['pass'], 'Password', '');
                    $form->addInput('text', 'localhost-name', $db_info['localhost']['name'], 'Database', 'required');
                    $form->endFieldset();
                    $form->endDependentFields();

                    $form->startDependentFields('db-target', 'production');
                    $form->startFieldset('Database Production server connection', 'class=mb-4');
                    $form->addInput('text', 'production-host', $db_info['production']['host'], 'Host', 'required');
                    $form->addInput('text', 'production-user', $db_info['production']['user'], 'User', 'required');
                    $form->addInput('text', 'production-pass', $db_info['production']['pass'], 'Password', 'required');
                    $form->addInput('text', 'production-name', $db_info['production']['name'], 'Database', 'required');
                    $form->endFieldset();
                    $form->endDependentFields();

                    $form->startFieldset('User Info', 'class=mb-4');
                    $form->addInput('email', 'user-email', '', 'Your email', 'required');
                    // $form->addHelper('Example: domain.com', 'user-domain');
                    // $form->addInput('text', 'user-domain', '', 'Your domain', 'required');
                    $form->addInput('text', 'user-purchase-code', '', 'Your purchase code', 'required');
                    $form->addHtml('<p><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank" rel="noopener" title="Where is my Purchase Code?">Where is my Purchase Code?</a></p>');
                    $form->endFieldset();

                    $form->centerButtons(true);
                    $form->setCols(-1, -1);
                    $form->addBtn('submit', 'back-btn', 1, '<i class="' . ICON_ARROW_LEFT . ' prepend"></i> Back', 'class=btn btn-warning', 'btns');
                    $form->addBtn('submit', 'submit-btn', 2, 'Next <i class="' . ICON_ARROW_RIGHT . ' append" aria-hidden="true"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'btns');
                    $form->printBtnGroup('btns');
                }
            } elseif ($current_step == 3) {
                //

                /* ==================================================
                    Step 2
                ================================================== */

                // get the db info to display db name
                include_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
                $form = new Form('step-3-global-settings', 'horizontal', 'novalidate', 'bs4');
                $form->startFieldset('Global Settings', 'class=mb-4');
                $form->addHelper('Enter the sitename to be displayed in your admin panel', 'sitename');
                $form->addInput('text', 'user-sitename', 'PHP CRUD GENERATOR', 'Your project name', 'required');

                if (!isset($_SESSION['step-3-global-settings']['user-language'])) {
                    $_SESSION['step-3-global-settings']['user-language'] = 'en';
                }

                $json = file_get_contents(GENERATOR_DIR . 'inc/languages.json');
                $countries = json_decode($json);

                foreach ($countries as $c) {
                    $form->addOption('user-language', $c->code, $c->name);
                }
                $form->addHtml('<div id="select-language-callback"></div>', 'user-language', 'after');
                $form->addSelect('user-language', 'Admin panel language', 'class=select2, required');

                $current_file = ''; // default empty
                $current_file_name = 'logo-height-100.png'; // default PHPCG logo

                $current_file_path = ADMIN_DIR . 'assets/images/';
                if (isset($_POST['user-logo'])) {
                    $current_file_name = $_POST['user-logo'];
                }

                if (file_exists($current_file_path . $current_file_name)) {
                    $current_file_size = filesize($current_file_path . $current_file_name);
                    $current_file_type = getMimeType($current_file_path . $current_file_name);
                    $current_file = array(
                        'name' => $current_file_name,
                        'size' => $current_file_size,
                        'type' => $current_file_type,
                        'file' => ADMIN_URL . 'assets/images/' . $current_file_name, // url of the file
                        'data' => array(
                            'listProps' => array(
                            'file' => $current_file_name
                           )
                       )
                    );
                }
                $fileUpload_config = array(
                    'xml'           => 'image-upload', // the thumbs directories must exist
                    'uploader'      => 'ajax_upload_file.php', // the uploader file in phpformbuilder/plugins/fileuploader/[xml]/php
                    'upload_dir'    => '../../../../../../admin/assets/images/', // the directory to upload the files. relative to [plugins dir]/fileuploader/image-upload/php/ajax_upload_file.php
                    'limit'         => 1, // max. number of files
                    'file_max_size' => 2, // each file's maximal size in MB {null, Number}
                    'extensions'    => ['jpg', 'jpeg', 'png'],
                    'thumbnails'    => false,
                    'editor'        => false,
                    'width'         => 200,
                    'height'        => 100,
                    'crop'          => false,
                    'debug'         => true
                );

                $form->addHelper('Image will be resized to max. width 200px, max. height 100px.<br>Accepted File Types : Accepted File Types : .jp[e]g, .png, .gif', 'user-logo', 'after');
                $form->addFileUpload('file', 'user-logo', '', 'Your image/logo', '', $fileUpload_config, $current_file);

                $form->addHelper('If yes, the installer will add the tables and data from <a href="https://dev.mysql.com/doc/sakila/en/sakila-structure.html" target="_blank" rel="noopener">Sakila Database</a> to your ' . DBNAME . ' database', 'install-demo-db', 'after');
                $form->addRadio('install-demo-db', 'Yes', 1);
                $form->addRadio('install-demo-db', 'No', 0);
                $form->printRadioGroup('install-demo-db', 'Install the demo database?');

                $form->centerButtons(true);
                $form->setCols(-1, -1);
                $form->addBtn('submit', 'back-btn', 2, '<i class="' . ICON_ARROW_LEFT . ' prepend"></i> Back', 'class=btn btn-warning', 'btns');
                $form->addBtn('submit', 'submit-btn', 3, 'Next <i class="' . ICON_ARROW_RIGHT . ' append" aria-hidden="true"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'btns');
                $form->printBtnGroup('btns');
                $form->endFieldset();

                $form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'blue']);
            }
        } // End Not yet registered
    }
} else {
    exit('Installer is locked.');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP CRUD Generator Installer</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/ripple.min.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/stylesheets/generator.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet" type="text/css">
    <?php
    if (isset($form)) {
        $form->printIncludes('css', false, true, false);
    }
    ?>
    <style type="text/css">
        .bs-wizard {margin-top: 40px;}

        /* step Wizard - https://codepen.io/migli/pen/JBYVJB */

        .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
        .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #3f51b5; top: 47px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #ABB6F5; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
        .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
        .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; height: 8px; line-height: 20px; box-shadow: none; background: #3f51b5;}
        .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
        .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
        .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
        .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
        .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
        .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
        .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
        .bs-wizard .progress { overflow: hidden; background-color: #f5f5f5; }
    </style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-tall mb-5">
        <h4 class="ml-2 mb-0">PHP CRUD Generator</h4>
    </nav>
    <div class="container">

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($current_step)) {
            $class_step = array();
            $class_step[1] = 'active';
            $class_step[2] = 'disabled';
            $class_step[3] = 'disabled';
            $class_step[4] = 'disabled';

            if ($current_step > 1) {
                $class_step[1] = 'complete';
            }
            if ($current_step > 2) {
                $class_step[2] = 'complete';
            }
            if ($current_step > 3) {
                $class_step[3] = 'complete';
            }
            $class_step[$current_step] = 'active';
            ?>
        <div class="row bs-wizard mb-4">

            <div class="col-3 bs-wizard-step <?php echo $class_step[1]; ?>">
                <div class="text-center bs-wizard-stepnum">Step 1</div>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
                <a href="#" class="bs-wizard-dot"></a>
                <div class="bs-wizard-info text-center">Server compatibility</div>
            </div>

            <div class="col-3 bs-wizard-step <?php echo $class_step[2]; ?>">
                <div class="text-center bs-wizard-stepnum">Step 2</div>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
                <a href="#" class="bs-wizard-dot"></a>
                <div class="bs-wizard-info text-center">Database & Registration</div>
            </div>

            <div class="col-3 bs-wizard-step <?php echo $class_step[3]; ?>">
                <div class="text-center bs-wizard-stepnum">Step 3</div>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
                <a href="#" class="bs-wizard-dot"></a>
                <div class="bs-wizard-info text-center">Custom settings</div>
            </div>

            <div class="col-3 bs-wizard-step <?php echo $class_step[4]; ?>">
                <div class="text-center bs-wizard-stepnum">Step 4</div>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
                <a href="#" class="bs-wizard-dot"></a>
                <div class="bs-wizard-info text-center">Done</div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="row justify-content-md-center">
            <div class="col-md-11 col-lg-10 mb-4">
                <div class="card card-default">
                    <div class="card-header">
                        <?php
                        if (!isset($current_step) && ($already_registered === true || $just_unregistered === true)) {
                            ?>
                        PHPCG Installation - Unregister
                        <?php
                        } else {
                            ?>
                        PHPCG Installation - Step <?php echo $current_step ?> / 4
                        <div class="heading-elements">
                            <span class="badge badge-primary">Step <?php echo $current_step ?> / 4</span>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($form)) {
                            $form->render();
                        } elseif ($just_unregistered === true) {
                            ?>
                        <p class="lead text-center my-5">You can now reinstall on this server or any other.</p>
                        <p class="lead text-center my-5"><a href="do-install.php" class="btn btn-primary">Refresh<i class="<?php echo ICON_ARROW_RIGHT_CIRCLE; ?> ml-2"></i></a></p>
                        <?php
                        } elseif ($current_step == 1) {
                            ?>
                        <h3 class="text-center mb-5">Server settings</h3>
                        <table class="table table-striped">
                            <tbody>
                                <?php
                            $all_server_values_ok = true;
                            foreach ($user_server as $key => $array_values) {
                                $value_ok = '<i class="' . ICON_DELETE . ' text-danger mx-2"></i>';
                                $value_error_msg = $array_values['error_msg'];
                                if ($array_values['ok'] === true) {
                                    $value_ok = '<i class="' . ICON_CHECKMARK . ' text-success mx-2"></i>';
                                    $value_error_msg = '';
                                } elseif ($array_values['ok'] == 'warning') {
                                    $value_ok = '<i class="' . ICON_DELETE . ' text-warning mx-2"></i>';
                                } else {
                                    $all_server_values_ok = false;
                                }
                                ?>
                                <tr>
                                    <th><?php echo $array_values['label']; ?></th>
                                    <td><?php echo $array_values['value']; ?></td>
                                    <td><?php echo $value_ok . $value_error_msg; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                            if ($all_server_values_ok === true) {
                                ?>
                        <form action="do-install.php" method="POST">
                            <div class="text-center my-5">
                                <button type="submit" class="btn btn-lg btn-success" value="1">Next <i class="<?php echo ICON_ARROW_RIGHT; ?> append" aria-hidden="true"></i></button>
                            </div>
                        </form>
                        <?php
                            } // End if ($all_server_values_ok === true)
                        } elseif ($current_step == 4) {
                            ?>
                        <h3 class="text-center mb-5"><strong>PHPCG</strong> Installation Successful</h3>
                        <p class="lead text-center"><strong>If for some reason you have someday to uninstall/reinstall:</strong></p>
                        <div class="d-flex justify-content-center">
                            <ol class="text-left">
                                <li>Delete <code>install/install.lock</code></li>
                                <li>Open <code>install/do-install.php</code> to unregister your license</li>
                                <li>Refresh your page to reinstall</li>
                            </ol>
                        </div>
                        <p class="lead text-center my-5"><a href="<?php echo GENERATOR_URL ?>generator.php" class="btn btn-primary" target="_blank" rel="noopener">Open PHP Crud Generator Now<i class="<?php echo ICON_NEW_TAB; ?> ml-2"></i></a></p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/pace.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/ripple.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/fontawesome-all.min.js"></script>
    <?php
    if (isset($form)) {
        $form->printIncludes('js', false, true, false);
        $form->printJsCode();
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('input[name="db-target"]')[0]) {
                // if step form
                var $dbInput      = $('input[name="db-target"]'),
                    dbTargetValue = $dbInput.val();

                if(dbTargetValue == "undefined") {
                    dbTargetValue = 'localhost';
                    $dbInput.val(dbTargetValue);
                }

                $('.choose-db-target-radio').on('click', function() {
                    dbTargetValue = $(this).attr('id');
                    $dbInput.val(dbTargetValue).trigger('change');
                    $('.choose-db-target-radio.active').removeClass('bg-pink-500 active').addClass('bg-dark');
                    $('#' + dbTargetValue).removeClass('bg-dark').addClass('bg-pink-500 active');
                });

                $('#' + dbTargetValue).trigger('click');

                $('select[name="user-language"]').on('change', function() {
                    var target = $('#select-language-callback'),
                        selectedLanguage = $(this).val();
                    $.ajax({
                        url: 'select-language-callback.php',
                        type: 'POST',
                        data: {
                            'language': selectedLanguage
                        }
                    }).done(function(data) {
                        target.html(data);
                    }).fail(function(data, statut, error) {
                        console.log(error);
                    });
                });
            }
        });
    </script>
</body>

</html>
