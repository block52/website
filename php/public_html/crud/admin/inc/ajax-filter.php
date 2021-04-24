<?php
use phpformbuilder\database\Mysql;

function sqlProtect($field)
{
    return '`' . str_replace('.', '`.`', $field) . '`';
}

session_start();
$error = false;
$out = array(
    'results' => array(),
    'pagination' => array(
        'more' => false
    )
);
if (
    !isset($_SESSION['filters_ajax']) ||
    !isset($_GET['selectname']) ||
    !isset($_GET['search']) ||
    !isset($_GET['page'])) {
    $error = true;
}
include_once '../../conf/conf.php';
include_once CLASS_DIR . 'phpformbuilder/Form.php';

$filters_ajax = addslashes($_GET['filters_ajax']);
$selectname   = $_GET['selectname'];
$search       = $_GET['search'];
$page         = $_GET['page'];

if (
    !isset($_SESSION['filters_ajax'][$selectname]) ||
    !isset($_SESSION['filters_ajax'][$selectname]['table']) ||
    !isset($_SESSION['filters_ajax'][$selectname]['field_to_filter']) ||
    !isset($_SESSION['filters_ajax'][$selectname]['option_text']) ||
    !isset($_SESSION['filters_ajax'][$selectname]['qry'])) {
    $error = true;
}
// var_dump($_SESSION['filters_ajax'][$selectname]);
// var_dump($error);
if ($error === false) {
    $table           = $_SESSION['filters_ajax'][$selectname]['table'];
    $filter = array(
        'field_to_filter' => $_SESSION['filters_ajax'][$selectname]['field_to_filter'],
        'option_text'     => $_SESSION['filters_ajax'][$selectname]['option_text']
    );
    $qry = $_SESSION['filters_ajax'][$selectname]['qry'];

    $where = 'AND ';
    $field_value = preg_replace('`[^.]+\.`', '', $filter['field_to_filter']);
    if (strpos($qry, 'WHERE') === false) {
        $where = 'WHERE ';
    }

    if (preg_match('`[\s]?\+[\s]?`', $filter['option_text'])) {

        /* if the option text combines 2 values
           ie: actor.firstname + actor.name
        -------------------------------------------------- */

        // $field_text_fields = ['actor.firstname', 'actor.name']
        $field_text_fields = preg_split('`[\s]?\+[\s]?`', $filter['option_text']);

        // $field_text = ['firstname', 'name']
        $field_text = array(
            preg_replace('`[^.]+\.`', '', $field_text_fields[0]),
            preg_replace('`[^.]+\.`', '', $field_text_fields[1])
        );
        $condition = $where . '(' . sqlProtect($field_text_fields[0]) . ' LIKE ' . Mysql::sqlValue('%' . $search . '%', Mysql::SQLVALUE_TEXT) . ' OR ' . sqlProtect($field_text_fields[1]) . ' LIKE ' . Mysql::sqlValue('%' . $search . '%', Mysql::SQLVALUE_TEXT) . ')';
    } else {
        $field_text_fields = $filter['option_text'];
        $field_text        = preg_replace('`[^.]+\.`', '', $filter['option_text']);
        $condition = $where . sqlProtect($field_text_fields) . ' LIKE ' . Mysql::sqlValue('%' . $search . '%', Mysql::SQLVALUE_TEXT);
    }

    $number_of_results = 10;
    // we get one more result than $number_of_results
    // it allows to know if some more results exist beyond the query
    $limit_query = ' LIMIT ' . (($page - 1) * $number_of_results)  . ',' . ($number_of_results + 1);
    $qry = str_replace('ORDER BY', $condition . ' ORDER BY', $qry) . $limit_query;
    // var_dump($qry);
    $db = new Mysql();
    $db->query($qry);
    $values_count = $db->rowCount();
    if (!empty($values_count)) {
        if ($values_count > $number_of_results) {
            $out['pagination'] = array(
                'more' => true
            );
        }
        $used_values = array();
        for ($i=0; $i < $values_count; $i++) {
            $row = $db->row();
            $test_if_json = json_decode($row->$field_value);
            if (json_last_error() == JSON_ERROR_NONE && is_array($test_if_json)) {
                foreach ($test_if_json as $value) {
                    if (!in_array($value, $used_values)) {
                        $out['results'][] = array(
                            'id' => '~' . $value . '~',
                            'text' => $value
                        );
                        $used_values [] = $value;
                    }
                }
            } else {
                if (is_array($field_text)) {
                    $f0 = $field_text[0];
                    $f1 = $field_text[1];
                    $option_text = $row->$f0 . '/' . $row->$f1;
                } else {
                    $option_text = $row->$field_text;
                }
                $option_value = $row->$field_value;
                $out['results'][] = array(
                    'id' => $option_value,
                    'text' => $option_text
                );
            }
        }
    }
}

echo json_encode($out);

/*
$_SESSION['filters_ajax'][$selectname] = array(
                        'field_to_filter' => $filter['field_to_filter'],
                        'qry' => $qry
                    );
*/

/* {
  "results": [
    {
      "id": 1,
      "text": "Option 1"
    },
    {
      "id": 2,
      "text": "Option 2"
    }
  ],
  "pagination": {
    "more": true
  }
} */


/*
// if json values => $_SESSION['filters-list'][$field_var] = ~value~
                if (preg_match('`^~([^~]+)~$`', $_SESSION['filters-list'][$field_var], $out)) {
                    $qry_where.= $transition . 'JSON_CONTAINS(' . $this->sqlProtect($field_to_filter) . ', \'["' . $out[1] . '"]\')';
                } else {
                    if (is_numeric($_SESSION['filters-list'][$field_var])) {
                        $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_NUMBER);
                    } else {
                        $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_TEXT);
                    }
                    $qry_where.= $transition . $this->sqlProtect($field_to_filter) . ' = ' . $field_var_sqlvalue;
                }
*/
