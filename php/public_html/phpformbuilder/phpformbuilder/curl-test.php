<?php
/**
 * Simple cURL request script
 *
 * Test if cURL is available, send request, print response
 *
 *   php curl.php
 */
if (!function_exists('curl_init')) {
    die('cURL not available!');
}
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.phpformbuilder.pro/registration/curl-test-answer.php'); // or use https://requestb.in/ for testing purposes
curl_setopt($curl, CURLOPT_FAILONERROR, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//// Require fresh connection
//curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
//// Send POST request instead of GET and transfer data
$postData = array(
 'name' => 'John Doe',
 'submit' => '1'
);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
//// Use a different request method
//// Note: PHP only converts data of GET and POST requests into convenient superglobals (»$_GET« & »$_POST«)
//// Use »parse_str(file_get_contents('php://input'), $_DELETE);« to read incoming data and write it to a
//// custom superglobal
//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
//// If the service is not able to parse the input stream, then use a regular POST request and a custom header
//// Use »$_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']« to read the incoming header variable
//curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
//// Send JSON body via POST request
//$postData = array(
//  'name' => 'John Doe',
//  'submit' => '1'
//);
//curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json')); // send JSON and expect JSON
//// As said above, the target script needs to read `php://input`, not `$_POST`!
//// Timeout in seconds
//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
//curl_setopt($curl, CURLOPT_TIMEOUT, 10);
//// Dont verify SSL certificate (eg. self-signed cert in testsystem)
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($curl);
if ($output === false) {
    echo 'An error has occurred: ' . curl_error($curl) . PHP_EOL;
} else {
    echo '<h4 style="color:#28B463">CURL Request has been sent successfully.</h4>';
    if ($output !== '') {
        echo $output;
    } else {
        echo '<h4 style="color:#B60000">The CURL answer is empty. Your server blocked it. You need to review your firewall settings.</h4>';
    }
}
