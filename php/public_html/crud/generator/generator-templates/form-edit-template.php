<?php
use phpformbuilder\database\Mysql;
use generator\TemplatesUtilities;
use common\Utils;
use crud\ElementsUtilities;

include_once GENERATOR_DIR . 'class/generator/TemplatesUtilities.php';
include_once ADMIN_DIR . 'class/crud/ElementsUtilities.php';

$generator = $_SESSION['generator'];
$form_id = 'form-edit-' . str_replace('_', '-', $generator->table);
$has_fileuploader = false;
if (in_array('image', $generator->columns['field_type']) || in_array('file', $generator->columns['field_type'])) {
    $has_fileuploader = true;
}


/* External fields
-------------------------------------------------- */

/*
$generator->external_columns = array(
    'target_table'       => '',
    'target_fields'      => array(),
    'table_label'        => '',
    'fields_labels'      => array(),
    'relation'           => '',
    'allow_crud_in_list' => false,
    'allow_in_forms'     => true,
    'forms_fields'       => array(),
    'field_type'         => array(), // 'select-multiple' | 'checkboxes'
    'active'             => false
);

// relation = $generator->relations['from_to'][$i]
*/

$show_external = false;
$active_ext_cols = array();
foreach ($generator->external_columns as $key => $ext_col) {
    if ($ext_col['active'] === true && !empty($ext_col['relation']['intermediate_table']) && $ext_col['allow_in_forms'] === true) {
        $show_external = true;
        $active_ext_cols[] = $ext_col;
    }
}

echo '<?php' . "\n";
?>
use phpformbuilder\Form;
<?php if ($has_fileuploader === true) { ?>
use fileuploader\server\FileUploader;
<?php } ?>
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use common\Utils;
use secure\Secure;

include_once ADMIN_DIR . 'secure/class/secure/Secure.php';
<?php if ($has_fileuploader === true) { ?>
include_once CLASS_DIR . 'phpformbuilder/plugins/fileuploader/server/class.fileuploader.php';
<?php } ?>

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('<?php echo $form_id; ?>') === true) {
    include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
    include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
<?php

/* =============================================
Create validation statements
============================================= */

for ($i=0; $i < $generator->columns_count; $i++) {
    $column_name       = $generator->columns['name'][$i];
    $column_type       = $generator->columns['column_type'][$i];
    $column_validation = $generator->columns['validation'][$i];
    $field_type        = $generator->columns['field_type'][$i];

    if (!empty($column_validation) && is_array($column_validation) && ($column_name != $generator->primary_key)) {
        $validation = $column_validation;

        // validate password only if not empty
        if ($field_type == 'password') {
?>
    if (!empty($_POST['<?php echo $column_name; ?>'])) {
<?php
        }

        for ($j=0; $j < count($validation); $j++) {
            $validation_function = $validation[$j]['function'];
            $validation_args     = $validation[$j]['args'];
            if ($validation_function == 'date' || $validation_function == 'minDate' || $validation_function == 'maxDate') {
?>
    if (isset($_POST['<?php echo $column_name; ?>_submit'])) {
        $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>_submit');
    } else {
        $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>');
    }
<?php
            } elseif ($field_type == 'password') {
                if ($validation_function == 'required') {
                    // password required => skip
                } else {
?>
    $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>');
<?php
                }
            } elseif ($generator->columns['select_multiple'][$i] > 0 || $field_type == 'checkbox') {
                // Array values
                if ($validation_function == 'required') {
                    // validate only 1st entry
?>
    $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>.0');
<?php
                } elseif ($validation_function == 'maxLength') {
                    // validate json encoded value
?>
    $json_value = json_encode($_POST['<?php echo $column_name; ?>']);
    $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate($json_value, JSON_UNESCAPED_UNICODE);
<?php
                } else {
                    // validate each entry
                    // used for all validation functions except required and maxLength
?>
    if (is_array($_POST['<?php echo $column_name; ?>']) || $_POST['<?php echo $column_name; ?>'] instanceof Countable) {
        $count = count($_POST['<?php echo $column_name; ?>']);
        for ($i=0; $i < $count; $i++) {
            $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>.' . $i);
        }
    }
<?php
                }
            } else {
?>
    $validator-><?php echo $validation_function; ?>(<?php echo $validation_args; ?>)->validate('<?php echo $column_name; ?>');
<?php
            }
        }

        // validate password only if not empty
        if ($field_type == 'password') {
?>
    } // end password optional validation
<?php
        }
    }
}
?>

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['<?php echo $form_id; ?>'] = $validator->getAllErrors();
    } else {
        require_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
        require_once CLASS_DIR . 'phpformbuilder/database/Mysql.php';
        $db = new Mysql();
<?php

/* =============================================
Create update query
============================================= */

/* field_types : boolean|checkbox|color|date|datetime|email|file|hidden|image|month|number|password|radio|select|text|textarea|time|url */

for ($i=0; $i < $generator->columns_count; $i++) {
    $column_name = $generator->columns['name'][$i];
    $column_type = $generator->columns['column_type'][$i];
    $field_type  = $generator->columns['field_type'][$i];

    // skip primary key
    if ($column_name != $generator->primary_key) {
        if ($field_type == 'text' || $field_type == 'color' || $field_type == 'email' || $field_type == 'textarea' || $field_type == 'radio' || $field_type == 'hidden' || $field_type == 'url') {
?>
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($_POST['<?php echo $column_name; ?>'], Mysql::SQLVALUE_TEXT);
<?php
        } elseif ($field_type == 'file') {
?>
        if (!empty($_POST['<?php echo $column_name; ?>']) && $_POST['<?php echo $column_name; ?>'] != '[]') {
            $posted_file = FileUploader::getPostedFiles($_POST['<?php echo $column_name; ?>']);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($posted_file[0]['file'], Mysql::SQLVALUE_TEXT);
        } else {
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue('', Mysql::SQLVALUE_TEXT);
        }
<?php
        } elseif ($field_type == 'image') {
?>
        if (!empty($_POST['<?php echo $column_name; ?>']) && $_POST['<?php echo $column_name; ?>'] != '[]') {
            $posted_img = FileUploader::getPostedFiles($_POST['<?php echo $column_name; ?>']);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($posted_img[0]['file'], Mysql::SQLVALUE_TEXT);
        } else {
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue('', Mysql::SQLVALUE_TEXT);
        }
<?php
        } elseif ($field_type == 'number') {
?>
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($_POST['<?php echo $column_name; ?>'], Mysql::SQLVALUE_NUMBER);
<?php
        } elseif ($field_type == 'password') {
?>
        if (!empty($_POST['<?php echo $column_name; ?>'])) {
            $password = Secure::encrypt($_POST['<?php echo $column_name; ?>']);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($password, Mysql::SQLVALUE_TEXT);
        }
<?php
        } elseif ($field_type == 'select') {
?>
        if (is_array($_POST['<?php echo $column_name; ?>'])) {
<?php
if ($column_type == 'enum' || $column_type == 'set') {
?>
            $values = implode(',', $_POST['<?php echo $column_name; ?>']);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($values);
<?php
} else {
?>
            $json_values = json_encode($_POST['<?php echo $column_name; ?>'], JSON_UNESCAPED_UNICODE);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($json_values);
<?php
}
?>
        } else {
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($_POST['<?php echo $column_name; ?>'], Mysql::SQLVALUE_TEXT);
        }
<?php
        } elseif ($field_type == 'boolean') {
?>
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($_POST['<?php echo $column_name; ?>'], Mysql::SQLVALUE_BOOLEAN);
<?php
        } elseif ($field_type == 'checkbox') {
            if ($column_type == 'enum' || $column_type == 'set') {
?>
            $values = implode(',', $_POST['<?php echo $column_name; ?>']);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($values);
<?php
            } else {
?>
            $json_values = json_encode($_POST['<?php echo $column_name; ?>'], JSON_UNESCAPED_UNICODE);
            $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($json_values);
<?php
            }
        } elseif ($field_type == 'date' || $field_type == 'month') {
?>
        $value = $_POST['<?php echo $column_name; ?>'];
        if (isset($_POST['<?php echo $column_name; ?>_submit'])) {
            $value = $_POST['<?php echo $column_name; ?>_submit'];
        }
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($value, Mysql::SQLVALUE_DATE);
<?php
        } elseif ($field_type == 'datetime') {
            if ($special3 > 0) {
?>
        $value = Mysql::SQLValue($_POST['<?php echo $column_name; ?>'], Mysql::SQLVALUE_DATETIME);
<?php
            } else {
?>
        $value_date = $_POST['<?php echo $column_name; ?>'];
        $value_time = $_POST['<?php echo $column_name; ?>-time'];
        if (isset($_POST['<?php echo $column_name; ?>_submit'])) {
            $value_date = $_POST['<?php echo $column_name; ?>_submit'];
        }
        if (isset($_POST['<?php echo $column_name; ?>-time_submit'])) {
            $value_time = $_POST['<?php echo $column_name; ?>-time_submit'];
        }
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($value_date . ' ' . $value_time, Mysql::SQLVALUE_DATETIME);
<?php
            }
        } elseif ($field_type == 'time') {
?>
        $value = $_POST['<?php echo $column_name; ?>'];
        if (isset($_POST['<?php echo $column_name; ?>_submit'])) {
            $value = $_POST['<?php echo $column_name; ?>_submit'];
        }
        $update['<?php echo $column_name; ?>'] = Mysql::SQLValue($value, Mysql::SQLVALUE_TIME);
<?php
        }
    } // END if
} // END for

/* =============================================
DB UPDATE
============================================= */

?>
        $filter["<?php echo $generator->primary_key; ?>"] = Mysql::SQLValue($_SESSION['<?php echo $generator->table; ?>_editable_primary_key'], Mysql::SQLVALUE_NUMBER);
        $db->throwExceptions = true;
        try {
            // begin transaction
            $db->transactionBegin();

            // update <?php echo $generator->table; ?>

            if (DEMO !== true && !$db->updateRows('<?php echo $generator->table; ?>', $update, $filter)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            } else {
<?php

/* External fields
-------------------------------------------------- */

/*
$generator->external_columns = array(
    'target_table'       => '',
    'target_fields'      => array(),
    'table_label'        => '',
    'fields_labels'      => array(),
    'relation'           => '',
    'allow_crud_in_list' => false,
    'allow_in_forms'     => true,
    'forms_fields'       => array(),
    'field_type'         => array(), // 'select-multiple' | 'checkboxes'
    'active'             => false
);

// relation = $generator->relations['from_to'][$i]
*/

if ($show_external === true) {
    foreach ($active_ext_cols as $key => $ext_col) {
        $origin_table       = $ext_col['relation']['origin_table'];
        $intermediate_table = $ext_col['relation']['intermediate_table'];
        $target_table       = $ext_col['relation']['target_table'];
        $table_label        = $ext_col['table_label'];
        $relation_origin_column = $ext_col['relation']['intermediate_column_1'];
        $relation_target_column = $ext_col['relation']['intermediate_column_2'];
        // (products => products_categories => categories)

        // get the primary key of the target table
        // many to many
        $intermediate_table_pk_column = 'unknown_primary_key';

        $db = new Mysql();
        $db->selectDatabase($generator->database);
        $qry = 'SHOW COLUMNS FROM ' . $intermediate_table;
        $db->query($qry);
        $columns_count = $db->rowCount();
        if (!empty($columns_count)) {
            while (! $db->endOfSeek()) {
                $row = $db->row();

                // last row is table comments, skip it.
                if (isset($row->Field)) {
                    if ($row->Key == 'PRI') {
                        $intermediate_table_pk_column  = $row->Field;
                    }
                }
            }
        }
?>
                // get records from <?php echo $intermediate_table ?>

                // = Array with <?php echo $intermediate_table; ?>.<?php echo $intermediate_table_pk_column; ?>_value => <?php echo $target_table; ?>.<?php echo $relation_target_column; ?>_value

                $<?php echo $intermediate_table ?>_current_records   = array();

                // Array with <?php echo $target_table; ?>.<?php echo $relation_target_column; ?>

                $<?php echo $intermediate_table ?>_records_to_add    = array();

                // Array with <?php echo $intermediate_table; ?>.<?php echo $intermediate_table_pk_column; ?>

                $<?php echo $intermediate_table ?>_records_to_delete = array();

                $<?php echo $generator->table; ?>_value = Mysql::SQLValue($_SESSION['<?php echo $generator->table; ?>_editable_primary_key'], Mysql::SQLVALUE_NUMBER);

                $qry = 'SELECT <?php echo $intermediate_table_pk_column; ?>, <?php echo $relation_target_column; ?> FROM <?php echo $intermediate_table; ?> WHERE <?php echo $relation_origin_column; ?> = ' . $<?php echo $generator->table; ?>_value;
                $db->query($qry);
                $db_count = $db->rowCount();
                if (!empty($db_count)) {
                    while (! $db->endOfSeek()) {
                        $row = $db->row();
                        $<?php echo $intermediate_table; ?>_<?php echo $intermediate_table_pk_column; ?>_value = $row-><?php echo $intermediate_table_pk_column; ?>;
                        $<?php echo $target_table; ?>_<?php echo $relation_target_column; ?>_value = $row-><?php echo $relation_target_column; ?>;

                        $<?php echo $intermediate_table ?>_current_records[$<?php echo $intermediate_table; ?>_<?php echo $intermediate_table_pk_column; ?>_value] = $<?php echo $target_table; ?>_<?php echo $relation_target_column; ?>_value;
                    }
                }

                foreach ($_POST['ext_<?php echo $target_table; ?>'] as $<?php echo $target_table ?>_value) {
                    if (!in_array($<?php echo $target_table ?>_value, $<?php echo $intermediate_table ?>_current_records)) {
                        $<?php echo $intermediate_table ?>_records_to_add[] = $<?php echo $target_table ?>_value;
                    }
                }

                foreach ($<?php echo $intermediate_table ?>_current_records as $<?php echo $intermediate_table ?>_key => $<?php echo $target_table ?>_value) {
                    if (!in_array($<?php echo $target_table ?>_value, $_POST['ext_<?php echo $target_table; ?>'])) {
                        $<?php echo $intermediate_table ?>_records_to_delete[] = $<?php echo $intermediate_table ?>_key;
                    }
                }

                // insert records in <?php echo $intermediate_table ?>

                foreach ($<?php echo $intermediate_table ?>_records_to_add as $value) {
                    try {
                        // begin transaction
                        $db->transactionBegin();

                        $insert = array();
                        $insert['<?php echo $intermediate_table_pk_column; ?>'] = Mysql::sqlValue('');
                        $insert['<?php echo $relation_origin_column; ?>'] = Mysql::SQLValue($_SESSION['<?php echo $generator->table; ?>_editable_primary_key'], Mysql::SQLVALUE_NUMBER);
                        $insert['<?php echo $relation_target_column; ?>'] = Mysql::sqlValue($value, Mysql::SQLVALUE_NUMBER);
                        if (DEMO !== true && !$db->insertRow('<?php echo $intermediate_table; ?>', $insert)) {
                            $error = $db->error();
                            $db->transactionRollback();
                            throw new \Exception($error);
                        } else {
                            $db->transactionEnd();
                        }
                    } catch (\Exception $e) {
                        $msg_content = DB_ERROR;
                        if (ENVIRONMENT == 'development') {
                            $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
                        }
                        $_SESSION['msg'] = Utils::alert($msg_content, 'alert-danger has-icon');
                    }
                }

                // delete records from <?php echo $intermediate_table ?>

                foreach ($<?php echo $intermediate_table ?>_records_to_delete as $value) {
                    try {
                        // begin transaction
                        $db->transactionBegin();

                        $filter = array();
                        $update = array();
                        $filter['<?php echo $intermediate_table_pk_column; ?>'] = Mysql::sqlValue($value, Mysql::SQLVALUE_NUMBER);
                        if (DEMO !== true && !$db->deleteRows('<?php echo $intermediate_table; ?>', $filter)) {
                            $error = $db->error();
                            $db->transactionRollback();
                            throw new \Exception($error);
                        } else {
                            $db->transactionEnd();
                        }
                    } catch (\Exception $e) {
                        $msg_content = DB_ERROR;
                        if (ENVIRONMENT == 'development') {
                            $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
                        }
                        $_SESSION['msg'] = Utils::alert($msg_content, 'alert-danger has-icon');
                    }
                }

<?php
    } // end foreach
} // end if
?>
                if (!isset($error)) {
                    // ALL OK
                    $db->transactionEnd();
                    $_SESSION['msg'] = Utils::alert(UPDATE_SUCCESS_MESSAGE, 'alert-success has-icon');

                    // reset form values
                    Form::clear('<?php echo $form_id; ?>');

                    // redirect to list page
                    if (isset($_SESSION['active_list_url'])) {
                        header('Location:' . $_SESSION['active_list_url']);
                    } else {
                        header('Location:' . ADMIN_URL . '<?php echo $generator->item; ?>');
                    }

                    // if we don't exit here, $_SESSION['msg'] will be unset
                    exit();
                }
            }
        } catch (\Exception $e) {
            $msg_content = DB_ERROR;
            if (ENVIRONMENT == 'development') {
                $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
            }
            $_SESSION['msg'] = Utils::alert($msg_content, 'alert-danger has-icon');
        }
    } // END else
} // END if POST
<?php

/* =============================================
get values from DB for form edit
============================================= */

$primary_key = $generator->primary_key;
?>
$<?php echo $primary_key; ?> = $pk;

// register editable primary key, which is NOT posted and will be the query update filter
$_SESSION['<?php echo $generator->table; ?>_editable_primary_key'] = $<?php echo $primary_key; ?>;

if (!isset($_SESSION['errors']['<?php echo $form_id; ?>']) || empty($_SESSION['errors']['<?php echo $form_id; ?>'])) { // If no error registered
<?php
// create join queries
$from_to = $generator->relations['from_to'];
$join_query = array();
$used_tables = array();
if (is_array($from_to)) {
    foreach ($from_to as $ft) {
        if ($ft['origin_table'] == $generator->table && $ft['target_table'] != $generator->table) {
            if (empty($ft['intermediate_table'])) {
                /* one-to one */

                if (!in_array($ft['target_table'], $used_tables)) {
                    $join_query[] = ' LEFT JOIN `' . $ft['target_table'] . '` ON `' . $ft['origin_table'] . '`.`' . $ft['origin_column'] . '`=`' . $ft['target_table'] . '`.`' . $ft['target_column'] . '`';
                } else {
                    $join_query[] = ' AND `' . $ft['origin_table'] . '`.`' . $ft['origin_column'] . '`=`' . $ft['target_table'] . '`.`' . $ft['target_column'] . '`';
                }
                $used_tables[] = $ft['target_table'];
            } else {
                /* many-to-many */
            }
        }
    }
}

// register column_count including relation fields
$join_query    = implode('', $join_query);

// get fields list
$fields = array();
foreach ($generator->columns['name'] as $colname) {
    $fields[] = '`' . $generator->table . '`.`' . $colname . '`';
}
$fields = implode(', ', $fields);

if (!empty($join_query)) {
?>
    $qry = "SELECT <?php echo $fields; ?> FROM `<?php echo $generator->table; ?>` <?php echo $join_query; ?>";
<?php
} else {
?>
    $qry = "SELECT * FROM `<?php echo $generator->table; ?>`";
<?php
}
?>

    $transition = 'WHERE';

    // if restricted rights
    if (ADMIN_LOCKED === true && Secure::canUpdateRestricted('<?php echo $generator->table; ?>')) {
        $qry .= Secure::getRestrictionQuery('<?php echo $generator->table; ?>');
        $transition = 'AND';
    }
    $qry .= ' ' . $transition . " <?php echo $generator->table; ?>.<?php echo $primary_key; ?> = '$<?php echo $primary_key; ?>'";

    $db = new Mysql();

    // echo $qry . '<br>';

    $db->query($qry);
    if ($db->rowCount() < 1) {
        if (DEBUG === true) {
            exit($db->getLastSql() . ' : No Record Found');
        } else {
            Secure::logout();
        }
    }
    $row = $db->row();
<?php
for ($i=0; $i < $generator->columns_count; $i++) {
    $column_name = $generator->columns['name'][$i];
    $column_type = $generator->columns['column_type'][$i];
    $field_type  = $generator->columns['field_type'][$i];
    if ($field_type == 'datetime') {
        if ($generator->columns['special3'][$i] < 1) {
?>
    $<?php echo $column_name; ?>_ts = strtotime($row-><?php echo $column_name; ?>);
    if (Utils::isValidTimeStamp($<?php echo $column_name; ?>_ts)) {
        $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('Y-m-d', $<?php echo $column_name; ?>_ts);
        $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>-time'] = date('H:i', $<?php echo $column_name; ?>_ts);
    }
<?php
        } else {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('Y-m-d H:i');
<?php
        }
    } elseif ($field_type == 'date') {
        if ($generator->columns['special3'][$i] < 1) {
?>
    $<?php echo $column_name; ?>_ts = strtotime($row-><?php echo $column_name; ?>);
    if (Utils::isValidTimeStamp($<?php echo $column_name; ?>_ts)) {
        $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('Y-m-d', $<?php echo $column_name; ?>_ts);
    }
<?php
        } else {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('Y-m-d');
<?php
        }
    } elseif ($field_type == 'time') {
        if ($generator->columns['special3'][$i] < 1) {
?>
    $<?php echo $column_name; ?>_ts = strtotime($row-><?php echo $column_name; ?>);
    if (Utils::isValidTimeStamp($<?php echo $column_name; ?>_ts)) {
        $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('H:i', $<?php echo $column_name; ?>_ts);
    }
<?php
        } else {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('H:i');
<?php
        }
    } elseif ($field_type == 'month') {
        if ($generator->columns['special3'][$i] < 1) {
?>
    $<?php echo $column_name; ?>_ts = strtotime($row-><?php echo $column_name; ?>);
    if (Utils::isValidTimeStamp($<?php echo $column_name; ?>_ts)) {
        $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('m', $<?php echo $column_name; ?>_ts);
    }
<?php
        } else {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = date('m');
<?php
        }
    } elseif ($column_type == 'enum' || $column_type == 'set') {
?>
    $values = explode(',', $row-><?php echo $column_name; ?>);
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = array();
    if (!empty($values)) {
        foreach ($values as $value) {
            $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'][] = $value;
        }
    }
<?php
    } elseif ($generator->columns['select_multiple'][$i] > 0 || $field_type == 'checkbox') {
?>
    $values = json_decode($row-><?php echo $column_name; ?>, true);
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = array();
    if (!empty($values)) {
        foreach ($values as $value) {
            $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'][] = $value;
        }
    }
<?php
    } elseif ($field_type != 'password') {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = $row-><?php echo $column_name; ?>;
<?php
    } else {
?>
    $_SESSION['<?php echo $form_id; ?>']['<?php echo $column_name; ?>'] = '';
<?php
    }
} // END for
?>
}
<?php


/* =============================================
    get external relation values for form edit
============================================= */

if ($show_external === true) {
    foreach ($active_ext_cols as $key => $ext_col) {
        $origin_table       = $ext_col['relation']['origin_table'];
        $intermediate_table = $ext_col['relation']['intermediate_table'];
        $target_table       = $ext_col['relation']['target_table'];
        $table_label        = $ext_col['table_label'];
        $relation_origin_column = $ext_col['relation']['intermediate_column_1'];
        $relation_target_column = $ext_col['relation']['intermediate_column_2'];
        // (products => products_categories => categories)
?>

$_SESSION['<?php echo $form_id; ?>']['ext_<?php echo $target_table; ?>'] = array();
$<?php echo $generator->table; ?>_value = Mysql::SQLValue($_SESSION['<?php echo $generator->table; ?>_editable_primary_key'], Mysql::SQLVALUE_NUMBER);

$qry = 'SELECT <?php echo $relation_target_column; ?> FROM <?php echo $intermediate_table; ?> WHERE <?php echo $relation_origin_column; ?> = ' . $<?php echo $generator->table; ?>_value;
$db = new Mysql();
$db->query($qry);
$db_count = $db->rowCount();
if (!empty($db_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $_SESSION['<?php echo $form_id; ?>']['ext_<?php echo $target_table; ?>'][] = $row-><?php echo $relation_target_column; ?>;
    }
}

<?php
    } // end foreach
} // end if

/* =============================================
form Update
============================================= */

?>
$form = new Form('<?php echo $form_id; ?>', 'horizontal', 'novalidate', 'bs4');
$form->setAction(ROOT_RELATIVE_URL . 'admin/<?php echo $generator->item ?>/edit/' . $<?php echo $primary_key; ?>);
$form->startFieldset();
<?php

// get grouped fields & fields width
$current_group = array();
$is_grouped = array();
for ($i=0; $i < $generator->columns_count; $i++) {
    // SKIP primary key
    if ($generator->columns['name'][$i] != $generator->primary_key) {
        $is_grouped[$i] = false;
        $flex_option[$i] = 'end';
        if (preg_match('`grouped`', $generator->columns['field_width'][$i]) || $generator->columns['field_type'][$i] == 'datetime') {
            $is_grouped[$i] = true;
        }
        $w = $generator->columns['field_width'][$i];
        $field_width[$i] = 10;
        $field_percent_width[$i] = 100;
        if ($w == '66% single' || $w == '66% grouped') {
            $field_width[$i] = 6;
            $field_percent_width[$i] = 66.66;
            if ($w == '66% single') {
                $flex_option[$i] = 'start';
            }
        } elseif ($w == '50% single' || $w == '50% grouped') {
            $field_width[$i] = 4;
            $field_percent_width[$i] = 50;
            if ($w == '50% single') {
                $flex_option[$i] = 'start';
            }
        } elseif ($w == '33% single' || $w == '33% grouped') {
            $field_width[$i] = 2;
            $field_percent_width[$i] = 33.33;
            if ($w == '33% single') {
                $flex_option[$i] = 'start';
            }
        }
    }
}

// the loop must be restarted because of group fields.
for ($i=0; $i < $generator->columns_count; $i++) {
    if ($generator->columns['name'][$i] != $generator->primary_key) {
        $field_type           = $generator->columns['field_type'][$i];
        $name                 = $generator->columns['name'][$i];
        $label                = $generator->columns['fields'][$name];
        $special              = $generator->columns['special'][$i];
        $special2             = $generator->columns['special2'][$i];
        $special3             = $generator->columns['special3'][$i];
        $special4             = $generator->columns['special4'][$i];
        $special5             = $generator->columns['special5'][$i];
        $special6             = $generator->columns['special6'][$i];
        $special7             = $generator->columns['special7'][$i];
        $select_from          = $generator->columns['select_from'][$i];
        $select_from_table    = $generator->columns['select_from_table'][$i];
        $select_from_value    = $generator->columns['select_from_value'][$i];
        $select_from_field_1  = $generator->columns['select_from_field_1'][$i];
        $select_from_field_2  = $generator->columns['select_from_field_2'][$i];
        $select_custom_values = $generator->columns['select_custom_values'][$i];
        $select_multiple      = $generator->columns['select_multiple'][$i];
        $help_text            = $generator->columns['help_text'][$i];
        $tooltip              = $generator->columns['tooltip'][$i];
        $required             = $generator->columns['required'][$i];
        $char_count           = $generator->columns['char_count'][$i];
        $char_count_max       = $generator->columns['char_count_max'][$i];
        $tinyMce              = $generator->columns['tinyMce'][$i];
        $grouped              = $is_grouped[$i];
        $width                = $field_width[$i];
        $flex                 = $flex_option[$i];


        /* field_types : input|password|textarea|select|radio|boolean|checkbox|file|image|date|hidden */

        // attributes
        $attr = [];
        if ($required == true && $field_type != 'password') {
            $attr[] = 'required';
        }

        // multiple
        if ($field_type == 'select' && $select_multiple > 0) {
            $name .= '[]';
        }
?>

// <?php echo $name; ?> --
<?php

        // group
if (empty($current_group) && $is_grouped[$i] == true) {
    $percent_width = 0;
    for ($j=$i; $j < ($i + 4); $j++) {
        if (isset($is_grouped[$j]) && $is_grouped[$j] == true) {
            $percent_width += $field_percent_width[$j];
            if ($percent_width <= 100) {
                // include to current group & remove from others incoming groups
                $current_group[] = '\'' . $generator->columns['name'][$j] . '\'';
                if ($generator->columns['field_type'][$j] == 'datetime') {
                    $current_group[] = '\'' . $generator->columns['name'][$j] . '-time\'';
                }
                $is_grouped[$j] = false;
            }
        }
    }
?>
$form->groupInputs(<?php echo implode(', ', $current_group) ?>);
<?php
}
if (($i == 0 && $flex == 'start') || ($i > 0 && $flex != $flex_option[$i - 1])) {
?>
$options = array(
    'elementsWrapper' => '<div class="form-group row justify-content-<?php echo $flex; ?>"></div>'
);
$form->setOptions($options);
<?php
}
        // reset group
        $percent_width = 0;
        $current_group = array();

        // layout
if ($i < 1 || $width != $field_width[$i - 1] || $generator->columns['name'][$i - 1] == $generator->primary_key) {
?>

$form->setCols(2, <?php echo $width; ?>);
<?php
}

        // help text
if (!empty($help_text)) {
?>
$form->addHtml('<span class="form-text text-muted"><?php echo addslashes($help_text); ?></span>', '<?php echo $name; ?>', 'after');
<?php
}

        // label & tooltip
$label = ucwords(addslashes($label));
if (!empty($tooltip)) {
?>
$uniqid = uniqid();
$form->addHtml('<div id="' . $uniqid . '" style="display:none">
<?php echo str_replace('"', '\'', addslashes($tooltip)); ?>
</div>');
<?php
    $label .= '<a href="#" data-tooltip="#\' . $uniqid . \'" data-delay="500" class="position-right"><span class="badge badge-secondary">?</span></a>';
}

        // char count
if ($char_count == true && $tinyMce == false) {
?>
$form->addPlugin('word-character-count', '#<?php echo $name; ?>', 'default', array('%maxAuthorized%' => <?php echo $char_count_max; ?>));
<?php

// char count + tinyMce
} elseif ($char_count == true && $tinyMce == true) {
    $attr[] = 'class=tinyMce';
?>
$form->addPlugin('tinymce', '#<?php echo $name; ?>', 'word_char_count', array('%maxAuthorized%' => <?php echo $char_count_max; ?>));
<?php

// tinyMce
} elseif ($tinyMce == true) {
    $attr[] = 'class=tinyMce';
?>
$form->addPlugin('tinymce', '#<?php echo $name; ?>');
<?php
}

        // color|email|number|url
if ($field_type == 'text' || $field_type == 'color' || $field_type == 'email' || $field_type == 'number' || $field_type == 'url') {
?>
$form->addInput('<?php echo $field_type; ?>', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
} elseif ($field_type == 'password') {
?>
$form->addPlugin('passfield', '#<?php echo $name; ?>', '<?php echo $special; ?>');
$form->addHelper(PASSWORD_EDIT_HELPER, '<?php echo $name; ?>');
$form->addInput('password', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
} elseif ($field_type == 'textarea') {
    $attr[] = 'rows=10';
    $attr[] = 'cols=10';
?>
$form->addTextarea('<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
} elseif ($field_type == 'select' || $field_type == 'radio' || $field_type == 'checkbox') {
    $indent = '';
    if ($field_type == 'select') {
        $attr[] = 'class=select2';
        if ($select_multiple == true) {
            $attr[] = 'multiple';
        }
    }

    /* START if ($select_from == 'from_table')
    -------------------------------------------------- */

    if ($select_from == 'from_table') {
        $indent = '    ';
        $fields_query = '`' . $select_from_table . '`.`' . $select_from_value . '`';
        if ($select_from_field_1 != $select_from_value) {
            $fields_query .= ', `' . $select_from_table . '`.`' . $select_from_field_1 . '`';
        }
        if (!empty($select_from_field_2)) {
            $fields_query .= ', `' . $select_from_table . '`.`' . $select_from_field_2 . '`';
        }
?>
$qry = 'SELECT DISTINCT <?php echo $fields_query; ?> FROM <?php echo $select_from_table; ?>';

// restrict if relationship table is the users table OR if the relationship table is used in the restriction query
if (ADMIN_LOCKED === true && Secure::canCreateRestricted('<?php echo $generator->table; ?>')) {
    $restriction_query = Secure::getRestrictionQuery('<?php echo $generator->table; ?>');
    if ('<?php echo $select_from_table; ?>' == USERS_TABLE) {
        $qry .= ' WHERE  <?php echo '`' . $select_from_table . '`.`' . $select_from_value . '`' ?> = ' . $_SESSION['secure_user_ID'];
    } else if (preg_match('/(?:`)*<?php echo $select_from_table; ?>(?:`)*\./', $restriction_query)) {
        $qry .= ', <?php echo $generator->table; ?>' . $restriction_query;
    }
}

$display_value = ''; // default value if no record exist

$db = new Mysql();

// echo $qry . '<br>';

$db->query($qry);

$db_count = $db->rowCount();
if (!empty($db_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $value = $row-><?php echo $select_from_value; ?>;
<?php
if ($select_from_field_1 != $select_from_value) {
?>
        $display_value = $row-><?php echo $select_from_field_1; ?>;
<?php
} else {
?>
        $display_value = $row-><?php echo $select_from_value; ?>;
<?php
}
if (!empty($select_from_field_2)) {
?>
        $display_value .= ' ' . $row-><?php echo $select_from_field_2; ?>;
<?php
}
?>
        if ($db_count > 1) {
<?php

if ($field_type == 'select') {
?>
            $form->addOption('<?php echo $name; ?>', $value, $display_value);
<?php
} elseif ($field_type == 'radio') {
?>
            $form->addRadio('<?php echo $name; ?>', $display_value, $value);
<?php
} elseif ($field_type == 'checkbox') {
?>
            $form->addCheckbox('<?php echo $name; ?>', $display_value, $value);
<?php
}
?>
        }
    }
}
<?php

    /* END if ($select_from == 'from_table')
    -------------------------------------------------- */
    } elseif ($select_from == 'custom_values') {
        foreach ($select_custom_values as $custom_label => $custom_value) {
            if ($field_type == 'select') {
    ?>
$form->addOption('<?php echo $name; ?>', '<?php echo $custom_value; ?>', '<?php echo $custom_label; ?>');
<?php
            } elseif ($field_type == 'radio') {
    ?>
$form->addRadio('<?php echo $name; ?>', '<?php echo $custom_label; ?>', '<?php echo $custom_value; ?>');
<?php
            } elseif ($field_type == 'checkbox') {
    ?>
$form->addCheckbox('<?php echo $name; ?>', '<?php echo $custom_label; ?>', '<?php echo $custom_value; ?>');
<?php
            }
        }
    }
    if ($select_from == 'from_table') {
    ?>

if ($db_count > 1) {
<?php
    }
    if ($field_type == 'select') {
?>
<?php echo $indent; ?>$form->addSelect('<?php echo $name; ?>', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
    } elseif ($field_type == 'radio') {
?>
<?php echo $indent; ?>$form->printRadioGroup('<?php echo $name; ?>', '<?php echo $label; ?>', true, '<?php echo implode(', ', $attr) ?>');
<?php
    } elseif ($field_type == 'checkbox') {
?>
<?php echo $indent; ?>$form->printCheckboxGroup('<?php echo $name; ?>', '<?php echo $label; ?>', true, '<?php echo implode(', ', $attr) ?>');
<?php
    }
    if ($select_from == 'from_table') {
        $attr[] = 'readonly';
?>
} else {
    // for display purpose
    $form->addInput('text', '<?php echo $name; ?>-display', $display_value, '<?php echo $label; ?>', 'readonly');

    // for send purpose
    $form->addInput('hidden', '<?php echo $name; ?>', $value);
}
<?php
    }
} elseif ($field_type == 'boolean') {
?>
$form->addRadio('<?php echo $name; ?>', YES, 1);
$form->addRadio('<?php echo $name; ?>', NO, 0);
$form->printRadioGroup('<?php echo $name; ?>', '<?php echo $label; ?>', true, '<?php echo implode(', ', $attr) ?>');
<?php
} elseif ($field_type == 'file') {
    // default allowed extensions
    $extensions = '[\'doc\', \'docx\', \'xls\', \'xlsx\', \'pdf\', \'txt\']';
    if (preg_match_all('`([^,]+)(?:,)*(?:\s)*`', $special3, $out)) {
        $extensions = '[\'' . implode('\', \'', $out[1]) . '\']';
    }
?>
// get current file if exists
$current_file = '';
if (!empty($_SESSION['<?php echo $form_id; ?>']['<?php echo $name; ?>'])) {
    if (isset($_POST['<?php echo $name; ?>']) && !empty($_POST['<?php echo $name; ?>'])) {
        // get filename from POST data (JSON)
        $posted_file = FileUploader::getPostedFiles($_POST['<?php echo $name; ?>']);
        $current_file_name = $posted_file[0]['file'];
    } else {
        // get filename from Database (text)
        $current_file_name = $_SESSION['<?php echo $form_id; ?>']['<?php echo $name; ?>'];
    }
    $current_file_path = ROOT . '<?php echo $special; ?>';
    if (file_exists($current_file_path . $current_file_name)) {
        $current_file_size = filesize($current_file_path . $current_file_name);
        $current_file_type = mime_content_type($current_file_path . $current_file_name);
        $current_file = array(
            'name' => $current_file_name,
            'size' => $current_file_size,
            'type' => $current_file_type,
            'file' => BASE_URL . '<?php echo $special; ?>' . $current_file_name,
            'data' => array(
                'listProps' => array(
                'file' => $current_file_name
                )
            )
        );
    }
}
$fileUpload_config = array(
'upload_dir'    => '../../../../../../<?php echo $special; ?>', // the directory to upload the files. relative to [plugins dir]/fileuploader/[xml]/php/[uploader]
'limit'         => 1, // max. number of files
'file_max_size' => 5, // each file's maximal size in MB {null, Number}
'extensions'    => <?php echo $extensions; ?>,
'debug'         => true
);
$form->addFileUpload('file', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '', $fileUpload_config, $current_file);
<?php
} elseif ($field_type == 'image') {
    $thumbnails = 'false';
    $editor     = 'false';
    $width      = '9999';
    $height     = '9999';
    $crop       = 'false';
    if ($special3 > 0) {
        $thumbnails = 'true';
    }
    if ($special4 > 0) {
        $editor = 'true';
    }
    if ($special5 > 0) {
        $width = $special5;
    }
    if ($special6 > 0) {
        $height = $special6;
    }
    if ($special7 > 0) {
        $crop = 'true';
    }
?>
// get current image if exists
$current_file = '';
if (!empty($_SESSION['<?php echo $form_id; ?>']['<?php echo $name; ?>'])) {
    if (isset($_POST['<?php echo $name; ?>']) && !empty($_POST['<?php echo $name; ?>'])) {
        // get filename from POST data (JSON)
        $posted_file = FileUploader::getPostedFiles($_POST['<?php echo $name; ?>']);
        $current_file_name = $posted_file[0]['file'];
    } else {
        // get filename from Database (text)
        $current_file_name = $_SESSION['<?php echo $form_id; ?>']['<?php echo $name; ?>'];
    }
    $current_file_path = ROOT . '<?php echo $special; ?>';
    if (file_exists($current_file_path . $current_file_name)) {
        $current_file_size = filesize($current_file_path . $current_file_name);
        $current_file_type = mime_content_type($current_file_path . $current_file_name);
        $current_file = array(
            'name' => $current_file_name,
            'size' => $current_file_size,
            'type' => $current_file_type,
            'file' => BASE_URL . '<?php echo $special; ?>' . $current_file_name,
            'data' => array(
                'listProps' => array(
                'file' => $current_file_name
                )
            )
        );
    }
}
$fileUpload_config = array(
    'xml'           => 'image-upload', // the thumbs directories must exist
    'uploader'      => 'ajax_upload_file.php', // the uploader file in phpformbuilder/plugins/fileuploader/[xml]/php
    'upload_dir'    => '../../../../../../<?php echo $special; ?>', // the directory to upload the files. relative to [plugins dir]/fileuploader/[xml]/php/[uploader]
    'limit'         => 1, // max. number of files
    'file_max_size' => 5, // each file's maximal size in MB {null, Number}
    'extensions'    => ['jpg', 'jpeg', 'png'],
    'thumbnails'    => <?php echo $thumbnails; ?>,
    'editor'        => <?php echo $editor; ?>,
    'width'         => <?php echo $width; ?>,
    'height'        => <?php echo $height; ?>,
    'crop'          => <?php echo $crop; ?>,
    'debug'         => true
);
$form->addFileUpload('file', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '', $fileUpload_config, $current_file);
<?php
} elseif ($field_type == 'date') {
    if ($special3 > 0) {
?>
$form->addInput('hidden', '<?php echo $name; ?>', date('Y-m-d'));
<?php
    } else {
        $attr[] = 'data-format=' . $special . ', data-format-submit=yyyy-mm-dd, data-set-default-date=true';
?>
$form->addPlugin('pickadate', '#<?php echo $name; ?>');
$form->addInput('text', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
    }
} elseif ($field_type == 'datetime') {
    if ($special3 > 0) {
?>
$form->addInput('hidden', '<?php echo $name; ?>', date('Y-m-d H:i'));
<?php
    } else {
        $date_attr          = $attr;
        $time_attr          = $attr;
        $material_time_attr = $attr;

        $date_format = 'yyyy mmmm dddd';
        $time_format = 'H:i a';
        $material_time_format = 'HH:i';
        if (!empty($special)) {
            $date_format = $special;
        }
        $twelve_hour = 'false';
        if (!empty($special2)) {
            $time_format = $special2;
            if (strpos($special2, 'h') !== false) {
                $twelve_hour = 'true';
                $material_time_format = 'hh:i A';
            }
        }

        $date_attr[] = 'data-format=' . $date_format;
        $date_attr[] = 'data-format-submit=yyyy-mm-dd';
        $date_attr[] = 'data-set-default-date=true';

        $time_attr[] = 'data-format=' . $time_format;
        $time_attr[] = 'data-format-submit=HH:i';
        $time_attr[] = 'data-interval=15';

        $material_time_attr[] = 'data-format=hh:i A';
        $material_time_attr[] = 'data-format-submit=HH:i';
        $material_time_attr[] = 'data-twelve-hour=' . $twelve_hour;
        $material_time_attr[] = 'data-interval=15';
?>
$form->addPlugin('pickadate', '#<?php echo $name; ?>'); // date field
$form->addPlugin('pickadate', '#<?php echo $name; ?>-time', 'pickatime'); // time field
<?php

        // set date & time fields width
if ($width == 4) {
    $date_width = 2;
    $time_width = 2;
} elseif ($width == 10) {
    $date_width = 6;
    $time_width = 4;
}
?>

$form->setCols(2, <?php echo $date_width; ?>);
$form->addInput('text', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $date_attr) ?>');
$form->setCols(0, <?php echo $time_width; ?>);
<?php

        // time placeholder
        $time_attr[] = 'placeholder=' . TIME_PLACEHOLDER;
        $material_time_attr[] = 'placeholder=' . TIME_PLACEHOLDER;
?>
if (DATETIMEPICKERS_STYLE === 'material') {
    $form->addInput('text', '<?php echo $name; ?>-time', '', '', '<?php echo implode(', ', $material_time_attr) ?>');
} else {
    $form->addInput('text', '<?php echo $name; ?>-time', '', '', '<?php echo implode(', ', $time_attr) ?>');
}
$form->setCols(2, <?php echo $width; ?>);
<?php
    }
} elseif ($field_type == 'time') {
    if ($special3 > 0) {
?>
$form->addInput('hidden', '<?php echo $name; ?>', date('HH:i'));
<?php
    } else {
        $time_attr          = $attr;
        $material_time_attr = $attr;
        $time_format = 'H:i a';
        $material_time_format = 'HH:i';
        $twelve_hour = 'false';
        if (!empty($special2)) {
            if (strpos($special2, 'h') !== false) {
                $twelve_hour = 'true';
                $material_time_format = 'hh:i A';
            }
        }
        $time_attr[] = 'data-format=' . $time_format;
        $time_attr[] = 'data-format-submit=HH:i';
        $time_attr[] = 'data-interval=15';

        $material_time_attr[] = 'data-format=hh:i A';
        $material_time_attr[] = 'data-format-submit=HH:i';
        $material_time_attr[] = 'data-twelve-hour=' . $twelve_hour;
        $material_time_attr[] = 'data-interval=15';
?>
$form->addPlugin('pickadate', '#<?php echo $name; ?>', 'pickatime'); // time field
if (DATETIMEPICKERS_STYLE === 'material') {
    $form->addInput('text', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $material_time_attr) ?>');
} else {
    $form->addInput('text', '<?php echo $name; ?>', '', '<?php echo $label; ?>', '<?php echo implode(', ', $time_attr) ?>');
}
<?php
    }
} elseif ($field_type == 'month') {
    if ($special3 > 0) {
?>
$form->addInput('hidden', '<?php echo $name; ?>', date('m'));
<?php
    } else {
        $attr[] = 'class=select2';
?>
$form->addOption('<?php echo $name; ?>', JANUARY, JANUARY);
$form->addOption('<?php echo $name; ?>', FEBRUARY, FEBRUARY);
$form->addOption('<?php echo $name; ?>', MARCH, MARCH);
$form->addOption('<?php echo $name; ?>', APRIL, APRIL);
$form->addOption('<?php echo $name; ?>', MAY, MAY);
$form->addOption('<?php echo $name; ?>', JUNE, JUNE);
$form->addOption('<?php echo $name; ?>', JULY, JULY);
$form->addOption('<?php echo $name; ?>', AUGUST, AUGUST);
$form->addOption('<?php echo $name; ?>', SEPTEMBER, SEPTEMBER);
$form->addOption('<?php echo $name; ?>', OCTOBER, OCTOBER);
$form->addOption('<?php echo $name; ?>', NOVEMBER, NOVEMBER);
$form->addOption('<?php echo $name; ?>', DECEMBER, DECEMBER);
$form->addSelect('<?php echo $name; ?>', '<?php echo $label; ?>', '<?php echo implode(', ', $attr) ?>');
<?php
    }
} elseif ($field_type == 'hidden') {
?>
$form->addInput('hidden', '<?php echo $name; ?>', '');
<?php
}
    }
}

/* External fields
-------------------------------------------------- */

/*
$generator->external_columns = array(
    'target_table'       => '',
    'target_fields'      => array(),
    'table_label'        => '',
    'fields_labels'      => array(),
    'relation'           => '',
    'allow_crud_in_list' => false,
    'allow_in_forms'     => true,
    'forms_fields'       => array(),
    'field_type'         => array(), // 'select-multiple' | 'checkboxes'
    'active'             => false
);

// relation = $generator->relations['from_to'][$i]
*/

if ($show_external === true) {
    foreach ($active_ext_cols as $key => $ext_col) {
        $origin_table       = $ext_col['relation']['origin_table'];
        $intermediate_table = $ext_col['relation']['intermediate_table'];
        $target_table       = $ext_col['relation']['target_table'];
        $table_label        = $ext_col['table_label'];
        // (products => products_categories => categories)

        // get the primary key of the target table
        // many to many
        $target_table_pk_column = 'unknown_primary_key';

        $db = new Mysql();
        $db->selectDatabase($generator->database);
        $qry = 'SHOW COLUMNS FROM ' . $target_table;
        $db->query($qry);
        $columns_count = $db->rowCount();
        if (!empty($columns_count)) {
            while (! $db->endOfSeek()) {
                $row = $db->row();

                // last row is table comments, skip it.
                if (isset($row->Field)) {
                    if ($row->Key == 'PRI') {
                        $target_table_pk_column  = $row->Field;
                    }
                }
            }
        }

        $fields_query = implode(', ', $ext_col['forms_fields']);

        // add primary key in query if necessary
        if (!in_array($target_table_pk_column, $ext_col['forms_fields'])) {
            $fields_query .= ', ' . $target_table_pk_column;
        }
        $row_value = '$row->' . $target_table_pk_column;
        $row_display_value    = '$row->' . implode(' . \' - \' . $row->', $ext_col['forms_fields']);
?>

// external relation: <?php echo $origin_table; ?> => <?php echo $intermediate_table; ?> => <?php echo $target_table; ?>;
$qry = 'SELECT DISTINCT <?php echo $fields_query; ?> FROM <?php echo $target_table; ?>';

$db = new Mysql();
$db->query($qry);
$db_count = $db->rowCount();
if (!empty($db_count)) {
    $values = array();
    $display_values = array();
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $values[] = <?php echo $row_value; ?>;
        $display_values[] = <?php echo $row_display_value; ?>;
    }
    for ($i=0; $i < $db_count; $i++) {
<?php
if ($ext_col['field_type'] == 'select-multiple') {
?>
    $form->addOption('ext_<?php echo $target_table; ?>[]', $values[$i], $display_values[$i]);
<?php
} else {
?>
    $form->addCheckbox('ext_<?php echo $target_table; ?>[]', $display_values[$i], $values[$i]);
<?php
}
?>
    }
<?php
if ($ext_col['field_type'] == 'select-multiple') {
?>
    $form->addSelect('ext_<?php echo $target_table; ?>[]', '<?php echo $table_label; ?>', 'class=select2, multiple, data-close-on-select=false');
<?php
} else {
?>
    $form->printCheckboxGroup('ext_<?php echo $target_table; ?>[]', '<?php echo $table_label; ?>');
<?php
}
?>
}
<?php
    } // end foreach
} // end if

    // layout
if ($generator->columns['field_width'][$i - 1] < 10) {
?>
$form->setCols(2, <?php echo $width; ?>);
<?php
}
?>
$form->addBtn('button', 'cancel', 0, '<i class="' . ICON_BACK . ' position-left"></i>' . CANCEL, 'class=btn btn-warning ladda-button legitRipple, onclick=history.go(-1)', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button legitRipple', 'btn-group');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->printBtnGroup('btn-group');
$form->endFieldset();
$form->addPlugin('nice-check', 'form', 'default', array('%skin%' => 'green'));
