<?php
use crud\ElementsUtilities;

$generator = $_SESSION['generator'];
echo '<?php' . "\n"; ?>
namespace crud;

use common\Utils;
use phpformbuilder\database\Mysql;
use phpformbuilder\database\Pagination;
use secure\Secure;

class <?php echo ElementsUtilities::upperCamelCase($generator->table); ?> extends Elements
{

    // item name passed in url
    public $item;

    // item name dispolayed
    public $item_label;

    // associative array : field => field displayed name
    public $fields;
<?php
    $external_active_tables_count = 0;
if (count($generator->external_columns) > 0) {
    $external_active_tables_count = 0;
    foreach ($generator->external_columns as $col) {
        if ($col['active'] == true) {
            $external_active_tables_count ++;
        }
    }
?>

    // external relations
    public $external_tables_count = <?php echo $external_active_tables_count; ?>;
    public $external_fields_count;
    public $external_rows_count;
    public $external_fields = array();
<?php
}
?>

    // primary key passed to create|edit|delete
    public $primary_key; // primary key fieldname
    public $primary_key_alias; // primary key alias for query

    // CREATE rights
    public $can_create = false;

    // authorized primary keys for restricted updates
    public $authorized_update_pk = array();

    public $pk = array(); // primary key values for each row
<?php for ($i=0; $i < $generator->columns_count; $i++) {
    echo '    public $' . $generator->columns['name'][$i] . ' = array();' . "\n";
} // end for ?>

    public $export_data_button;
    public $join_query       = '';
    public $records_count;
    public $item_url;

    public function __construct($element)
    {
        $this->table             = $element->table;
        $this->item              = $element->item;
        $this->item_label        = $element->item_label;
        $this->primary_key       = $element->primary_key;
        $this->primary_key_alias = $element->primary_key;
        $this->select_data       = $element->select_data;
        $this->fields            = $element->fields;

        $table = $this->table;

        $this->item_url          = $_SERVER['REQUEST_URI'];
<?php
    // generate fields query
    $columns = array(
        'table' => array(),
        'query' => array(),
        'name' => array(),
        'value' => array()
    );
    for ($i=0; $i < $generator->columns_count; $i++) {
        $relation = $generator->columns['relation'][$i];

        if (empty($relation['target_table'])) {
            $columns['table'][] = $generator->table;
            $columns['query'][] = '`' . $generator->table . '`.`' . $generator->columns['name'][$i] . '`';
            $columns['name'][]  = $generator->columns['name'][$i];
            $columns['value'][] = '$row->' . $columns['name'][$i];
        } else {
            /* =============================================
            join if any relation
            ============================================= */

            $target_table  = $relation['target_table'];

            // relation query can use several fields
            $target_fields = explode(', ', $relation['target_fields']);

            $columns['table'][] = $target_table;

            $query = array();
            foreach ($target_fields as $target_field) {
                $query[] = '`' . $target_table . '`.`' . $target_field . '` AS `' . $target_table . '_' . $target_field . '`';

                // register primary_key_alias if target_field is primary_key
                if ($target_table == $generator->table && $target_field == $this->primary_key) {
                    $this->primary_key_alias = $target_field;
                }
            }
            $columns['query'][] = implode(', ', $query);

            $columns['name'][]  = $generator->columns['name'][$i];

            $value = array();
            foreach ($target_fields as $target_field) {
                $value[] = '$row->' . $target_table . '_' . $target_field;
            }
            $columns['value'][] = implode(' . \' \' . ', $value);
        }
    }

    // create join queries
    $from_to = $generator->relations['from_to'];
    $join_query = array();
    if (is_array($from_to)) {
        foreach ($from_to as $ft) {
            if ($ft['origin_table'] == $generator->table) {
                if (empty($ft['intermediate_table'])) {
                    /* one-to one */

                    $join_query[] = ' LEFT JOIN `' . $ft['target_table'] . '`
    ON `' . $ft['origin_table'] . '`.`' . $ft['origin_column'] . '`=`' . $ft['target_table'] . '`.`' . $ft['target_column'] . '`';
                        $used_tables[] = $ft['target_table'];
                } else {
                    /* many-to-many */
                }
            }
        }
    }

    // register column_count including relation fields
    $columns_count = count($columns['table']);
    $columns_query = implode(', ', $columns['query']);
    $join_query    = implode('', $join_query);
    if (!empty($join_query)) {
?>
        $this->join_query       = '<?php echo $join_query; ?>';
        $qry_start              = 'SELECT <?php echo $columns_query ?> FROM <?php echo $generator->table; ?>' . $this->join_query;
<?php
    } else {
?>
        $qry_start              = 'SELECT <?php echo $columns_query ?> FROM <?php echo $generator->table; ?>';
<?php
    }
?>

        // restricted rights query
        $qry_restriction = '';
        if (Secure::canReadRestricted($table)) {
            $qry_restriction = Secure::getRestrictionQuery($table);
        }

        $db = new Mysql();
        $db->query($qry_start . $qry_restriction);
        $this->records_count = $db->rowCount();
        $primary_key = $this->primary_key_alias;
        if (!empty($this->records_count)) {
            while (!$db->endOfSeek()) {
                $row = $db->row();
                $this->pk[] = $row->$primary_key;
<?php
for ($i=0; $i < $columns_count; $i++) {
    echo '                $this->' . $columns['name'][$i] . '[]= ' . $columns['value'][$i] . ';' . "\n";
} // end for
?>
            }
        }

        // restricted UPDATE rights
        // (no need to restrict if read rights are already restricted : only allowed records are displayed)
        if (Secure::canUpdateRestricted($table) === true && Secure::canReadRestricted($table) !== true) {
            $transition = 'WHERE';

            // get authorized update primary keys
            $qry_start .= Secure::getRestrictionQuery($table, $transition);
            $db = new Mysql();
            $db->query($qry_start . $qry_restriction);
            $records_count = $db->rowCount();
            $primary_key = $this->primary_key_alias;
            if (!empty($records_count)) {
                while (!$db->endOfSeek()) {
                    $row = $db->row();
                    $this->authorized_update_pk[] = $row->$primary_key;
                }
            }
        } elseif (Secure::canUpdate($table) === true || Secure::canUpdateRestricted($table) === true) {

            // user can update ALL records
            $this->authorized_update_pk = $this->pk;
        }
<?php

    /* =============================================
    External relations
    ============================================= */

if (count($generator->external_columns) > 0) {
?>

        /* external relations */

        for ($i=0; $i < count($this->pk); $i++) {
            $this->external_rows_count[$i] = array();
            $this->external_fields[$i] = array();
            $db = new Mysql();
    <?php
    foreach ($generator->external_columns as $key => $ext_col) {
        if ($ext_col['active'] === true) {
            if (!empty($ext_col['relation']['intermediate_table'])) {
                // many to many
    ?>
                // <?php echo $ext_col['relation']['origin_table']; ?> => <?php echo $ext_col['relation']['intermediate_table']; ?> => <?php echo $ext_col['relation']['target_table']; ?>

    <?php
            } else {
                // one to many with the current table as target
    ?>
                // <?php echo $ext_col['relation']['origin_table']; ?> => <?php echo $ext_col['relation']['target_table']; ?>

    <?php
            }
                $target_table = $ext_col['target_table'];
                $target_fields_query = $ext_col['target_table'] . '.' . implode(', ' . $ext_col['target_table'] . '.', $ext_col['target_fields']);
            if (!empty($ext_col['relation']['intermediate_table'])) {
                // many to many
                $join_query = ' INNER JOIN `' . $ext_col['relation']['intermediate_table'] . '`
            ON `' . $ext_col['relation']['intermediate_table'] . '`.`' . $ext_col['relation']['intermediate_column_1'] . '`=`' . $ext_col['relation']['origin_table'] . '`.`' . $ext_col['relation']['origin_column'] . '`';

                $join_query .= ' INNER JOIN `' . $ext_col['target_table'] . '`
            ON `' . $ext_col['relation']['intermediate_table'] . '`.`' . $ext_col['relation']['intermediate_column_2'] . '`=`' . $ext_col['relation']['target_table'] . '`.`' . $ext_col['relation']['target_column'] . '`';
            } else {
                // one to many with the current table as target
                $join_query = ' INNER JOIN `' . $ext_col['relation']['origin_table'] . '`
            ON `' . $ext_col['relation']['origin_table'] . '`.`' . $ext_col['relation']['origin_column'] . '`=`' . $ext_col['relation']['target_table'] . '`.`' . $ext_col['relation']['target_column'] . '`';
            }

                /*
                $generator->external_columns = array(
                    'target_table'  => '',
                    'target_fields' => array(),
                    'table_label'   => '',
                    'fields_labels' => array(),
                    'relation'      => array(
                        'origin_table' // origin_table
                        'origin_column'
                        'intermediate_table'
                        'intermediate_column_1' // refers to origin_table
                        'intermediate_column_2' // refers to target_table
                        'target_table'
                        'target_column'
                    ),
                    'active'        => false
                );

               'relation'      => array(
                   'origin_table' => 'orders',
                   'origin_column' => 'ID',
                   'intermediate_table' => 'products_orders',
                   'intermediate_column_1' => 'orders_ID',
                   'intermediate_column_2' => 'products_ID',
                   'target_table' => 'products',
                   'target_column' => 'ID'
               );

               SELECT
                 products.product_name,
                 products.ID
               FROM
                 orders INNER JOIN
                 products_orders
                   ON products_orders.orders_ID = orders.ID INNER JOIN
                 products
                   ON products_orders.products_ID = products.ID
               WHERE
                 orders.ID = 1
                */
    ?>
            $qry = 'SELECT <?php echo $target_fields_query; ?> FROM <?php echo $generator->table; ?><?php echo $join_query; ?> WHERE <?php echo $generator->table; ?>.' . $this->primary_key . ' = ' . $this->pk[$i];
            $db->query($qry);
            $this->external_rows_count[$i][] = $db->rowCount();
            $ext_fields = array(
                'table'       => '<?php echo $target_table; ?>',
                'table_label' => '<?php echo $target_table; ?>',
                'uniqid'      => 'f-' . uniqid(),
                'fields'      => array(
    <?php
    for ($i=0; $i < count($ext_col['target_fields']); $i++) {
    ?>
                    '<?php echo $ext_col['target_fields'][$i]; ?>' => array()<?php if ($i + 1 < count($ext_col['target_fields'])) {
                        echo ',';
                     }
                    ?>

    <?php
    } // end for
    ?>
                )
            );
            if (!empty($this->external_rows_count[$i])) {
                while (! $db->endOfSeek()) {
                    $row = $db->row();
    <?php
    for ($i=0; $i < count($ext_col['target_fields']); $i++) {
    ?>
                    $ext_fields['fields']['<?php echo $ext_col['target_fields'][$i]; ?>'][]  = $row-><?php echo $ext_col['target_fields'][$i]; ?>;
    <?php
    } // end for
    ?>
                } // end while
            } // end if
            $this->external_fields[$i][] = $ext_fields;
    <?php
        } // end if active
    } // end foreach
    ?>
        } // end for
        $this->external_fields_count = count($this->external_fields);
<?php
}
?>

        // Export data button
        $this->export_data_button = ElementsUtilities::exportDataButtons($table, 'SELECT * FROM ' . $table . ' ORDER BY ' . $this->primary_key . ' ASC', 'excel, csv');
    }
}
