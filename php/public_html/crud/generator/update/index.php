<?php

if (file_exists('conf/conf.php')) {
    include_once 'conf/conf.php';
} elseif (file_exists('../conf/conf.php')) {
    include_once '../conf/conf.php';
} elseif (file_exists('../../conf/conf.php')) {
    include_once '../../conf/conf.php';
} else {
    exit('Configuration file not found (10)');
}
// if PHPCG is installed in a sub-directory
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
} else if (file_exists('../../vendor/autoload.php')) {
    require_once '../../vendor/autoload.php';
} else {
    require_once ROOT . 'vendor/autoload.php';
}

use \VisualAppeal\AutoUpdate;

$user_msg = '';

$update = new AutoUpdate(__DIR__ . '/temp', ROOT, 60);

// get current PHPCG version

if (!defined('VERSION')) {
    define('VERSION', '1.0');
}

$update->setCurrentVersion(VERSION);
$update->setUpdateUrl('https://www.phpcrudgenerator.com/server-update');
// Optional:
$update->addLogHandler(new Monolog\Handler\StreamHandler(__DIR__ . '/update.log'));
$update->setCache(new Desarrolla2\Cache\Adapter\File(__DIR__ . '/cache'), 3600);

//Check for a new update
if ($update->checkUpdate() === false) {
    $user_msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class="font-weight-bold">Could not check for updates! See log file at generator/update/update.log for details.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
} else {
    if ($update->newVersionAvailable()) {
        if (!isset($_POST['update'])) {
            /* =============================================
                Display the update button
            ============================================= */

            $user_msg = '<div class="alert bg-success-100 text-center alert-dismissible fade show" role="alert">';
            $user_msg .= '<p class="text-green-700 mb-4"><span class="font-weight-bold">PHP CRUD GENERATOR version ' . $update->getLatestVersion() . ' is available</strong></p>';
            $user_msg .= '<button type="button" name="update" id="update-btn" class="btn btn-outline-success mx-auto mb-4">Install<i class="fas fa-check position-right"></i></button>';
            $user_msg .= '<p class="text-gray-700 mb-0">Just click &amp; relax, the updater is safe, it won\'t break anything</p>';
            $user_msg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $user_msg .= '    <span aria-hidden="true">&times;</span>';
            $user_msg .= '</button>';
            $user_msg .= '</div>';
            $user_msg .= '<script>';
            $user_msg .= '    var head = document.getElementsByTagName("head")[0];';
            $user_msg .= '    Pace.once(\'hide\', function() {';
            $user_msg .= '      var paceUpdateCss = \'.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;box-sizing:border-box;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;-webkit-background-clip:padding-box;-moz-background-clip:padding;background-clip:padding-box;z-index:2000;position:fixed;margin:auto;top:12px;left:0;right:0;bottom:0;width:200px;height:50px;overflow:hidden}.pace .pace-progress{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;box-sizing:border-box;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-background-clip:padding-box;-moz-background-clip:padding;background-clip:padding-box;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0);display:block;position:absolute;right:100%;margin-right:-7px;width:93%;top:7px;height:14px;font-size:12px;background:#29d;color:#29d;line-height:60px;font-weight:700;font-family:Helvetica,Arial,"Lucida Grande",sans-serif;-webkit-box-shadow:120px 0 #fff,240px 0 #fff;-ms-box-shadow:120px 0 #fff,240px 0 #fff;box-shadow:120px 0 #fff,240px 0 #fff}.pace .pace-progress:after{content:attr(data-progress-text);display:inline-block;position:fixed;width:45px;text-align:right;right:0;padding-right:16px;top:4px}.pace .pace-progress[data-progress-text="0%"]:after{right:-200px}.pace .pace-progress[data-progress-text="1%"]:after{right:-198.14px}.pace .pace-progress[data-progress-text="2%"]:after{right:-196.28px}.pace .pace-progress[data-progress-text="3%"]:after{right:-194.42px}.pace .pace-progress[data-progress-text="4%"]:after{right:-192.56px}.pace .pace-progress[data-progress-text="5%"]:after{right:-190.7px}.pace .pace-progress[data-progress-text="6%"]:after{right:-188.84px}.pace .pace-progress[data-progress-text="7%"]:after{right:-186.98px}.pace .pace-progress[data-progress-text="8%"]:after{right:-185.12px}.pace .pace-progress[data-progress-text="9%"]:after{right:-183.26px}.pace .pace-progress[data-progress-text="10%"]:after{right:-181.4px}.pace .pace-progress[data-progress-text="11%"]:after{right:-179.54px}.pace .pace-progress[data-progress-text="12%"]:after{right:-177.68px}.pace .pace-progress[data-progress-text="13%"]:after{right:-175.82px}.pace .pace-progress[data-progress-text="14%"]:after{right:-173.96px}.pace .pace-progress[data-progress-text="15%"]:after{right:-172.1px}.pace .pace-progress[data-progress-text="16%"]:after{right:-170.24px}.pace .pace-progress[data-progress-text="17%"]:after{right:-168.38px}.pace .pace-progress[data-progress-text="18%"]:after{right:-166.52px}.pace .pace-progress[data-progress-text="19%"]:after{right:-164.66px}.pace .pace-progress[data-progress-text="20%"]:after{right:-162.8px}.pace .pace-progress[data-progress-text="21%"]:after{right:-160.94px}.pace .pace-progress[data-progress-text="22%"]:after{right:-159.08px}.pace .pace-progress[data-progress-text="23%"]:after{right:-157.22px}.pace .pace-progress[data-progress-text="24%"]:after{right:-155.36px}.pace .pace-progress[data-progress-text="25%"]:after{right:-153.5px}.pace .pace-progress[data-progress-text="26%"]:after{right:-151.64px}.pace .pace-progress[data-progress-text="27%"]:after{right:-149.78px}.pace .pace-progress[data-progress-text="28%"]:after{right:-147.92px}.pace .pace-progress[data-progress-text="29%"]:after{right:-146.06px}.pace .pace-progress[data-progress-text="30%"]:after{right:-144.2px}.pace .pace-progress[data-progress-text="31%"]:after{right:-142.34px}.pace .pace-progress[data-progress-text="32%"]:after{right:-140.48px}.pace .pace-progress[data-progress-text="33%"]:after{right:-138.62px}.pace .pace-progress[data-progress-text="34%"]:after{right:-136.76px}.pace .pace-progress[data-progress-text="35%"]:after{right:-134.9px}.pace .pace-progress[data-progress-text="36%"]:after{right:-133.04px}.pace .pace-progress[data-progress-text="37%"]:after{right:-131.18px}.pace .pace-progress[data-progress-text="38%"]:after{right:-129.32px}.pace .pace-progress[data-progress-text="39%"]:after{right:-127.46px}.pace .pace-progress[data-progress-text="40%"]:after{right:-125.6px}.pace .pace-progress[data-progress-text="41%"]:after{right:-123.74px}.pace .pace-progress[data-progress-text="42%"]:after{right:-121.88px}.pace .pace-progress[data-progress-text="43%"]:after{right:-120.02px}.pace .pace-progress[data-progress-text="44%"]:after{right:-118.16px}.pace .pace-progress[data-progress-text="45%"]:after{right:-116.3px}.pace .pace-progress[data-progress-text="46%"]:after{right:-114.44px}.pace .pace-progress[data-progress-text="47%"]:after{right:-112.58px}.pace .pace-progress[data-progress-text="48%"]:after{right:-110.72px}.pace .pace-progress[data-progress-text="49%"]:after{right:-108.86px}.pace .pace-progress[data-progress-text="50%"]:after{right:-107px}.pace .pace-progress[data-progress-text="51%"]:after{right:-105.14px}.pace .pace-progress[data-progress-text="52%"]:after{right:-103.28px}.pace .pace-progress[data-progress-text="53%"]:after{right:-101.42px}.pace .pace-progress[data-progress-text="54%"]:after{right:-99.56px}.pace .pace-progress[data-progress-text="55%"]:after{right:-97.7px}.pace .pace-progress[data-progress-text="56%"]:after{right:-95.84px}.pace .pace-progress[data-progress-text="57%"]:after{right:-93.98px}.pace .pace-progress[data-progress-text="58%"]:after{right:-92.12px}.pace .pace-progress[data-progress-text="59%"]:after{right:-90.26px}.pace .pace-progress[data-progress-text="60%"]:after{right:-88.4px}.pace .pace-progress[data-progress-text="61%"]:after{right:-86.53999999999999px}.pace .pace-progress[data-progress-text="62%"]:after{right:-84.68px}.pace .pace-progress[data-progress-text="63%"]:after{right:-82.82px}.pace .pace-progress[data-progress-text="64%"]:after{right:-80.96000000000001px}.pace .pace-progress[data-progress-text="65%"]:after{right:-79.1px}.pace .pace-progress[data-progress-text="66%"]:after{right:-77.24px}.pace .pace-progress[data-progress-text="67%"]:after{right:-75.38px}.pace .pace-progress[data-progress-text="68%"]:after{right:-73.52px}.pace .pace-progress[data-progress-text="69%"]:after{right:-71.66px}.pace .pace-progress[data-progress-text="70%"]:after{right:-69.8px}.pace .pace-progress[data-progress-text="71%"]:after{right:-67.94px}.pace .pace-progress[data-progress-text="72%"]:after{right:-66.08px}.pace .pace-progress[data-progress-text="73%"]:after{right:-64.22px}.pace .pace-progress[data-progress-text="74%"]:after{right:-62.36px}.pace .pace-progress[data-progress-text="75%"]:after{right:-60.5px}.pace .pace-progress[data-progress-text="76%"]:after{right:-58.64px}.pace .pace-progress[data-progress-text="77%"]:after{right:-56.78px}.pace .pace-progress[data-progress-text="78%"]:after{right:-54.92px}.pace .pace-progress[data-progress-text="79%"]:after{right:-53.06px}.pace .pace-progress[data-progress-text="80%"]:after{right:-51.2px}.pace .pace-progress[data-progress-text="81%"]:after{right:-49.34px}.pace .pace-progress[data-progress-text="82%"]:after{right:-47.480000000000004px}.pace .pace-progress[data-progress-text="83%"]:after{right:-45.62px}.pace .pace-progress[data-progress-text="84%"]:after{right:-43.76px}.pace .pace-progress[data-progress-text="85%"]:after{right:-41.9px}.pace .pace-progress[data-progress-text="86%"]:after{right:-40.04px}.pace .pace-progress[data-progress-text="87%"]:after{right:-38.18px}.pace .pace-progress[data-progress-text="88%"]:after{right:-36.32px}.pace .pace-progress[data-progress-text="89%"]:after{right:-34.46px}.pace .pace-progress[data-progress-text="90%"]:after{right:-32.6px}.pace .pace-progress[data-progress-text="91%"]:after{right:-30.740000000000002px}.pace .pace-progress[data-progress-text="92%"]:after{right:-28.880000000000003px}.pace .pace-progress[data-progress-text="93%"]:after{right:-27.02px}.pace .pace-progress[data-progress-text="94%"]:after{right:-25.16px}.pace .pace-progress[data-progress-text="95%"]:after{right:-23.3px}.pace .pace-progress[data-progress-text="96%"]:after{right:-21.439999999999998px}.pace .pace-progress[data-progress-text="97%"]:after{right:-19.58px}.pace .pace-progress[data-progress-text="98%"]:after{right:-17.72px}.pace .pace-progress[data-progress-text="99%"]:after{right:-15.86px}.pace .pace-progress[data-progress-text="100%"]:after{right:-14px}.pace .pace-activity{position:absolute;width:100%;height:28px;z-index:2001;box-shadow:inset 0 0 0 2px #29d,inset 0 0 0 7px #FFF;border-radius:10px}.pace.pace-inactive{display:none}.pace.pace-active:before { position: fixed; content: " "; width: 100vw; height: 100vh; background: rgba(0,0,0,.75); top: 0; left: 0; }\';';
            $user_msg .= '      var newStyle = document.createElement("style");';
            $user_msg .= '      newStyle.type = "text/css";';
            $user_msg .= '      newStyle.appendChild(document.createTextNode(paceUpdateCss));';
            $user_msg .= '      head.appendChild(newStyle);';
            $user_msg .= '    });';
            $user_msg .= '    var newScript = document.createElement("script");';
            $user_msg .= '    var scriptContent = document.createTextNode(\'var body = document.getElementsByTagName("body")[0];';
            $user_msg .= '    setTimeout(function() {';
            $user_msg .= '        var url = $(\\\'input[name="generator-url"]\\\').val();';
            $user_msg .= '        if ($("#update-btn")[0]) {';
            $user_msg .= '            $("#update-btn").on("click", function() {';
            $user_msg .= '                Pace.track(function() {';
            $user_msg .= '                    $.ajax({';
            $user_msg .= '                        url: url + "update/index.php",';
            $user_msg .= '                        type: "POST",';
            $user_msg .= '                        data: {';
            $user_msg .= '                            update: true';
            $user_msg .= '                        }';
            $user_msg .= '                    })';
            $user_msg .= '                    .done(function(data) {';
            $user_msg .= '                        $("#remodal-content").html(data);';
            $user_msg .= '                        var inst = $($(\\\'div[data-remodal-id="modal"]\\\')).remodal();';
            $user_msg .= '                        inst.open();';
            $user_msg .= '                    })';
            $user_msg .= '                    .fail(function() {';
            $user_msg .= '                        console.log("error");';
            $user_msg .= '                    });';
            $user_msg .= '';
            $user_msg .= '                    $(document)';
            $user_msg .= '                    .off("closed")';
            $user_msg .= '                    .on("closed", ".remodal", function(e) {';
            $user_msg .= '                        location.reload();';
            $user_msg .= '                    });';
            $user_msg .= '                });';
            $user_msg .= '            });';
            $user_msg .= '        }';
            $user_msg .= '    }, 2000);\');';
            $user_msg .= '    newScript.appendChild(scriptContent);';
            $user_msg .= '    head.appendChild(newScript);';
            $user_msg .= '</script>';
        } else {
            /* =============================================
                Do update
            ============================================= */

            $simulate = false;

            echo '<div class="text-center">';

            $updated_versions = array_map(function ($version) {
                    return (string) $version;
            }, $update->getVersionsToUpdate());

            echo 'New Version: ' . $update->getLatestVersion() . '<br>';
            echo 'Installing Updates: <br>';
            // empty log file
            $f = @fopen(__DIR__ . '/update.log', 'r+');
            if ($f !== false) {
                ftruncate($f, 0);
                fclose($f);
            }
            if ($simulate === true) {
                echo '<pre>';
                var_dump(array_map(function ($version) {
                    return (string) $version;
                }, $update->getVersionsToUpdate()));
                echo '</pre>';

                // This call will only simulate an update.
                // Set the first argument (simulate) to "false" to install the update
                // i.e. $update->update(false);
                $result = $update->update();
            } else {
                //Install new update
                $result = $update->update(false);
            }

            if ($result === true) {
                if ($simulate === true) {
                    echo '<p class="text-success mb-3">Update simulation successful</p>';
                } else {
                    echo '<p class="text-success mb-3">Update successful</p><p>Open <a href="https://www.phpcrudgenerator.com/documentation/index#changelog">/documentation/index</a> to see the changelog.</p>';
                }
            } else {
                if ($simulate === true) {
                    echo '<p class="text-danger mb-3">Update simulation failed: ' . $result . '!</p>';
                } else {
                    echo '<p class="text-danger mb-3">Update failed: ' . $result . '!</p><p><a href="https://www.phpcrudgenerator.com/help-center#update-errors" target="_blank">Help me please!</a></p>';
                }

                if ($result == AutoUpdate::ERROR_SIMULATE) {
                    echo '<pre>';
                    var_dump($update->getSimulationResults());
                    echo '</pre>';
                }
            }

            if ($simulate === true) {
                echo 'Log:<br>';
                echo nl2br(file_get_contents(__DIR__ . '/update.log'));
                echo '<br>';
            }

            echo '<p>Close this frame to reload the page</p>';
            echo '<p>If you see some PHP warnings after reloading, clear your PHP SESSION (or just close and reopen your browser).</p>';
            echo '</div>';
        }
    } else {
        //  shouldn't occur, as there's no update button if version is up to date
        echo '<p class="text-right bg-indigo-600 text-indigo-200 px-4 py-1">Current Version is up to date</p>';
    }
}

if (!empty($user_msg)) {
    echo $user_msg;
}
