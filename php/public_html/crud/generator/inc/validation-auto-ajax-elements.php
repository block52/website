<?php
use phpformbuilder\Form;
use phpformbuilder\FormExtended;

include_once '../class/generator/Generator.php';

@session_start();

if (isset($_SESSION['generator']) && isset($_GET['columnName']) && preg_match('([0-9a-zA-Z_-]+)', $_GET['columnName']) && isset($_GET['fieldType']) && preg_match('([a-z]+)', $_GET['fieldType']) && isset($_GET['passwordValue']) && (preg_match('([0-9a-z-]+)', $_GET['passwordValue']) || empty($_GET['passwordValue']))) {
    include_once '../../conf/conf.php';

    $generator      = $_SESSION['generator'];
    $column_name    = $_GET['columnName'];
    $field_type     = $_GET['fieldType'];
    $password_value = $_GET['passwordValue'];
    $column_index   = array_search($column_name, $generator->columns['name']);

    /*
    columns types list : ( = database columns)
        boolean|tinyint|smallint|mediumint|int|bigint|decimal|float|double|real|date|datetime|timestamp|time|year|char|varchar|tinytext|text|mediumtext|longtext|enum|set

    field types list : ( = create update fields)
        boolean|checkbox|color|date|datetime|email|file|hidden|image|month|number|password|radio|select|text|textarea|time|url
     */

    $column_type    = $generator->columns['column_type'][$column_index];

    // reset
    for ($i=0; $i < 10; $i++) {
        unset($_SESSION['form']['cu_auto_validation_function_' . $column_name . '-' . $i]);
        unset($_SESSION['form']['cu_auto_validation_arguments_' . $column_name . '-' . $i]);
    }

    $form = new FormExtended('form', 'horizontal', 'novalidate');

    // index of validation fields
    $i = 0;

    $validation = array();

    if ($generator->columns['required'][$column_index] === true) {
        $validation['required'] = '';
    }

    /* =============================================
    Validate according to field types
    ============================================= */

    if ($field_type == 'boolean') {
        $validation['integer'] = '';
        $validation['min'] = '0';
        $validation['max'] = '1';
    } elseif ($field_type == 'date' || $field_type == 'datetime' || $field_type == 'month' || $field_type == 'time') {
        $validation['date'] = '';
    } elseif ($field_type == 'email') {
        $validation['email'] = '';
    } elseif ($field_type == 'number') {
        // user set field type = number, but column type is not a number field (varchar, ...)
        $validation['float'] = '';
    } elseif ($field_type == 'password') {
        if ($password_value != '') {
            preg_match('`(lower-)?(upper-)?(number-)?(symbol-)?(min-)([3-8])$`', $password_value, $out);
            if (!empty($out[1])) {
                $validation['hasLowercase'] = '';
            }
            if (!empty($out[2])) {
                $validation['hasUppercase'] = '';
            }
            if (!empty($out[3])) {
                $validation['hasNumber'] = '';
            }
            if (!empty($out[4])) {
                $validation['hasSymbol'] = '';
            }
            if (!empty($out[6])) {
                $validation['minLength'] = $out[6];
            }
        }
    } elseif ($field_type == 'url') {
        $validation['url'] = '';
    }

    /* =============================================
    Deduct validation from db column type
    ============================================= */

    $db_column_type_validation = $generator->getValidation($column_type, $column_index);
    foreach ($db_column_type_validation as $v) {
        if (!in_array($v['function'], $validation)) {
            $function              = $v['function'];
            $args                  = $v['args'];
            $validation[$function] = $args;
        }
    }

    /* render elements */

    $i = 0;
    foreach ($validation as $function => $args) {
        $_SESSION['form']['cu_auto_validation_function_' . $column_name . '-' . $i] = $function;
        $_SESSION['form']['cu_auto_validation_arguments_' . $column_name . '-' . $i] = $args;
        $helper_text = $validation_helper_texts[$function];
        $form->addValidationAutoFields($column_name, $i, $function, $args, $helper_text);
        $i++;
    }

    echo $form->html;
}
