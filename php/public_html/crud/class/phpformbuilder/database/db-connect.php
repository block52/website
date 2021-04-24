<?php

/* database connection */

if (ENVIRONMENT == 'development') {
    define('DBUSER', '%localhost-user%');
    define('DBPASS', '%localhost-pass%');
    define('DBHOST', '%localhost-host%');
    define('DBNAME', '%localhost-name%');
} else {
    define('DBUSER', 'floattheflop_master');
    define('DBPASS', 'T!IxiNdR,L8pBQjrGt');
    define('DBHOST', 'localhost');
    define('DBNAME', 'floattheflop_player_portal');
}
define('DB', 'mysql:host=' . DBHOST . ';dbname=' . DBNAME);
