<?php

use phpformbuilder\Form;

include_once 'Form.php';

define('CURL_VERBOSE', true);

$user_msg           = '';
$already_registered = false;
$just_registered    = false;
$just_unregistered  = false;

function checkServer()
{
    $errors = array();

    $php_extensions = get_loaded_extensions();

    if (!in_array('curl', $php_extensions)) {
        $errors[] = '<strong>PHP CURL extension is NOT enabled.<br>You\'ve got to enable it to register your PHP Form Builder copy.</strong>';
    }
    if (!empty($errors)) {
        return $errors;
    }

    return true;
}

$server_msg = checkServer();

if (is_array($server_msg)) {
    $user_msg = '<p class="mb-0">';
    foreach ($server_msg as $msg) {
        $user_msg .= $msg . '<br>';
    }
    $user_msg .= '</p>';
    $user_msg_class = 'danger';
}

//get current page url (also remove specific strings and last slash if needed)
function getCurrentUrl($remove_last_slash = null, $string_to_remove_array = null)
{
    $current_url=null;

    if ((! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') || (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')) {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }

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

$script_url = array(
    'script_url' => str_ireplace('/phpformbuilder/register.php', '', 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])
);

$current_url = array(
    'current_url' => getCurrentUrl(1)
);

try {
    $already_registered = Form::checkRegistration('static');
    $main_host = Form::get_domain($_SERVER['HTTP_HOST']);
    if ($already_registered !== true) {
        // empty license.php if wrong registration data
        if (is_dir(__DIR__ . '/' . $main_host) && file_exists(__DIR__ . '/' . $main_host . '/license.php')) {
            $handle=fopen(__DIR__ . '/' . $main_host . '/license.php', "w+");
            fclose($handle);
        }
    }
    $license  = file_get_contents(__DIR__ . '/' . $main_host . '/license.php');
} catch (Exception $e) {
    var_dump($e);
    exit('License file not found');
}

if (isset($_POST['registration-form']) && $already_registered === false) {
    try {
        $ch = curl_init();

        $postfields = array_merge($_POST, $script_url);

        $user_agent = "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0"; //set user agent
        $connect_timeout = 10; //set connection timeout

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.phpformbuilder.pro/registration/register.php");
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $connect_timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        if (CURL_VERBOSE === true) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }

        $json_result = curl_exec($ch);

        if ($json_result === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }
    } catch(Exception $e) {

        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }

    $result = json_decode($json_result);

    if (isset($result->error_msg)) {
        $user_msg = $result->error_msg;
        $user_msg_class = 'danger';
    } elseif (isset($result->notification_text)) {
        if ($result->notification_case !== "notification_license_ok") {
            $user_msg = $result->notification_text;
            $user_msg_class = 'danger';
        } else {
            try {
                file_put_contents(__DIR__ . '/' . $main_host . '/license.php', $result->notification_text);
                $user_msg = '<p>thank you for registering your copy.</p><p>You can now freely use PHP Form Builder.</p><hr><p><strong><u>Important</u></strong>:<br>delete this file from your server now to avoid any unwanted use.</p>';
                $user_msg_class = 'success';
                $just_registered = true;
            } catch (Exception $e) {
                var_dump($e);
                exit('Unable to write file /' . $main_host . '/license.php - please check your write access (chmod)');
            }
        }
    } else {
        $user_msg = '<p>An error occured during the registration process.</p>';
        if ($json_result === false) {
            $curl_errno = curl_errno($ch);
            $user_msg .= '<p><strong>cUrl error #' . $curl_errno . ' ' . htmlspecialchars(curl_error($ch)) . '</strong></p>';
            if ($curl_errno == 7) {
                $user_msg .= '<p><a href="https://www.google.com/search?q=php+curl+Ierror+7+Permission+denied&oq=php+curl+Ierror+7+Permission+denied">CURL ERROR 7 Failed to connect to ... Permission denied error</a> is caused, when for any reason curl request is blocked by some firewall or similar thing.</p>';
                $user_msg .= '<p>To solve this issue you have to change your firewall settings.</p>';
                $user_msg .= '<p>If your server uses <abbr title="Security-Enhanced Linux">SELinux</abbr> security module, you can:</p>';
                $user_msg .= '<ul class="d-inline-block text-left">';
                $user_msg .= '<li><a href="https://www.google.com/search?q=disable+selinux">disable SELinux</a></li>';
                $user_msg .= '<li><a href="https://www.google.com/search?q=configure+selinux+policy">configure SELinux policy</a></li>';
                $user_msg .= '</ul>';
            }
            if (CURL_VERBOSE === true) {
                rewind($verbose);
                $verboseLog = stream_get_contents($verbose);
                $user_msg .= '<p><strong>Verbose information:</strong></p><div class="d-inline-block"><pre class="text-left">' . htmlspecialchars($verboseLog) . '</pre></div>';
            }
            $user_msg_class = 'danger';
        }
    }
    curl_close($ch);
}

if (isset($_POST['unregister-form']) && $already_registered === true) {
    $ch = curl_init();

    $postfields = array_merge($_POST, $current_url);

    $user_agent = "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0"; //set user agent
    $connect_timeout = 10; //set connection timeout

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.phpformbuilder.pro/registration/unregister.php");
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $connect_timeout);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $json_result = curl_exec($ch);
    $result = json_decode($json_result);
    // $info = curl_getinfo($ch);
    curl_close($ch);

    if (isset($result->notification_text)) {
        if ($result->notification_case !== "notification_license_ok") {
            $user_msg = $result->notification_text;
            $user_msg_class = 'danger';
        } else {
            try {
                $main_host = Form::get_domain($_SERVER['HTTP_HOST']);
                $handle=fopen(__DIR__ . '/' . $main_host . '/license.php', "w+");
                fclose($handle);
                $user_msg = '<p>Your copy has been successfully unregistered.</p><hr><p><strong><u>Important</u></strong>:<br>delete this file from your server now to avoid any unwanted use.</p>';
                $user_msg_class = 'success';
                $just_unregistered = true;
            } catch (Exception $e) {
                var_dump($e);
                exit('Unable to write file /' . $main_host . '/license.php - please check your write access (chmod)');
            }
        }
    } else {
        $user_msg = 'An error occured during the un-registration process.';
        $user_msg_class = 'danger';
    }
} elseif ($already_registered === true) {
    $user_msg = '<p>Your PHP Form Builder copy is already registered on this domain.</p><hr><p>If you want to install on another domain<br>you have to unregister your copy.</p>';
    $user_msg_class = 'success';
}

if (!empty($user_msg)) {
    $user_msg = '<div class="alert alert-' . $user_msg_class . ' text-center my-5" role="alert">' . $user_msg . '</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Php Form Builder - Register</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/solid.css" integrity="sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css" integrity="sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG" crossorigin="anonymous">

    <link href="plugins/ladda/dist/ladda-themeless.min.css" rel="stylesheet" media="screen">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <?php echo $user_msg; ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <?php if ($already_registered === true) {
                    if ($just_unregistered === false) { ?>
                    <form id="unregister-form" action="register.php" method="POST" novalidate>
                        <div>
                            <input name="unregister-form" type="hidden" value="1" >
                            <input name="license_content" type="hidden" value="<?php echo $license; ?>" >
                        </div>
                        <fieldset class="my-4">
                            <legend class="text-center">
                                PHP Form Builder - Unregister
                            </legend>
                            <p class="text-center">Please fill-in the form below to unregister your copy</p>
                            <hr class="mb-5">
                            <div class="form-group">
                                <label for="user-purchase-code" class="form-control-label">
                                    Enter your purchase code <sup class="text-danger">* </sup>
                                </label>
                                <input id="user-purchase-code" name="user-purchase-code" type="text" value="" required class="form-control">
                            </div>
                        </fieldset>
                        <div class="form-group text-center">
                            <button type="submit" name="submit-btn" value="1" class="btn btn-danger ladda-button" data-style="zoom-in">
                                Unregister<i class="fas fa-magic ml-3"></i>
                            </button>
                        </div>
                        <p>&nbsp;</p>
                        <p class="text-center my-5"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where can I find my purchase code?</a></p>
                    </form>
                    <?php   }
                } elseif ($just_registered === false) { ?>
                <form id="registration-form" action="register.php" method="POST" novalidate>
                    <div>
                        <input name="registration-form" type="hidden" value="1" >
                        <input name="license_content" type="hidden" value="<?php echo $license; ?>" >
                    </div>
                    <fieldset class="my-4">
                        <legend class="text-center">
                            PHP Form Builder Registration
                        </legend>
                        <p class="text-center">Please fill-in the form below to register your copy</p>
                        <hr class="mb-5">
                        <div class="form-group">
                            <label for="user-purchase-code" class="form-control-label">
                                Enter your purchase code <sup class="text-danger">* </sup>
                            </label>
                            <input id="user-purchase-code" name="user-purchase-code" type="text" value="" required class="form-control">
                        </div>
                    </fieldset>
                    <div class="form-group text-center">
                        <button type="submit" name="submit-btn" value="1" class="btn btn-success ladda-button" data-style="zoom-in">
                            Register<i class="fas fa-magic ml-3"></i>
                        </button>
                    </div>
                    <p>&nbsp;</p>
                    <p class="text-center my-5"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where can I find my purchase code?</a></p>
                </form>
<?php } ?>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="plugins/ladda/dist/spin.min.js" defer></script>
    <script src="plugins/ladda/dist/ladda.min.js" defer></script>
    <script type="text/javascript" defer>
    jQuery(document).ready(function($) {
        var forms = Array('#registration-form', '#unregister-form');
        for (var i = forms.length - 1; i >= 0; i--) {
            var form = forms[i];
            if($(form)[0]) {
                var l = Ladda.create(document.querySelector(form + ' .ladda-button')),
                $laddaForm = $(form + ' .ladda-button').closest('form');
                $(form + ' .ladda-button').on('click', function() {
                    l.start();
                    $(this).closest('form').submit();
                });
            }
        }
    });
    </script>

</body>
</html>
