<?php 
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 06.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
/* Load Settings */
if(isLogged()){
# Back-end Area Admin ID
	$SDR_LOG_AUTH = $db->where('session_token=?',array($_COOKIE['caledonian']))->getOne('users');
	if($db->count==0){header('Location: login.php');die();}
	define('CAL_AUTH_PUB_ID',$SDR_LOG_AUTH['user_id']);
	define('CAL_AUTH_MODE',$SDR_LOG_AUTH['admin_mod']);
	define('CAL_AUTH_ID',$SDR_LOG_AUTH['user_id']);
	define('CAL_AUTH_NAME',$SDR_LOG_AUTH['full_name']);
	define('CAL_AUTH_REG_DATE',$SDR_LOG_AUTH['add_date']);
	define('CAL_AUTH_LAST_LOGIN',$SDR_LOG_AUTH['last_login']);
	define('CAL_VIEW_MODE',((CAL_AUTH_MODE!=1) ? $SDR_LOG_AUTH['view_mode']:0)); # 0 - Show All Data, 1 - Only User Specfic Datas
}else{
	header('Location: login.php');
	die();
}
?>