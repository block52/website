<?php
use generator\TemplatesUtilities;
use crud\ElementsUtilities;

include_once GENERATOR_DIR . 'class/generator/TemplatesUtilities.php';
include_once ADMIN_DIR . 'class/crud/ElementsUtilities.php';

$generator = $_SESSION['generator'];
$form_id = 'form-delete-' . str_replace('_', '-', $generator->table);
$radio_fieldname = 'delete-' . str_replace('_', '-', $generator->table);
echo '<?php' . "\n";
?>
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use common\Utils;

// get referer pagination
$page_url_qry = '';
if (isset($_SESSION['<?php echo $generator->table; ?>-page']) && is_numeric($_SESSION['<?php echo $generator->table; ?>-page'])) {
    $page_url_qry = '/p' . $_SESSION['<?php echo $generator->table; ?>-page'];
}

/* =============================================
    delete if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('<?php echo $form_id; ?>') === true) {
    if ($_POST['<?php echo $radio_fieldname; ?>'] > 0) {
        $db = new Mysql();
        $db->throwExceptions = true;
        try {

            // begin transaction
            $db->transactionBegin();
<?php

    /* constrained_from_to_relations:
        array(
            'origin_table'
            'origin_column'
            'intermediate_table'
            'intermediate_column_1' // refers to origin_table
            'intermediate_column_2' // refers to target_table
            'target_table'
            'target_column',
            'cascade_delete_from_intermediate' // true will automatically delete all matching records according to foreign keys constraints. Default: true
            'cascade_delete_from_origin' // true will automatically delete all matching records according to foreign keys constraints. Default: true
        )*/

    // Cascade delete - automatically delete all matching records according to foreign keys constraints (true|false)
    //
    // Current table is always the target.
    //
    // If External relation with intermediate table:
    //      origin_table ID <- [fk-origin + fk-target] -> target_table ID
    //      => We'll delete from [intermediate_table] THEN origin_table THEN target_table
    // else:
    //      fk-origin -> target_table ID
    //      => We'll delete from origin_table THEN target_table


/*
CAS 1

    target       = souscategories
    intermediate = articles
    origin       = categories

CAS 2

    target       = souscategories
    intermediate = null
    origin       = articles
*/

$done_tables = array();

if (isset($generator->relations['from_to'])) {
    foreach ($generator->relations['from_to'] as $from_to) {
        if ($from_to['target_table'] == $generator->table) {
            if (!empty($from_to['intermediate_table'])) {
                // Delete from intermediate
                if ($from_to['cascade_delete_from_intermediate'] > 0 && !empty($from_to['intermediate_table']) && !in_array($from_to['intermediate_table'], $done_tables)) {
                    if ($from_to['cascade_delete_from_origin'] > 0 && !in_array($from_to['origin_table'], $done_tables)) {
?>

            // Get records to delete from origin table before intermediate are deleted
            $<?php echo $from_to['origin_table']; ?>_records = array();

            $qry = 'SELECT
            <?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?>
            FROM
            <?php echo $from_to['origin_table']; ?>
            INNER JOIN <?php echo $from_to['intermediate_table']; ?> ON <?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_1']; ?> =
                <?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?>
            INNER JOIN <?php echo $from_to['target_table']; ?> ON <?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_2']; ?> =
                <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>
            WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = Mysql::SQLValue(' . $_POST['<?php echo $generator->primary_key; ?>'] . ')';
                        $db->query($qry);
                        $db_count = $db->rowCount();
                        if (!empty($db_count)) {
                            while (! $db->endOfSeek()) {
                                $row = $db->row();
                                $<?php echo $from_to['origin_table']; ?>_records[] = $row-><?php echo $from_to['origin_column']; ?>;
                            }
                        }
<?php
                    } // END if ($from_to['cascade_delete_from_origin'] > 0)
?>

            // Delete from intermediate
            $qry = 'DELETE <?php echo $from_to['intermediate_table']; ?> FROM <?php echo $from_to['intermediate_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_2']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($_POST['<?php echo $generator->primary_key; ?>']);
            if (DEMO !== true && !$db->query($qry)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            }

<?php

                // Delete from origin
                    if ($from_to['cascade_delete_from_origin'] > 0 && !in_array($from_to['origin_table'], $done_tables)) {
                        $origin_filtered_column = $from_to['origin_table'] . '.' . $from_to['origin_column'];
?>
            foreach ($<?php echo $from_to['origin_table']; ?>_records as $value) {
                $filter = array();
                $filter["<?php echo $origin_filtered_column; ?>"] = Mysql::SQLValue($value);
                if (DEMO !== true && !$db->deleteRows('<?php echo $from_to['origin_table']; ?>', $filter)) {
                    $error = $db->error();
                    $db->transactionRollback();
                    throw new \Exception($error);
                }
            }

<?php
                        $done_tables[] = $from_to['origin_table'];
                    }   // END if ($from_to['cascade_delete_from_origin'] > 0) {
                    $done_tables[] = $from_to['intermediate_table'];
                } // END if ($from_to['cascade_delete_from_intermediate'] > 0)
            } else { // If NO intermediate table
/* =============================================
    DELETE customers FROM customers LEFT JOIN orders  ON (customers.id = orders.customer_id) WHERE orders.customer_id IS NULL;
============================================= */

                // Delete from origin
                if ($from_to['cascade_delete_from_origin'] > 0 && !in_array($from_to['origin_table'], $done_tables)) {
                    $origin_filtered_column = $from_to['origin_column'];
                    $origin_filtered_column_value = $from_to['origin_table'] . '_' . $from_to['origin_column'];
?>

            // Delete from origin
            $qry = 'DELETE <?php echo $from_to['origin_table']; ?> FROM <?php echo $from_to['origin_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($_POST['<?php echo $generator->primary_key; ?>']);
            if (DEMO !== true && !$db->query($qry)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            }
<?php
                    $done_tables[] = $from_to['origin_table'];
                } // END if ($from_to['cascade_delete_from_origin'] > 0) {
            }
        }
    }
}
?>

            // Delete from target table
            $filter = array();
            $filter["<?php echo $generator->primary_key; ?>"] = Mysql::SQLValue($_POST['<?php echo $generator->primary_key; ?>']);
            if (DEMO === true || $db->deleteRows('<?php echo $generator->table; ?>', $filter)) {

                // ALL OK
                $db->transactionEnd();
                $_SESSION['msg'] = Utils::alert(UPDATE_SUCCESS_MESSAGE, 'alert-success has-icon');
            } else {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            }
        } catch(\Exception $e) {
            $msg_content = DB_ERROR;
            if (ENVIRONMENT == 'development') {
                $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
            }
            $_SESSION['msg'] = Utils::alert($msg_content, 'alert-danger has-icon');
        }
    }

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

} // END if POST
<?php

/* =============================================
form Delete
============================================= */

$primary_key = $generator->primary_key;
?>

$<?php echo $primary_key; ?> = $pk;

// select name to display for confirmation
<?php
    $select_fields = $generator->field_delete_confirm_1;
if (!empty($generator->field_delete_confirm_2)) {
    $select_fields .= ', ' . $generator->field_delete_confirm_2;
}
?>
$qry = 'SELECT <?php echo $select_fields ?> FROM <?php echo $generator->table ?> WHERE <?php echo $generator->primary_key ?> = ' . Mysql::sqlValue($<?php echo $primary_key; ?>) . ' LIMIT 1';
$db = new Mysql();
$db->query($qry);
$count = $db->rowCount();
if (!empty($count)) {
        $row = $db->row();
        $display_value = $row-><?php echo $generator->field_delete_confirm_1 ?>;
<?php if (!empty($generator->field_delete_confirm_2)) { ?>
        $display_value .= ' ' . $row-><?php echo $generator->field_delete_confirm_2 ?>;
<?php } ?>
} else {

    // this should never happen
    // echo $db->getLastSql();
    exit('QRY ERROR');
}

$form = new Form('<?php echo $form_id; ?>', 'vertical', 'novalidate', 'bs4');
$form->setAction(ROOT_RELATIVE_URL . 'admin/<?php echo $generator->item ?>/delete/' . $<?php echo $primary_key; ?>);
$form->startFieldset();
$form->addInput('hidden', '<?php echo $generator->primary_key; ?>', $<?php echo $primary_key; ?>);
<?php
$matching_records_tables = array();
if (isset($generator->relations['from_to'])) {
    foreach ($generator->relations['from_to'] as $from_to) {
        if ($from_to['target_table'] == $generator->table) {
            if ($from_to['cascade_delete_from_intermediate'] > 0 && !empty($from_to['intermediate_table']) && !in_array($from_to['intermediate_table'], $matching_records_tables)) {
?>
// Get records count from intermediate table
$<?php echo $from_to['intermediate_table']; ?>_record_count = 0;
$qry = 'SELECT COUNT(<?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_2']; ?>) AS record_count FROM <?php echo $from_to['intermediate_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_2']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($<?php echo $primary_key; ?>);
$db = new Mysql();
$db->query($qry);
$count = $db->rowCount();
if (!empty($count)) {
        $row = $db->row();
        $<?php echo $from_to['intermediate_table']; ?>_record_count = $row->record_count;
}
<?php
                $matching_records_tables[] = $from_to['intermediate_table'];
?>

// intermediate table
$form->addInput('hidden', '<?php echo 'constrained_tables_' . $from_to['intermediate_table']; ?>', true);
<?php
            }
            if ($from_to['cascade_delete_from_origin'] > 0 && !in_array($from_to['origin_table'], $matching_records_tables)) {
?>
// Get records count from origin table
$<?php echo $from_to['origin_table']; ?>_record_count = 0;
$qry = 'SELECT COUNT(<?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?>) AS record_count FROM <?php echo $from_to['origin_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($<?php echo $primary_key; ?>);
$db = new Mysql();
$db->query($qry);
$count = $db->rowCount();
if (!empty($count)) {
        $row = $db->row();
        $<?php echo $from_to['origin_table']; ?>_record_count = $row->record_count;
}
<?php
                $matching_records_tables[] = $from_to['origin_table'];
?>

// origin table
$form->addInput('hidden', '<?php echo 'constrained_tables_' . $from_to['origin_table']; ?>', true);
<?php
            }
        }
    }
}
?>
$form->addHtml('<div class="text-center p-md">');
$form->addRadio('<?php echo $radio_fieldname; ?>', YES, 1);
$form->addRadio('<?php echo $radio_fieldname; ?>', NO, 0);
$form->printRadioGroup('<?php echo $radio_fieldname; ?>', '<span class="mr-20">' . DELETE_CONST . ' "' . $display_value . '" ?</span>');
<?php
if (count($matching_records_tables) > 0) {
?>
$tables_records_html = '';
<?php
for ($i = 0; $i < count($matching_records_tables); $i++) {
?>
    $tables_records_html .= '<span class="badge badge-warning position-left"><?php echo $matching_records_tables[$i] ?> (' . $<?php echo $matching_records_tables[$i]; ?>_record_count . ' ' . RECORDS . ')</span>';
<?php
}
?>
$form->addHtml(Utils::alert('<p class="text-semibold">' . MATCHING_RECORDS_WILL_BE_DELETED . ':</p><p>' . $tables_records_html . '</p>', 'alert-warning has-icon'));
<?php
}
?>
$form->addBtn('button', 'cancel', 0, '<i class="' . ICON_BACK . ' position-left"></i>' . CANCEL, 'class=btn btn-warning legitRipple, onclick=history.go(-1)', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success legitRipple', 'btn-group');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->printBtnGroup('btn-group');
$form->addHtml('</div>');
$form->endFieldset();
$form->addPlugin('nice-check', 'form', 'default', array('%skin%' => 'green'));
$form->addPlugin('select2', 'select', 'default');
