<?php
$json = json_decode($_POST['data']);

foreach ($json as $var => $val) {
    ${$var} = $val;
}
$details = '';
if (!empty($name) && !empty($value)) {
    $txt = '<small>is equal to</small>';
    if (preg_match('`,`', $value)) {
        $txt = '<small>is one of these values:</small>';
    }
    $details = '<br><small>show if</small> <span class="badge badge-secondary text-light">' . $name . '</span> ' . $txt . ' <span class="badge badge-secondary text-light">' . $value . '</span>';
}
echo '<p class="text-yellow-700 bg-yellow-200 text-center align-self-center mb-0">-- Dependent fields start --' . $details . '</p>';
