<?php
namespace secure;

use secure\UsersRights;
use phpformbuilder\database\Mysql;
use common\Utils;

/**
 * Secure Class
 *
 * @version 1.0
 * @author Gilles Migliori - gilles.migliori@gmail.com
 *
 * USAGE
 *
 * (*) = redirect to login page on failure
 *
 *      --- Page requires authentification(*) :
 *      Secure::lock();
 *
 *      --- logout
 *      Secure::logout();
 *
 *      --- Page requires authentification AND FULL READ rights on specific table(*) :
 *      Secure::lock($table);
 *
 *      --- Page requires authentification AND RESTRICTED READ rights on specific table(*) :
 *      Secure::lock($table, 'restricted');
 *
 *      --- Allow part of page :
 *      if(Secure::canRead($table)) { // User can read ALL records
 *          [Do stuff here]
 *      }
 *
 *      if(Secure::canUpdate($table)) { // User can update ALL records
 *          [Do stuff here]
 *      }
 *
 *      // Same function for create/delete :
 *      if(Secure::canCreate($table)) { // User can create/delete ALL records
 *          [Do stuff here]
 *      }
 *
 *      if(Secure::canReadRestricted($table)) { // User can read ONLY RESTRICTED records
 *          [Do stuff here]
 *      }
 *
 *      if(Secure::canUpdateRestricted($table)) { // User can update ONLY RESTRICTED records
 *          [Do stuff here]
 *      }
 *
 *      // get additional query for restricted user rights - returns ' WHERE ...'
 *      Secure::getRestrictionQuery($table);
 *
 */

class Secure
{
    public static function encrypt($password)
    {
        include_once(ADMIN_DIR . 'secure/inc/password.php');
        $hash = password_hash($password, PASSWORD_BCRYPT);
        if (password_verify($password, $hash)) {
            return $hash;
        } else {
            /* Invalid */
            exit('Error during password encryption');
        }
    }

    /**
     * Lock page and redirect to the login page if needed
     * Logout and redirect to the login page if needed
     *
     * @param  string $table  optional table to restrict
     * @param  string $target null|self|all
     *                        user must have [restricted|all] READ rights on $table
     * @return void
     *
     */
    public static function lock($table = '', $target = 'all')
    {
        if (self::isLocked() === false) {
            return;
        }
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
            // logout
            self::logout();
        } else {
            if (!isset($_SESSION["admin_auth"]) || !isset($_SESSION["admin_random_hash"]) || !isset($_SESSION["admin_hash"]) ||  password_verify($_SESSION['admin_auth'] . $_SESSION['admin_random_hash'], $_SESSION["admin_hash"]) !== true || !isset($_SESSION['UsersRights'])) {
                // authentification failed
                header('Location: ' . ADMINLOGINPAGE);
                exit();
            } else {
                // authentification ok
                if (!empty($table)) {
                    // test users rights on current table
                    $UsersRights = self::loadUsersRights();
                    if (!is_object($UsersRights)) {
                        header('Location: ' . ADMINLOGINPAGE);
                        exit();
                    }
                    /*
                        Rights on each table :
                        0 : deny access
                        1 : use can access restricted records
                        2 : user can access all records
                    */

                    $minimum_rights = 2;
                    if ($target == 'restricted') {
                        $minimum_rights = 1;
                    }
                    if ($UsersRights->tables[$table]['can_read'] < $minimum_rights) {
                        // insuficient rights on given table
                        header('Location: ' . ADMINLOGINPAGE);
                        exit();
                    }
                }
            }
        }
    }

    /**
     * Log user
     * Register current user rights on each table
     * Redirect after login or if already logged.
     *
     */
    public static function testUser()
    {
        if (self::isLocked() === false) {
            return;
        }
        if (self::isUserConnected() === true) { // if user is already connected
            header('Location: ' . ADMINREDIRECTPAGE);
        }
        if (isset($_POST['login-form'])) { // if user has posted the login form
            // get users table name
            include_once ADMIN_DIR . 'secure/conf/conf.php';

            // test user
            $useremail    = Mysql::sqlValue($_POST['user-email'], Mysql::SQLVALUE_TEXT);
            $userpassword = $_POST['user-password'];
            $qry = 'SELECT ' . USERS_TABLE . '.ID, ' . USERS_TABLE . '.name, ' . USERS_TABLE . '.firstname, ' . USERS_TABLE . '.email, ' . USERS_TABLE . '.password, ' . USERS_TABLE . '.active, ' . USERS_TABLE . '_profiles.profile_name AS profiles_name FROM ' . USERS_TABLE . ' INNER JOIN ' . USERS_TABLE . '_profiles ON ' . USERS_TABLE . '.profiles_ID = ' . USERS_TABLE . '_profiles.ID WHERE email = ' . $useremail . ' LIMIT 1';
            $db = new Mysql();
            $db->query($qry);
            $db_count = $db->rowCount();
            if (!empty($db_count)) {
                $row = $db->row();
                if ($row->active < 1) {
                    self::userMessage(ACCOUNT_NOT_ACTIVATED, 'alert-warning has-icon');
                } else {
                    // text password
                    include_once(ADMIN_DIR . 'secure/inc/password.php');
                    if (password_verify($userpassword, $row->password)) {
                        /* LOG THE USER AS ADMIN */

                        $user_ID                               = $row->ID;
                        $_SESSION['secure_user_ID']            = $row->ID;
                        $_SESSION['secure_user_name']          = $row->name;
                        $_SESSION['secure_user_firstname']     = $row->firstname;
                        $_SESSION['secure_user_profiles_name'] = $row->profiles_name;
                        $_SESSION['admin_auth']                = $row->email;
                        $_SESSION['admin_random_hash']         = self::generateRandomString();
                        $_SESSION['admin_hash']                = self::encrypt($_SESSION['admin_auth'] . $_SESSION['admin_random_hash']);

                        /* Register current user rights on each table */

                        include_once ADMIN_DIR . 'secure/class/secure/UsersRights.php';
                        $UsersRights = new UsersRights($user_ID);

                        $_SESSION['UsersRights'] = serialize($UsersRights);
                        header('Location: ' . ADMINREDIRECTPAGE);
                    } else {
                        self::userMessage(LOGIN_ERROR, 'alert-danger has-icon');
                    }
                }
            } else {
                self::userMessage(LOGIN_ERROR, 'alert-danger has-icon');
            }
        }
    }

    /**
     * test if user is logged
     * @return boolean
     */
    public static function isUserConnected()
    {
        if (isset($_SESSION["admin_auth"]) && isset($_SESSION["admin_random_hash"]) && isset($_SESSION["admin_hash"]) && password_verify($_SESSION['admin_auth'] . $_SESSION['admin_random_hash'], $_SESSION["admin_hash"]) === true && isset($_SESSION['UsersRights'])) { // if user is already connected
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can read ALL records
     */
    public static function canRead($table)
    {
        if (self::isLocked() === false) {
            return true;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_read'] == 2) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can update ALL records
     */
    public static function canUpdate($table)
    {
        if (self::isLocked() === false) {
            return true;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_update'] == 2) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can create ALL
     */
    public static function canCreate($table)
    {
        if (self::isLocked() === false) {
            return true;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_create_delete'] == 2) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can read Restricted records
     */
    public static function canReadRestricted($table)
    {
        if (self::isLocked() === false) {
            // not restricted if not locked
            return false;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_read'] == 1) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can update Restricted records
     */
    public static function canUpdateRestricted($table)
    {
        if (self::isLocked() === false) {
            // not restricted if not locked
            return false;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_update'] == 1) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  string       $table
     * @return Boolean      true if user can create/delete Restricted records
     */
    public static function canCreateRestricted($table)
    {
        if (self::isLocked() === false) {
            // not restricted if not locked
            return false;
        }
        $UsersRights = self::loadUsersRights();
        if (in_array($table, $UsersRights->tables) && $UsersRights->tables[$table]['can_create_delete'] == 1) {
            return true;
        }

        return false;
    }

    public static function getRestrictionQuery($table)
    {
        if (self::isLocked() === false) {
            // not restricted if not locked
            return '';
        }
        $UsersRights = self::loadUsersRights();
        $find = array('CURRENT_USER_ID');
        $replace = array($_SESSION['secure_user_ID']);

        return ' ' . str_replace($find, $replace, $UsersRights->tables[$table]['constraint_query']);
    }

    /**
     * Logout the user
     *
     */
    public static function logout()
    {
        session_destroy();
        header("Location: " . ADMINLOGINPAGE);
        exit;
    }

    /**
     * Test if ADMIN_LOCKED
     *
     * @return Boolean
     */
    private static function isLocked()
    {
        return ADMIN_LOCKED;
    }

    /**
     * load userRights object from session
     * @return object userRights
     */
    private static function loadUsersRights()
    {
        include_once ADMIN_DIR . 'secure/class/secure/UsersRights.php';
        if (!isset($_SESSION['UsersRights'])) {
            self::logout();
        }
        $UsersRights = unserialize($_SESSION['UsersRights']);
        if (!is_object($UsersRights)) {
            self::logout();
        }

        return $UsersRights;
    }

    private static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * register output message for user
     * @param  string $msg       message html content
     * @param  string $classname Boootstrap alert class (alert-success, alert-primary, alert-warning, alert-danger)
     * @return void
     */
    public static function userMessage($msg, $classname)
    {
        if (!isset($_SESSION['msg'])) {
            $_SESSION['msg'] = '';
        }
        $_SESSION['msg'] .= Utils::alert($msg, $classname);
    }
}
