<?php

//MAIN CONFIG FILE OF AUTO PHP LICENSER. CAN BE EDITED MANUALLY OR GENERATED USING Extra Tools > Configuration Generator TAB IN AUTO PHP LICENSER DASHBOARD. THE FILE MUST BE INCLUDED IN YOUR SCRIPT BEFORE YOU PROVIDE IT TO USER.


//-----------BASIC SETTINGS-----------//

if (!defined("APL_SALT")) {
    //Random salt used for encryption. It should contain random symbols (16 or more recommended) and be different for each application you want to protect. Cannot be modified after installing script.
    define("APL_SALT", "g5*j%EF56BB=-eDf");

    //The URL (without / at the end) where Auto PHP Licenser from /WEB directory is installed on your server. No matter how many applications you want to protect, a single installation is enough.
    define("APL_ROOT_URL", "https://www.miglisoft.com/phpmillion");

    //Unique numeric ID of product that needs to be licensed. Can be obtained by going to Products > View Products tab in Auto PHP Licenser dashboard and selecting product to be licensed. At the end of URL, you will see something like products_edit.php?product_id=NUMBER, where NUMBER is unique product ID. Cannot be modified after installing script.
    define("APL_PRODUCT_ID", 2);

    //Time period (in days) between automatic license verifications. The lower the number, the more often license will be verified, but if many end users use your script, it can cause extra load on your server. Available values are between 1 and 365. Usually 7 or 14 days are the best choice.
    define("APL_DAYS", 7);

    //Place to store license signature and other details. "DATABASE" means data will be stored in MySQL database (recommended), "FILE" means data will be stored in local file. Only use "FILE" if your application doesn't support MySQL. Otherwise, "DATABASE" should always be used. Cannot be modified after installing script.
    define("APL_STORAGE", "FILE");

    //Name of table (will be automatically created during installation) to store license signature and other details. Only used when "APL_STORAGE" set to "DATABASE". The more "harmless" name, the better. Cannot be modified after installing script.
    define("APL_DATABASE_TABLE", "");

    //Name and location (relative to directory where "apl_core_configuration.php" file is located, cannot be moved outside this directory) of file to store license signature and other details. Can have ANY name and extension. The more "harmless" location and name, the better. Cannot be modified after installing script. Only used when "APL_STORAGE" set to "FILE" (file itself can be safely deleted otherwise).
    $main_host = get_domain($_SERVER['HTTP_HOST']);
    define("APL_LICENSE_FILE_LOCATION", "../" . $main_host . "/license.php");

    //Name and location (relative to directory where "apl_core_configuration.php" file is located, cannot be moved outside this directory) of MySQL connection file. Only used when "APL_STORAGE" set to "DATABASE" (file itself can be safely deleted otherwise).
    define("APL_MYSQL_FILE_LOCATION", "");

    //Notification to be displayed when operation fails because of connection issues (no Internet connection, your domain is blacklisted by user, etc.) Other notifications will be automatically fetched from your Auto PHP Licenser installation.
    define("APL_NOTIFICATION_NO_CONNECTION", "Can't connect to licensing server.");

    //Notification to be displayed when updating database fails. Only used when APL_STORAGE set to DATABASE.
    define("APL_NOTIFICATION_DATABASE_WRITE_ERROR", "Can't write to database.");

    //Notification to be displayed when updating license file fails. Only used when APL_STORAGE set to FILE.
    define("APL_NOTIFICATION_LICENSE_FILE_WRITE_ERROR", "Can't write to license file.");

    //Notification to be displayed when installation wizard is launched again after script was installed.
    define("APL_NOTIFICATION_SCRIPT_ALREADY_INSTALLED", "Script is already installed (or database not empty).");

    //Notification to be displayed when license could not be verified because license is not installed yet or corrupted.
    define("APL_NOTIFICATION_LICENSE_CORRUPTED", "License is not installed yet or corrupted.");

    //Notification to be displayed when license verification does not need to be performed. Used for debugging purposes only, should never be displayed to end user.
    define("APL_NOTIFICATION_BYPASS_VERIFICATION", "No need to verify");


    //-----------ADVANCED SETTINGS-----------//


    //Secret key used to verify if configuration file included in your script is genuine (not replaced with 3rd party files). It can contain any number of random symbols and should be different for each application you want to protect. You should also change its name from "APL_INCLUDE_KEY_CONFIG" to something else, let's say "MY_CUSTOM_SECRET_KEY"
    define("TOKEN_CONFIG", "885kufR**.xp5e6S");

    //IP address of your Auto PHP Licenser installation. If IP address is set, script will always check if "APL_ROOT_URL" resolves to this IP address (very useful against users who may try blocking or nullrouting your domain on their servers). However, use it with caution because if IP address of your server is changed in future, old installations of protected script will stop working (you will need to update this file with new IP and send updated file to end user). If you want to verify licensing server, but don't want to lock it to specific IP address, you can use APL_ROOT_NAMESERVERS option (because nameservers change is unlikely).
    define("APL_ROOT_IP", "");

    //Nameservers of your domain with Auto PHP Licenser installation (only works with domains and NOT subdomains). If nameservers are set, script will always check if "APL_ROOT_NAMESERVERS" match actual DNS records (very useful against users who may try blocking or nullrouting your domain on their servers). However, use it with caution because if nameservers of your domain are changed in future, old installations of protected script will stop working (you will need to update this file with new nameservers and send updated file to end user). Nameservers should be formatted as an array. For example: array("ns1.phpmillion.com", "ns2.phpmillion.com"). Nameservers are NOT CAse SensitIVE.
    //define("APL_ROOT_NAMESERVERS", array()); //ATTENTION! THIS FEATURE ONLY WORKS WITH PHP 7, SO UNCOMMENT THIS LINE ONLY IF PROTECTED SCRIPT WILL RUN ON PHP 7 SERVER!

    //When option set to "YES", all files and MySQL data will be deleted when illegal usage is detected. This is very useful against users who may try using pirated software; if someone shares his license with 3rd parties (by sending it to a friend, posting on warez forums, etc.) and you cancel this license, Auto PHP Licenser will try to delete all script files and any data in MySQL database for everyone who uses cancelled license. For obvious reasons, data will only be deleted if license is cancelled. If license is invalid or expired, no data will be modified. Use at your own risk!
    define("APL_DELETE_CANCELLED", "NO");

    //When option set to "YES", all files and MySQL data will be deleted when cracking attempt is detected. This is very useful against users who may try cracking software; if some unauthorized changes in core functions are detected, Auto PHP Licenser will try to delete all script files and any data in MySQL database. Use at your own risk!
    define("APL_DELETE_CRACKED", "NO");


    //-----------NOTIFICATIONS FOR DEBUGGING PURPOSES ONLY. SHOULD NEVER BE DISPLAYED TO END USER-----------//


    define("APL_CORE_NOTIFICATION_INVALID_SALT", "Configuration error: invalid or default encryption salt");
    define("APL_CORE_NOTIFICATION_INVALID_ROOT_URL", "Configuration error: invalid root URL of Auto PHP Licenser installation");
    define("APL_CORE_NOTIFICATION_INVALID_PRODUCT_ID", "Configuration error: invalid product ID");
    define("APL_CORE_NOTIFICATION_INVALID_VERIFICATION_PERIOD", "Configuration error: invalid license verification period");
    define("APL_CORE_NOTIFICATION_INVALID_STORAGE", "Configuration error: invalid license storage option");
    define("APL_CORE_NOTIFICATION_INVALID_TABLE", "Configuration error: invalid MySQL table name to store license signature");
    define("APL_CORE_NOTIFICATION_INVALID_LICENSE_FILE", "Configuration error: invalid license file location (or file not writable)");
    define("APL_CORE_NOTIFICATION_INVALID_MYSQL_FILE", "Configuration error: invalid MySQL file location (or file not readable)");
    define("APL_CORE_NOTIFICATION_INVALID_ROOT_IP", "Configuration error: invalid IP address of your Auto PHP Licenser installation");
    define("APL_CORE_NOTIFICATION_INVALID_ROOT_NAMESERVERS", "Configuration error: invalid nameservers of your Auto PHP Licenser installation");
    define("APL_CORE_NOTIFICATION_INACCESSIBLE_ROOT_URL", "Server error: impossible to establish connection to your Auto PHP Licenser installation");
    define("APL_CORE_NOTIFICATION_INVALID_DNS", "License error: actual IP address and/or nameservers of your Auto PHP Licenser installation don't match specified IP address and/or nameservers");


    //-----------SOME EXTRA STUFF. SHOULD NEVER BE REMOVED OR MODIFIED-----------//
    define("APL_DIRECTORY", __DIR__);
    define("APL_MYSQL_QUERY", "LOCAL");
}

/**
 * get the main domain from any domain or subdomain
 *
 * https://stackoverflow.com/questions/1201194/php-getting-domain-name-from-subdomain
 *
 * @param string $host
 * @return String
 **/
function get_domain($host) {
    $myhost = strtolower(trim($host));
    $count = substr_count($myhost, '.');
    if ($count === 1 || $count === 2) {
        if (strlen(explode('.', $myhost)[1]) > 3) {
            $myhost = explode('.', $myhost, 2)[1];
        }
    } elseif ($count > 2) {
        $myhost = get_domain(explode('.', $myhost, 2)[1]);
    }
    return $myhost;
}

//ALL THE FUNCTIONS IN THIS FILE START WITH apl TO PREVENT DUPLICATED NAMES WHEN AUTO PHP LICENSER SOURCE FILES ARE INTEGRATED INTO ANY SCRIPT

//encrypt text with custom key
function aplCustomEncrypt($string, $key)
{
    $encrypted_string=null;

    if (!empty($string) && !empty($key)) {
        $iv=openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc")); //generate an initialization vector

        $encrypted_string=openssl_encrypt($string, "aes-256-cbc", $key, 0, $iv); //encrypt the string using AES 256 encryption in CBC mode using encryption key and initialization vector
        $encrypted_string=base64_encode($encrypted_string."::".$iv); //the $iv is just as important as the key for decrypting, so save it with encrypted string using a unique separator "::"
    }

    return $encrypted_string;
}


//decrypt text with custom key
function aplCustomDecrypt($string, $key)
{
    $decrypted_string=null;

    if (!empty($string) && !empty($key)) {
        $string=base64_decode($string); //remove the base64 encoding from string (it's always encoded using base64_encode)
        if (stristr($string, "::")) { //unique separator "::" found, most likely it's valid encrypted string
            $string_iv_array=explode("::", $string, 2); //to decrypt, split the encrypted string from $iv - unique separator used was "::"
            if (!empty($string_iv_array) && count($string_iv_array)==2) { //proper $string_iv_array should contain exactly two values - $encrypted_string and $iv
                list($encrypted_string, $iv)=$string_iv_array;

                $decrypted_string=openssl_decrypt($encrypted_string, "aes-256-cbc", $key, 0, $iv);
            }
        }
    }

    return $decrypted_string;
}


//validate numbers (or ranges like 1-10) and check if they match min and max values
function aplValidateNumberOrRange($number, $min_value, $max_value = INF)
{
    $result=false;

    if (filter_var($number, FILTER_VALIDATE_INT)===0 || !filter_var($number, FILTER_VALIDATE_INT)===false) { //number provided
        if ($number>=$min_value && $number<=$max_value) {
            $result=true;
        } else {
            $result=false;
        }
    }

    if (stristr($number, "-")) { //range provided
        $numbers_array=explode("-", $number);
        if (filter_var($numbers_array[0], FILTER_VALIDATE_INT)===0 || !filter_var($numbers_array[0], FILTER_VALIDATE_INT)===false && filter_var($numbers_array[1], FILTER_VALIDATE_INT)===0 || !filter_var($numbers_array[1], FILTER_VALIDATE_INT)===false) {
            if ($numbers_array[0]>=$min_value && $numbers_array[1]<=$max_value && $numbers_array[0]<=$numbers_array[1]) {
                $result=true;
            } else {
                $result=false;
            }
        }
    }

    return $result;
}


//validate raw domain (only URL like (sub.)domain.com will validate)
function aplValidateRawDomain($url)
{
    $result=false;

    if (!empty($url)) {
        if (preg_match('/^[a-z0-9-.]+\.[a-z\.]{2,7}$/', strtolower($url))) { //check if this is valid tld
            $result=true;
        } else {
            $result=false;
        }
    }

    return $result;
}


//get current page url (also remove specific strings and last slash if needed)
function aplGetCurrentUrl($remove_last_slash = null, $string_to_remove_array = null)
{
    $current_url=null;

    $protocol=!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=="off" ? 'https' : 'http';
    if (isset($_SERVER['HTTP_HOST'])) {
        $host=$_SERVER['HTTP_HOST'];
    }
    if (isset($_SERVER['SCRIPT_NAME'])) {
        $script=$_SERVER['SCRIPT_NAME'];
    }
    if (isset($_SERVER['QUERY_STRING'])) {
        $params=$_SERVER['QUERY_STRING'];
    }

    if (!empty($protocol) && !empty($host) && !empty($script)) { //return URL only when script is executed via browser (because no URL should exist when executed from command line)
        $current_url=$protocol.'://'.$host.$script;

        if (!empty($params)) {
            $current_url.='?'.$params;
        }

        if (!empty($string_to_remove_array) && is_array($string_to_remove_array)) { //remove specific strings from URL
            foreach ($string_to_remove_array as $key => $value) {
                $current_url=str_ireplace($value, "", $current_url);
            }
        }

        if ($remove_last_slash==1) { //remove / from the end of URL if it exists
            while (substr($current_url, -1)=="/") { //use cycle in case URL already contained multiple // at the end
                $current_url=substr($current_url, 0, -1);
            }
        }
    }

    return $current_url;
}


//get raw domain (returns (sub.)domain.com from url like http://www.(sub.)domain.com/something.php?xx=yy)
function aplGetRawDomain($url)
{
    $raw_domain=null;

    if (!empty($url)) {
        $url_array=parse_url($url);
        if (empty($url_array['scheme'])) { //in case no scheme was provided in url, it will be parsed incorrectly. add http:// and re-parse
            $url="http://".$url;
            $url_array=parse_url($url);
        }

        if (!empty($url_array['host'])) {
            $raw_domain=$url_array['host'];

            $raw_domain=trim(str_ireplace("www.", "", filter_var($raw_domain, FILTER_SANITIZE_URL)));
        }
    }

    return $raw_domain;
}


//return root url from long url (http://www.domain.com/path/file.php?aa=xx becomes http://www.domain.com/path/), remove scheme, www. and last slash if needed
function aplGetRootUrl($url, $remove_scheme, $remove_www, $remove_path, $remove_last_slash)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $url_array=parse_url($url); //parse URL into arrays like $url_array['scheme'], $url_array['host'], etc

        $url=str_ireplace($url_array['scheme']."://", "", $url); //make URL without scheme, so no :// is included when searching for first or last /

        if ($remove_path==1) { //remove everything after FIRST / in URL, so it becomes "real" root URL
            $first_slash_position=stripos($url, "/"); //find FIRST slash - the end of root URL
            if ($first_slash_position>0) { //cut URL up to FIRST slash
                $url=substr($url, 0, $first_slash_position+1);
            }
        } else //remove everything after LAST / in URL, so it becomes "normal" root URL
            {
            $last_slash_position=strripos($url, "/"); //find LAST slash - the end of root URL
            if ($last_slash_position>0) { //cut URL up to LAST slash
                $url=substr($url, 0, $last_slash_position+1);
            }
        }

        if ($remove_scheme!=1) { //scheme was already removed, add it again
            $url=$url_array['scheme']."://".$url;
        }

        if ($remove_www==1) { //remove www.
            $url=str_ireplace("www.", "", $url);
        }

        if ($remove_last_slash==1) { //remove / from the end of URL if it exists
            while (substr($url, -1)=="/") { //use cycle in case URL already contained multiple // at the end
                $url=substr($url, 0, -1);
            }
        }
    }

    return trim($url);
}


//make post requests with cookies, referrers, etc
function aplCustomPost($url, $refer = null, $post_info = null)
{
    $user_agent="Mozilla/5.0 (Windows NT 6.3; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0"; //set user agent
    $connect_timeout=10; //set connection timeout

    if (empty($refer) || !filter_var($refer, FILTER_VALIDATE_URL)) {
        $refer=$url;
    } //use original url as refer when no valid URL provided

    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $connect_timeout);
    curl_setopt($ch, CURLOPT_REFERER, $refer);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_info);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $result=curl_exec($ch);
    // $info = curl_getinfo($ch);
    curl_close($ch);
    return $result;
}


//verify date according to provided format (such as Y-m-d)
function aplVerifyDate($date, $date_format)
{
    $datetime=DateTime::createFromFormat($date_format, $date);
    $errors=DateTime::getLastErrors();
    if (!$datetime || !empty($errors['warning_count'])) { //date was invalid
        $date_check_ok=false;
    } else //everything OK
        {
        $date_check_ok=true;
    }

    return $date_check_ok;
}


//calculate number of days between dates
function aplGetDaysBetweenDates($date_from, $date_to)
{
    $number_of_days=0;

    if (aplVerifyDate($date_from, "Y-m-d") && aplVerifyDate($date_to, "Y-m-d")) {
        $date_to=new DateTime($date_to);
        $date_from=new DateTime($date_from);
        $number_of_days=$date_from->diff($date_to)->format("%a");
    }

    return $number_of_days;
}


//parse values between specified xml-like tags
function aplParseXmlTags($content, $tag_name)
{
    $parsed_value=null;

    if (!empty($content) && !empty($tag_name)) {
        preg_match_all("/<".preg_quote($tag_name, "/").">(.*?)<\/".preg_quote($tag_name, "/").">/ims", $content, $output_array, PREG_SET_ORDER);

        if (!empty($output_array[0][1])) {
            $parsed_value=trim($output_array[0][1]);
        }
    }

    return $parsed_value;
}


//parse license notifications tags generated by Auto PHP Licenser server
function aplParseServerNotifications($content)
{
    $notifications_array=array();
    $notifications_array['notification_case']=null;
    $notifications_array['notification_text']=null;

    if (!empty($content)) {
        preg_match_all("/<notification_([a-z_]+)>(.*?)<\/notification_([a-z_]+)>/", $content, $output_array, PREG_SET_ORDER); //parse <notification_case> along with message

        if (!empty($output_array[0][1]) && $output_array[0][1]==$output_array[0][3] && !empty($output_array[0][2])) { //check if both notification tags are the same and contain text inside
            $notifications_array['notification_case']="notification_".$output_array[0][1];
            $notifications_array['notification_text']=$output_array[0][2];
        }
    }

    return $notifications_array;
}


//generate signature to be submitted to Auto PHP Licenser server
function aplGenerateScriptSignature($ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE)
{
    $script_signature=null;
    $root_ips_array=gethostbynamel(aplGetRawDomain(APL_ROOT_URL));

    if (!empty($root_ips_array)) { //IP(s) resolved successfully
        $script_signature=hash("sha256", gmdate("Y-m-d").$ROOT_URL.$CLIENT_EMAIL.$LICENSE_CODE.APL_PRODUCT_ID.implode("", $root_ips_array));
    }

    return $script_signature;
}


//verify signature received from Auto PHP Licenser server
function aplVerifyServerSignature($content, $ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE)
{
    $result=false;
    $root_ips_array=gethostbynamel(aplGetRawDomain(APL_ROOT_URL));
    $server_signature=aplParseXmlTags($content, "license_signature");

    if (!empty($root_ips_array) && !empty($server_signature)) {
        if (hash("sha256", implode("", $root_ips_array).APL_PRODUCT_ID.$LICENSE_CODE.$CLIENT_EMAIL.$ROOT_URL.gmdate("Y-m-d"))==$server_signature) {
            $result=true;
        }
    }

    return $result;
}


//check Auto PHP Licenser core configuration and return an array with error messages if something wrong
function aplCheckSettings()
{
    $notifications_array=array();

    if (empty(APL_SALT) || APL_SALT=="some_random_text") {
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_SALT; //invalid encryption salt
    }

    if (!filter_var(APL_ROOT_URL, FILTER_VALIDATE_URL) || !ctype_alnum(substr(APL_ROOT_URL, -1))) { //invalid APL installation URL
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_ROOT_URL;
    }

    if (!filter_var(APL_PRODUCT_ID, FILTER_VALIDATE_INT)) { //invalid APL product ID
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_PRODUCT_ID;
    }

    if (!aplValidateNumberOrRange(APL_DAYS, 1, 365)) { //invalid verification period
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_VERIFICATION_PERIOD;
    }

    if (APL_STORAGE!="DATABASE" && APL_STORAGE!="FILE") { //invalid data storage
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_STORAGE;
    }

    if (APL_STORAGE=="DATABASE" && !ctype_alnum(str_ireplace(array("_"), "", APL_DATABASE_TABLE))) { //invalid license table name
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_TABLE;
    }

    if (APL_STORAGE=="FILE" && !@is_writable(APL_DIRECTORY."/".APL_LICENSE_FILE_LOCATION)) { //invalid license file
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_LICENSE_FILE;
    }

    if (APL_STORAGE=="DATABASE" && !@is_readable(APL_DIRECTORY."/".APL_MYSQL_FILE_LOCATION)) { //invalid MySQL file
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_MYSQL_FILE;
    }

    if (!empty(APL_ROOT_IP) && !filter_var(APL_ROOT_IP, FILTER_VALIDATE_IP)) { //invalid APL server IP
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_ROOT_IP;
    }

    if (!empty(APL_ROOT_IP) && !in_array(APL_ROOT_IP, gethostbynamel(aplGetRawDomain(APL_ROOT_URL)))) { //actual IP address of APL server domain doesn't match specified IP address
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_DNS;
    }

    if (defined("APL_ROOT_NAMESERVERS") && !empty(APL_ROOT_NAMESERVERS)) { //check if nameservers are valid (use "defined" to check if nameservers are set because APL_ROOT_NAMESERVERS is commented by default to prevent errors in PHP<7)
        foreach (APL_ROOT_NAMESERVERS as $nameserver) {
            if (!aplValidateRawDomain($nameserver)) { //invalid APL server nameservers
                $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_ROOT_NAMESERVERS;
                break;
            }
        }
    }

    if (defined("APL_ROOT_NAMESERVERS") && !empty(APL_ROOT_NAMESERVERS)) { //check if actual nameservers of APL server domain match specified nameservers (use "defined" to check if nameservers are set because APL_ROOT_NAMESERVERS is commented by default to prevent errors in PHP<7)
        $apl_root_nameservers_array=APL_ROOT_NAMESERVERS; //create a variable from constant in order to use sort and other array functions
        $fetched_nameservers_array=array();

        $dns_records_array=dns_get_record(aplGetRawDomain(APL_ROOT_URL), DNS_NS);
        foreach ($dns_records_array as $record) {
            $fetched_nameservers_array[]=$record['target'];
        }

        $apl_root_nameservers_array=array_map("strtolower", $apl_root_nameservers_array); //convert root nameservers to lowercase
        $fetched_nameservers_array=array_map("strtolower", $fetched_nameservers_array); //convert fetched nameservers to lowercase

        sort($apl_root_nameservers_array); //sort both arrays before comparison
        sort($fetched_nameservers_array);
        if ($apl_root_nameservers_array!=$fetched_nameservers_array) {
            $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_DNS; //actual nameservers of APL server domain don't match specified nameservers
        }
    }

    return $notifications_array;
}


//parse config file and make an array with settings
function aplGetFileSettings()
{
    $file_settings_array=array();

    $file_content=@file_get_contents(APL_DIRECTORY."/".APL_LICENSE_FILE_LOCATION);
    preg_match_all("/<([A-Z_]+)>(.*?)<\/([A-Z_]+)>/", $file_content, $matches, PREG_SET_ORDER);
    if (!empty($matches)) {
        foreach ($matches as $value) {
            if (!empty($value[1]) && $value[1]==$value[3]) {
                $file_settings_array[$value[1]]=$value[2];
            }
        }
    }

    return $file_settings_array;
}


//check if connection is OK
function aplCheckConnection()
{
    $notifications_array=array();

    if (aplCustomPost(APL_ROOT_URL."/apl_callbacks/connection_test.php", APL_ROOT_URL, "connection_hash=".rawurlencode(hash("sha256", "connection_test")))!="<connection_test>OK</connection_test>") { //no content received from APL server
        $notifications_array[]=APL_CORE_NOTIFICATION_INACCESSIBLE_ROOT_URL;
    }

    return $notifications_array;
}

//return an array with license data,no matter where license is stored
function aplGetLicenseData($MYSQLI_LINK = null)
{
    $settings_row=array();

    if (APL_STORAGE=="DATABASE") { //license stored in database (use @ before mysqli_ function to prevent errors when function is executed by aplInstallLicense function)
        $settings_results=@mysqli_query($MYSQLI_LINK, "SELECT * FROM ".APL_DATABASE_TABLE);
        $settings_row=@mysqli_fetch_assoc($settings_results);
    }

    if (APL_STORAGE=="FILE") { //license stored in file
        $settings_row=aplParseLicenseFile();
    }

    return $settings_row;
}

//parse license file and make an array with license data
function aplParseLicenseFile()
{
    $license_data_array=array();

    if (@is_readable(APL_DIRECTORY."/".APL_LICENSE_FILE_LOCATION)) {
        $file_content=file_get_contents(APL_DIRECTORY."/".APL_LICENSE_FILE_LOCATION);
        preg_match_all("/<([A-Z_]+)>(.*?)<\/([A-Z_]+)>/", $file_content, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            foreach ($matches as $value) {
                if (!empty($value[1]) && $value[1]==$value[3]) {
                    $license_data_array[$value[1]]=$value[2];
                }
            }
        }
    }

    return $license_data_array;
}

//check Auto PHP Licenser variables and return false if something wrong
function aplCheckData($MYSQLI_LINK = null)
{
    $error_detected=0;
    $cracking_detected=0;
    $data_check_result=false;

    extract(aplGetLicenseData($MYSQLI_LINK)); //get license data

    if (!empty($ROOT_URL) && !empty($INSTALLATION_HASH) && !empty($INSTALLATION_KEY) && !empty($LCD) && !empty($LRD)) { //do further check only if essential variables are valid
        $LCD=aplCustomDecrypt($LCD, APL_SALT.$INSTALLATION_KEY); //decrypt $LCD value for easier data check
        $LRD=aplCustomDecrypt($LRD, APL_SALT.$INSTALLATION_KEY); //decrypt $LRD value for easier data check

        if (!filter_var($ROOT_URL, FILTER_VALIDATE_URL) || !ctype_alnum(substr($ROOT_URL, -1))) { //invalid script url
            $error_detected=1;
        }

        if (filter_var(aplGetCurrentUrl(), FILTER_VALIDATE_URL) && stristr(preg_replace('/\\.[^.\\s]{2,4}$/', '', aplGetRootUrl(aplGetCurrentUrl(), 1, 1, 1, 1)), preg_replace('/\\.[^.\\s]{2,4}$/', '', aplGetRootUrl("$ROOT_URL/", 1, 1, 1, 1)))===false) { //script is opened via browser (current_url set), but current_url is different from value in database
            $error_detected=2;
        }

        if (empty($INSTALLATION_HASH) || $INSTALLATION_HASH!=hash("sha256", $ROOT_URL.$CLIENT_EMAIL.$LICENSE_CODE)) { //invalid installation hash (value - $ROOT_URL, $CLIENT_EMAIL AND $LICENSE_CODE encrypted with sha256)
            $error_detected=3;
        }

        if (empty($INSTALLATION_KEY) || !password_verify($LRD, aplCustomDecrypt($INSTALLATION_KEY, APL_SALT.$ROOT_URL))) { //invalid installation key (value - current date ("Y-m-d") encrypted with password_hash and then encrypted with custom function (salt - $ROOT_URL). Put simply, it's LRD value, only encrypted different way)
            $error_detected=4;
        }

        if (!aplVerifyDate($LCD, "Y-m-d")) { //last check date is invalid
            $error_detected=5;
        }

        if (!aplVerifyDate($LRD, "Y-m-d")) { //last run date is invalid
            $error_detected=6;
        }

        //check for possible cracking attempts - starts
        if (aplVerifyDate($LCD, "Y-m-d") && $LCD>date("Y-m-d", strtotime("+1 day"))) { //last check date is VALID, but higher than current date (someone manually decrypted and overwrote it or changed system time back). Allow 1 day difference in case user changed his timezone and current date went 1 day back
            $error_detected=7;
            $cracking_detected=1;
        }

        if (aplVerifyDate($LRD, "Y-m-d") && $LRD>date("Y-m-d", strtotime("+1 day"))) { //last run date is VALID, but higher than current date (someone manually decrypted and overwrote it or changed system time back). Allow 1 day difference in case user changed his timezone and current date went 1 day back
            $error_detected=8;
            $cracking_detected=1;
        }

        if (aplVerifyDate($LCD, "Y-m-d") && aplVerifyDate($LRD, "Y-m-d") && $LCD>$LRD) { //last check date and last run date is VALID, but LCD is higher than LRD (someone manually decrypted and overwrote it or changed system time back)
            $error_detected=9;
            $cracking_detected=1;
        }

        if ($cracking_detected==1 && APL_DELETE_CRACKED=="YES") { //delete user data
            aplDeleteData($MYSQLI_LINK);
        }
        //check for possible cracking attempts - ends

        if ($error_detected === 0 && $cracking_detected!=1) { //everything OK
            $data_check_result=true;
        }
    }

    return array(
        'data_check_result' => $data_check_result,
        'error_detected'    => $error_detected
    );
}


//verify Envato purchase
function aplVerifyEnvatoPurchase($LICENSE_CODE = null)
{
    $notifications_array=array();
    $result = aplCustomPost(APL_ROOT_URL."/apl_callbacks/verify_envato_purchase.php", APL_ROOT_URL, "product_id=".rawurlencode(APL_PRODUCT_ID)."&license_code=".rawurlencode($LICENSE_CODE)."&connection_hash=".rawurlencode(hash("sha256", "verify_envato_purchase")));
    if ($result!="<head/><verify_envato_purchase>OK</verify_envato_purchase>" && $result!="<verify_envato_purchase>OK</verify_envato_purchase>") { //no content received from APL server
        $notifications_array[]=APL_CORE_NOTIFICATION_INACCESSIBLE_ROOT_URL;
    }

    return $notifications_array;
}

//verify license
function verifyToken($MYSQLI_LINK = null, $FORCE_VERIFICATION = 0)
{
    $notifications_array=array();
    $update_lrd_value=0;
    $update_lcd_value=0;
    $updated_records=0;
    $apl_core_notifications=aplCheckSettings(); //check core settings

    if (empty($apl_core_notifications)) { //only continue if script is properly configured
        $aplCheckDataResult = aplCheckData($MYSQLI_LINK);
        if ($aplCheckDataResult['data_check_result'] === true) { //only continue if license is installed and properly configured
            $settings_row=aplGetFileSettings();
            extract($settings_row);

            if (aplGetDaysBetweenDates(aplCustomDecrypt($LCD, APL_SALT.$INSTALLATION_KEY), date("Y-m-d"))<APL_DAYS && $FORCE_VERIFICATION==0) { //the only case when no verification is needed, return notification_license_ok case, so script can continue working
                $notifications_array['notification_case']="notification_license_ok";
                $notifications_array['notification_text']=APL_NOTIFICATION_BYPASS_VERIFICATION;
            } else //time to verify license (or use forced verification)
                {
                $post_info="product_id=".rawurlencode(APL_PRODUCT_ID)."&client_email=".rawurlencode($CLIENT_EMAIL)."&license_code=".rawurlencode($LICENSE_CODE)."&root_url=".rawurlencode($ROOT_URL)."&installation_hash=".rawurlencode($INSTALLATION_HASH)."&license_signature=".rawurlencode(aplGenerateScriptSignature($ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE));

                $content=aplCustomPost(APL_ROOT_URL."/apl_callbacks/license_verify.php", $ROOT_URL, $post_info);
                if (!empty($content)) { //content received, do other checks if needed
                    $notifications_array=aplParseServerNotifications($content); //parse <notification_case> along with message

                    if ($notifications_array['notification_case']=="notification_license_ok" && aplVerifyServerSignature($content, $ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE)) { //everything OK
                        $update_lcd_value=1;
                    }

                    if ($notifications_array['notification_case']=="notification_license_cancelled" && APL_DELETE_CANCELLED=="YES") { //license cancelled, data deletion activated, so delete user data
                        aplDeleteData($MYSQLI_LINK);
                    }
                } else //no content received
                    {
                    $notifications_array['notification_case']="notification_no_connection";
                    $notifications_array['notification_text']=APL_NOTIFICATION_NO_CONNECTION;
                }
            }

            if (aplCustomDecrypt($LRD, APL_SALT.$INSTALLATION_KEY)<date("Y-m-d")) { //used to make sure database gets updated only once a day, not every time script is executed. do it BEFORE new $INSTALLATION_KEY is generated
                $update_lrd_value=1;
            }

            if ($update_lrd_value==1 || $update_lcd_value==1) { //update database only if $LRD or $LCD were changed
                if ($update_lcd_value==1) { //generate new $LCD value ONLY if verification succeeded. Otherwise, old $LCD value should be used, so license will be verified again next time script is executed
                    $LCD=date("Y-m-d");
                } else //get existing DECRYPTED $LCD value because it will need to be re-encrypted using new $INSTALLATION_KEY in case license verification didn't succeed
                    {
                    $LCD=aplCustomDecrypt($LCD, APL_SALT.$INSTALLATION_KEY);
                }

                $INSTALLATION_KEY=aplCustomEncrypt(password_hash(date("Y-m-d"), PASSWORD_DEFAULT), APL_SALT.$ROOT_URL); //generate $INSTALLATION_KEY first because it will be used as salt to encrypt LCD and LRD!!!
                $LCD=aplCustomEncrypt($LCD, APL_SALT.$INSTALLATION_KEY); //finally encrypt $LCD value (it will contain either DECRYPTED old date, either non-encrypted today's date)
                $LRD=aplCustomEncrypt(date("Y-m-d"), APL_SALT.$INSTALLATION_KEY); //generate new $LRD value every time database needs to be updated (because if LCD is higher than LRD, cracking attempt will be detected).

                $handle=@fopen(APL_DIRECTORY."/".APL_LICENSE_FILE_LOCATION, "w+");
                $fwrite=@fwrite($handle, "<ROOT_URL>$ROOT_URL</ROOT_URL><CLIENT_EMAIL>$CLIENT_EMAIL</CLIENT_EMAIL><LICENSE_CODE>$LICENSE_CODE</LICENSE_CODE><LCD>$LCD</LCD><LRD>$LRD</LRD><INSTALLATION_KEY>$INSTALLATION_KEY</INSTALLATION_KEY><INSTALLATION_HASH>$INSTALLATION_HASH</INSTALLATION_HASH>");
                if ($fwrite===false) { //updating file failed
                    echo APL_NOTIFICATION_LICENSE_FILE_WRITE_ERROR;
                    exit();
                }
                @fclose($handle);
            }
        } else //license is not installed yet or corrupted
            {
            $notifications_array['notification_case']="notification_license_corrupted";
            $notifications_array['notification_text']=APL_NOTIFICATION_LICENSE_CORRUPTED . ' (' . $aplCheckDataResult['error_detected'] . ')';
        }
    } else //script is not properly configured
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $apl_core_notifications);
    }

    return $notifications_array;
}

//verify updates
function aplVerifyUpdates($MYSQLI_LINK = null)
{
    $notifications_array=array();
    $apl_core_notifications=aplCheckSettings(); //check core settings

    if (empty($apl_core_notifications)) { //only continue if script is properly configured
        if (aplCheckData($MYSQLI_LINK)) { //only continue if license is installed and properly configured
            if (APL_STORAGE=="DATABASE") { //settings stored in database
                $settings_results=mysqli_query($MYSQLI_LINK, "SELECT * FROM ".APL_DATABASE_TABLE);
                while ($settings_row=mysqli_fetch_assoc($settings_results)) {
                    extract($settings_row);
                }
            }

            if (APL_STORAGE=="FILE") { //settings stored in file
                $settings_row=aplGetFileSettings();
                extract($settings_row);
            }

            $post_info="product_id=".rawurlencode(APL_PRODUCT_ID)."&client_email=".rawurlencode($CLIENT_EMAIL)."&license_code=".rawurlencode($LICENSE_CODE)."&root_url=".rawurlencode($ROOT_URL)."&installation_hash=".rawurlencode($INSTALLATION_HASH)."&license_signature=".rawurlencode(aplGenerateScriptSignature($ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE));

            $content=aplCustomPost(APL_ROOT_URL."/apl_callbacks/license_updates.php", $ROOT_URL, $post_info);
            if (!empty($content)) { //content received, do other checks if needed
                $notifications_array=aplParseServerNotifications($content); //parse <notification_case> along with message
            } else //no content received
                {
                $notifications_array['notification_case']="notification_no_connection";
                $notifications_array['notification_text']=APL_NOTIFICATION_NO_CONNECTION;
            }
        } else //license is not installed yet or corrupted
            {
            $notifications_array['notification_case']="notification_license_corrupted";
            $notifications_array['notification_text']=APL_NOTIFICATION_LICENSE_CORRUPTED;
        }
    } else //script is not properly configured
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $apl_core_notifications);
    }

    return $notifications_array;
}

//delete user data
function aplDeleteData($MYSQLI_LINK = null)
{
    if (is_dir(APL_DIRECTORY)) {
        $root_directory=dirname(APL_DIRECTORY); //APL_DIRECTORY actually is USER_INSTALLATION_FULL_PATH/SCRIPT (where this file is located), go one level up to enter root directory of protected script

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root_directory, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
            $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
        }
        rmdir($root_directory);
    }

    if (APL_STORAGE=="DATABASE") { //settings stored in database, delete MySQL data
        $database_tables_array=array();

        $table_list_results=mysqli_query($MYSQLI_LINK, "SHOW TABLES"); //get list of tables in database
        while ($table_list_row=mysqli_fetch_row($table_list_results)) {
            $database_tables_array[]=$table_list_row[0];
        }

        if (!empty($database_tables_array)) {
            foreach ($database_tables_array as $table_name) { //delete all data from tables first
                mysqli_query($MYSQLI_LINK, "DELETE FROM $table_name");
            }

            foreach ($database_tables_array as $table_name) { //now drop tables (do it later to prevent script from being aborted when no drop privileges are granted)
                mysqli_query($MYSQLI_LINK, "DROP TABLE $table_name");
            }
        }
    }

    exit(); //abort further execution
}
