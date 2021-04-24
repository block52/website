<?php
/* =============================================
    Database connection test

    1. Replace 'host', 'user', 'pass', 'dbname' with your database connection settings
    2. Replace 'dbtable' with a table name from your database
    3. Open this file from in browser

    If the connection is successful you should see each column from your table displayed as Object
    Else you probably entered wrong connection settings.
============================================= */
use phpformbuilder\database\Mysql;

error_reporting('E_ALL');
ini_set('display_errors', 1);

define('DBHOST', 'host');
define('DBUSER', 'user');
define('DBPASS', 'pass');
define('DBNAME', 'dbname');

define('DBTABLE', 'dbtable');

include_once '../class/phpformbuilder/database/Mysql.php';

$db = new Mysql(true, DBNAME, DBHOST, DBUSER, DBPASS);
$db->selectDatabase(DBNAME);
$qry = 'SHOW COLUMNS FROM ' . DBTABLE;
$db->query($qry);
echo $db->getLastSql();
$columns_count = $db->rowCount();
if (!empty($columns_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        var_dump($row);
    }
}
