<?php
use bootstrap\Sidebar\sidebar;
use crud\ElementsUtilities;
use common\Utils;
use secure\Secure;

include_once CLASS_DIR . '/bootstrap/sidebar/Sidebar.php';
include_once CLASS_DIR . '/common/Utils.php';

$json = file_get_contents('crud-data/nav-data.json');
$sidebar_data = json_decode($json, true);

$json = file_get_contents('crud-data/db-data.json');
$db_data = json_decode($json, true);

$sidebar = new Sidebar('sidebar-main', 'sidebar-default');

$user_identity = 'User Name';
$user_profile = 'Profile';
if (ADMIN_LOCKED === true) {
    $user_identity = ucfirst($_SESSION['secure_user_firstname'] . ' ' . $_SESSION['secure_user_name']);
    $user_profile = ucfirst($_SESSION['secure_user_profiles_name']);
}

// Sidebar top content
$sidebar->addCategory('sidebar-user', '', $user_identity, $user_profile);

if (!empty($object->filters_form)) {
    $sidebar->addCategory('sidebar-filters', FILTER_LIST, '', '', true);
    $sidebar->sidebarFilters->addNav('sidebar-filters-nav', 'nav flex-column');
    $sidebar->sidebarFilters->sidebarFiltersNav->addLink('', $object->filters_form);
}

if (!empty($sidebar_data)) {
    // Sidebar Categories
    foreach ($sidebar_data as $sidebar_category => $category_data) {
        $has_content              = false;
        $is_category_collapsed    = true;
        $category_items           = array();
        $sanitized_name           = Utils::sanitize($category_data['name']); // lowercase with '-' instead of spaces
        $camelcased_name          = Utils::camelCase($category_data['name']);
        $sanitized_nav_name       = Utils::sanitize('sidebar-' . $sanitized_name . '-nav'); // lowercase with '-' instead of spaces
        $camelcased_nav_name      = Utils::camelCase('sidebar-' . $sanitized_name . '-nav');

        $tables_count = count($category_data['tables']);

        // Sidebar categories items
        for ($i=0; $i < $tables_count; $i++) {
            $table       = $category_data['tables'][$i];
            $is_disabled = $category_data['is_disabled'][$i];

            if ($is_disabled !== 'true') {
                $sidebar_label = $db_data[$table]['table_label'];
                $sidebar_item  = $db_data[$table]['item'];
                $sidebar_icon  = $db_data[$table]['icon'];

                // secure access (minimum rights required = restricted)
                if (Secure::canReadRestricted($table) || Secure::canRead($table)) {
                    $has_content = true;

                    $active = false;
                    if (isset($match['params']['item']) && $match['params']['item'] == $sidebar_item) {
                        $active = true;
                        $is_category_collapsed = false;
                    }
                    $category_items[] = array(
                        'link'   => ADMIN_URL . $sidebar_item,
                        'label'  => $sidebar_label,
                        'icon'   => $sidebar_icon,
                        'active' => $active
                    );
                }
            }
        }

        if ($has_content === true) {
            // add category
            $sidebar->addCategory($sanitized_name, $category_data['name'], '', '', true, $is_category_collapsed);

            // add nav into category
            $sidebar->$camelcased_name->addNav($sanitized_nav_name, 'nav flex-column');

            // add items into nav
            foreach ($category_items as $key => $nav_item) {
                $sidebar->$camelcased_name->$camelcased_nav_name->addLink($nav_item['link'], $nav_item['label'], $nav_item['icon'], $nav_item['active'], 'class=nav-item', 'class=nav-link d-flex align-items-center');
            }
        }
    }
}
