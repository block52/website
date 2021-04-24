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

/* MySQL Prepare */
	function mysql_prep($v){
		global $myconn;
		$v = trim($v);
		$v = $myconn->real_escape_string($v);
		
		return $v;
	}

/* Output Data */
	function showIn($v,$pl=''){
		

		
			if($pl=='page') { $v = htmlspecialchars($v,ENT_QUOTES,'UTF-8'); }
			else if($pl=='input'){$v = htmlspecialchars($v,ENT_COMPAT,'UTF-8'); }
			else if($pl=='htmledit'){$v = htmlspecialchars($v,ENT_COMPAT,'UTF-8'); }
			else if($pl=='textarea'){$v = htmlspecialchars($v,ENT_COMPAT,'UTF-8'); }
			else if($pl=='sconf'){$v = htmlspecialchars($v,ENT_QUOTES,'UTF-8'); }
			else if($pl=='urle'){$v = rawurlencode($v); }
			else if($pl=='urld'){$v = rawurldecode($v); }
			else if($pl=='decode') { $v = htmlspecialchars_decode($v); }

		
		return $v;
		
	}
	
/* Bullet Maker */
function getBullets($v){
	if($v==0){
		return '<span class="glyphicon glyphicon-remove text-danger"></span>';
	}else if($v==1){
		return '<span class="glyphicon glyphicon-ok text-success"></span>';
	}else if($v==2){
		return '<span class="glyphicon glyphicon-ok text-warning"></span>';
	}
}

/* Random Password */
function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
    return substr( str_shuffle( $chars ), 0, $length );
}

/* Demo Mode Checker */
	function isDemo($po){
		$cp = 0;
		$po = explode(',',$po);
		foreach($po as $k){
			if(isset($_POST[$k])){
				if(DEMO_MODE){
					$cp=1;
				}
			}
		}
		if($cp==1){
			unset($_POST);
			return false;
		}else{
			return true;
		}
	}
	
/* Selectbox and Checkbox Marker */
	function formSelector($f1,$f2,$ty){
		# f1 - First Option
		# f2 - Second Option
		# ty - Form Type (0=Selectbox, 1=Checkbox, 2=Radio, 3=Link, 4=Required, 5=Array values)
		if($ty==0){$cc = ' selected';}
		elseif($ty==1){$cc = ' checked';}
		elseif($ty==2){$cc = ' checked';}
		elseif($ty==3){$cc = ' class="selected-link"';}
		elseif($ty==4){$cc = ' required';}
		elseif($ty==5){
			if(is_array($f1)){
				if(in_array($f2,$f1)){
					return ' selected';
				}else{
					return '';
				}
			}else{
				return '';
			}
		}
		if($f1==$f2){return $cc;} else {return '';}
	}
	
/* Error Ouput */
function errMod($t,$m){

	$r = '<div class="alert alert-'. $m .' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'. $t .'</div>';
	
	return $r;

}

/* Encryption */
function encr($t){

	$t = md5('betelgeuse'.sha1(sha1(sha1($t))));
	return $t;

}

/* E-Mail Validation */
	function mailVal($v){
		if (!filter_var($v, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		else {return true;}
	}
	
/* Date Types */
function setMyDate($d,$t){

	global $CAL_DATE_VALUES;
	$err = 0;
	$d = strtotime($d);
	if(date('Y',$d)=='1970'){$err=1;}
	
	switch($t){
	
		case 1 : $d = date('d.m.Y',$d); break; # 30.06.2014
		case 2 : $d = date('d.m.Y H:i:s A',$d); break; # 30.06.2014 08:13:47
		case 3 : $d = convDat(date('n',$d),0,'months') . date(' d Y, H:s A',$d); break; # March 10, 2001, 5:16 pm
		//case 4 : $d = time_elapsed($d); break; # x time ago
		case 4 : $d = tago($d); break; # x time ago
		case 5 : $d = time_elapsed($d); break; # remaning time
		case 6 : $d = date('Y/m/d H:i:s',$d); break; # 2014/01/18 08:13:47 Used for JS counter
		case 7 : $d = date('d',$d) . ' '. $CAL_DATE_VALUES['months'][date('n',$d)] .' ' .date('Y',$d); break; # 21 May 2015
		case 8 : $d = '<sup><i class="fa fa-calendar"></i></sup> '.date('d',$d) . ' '. $CAL_DATE_VALUES['months'][date('n',$d)] .' ' .date('Y',$d).' <sup><i class="fa fa-clock-o"></i></sup> '.date('H:i A',$d); break; # 21 May 2015 00:00 A
		default : $d = date('d.m.Y',$d); break;
	
	}
	
	if($err){
		return '-';
	}else{
		return $d;
	}

}

/* Isset and Not Empty */
function isseter($v,$t=0,$m=0){

	# $v - Data, $t - Type (0-Text,1-Num), $m - Method (0-Post,1-Get)
	
	if($m==0){ # Post
		if($t==0){
			if(!isset($_POST[$v]) || empty($_POST[$v])){return false;}else{return true;}
		}else if($t==1){
			if(!isset($_POST[$v]) || !is_numeric($_POST[$v])){return false;}else{return true;}
		}
	}else if($m==1){ # Get
		if($t==0){
			if(!isset($_GET[$v]) || empty($_GET[$v])){return false;}else{return true;}
		}else if($t==1){
			if(!isset($_GET[$v]) || !is_numeric($_GET[$v])){return false;}else{return true;}
		}
	}

}

/* Admin Val Controller */
function isLogged(){

	global $db;
	if(!isset($_COOKIE['caledonian']) || empty($_COOKIE['caledonian'])){
		return false;
	}else{
		$db->where('session_token=?',array($_COOKIE['caledonian']))->getOne('users');
		if($db->count==0){return false;}else{return true;}
	}

}

/* Sidera Helper */
function sh($hc){
	return ((cal_set_pointips) ? '<a href="javascript:;" class="shd-mh" data-shd-key="'. $hc .'" tabindex="-1"><i class="glyphicon glyphicon-question-sign"></i></a> ':'');
}

/* Too Short / Long */
function isToo($v,$t='',$min=3,$max=50){

	if(strlen($v)<=$min){return showIn($t,'page') . calglb_too_short;}
	else if(strlen($v)>=$max){return showIn($t,'page') . calglb_too_long;}
	else{return '';}
}

# Get User
function getUser($v,$d){
	
	global $db;
	
	if($d==1){ # Get Username by ID
		
		$getUser = $db->where('user_id=?',array($v))->getOne('users');
		if($db->count==0){
			return '-';
		}else{
			return $getUser['full_name'];
		}
		
	}
	else if($d==2){ # Get Public Key by ID
		
		$getUser = $db->where('user_id=?',array($v))->getOne('users');
		if($db->count==0){
			return '-';
		}else{
			return $getUser['public_key'];
		}
		
	}
	else if($d==3){ # Get ID by Public Key
		
		$getUser = $db->where('public_key=?',array($v))->getOne('users');
		if($db->count==0){
			return 0;
		}else{
			return $getUser['user_id'];
		}
		
	}
	
}

/* Timezone Creator */
function timezone_list() {
    static $timezones = null;
	
	if(!ini_get('date.timezone'))
	{
		date_default_timezone_set('UTC');
	}

    if ($timezones === null) {
        $timezones = array();
        $offsets = array();
        $now = new DateTime();

        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . format_GMT_offset($offset) . ') ' . format_timezone_name($timezone);
        }

        array_multisort($offsets, $timezones);
    }

    return $timezones;
}

function format_GMT_offset($offset) {
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function format_timezone_name($name) {
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}

/* Form Validator */
function reqVal($f,$m,$t=0){
	
	# f - area name
	# m - model, email, empty, isnumeric etc
	# t - 0 post / 1 get
	# Example: if(!reqVal('form_field','empty','0'))
	
	if($t==0){
		
		if($m=='empty'){if(!isset($_POST[$f]) || empty($_POST[$f])){return false;}else{return true;}}
		if($m=='numeric'){if(!isset($_POST[$f]) || !is_numeric($_POST[$f])){return false;}else{return true;}}
		if($m=='mail'){if(!isset($_POST[$f]) || !mailVal($_POST[$f])){return false;}else{return true;}}
		
	}else{
		
		if($m=='empty'){if(!isset($_GET[$f]) || empty($_GET[$f])){return false;}else{return true;}}
		if($m=='numeric'){if(!isset($_GET[$f]) || !is_numeric($_GET[$f])){return false;}else{return true;}}
		if($m=='mail'){if(!isset($_GET[$f]) || !mailVal($_GET[$f])){return false;}else{return true;}}
		
	}
	
}

/* Curl Controller */
function _iscurl(){
	if(function_exists('curl_version'))
	  return true;
	else 
	  return false;
}

/* Get CURL Result */
function curl_get_result($url) {
	@set_time_limit(0);
	
	// Headers
	  $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	  $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	  $header[] = "Cache-Control: max-age=0";
	  $header[] = "Connection: keep-alive";
	  $header[] = "Keep-Alive: 300";
	  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	  $header[] = "Accept-Language: en-us,en;q=0.5";
	  $header[] = "Pragma: "; // browsers keep this blank. 
	
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	if(!$data = curl_exec($ch)){
		return false;
	}else{
		curl_close($ch);
		return $data;
	}
}

# Directory and URL
/* Rel Document Builder */
function relDocs($filePath){

        $filePath = str_replace('\\','/',$filePath);
        $ssl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true : false;
        $sp = strtolower($_SERVER['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $_SERVER['SERVER_PORT'];
        $stringPort = ((!$ssl && ($port == '80' || $port=='8080')) || ($ssl && $port == '443')) ? '' : ':' . $port;
		

		
		
        $host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		
		
        $filePath = preg_replace('/(\/+)/','/',$filePath);
		$fileUrl = str_replace($_SERVER['DOCUMENT_ROOT'] ,$protocol . '://' . $host . $stringPort, $filePath); 
		
		return $fileUrl;

}

# Set Demo Date
function demoDate($m){
	$demo_date = DEMO_TODAY;
	if(DEMO_MODE){
		$demo_date = DateTime::createFromFormat("Y-m-d H:i:s", $demo_date)->format("Y-m-d H:i:s");
		if($m=='d'){return date('d',strtotime($demo_date));}
		if($m=='m'){return date('m',strtotime($demo_date));}
		if($m=='Y'){return date('Y',strtotime($demo_date));}
		if($m=='Y-m-d H:i'){return date('Y-m-d H:i',strtotime($demo_date));}
	}else{
		if($m=='d'){return date('d');}
		if($m=='m'){return date('m');}
		if($m=='Y'){return date('Y');}
		if($m=='Y-m-d H:i'){return date('Y-m-d H:i');}
	}
}

# URL Sanitizer
include_once('url_slug.php');

# Is Ajax Request
function isAjax(){
	
	$headers = apache_request_headers();
	$is_ajax = (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
	
	if($is_ajax) {
		return true;
	}else{
		return false;
	}
}

/* RSS Filter */
function rss_filter($v){
	$v = showIn($v,'page');
	$rss_str = '<![CDATA['.$v.']]>';
	
	return $rss_str;
}

if( !function_exists('apache_request_headers') ) {
///
function apache_request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do some nasty string manipulations to restore the original letter case
      // this should work in most cases
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
}
///
}


/* SEO Link Maker */
function getSEO($eid,$title){
	
	$link_struct = cal_set_app_url.'event/'. url_slug($title) .'/'. $eid .'/';
	
	# For 2.4 Unpached
	if(!defined('cal_set_seo_links')){
		define('cal_set_seo_links',1);
	}
	
	# SEO On
	if(cal_set_seo_links){
		return $link_struct;
		
	# SEO Off
	}else{
		return cal_set_app_url.'sdr.calendar.php?pos=details&amp;ID='.$eid;
	}
	
}
?>