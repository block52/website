<?php
use phpformbuilder\database\Mysql;
use common\Utils;

include_once '../../conf/conf.php';
// var_dump($_POST);
preg_match('`([a-zA-Z0-9_]+)-([a-zA-Z0-9_-]+)-([a-zA-Z0-9_-]+)-([0-9]+)`', $_POST['id'], $out);
$table = $out[1];
$champ = $out[2];
$pk_name = $out[3];
$pk_value = $out[4];
if (isset($_POST['value_submit'])) { // pickadate
    $new_value = $_POST['value_submit'];
} else {
    $new_value = $_POST['value'];
}
$display = $_POST['value'];
$filter[$pk_name] = Mysql::SQLValue($pk_value);
$update[$champ] = Mysql::SQLValue($new_value);
$db = new Mysql();
if (DEMO !== true) {
    $db->updateRows($table, $update, $filter);

// echo $db->getLastSql();
    echo $display;
} else {
     echo addslashes($display);
        ?>
     <script type="text/javascript">alert('live edit disabled in demo');</script>
        <?php
}

/*value' => string '1' (length=1)
  'id' => string 'users-active-ID-1' (length=17)*/
