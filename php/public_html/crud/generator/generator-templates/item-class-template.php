<?php
use phpformbuilder\database\Mysql;
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

    // item name displayed
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
    echo '    public $' . ElementsUtilities::sanitizeFieldName($generator->columns['name'][$i]) . ' = array();' . "\n";
} // end for ?>

    public $export_data_button;
    public $filtered_columns = '';
    public $filters_form;
    public $join_query       = '';
    public $main_query       = '';
    public $pagination_html;
    public $records_count;
    public $select_number_per_page;
    public $sorting;
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

        if (file_exists(ADMIN_DIR . 'crud-data/' . $this->item . '-filter-data.json')) {
            $json = file_get_contents(ADMIN_DIR . 'crud-data/' . $this->item . '-filter-data.json');
            $filters_array = json_decode($json, true);
        }
        $this->item_url = $_SERVER['REQUEST_URI'];
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
    $from_to     = $generator->relations['from_to'];
    $join_query  = array();
    $used_tables = array();
    if (is_array($from_to)) {
        foreach ($from_to as $ft) {
            if ($ft['origin_table'] == $generator->table) {
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
    $columns_count = count($columns['table']);
    $columns_query = implode(', ', $columns['query']);
    $join_query    = implode('', $join_query);
    if (!empty($join_query)) {
?>
        $this->join_query = '<?php echo $join_query; ?>';
        $qry_start        = 'SELECT <?php echo $columns_query ?> FROM <?php echo $generator->table; ?>';
<?php
    } else {
?>
        $qry_start        = 'SELECT <?php echo $columns_query ?> FROM <?php echo $generator->table; ?>';
<?php
    }
?>

        // restricted rights query
        $qry_restriction = '';
        if (Secure::canReadRestricted($table)) {
            $qry_restriction = Secure::getRestrictionQuery($table);
        }

        // filters
        $filters           = new ElementsFilters($table, $filters_array, $this->join_query);
        $filters_where_qry = $filters->returnWhereQry();
        if (!empty($qry_restriction)) {
            $filters_where_qry = str_replace('WHERE', 'AND', $filters_where_qry);
        }

        // search
        $search_query = '';
        if (isset($_POST['search_field']) && isset($_POST['search_string'])) {
            $_SESSION['rp_search_field'][$table] = $_POST['search_field'];
            $_SESSION['rp_search_string'][$table] = $_POST['search_string'];
        }

        if (isset($_SESSION['rp_search_string'][$table]) && !empty($_SESSION['rp_search_string'][$table])) {
            $sf = $_SESSION['rp_search_field'][$table];
            $search_field = '`' . $table . '`.`' . $sf . '`';
            $search_field2 = '';
            $search_string_sqlvalue = Mysql::sqlValue('%' . $_SESSION['rp_search_string'][$table] . '%', Mysql::SQLVALUE_TEXT);
            if (file_exists(ADMIN_DIR . 'crud-data/' . $this->item . '-select-data.json')) {
                $json = file_get_contents(ADMIN_DIR . 'crud-data/' . $this->item . '-select-data.json');
                $selects_array = json_decode($json, true);
                if (isset($selects_array[$sf])) {
                    if ($selects_array[$sf]['from'] == 'from_table') {
                        $search_field = '`' . $selects_array[$sf]['from_table'] . '`.`' . $selects_array[$sf]['from_field_1'] . '`';
                        if (!empty($selects_array[$sf]['from_field_2'])) {
                            $search_field2 = '`' . $selects_array[$sf]['from_table'] . '`.`' . $selects_array[$sf]['from_field_2'] . '`';
                        }
                    }
                }
            }
            $search_query = ' WHERE (' . $search_field . ' LIKE ' . $search_string_sqlvalue;
            if (!empty($search_field2)) {
                $search_query .= ' OR ' . $search_field2 . ' LIKE ' . $search_string_sqlvalue;
            }
            $search_query .= ')';
        }

        if (!empty($qry_restriction) || !empty($filters_where_qry)) {
            $search_query = str_replace('WHERE', 'AND', $search_query);
        }

        if (isset($_SESSION['filtered_columns']) && is_array($_SESSION['filtered_columns'])) {
            $this->filtered_columns = implode(', ', $_SESSION['filtered_columns']);
        }
        $this->filters_form = $filters->returnForm($this->item_url);

        $active_filters_join_queries = array();

        // Get join queries from active filters
        $active_filters_join_queries = $filters->buildElementJoinQuery();

        // sorting query
        $this->sorting = ElementsUtilities::getSorting($table, '<?php echo $generator->list_options['order_by']; ?>', '<?php echo $generator->list_options['order_direction']; ?>');
        $qry_sorting   = " ORDER BY" . $this->sorting;

        $db = new Pagination();
        $pagination_url = $_SERVER['REQUEST_URI'];
        if (isset($_POST['npp']) && is_numeric($_POST['npp'])) {
            $_SESSION['npp'] = $_POST['npp'];
        } elseif (!isset($_SESSION['npp'])) {
            $_SESSION['npp'] = 20;
        }

        $npp = $_SESSION['npp'];
        if (!empty($search_query) && PAGINE_SEARCH_RESULTS === false) {
            $npp = 1000000;
        }

        // $this->main_query is the query without pagination.
        $this->main_query = $qry_start . $active_filters_join_queries . $qry_restriction . $filters_where_qry . $search_query . $qry_sorting;

        // echo $this->main_query;

        $this->pagination_html = $db->pagine($this->main_query, $npp, 'p', $pagination_url, 5, true, '/', '');

        $this->records_count = $db->rowCount();
        $primary_key = $this->primary_key_alias;
        if (!empty($this->records_count)) {
            while (!$db->endOfSeek()) {
                $row = $db->row();
                $this->pk[] = $row->$primary_key;
<?php
for ($i=0; $i < $columns_count; $i++) {
    if ($generator->columns['select_from'][$i] == 'from_table' && $generator->columns['select_multiple'][$i] > 0) {
?>
                $test_if_json = json_decode(<?php echo $columns['value'][$i]; ?>);
                if (json_last_error() == JSON_ERROR_NONE && is_array($test_if_json)) {
                    $this-><?php echo ElementsUtilities::sanitizeFieldName($columns['name'][$i]); ?>[] =  implode(', ', $test_if_json);
                } else {
                    $this-><?php echo ElementsUtilities::sanitizeFieldName($columns['name'][$i]); ?>[]=  <?php echo $columns['value'][$i]; ?>;
                }
<?php
    } else {
        echo '                $this->' . ElementsUtilities::sanitizeFieldName($columns['name'][$i]) . '[]= ' . $columns['value'][$i] . ';' . "\n";
    }
} // end for
?>
            }
        }

        // Autocomplete doesn't need the followings settings
        if (!isset($_POST['is_autocomplete'])) {

            // CREATE/DELETE rights
            if (Secure::canCreate($table) || Secure::canCreateRestricted($table) === true) {
                $this->can_create = true;
            }

            // restricted UPDATE rights
            if (Secure::canUpdateRestricted($table) === true) {
                $qry_restriction = Secure::getRestrictionQuery($table);

                if (!empty($qry_restriction)) {
                    $filters_where_qry = str_replace('WHERE', 'AND', $filters_where_qry);
                }

                // get authorized update primary keys
                $db = new Pagination();
                $pagination_html = $db->pagine($qry_start . $active_filters_join_queries . $qry_restriction . $filters_where_qry . $search_query . $qry_sorting, $npp, 'p', $pagination_url, 5, true, '/', '');
                $records_count = $db->rowCount();
                $primary_key = $this->primary_key_alias;
                if (!empty($records_count)) {
                    while (!$db->endOfSeek()) {
                        $row = $db->row();
                        $this->authorized_update_pk[] = $row->$primary_key;
                    }
                }
            } elseif (Secure::canUpdate($table) === true) {

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
                $this->external_fields[$i]     = array();
                $this->external_add_btn[$i]    = array();
                $db = new Mysql();
<?php
    foreach ($generator->external_columns as $key => $ext_col) {
        if ($ext_col['active'] === true) {
            $origin_table = $ext_col['relation']['origin_table'];
            $target_table = $ext_col['relation']['target_table'];
            $intermediate_table = $ext_col['relation']['intermediate_table'];

            if (!empty($intermediate_table)) {
                // many to many
                $relation_table = $target_table;
?>

                // <?php echo $origin_table; ?> => <?php echo $intermediate_table; ?> => <?php echo $target_table; ?>

<?php
            } else {
                // one to many with the current table as target
                $relation_table = $origin_table;
?>
                // <?php echo $origin_table; ?> => <?php echo $target_table; ?>

<?php
            }

            /* get the primary key of the relation table
            to build the edit/delete links
            -------------------------------------------------- */

            if (!empty($intermediate_table)) {
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

                // if many to many the READ LIST links lead to the intermediate relation table
                $upperCamelCase_intermediate_table = ElementsUtilities::upperCamelCase($intermediate_table);
                $relation_item = mb_strtolower($upperCamelCase_intermediate_table);
            } else {
                // one to many with the current table as target
                $origin_table_pk_column = 'unknown_primary_key';

                $db = new Mysql();
                $db->selectDatabase($generator->database);
                $qry = 'SHOW COLUMNS FROM ' . $origin_table;
                $db->query($qry);
                $columns_count = $db->rowCount();
                if (!empty($columns_count)) {
                    while (! $db->endOfSeek()) {
                        $row = $db->row();

                        // last row is table comments, skip it.
                        if (isset($row->Field)) {
                            if ($row->Key == 'PRI') {
                                $origin_table_pk_column  = $row->Field;
                            }
                        }
                    }
                }
                $upperCamelCase_origin_table = ElementsUtilities::upperCamelCase($origin_table);
                $relation_item = mb_strtolower($upperCamelCase_origin_table);
            }

            $fields_query = '';
            // SELECT payment.payment_id AS payment_payment_id, payment.payment_id, customer.amount, customer.payment_date FROM customer INNER JOIN `payment`
            // change the primary key to alias in the query
            if (!empty($intermediate_table)) {
                // remove pk from the target fields for the query
                $to_remove = array($intermediate_table_pk_column);
                $ext_cols_target_fields_without_pk = array_diff($ext_col['target_fields'], $to_remove);
                $fields_query .= $intermediate_table . '.' . $intermediate_table_pk_column . ' AS ' . $intermediate_table . '_' . $intermediate_table_pk_column . ', ';
                $fields_query .= $relation_table . '.' . implode(', ' . $target_table . '.', $ext_cols_target_fields_without_pk);
            } else {
                $to_remove = array($origin_table_pk_column);
                $ext_cols_target_fields_without_pk = array_diff($ext_col['target_fields'], $to_remove);
                if ($origin_table != $target_table) {
                    $fields_query .= $origin_table . '.' . $origin_table_pk_column . ' AS ' . $origin_table . '_' . $origin_table_pk_column;
                    if (count($ext_cols_target_fields_without_pk) > 0) {
                        $fields_query .= ', ';
                        $fields_query .= $relation_table . '.' . implode(', ' . $relation_table . '.', $ext_cols_target_fields_without_pk);
                    }
                } else {
                    // self-reference table => we use aliases
                    // t2       = origin
                    // t1       = target
                    // relation = origin (t2)
                    $fields_query .= 't2.' . $origin_table_pk_column . ' AS ' . $origin_table . '_' . $origin_table_pk_column;
                    if (count($ext_cols_target_fields_without_pk) > 0) {
                        $fields_query .= ', ';
                        $fields_query .= 't2.' . implode(', t1' . $target_table . '.', $ext_cols_target_fields_without_pk);
                    }
                }
            }

            if (!empty($intermediate_table)) {
                // many to many
                $join_query = ' INNER JOIN `' . $intermediate_table . '`
            ON `' . $intermediate_table . '`.`' . $ext_col['relation']['intermediate_column_1'] . '`=`' . $origin_table . '`.`' . $ext_col['relation']['origin_column'] . '`';

                $join_query .= ' INNER JOIN `' . $target_table . '`
            ON `' . $intermediate_table . '`.`' . $ext_col['relation']['intermediate_column_2'] . '`=`' . $target_table . '`.`' . $ext_col['relation']['target_column'] . '`';
            } else {
                // one to many with the current table as target
                if ($origin_table != $target_table) {
                    $join_query = ' INNER JOIN `' . $origin_table . '`
            ON `' . $origin_table . '`.`' . $ext_col['relation']['origin_column'] . '`=`' . $target_table . '`.`' . $ext_col['relation']['target_column'] . '`';
                } else {
                    // self-reference table => we use aliases
                    $join_query = ' INNER JOIN `' . $origin_table . '` t2
            ON `t2`.`' . $ext_col['relation']['origin_column'] . '`=`t1`.`' . $ext_col['relation']['target_column'] . '`';

                // ie:
                // $qry = 'SELECT t1.brand_id AS brand_brand_id, t1.brand_name FROM brand AS t1 INNER JOIN `brand` t2 ON `t1`.`is_sub_brand`=`t2`.`brand_id` WHERE t1.' . $this->primary_key . ' = ' . $this->pk[$i];
                }
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
                'allow_crud_in_list' => false
                'active'             => false
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

            $from  = $generator->table;
            $where = $generator->table;
            if (empty($intermediate_table) && $origin_table == $target_table) {
                // if one to many self-reference table
                $from .= ' AS t1';
                $where = 't1';
            }
?>
                $qry = 'SELECT <?php echo $fields_query; ?> FROM <?php echo $from; ?><?php echo $join_query; ?> WHERE <?php echo $where; ?>.' . $this->primary_key . ' = ' . $this->pk[$i];
                $db->query($qry);
                $records_count = $db->rowCount();
                $this->external_rows_count[$i][] = $records_count;
                $ext_fields = array(
                    'table'       => '<?php echo $relation_table; ?>',
                    'table_label' => '<?php echo $ext_col['table_label']; ?>',
                    'uniqid'      => 'f-' . uniqid(),
                    'fields'      => array(
<?php
            for ($i=0; $i < count($ext_col['target_fields']); $i++) {
                ?>
                    '<?php echo $ext_col['target_fields'][$i] . '\' => array()';
                    if ($i + 1 < count($ext_col['target_fields'])) {
                        echo ',';
                    }
?>

<?php
            } // end for
?>
                    ),
                    'fieldnames'      => array(
<?php
            for ($i=0; $i < count($ext_col['target_fields']); $i++) {
                ?>
                        '<?php echo $ext_col['target_fields'][$i] . '\' => \'' . $ext_col['target_fields'][$i] . '\'';
                    if ($i + 1 < count($ext_col['target_fields'])) {
                        echo ',';
                    }
                    echo "\n";
            } // end for
?>
                    )
<?php

            // add url query parameter with primary key
            $url_query_parameters = '';
            if (empty($ext_col['relation']['intermediate_table'])) {
                // if relation is one to many
                $url_query_parameters = '?' . $ext_col['relation']['origin_column'] . '=\' . $this->pk[$i] . \'';
            } else {
                $url_query_parameters = '?' . $ext_col['relation']['intermediate_column_1'] . '=\' . $this->pk[$i] . \'';
            }
?>
                );

                // get user custom fieldnames
                $ext_fieldnames = ElementsUtilities::getFieldNames($ext_fields['table']);
                if ($ext_fieldnames !== false) {
                    foreach ($ext_fields['fieldnames'] as $key => $value) {
                        if (isset($ext_fieldnames[$key])) {
                            $ext_fields['fieldnames'][$key] = $ext_fieldnames[$key];
                        }
                    }
                }
                // add button
                $add_btn = '';
<?php
            if (!empty($ext_col['relation']['intermediate_table']) || $ext_col['allow_crud_in_list'] === true) {
                // if many to many relation | one to many relation with allow_crud_in_list
?>
                if (Secure::canCreate('<?php echo $relation_table; ?>') === true) {
                    if (!empty($records_count)) {
                        // add button for nested table
                        $add_btn = '<div class="d-flex flex-row-reverse mb-2">';
                        $add_btn .= '    <a href="' . ADMIN_URL . '<?php echo $relation_item; ?>/create<?php echo $url_query_parameters; ?>" class="btn btn-xs btn-primary legitRipple" title="<?php echo ADD_NEW; ?>" data-popup="tooltip" data-delay="500"><span class="fas fa-plus-circle position-left"></span><?php echo ADD_NEW; ?> <?php echo $ext_col['table_label']; ?></a>';
                        $add_btn .= '</div>';
                    } else {
                        // add button for empty cell
                        $add_btn = '<div class="d-flex justify-content-center">';
                        $add_btn .= '    <a href="' . ADMIN_URL . '<?php echo $relation_item; ?>/create<?php echo $url_query_parameters; ?>" class="btn btn-xs btn-outline-secondary legitRipple" title="<?php echo ADD_NEW; ?>" data-popup="tooltip" data-delay="500"><span class="fas fa-plus-circle position-left"></span><?php echo ADD_NEW; ?></a>';
                        $add_btn .= '</div>';
                    }
                }
<?php
            } // end if
?>
                $this->external_add_btn[$i][] = $add_btn;


                if (!empty($records_count)) {
                    while (! $db->endOfSeek()) {
                        $row = $db->row();
<?php
            for ($i=0; $i < count($ext_col['target_fields']); $i++) {
                    // replace the primary key with the alias used in query
                $row_field = $ext_col['target_fields'][$i];
                if (!empty($intermediate_table)) {
                    if ($row_field == $intermediate_table_pk_column) {
                        $row_field = $intermediate_table . '_' . $intermediate_table_pk_column;
                    }
                } else if ($row_field == $origin_table_pk_column) {
                    $row_field = $origin_table . '_' . $origin_table_pk_column;
                }
?>
                        $test_if_json = json_decode($row-><?php echo $row_field; ?>);
                        if (json_last_error() == JSON_ERROR_NONE && is_array($test_if_json)) {
                        $ext_fields['fields']['<?php echo $ext_col['target_fields'][$i]; ?>'][] = implode(', ', $test_if_json);
                        } else {
                            $ext_fields['fields']['<?php echo $ext_col['target_fields'][$i]; ?>'][] = $row-><?php echo $row_field; ?>;
                        }
<?php
            } // end for
            if (!empty($ext_col['relation']['intermediate_table']) || $ext_col['allow_crud_in_list'] === true) {
                // if many to many relation | one to many relation with allow_crud_in_list
                if (!empty($ext_col['relation']['intermediate_table'])) {
                    $relation_table_pk_column = $intermediate_table . '_' . $intermediate_table_pk_column;
                } else {
                    $relation_table_pk_column = $origin_table . '_' . $origin_table_pk_column;
                }
?>

                        // edit/delete buttons
                        if (Secure::canUpdate('<?php echo $relation_table; ?>') === true || Secure::canCreate('<?php echo $relation_table; ?>') === true) {
                            $action_btns  = '<div class="btn-group">';
                            if (Secure::canUpdate('<?php echo $relation_table; ?>') === true) {
                                $action_btns  .= '<a href="<?php echo $relation_item; ?>/edit/' . $row-><?php echo $relation_table_pk_column; ?> . '" class="btn btn-xs btn-warning legitRipple" title="' . addslashes(EDIT) . '" rel="noindex" data-popup="tooltip" data-delay="500"><span class="fas fa-pencil-alt"></span></a>';
                            }
                            if (Secure::canCreate('<?php echo $relation_table; ?>') === true) {
                                $action_btns  .= '<a href="<?php echo $relation_item; ?>/delete/' . $row-><?php echo $relation_table_pk_column; ?> . '" class="btn btn-xs btn-danger legitRipple" title="' . addslashes(DELETE_CONST) . '" rel="noindex" data-popup="tooltip" data-delay="500"><span class="fas fa-times-circle"></span></a>';
                            }
                            $action_btns  .= '</div>';
                            $ext_fields['fieldnames']['action'] = ACTION_CONST;
                            $ext_fields['fields']['action'][] = $action_btns;
                        } // end if
<?php
            } // end if
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
        } // end if

        // Export data button
        $this->export_data_button = ElementsUtilities::exportDataButtons($table, $this->main_query, 'excel, csv, browser');

        // number/page
        $numbers_array = array(5, 10, 20, 50, 100, 200, 10000);
        $this->select_number_per_page = ElementsUtilities::selectNumberPerPage($numbers_array, $_SESSION['npp'], $this->item_url);
    }
}
