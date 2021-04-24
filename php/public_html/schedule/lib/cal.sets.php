<?php
/*  +------------------------------------------------------------------------+ */
/*  | Artlantis CMS Solutions                                                | */
/*  +------------------------------------------------------------------------+ */
/*  | Caledonian PRO PHP Event Calendar                                      | */
/*  | Copyright (c) Artlantis Design Studio 2015. All rights reserved.       | */
/*  | Version       2.5                                                      | */
/*  | Last modified 28.09.2020                                               | */
/*  | Email         developer@artlantis.net                                  | */
/*  | Web           http://www.artlantis.net                                 | */
/*  +------------------------------------------------------------------------+ */

# General Settings
$CAL_SETS['cal_set_default_timezone'] = 'Australia/Sydney';
$CAL_SETS['cal_set_default_language'] = 'en';
$CAL_SETS['cal_set_app_url'] = 'https://www.float-the-flop.com/schedule/';
$CAL_SETS['cal_set_sysmail'] = 'support@float-the-flop.com';
$CAL_SETS['cal_set_max_upcoming'] = 200;
$CAL_SETS['cal_set_file_size'] = 2097152;
$CAL_SETS['cal_set_api_public'] = '99173b416a875bd6dd3cc0069671fd1e';
$CAL_SETS['cal_set_api_private'] = '64cbd8d06b751a28739ea169f0a7955f';
$CAL_SETS['cal_set_share_buttons'] = 0;
$CAL_SETS['cal_set_show_creator'] = 0;
$CAL_SETS['cal_set_pointips'] = 0;
$CAL_SETS['cal_set_debug_mode'] = 0;
$CAL_SETS['cal_set_seo_links'] = 0;
$CAL_SETS['cal_set_license_key'] = '8bbfbfae-651d-423e-bc09-1ed370c137d2';


foreach($CAL_SETS as $k=>$v){if(!defined($k)){define($k,$v);}}
?>