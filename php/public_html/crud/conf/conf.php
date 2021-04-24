<?php

/* =============================================
    CORE DEFINITIONS - DON'T MODIFY ANYTHING
    USE THE 'GENERAL SETTINGS' form
    in the Generator
============================================= */

define('AUTHOR', 'Gilles Migliori');
define('VERSION', '1.11');

// path to conf folder
$root_path = dirname(dirname(__FILE__));

// reliable path to conf folder with symlinks resolved
$info = new \SplFileInfo($root_path);
$real_root_path = $info->getRealPath();

// sanitize root directory separator
$root = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $real_root_path) . DIRECTORY_SEPARATOR;

// ROOT is the path leading to the PHPCG folders (admin, generator, ...)
define('ROOT', $root);

$userConf = json_decode(file_get_contents(ROOT . 'conf/user-conf.json'));

/* Project BASE URL
-------------------------------------------------- */

$base_urls = getBaseUrls();

// Uncomment the following line to display the 2 returned values
// echo 'BASE_URL: ' . $base_urls['base_url'] . '<br>ROOT_RELATIVE_URL: ' . $base_urls['root_relative_url'] . '<br>';

// BASE_URL MUST lead to your project root url.
// This url MUST end with a slash.
// ie: define('BASE_URL', 'http://localhost/my-project/');
define('BASE_URL', $base_urls['base_url']);

// ROOT_RELATIVE_URL is the ROOT RELATIVE URL leading to you admin folder.
// This url MUST end with a slash.
define('ROOT_RELATIVE_URL', $base_urls['root_relative_url']);

define('ADMIN_DIR', ROOT . 'admin/');
define('CLASS_DIR', ROOT . 'class/');
define('GENERATOR_DIR', ROOT . 'generator/');

// backup dir must exist on your server
define('BACKUP_DIR', GENERATOR_DIR . 'backup-files/');

define('ADMIN_URL', BASE_URL . 'admin/');
define('ADMINLOGINPAGE', ADMIN_URL . 'login');
define('ADMINREDIRECTPAGE', ADMIN_URL . 'home');
define('ASSETS_URL', BASE_URL . 'assets/');
define('CLASS_URL', BASE_URL . 'class/');
define('GENERATOR_URL', BASE_URL . 'generator/');

/* Translation */

// the translation file MUST exist in /admin/i18n/
define('LANG', $userConf->lang);

if (!file_exists(ADMIN_DIR . 'i18n/' . LANG . '.php')) {
    exit('Language file doesn\'t exist: ' . ADMIN_DIR . 'i18n/' . LANG . '.php - Please read documentation and add your language to i18n');
} else {
    include_once ADMIN_DIR . 'i18n/' . LANG . '.php';
}

// Detect if we're on https://www.phpcrudgenerator.com's demo
$demo = false;
if (preg_match('`^www.phpcrudgenerator.com`', $_SERVER['HTTP_HOST'])) {
    $demo = true;
}
define('DEMO', $demo);

/*
    localhost :
        shows queries on database errors
    production :
        hide queries
*/

$environment = 'production';
$debug = false;

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    // localhost settings
    $environment = 'development';
    $debug       = true;
}
define('ENVIRONMENT', $environment);
define('DEBUG', $debug);

// datetime filedtypes for daterange filters
define('DATETIME_FIELD_TYPES', 'date,datetime,timestamp');

/* =============================================
    ICONS
============================================= */

define('ICON_ADDRESS', 'fas fa-map-marker-alt');
define('ICON_ARROW_DOWN', 'fas fa-angle-down');
define('ICON_ARROW_LEFT', 'fas fa-angle-left');
define('ICON_ARROW_RIGHT', 'fas fa-angle-right');
define('ICON_ARROW_UP', 'fas fa-angle-up');
define('ICON_ARROW_RIGHT_CIRCLE', 'far fa-arrow-alt-circle-right');
define('ICON_BACK', 'fas fa-long-arrow-alt-left');
define('ICON_CALENDAR', 'far fa-calendar');
define('ICON_CANCEL', 'fas fa-times');
define('ICON_CHECKMARK', 'fas fa-check');
define('ICON_CITY', 'far fa-building');
define('ICON_COMPANY', 'fas fa-id-card');
define('ICON_CONTACT', 'fas fa-phone');
define('ICON_COUNTRY', 'fas fa-flag');
define('ICON_DASHBOARD', 'fas fa-power-off');
define('ICON_DELETE', 'fas fa-times-circle');
define('ICON_EDIT', 'fas fa-pencil-alt');
define('ICON_ENVELOP', 'fas fa-envelope');
define('ICON_FILTER', 'fas fa-filter');
define('ICON_HOME', 'fas fa-home');
define('ICON_HOUR_GLASS', 'fas fa-hourglass-half');
define('ICON_INFO', 'fas fa-info-circle');
define('ICON_LINK', 'fas fa-link');
define('ICON_LIST', 'fas fa-list');
define('ICON_LOCK', 'fas fa-lock');
define('ICON_LOGOUT', 'fas fa-power-off');
define('ICON_LOGIN', 'fas fa-user-circle');
define('ICON_NEW_TAB', ' fas fa-external-link-alt');
define('ICON_PASSWORD', 'far fa-eye-slash');
define('ICON_PLUS', 'fas fa-plus-circle');
define('ICON_QUESTION', 'fas fa-question');
define('ICON_REFRESH', 'fas fa-sync');
define('ICON_RESET', 'fas fa-undo');
define('ICON_SEARCH', 'fas fa-search');
define('ICON_SPINNER', 'fas fa-spinner');
define('ICON_STOP', 'far fa-stop-circle');
define('ICON_TRANSMISSION', 'fas fa-exchange-alt');
define('ICON_UNLOCK', 'fas fa-unlock-alt');
define('ICON_UPLOAD', 'fas fa-upload');
define('ICON_USER', 'fas fa-user');
define('ICON_USER_PLUS', 'fas fa-user-plus');
define('ICON_ZIP_CODE', 'fas fa-location-arrow');

/* database connection */

include_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';

/* =============================================
    USER CONFIG
============================================= */

// Lock Generator with login page
define('GENERATOR_LOCKED', $userConf->generator_locked);

// set timezone
if (isset($userConf->timezone)) {
    define('TIMEZONE', $userConf->timezone);
} else {
    define('TIMEZONE', 'UTC');
}

date_default_timezone_set(TIMEZONE);

/* Admin panel settings
-------------------------------------------------- */

// Lock/Unlock admin panel with User Authentification
define('ADMIN_LOCKED', $userConf->admin_locked);

// Bootstrap theme
define('BOOTSTRAP_THEME', $userConf->bootstrap_theme);

// Admin panel main title
define('SITENAME', $userConf->sitename);

// date & time translations for lists
if (class_exists('Locale')) {
    Locale::setDefault($userConf->locale_default);
}

define('DATETIMEPICKERS_STYLE', $userConf->datetimepickers_style);
define('DATETIMEPICKERS_LANG', $userConf->datetimepickers_lang);

// Admin panel action buttons
define('ADMIN_ACTION_BUTTONS_POSITION', $userConf->admin_action_buttons_position);

// Admin panel auto-enable filters
define('AUTO_ENABLE_FILTERS', $userConf->auto_enable_filters);

// Admin panel logo
define('ADMIN_LOGO', $userConf->admin_logo);

// password contraint for users acounts
// available contraints in
// /class/phpformbuilder/plugins-config/passfield.xml
define('USERS_PASSWORD_CONSTRAINT', $userConf->users_password_constraint);

// Search results settings
define('PAGINE_SEARCH_RESULTS', $userConf->pagine_search_results);

// Sidebar settings
define('COLLAPSE_INACTIVE_SIDEBAR_CATEGORIES', $userConf->collapse_inactive_sidebar_categories);

/* Admin panel skin
-------------------------------------------------- */

define('DEFAULT_HEADER_CLASS', $userConf->default_header_class);
define('DEFAULT_SIDEBAR_USER_CLASS', $userConf->default_sidebar_user_class);
define('DEFAULT_BODY_CLASS', $userConf->default_body_class);
define('DEFAULT_CARD_CLASS', $userConf->default_card_class);
define('DEFAULT_CARD_HEADING_CLASS', $userConf->default_card_heading_class);
define('DEFAULT_CARD_FOOTER_CLASS', $userConf->default_card_footer_class);
define('DEFAULT_TABLE_HEADING_BACKGROUND', $userConf->default_table_heading_background);
define('DEFAULT_BUTTONS_BACKGROUND', $userConf->default_buttons_background);

/* =============================================
    Auto-detect base url
============================================= */

function getBaseUrls()
{
    // reliable document_root (https://gist.github.com/jpsirois/424055)
    $script_name     = str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['SCRIPT_NAME']);
    $script_filename = str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['SCRIPT_FILENAME']);
    $root_path       = str_replace($script_name, '', $script_filename);
    $conf_path       = rtrim(dirname(strtolower(dirname(__FILE__))), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    // reliable document_root with symlinks resolved
    $info = new \SplFileInfo($root_path);
    $real_root_path = strtolower($info->getRealPath());

    // defined root_relative url used in admin routing
    // ie: /my-dir/
    $root_relative_url = '/' . ltrim(
        str_replace(array($real_root_path, DIRECTORY_SEPARATOR), array('', '/'), $conf_path),
        '/'
    );
        // sanitize directory separator
        $base_url = (((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $root_relative_url;

    return array(
        'root_relative_url' => $root_relative_url,
        'base_url'          => $base_url
    );
}

/* =============================================
    Register the default autoloader implementation in the php engine.
============================================= */

function autoload($class)
{
    /* Define the paths to the directories holding class files */

    $paths = array(
        CLASS_DIR,
        ADMIN_DIR . 'class/',
        ADMIN_DIR . 'secure/'
    );
    foreach ($paths as $path) {
        $file = $path . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file) === true) {
            require_once $file;
            break;
        }
    }
}
spl_autoload_register('autoload');
