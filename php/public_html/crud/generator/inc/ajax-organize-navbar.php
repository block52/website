<?php
use generator\Generator;
use common\Utils;

if (!file_exists('../../conf/conf.php')) {
    exit('Configuration file not found (6)');
}
include_once '../../conf/conf.php';
include_once GENERATOR_DIR . 'class/generator/Generator.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['navCats']) && isset($_POST['tablesIcons']) && isset($_SESSION['generator']) && DEMO !== true) {
    if (!file_exists(ADMIN_DIR . 'crud-data/nav-data.json')) {
        echo Utils::alert(FILE_NOT_FOUND . ': ' . ADMIN_DIR . 'crud-data/nav-data.json', 'alert-danger has-icon');
    } elseif (!file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
        echo Utils::alert(FILE_NOT_FOUND . ': ' . ADMIN_DIR . 'crud-data/db-data.json', 'alert-danger has-icon');
    } else {
        // nav data (admin/crud-data/nav-data.json)
        $generator = $_SESSION['generator'];
        $dir              = ADMIN_DIR . 'crud-data/';
        $file             = 'nav-data.json';
        $dir_path[]       = $dir;
        $file_name[]      = $file;

        $nav_cats = $_POST['navCats'];
        foreach ($nav_cats as $key => $cat) {
            if (!isset($cat['tables'])) {
                unset($nav_cats[$key]);
            }
        }
        $nav_cats = array_values($nav_cats);
        $generator->registerAdminFile($dir, $file, json_encode($nav_cats, JSON_UNESCAPED_UNICODE));

        // register icons in crud-data/db-data.json + current icon in generator table
        $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
        $db_data = json_decode($json, true);

        foreach ($_POST['tablesIcons'] as $table => $icon) {
            if ($table == $generator->table) {
                $generator->table_icon = $icon;
            }
            $db_data[$table]['icon'] = $icon;
        }
        $json = json_encode($db_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = 'db-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $generator->registerAdminFile($dir, $file, $json);
        $_SESSION['generator'] = $generator;
        echo Utils::alert(CHANGES_RECORDED, 'alert-success has-icon');
        echo '<button type="button" class="btn btn-outline-primary my-4" onclick="window.location.reload();"><i class="' . ICON_REFRESH . ' mr-3"></i>' . CLICK_TO_REFRESH . '</button>';
    }
} elseif (DEMO === true) {
    echo Utils::alert('Feature disabled in DEMO', 'alert-danger has-icon');
} else {
    echo Utils::alert(SESSION_EXPIRED, 'alert-danger has-icon');
}
