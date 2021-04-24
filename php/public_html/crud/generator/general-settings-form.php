<?php
use fileuploader\server\FileUploader;
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

if (!file_exists('../conf/conf.php')) {
    exit('Configuration file not found');
}
include_once '../conf/conf.php';

if (!file_exists(ROOT . 'conf/user-conf.json')) {
    exit('User Configuration file not found');
}
session_start();

// lock access on production server
if (ENVIRONMENT !== 'localhost' && GENERATOR_LOCKED === true) {
    include_once 'inc/protect.php';
}

include_once CLASS_DIR . 'phpformbuilder/Form.php';

// include the fileuploader
include_once CLASS_DIR . 'phpformbuilder/plugins/fileuploader/server/class.fileuploader.php';

$userConf = json_decode(file_get_contents(ROOT . 'conf/user-conf.json'));

/*=============================================
=             Set default values              =
=============================================*/

$default_values = array(
    'generator_locked'                     => false,
    'admin_locked'                         => false,
    'sitename'                             => 'PHP CRUD GENERATOR',
    'admin_logo'                           => 'logo-height-100.png',
    'bootstrap_theme'                      => 'default',
    'admin_action_buttons_position'        => 'left',
    'auto_enable_filters'                  => false,
    'lang'                                 => 'en',
    'locale_default'                       => 'en-GB',
    'datetimepickers_style'                => 'default',
    'datetimepickers_lang'                 => 'en_EN',
    'timezone'                             => 'UTC',
    'users_password_constraint'            => 'lower-upper-number-min-6',
    'collapse_inactive_sidebar_categories' => true,
    'pagine_search_results'                => true,
    'default_header_class'                 => '',
    'default_sidebar_user_class'           => '',
    'default_body_class'                   => 'bg-white',
    'default_card_class'                   => 'bg-white',
    'default_card_heading_class'           => 'bg-gray-100',
    'default_card_footer_class'            => 'bg-gray-100',
    'default_table_heading_background'     => 'bg-gray-dark',
    'default_buttons_background'           => 'bg-gray-200'
);

foreach ($default_values as $key => $value) {
    if (!isset($userConf->$key)) {
        $userConf->$key = $value;
    }
}

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('general-settings-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('general-settings-form');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['general-settings-form'] = $validator->getAllErrors();
    } else {
        $userConf->generator_locked = true;
        if (!isset($_POST['generator_locked'])) {
            $userConf->generator_locked = false;
        }
        $userConf->sitename = $_POST['sitename'];
        if (isset($_POST['admin_logo']) && !empty($_POST['admin_logo'])) {
            $posted_file        = FileUploader::getPostedFiles($_POST['admin_logo']);
            $current_file_name  = $posted_file[0]['file'];
            $userConf->admin_logo = $current_file_name;
        }
        $userConf->bootstrap_theme = $_POST['bootstrap_theme'];
        if ($_POST['lang'] != 'other') {
            $userConf->lang = $_POST['lang'];
        } else {
            $userConf->lang = $_POST['lang-other'];
        }
        if (isset($_POST['locale_default'])) {
            $userConf->locale_default = $_POST['locale_default'];
        }
        $userConf->datetimepickers_style = $_POST['datetimepickers_style'];

        if ($userConf->datetimepickers_style == 'default') {
            $userConf->datetimepickers_lang = $_POST['datetimepickers_lang'];
        } else {
            $userConf->datetimepickers_lang = $_POST['datetimepickers_material_lang'];
        }
        $userConf->timezone                      = $_POST['timezone'];
        $userConf->admin_action_buttons_position = $_POST['admin_action_buttons_position'];
        $userConf->auto_enable_filters           = false;
        if ($_POST['auto_enable_filters'] > 0) {
            $userConf->auto_enable_filters = true;
        }
        $userConf->collapse_inactive_sidebar_categories = false;
        if (isset($_POST['collapse_inactive_sidebar_categories'])) {
            $userConf->collapse_inactive_sidebar_categories = true;
        }
        $userConf->pagine_search_results = false;
        if ($_POST['pagine_search_results'] > 0) {
            $userConf->pagine_search_results = true;
        }
        $userConf->users_password_constraint            = $_POST['users_password_constraint'];
        $userConf->pagine_search_results                = $_POST['pagine_search_results'];
        $userConf->default_header_class                 = $_POST['default_header_class'];
        $userConf->default_sidebar_user_class           = $_POST['default_sidebar_user_class'];
        $userConf->default_body_class                   = $_POST['default_body_class'];
        $userConf->default_card_class                   = $_POST['default_card_class'];
        $userConf->default_card_heading_class           = $_POST['default_card_heading_class'];
        $userConf->default_card_footer_class            = $_POST['default_card_footer_class'];
        $userConf->default_table_heading_background     = $_POST['default_table_heading_background'];
        $userConf->default_buttons_background           = $_POST['default_buttons_background'];

        $user_conf = json_encode($userConf);
        if (DEMO !== true) {
            if (!file_put_contents(ROOT . 'conf/user-conf.json', $user_conf)) {
                $form_message = '<p class="alert alert-danger has-icon">' . ERROR_CANT_WRITE_FILE . ': ' . ROOT . 'conf/user-conf.json</p>';
            } else {
                $form_message = '<p class="alert alert-success has-icon">' . GENERAL_SETTINGS_SUCCESS_MESSAGE . '</p>';
                Form::clear('general-settings-form');
            }
        } else {
            $form_message = '<p class="alert alert-success has-icon">' . GENERAL_SETTINGS_SUCCESS_MESSAGE . ' (Disabled in DEMO)</p>';
            Form::clear('general-settings-form');
        }
    }
}
$form = new Form('general-settings-form', 'horizontal', 'novalidate');
$form->setMode('development');
$form->useLoadJs('core');

if (!isset($_SESSION['errors']['general-settings-form']) || empty($_SESSION['errors']['general-settings-form'])) { // If no error registered
    $_SESSION['general-settings-form']['generator_locked']              = $userConf->generator_locked;
    $_SESSION['general-settings-form']['sitename']                      = $userConf->sitename;
    $_SESSION['general-settings-form']['admin_logo']                    = $userConf->admin_logo;
    $_SESSION['general-settings-form']['bootstrap_theme']               = $userConf->bootstrap_theme;
    $available_languages = array('en', 'es', 'fr', 'it');
    if (in_array($userConf->lang, $available_languages)) {
        $_SESSION['general-settings-form']['lang'] = $userConf->lang;
    } else {
        $_SESSION['general-settings-form']['lang'] = 'other';
        $_SESSION['general-settings-form']['lang-other'] = $userConf->lang;
    }
    $_SESSION['general-settings-form']['locale_default']                       = $userConf->locale_default;
    $_SESSION['general-settings-form']['datetimepickers_style']                = $userConf->datetimepickers_style;
    if ($userConf->datetimepickers_style == 'default') {
        $_SESSION['general-settings-form']['datetimepickers_lang'] = $userConf->datetimepickers_lang;
        $_SESSION['datetimepickers_material_lang'] = '';
    } else {
        $_SESSION['general-settings-form']['datetimepickers_lang'] = '';
        $_SESSION['datetimepickers_material_lang'] = $userConf->datetimepickers_lang;
    }
    $_SESSION['general-settings-form']['timezone']                             = $userConf->timezone;
    $_SESSION['general-settings-form']['admin_action_buttons_position']        = $userConf->admin_action_buttons_position;
    $_SESSION['general-settings-form']['auto_enable_filters']                  = $userConf->auto_enable_filters;
    $_SESSION['general-settings-form']['users_password_constraint']            = $userConf->users_password_constraint;
    $_SESSION['general-settings-form']['pagine_search_results']                = $userConf->pagine_search_results;
    $_SESSION['general-settings-form']['collapse_inactive_sidebar_categories'] = $userConf->collapse_inactive_sidebar_categories;
    $_SESSION['general-settings-form']['default_header_class']                 = $userConf->default_header_class;
    $_SESSION['general-settings-form']['default_sidebar_user_class']           = $userConf->default_sidebar_user_class;
    $_SESSION['general-settings-form']['default_body_class']                   = $userConf->default_body_class;
    $_SESSION['general-settings-form']['default_card_class']                   = $userConf->default_card_class;
    $_SESSION['general-settings-form']['default_card_heading_class']           = $userConf->default_card_heading_class;
    $_SESSION['general-settings-form']['default_card_footer_class']            = $userConf->default_card_footer_class;
    $_SESSION['general-settings-form']['default_table_heading_background']     = $userConf->default_table_heading_background;
    $_SESSION['general-settings-form']['default_buttons_background']           = $userConf->default_buttons_background;
}

$form->startFieldset(MAIN_SETTINGS_TXT);

// generator_locked
$form->addHelper(LOCK_THE_GENERATOR_HELPER, 'generator_locked');
$form->addCheckbox('generator_locked', '', true, 'class=lcswitch, data-ontext=' . YES . ', data-offtext=' . NO . ', data-theme=blue');
$form->printCheckboxGroup('generator_locked', LOCK_THE_GENERATOR_TXT, false);

// site name
$form->addHelper(SITE_NAME_HELPER, 'sitename');
$form->addInput('text', 'sitename', '', SITE_NAME_TXT, 'required');

// admin logo

// reload the previously posted file if the form was posted with errors
$current_file = '';
if (isset($_POST['admin_logo']) && !empty($_POST['admin_logo'])) {
    $posted_file = FileUploader::getPostedFiles($_POST['admin_logo']);
    $current_file_name = $posted_file[0]['file'];
} else {
    $current_file_name = $userConf->admin_logo;
}
$current_file_path = ROOT . 'admin/assets/images/';
if (!empty($current_file_name) && file_exists($current_file_path . $current_file_name)) {
    $current_file_size = filesize($current_file_path . $current_file_name);
    $file_info = new finfo();
    $current_file_type = $file_info->file($current_file_path . $current_file_name, FILEINFO_MIME_TYPE);
    // $current_file_type = mime_content_type($current_file_path . $current_file_name);
    $current_file = array(
        'name' => $current_file_name,
        'size' => $current_file_size,
        'type' => $current_file_type,
        'file' => ADMIN_URL . '/assets/images/' . $current_file_name, // url of the file
        'data' => array(
            'listProps' => array(
            'file' => $current_file_name
            )
        )
    );
}

if ($_SERVER['HTTP_HOST'] !== 'www.phpcrudgenerator.com') {
    $fileUpload_config = array(
        'xml'           => 'image-upload',                          // the uploader's config in phpformbuilder/plugins-config/fileuploader.xml
        'uploader'      => 'ajax_upload_file.php',              // the uploader file in phpformbuilder/plugins/fileuploader/[xml]/php
        'upload_dir'    => ROOT . 'admin/assets/images/',   // the directory to upload the files. relative to [plugins dir]/fileuploader/image-upload/php/ajax_upload_file.php
        'limit'         => 1,                                       // max. number of files
        'file_max_size' => 5,                                       // each file's maximal size in MB {null, Number}
        'extensions'    => ['jpg', 'jpeg', 'png', 'gif'],           // allowed extensions
        'thumbnails'    => false,                                    // the thumbs directories must exist. thumbs config. is done in phpformbuilder/plugins/fileuploader/image-upload/php/ajax_upload_file.php
        'editor'        => true,                                    // allows the user to crop/rotate the uploaded image
        'width'         => 1000,                                     // the uploaded image maximum width
        'height'        => 100,                                     // the uploaded image maximum height
        'crop'          => false,
        'debug'         => true                                     // log the result in the browser's console and shows an error text on the page if the uploader fails to parse the json result.
    );
    $form->addHelper(ADMIN_LOGO_HELPER, 'admin_logo');
    if (is_array($current_file)) {
        $form->addFileUpload('file', 'admin_logo', '', ADMIN_LOGO_TXT, '', $fileUpload_config, $current_file);
    } else {
        $form->addFileUpload('file', 'admin_logo', '', ADMIN_LOGO_TXT, '', $fileUpload_config);
    }
}

// Bootstrap theme
$dir = new DirectoryIterator(ADMIN_DIR . 'assets/stylesheets/themes/');
foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $dirname = $fileinfo->getFilename();
        $form->addOption('bootstrap_theme', $dirname, ucfirst($dirname));
    }
}
$form->addSelect('bootstrap_theme', 'Bootstrap theme', 'class=select2, required');

$form->endFieldset();

$form->startFieldset(LANGUAGE_SETTINGS_TXT);

$form->addOption('lang', 'en', 'English');
$form->addOption('lang', 'es', 'Spanish');
$form->addOption('lang', 'it', 'Italian');
$form->addOption('lang', 'fr', 'French');
$form->addOption('lang', 'cs', 'Czech');
$form->addOption('lang', 'other', 'Other');
$form->addSelect('lang', LANGUAGE_TXT, 'class=select2, data-minimum-results-for-search=Infinity, required');

$form->startDependentFields('lang', 'other');
$form->addHelper(LANGUAGE_OTHER_HELPER, 'lang-other');
$form->addInput('text', 'lang-other', '', LANGUAGE_OTHER_TXT, 'required');
$form->endDependentFields();

if (class_exists('Locale')) {
    $locale = ResourceBundle::getLocales('');
    foreach ($locale as $value) {
        $value = str_replace('_', '-', $value);
        $form->addOption('locale_default', $value, $value);
    }
    $form->addHelper(DATE_TIME_TRANSLATIONS_FOR_LISTS_HELPER, 'locale_default');
    $form->addSelect('locale_default', DATE_TIME_TRANSLATIONS_FOR_LISTS_TXT, 'class=select2');
} else {
    $form->addHtml(NO_LOCALE);
}

// datetimepickers style
$form->addOption('datetimepickers_style', 'default', DEFAULT_CONST);
$form->addOption('datetimepickers_style', 'material', 'Material Design');
$form->addSelect('datetimepickers_style', 'Date &amp; Time pickers style', 'class=select2, data-minimum-results-for-search=Infinity');

// datetimepickers lang
$form->startDependentFields('datetimepickers_style', 'default');
$files = array_diff(scandir(CLASS_DIR . 'phpformbuilder/plugins/pickadate/lib/compressed/translations/'), array('.', '..'));
$form->addOption('datetimepickers_lang', 'en_EN', 'en_EN');
foreach ($files as $file) {
    $file = str_replace('.js', '', $file);
    $form->addOption('datetimepickers_lang', $file, $file);
}
$form->addHelper(DATETIMEPICKERS_LANG_HELPER, 'datetimepickers_lang');
$form->addSelect('datetimepickers_lang', DATETIMEPICKERS_LANG_TXT, 'class=select2');
$form->endDependentFields();

// datetimepickers material lang
$form->startDependentFields('datetimepickers_style', 'material');
$files = array_diff(scandir(CLASS_DIR . 'phpformbuilder/plugins/material-datepicker/dist/i18n/'), array('.', '..'));
foreach ($files as $file) {
    $file = str_replace('.js', '', $file);
    $form->addOption('datetimepickers_material_lang', $file, $file);
}
$form->addHelper(DATETIMEPICKERS_MATERIAL_LANG_HELPER, 'datetimepickers_material_lang');
$form->addSelect('datetimepickers_material_lang', DATETIMEPICKERS_LANG_TXT, 'class=select2');
$form->endDependentFields();

// timezone
$timezones = DateTimeZone::listIdentifiers();
$timezones_count = count($timezones);
for ($i=0; $i < $timezones_count; $i++) {
    $form->addOption('timezone', $timezones[$i], $timezones[$i]);
}
$form->addSelect('timezone', 'Timezone', 'class=select2');

$form->endFieldset();

$form->startFieldset(ADMIN_PANEL_SETTINGS_TXT);

$form->addRadio('admin_action_buttons_position', ON_THE_LEFT, 'left');
$form->addRadio('admin_action_buttons_position', ON_THE_RIGHT, 'right');
$form->printRadioGroup('admin_action_buttons_position', ADMIN_ACTION_BUTTONS_POSITION_TXT, true);

$form->addRadio('auto_enable_filters', ON_FILTER_BUTTON_CLICK_TXT, false);
$form->addRadio('auto_enable_filters', ON_SELECT_TXT, true);
$form->printRadioGroup('auto_enable_filters', ENABLE_FILTERS_TXT, true);

$password_contraints = array('lower-upper-min-', 'lower-upper-number-min-', 'lower-upper-number-symbol-min-');

foreach ($password_contraints as $constraint) {
    # code...
    for ($i=3; $i < 9; $i++) {
        $form->addOption('users_password_constraint', $constraint . $i, $constraint . $i);
    }
}
$form->addHelper(USERS_PASSWORD_CONSTRAINT_HELPER, 'users_password_constraint');
$form->addSelect('users_password_constraint', USERS_PASSWORD_CONSTRAINT_TXT, 'class=select2');

$form->addCheckbox('collapse_inactive_sidebar_categories', '', true, 'class=lcswitch, data-ontext=Yes, data-offtext=No, data-theme=blue');
$form->printCheckboxGroup('collapse_inactive_sidebar_categories', COLLAPSE_INACTIVE_SIDEBAR_CATEGORIES_TXT, false);

$form->addRadio('pagine_search_results', IN_A_PAGINATED_LIST , true);
$form->addRadio('pagine_search_results', ALL_ON_THE_SAME_PAGE, false);
$form->printRadioGroup('pagine_search_results', SHOW_SEARCH_RESULTS, true);
$form->endFieldset();

$form->startFieldset(ADMIN_SKIN_TXT);

$form->addHelper(DEFAULT_PAGE_HEADER_HELPER, 'default_header_class');
$form->addInput('text', 'default_header_class', '', DEFAULT_PAGE_HEADER_TXT);

$form->addHelper(DEFAULT_SIDEBAR_USER_HELPER, 'default_sidebar_user_class');
$form->addInput('text', 'default_sidebar_user_class', '', DEFAULT_SIDEBAR_USER_TXT);

$form->addHelper(DEFAULT_BODY_CLASS_HELPER, 'default_body_class');
$form->addInput('text', 'default_body_class', '', DEFAULT_BODY_CLASS_TXT);

$form->addHelper(DEFAULT_CARD_CLASS_HELPER, 'default_card_class');
$form->addInput('text', 'default_card_class', '', DEFAULT_CARD_CLASS_TXT);

$form->addHelper(DEFAULT_CARD_HEADING_CLASS_HELPER, 'default_card_heading_class');
$form->addInput('text', 'default_card_heading_class', '', DEFAULT_CARD_HEADING_CLASS_TXT);

$form->addHelper(DEFAULT_CARD_FOOTER_CLASS_HELPER, 'default_card_footer_class');
$form->addInput('text', 'default_card_footer_class', '', DEFAULT_CARD_FOOTER_CLASS_TXT);

$form->addHelper(DEFAULT_TABLE_HEADING_BACKGROUND_HELPER, 'default_table_heading_background');
$form->addInput('text', 'default_table_heading_background', '', DEFAULT_TABLE_HEADING_BACKGROUND_TXT);

$form->addHelper(DEFAULT_BUTTONS_BACKGROUND_HELPER, 'default_buttons_background');
$form->addInput('text', 'default_buttons_background', '', DEFAULT_BUTTONS_BACKGROUND_TXT);

$form->addBtn('button', 'load-skin', 1, '<i class="' . ICON_REFRESH . ' prepend"></i>' . LOAD_CURRENT_THEME_DEFAULT_SKIN, 'class=btn btn-sm btn-warning float-right');

$form->endFieldset();

$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' append"></i>', 'class=btn btn-success ladda-button, data-style=zoom-in');

$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'blue']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Generator - <?php echo GENERAL_SETTINGS; ?></title>
    <meta name="description" content="General settings for the Bootstrap Admin Panel - PHP CRUD Generator">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/ripple.min.css" media="screen"
        type="text/css" />
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/fa-svg-with-js.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/stylesheets/generator.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col col-md-10 my-5">
                <h1 class="mb-4">PHP CRUD Generator</h1>
                <div class="card card-default">
                    <div class="card-header">
                        <h2 class="card-title h4 text-semibold mb-0"><?php echo GENERAL_SETTINGS; ?></h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (DEMO === true) {
                            ?>
                        <div class="alert alert-info has-icon">
                            <p class="mb-0 h4">The <em>General Settings</em> form is disabled in this demo.</p>
                        </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($form_message)) {
                            echo $form_message;
                        }
                        $form->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/loadjs.min.js"></script>
    <script type="text/javascript">
    var adminUrl = '<?php echo ADMIN_URL; ?>';
    var generatorUrl = '<?php echo GENERATOR_URL; ?>';
    </script>
    <script type="text/javascript" src="<?php echo GENERATOR_URL; ?>generator-assets/javascripts/generator.js"></script>
    <script>
    let defaultSkins = {
        'cerulean': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-primary-600',
            'default_card_footer_class'       : 'bg-primary-600',
            'default_table_heading_background': 'bg-primary',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'cosmo': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-primary-600',
            'default_card_footer_class'       : 'bg-primary-600',
            'default_table_heading_background': 'bg-primary',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'cyborg': {
            'default_header_class'            : 'bg-primary-800',
            'default_sidebar_user_class'      : 'bg-primary-600',
            'default_body_class'              : 'bg-primary-100',
            'default_card_class'              : 'bg-white',
            'default_card_heading_class'      : 'bg-primary-600',
            'default_card_footer_class'       : 'bg-primary-600',
            'default_table_heading_background': 'bg-primary',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'darkly': {
            'default_header_class'            : 'bg-gray-800',
            'default_sidebar_user_class'      : 'bg-gray-800',
            'default_body_class'              : 'bg-gray-900',
            'default_card_class'              : 'bg-gray-800 text-white',
            'default_card_heading_class'      : 'bg-gray-700',
            'default_card_footer_class'       : 'bg-gray-700',
            'default_table_heading_background': 'bg-gray-dark',
            'default_buttons_background'      : 'bg-gray-600 text-white'
        },
        'default': {
            'default_header_class'            : '<?php echo $userConf->default_header_class; ?>',
            'default_sidebar_user_class'      : '<?php echo $userConf->default_sidebar_user_class; ?>',
            'default_body_class'              : '<?php echo $userConf->default_body_class; ?>',
            'default_card_class'              : '<?php echo $userConf->default_card_class; ?>',
            'default_card_heading_class'      : '<?php echo $userConf->default_card_heading_class; ?>',
            'default_card_footer_class'       : '<?php echo $userConf->default_card_footer_class; ?>',
            'default_table_heading_background': '<?php echo $userConf->default_table_heading_background; ?>',
            'default_buttons_background'      : '<?php echo $userConf->default_buttons_background; ?>'
        },
        'flatly': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary-400',
            'default_body_class'              : 'bg-white',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-primary-400',
            'default_card_footer_class'       : 'bg-primary-400',
            'default_table_heading_background': 'bg-primary-300',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'journal': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : 'bg-white',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-primary',
            'default_card_footer_class'       : 'bg-primary',
            'default_table_heading_background': 'bg-primary-300',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'litera': {
            'default_header_class'            : 'bg-primary-700',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-primary-600',
            'default_card_footer_class'       : 'bg-primary-600',
            'default_table_heading_background': 'bg-primary',
            'default_buttons_background'      : 'bg-primary-200'
        },
        'lumen': {
            'default_header_class'            : 'bg-gray-700',
            'default_sidebar_user_class'      : 'bg-gray-700',
            'default_body_class'              : 'bg-white',
            'default_card_class'              : 'bg-white',
            'default_card_heading_class'      : 'bg-gray-700',
            'default_card_footer_class'       : 'bg-gray-700',
            'default_table_heading_background': 'bg-gray-600 text-white',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'lux': {
            'default_header_class'            : 'bg-white',
            'default_sidebar_user_class'      : 'bg-gray-700',
            'default_body_class'              : 'bg-gray-100',
            'default_card_class'              : 'bg-white',
            'default_card_heading_class'      : 'bg-gray-700',
            'default_card_footer_class'       : 'bg-gray-700',
            'default_table_heading_background': 'bg-gray text-white',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'materia': {
            'default_header_class'            : 'bg-gray-700',
            'default_sidebar_user_class'      : 'bg-gray-700',
            'default_body_class'              : 'bg-gray-100',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-300',
            'default_card_footer_class'       : 'bg-gray-300',
            'default_table_heading_background': 'bg-gray text-white',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'minty': {
            'default_header_class'            : 'bg-success',
            'default_sidebar_user_class'      : 'bg-success',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-green-200'
        },
        'pulse': {
            'default_header_class'            : 'bg-purple',
            'default_sidebar_user_class'      : 'bg-purple',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-purple-200'
        },
        'sandstone': {
            'default_header_class'            : 'bg-gray-700',
            'default_sidebar_user_class'      : 'bg-gray-700',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'simplex': {
            'default_header_class'            : 'bg-gray-100',
            'default_sidebar_user_class'      : 'bg-gray-100',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'sketchy': {
            'default_header_class'            : 'bg-gray-100',
            'default_sidebar_user_class'      : 'bg-gray-100',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'slate': {
            'default_header_class'            : '',
            'default_sidebar_user_class'      : 'bg-secondary text-white',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-600',
            'default_card_footer_class'       : 'bg-gray-600',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-gray-200'
        },
        'solar': {
            'default_header_class'            : 'bg-success',
            'default_sidebar_user_class'      : 'bg-success',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : '',
            'default_card_footer_class'       : '',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-green-200'
        },
        'spacelab': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : '',
            'default_card_footer_class'       : '',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-blue-200'
        },
        'superhero': {
            'default_header_class'            : 'bg-info-700',
            'default_sidebar_user_class'      : 'bg-info-700',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-600',
            'default_card_footer_class'       : 'bg-gray-600',
            'default_table_heading_background': 'bg-gray-700',
            'default_buttons_background'      : 'bg-gray-600 text-white'
        },
        'united': {
            'default_header_class'            : 'bg-info-700',
            'default_sidebar_user_class'      : 'bg-info-700 text-white',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': 'bg-white',
            'default_buttons_background'      : 'bg-info-200'
        },
        'yeti': {
            'default_header_class'            : 'bg-primary',
            'default_sidebar_user_class'      : 'bg-primary',
            'default_body_class'              : '',
            'default_card_class'              : '',
            'default_card_heading_class'      : 'bg-gray-100',
            'default_card_footer_class'       : 'bg-gray-100',
            'default_table_heading_background': '',
            'default_buttons_background'      : 'bg-primary-200'
        }
    }
    loadjs.ready('core', function() {
        $('button[name="load-skin"]').on('click', function() {
            let theme = $('#bootstrap_theme').val();
            let skin = defaultSkins[theme];
            for (let [key, value] of Object.entries(skin)) {
                $('input[name="' + key + '"]').val(value);
            }
        });
    });
    </script>
    <?php
        $form->printJsCode('core');
    ?>
</body>

</html>
