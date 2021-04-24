<?php
use phpformbuilder\Form;
use phpformbuilder\database\Mysql;
use generator\Generator;
use common\Utils;

include_once '../class/generator/Generator.php';

@session_start();
if (isset($_SESSION['generator']) && isset($_POST['column']) && preg_match('([0-9a-zA-Z_-]+)', $_POST['column'])) {
    include_once '../../conf/conf.php';
    if (DEMO !== true) {
        $generator            = $_SESSION['generator'];
        $editable_column      = $_POST['column'];
        $select_from          = $_POST['select_from'];
        $select_from_table    = $_POST['select_from_table'];
        $select_from_value    = $_POST['select_from_value'];
        $select_from_field_1  = $_POST['select_from_field_1'];
        $select_from_field_2  = $_POST['select_from_field_2'];
        $select_multiple      = $_POST['select_multiple'];
        $select_custom_names_values = '';
        if (is_array($_POST['select_custom_names'])) {
            $select_custom_names_values = array();
            for ($i=0; $i < count($_POST['select_custom_names']); $i++) {
                $name  = addslashes($_POST['select_custom_names'][$i]['value']);
                $value = addslashes($_POST['select_custom_values'][$i]['value']);
                $select_custom_names_values[$name] = $value;
            }
        }
        $generator->registerSelectValues($editable_column, $select_from, $select_from_table, $select_from_value, $select_from_field_1, $select_from_field_2, $select_custom_names_values, $select_multiple);
        $select_values = $generator->getSelectValues($editable_column);

        echo $select_values;
    }
}
