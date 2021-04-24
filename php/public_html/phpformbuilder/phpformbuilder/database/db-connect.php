<?php

/* database connection */

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    define('DBUSER', 'floattheflop_master');
    define('DBPASS', 'T!IxiNdR,L8pBQjrGt');
    define('DBHOST', 'localhost');
    define('DBNAME', 'floattheflop_main');
} else {
    define('DBUSER', 'floattheflop_master');
    define('DBPASS', 'T!IxiNdR,L8pBQjrGt');
    define('DBHOST', 'localhost');
    define('DBNAME', 'floattheflop_main');
}
define('DB', 'mysql:host=' . DBHOST . ';dbname=' . DBNAME);
