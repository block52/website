<?php
use generator\TemplatesUtilities;
use crud\ElementsUtilities;

include_once GENERATOR_DIR . 'class/generator/TemplatesUtilities.php';
include_once ADMIN_DIR . 'class/crud/ElementsUtilities.php';

$generator = $_SESSION['generator'];
echo '<?php' . "\n";
?>
use secure\Secure;
use phpformbuilder\database\Mysql;
use common\Utils;

include_once '../../../conf/conf.php';
include_once ADMIN_DIR . 'secure/class/secure/Secure.php';

session_start();

// user must have [restricted|all] CREATE/DELETE rights on $table
if (Secure::canCreate('<?php echo $generator->table; ?>') || Secure::canCreateRestricted('<?php echo $generator->table; ?>')) {

    /* =============================================
        delete if posted
    ============================================= */

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['recordsIds']) && is_array($_POST['recordsIds'])) {
            $db = new Mysql();
            $db->throwExceptions = true;
            try {

                // begin transaction
                $db->transactionBegin();
                foreach ($_POST['recordsIds'] as $record_pk_value) {
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
                    WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = Mysql::SQLValue($record_pk_value)';
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
                    $qry = 'DELETE <?php echo $from_to['intermediate_table']; ?> FROM <?php echo $from_to['intermediate_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['intermediate_table']; ?>.<?php echo $from_to['intermediate_column_2']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($record_pk_value);
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
                    $qry = 'DELETE <?php echo $from_to['origin_table']; ?> FROM <?php echo $from_to['origin_table']; ?> LEFT JOIN <?php echo $from_to['target_table']; ?> ON (<?php echo $from_to['origin_table']; ?>.<?php echo $from_to['origin_column']; ?> = <?php echo $from_to['target_table']; ?>.<?php echo $from_to['target_column']; ?>) WHERE <?php echo $from_to['target_table']; ?>.<?php echo $generator->primary_key; ?> = ' . Mysql::SQLValue($record_pk_value);
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
                    $filter["<?php echo $generator->primary_key; ?>"] = Mysql::SQLValue($record_pk_value);
                    if (DEMO !== true && !$db->deleteRows('<?php echo $generator->table; ?>', $filter)) {
                        $error = $db->error();
                        $db->transactionRollback();
                        throw new \Exception($error);
                    }
                } // end foreach
                // ALL OK
                $db->transactionEnd();
                $msg = Utils::alert(count($_POST['recordsIds']) . BULK_DELETE_SUCCESS_MESSAGE, 'alert-success has-icon');
            } catch(\Exception $e) {
                $msg_content = DB_ERROR;
                if (ENVIRONMENT == 'development') {
                    $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
                }
                $msg = Utils::alert($msg_content, 'alert-danger has-icon');
            }
        } // END if (isset($_POST['recordsIds']))

        echo $msg;

    } // END if POST
} // END if Secure
