<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 30.06.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
ob_start();
header("Content-Type: text/html; charset=UTF-8");
$errText = null;
define('CAL_FULL_NAME','Caledonian PRO PHP Event Calendar');
define('CAL_VERSION','2.5');

/* Path Info */
define('CAL_APP',dirname(__FILE__)); # Caledonian Directory
define('CAL_APP_ADMIN',CAL_APP.DIRECTORY_SEPARATOR.'admin'); # Caledonian Admin Directory
define('CAL_LANGUAGES',CAL_APP.DIRECTORY_SEPARATOR.'languages'); # Caledonian Language Files

/* General Settings */
$CAL_SETS = array();
include_once('lib/cal.sets.php'); # Caledonian System Settings (Writable)

/* Default Settings */
date_default_timezone_set(cal_set_default_timezone); # Caledonian System Timezone
define('DEFAULT_LANG',cal_set_default_language); # Caledonian Default Language
$cnsLang = ((!isset($_COOKIE["slang"]) || is_null($_COOKIE["slang"])) ? DEFAULT_LANG:$_COOKIE["slang"]);
define('DEMO_MODE',0); # Demo Mode On/Off
define('CAL_POWERED','Artlantis Design Studio');
define('DEMO_TODAY','2015-07-24 23:43:00');

/* Error Handling */
error_reporting((cal_set_debug_mode) ? E_ALL:0);
ini_set('display_errors', (cal_set_debug_mode) ? '1':'0');

/* Language Loader */
include_once(CAL_LANGUAGES.'/sirius_conf.php');
$sirius->loadLanguages();

/* Common Settings */
include_once('lib/common.php');

/* Database Configurations */
include_once('lib/cal.config.php');

/* Database Connection */
require_once ('lib/MysqliDb.php');
$myconn = new mysqli(db_host,db_login,db_pass,db_name) or die('DB Connection Error');
$myconn->set_charset('utf8');
$db = new MysqliDb ($myconn);
$db->setPrefix(db_table_pref);

/* Load Functions */
require_once('lib/functions.php');

/* Load Sidera Class */
include_once('lib/class.caledonian.php');
?>