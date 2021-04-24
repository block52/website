<?php
namespace secure;

use crud\ElementsUtilities;
use common\Utils;
use phpformbuilder\database\Mysql;

/**
 * Secure Class
 * Manage users rights according to users profiles
 *
 * Rights on each table :
 * 0 : deny access
 * 1 : use can access restricted records
 * 2 : user can access all records
 *
 * @version 1.0
 * @author Gilles Migliori - gilles.migliori@gmail.com
 *
 */

class UsersRights
{
    public $tables = array();

    public function __construct($user_ID)
    {

        // get items used in admin
        $json     = file_get_contents(ADMIN_DIR . 'crud-data/nav-data.json');
        $nav_data = json_decode($json, true);

        // get tables names from items
        $json     = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
        $db_data  = json_decode($json, true);
        // Sidebar Categories
        foreach ($nav_data as $nav_category => $category_data) {
            foreach ($category_data['tables'] as $table) {
                if (array_key_exists($table, $db_data)) {
                    // if table is registered in db_data (=> read list has been built)
                    $this->tables[] = $table;
                }
            }
        }
        $qry = 'SELECT ' . USERS_TABLE . '_profiles.* FROM ' . USERS_TABLE . ' INNER JOIN ' . USERS_TABLE . '_profiles ON ' . USERS_TABLE . '.profiles_ID = ' . USERS_TABLE . '_profiles.ID WHERE ' . USERS_TABLE . '.ID = ' . $user_ID . ' LIMIT 1';
        $db = new Mysql();
        $db->query($qry);
        $db_count = $db->rowCount();
        if (!empty($db_count)) {
            $row = $db->row();
            // var_dump($this->tables);
            // exit;
            foreach ($this->tables as $table) {
                $current                      = array();
                $read_row                     = 'read_' . $table;
                $update_row                   = 'update_' . $table;
                $create_delete_row            = 'create_delete_' . $table;
                $constraint_query_row         = 'constraint_query_' . $table;

                if (!isset($row->$read_row)) {
                    // Error : current table has been added to admin panel but hasn't been installed in SECURE
                    $content = str_replace('%TABLE%', $table, MISSING_TABLE_IN_AUTHENTIFICATION_MODULE);
                    $_SESSION['msg'] = Utils::alert($content, 'alert-danger has-icon');

                    unset($_SESSION['admin_auth']);
                    unset($_SESSION['admin_random_hash']);
                    unset($_SESSION['admin_hash']);
                    unset($_SESSION['users_rights']);
                    header('Location: ' . ADMINLOGINPAGE);
                    exit();
                } else {
                    $current['can_read']          = $row->$read_row;
                    $current['can_update']        = $row->$update_row;
                    $current['can_create_delete'] = $row->$create_delete_row;
                    $current['constraint_query']  = $row->$constraint_query_row;
                }

                $this->tables[$table] = $current;
            }
        }
    }
}
