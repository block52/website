<?php
namespace generator;

use phpformbuilder\Form;
use phpformbuilder\database\Mysql;
use common\Utils;
use crud\ElementsUtilities;

/**
 * Php CRUD Generator Class
 *
 * @version available in conf/conf.php
 * @author Gilles Migliori - gilles.migliori@gmail.com
 *
 */

class Generator
{
    public $authentication_module_enabled = ADMIN_LOCKED;
    public $database;

    /* current database table relations
    $this->relations = array(
        'db' = array(
            'table'             => $row->TABLE_NAME,
            'column'            => $row->COLUMN_NAME,
            'referenced_table'  => $row->REFERENCED_TABLE_NAME,
            'referenced_column' => $row->REFERENCED_COLUMN_NAME
        ),
        'all_db_related_tables' = array(), // = tables + referenced_tables
        'from_to' = array(
            'origin_table'
            'origin_column'
            'intermediate_table'
            'intermediate_column_1' // refers to origin_table
            'intermediate_column_2' // refers to target_table
            'target_table'
            'target_column',
            'cascade_delete_from_intermediate' // true will automatically delete all matching records according to foreign keys constraints. Default: true
            'cascade_delete_from_origin' // true will automatically delete all matching records according to foreign keys constraints. Default: true
        ),
        'from_to_origin_tables' = array(), // = All from_to['origin_table']
        ,
        'from_to_target_tables' = array(), // = All from_to['target_table']
    );
    */

    public $relations = array();
    public $tables    = array();
    public $table;
    public $default_table_icon = 'fas fa-pencil-alt';
    public $table_icon;
    public $table_label;

    // item = lowercase table name without '-' and '_'
    public $item;
    public $columns_count;
    public $diff_files_form = '';

    /* columns properties extracted from db
        $this->db_columns = array(
            'name',
            'type',
            'null',
            'key',
            'extra'
        );
    */
    public $db_columns = array();

    /* translated properties corresponding to generator needs
        $this->columns = array(
            'name',
            'column_type',
            'field_type'

            'relation' = array(
                'target_table',
                'target_fields' // comma separated
            ),

            'validation_type'
            'value_type',
            'validation',
            'primary',
            'auto_increment'

            'fields' = array(
                $columns_name => $columns_label
            )

            'jedit'
            'special' // file path | image path | date display format | password constraints
            'special2' // file url | image url | time display format if datetime or timestamp
            'special3' // file types | image thumbnails (bool) | date_now_hidden (bool)
            'special4' // image editor
            'special5' // image width
            'special6' // image height
            'special7' // image crop
            'sorting'
            'nested'
            'skip'
            'select_from' // from_table | custom_values
            'select_from_table'
            'select_from_value'
            'select_from_field_1'
            'select_from_field_2'
            'select_custom_values'
            'select_multiple'

            'help_text'
            'tooltip'
            'required'
            'char_count'
            'char_count_max'
            'tinyMce'
            'field_width'
        );

        columns types list : ( = database columns)
            boolean|tinyint|smallint|mediumint|int|bigint|decimal|float|double|real|date|datetime|timestamp|time|year|char|varchar|tinytext|text|mediumtext|longtext|enum|set

        field types list : ( = create update fields)
            boolean|checkbox|color|date|datetime|email|file|hidden|image|month|number|password|radio|select|text|textarea|time|url

        value types list : ( = read paginated display values)
            array|boolean|color|date|datetime|time|file|image|number|password|set|text|url

        NOTE:
        -----
        Changing value_type in the read paginated list changes automatically the corresponding field_type in generator columns properties.
        The reverse is not true: when we change the field_type in the create/update form it doesn't update the read paginated's value_type

        fields width :
            '100%'         = col(2, 10)
            '66% grouped'  = col(2, 6)
            '66% single'
            '50% grouped'  = col(2, 4)
            '50% single'
            '33% grouped'  = col(2, 2)
            '33% single'
    */
    public $columns = array();

    /*
    $this->external_columns = array(
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

    // relation = $this->relations['from_to'][$i]
    */
    public $external_columns = array();

    /**
     * $this->list_options = array(
     *    'list_type', // build_paginated_list|build_single_element_list
     *    'open_url_btn',
     *    'export_btn',
     *    'bulk_delete',
     *    'default_search_field',
     *    'order_by',
     *    'order_direction',
     *    'filters' => array()
     * );
     */
    public $list_options = array();
    public $primary_key;
    public $field_delete_confirm_1;
    public $field_delete_confirm_2;

    /**
     * action sent by POST
     *    'build_paginated_list'
     *    'build_single_element_list'
     *    'build_create_edit'
     *    'build_delete'
     */
    public $debug;
    /**
     * $simulate_and_debug:
     * if true, will simulate DB reset structure when posted,
     * and record results in generator/class/generator/reload-table-data-debug.log
     */
    private $simulate_and_debug = false;
    public $action = '';

    /**
     * get databases from root
     * @return null
     */
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        $this->checkRequiredFiles();
        $db = new Mysql();
        if ($db->selectDatabase(DBNAME) === true) {
            $this->database = DBNAME;
            // register if no database error
            $_SESSION['generator'] = $this;
        } else {
            $this->userMessage(FAILED_TO_CONNECT_DB, 'alert-danger has-icon');
        }
        $this->logMessage('<span class="font-weight-bold">construct</strong>');
    }

    /**
     * register POST data
     * set action
     * @return null
     */
    public function init()
    {
        // enable|disable admin authentification module (Secure)
        if (isset($_POST['lock-unlock-admin']) && Form::testToken('lock-unlock-admin') === true && DEMO !== true) {
            if (isset($_POST['lock-admin']) && ($_POST['lock-admin'] > 0)) {
                if ($this->lockAdminPanel() === true) {
                    $this->userMessage(ADMIN_AUTHENTIFICATION_MODULE_ENABLED, 'alert-success has-icon');
                    $this->authentication_module_enabled = true;
                }
            } elseif (isset($_POST['unlock-admin']) && ($_POST['unlock-admin'] > 0)) {
                if ($this->unlockAdminPanel() === true) {
                    $this->userMessage(ADMIN_AUTHENTIFICATION_MODULE_DISABLED, 'alert-success has-icon');
                    $this->authentication_module_enabled = false;
                }
            }
        } elseif (isset($_POST['form-remove-authentification-module']) && Form::testToken('form-remove-authentification-module') === true && DEMO !== true) {
            if (!empty($this->database) && $_POST['remove'] > 0) {
                $this->removeAuthentificationModule();
            } elseif (empty($this->database)) {
                $this->userMessage(SELECT_DATABASE, 'alert-warning has-icon');
            }
        }
        $this->action = '';
        if (isset($_POST['form-select-table']) && Form::testToken('form-select-table') === true) {
            if (empty($this->database)) {
                $this->userMessage(SELECT_DATABASE, 'alert-warning has-icon');

                return false;
            } else {
                $this->table = $_POST['table'];
                $this->table_icon = $this->getIcon($_POST['table']);
                $this->table_label = $this->getLabel($_POST['table']);
                $upperCamelCaseTable = ElementsUtilities::upperCamelCase($this->table);
                $this->item = mb_strtolower($upperCamelCaseTable);
                $this->reset('columns');
                $this->logMessage('<span class="font-weight-bold">init</strong> => Generator table (from POST) = ' . $this->table);
            }
        }

        if (!empty($this->database)) {
            // delete relation file if exists (will be regenerated on page reload)
            if (isset($_POST['reset-relations']) && $_POST['reset-relations'] > 0 && Form::testToken('form-reset-relations') === true) {
                if (DEMO !== true) {
                    $this->resetRelations();
                } else {
                    $this->userMessage('Feature disabled in DEMO', 'alert-danger has-icon');
                }
            }
            $this->getRelations();

            // delete table files if exist (will be regenerated on page reload)
            if (isset($_POST['reset-table']) && $_POST['reset-table'] > 0 && DEMO !== true) {
                if (DEMO !== true) {
                    $this->table = $_POST['table-to-reset'];
                    $this->table_icon = $this->getIcon($this->table);
                    $this->table_label = $this->getLabel($this->table);
                    $upperCamelCaseTable = ElementsUtilities::upperCamelCase($this->table);
                    $this->item = mb_strtolower($upperCamelCaseTable);
                    $this->reset('columns');
                    $this->logMessage('<span class="font-weight-bold">init</strong> => Generator table (from table-to-reset POST) = ' . $this->table);
                    // reset table (structure + data) in all cases
                    $this->deleteTableData();

                    if ($_POST['reset-data'] < 1) {
                        // reload old data
                        $this->reloadTableData();
                    }
                } else {
                    $this->userMessage('Feature disabled in DEMO', 'alert-danger has-icon');
                }
            }
        }
        // set action :
        //      build_create_edit
        //      build_paginated_list
        //      build_single_element_list
        //      build_delete
        if (isset($_POST['action']) && isset($_POST['form-select-fields']) && Form::testToken('form-select-fields') === true && DEMO !== true) {
            if ($_POST['action'] == 'build_read') {
                $this->action = $_POST['list_type'];
            } else {
                $this->action = $_POST['action'];
            }
        }

        // Create form with all backup files in a dropdown select
        $this->createDiffFileList();
    }

    /**
     * get tables from current database
     * @return null
     */
    public function getTables()
    {
        if (empty($this->tables)) {
            $db = new Mysql();
            $db->selectDatabase($this->database);
            $tables = $db->getTables();
            $registration_table_key = array_search('user_data', $tables);
            if ($registration_table_key !== false) {
                unset($tables[$registration_table_key]);
            }
            $this->tables = $tables;

            // delete tables if they're in admin/crud-data/db-data.json but not in real database
            if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
                $do_refresh_relations = false;
                $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
                $db_data = json_decode($json, true);
                if (!empty($db_data)) {
                    foreach ($db_data as $table => $data) {
                        if (!in_array($table, $this->tables)) {
                            $this->deleteTableData($table);
                            $do_refresh_relations = true;
                        }
                    }
                }
                if ($do_refresh_relations === true) {
                    $this->resetRelations();
                    $this->registerRelations();
                }
            }

            // test invalid characters
            $tables_with_invalid_chars = array();
            $columns_with_invalid_chars = array();
            if (count($this->tables) > 0) {
                foreach ($this->tables as $table) {
                    if (!preg_match('`^[a-zA-Z0-9_]+$`', $table) || preg_match('`^[0-9]{1}`', $table)) {
                        $tables_with_invalid_chars[] = $table;
                    }
                    $columns = $db->GetColumnNames($table);
                    foreach ($columns as $column_name) {
                        if (!preg_match('`^[a-zA-Z0-9_]+$`', $column_name) || preg_match('`^[0-9]{1}`', $column_name)) {
                            $columns_with_invalid_chars[] = $table . '.' . $column_name;
                        }
                    }
                }
                if (!empty($tables_with_invalid_chars)) {
                    $find = array('%target_name%', '%target_values%');
                    $replace = array('tables', implode('<br>', $tables_with_invalid_chars));
                    $error_msg = str_replace($find, $replace, INVALID_CHARS_ERROR);
                    $this->userMessage($error_msg, 'alert-warning has-icon');
                }
                if (!empty($columns_with_invalid_chars)) {
                    $find = array('%target_name%', '%target_values%');
                    $replace = array('columns', implode('<br>', $columns_with_invalid_chars));
                    $error_msg = str_replace($find, $replace, INVALID_CHARS_ERROR);
                    $this->userMessage($error_msg, 'alert-danger has-icon');
                }
            }
            $this->logMessage('<span class="font-weight-bold">getTables</strong> => Get tables from DB');
        } else {
            $this->logMessage('<span class="font-weight-bold">getTables</strong> => Tables already registered');
        }

        // select default table
        if (empty($this->table)) {
            $this->table         = $this->tables[0];
            $this->table_icon    = $this->getIcon($this->tables[0]);
            $this->table_label   = $this->getLabel($this->tables[0]);
            $upperCamelCaseTable = ElementsUtilities::upperCamelCase($this->table);
            $this->item          = mb_strtolower($upperCamelCaseTable);
            $this->logMessage('<span class="font-weight-bold">getTables</strong> => generator default table = ' . $this->table);
        }
    }

    /**
     * get columns from current table
     * @return null
     */
    public function getDbColumns()
    {
        if (empty($this->db_columns)) {
            $this->db_columns = array(
                'name' => array(),
                'type' => array(),
                'null' => array(),
                'key' => array(),
                'extra' => array()
            );
            $db = new Mysql();
            $db->selectDatabase($this->database);
            $qry = 'SHOW COLUMNS FROM ' . $this->table;
            $db->query($qry);
            $this->columns_count = $db->rowCount();
            if (!empty($this->columns_count)) {
                while (! $db->endOfSeek()) {
                    $row = $db->row();

                    // last row is table comments, skip it.
                    if (isset($row->Field)) {
                        $this->db_columns['name'][]  = $row->Field;
                        $this->db_columns['type'][]  = $row->Type;

                        // allow null for auto_increment
                        if ($row->Extra == 'auto_increment') {
                            $this->db_columns['null'][]  = 'YES';
                        } else {
                            $this->db_columns['null'][]  = $row->Null;
                        }
                        $this->db_columns['key'][]   = $row->Key;
                        $this->db_columns['extra'][] = $row->Extra;
                    }
                }
                if (!in_array('PRI', $this->db_columns['key'])) {
                    $this->userMessage(NO_PRIMARY_KEY, 'alert-danger has-icon');
                }
            }
            $this->logMessage('<span class="font-weight-bold">getDbColumns</strong>');
        } else {
            $this->logMessage('<span class="font-weight-bold">getDbColumns</strong> => Columns already registered');
        }
    }

    public function registerColumnsProperties()
    {
        if (empty($this->columns)) {
            // get columns properties from json if file exists
            if (file_exists(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->table . '.json')) {
                $json                         = file_get_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->table . '.json');
                $json_data                    = json_decode($json, true);
                $this->columns                = $json_data['columns'];
                $this->external_columns       = $json_data['external_columns'];
                $this->list_options           = $json_data['list_options'];
                $this->field_delete_confirm_1 = $json_data['field_delete_confirm_1'];
                $this->field_delete_confirm_2 = $json_data['field_delete_confirm_2'];

                // get primary key
                $key = array_search('true', $this->columns['primary']);
                $this->primary_key          = $this->columns['name'][$key];

                if (!array_key_exists('bulk_delete', $this->list_options)) {
                    $this->list_options['bulk_delete'] = false;
                }
                if (!array_key_exists('default_search_field', $this->list_options)) {
                    $this->list_options['default_search_field'] = '';
                }
                if (!in_array('order_by', $this->list_options)) {
                    $this->list_options['order_by'] = $this->primary_key;
                    $this->list_options['order_direction'] = 'ASC';
                }

                $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From JSON : ' . $this->database . '/' . $this->table . '.json');
            } else {
                // get columns properties from database field types
                $db_columns_data = $this->getColumnsDataFromDb();
                // var_dump($db_columns_data);

                // default fields for forms
                $text = array(
                    'tinyint',
                    'smallint',
                    'mediumint',
                    'int',
                    'bigint',
                    'decimal',
                    'float',
                    'double',
                    'real',
                    'char',
                    'varchar'
                );
                $textarea = array(
                    'tinytext',
                    'text',
                    'mediumtext',
                    'longtext'
                );
                $select = array(
                    'enum',
                    'set'
                );
                $boolean = array(
                    'boolean'
                );
                $date = array(
                    'date',
                    'year'
                );
                $datetime = array(
                    'datetime',
                    'timestamp'
                );
                $time = array(
                    'time'
                );
                for ($i=0; $i < $this->columns_count; $i++) {
                    // default values
                    $columns_name = $this->db_columns['name'][$i];
                    $columns_label = $this->toReadable($this->db_columns['name'][$i]);

                    $this->columns['name'][]        = $columns_name;
                    $this->columns['column_type'][] = $db_columns_data['column_type'][$i];

                    $select_from         = '';
                    $select_from_table   = '';
                    $select_from_value   = '';
                    $select_from_field_1 = '';
                    $select_from_field_2 = '';
                    $select_custom_values = '';

                    $field_type = 'text';

                    // default empty relation
                    $relation = array(
                        'target_table' => '',
                        'target_fields' => '' // comma separated
                    );

                    $has_relation = false;

                    // if current table has relations
                    if (is_array($this->relations['from_to_origin_tables']) && in_array($this->table, $this->relations['from_to_origin_tables'])) {
                        // find the corresponding index in $this->relations['from_to']
                        $index_array = Utils::findInIndexedArray($this->relations['from_to'], 'origin_table', $this->table);
                        foreach ($index_array as $index) {
                            if ($columns_name == $this->relations['from_to'][$index]['origin_column']) {
                                // if one-to-one or one-to-many relation
                                if (empty($this->relations['from_to'][$index]['intermediate_table'])) {
                                    $has_relation = true;
                                    $relation = array(
                                        'target_table' => $this->relations['from_to'][$index]['target_table'],
                                        'target_fields' => $this->relations['from_to'][$index]['target_column'] // default targeted field is the foreign key
                                    );

                                    // default select values = relation field
                                    $select_from         = 'from_table';
                                    $select_from_table   = $this->relations['from_to'][$index]['target_table'];
                                    $select_from_value   = $this->relations['from_to'][$index]['target_column'];
                                    $select_from_field_1 = $this->relations['from_to'][$index]['target_column'];
                                    $select_from_field_2 = '';
                                }
                            }
                        }
                    }

                    $value_type = 'text';
                    $special    = '';
                    $special2   = '';
                    $special3   = '';
                    $special4   = '';
                    $special5   = '';
                    $special6   = '';
                    $special7   = '';
                    $column_type = $db_columns_data['column_type'][$i];
                    if ($has_relation === true) {
                        $field_type = 'select';
                        $value_type = 'text';
                    } elseif ($db_columns_data['auto_increment'][$i] == true) {
                        $field_type = 'hidden';
                    } elseif (in_array($column_type, $textarea)) {
                        $field_type = 'textarea';
                    } elseif (in_array($column_type, $select)) {
                        $field_type = 'select';
                    } elseif (in_array($column_type, $boolean)) {
                        $field_type = 'boolean';
                        $value_type = 'boolean';
                    } elseif (in_array($column_type, $date)) {
                        $field_type = 'date';
                        $value_type = 'date';
                        $special = 'dd mmmm yyyy';
                    } elseif (in_array($column_type, $datetime)) {
                        $field_type = 'datetime';
                        $value_type = 'datetime';
                        $special = 'dd mmmm yyyy';
                        $special2 = 'H:i a';
                    } elseif (in_array($column_type, $time)) {
                        $field_type = 'time';
                        $value_type = 'time';
                        $special = 'H:i a';
                    }

                    // set select default values
                    if ($field_type == 'select' && !empty($db_columns_data['select_values'][$i])) {
                        $select_from         = 'custom_values';
                        $select_custom_values = $db_columns_data['select_values'][$i];
                    }

                    $this->columns['field_type'][]      = $field_type;
                    $this->columns['relation'][]        = $relation;
                    $this->columns['validation_type'][] = 'auto';
                    $this->columns['value_type'][]      = $value_type;
                    $this->columns['validation'][]      = $db_columns_data['validation'][$i];
                    $this->columns['primary'][]         = $db_columns_data['primary'][$i];
                    $this->columns['auto_increment'][]  = $db_columns_data['auto_increment'][$i];

                    $this->columns['fields'][$columns_name]  = $columns_label;

                    $this->columns['jedit'][]                = '';
                    $this->columns['special'][]              = $special;
                    $this->columns['special2'][]             = $special2;
                    $this->columns['special3'][]             = $special3;
                    $this->columns['special4'][]             = $special4;
                    $this->columns['special5'][]             = $special5;
                    $this->columns['special6'][]             = $special6;
                    $this->columns['special7'][]             = $special7;
                    $this->columns['sorting'][]              = false;
                    $this->columns['nested'][]               = false;
                    $this->columns['skip'][]                 = false;
                    $this->columns['select_from'][]          = $select_from;
                    $this->columns['select_from_table'][]    = $select_from_table;
                    $this->columns['select_from_value'][]    = $select_from_value;
                    $this->columns['select_from_field_1'][]  = $select_from_field_1;
                    $this->columns['select_from_field_2'][]  = $select_from_field_2;
                    $this->columns['select_custom_values'][] = $select_custom_values;
                    $this->columns['select_multiple'][]      = false;

                    $this->columns['help_text'][]  = '';
                    $this->columns['tooltip'][]    = '';
                    $required = false;
                    if ($this->db_columns['null'][$i] == 'NO') {
                        $required = true;
                    }
                    $this->columns['required'][]       = $required;
                    $this->columns['char_count'][]     = false;
                    $this->columns['char_count_max'][] = '';
                    $this->columns['tinyMce'][]        = false;
                    $this->columns['field_width'][]    = '100%';
                }

                /*  add external relations to columns list:
                    -   many to many
                    -   one to many with the current table as target
                */

                // reset
                $this->external_columns = array();

                // if current table has relations
                if (is_array($this->relations['from_to_origin_tables']) && in_array($this->table, $this->relations['from_to_origin_tables'])) {
                    // find the corresponding index in $this->relations['from_to']
                    $index_array = Utils::findInIndexedArray($this->relations['from_to'], 'origin_table', $this->table);
                    foreach ($index_array as $index) {
                        // if many-to-many relation
                        if (!empty($this->relations['from_to'][$index]['intermediate_table'])) {
                            // add external column data
                            $external_columns_name    = $this->relations['from_to'][$index]['target_table'];
                            $external_columns_labels  = array($this->getLabel($this->relations['from_to'][$index]['target_table']));
                            $this->external_columns[] = array(
                                'target_table'       => $this->relations['from_to'][$index]['target_table'],
                                'target_fields'      => array(
                                    $this->relations['from_to'][$index]['target_column'] // default targeted field is the foreign key
                                ),
                                'table_label'        => $external_columns_name,
                                'fields_labels'      => $external_columns_labels,
                                'relation'           => $this->relations['from_to'][$index],
                                'allow_crud_in_list' => false,
                                'allow_in_forms'     => true,
                                'forms_fields'       => array(),
                                'field_type'         => 'select-multiple',
                                'active'             => false
                            );
                        }
                    }
                }
                if (is_array($this->relations['from_to_target_tables']) && in_array($this->table, $this->relations['from_to_target_tables'])) {
                    // find the corresponding index in $this->relations['from_to']
                    $index_array = Utils::findInIndexedArray($this->relations['from_to'], 'target_table', $this->table);
                    foreach ($index_array as $index) {
                        // if one-to-many relation
                        if (empty($this->relations['from_to'][$index]['intermediate_table'])) {
                            // add external column data
                            $external_columns_name    = $this->relations['from_to'][$index]['origin_table'];
                            $external_columns_labels  = array($this->getLabel($this->relations['from_to'][$index]['origin_table']));
                            $this->external_columns[] = array(
                                'target_table'       => $this->relations['from_to'][$index]['origin_table'],
                                'target_fields'      => array(
                                    $this->relations['from_to'][$index]['origin_table'] // default targeted field is the foreign key
                                ),
                                'table_label'        => $external_columns_name,
                                'fields_labels'      => $external_columns_labels,
                                'relation'           => $this->relations['from_to'][$index],
                                'allow_crud_in_list' => false,
                                'allow_in_forms'     => true,
                                'forms_fields'       => array(),
                                'field_type'         => 'select-multiple',
                                'active'             => false
                            );
                        }
                    }
                }

                // default values
                $this->list_options = array(
                    'list_type'            => 'build_paginated_list',
                    'open_url_btn'         => true,
                    'export_btn'           => true,
                    'bulk_delete'          => false,
                    'default_search_field' => '',
                    'order_by'             => $this->primary_key,
                    'order_direction'      => 'ASC',
                    'filters'              => array()
                );

                $json_data = array(
                    'list_options'           => $this->list_options,
                    'columns'                => $this->columns,
                    'external_columns'       => $this->external_columns,
                    'field_delete_confirm_1' => $this->field_delete_confirm_1,
                    'field_delete_confirm_2' => $this->field_delete_confirm_2
                );

                // register table & columns properties in json file
                $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
                $this->registerJson($this->table . '.json', $json);
                $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From DB');
            }
        } elseif ($this->action == 'build_paginated_list') {
            $has_nested_table = false;
            for ($i=0; $i < $this->columns_count; $i++) {
                $column_name = $this->columns['name'][$i];
                $others = 'rp_others_' . $column_name;
                if ($_POST[$others] == 'nested') {
                    $has_nested_table = true;
                }
            }
            // edit columns properties from POST
            for ($i=0; $i < $this->columns_count; $i++) {
                $column_name                           = $this->columns['name'][$i];
                $column_label                          = $_POST['rp_label_' . $column_name];
                $value_type                            = 'rp_value_type_' . $column_name;
                $jedit                                 = 'rp_jedit_' . $column_name;
                $this->columns['fields'][$column_name] = $column_label;
                $this->columns['special'][$i]          = ''; // file path | image path | date display format | password constraints
                $this->columns['special2'][$i]         = ''; // file url | image url | time display format if datetime or timestamp
                $this->columns['special3'][$i]         = ''; // file types | image thumbnails (bool) | date_now_hidden (bool)
                $this->columns['special4'][$i]         = ''; // img editor
                $this->columns['special5'][$i]         = ''; // img width
                $this->columns['special6'][$i]         = ''; // img height
                $this->columns['special7'][$i]         = ''; // img crop
                $others                                = 'rp_others_' . $column_name;
                $this->columns['value_type'][$i]       = $_POST[$value_type];
                if (isset($_POST[$jedit])) {
                    $this->columns['jedit'][$i] = $_POST[$jedit];
                } else {
                    // if jedit field has been disabled
                    $this->columns['jedit'][$i] = '';
                }

                // update field_type according to value_type
                // (value_type = read paginated display value)
                // (field_type = create update field)
                if ($this->columns['value_type'][$i] == 'set') {
                    $this->columns['field_type'][$i] = 'select';
                } elseif ($this->columns['auto_increment'][$i] === true) {
                    $this->columns['field_type'][$i] = 'hidden';
                } elseif (!empty($this->columns['relation'][$i]['target_table'])) {
                    $this->columns['field_type'][$i] = 'select';
                } else {
                    $this->columns['field_type'][$i] = $this->columns['value_type'][$i];
                }

                // relation fields  - target values to display
                if (isset($_POST['rp_target_column_0_' . $column_name])) {
                    $this->columns['relation'][$i]['target_fields'] = $_POST['rp_target_column_0_' . $column_name];
                    if (!empty($_POST['rp_target_column_1_' . $column_name])) {
                        $this->columns['relation'][$i]['target_fields'] .= ', ' . $_POST['rp_target_column_1_' . $column_name];
                    }

                    // register chosen columns in select values
                    $this->columns['select_from_field_1'][$i] = $_POST['rp_target_column_0_' . $column_name];
                    $this->columns['select_from_field_2'][$i] = $_POST['rp_target_column_1_' . $column_name];
                }

                // special (image path | date display format | password constraint)
                if ($this->columns['value_type'][$i] == 'file') {
                    $this->columns['special'][$i]  = $_POST['rp_special_file_dir_' . $column_name];
                    $this->columns['special2'][$i] = $_POST['rp_special_file_url_' . $column_name];
                    $this->columns['special3'][$i] = $_POST['rp_special_file_types_' . $column_name];
                } elseif ($this->columns['value_type'][$i] == 'image') {
                    $this->columns['special'][$i]  = $_POST['rp_special_image_dir_' . $column_name];
                    $this->columns['special2'][$i] = $_POST['rp_special_image_url_' . $column_name];
                    $this->columns['special3'][$i] = $_POST['rp_special_image_thumbnails_' . $column_name];
                } elseif ($this->columns['value_type'][$i] == 'date' || $this->columns['value_type'][$i] == 'month') {
                    if (!empty($_POST['rp_special_date_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rp_special_date_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'dd mmmm yyyy';
                    }
                } elseif ($this->columns['value_type'][$i] == 'datetime') {
                    if (!empty($_POST['rp_special_date_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rp_special_date_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'dd mmmm yyyy';
                    }
                    if (!empty($_POST['rp_special_time_' . $column_name])) {
                        $this->columns['special2'][$i] = $_POST['rp_special_time_' . $column_name];
                    } else {
                        $this->columns['special2'][$i] = 'H:i a';
                    }
                } elseif ($this->columns['value_type'][$i] == 'time') {
                    if (!empty($_POST['rp_special_time_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rp_special_time_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'H:i a';
                    }
                } elseif ($this->columns['value_type'][$i] == 'password') {
                    $this->columns['special'][$i] = $_POST['rp_special_password_' . $column_name];
                }

                $this->columns['sorting'][$i] = false;
                $this->columns['nested'][$i]  = false;
                $this->columns['skip'][$i]    = false;
                if ($_POST[$others] == 'sorting') {
                    $this->columns['sorting'][$i] = true;
                } elseif ($_POST[$others] == 'nested') {
                    $this->columns['nested'][$i] = true;
                } elseif ($_POST[$others] == 'skip') {
                    $this->columns['skip'][$i] = true;
                }
            }

            $this->table_label = $_POST['rp_table_label'];

            // store main list values
            $this->list_options = array(
                'list_type'            => $_POST['list_type'],
                'open_url_btn'         => $_POST['rp_open_url_btn'],
                'export_btn'           => $_POST['rp_export_btn'],
                'bulk_delete'          => $_POST['rp_bulk_delete'],
                'default_search_field' => $_POST['rp_default_search_field'],
                'order_by'             => $_POST['rp_order_by'],
                'order_direction'      => $_POST['rp_order_direction'],
                'filters'              => array()
            );

            // unset the session value to refresh the admin list order
            if (isset($_SESSION['sorting_' . $this->table])) {
                unset($_SESSION['sorting_' . $this->table]);
                unset($_SESSION['direction_' . $this->table]);
            }

            // filters

            /*
                Simple filter example

            array(
                'select_label'    => 'Name',
                'select_name'     => 'mock-data',
                'option_text'     => 'mock_data.last_name + mock_data.first_name',
                'fields'          => 'mock_data.last_name, mock_data.first_name',
                'field_to_filter' => 'mock_data.last_name',
                'from'            => 'mock_data',
                'type'            => 'text',
                'column'          => 1
            )

                Advanced filter example

            array(
                'select_label'    => 'Secondary nav',
                'select_name'     => 'dropdown_ID',
                'option_text'     => 'nav_name + dropdown.name',
                'fields'          => 'dropdown.ID, dropdown.name, nav.name AS nav_name',
                'field_to_filter' => 'dropdown.ID',
                'from'            => 'dropdown Left Join nav On dropdown.nav_ID = nav.ID',
                'type'            => 'text',
                'column'          => 2
            )
            */

            if (isset($_POST['filters-dynamic-fields-index'])) {
                for ($i=0; $i <= $_POST['filters-dynamic-fields-index']; $i++) {
                    $filter_mode = $_POST['filter-mode-' . $i];
                    $filter_ajax = false;
                    if (isset($_POST['filter-ajax-' . $i])) {
                        $filter_ajax = boolval($_POST['filter-ajax-' . $i]);
                    }

                    // simple
                    if ($filter_mode == 'simple') {
                        $filter_A         = $_POST['filter_field_A-' . $i];
                        $field_index_A    = array_search($filter_A, $this->columns['name']);
                        $column_name      = $this->columns['name'][$field_index_A];
                        $select_label     = $this->columns['fields'][$column_name];
                        $select_name      = $filter_A;
                        $option_text      = $this->table . '.' . $filter_A;
                        $fields           = $this->table . '.' . $filter_A;
                        $field_to_filter  = $this->table . '.' . $filter_A;
                        $daterange        = false;
                        $from             = $this->table;
                        $from_table       = $this->table;
                        $join_tables      = array();
                        $join_queries     = array();
                        $type             = 'text';
                        if ($this->columns['column_type'][$field_index_A] == 'boolean') {
                            $type = 'boolean';
                        } else {
                            $datetime_field_types = explode(',', DATETIME_FIELD_TYPES);
                            if (in_array($this->columns['column_type'][$field_index_A], $datetime_field_types)) {
                                $type = $this->columns['column_type'][$field_index_A];
                                $daterange = boolval($_POST['filter-daterange-' . $i]);
                                if ($daterange === true) {
                                    $filter_ajax = false;
                                }
                            }
                        }

                        // find column index in admin list
                        $column_index = 1;
                        for ($j=0; $j < $this->columns_count; $j++) {
                            if ($this->columns['name'][$j] == $filter_A) {
                                break;
                            } elseif ($this->columns['skip'][$j] == false) {
                                $column_index ++;
                            }
                        }
                    } elseif ($filter_mode == 'advanced') {
                        $filter_A         = '';
                        $select_label     = $_POST['filter_select_label-' . $i];
                        $select_name      = mb_strtolower(ElementsUtilities::upperCamelCase($this->table)) . '-' . $i;
                        $option_text      = $_POST['filter_option_text-' . $i];
                        $fields           = $_POST['filter_fields-' . $i];
                        $field_to_filter  = $_POST['filter_field_to_filter-' . $i];
                        $from             = $_POST['filter_from-' . $i];
                        $filter_parsed    = $this->parseQuery($from);
                        $daterange        = false;
                        $from_table       = $filter_parsed['from_table'];
                        $join_tables      = $filter_parsed['join_tables'];
                        $join_queries     = $filter_parsed['join_queries'];
                        $type             = 'text';
                        if (isset($_POST['filter_type-' . $i])) {
                            $type        = $_POST['filter_type-' . $i];
                        }
                        $column_index    = $_POST['filter_column-' . $i];
                    }

                    // add 1 to column_index if there's a nested table
                    if ($has_nested_table == true) {
                        $column_index += 1;
                    }

                    $filter_data = array(

                        // generator simple data
                        'filter_mode'     => $filter_mode,
                        'filter_A'        => $filter_A,

                        // admin data
                        'ajax'             => $filter_ajax,
                        'select_label'     => $select_label,
                        'select_name'      => $select_name,
                        'option_text'      => $option_text,
                        'fields'           => $fields,
                        'field_to_filter'  => $field_to_filter,
                        'daterange'        => $daterange,
                        'from'             => $from,
                        'from_table'       => $from_table,
                        'join_tables'      => $join_tables,
                        'join_queries'     => $join_queries,
                        'type'             => $type,
                        'column'           => $column_index
                    );
                    $this->list_options['filters'][] = $filter_data;
                }
            }

            // external relations
            if (count($this->external_columns) > 0) {
                foreach ($this->external_columns as $key => $ext_col) {
                    $this->external_columns[$key]['active'] = false;
                    if ($_POST['rp_ext_col_target_table-' . $key] > 0) {
                        $this->external_columns[$key]['active'] = true;
                    }
                    $this->external_columns[$key]['target_fields'] = array();
                    $this->external_columns[$key]['fields_labels'] = array();
                    $fields = 'rp_ext_col_target_fields-' . $key;
                    if (isset($_POST[$fields])) {
                        foreach ($_POST[$fields] as $fieldname) {
                            $this->external_columns[$key]['target_fields'][] = $fieldname;
                            $this->external_columns[$key]['fields_labels'][] = $this->getLabel($this->external_columns[$key]['target_table'], $fieldname);
                        }
                    }
                    $this->external_columns[$key]['allow_crud_in_list'] = false;
                    if (isset($_POST['rp_ext_col_allow_crud_in_list-' . $key]) && $_POST['rp_ext_col_allow_crud_in_list-' . $key] > 0) {
                        $this->external_columns[$key]['allow_crud_in_list'] = true;
                    }
                    $this->external_columns[$key]['table_label'] = $this->getLabel($this->external_columns[$key]['target_table']);
                }
            }

            $json_data = array(
                'list_options'           => $this->list_options,
                'columns'                => $this->columns,
                'external_columns'       => $this->external_columns,
                'field_delete_confirm_1' => $this->field_delete_confirm_1,
                'field_delete_confirm_2' => $this->field_delete_confirm_2
            );

            // register table & columns properties in json file
            $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
            $this->registerJson($this->table . '.json', $json);
            $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From build_paginated_list POST');
        } elseif ($this->action == 'build_single_element_list') {
            // edit columns properties from POST
            for ($i=0; $i < $this->columns_count; $i++) {
                $column_name                           = $this->columns['name'][$i];
                $column_label                          = $_POST['rs_label_' . $column_name];
                $value_type                            = 'rs_value_type_' . $column_name;
                $jedit                                 = 'rs_jedit_' . $column_name;
                $this->columns['fields'][$column_name] = $column_label;
                $this->columns['special'][$i]          = ''; // img path | date display format | time display format || password constraints
                $this->columns['special2'][$i]         = ''; // img url | time display format if datetime or timestamp
                $this->columns['special3'][$i]         = ''; // img thumbnails
                $this->columns['special4'][$i]         = ''; // img editor
                $this->columns['special5'][$i]         = ''; // img width
                $this->columns['special6'][$i]         = ''; // img height
                $this->columns['special7'][$i]         = ''; // img crop
                $others                                = 'rs_others_' . $column_name;
                $this->columns['value_type'][$i]       = $_POST[$value_type];
                if (isset($_POST[$jedit])) {
                    $this->columns['jedit'][$i] = $_POST[$jedit];
                } else {
                    // if jedit field has been disabled
                    $this->columns['jedit'][$i] = '';
                }

                // update field_type according to value_type
                // (value_type = read paginated display value)
                // (field_type = create update field)
                if ($this->columns['value_type'][$i] == 'set') {
                    $this->columns['field_type'][$i] = 'select';
                } else {
                    $this->columns['field_type'][$i] = $this->columns['value_type'][$i];
                }

                // relation fields  - target values to display
                if (isset($_POST['rs_target_column_0_' . $column_name])) {
                    $this->columns['relation'][$i]['target_fields'] = $_POST['rs_target_column_0_' . $column_name];
                    if (!empty($_POST['rs_target_column_1_' . $column_name])) {
                        $this->columns['relation'][$i]['target_fields'] .= ', ' . $_POST['rs_target_column_1_' . $column_name];
                    }

                    // register chosen columns in select values
                    $this->columns['select_from_field_1'][$i] = $_POST['rs_target_column_0_' . $column_name];
                    $this->columns['select_from_field_2'][$i] = $_POST['rs_target_column_1_' . $column_name];
                }

                // special (image path | date display format | password constraint)
                if ($this->columns['value_type'][$i] == 'file') {
                    $this->columns['special'][$i]  = $_POST['rs_special_file_dir_' . $column_name];
                    $this->columns['special2'][$i] = $_POST['rs_special_file_url_' . $column_name];
                    $this->columns['special3'][$i] = $_POST['rs_special_file_types_' . $column_name];
                } elseif ($this->columns['value_type'][$i] == 'image') {
                    $this->columns['special'][$i]  = $_POST['rs_special_image_dir_' . $column_name];
                    $this->columns['special2'][$i] = $_POST['rs_special_image_url_' . $column_name];
                    $this->columns['special3'][$i] = $_POST['rs_special_image_thumbnails_' . $column_name];
                } elseif ($this->columns['value_type'][$i] == 'date' || $this->columns['value_type'][$i] == 'month') {
                    if (!empty($_POST['rs_special_date_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rs_special_date_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'dd mmmm yyyy';
                    }
                } elseif ($this->columns['value_type'][$i] == 'datetime') {
                    if (!empty($_POST['rs_special_date_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rs_special_date_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'dd mmmm yyyy';
                    }
                    if (!empty($_POST['rs_special_time_' . $column_name])) {
                        $this->columns['special2'][$i] = $_POST['rs_special_time_' . $column_name];
                    } else {
                        $this->columns['special2'][$i] = 'H:i a';
                    }
                } elseif ($this->columns['value_type'][$i] == 'time') {
                    if (!empty($_POST['rs_special_time_' . $column_name])) {
                        $this->columns['special'][$i] = $_POST['rs_special_time_' . $column_name];
                    } else {
                        $this->columns['special'][$i] = 'H:i a';
                    }
                } elseif ($this->columns['value_type'][$i] == 'password') {
                    $this->columns['special'][$i] = $_POST['rs_special_password_' . $column_name];
                }

                $this->columns['sorting'][$i] = false;
                $this->columns['nested'][$i]  = false;
                $this->columns['skip'][$i]    = false;
                if (isset($_POST[$others])) {
                    if (in_array('skip', $_POST[$others])) {
                        $this->columns['skip'][$i] = true;
                    }
                }
            }

            $this->table_label = $_POST['rs_table_label'];

            // store main list values
            $this->list_options = array(
                'list_type'            => $_POST['list_type'],
                'open_url_btn'         => $_POST['rs_open_url_btn'],
                'export_btn'           => $_POST['rs_export_btn'],
                'bulk_delete'          => '',
                'default_search_field' => '',
                'order_by'             => '',
                'order_direction'      => '',
                'filters'              => array()
            );

            // external relations
            if (count($this->external_columns) > 0) {
                foreach ($this->external_columns as $key => $ext_col) {
                    $this->external_columns[$key]['active'] = false;
                    if ($_POST['rs_ext_col_target_table-' . $key] > 0) {
                        $this->external_columns[$key]['active'] = true;
                    }
                    $this->external_columns[$key]['target_fields'] = array();
                    $this->external_columns[$key]['fields_labels'] = array();
                    $fields = 'rs_ext_col_target_fields-' . $key;
                    if (isset($_POST[$fields])) {
                        foreach ($_POST[$fields] as $fieldname) {
                            $this->external_columns[$key]['target_fields'][] = $fieldname;
                            $this->external_columns[$key]['fields_labels'][] = $this->getLabel($this->external_columns[$key]['target_table'], $fieldname);
                        }
                    }
                    if (isset($_POST['rs_ext_col_allow_crud_in_list-' . $key])) {
                        $this->external_columns[$key]['allow_crud_in_list'][] = $_POST['rs_ext_col_allow_crud_in_list-' . $key];
                    }
                    $this->external_columns[$key]['table_label'] = $this->getLabel($this->external_columns[$key]['target_table']);
                }
            }

            $json_data = array(
                'list_options'           => $this->list_options,
                'columns'                => $this->columns,
                'external_columns'       => $this->external_columns,
                'field_delete_confirm_1' => $this->field_delete_confirm_1,
                'field_delete_confirm_2' => $this->field_delete_confirm_2
            );

            // register table & columns properties in json file
            $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
            $this->registerJson($this->table . '.json', $json);
            $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From build_single_element_list POST');
        } elseif ($this->action == 'build_create_edit') {
            // update columns properties from POST
            for ($i=0; $i < $this->columns_count; $i++) {
                $column_name = $this->columns['name'][$i];
                $field_type   = $_POST['cu_field_type_' . $column_name];
                $special      = '';
                $special2     = '';
                $special3     = '';
                $special4     = '';
                $special5     = '';
                $special6     = '';
                $special7     = '';

                // special (image path | date display format | password constraint)
                if ($field_type == 'file') {
                    $special  = $_POST['cu_special_file_dir_' . $column_name];
                    $special2 = $_POST['cu_special_file_url_' . $column_name];
                    $special3 = $_POST['cu_special_file_types_' . $column_name];
                } elseif ($field_type == 'image') {
                    $special  = $_POST['cu_special_image_dir_' . $column_name];
                    $special2 = $_POST['cu_special_image_url_' . $column_name];
                    $special3 = $_POST['cu_special_image_thumbnails_' . $column_name];
                    $special4 = $_POST['cu_special_image_editor_' . $column_name];
                    $special5 = $_POST['cu_special_image_width_' . $column_name];
                    $special6 = $_POST['cu_special_image_height_' . $column_name];
                    $special7 = $_POST['cu_special_image_crop_' . $column_name];
                } elseif ($field_type == 'date' || $field_type == 'month') {
                    if (!empty($_POST['cu_special_date_' . $column_name])) {
                        $special = $_POST['cu_special_date_' . $column_name];
                    } else {
                        $special = 'dd mmmm yyyy';
                    }
                    $special3 = $_POST['cu_special_date_now_hidden_' . $column_name];
                } elseif ($field_type == 'datetime') {
                    if (!empty($_POST['cu_special_date_' . $column_name])) {
                        $special = $_POST['cu_special_date_' . $column_name];
                    } else {
                        $special = 'dd mmmm yyyy';
                    }
                    $special3 = $_POST['cu_special_date_now_hidden_' . $column_name];
                    if (!empty($_POST['cu_special_time_' . $column_name])) {
                        $special2 = $_POST['cu_special_time_' . $column_name];
                    } else {
                        $special2 = 'H:i a';
                    }
                } elseif ($field_type == 'time') {
                    if (!empty($_POST['cu_special_time_' . $column_name])) {
                        $special = $_POST['cu_special_time_' . $column_name];
                    } else {
                        $special = 'H:i a';
                    }
                    $special3 = $_POST['cu_special_date_now_hidden_' . $column_name];
                } elseif ($field_type == 'password') {
                    $special = $_POST['cu_special_password_' . $column_name];
                }

                /* select values are already registered with ajax */

                $help_text      = '';
                $tooltip        = '';
                $char_count     = false;
                $tinyMce        = false;
                $char_count_max = '';
                $field_width    = '100%';
                if (isset($_POST['cu_help_text_' . $column_name])) {
                    $help_text = $_POST['cu_help_text_' . $column_name];
                }
                if (isset($_POST['cu_tooltip_' . $column_name])) {
                    $tooltip = $_POST['cu_tooltip_' . $column_name];
                }
                if (isset($_POST['cu_field_width_' . $column_name])) {
                    $field_width = $_POST['cu_field_width_' . $column_name];
                }

                if (isset($_POST['cu_options_' . $column_name])) {
                    if (in_array('char_count_' . $column_name, $_POST['cu_options_' . $column_name])) {
                        $char_count = true;
                        $char_count_max = $_POST['char_count_max_' . $column_name];
                    }
                    if (in_array('tinyMce_' . $column_name, $_POST['cu_options_' . $column_name])) {
                        $tinyMce = true;
                    }
                }

                // validation
                $validation  = array();
                $v_functions = array();
                $v_arguments = array();
                $validation_type = $_POST['cu_validation_type_' . $column_name];
                if ($validation_type == 'auto' || $validation_type == 'custom') {
                    if ($validation_type == 'auto') {
                        $function_field_name  = 'cu_auto_validation_function_';
                        $arguments_field_name = 'cu_auto_validation_arguments_';
                    } elseif ($validation_type == 'custom') {
                        $function_field_name  = 'cu_validation_function_';
                        $arguments_field_name = 'cu_validation_arguments_';
                    }
                    foreach ($_POST as $name => $value) {
                        if (preg_match('`' . $function_field_name . $column_name . '-`', $name)) {
                            $v_functions[] = $value;
                        } elseif (preg_match('`' . $arguments_field_name . $column_name . '-`', $name)) {
                            $v_arguments[] = $value;
                        }
                    }
                    for ($j=0; $j < count($v_functions); $j++) {
                        $validation[] = array(
                            'function' => $v_functions[$j],
                            'args' => $v_arguments[$j]
                        );
                    }
                }
                $required       = false;
                if (in_array('required', $v_functions)) {
                    $required = true;
                }
                $this->columns['validation_type'][$i] = $validation_type;
                $this->columns['field_type'][$i]      = $field_type;
                $this->columns['special'][$i]         = $special;
                $this->columns['special2'][$i]        = $special2;
                $this->columns['special3'][$i]        = $special3;
                $this->columns['special4'][$i]        = $special4;
                $this->columns['special5'][$i]        = $special5;
                $this->columns['special6'][$i]        = $special6;
                $this->columns['special7'][$i]        = $special7;
                $this->columns['help_text'][$i]       = $help_text;
                $this->columns['tooltip'][$i]         = $tooltip;
                $this->columns['required'][$i]        = $required;
                $this->columns['char_count'][$i]      = $char_count;
                $this->columns['tinyMce'][$i]         = $tinyMce;
                $this->columns['char_count_max'][$i]  = $char_count_max;
                $this->columns['field_width'][$i]     = $field_width;
                $this->columns['validation'][$i]      = $validation;

                // Generate warning message if any select|radio|checkbox without values
                if ($field_type == 'select' | $field_type == 'radio' | $field_type == 'checkbox') {
                    $select_from          = $this->columns['select_from'][$i];
                    $select_from_table    = $this->columns['select_from_table'][$i];
                    $select_from_value    = $this->columns['select_from_value'][$i];
                    $select_from_field_1  = $this->columns['select_from_field_1'][$i];
                    $select_from_field_2  = $this->columns['select_from_field_2'][$i];
                    $select_custom_values = $this->columns['select_custom_values'][$i];
                    if (($select_from== 'from_table' && (empty($select_from_table) || empty($select_from_value))) || ($select_from == 'custom_values' && empty($select_custom_values)) || empty($select_from)) {
                        $this->userMessage(NO_VALUE_SELECTED . ' <em>' . $this->columns['name'][$i] . '</em>', 'alert-warning has-icon');
                    }
                }
            }
            $group_started = false;
            $group_width   = 0;
            $group_length  = 0;
            for ($i=0; $i < $this->columns_count; $i++) {
                // Generate warning message if single grouped field
                if ($this->columns['field_type'][$i] != 'hidden') {
                    if (preg_match('`grouped`', $this->columns['field_width'][$i])) {
                        $field_width = preg_replace('`% [a-z]+`', '', $this->columns['field_width'][$i]); // 33|50|66
                        // start new group
                        if ($group_started === false) {
                            $group_started = true;
                            $group_width   = $field_width;
                            $group_length  = 1;
                        } else {
                            if ($group_width + $field_width <= 100) {
                                // continue group
                                $group_width += $field_width;
                                $group_length += 1;
                            } else {
                                if ($group_length == 1) {
                                    $find = array('%field1%', '%field2%');
                                    $replace = array($this->columns['name'][$i - 1], $this->columns['name'][$i]);
                                    $group_warning = str_replace($find, $replace, GROUP_WIDTH_WARNING);
                                    $this->userMessage($group_warning, 'alert-warning has-icon');
                                }
                                // end group & start new one
                                $group_width   = $field_width;
                                $group_length  = 1;
                            }
                        }
                    } else {
                        if ($group_started === true && $group_length == 1) {
                            $group_warning = str_replace('%field%', ' <em>' . $this->columns['name'][$i] . '</em>', GROUP_WARNING);
                            $this->userMessage($group_warning, 'alert-warning has-icon');
                        }

                        // end group
                        $group_started = false;
                        $group_width   = 0;
                        $group_length  = 0;
                    }
                }
            }

            // external relations
            if (count($this->external_columns) > 0) {
                foreach ($this->external_columns as $key => $ext_col) {
                    if ($ext_col['active'] === true && !empty($ext_col['relation']['intermediate_table'])) {
                        $this->external_columns[$key]['allow_in_forms'] = false;
                        if ($_POST['cu_ext_col_allow_in_forms-' . $key] > 0) {
                            $this->external_columns[$key]['allow_in_forms'] = true;
                            $this->external_columns[$key]['forms_fields']   = $_POST['cu_ext_col_forms_fields-' . $key];
                            $this->external_columns[$key]['field_type']     = $_POST['cu_ext_col_field_type-' . $key];
                        }
                    }
                }
            }

            $json_data = array(
                'list_options'           => $this->list_options,
                'columns'                => $this->columns,
                'external_columns'       => $this->external_columns,
                'field_delete_confirm_1' => $this->field_delete_confirm_1,
                'field_delete_confirm_2' => $this->field_delete_confirm_2
            );

            $json_data = array(
                'list_options'           => $this->list_options,
                'columns'                => $this->columns,
                'external_columns'       => $this->external_columns,
                'field_delete_confirm_1' => $this->field_delete_confirm_1,
                'field_delete_confirm_2' => $this->field_delete_confirm_2
            );

            // register table & columns properties in json file
            $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
            $this->registerJson($this->table . '.json', $json);
            $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From build_create_edit POST');
        } elseif ($this->action == 'build_delete') {
            $this->field_delete_confirm_1 = $_POST['field_delete_confirm_1'];
            $this->field_delete_confirm_2 = $_POST['field_delete_confirm_2'];
            $json_data = array(
                'list_options'           => $this->list_options,
                'columns'                => $this->columns,
                'external_columns'       => $this->external_columns,
                'field_delete_confirm_1' => $this->field_delete_confirm_1,
                'field_delete_confirm_2' => $this->field_delete_confirm_2
            );

            // register table & columns properties in json file
            $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
            $this->registerJson($this->table . '.json', $json);
            $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => From build_delete POST');
        } else {
            $this->logMessage('<span class="font-weight-bold">registerColumnsProperties</strong> => Already registered');
        }
    }

    public function registerSelectValues($column, $select_from, $select_from_table, $select_from_value, $select_from_field_1, $select_from_field_2, $select_custom_values, $select_multiple)
    {
        if (!file_exists(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->table . '.json')) {
            exit('json file not found');
        }
        $json          = file_get_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->table . '.json');
        $json_data     = json_decode($json, true);

        $index = array_search($column, $json_data['columns']['name']);

        $this->columns['select_from'][$index]          = $select_from;
        $this->columns['select_from_table'][$index]    = $select_from_table;
        $this->columns['select_from_value'][$index]    = $select_from_value;
        $this->columns['select_from_field_1'][$index]  = $select_from_field_1;
        $this->columns['select_from_field_2'][$index]  = $select_from_field_2;
        $this->columns['select_custom_values'][$index] = $select_custom_values;
        $this->columns['select_multiple'][$index]      = $select_multiple;

        $json_data = array(
            'list_options'           => $this->list_options,
            'columns'                => $this->columns,
            'external_columns'       => $this->external_columns,
            'field_delete_confirm_1' => $this->field_delete_confirm_1,
            'field_delete_confirm_2' => $this->field_delete_confirm_2
        );

        // register table & columns properties in json file
        $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        $this->registerJson($this->table . '.json', $json);
    }

    public function getSelectValues($column)
    {
        $index = array_search($column, $this->columns['name']);
        if (empty($this->columns['select_from'][$index])) {
            return NONE;
        } else {
            if ($this->columns['select_from'][$index] == 'from_table') {
                $values = $this->columns['select_from_table'][$index] . '.' . $this->columns['select_from_field_1'][$index];
                if (!empty($this->columns['select_from_field_2'][$index])) {
                    $values .= '<br>' . $this->columns['select_from_table'][$index] . '.' . $this->columns['select_from_field_2'][$index];
                }

                return $values;
            } else {
                return CUSTOM_VALUES;
            }
        }
    }

    /**
     * remove table from admin sidenav
     * @return Boolean
     */
    private function unregisterNavTable($table)
    {
        $dir_path  = array();
        $file_name = array();


        // nav data (admin/crud-data/nav-data.json)
        $json_data = array();
        if (file_exists(ADMIN_DIR . 'crud-data/nav-data.json')) {
            $json               = file_get_contents(ADMIN_DIR . 'crud-data/nav-data.json');
            $json_data          = json_decode($json, true);

            if (empty($json_data)) {
                $this->logMessage('<span class="font-weight-bold">--- unregisterNavTable: </strong> nav data is empty');

                return false;
            }

            // try to find the table in nav categories
            $current_cat = '';
            foreach ($json_data as $navcat => $data) {
                // "navcat-0": { "name": "Inventory", "tables": ["customer"], "is_disabled": [false] }
                $tables      = $data['tables'];
                $is_disabled = $data['is_disabled'];
                if (is_array($tables) && in_array($table, $tables)) {
                    $key = array_search($table, $tables);
                    unset($tables[$key]);
                    unset($is_disabled[$key]);
                    $json_data[$navcat]['tables']      = array_values($tables);
                    $json_data[$navcat]['is_disabled'] = array_values($is_disabled);
                    $dir              = ADMIN_DIR . 'crud-data/';
                    $file             = 'nav-data.json';
                    $dir_path[]       = $dir;
                    $file_name[]      = $file;
                    $this->registerAdminFile($dir, $file, json_encode($json_data, JSON_UNESCAPED_UNICODE));

                    $this->logMessage('<span class="font-weight-bold">--- unregisterNavTable: </strong> ' . $table);

                    return true;
                }
            }

            // if the table hasn't been found in previous loop
            $this->logMessage('<span class="font-weight-bold">--- unregisterNavTable: </strong> ' . $table . ' table not found in nav data');

            return false;
        }
    }

    private function registerNavData()
    {
        $dir_path  = array();
        $file_name = array();

        // nav data (admin/crud-data/nav-data.json)
        $json_data = array();
        if (file_exists(ADMIN_DIR . 'crud-data/nav-data.json')) {
            $json               = file_get_contents(ADMIN_DIR . 'crud-data/nav-data.json');
            $json_data          = json_decode($json, true);
        }

        if (empty($json_data)) {
            $json_data = array(
                'navcat-0' => array(
                    'name'        => EDITABLE_CONTENT,
                    'tables'      => array(),
                    'is_disabled' => array()
                )
            );
        }

        // try to find the current table in nav categories
        $current_cat = '';
        foreach ($json_data as $navcat => $data) {
            $tables = $data['tables'];
            if (is_array($tables) && in_array($this->table, $tables)) {
                $key = array_search($this->table, $tables);
                $current_cat = $tables[$key];
            }
            $last_cat = $navcat;
        }

        // if the current table is not already in nav categories, we add it to the last one.
        if (empty($current_cat)) {
            $json_data[$last_cat]['tables'][]      = $this->table;
            $json_data[$last_cat]['is_disabled'][] = false;
            $dir              = ADMIN_DIR . 'crud-data/';
            $file             = 'nav-data.json';
            $dir_path[]       = $dir;
            $file_name[]      = $file;
            $this->registerAdminFile($dir, $file, json_encode($json_data, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * build files depending on current action
     * @return [type] [description]
     */
    public function runBuild()
    {
        if (DEMO !== true) {
            if ($this->action == 'build_create_edit') {
                $this->buildCreateUpdate();
            } elseif ($this->action == 'build_paginated_list') {
                $this->buildPaginatedList();
            } elseif ($this->action == 'build_single_element_list') {
                $this->buildSingleElementList();
            } elseif ($this->action == 'build_delete') {
                $this->buildDelete();
            }
        } elseif ($this->action == 'build_create_edit' || $this->action == 'build_paginated_list' || $this->action == 'build_single_element_list' || $this->action == 'build_delete') {
            $this->userMessage('Feature disabled in DEMO', 'alert-danger has-icon');
        }
    }

    private function buildCreateUpdate()
    {
        $dir_path  = array();
        $file_name = array();

        $item = $this->item;

        // form create (/admin/inc/forms/[lowertable]-create.php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/form-create-template.php';
        $output_form_create = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'inc/forms/';
        $file = $item . '-create.php';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_form_create);

        // form edit (/admin/inc/forms/[lowertable]-edit.php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/form-edit-template.php';
        $output_form_edit = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'inc/forms/';
        $file = $item . '-edit.php';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_form_edit);

        // select-data (admin/crud-data/[table]-select-data.json)
        $select_data = array();
        for ($i=0; $i < $this->columns_count; $i++) {
            $name               = $this->columns['name'][$i];
            $this->getSelectValues($name);
            $select_data[$name] = array(
                'from'          => $this->columns['select_from'][$i],
                'from_table'    => $this->columns['select_from_table'][$i],
                'from_value'    => $this->columns['select_from_value'][$i],
                'from_field_1'  => $this->columns['select_from_field_1'][$i],
                'from_field_2'  => $this->columns['select_from_field_2'][$i],
                'custom_values' => $this->columns['select_custom_values'][$i],
                'multiple'      => $this->columns['select_multiple'][$i]
            );
        }

        $json = json_encode($select_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = $item . '-select-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);

        // edit admin/inc/forms/[userstable]profiles[-create|-edit].php
        // for specific customization
        include_once ADMIN_DIR . 'secure/conf/conf.php';
        if ($this->table == USERS_TABLE . '_profiles') {
            include_once ADMIN_DIR . 'secure/install/users-profiles-form-edit-customization.php';
        }

        // delete form css & js combined files to regenerate them if plugins have changed
        if (file_exists(CLASS_DIR . 'phpformbuilder/plugins/min/css/bs4-form-create-' . $item . '.min.css')) {
            unlink(CLASS_DIR . 'phpformbuilder/plugins/min/css/bs4-form-create-' . $item . '.min.css');
        }

        if (file_exists(CLASS_DIR . 'phpformbuilder/plugins/min/js/bs4-form-create-' . $item . '.min.js')) {
            unlink(CLASS_DIR . 'phpformbuilder/plugins/min/js/bs4-form-create-' . $item . '.min.js');
        }

        $list_url = ADMIN_URL . $item;
        $title = '<span class="badge bg-success-600 mr-4 no-margin-bottom">' . $this->table . '</span> ' . FORMS_GENERATED . '<a href="' . $list_url . '" class="bg-success-600 px-2 py-1 ml-4" target="_blank">' . OPEN_ADMIN_PAGE . '<i class="fas fa-external-link-alt position-right"></i></a>';
        $msg_body = '<p class="text-semibold">' . CREATED_UPDATED_FILES . ' : </p>' . "\n";
        $msg_body .= '<ul class="list-square">';
        for ($i=0; $i < count($dir_path); $i++) {
            $msg_body .= '<li>' . $dir_path[$i] . $file_name[$i] . '</li>';
        }
        $msg_body .= '</ul>';

        $this->userMessage($title, 'bg-success card-collapsed has-icon', 'collapse, close', $msg_body);
    }

    private function buildPaginatedList()
    {
        $this->registerNavData();

        // main class (/admin/class/crud/[Table].php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/item-class-template.php';
        $output_item_class = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'class/crud/';
        $upperCamelCaseTable = ElementsUtilities::upperCamelCase($this->table);
        $item = $this->item;
        $file = $upperCamelCaseTable . '.php';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_item_class);

        // list template (/admin/templates/[lowertable].html)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/item-list-template.php';
        $output_item_template = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'templates/';
        $file = $item . '.html';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_item_template);

        // form bulk delete (/admin/inc/forms/[lowertable]-bulk-delete.php)
        if ($_POST['rp_bulk_delete'] > 0) {
            $bulk_delete_output = $this->buildBulkDelete();
            $dir_path = array_merge($dir_path, $bulk_delete_output['dir']);
            $file_name = array_merge($file_name, $bulk_delete_output['file']);
        }

        // db-data (admin/crud-data/db-data.json)
        if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
            $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
            $db_data = json_decode($json, true);
        } else {
            $db_data = array();
        }

        // create / edit table data (even if exists)
        $table                  = $this->table;
        $table_label            = $this->table_label;
        $class_name             = $upperCamelCaseTable;
        $primary_key            = $this->primary_key;
        $field_delete_confirm_1 = $this->field_delete_confirm_1;
        $field_delete_confirm_2 = $this->field_delete_confirm_2;
        $table_icon             = $this->table_icon;
        $fields                 = $this->columns['fields'];

        $db_data[$table] = array(
            'item'                   => $item,
            'table_label'            => $table_label,
            'class_name'             => $class_name,
            'primary_key'            => $primary_key,
            'field_delete_confirm_1' => $field_delete_confirm_1,
            'field_delete_confirm_2' => $field_delete_confirm_2,
            'icon'                   => $table_icon,
            'fields'                 => $fields
        );
        $json = json_encode($db_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = 'db-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);

        // filter-data (admin/data/[table]-filter-data.json)
        $filter_data = $this->list_options['filters'];
        $json = json_encode($filter_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = $item . '-filter-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);

        // select-data (admin/crud-data/[table]-select-data.json)
        $select_data = array();
        for ($i=0; $i < $this->columns_count; $i++) {
            $name               = $this->columns['name'][$i];
            $select_data[$name] = array(
                'from'          => $this->columns['select_from'][$i],
                'from_table'    => $this->columns['select_from_table'][$i],
                'from_value'    => $this->columns['select_from_value'][$i],
                'from_field_1'  => $this->columns['select_from_field_1'][$i],
                'from_field_2'  => $this->columns['select_from_field_2'][$i],
                'custom_values' => $this->columns['select_custom_values'][$i],
                'multiple'      => $this->columns['select_multiple'][$i]
            );
        }

        $json = json_encode($select_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = $item . '-select-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);
        $list_url = ADMIN_URL . $item;
        $title = '<span class="badge bg-success-600 mr-4 no-margin-bottom">' . $this->table . '</span> ' . LIST_GENERATED . '<a href="' . $list_url . '" class="bg-success-600 px-2 py-1 ml-4" target="_blank">' . OPEN_ADMIN_PAGE . '<i class="fas fa-external-link-alt position-right"></i></a>';
        $msg_body = '<p class="text-semibold">' . CREATED_UPDATED_FILES . ' : </p>' . "\n";
        $msg_body .= '<ul class="list-square">';
        for ($i=0; $i < count($dir_path); $i++) {
            $msg_body .= '<li>' . $dir_path[$i] . $file_name[$i] . '</li>';
        }
        $msg_body .= '</ul>';

        $this->userMessage($title, 'bg-success card-collapsed has-icon', 'collapse, close', $msg_body);
        $this->logMessage('<span class="font-weight-bold">buildPaginatedList</strong>');

        // Create form with all backup files in a dropdown select
        $this->createDiffFileList();
    }

    private function buildSingleElementList()
    {
        $this->registerNavData();

        // main class (/admin/class/crud/[Table].php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/item-class-single-element-template.php';
        $output_item_class = ob_get_contents();
        ob_end_clean();
        $dir                 = ADMIN_DIR . 'class/crud/';
        $upperCamelCaseTable = ElementsUtilities::upperCamelCase($this->table);
        $item                = $this->item;
        $file                = $upperCamelCaseTable . '.php';
        $dir_path[]          = $dir;
        $file_name[]         = $file;
        $this->registerAdminFile($dir, $file, $output_item_class);

        // list template (/admin/templates/[lowertable].html)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/item-list-single-element-template.php';
        $output_item_template = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'templates/';
        $file = $item . '.html';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_item_template);

        // db-data (admin/crud-data/db-data.json)
        if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
            $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
            $db_data = json_decode($json, true);
        } else {
            $db_data = array();
        }

        // create / edit table data (even if exists)
        $table                  = $this->table;
        $table_label            = $this->table_label;
        $class_name             = $upperCamelCaseTable;
        $primary_key            = $this->primary_key;
        $field_delete_confirm_1 = $this->field_delete_confirm_1;
        $field_delete_confirm_2 = $this->field_delete_confirm_2;
        $table_icon             = $this->table_icon;
        $fields                 = $this->columns['fields'];

        $db_data[$table] = array(
            'item'                   => $item,
            'table_label'            => $table_label,
            'class_name'             => $class_name,
            'primary_key'            => $primary_key,
            'field_delete_confirm_1' => $field_delete_confirm_1,
            'field_delete_confirm_2' => $field_delete_confirm_2,
            'icon'                   => $table_icon,
            'fields'                 => $fields
        );
        $json = json_encode($db_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = 'db-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);

        // filter-data (admin/data/[table]-filter-data.json)
        $filter_data = $this->list_options['filters'];
        $json = json_encode($filter_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = $item . '-filter-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);

        // select-data (admin/crud-data/[table]-select-data.json)
        $select_data = array();
        for ($i=0; $i < $this->columns_count; $i++) {
            $name               = $this->columns['name'][$i];
            $select_data[$name] = array(
                'from'          => $this->columns['select_from'][$i],
                'from_table'    => $this->columns['select_from_table'][$i],
                'from_value'    => $this->columns['select_from_value'][$i],
                'from_field_1'  => $this->columns['select_from_field_1'][$i],
                'from_field_2'  => $this->columns['select_from_field_2'][$i],
                'custom_values' => $this->columns['select_custom_values'][$i],
                'multiple'      => $this->columns['select_multiple'][$i]
            );
        }

        $json = json_encode($select_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        $file = $item . '-select-data.json';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $json);
        $list_url = ADMIN_URL . $item;
        $title = '<span class="badge bg-success-600 mr-4 no-margin-bottom">' . $this->table . '</span> ' . LIST_GENERATED . '<a href="' . $list_url . '" class="bg-success-600 px-2 py-1 ml-4" target="_blank">' . OPEN_ADMIN_PAGE . '<i class="fas fa-external-link-alt position-right"></i></a>';
        $msg_body = '<p class="text-semibold">' . CREATED_UPDATED_FILES . ' : </p>' . "\n";
        $msg_body .= '<ul class="list-square">';
        for ($i=0; $i < count($dir_path); $i++) {
            $msg_body .= '<li>' . $dir_path[$i] . $file_name[$i] . '</li>';
        }
        $msg_body .= '</ul>';

        $this->userMessage($title, 'bg-success card-collapsed has-icon', 'collapse, close', $msg_body);
        $this->logMessage('<span class="font-weight-bold">buildSingleElementList</strong>');

        // Create form with all backup files in a dropdown select
        $this->createDiffFileList();
    }

    private function buildDelete()
    {
        $dir_path  = array();
        $file_name = array();

        $item = $this->item;

        // register cascade_delete relations
        $this->getRelations();
        if (isset($_POST['from_to_indexes'])) {
            foreach ($_POST['from_to_indexes'] as $index) {
                $cascade_delete_origin_field = 'constrained_tables_' . $this->relations['from_to'][$index]['origin_table'];
                $this->relations['from_to'][$index]['cascade_delete_from_origin'] = $_POST[$cascade_delete_origin_field];
                if (!empty($this->relations['from_to'][$index]['intermediate_table'])) {
                    $cascade_delete_intermediate_field = 'constrained_tables_' . $this->relations['from_to'][$index]['intermediate_table'];
                    $this->relations['from_to'][$index]['cascade_delete_from_intermediate'] = $_POST[$cascade_delete_intermediate_field];
                }
            }
        }

        // form delete (/admin/inc/forms/[lowertable]-delete.php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/form-delete-template.php';
        $output_form_delete = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'inc/forms/';
        $file = $item . '-delete.php';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_form_delete);

        // register table & columns properties in json file
        $json_data = json_encode($this->relations, JSON_UNESCAPED_UNICODE);
        $this->registerJson($this->database . '-relations.json', $json_data);

        $list_url = ADMIN_URL . $item;
        $title = '<span class="badge bg-success-600 mr-4 no-margin-bottom">' . $this->table . '</span> ' . FORMS_GENERATED . '<a href="' . $list_url . '" class="bg-success-600 px-2 py-1 ml-4" target="_blank">' . OPEN_ADMIN_PAGE . '<i class="fas fa-external-link-alt position-right"></i></a>';
        $msg_body = '<p class="text-semibold">' . CREATED_UPDATED_FILES . ' : </p>' . "\n";
        $msg_body .= '<ul class="list-square">';
        for ($i=0; $i < count($dir_path); $i++) {
            $msg_body .= '<li>' . $dir_path[$i] . $file_name[$i] . '</li>';
        }
        $msg_body .= '</ul>';

        $this->userMessage($title, 'bg-success card-collapsed has-icon', 'collapse, close', $msg_body);
        $this->logMessage('<span class="font-weight-bold">buildDelete</strong>');

        // Create form with all backup files in a dropdown select
        $this->createDiffFileList();
    }

    private function buildBulkDelete()
    {
        $dir_path  = array();
        $file_name = array();

        $item = $this->item;

        // register cascade_delete relations
        // there's no difference between bulk_constrained_tables_ and constrained_tables_
        // as the radio buttons change simultaneously in the READ form & the DELETE form
        $this->getRelations();
        if (isset($_POST['bulk_from_to_indexes'])) {
            foreach ($_POST['bulk_from_to_indexes'] as $index) {
                $cascade_delete_origin_field = 'bulk_constrained_tables_' . $this->relations['from_to'][$index]['origin_table'];
                $this->relations['from_to'][$index]['cascade_delete_from_origin'] = $_POST[$cascade_delete_origin_field];
                if (!empty($this->relations['from_to'][$index]['intermediate_table'])) {
                    $cascade_delete_intermediate_field = 'bulk_constrained_tables_' . $this->relations['from_to'][$index]['intermediate_table'];
                    $this->relations['from_to'][$index]['cascade_delete_from_intermediate'] = $_POST[$cascade_delete_intermediate_field];
                }
            }
        }

        // form delete (/admin/inc/forms/[lowertable]-bulk-delete.php)
        ob_start();
        include GENERATOR_DIR . 'generator-templates/bulk-delete-template.php';
        $output_form_delete = ob_get_contents();
        ob_end_clean();
        $dir = ADMIN_DIR . 'inc/forms/';
        $file = $item . '-bulk-delete.php';
        $dir_path[]  = $dir;
        $file_name[] = $file;
        $this->registerAdminFile($dir, $file, $output_form_delete);

        // register table & columns properties in json file
        $json_data = json_encode($this->relations, JSON_UNESCAPED_UNICODE);
        $this->registerJson($this->database . '-relations.json', $json_data);

        $this->logMessage('<span class="font-weight-bold">buildBulkDelete</strong>');

        // Create form with all backup files in a dropdown select
        $this->createDiffFileList();

        // return dir & created files
        return array(
            'dir'  => $dir_path,
            'file' => $file_name
        );
    }

    /**
     * Create form with all backup files in a dropdown select
     */
    private function createDiffFileList()
    {
        $files_to_diff   = $this->scanDirectories(BACKUP_DIR);
        if (count($files_to_diff) > 0) {
            $this->diff_files_form = new Form('diff-files', 'inline', 'target=_blank', 'bs4');
            $this->diff_files_form->useLoadJs('core');
            $this->diff_files_form->setMode('development');
            $options = array(
                    'elementsWrapper'     => '<div class="input-group"></div>',
            );
            $this->diff_files_form->setOptions($options);
            $this->diff_files_form->groupInputs('file-to-diff', 'submit');
            $this->diff_files_form->setAction(GENERATOR_URL . 'diff-files.php');
            foreach ($files_to_diff as $key => $value) {
                $optgroup = 'Root';
                $value = str_replace(BACKUP_DIR, '', $value);
                $file_name = basename($value);
                $file_dir = ltrim(str_replace($file_name, '', $value), '/');
                if (!empty($file_dir) && $file_dir !== $optgroup) {
                    $optgroup = $file_dir;
                }
                $this->diff_files_form->addOption('file-to-diff', ltrim($value, '/'), $file_name, $optgroup);
            }
            $this->diff_files_form->addSelect('file-to-diff', DIFF_FILES, 'class=select2, data-dropdown-auto-width=true');
            $this->diff_files_form->addInputWrapper('<div class="input-group-append"></div>', 'submit');
            $this->diff_files_form->addBtn('submit', 'submit', 1, COMPARE . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success');
        }
    }

    /**
     * reset descending data from database
     * @param  string $level database|tables|table
     * @return null
     */
    public function reset($level)
    {
        if ($level == 'tables') {
            $this->tables     = array();
            $this->table      = '';
            $this->item       = '';
            $this->columns    = array();
            $this->db_columns = array();
        } elseif ($level == 'columns') {
            $this->columns    = array();
            $this->db_columns = array();
        }
        $this->logMessage('<span class="font-weight-bold">reset</strong> => ' . $level);
    }

    /**
     * replace chars from string to make readable name
     * @param  string $string
     * @return string
     */
    public function toReadable($string)
    {
        $find = array('`-`', '`_`');
        $replace = array(' ', ' ');

        return preg_replace($find, $replace, $string);
    }

    /**
     * get database columns data corresponding to generator needs
     * @return
     * array(
     *     type =>
     *     validation =>
     *     primary => true|false
     *     auto_increment => true|false
     * )
     */
    private function getColumnsDataFromDb()
    {
        $valid_db_types = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'decimal', 'float', 'double', 'real', 'date', 'datetime', 'timestamp', 'time', 'year', 'char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext', 'enum', 'set');
        $columns_data = array(
             'type',
             'select_values',
             'validation',
             'primary',
             'auto_increment'
        );
        for ($i=0; $i < $this->columns_count; $i++) {
            // get type before parenthesis
            $pos = strpos($this->db_columns['type'][$i], '(');
            if ($pos === false) {
                $column_type = $this->db_columns['type'][$i];
            } else {
                $type = substr($this->db_columns['type'][$i], 0, $pos);
                if (in_array($type, $valid_db_types)) {
                    // detect if boolean from records values
                    if ($this->db_columns['type'][$i] == 'tinyint(1)') {
                        $qry = 'SELECT ' . $this->db_columns['name'][$i] . ' FROM ' . $this->table . ' WHERE ' . $this->db_columns['name'][$i] . ' > 1 LIMIT 1';
                        $db = new Mysql();
                        $db->query($qry);
                        $db_count = $db->rowCount();
                        if (!empty($db_count)) {
                            $type = 'tinyint';
                        } else {
                            $type = 'boolean';
                        }
                    }
                    $column_type = $type;
                } else {
                    // default if type not found
                    $column_type = 'varchar';
                }
            }
            $columns_data['column_type'][] = $column_type;

            // get select values if enum|set
            if ($column_type == 'enum' || $column_type == 'set') {
                // Remove "set(" at start and ");" at end.
                $set  = substr($this->db_columns['type'][$i], 5, strlen($this->db_columns['type'][$i])-7);

                // Split into an array.
                $array_values = explode(',', str_replace("'", '', $set));

                // convert to associative array
                $assoc_array = array();
                foreach ($array_values as $key => $value) {
                    if (!empty($value)) {
                        $assoc_array[$value] = $value;
                    }
                }
                $columns_data['select_values'][] = $assoc_array;
            } else {
                $columns_data['select_values'][] = '';
            }
            $columns_data['validation'][] = $this->getValidation($column_type, $i);
            if ($this->db_columns['key'][$i] == 'PRI') {
                $columns_data['primary'][] = true;
                $this->primary_key            = $this->db_columns['name'][$i];
                $this->field_delete_confirm_1 = $this->db_columns['name'][$i];
                $this->field_delete_confirm_2 = '';
            } else {
                $columns_data['primary'][] = false;
            }
            if ($this->db_columns['extra'][$i] == 'auto_increment') {
                $columns_data['auto_increment'][] = true;
            } else {
                $columns_data['auto_increment'][] = false;
            }
        }
        $this->logMessage('<span class="font-weight-bold">getColumnsDataFromDb</strong>');

        return $columns_data;
    }

    /**
     * deduct validation from db column type
     * @param  string $column_type    column type before parenthesis
     * @param  number $i              column index
     * @return array  $validation
     */
    public function getValidation($column_type, $i)
    {
        $db_column_type = $this->db_columns['type'][$i];
        $db_column_null = $this->db_columns['null'][$i];
        $validation = array();
        // no validation if column can be null
        // if ($db_column_null !== 'YES' || $this->db_columns['extra'][0] == 'auto_increment') {
            $int        = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint');
            $decimal    = array('decimal', 'numeric', 'float', 'double', 'real');
            $boolean    = array('boolean');
            $date_time  = array('date', 'datetime', 'timestamp', 'time', 'year');
            $string     = array('char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext');
            $sets       = array('enum', 'set');
        if ($db_column_null == 'NO') {
            $validation[] = array(
                'function' => 'required',
                'args' => ''
            );
        }
        if (in_array($column_type, $int)) {
            // validate integer
            $validation[] = array(
                'function' => 'integer',
                'args' => ''
            );
            preg_match('`([a-z]+)\(([0-9]+)\)`', $db_column_type, $out);

            // calculate unsigned min max values
            if (preg_match('`unsigned`', $db_column_type)) {
                $min = '0';
                // convert number of values to '9'. ex : 2 => 99
                $max = $this->getMaxNumber($out[2]);
                if ($column_type == 'tinyint' && $out[2] == 3) {
                    $max = '255';
                } elseif ($column_type == 'smallint' && $out[2] == 5) {
                    $max = '65535';
                } elseif ($column_type == 'mediumint' && $out[2] == 8) {
                    $max = '16777215';
                } elseif ($column_type == 'int' && $out[2] == 10) {
                    $max = '4294967295';
                } elseif ($column_type == 'bigint' && $out[2] == 20) {
                    $max = '18446744073709551615';
                }
            } else {
                // convert number of values to '9'. ex : 2 => 99
                $min = -($this->getMaxNumber($out[2]));
                $max = $this->getMaxNumber($out[2]);
                if ($column_type == 'tinyint' && $out[2] == 3) {
                    $min = '-128';
                    $max = '127';
                } elseif ($column_type == 'smallint' && $out[2] == 5) {
                    $min = '-32768';
                    $max = '32767';
                } elseif ($column_type == 'mediumint' && $out[2] == 8) {
                    $min = '-8388608';
                    $max = '8388607';
                } elseif ($column_type == 'int' && $out[2] == 10) {
                    $min =  '-2147483648';
                    $max = '2147483647';
                } elseif ($column_type == 'bigint' && $out[2] == 20) {
                    $min = '-9223372036854775808';
                    $max = '9223372036854775807';
                }
            }
            $validation[] = array(
                'function' => 'min',
                'args' => $min
            );
            $validation[] = array(
                'function' => 'max',
                'args' => $max
            );
        } elseif (in_array($column_type, $decimal)) {
            // validate decimal
            $validation[] = array(
                'function' => 'float',
                'args' => ''
            );
            preg_match('`([a-z]+)\(([0-9]+),([0-9]+)\)`', $db_column_type, $out);

            // calculate min / max values
            $max = $this->getMaxNumber($out[2], $out[3]);
            if (preg_match('`unsigned`', $db_column_type)) {
                $min = 0;
            } else {
                $min = -($max);
            }
            $validation[] = array(
                'function' => 'min',
                'args' => $min
            );
            $validation[] = array(
                'function' => 'max',
                'args' => $max
            );
        } elseif (in_array($column_type, $boolean)) {
            $validation[] = array(
                'function' => 'min',
                'args' => '0'
            );
            $validation[] = array(
                'function' => 'max',
                'args' => '1'
            );
        } elseif (in_array($column_type, $date_time)) {
            $validation[] = array(
                'function' => 'date',
                'args' => ''
            );
        } elseif (in_array($column_type, $string)) {
            if (preg_match('`([a-z]+)\(([0-9]+)\)`', $db_column_type, $out)) {
                $validation[] = array(
                    'function' => 'maxLength',
                    'args' => $out[2]
                );
            }
        } elseif (in_array($column_type, $sets)) {
            // Remove "[enum|set](" at start and ");" at end.
            if ($column_type == 'enum') {
                $out  = substr($db_column_type, 6, strlen($db_column_type) - 8);
            } else {
                $out  = substr($db_column_type, 5, strlen($db_column_type) - 7);
            }
            $validation[] = array(
                'function' => 'oneOf',
                'args' => "'" . preg_replace('`\',\'`', ',', $out) . "'"
            );
        }
        // }

        return $validation;
    }

    /**
     * convert int or decimal '9'.
     * 2 returns 99
     * 3.2 returns 999.99
     * @param  int $int
     * @return int $decimal
     */
    private function getMaxNumber($int, $decimal = '')
    {
        $units = '';
        for ($i=0; $i < $int; $i++) {
            $units .= '9';
        }
        $dec = '';
        if (!empty($decimal)) {
            $dec = '.';
            for ($i=0; $i < $decimal; $i++) {
                $dec .= '9';
            }
        }

        return $units . $dec;
    }

    /** delete relations json file */
    public function resetRelations()
    {
        if (file_exists(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json')) {
            if (!@unlink(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json')) {
                $this->userMessage(FAILED_TO_DELETE . ' ' . GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json', 'alert-danger has-icon');
            }
        }
    }

    /**
     * if $this->simulate_and_debug === true, will JUST copy table data in backup dir (delete nothing)
     *
     * copy table data in backup dir
     * then delete table data
     * files :
     *     admin/crud-data/db-data.json (delete data)
     *     item-filter-data.json (delete file)
     *     item-select-data.json (delete file)
     * @return void
     */
    private function deleteTableData($table = '')
    {
        if (empty($table)) {
            $table = $this->table;
            $item  = $this->item;
        } else {
            $upperCamelCaseTable = ElementsUtilities::upperCamelCase($table);
            $item = mb_strtolower($upperCamelCaseTable);
        }
        if ($this->simulate_and_debug !== true) {
            $msg = array();

            $this->logMessage('<span class="font-weight-bold">deleteTableData</strong>');

        // Generate backup file then delete generator table.json
            $path = GENERATOR_DIR . 'database/' . $this->database;
            $file = $table . '.json';
            if (file_exists($path . '/' . $file)) {
                // Generate backup file
                $backup_path = str_replace(GENERATOR_DIR, BACKUP_DIR, $path);
                if (!is_dir($backup_path)) {
                    if (!mkdir($backup_path, 0775)) {
                        $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . $backup_path, 'alert-danger has-icon');

                        return false;
                    }
                }
                if (copy($path . '/' . $file, $backup_path . '/' . $file) === false) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $backup_path . '/' . $file, 'alert-danger has-icon');
                }

                if ($this->simulate_and_debug !== true) {
                    // Delete file
                    if (!@unlink($path . '/' . $file)) {
                        $msg[] = FAILED_TO_DELETE . ' ' . $path . '/' . $file;
                    } else {
                        $this->logMessage('<span class="font-weight-bold">--- unlink </strong>' . $file);
                    }
                }
            }

            // remove table from db-data (admin/crud-data/db-data.json)
            $path = ADMIN_DIR . 'crud-data';
            $file = 'db-data.json';
            if (file_exists($path . '/' . $file)) {
                // Generate backup file
                $backup_path = str_replace(ADMIN_DIR, BACKUP_DIR, $path);
                if (!is_dir($backup_path)) {
                    if (!mkdir($backup_path, 0775)) {
                        $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . $backup_path, 'alert-danger has-icon');

                        return false;
                    }
                }
                if (copy($path . '/' . $file, $backup_path . '/' . $file) === false) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $backup_path . '/' . $file, 'alert-danger has-icon');
                }

                if ($this->simulate_and_debug !== true) {
                    // delete table data
                    $json    = file_get_contents($path . '/' . $file);
                    $db_data = json_decode($json, true);
                    if (isset($db_data[$table])) {
                        unset($db_data[$table]);
                        $json = json_encode($db_data, JSON_UNESCAPED_UNICODE);
                        $this->registerAdminFile($path . '/', $file, $json);
                    }
                }
            }

        // backup & delete admin item-filter-data.json
            $path = ADMIN_DIR . 'crud-data';
            $file = $item . '-filter-data.json';
            if (file_exists($path . '/' . $file)) {
                 // Generate backup file
                $backup_path = str_replace(ADMIN_DIR, BACKUP_DIR, $path);
                if (!is_dir($backup_path)) {
                    if (!mkdir($backup_path, 0775)) {
                        $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . $backup_path, 'alert-danger has-icon');

                        return false;
                    }
                }
                if (copy($path . '/' . $file, $backup_path . '/' . $file) === false) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $backup_path . '/' . $file, 'alert-danger has-icon');
                }

                if ($this->simulate_and_debug !== true) {
                    if (!@unlink($path . '/' . $file)) {
                        $msg[] = FAILED_TO_DELETE . ' ' . $path . '/' . $file;
                    } else {
                        $this->logMessage('<span class="font-weight-bold">--- unlink </strong>' . $file);
                    }
                }
            }

            // backup & delete admin item-select-data.json
            $path = ADMIN_DIR . 'crud-data';
            $file = $item . '-select-data.json';
            if (file_exists($path . '/' . $file)) {
                 // Generate backup file
                $backup_path = str_replace(ADMIN_DIR, BACKUP_DIR, $path);
                if (!is_dir($backup_path)) {
                    if (!mkdir($backup_path, 0775)) {
                        $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . $backup_path, 'alert-danger has-icon');

                        return false;
                    }
                }
                if (copy($path . '/' . $file, $backup_path . '/' . $file) === false) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $backup_path . '/' . $file, 'alert-danger has-icon');
                }

                if ($this->simulate_and_debug !== true) {
                    if (!@unlink($path . '/' . $file)) {
                        $msg[] = FAILED_TO_DELETE . ' ' . $path . '/' . $file;
                    } else {
                        $this->logMessage('<span class="font-weight-bold">--- unlink </strong>' . $file);
                    }
                }
            }

            if ($this->simulate_and_debug !== true) {
                // remove table from sidenav
                $this->unregisterNavTable($table);
            }

            if (count($msg) > 0) {
                $msg = implode('<br>', $msg);

                // error message
                $this->userMessage($msg, 'alert-danger has-icon');
            } else {
                // all OK
                $this->userMessage(str_replace('%table%', $table, TABLE_HAS_BEEN_REMOVED), 'alert-success has-icon');
            }
        }
    }

    /**
     * if $this->simulate_and_debug === true, will just simulate and record results in class/generator/reload-table-data-debug.log
     * regenerate table data from database
     * then restore content from backup files :
     *     GENERATOR_DIR . 'database/' . $this->database . '/' . $this->table . '.json'
     *     ADMIN_DIR . 'crud-data/db-data.json'
     *     ADMIN_DIR . 'crud-data/' . $this->item . '-filter-data.json'
     *     ADMIN_DIR . 'crud-data/' . $this->item . '-select-data.json'
     *
     * @return [type] [description]
     */
    private function reloadTableData()
    {
        $this->logMessage('<span class="font-weight-bold">reloadTableData</strong>');

        // register columns from database in $this->table . '.json'
        $this->columns = array();
        $this->db_columns = array();
        $this->getDbColumns();
        $this->registerColumnsProperties();

        // restore content from backup files
        $backup_path = BACKUP_DIR . 'database/' . $this->database;
        $path = str_replace(BACKUP_DIR, GENERATOR_DIR, $backup_path);
        $file = $this->table . '.json';
        if (file_exists($backup_path . '/' . $file) && file_exists($path . '/' . $file)) {
            // Restore backup content from table.json in generator file
            $json             = file_get_contents($backup_path . '/' . $file);
            $json_backup_data = json_decode($json, true);

            // array_intersect_key returns keys => values from array_1 if key exists in array_2
            // recursiveArrayIntersectKey = same function using recursive
            $this->list_options = self::recursiveArrayIntersectKey($json_backup_data['list_options'], $this->list_options);

            // restore columns data only for columns with same name & same column_type
            $columns_data_to_restore = array(
                'field_type',
                // 'relation',
                'validation_type',
                'value_type',
                'validation',
                'fields',
                'jedit',
                'special',
                'special2',
                'special3',
                'special4',
                'special5',
                'special6',
                'special7',
                'sorting',
                'nested',
                'skip',
                'select_from',
                'select_from_table',
                'select_from_value',
                'select_from_field_1',
                'select_from_field_2',
                'select_custom_values',
                'select_multiple',
                'help_text',
                'tooltip',
                'required',
                'char_count',
                'char_count_max',
                'tinyMce',
                'field_width'
            );
            $count = count($this->columns['name']);
            if ($this->simulate_and_debug === true) {
                $content = array();
                $content[] = "\n\n" . '==================================== ' . "\n" . $file . "\n" . '====================================';
                $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n");
            }
            for ($i=0; $i < $count; $i++) {
                $key = array_search($this->columns['name'][$i], $json_backup_data['columns']['name']);
                if ($key !== false && $this->columns['column_type'][$i] == $json_backup_data['columns']['column_type'][$key]) {
                    if ($this->simulate_and_debug === true) {
                        $content = array();
                        $content[] = 'FOUND FROM BACKUP column name: ' . $this->columns['name'][$i] . "\n" . '------------------------------------';
                        $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
                    }
                    foreach ($columns_data_to_restore as $c_data) {
                        // $this->columns[$c_data] = self::recursiveArrayIntersectKey($json_backup_data['columns'][$c_data], $this->columns[$c_data]);
                        if (isset($json_backup_data['columns'][$c_data][$key])) {
                            $this->columns[$c_data][$i] = $json_backup_data['columns'][$c_data][$key];
                            if ($this->simulate_and_debug === true) {
                                $content = array();
                                $content[] = '      FOUND FROM BACKUP $c_data: ' . $c_data;
                                if (is_array($json_backup_data['columns'][$c_data][$key])) {
                                    $content[] = '  $this->columns[$c_data][$i] =  ' . var_export($json_backup_data['columns'][$c_data][$key], true);
                                } else {
                                    $content[] = '  $this->columns[$c_data][$i] =  ' . $json_backup_data['columns'][$c_data][$key];
                                }
                                $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
                            }
                        }
                    }
                }
            }
            // $this->external_columns     = self::recursiveArrayIntersectKey($json_backup_data['external_columns'], $this->external_columns);
            if (in_array($json_backup_data['field_delete_confirm_1'], $this->columns['name'])) {
                $this->field_delete_confirm_1 = $json_backup_data['field_delete_confirm_1'];
                $this->field_delete_confirm_2 = $json_backup_data['field_delete_confirm_2'];
                if ($this->simulate_and_debug === true) {
                    $content = array();
                    $content[] = '      FOUND FROM BACKUP field_delete_confirm_1: ' . $this->field_delete_confirm_1;
                    $content[] = '      FOUND FROM BACKUP field_delete_confirm_2: ' . $this->field_delete_confirm_2;
                    $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
                }
            } else {
                // default is primary key if old field_delete_confirm doesn't exist anymore
                $key = array_search(true, $this->columns['primary']);
                if ($key !== false) {
                    $this->field_delete_confirm_1 = $this->columns['name'][$key];
                } else {
                    $this->field_delete_confirm_1 = $this->columns['name'][0];
                }
                $this->field_delete_confirm_2 = '';
            }

            if ($this->simulate_and_debug !== true) {
                $json_data = array(
                    'list_options'           => $this->list_options,
                    'columns'                => $this->columns,
                    'external_columns'       => $this->external_columns,
                    'field_delete_confirm_1' => $this->field_delete_confirm_1,
                    'field_delete_confirm_2' => $this->field_delete_confirm_2
                );

                // register table & columns properties in json file
                $json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
                $this->registerJson($this->table . '.json', $json);
            }
        }

        $backup_path = BACKUP_DIR . 'crud-data';
        $path = str_replace(BACKUP_DIR, ADMIN_DIR, $backup_path);
        $file = 'db-data.json';

        if ($this->simulate_and_debug === true) {
            $content = array();
            $content[] = "\n\n" . '==================================== ' . "\n" . $file . "\n" . '====================================';
            $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
        }

        if (file_exists($backup_path . '/' . $file) && file_exists($path . '/' . $file)) {
            // Restore backup content in admin file
            $json             = file_get_contents($backup_path . '/' . $file);
            $json_backup_data = json_decode($json, true);

            // $json            = file_get_contents($path . '/' . $file);
            // $admin_json_data = json_decode($json, true);

            // $json_data = self::recursiveArrayIntersectKey($json_backup_data, $admin_json_data);
            $json_data = $json_backup_data;
            $table = $this->table;
            if (isset($json_backup_data[$table]['fields'])) {
                foreach ($this->columns['fields'] as $column_name => $column_label) {
                    if (isset($json_backup_data[$table]['fields'][$column_name])) {
                        $this->columns['fields'][$column_name] = $json_backup_data[$table]['fields'][$column_name];
                        if ($this->simulate_and_debug === true) {
                            $content = array();
                            $content[] = '      FOUND FROM BACKUP $column_name: ' . $column_name;
                            $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
                        }
                    }
                }
            }

            $table_icon             = $this->table_icon;
            $table_label            = $this->table_label;
            $upperCamelCaseTable    = ElementsUtilities::upperCamelCase($this->table);
            $class_name             = $upperCamelCaseTable;
            $item                   = $this->item;
            $primary_key            = $this->primary_key;
            $field_delete_confirm_1 = $this->field_delete_confirm_1;
            $field_delete_confirm_2 = $this->field_delete_confirm_2;
            $fields                 = $this->columns['fields'];

            if ($this->simulate_and_debug !== true) {
                $json_data[$table] = array(
                    'item'                   => $item,
                    'table_label'            => $table_label,
                    'class_name'             => $class_name,
                    'primary_key'            => $primary_key,
                    'field_delete_confirm_1' => $field_delete_confirm_1,
                    'field_delete_confirm_2' => $field_delete_confirm_2,
                    'icon'                   => $table_icon,
                    'fields'                 => $fields
                );

                $data = json_encode($json_data, JSON_UNESCAPED_UNICODE);

                $this->registerAdminFile($path . '/', $file, $data, false);
            }
        }

        // filter-data (admin/data/[table]-filter-data.json)
        $backup_path = BACKUP_DIR . 'crud-data';
        $path = str_replace(BACKUP_DIR, ADMIN_DIR, $backup_path);
        $file = $this->item . '-filter-data.json';

        if ($this->simulate_and_debug === true) {
            $content = array();
            $content[] = "\n\n" . '==================================== ' . "\n" . $file . "\n" . '====================================';
            $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
        }

        if (file_exists($backup_path . '/' . $file)) {
            $json             = file_get_contents($backup_path . '/' . $file);
            $json_backup_data = json_decode($json, true);

            foreach ($json_backup_data as $jbd) {
                // if filter field still exists
                if (in_array($jbd['filter_A'], $this->columns['name'])) {
                    $this->list_options['filters'][] = $jbd;
                }
                if ($this->simulate_and_debug === true) {
                    $content = array();
                    $content[] = '      FOUND FROM BACKUP filter_A: ' . $jbd['filter_A'];
                    $fp = file_put_contents('class/generator/reload-table-data-debug.log', implode("\n", $content) . "\n\n", FILE_APPEND);
                }
            }
        }
        $filter_data = $this->list_options['filters'];
        $json = json_encode($filter_data, JSON_UNESCAPED_UNICODE);
        $dir = ADMIN_DIR . 'crud-data/';
        if ($this->simulate_and_debug !== true) {
            $this->registerAdminFile($dir, $file, $json);
        }

        // select-data (admin/crud-data/[table]-select-data.json)
        $select_data = array();
        for ($i=0; $i < $this->columns_count; $i++) {
            $name               = $this->columns['name'][$i];
            $this->getSelectValues($name);
            $select_data[$name] = array(
                'from'          => $this->columns['select_from'][$i],
                'from_table'    => $this->columns['select_from_table'][$i],
                'from_value'    => $this->columns['select_from_value'][$i],
                'from_field_1'  => $this->columns['select_from_field_1'][$i],
                'from_field_2'  => $this->columns['select_from_field_2'][$i],
                'custom_values' => $this->columns['select_custom_values'][$i],
                'multiple'      => $this->columns['select_multiple'][$i]
            );
        }

        if ($this->simulate_and_debug !== true) {
            $json = json_encode($select_data, JSON_UNESCAPED_UNICODE);
            $dir = ADMIN_DIR . 'crud-data/';
            $file = $this->item . '-select-data.json';
            $dir_path[]  = $dir;
            $file_name[] = $file;
            $this->registerAdminFile($dir, $file, $json);
        }
    }

    /**
     * returns keys => values from array_1 if key exists in array_2
     * recursive => compare array values inside parent array
     *
     * $array_1 = json_backup_data
     * $array_2 = db_data
     *
     *
     * @param  array  $array_1
     * @param  array  $array_2
     * @return Array
     */
    private static function recursiveArrayIntersectKey(array $array_1, array $array_2, $vd = false)
    {
        $array_1 = array_intersect_key($array_1, $array_2);
        foreach ($array_1 as $key => &$value) {
            if (is_array($value)) {
                if (is_array($array_2[$key])) {
                    $value = self::recursiveArrayIntersectKey($value, $array_2[$key], false);
                }
            }
        }
        if ($vd == true) {
            var_dump($array_1);
        }
        return $array_1;
    }

    /**
     * Auto-detect relations between tables
     * called :
     *     - on first database post
     *     - on relation reset post (json file has beed deleted)
     *     - if a table has been deleted
     * register relations in generator/database/[current_db]/[current_db]_relations.json
     * @return [type] [description]
     */
    public function registerRelations()
    {
        $db = new Mysql();
        $db->throwExceptions = true;
        try {
            $db->transactionBegin();
            $qry = 'SELECT `TABLE_NAME`, `COLUMN_NAME`, `REFERENCED_TABLE_NAME`, `REFERENCED_COLUMN_NAME` FROM `information_schema`.`KEY_COLUMN_USAGE` WHERE `CONSTRAINT_SCHEMA` = \'' . $this->database . '\' AND `REFERENCED_TABLE_SCHEMA` IS NOT NULL AND `REFERENCED_TABLE_NAME` IS NOT NULL AND `REFERENCED_COLUMN_NAME` IS NOT NULL';
            $db->query($qry);
            $db_count = $db->rowCount();
            if (!empty($db_count)) {
                /* output example

                    TABLE_NAME         COLUMN_NAME       REFERENCED_TABLE_NAME     REFERENCED_COLUMN_NAME
                    orders             customers_ID      customers                 ID
                    products_orders    orders_ID         orders                    ID
                    products_orders    products_ID       products                  ID
                */

                // reset
                $this->relations = array(
                    'db'                    => array(),
                    'all_db_related_tables' => array(),
                    'from_to'               => array(),
                    'from_to_origin_tables' => array(),
                    'from_to_target_tables' => array()
                );

                while (! $db->endOfSeek()) {
                    $row                 = $db->row();
                    $table[]             = $row->TABLE_NAME;
                    $column[]            = $row->COLUMN_NAME;
                    $referenced_table[]  = $row->REFERENCED_TABLE_NAME;
                    $referenced_column[] = $row->REFERENCED_COLUMN_NAME;

                    $this->relations['db'][] = array(
                        'table'             => $row->TABLE_NAME,
                        'column'            => $row->COLUMN_NAME,
                        'referenced_table'  => $row->REFERENCED_TABLE_NAME,
                        'referenced_column' => $row->REFERENCED_COLUMN_NAME
                    );

                    $this->relations['all_db_related_tables'][] = $row->TABLE_NAME;
                    $this->relations['all_db_related_tables'][] = $row->REFERENCED_TABLE_NAME;
                }
                $this->relations['all_db_related_tables'] = array_unique($this->relations['all_db_related_tables']);

                /* Get structured from_to relations from db relations */

                $relation = array();

                // one-to-one && one-to many
                for ($i=0; $i < count($this->relations['db']); $i++) {
                    $relation_db                                  = $this->relations['db'][$i];
                    $relation['origin_table']                     = $relation_db['table'];
                    $relation['origin_column']                    = $relation_db['column'];
                    $relation['intermediate_table']               = '';
                    $relation['intermediate_column_1']            = '';
                    $relation['intermediate_column_2']            = '';
                    $relation['target_table']                     = $relation_db['referenced_table'];
                    $relation['target_column']                    = $relation_db['referenced_column'];
                    $relation['cascade_delete_from_intermediate'] = true; // default
                    $relation['cascade_delete_from_origin']       = true; // default

                    $this->relations['from_to'][] = $relation;
                    $this->relations['from_to_origin_tables'][] = $relation['origin_table'];
                    $this->relations['from_to_target_tables'][] = $relation['target_table'];
                }

                // many-to many ( = with intermediate tables)
                // 2 referenced tables must have same origin to be registered as many-to many relation
                $tested_origins = array();
                for ($i=0; $i < count($this->relations['db']); $i++) {
                    $relation_db = $this->relations['db'][$i];
                    if (!in_array($relation_db['table'], $tested_origins)) {
                        $tested_origins[] = $relation_db['table'];

                        // look for same origin in all followings
                        for ($j=$i + 1; $j < count($this->relations['db']); $j++) {
                            $rel_db_row = $this->relations['db'][$j];
                            if ($rel_db_row['table'] == $relation_db['table']) {
                                // same origin tables => recording as many-to many relation
                                $relation['origin_table']                     = $relation_db['referenced_table'];
                                $relation['origin_column']                    = $relation_db['referenced_column'];
                                $relation['intermediate_table']               = $relation_db['table'];
                                $relation['intermediate_column_1']            = $relation_db['column'];
                                $relation['intermediate_column_2']            = $rel_db_row['column'];
                                $relation['target_table']                     = $rel_db_row['referenced_table'];
                                $relation['target_column']                    = $rel_db_row['referenced_column'];
                                $relation['cascade_delete_from_intermediate'] = true; // default
                                $relation['cascade_delete_from_origin']       = true; // default

                                $this->relations['from_to'][] = $relation;
                                $this->relations['from_to_origin_tables'][] = $relation['origin_table'];
                                $this->relations['from_to_target_tables'][] = $relation['target_table'];

                                if (!empty($relation['intermediate_column_1'])) {
                                    // Register reverse relation (ex : products => orders | orders => products)
                                    $relation['origin_table']                     = $rel_db_row['referenced_table'];
                                    $relation['origin_column']                    = $rel_db_row['referenced_column'];
                                    $relation['intermediate_table']               = $relation_db['table'];
                                    $relation['intermediate_column_1']            = $rel_db_row['column'];
                                    $relation['intermediate_column_2']            = $relation_db['column'];
                                    $relation['target_table']                     = $relation_db['referenced_table'];
                                    $relation['target_column']                    = $relation_db['referenced_column'];
                                    $relation['cascade_delete_from_intermediate'] = true; // default
                                    $relation['cascade_delete_from_origin']       = true; // default

                                    $this->relations['from_to'][] = $relation;
                                    $this->relations['from_to_origin_tables'][] = $relation['origin_table'];
                                    $this->relations['from_to_target_tables'][] = $relation['target_table'];
                                }
                            }
                        }
                    }
                }

                $this->relations['from_to_origin_tables'] = array_unique($this->relations['from_to_origin_tables']);
                $this->relations['from_to_target_tables'] = array_unique($this->relations['from_to_target_tables']);

                // register table & columns properties in json file
                $json_data = json_encode($this->relations, JSON_UNESCAPED_UNICODE);
                $this->registerJson($this->database . '-relations.json', $json_data);
                $this->logMessage('<span class="font-weight-bold">registerRelations</strong>');
                $this->userMessage(DB_RELATIONS_REFRESHED, 'alert-success has-icon');
            } else {
                $json_data = '';
                $this->registerJson($this->database . '-relations.json', $json_data);
                $this->logMessage('<span class="font-weight-bold">registerRelations (No relation found)</strong>');
            }
            $db->transactionEnd();
        } catch (\Exception $e) {
            $db->transactionRollback();
            exit($e->getMessage() . '<br>' . $db->getLastSql());
        }
    }

    private function getRelations()
    {
        // create file if doesn't exist
        if (!file_exists(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json')) {
            $this->registerRelations();
        }

        // get relations
        if (file_exists(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json')) {
            $json            = file_get_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json');
            $this->relations = json_decode($json, true);
        } else {
            $this->userMessage(GENERATOR_DIR . 'database/' . $this->database . '/' . $this->database . '-relations.json : ' . ERROR_FILE_NOT_FOUND, 'alert-warning has-icon');
        }
    }

    /**
     * find label in table json file if exists
     * @param  string $table
     * @param  string $column
     * @return string         label from json file or from toReadable function if not found
     */
    public function getLabel($table, $column = '')
    {
        $label     = '';
        $json_data = array();
        if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
            $json      = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
            $json_data = json_decode($json, true);
        }
        if (isset($json_data[$table])) {
            if (empty($column)) {
                $label = $json_data[$table]['table_label'];
            } else {
                $label = $json_data[$table]['fields'][$column];
            }
        } else {
            if (empty($column)) {
                $label = $this->toReadable($table);
            } else {
                $label = $this->toReadable($column);
            }
        }

        return $label;
    }

    /**
     * find icon in table json file if exists
     * @param  string $table
     * @return string         icon from json file or default icon if not found
     */
    public function getIcon($table)
    {
        $icon     = '';
        $json_data = array();
        if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
            $json      = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
            $json_data = json_decode($json, true);
        }
        if (isset($json_data[$table])) {
            $icon = $json_data[$table]['icon'];
        } else {
            $icon = $this->default_table_icon;
        }

        return $icon;
    }

    public function registerJson($file_name, $json_data)
    {
        if (!is_dir(GENERATOR_DIR . 'database/' . $this->database)) {
            if (!mkdir(GENERATOR_DIR . 'database/' . $this->database, 0775)) {
                $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . GENERATOR_DIR . 'database/' . $this->database, 'alert-danger has-icon');

                return false;
            }
        }
        if (file_put_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . $file_name, $json_data) === false) {
            $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . GENERATOR_DIR . 'database/' . $this->database . '/' . $file_name, 'alert-danger has-icon');

            return false;
        }
        $this->logMessage('<span class="font-weight-bold">registerJson</strong> => ' . $file_name);
    }

    public function registerAdminFile($dir_path, $file_name, $data, $backup = true)
    {
        if (!is_dir($dir_path)) {
            if (!mkdir($dir_path, 0775)) {
                $this->userMessage(ERROR_CANT_CREATE_DIR . ' ' . $dir_path, 'alert-danger has-icon');

                return false;
            }
        }

        // Generate backup file
        if (file_exists($dir_path . $file_name) && $backup === true) {
            $backup_dir = str_replace(ADMIN_DIR, BACKUP_DIR, $dir_path);
            if (copy($dir_path . $file_name, $backup_dir . $file_name) === false) {
                $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $backup_dir . $file_name, 'alert-danger has-icon');
            }
        }

        // Register new content
        if (file_put_contents($dir_path . $file_name, $data) === false) {
            $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $dir_path . $file_name, 'alert-danger has-icon');

            return false;
        }
        $this->logMessage('<span class="font-weight-bold">registerAdminFile</strong> => ' . $dir_path . $file_name);
    }

    public function lockAdminPanel()
    {
        $userConf = json_decode(file_get_contents(ROOT . 'conf/user-conf.json'));
        $userConf->admin_locked = true;
        $user_conf = json_encode($userConf);
        if (DEMO !== true) {
            if (!file_put_contents(ROOT . 'conf/user-conf.json', $user_conf)) {
                $this->userMessage(ERROR_CANT_WRITE_FILE . ': ' . ROOT . 'conf/user-conf.json', 'alert-danger has-icon');

                return false;
            }

            return true;
        }

        return true;
    }

    /**
     * parse a sql "from" query - used to parse filters "from"
     * @param  string $from - the complete "from" query with tables & joins
     * @return array       An array with the tables used in from and the join queries
     */
    public function parseQuery($from)
    {
        $qry         = preg_replace('`( LEFT JOIN| INNER JOIN| RIGHT JOIN)`', '%$1', $from);
        $out         = preg_split('`%`', $qry);
        $from_table  = trim($out[0]);
        array_splice($out, 0, 1);
        $join_queries = $out;

        $join_tables = array();
        foreach ($join_queries as $qry) {
            preg_match('`JOIN ([a-zA-Z_]+) ON`', $qry, $table_out);
            $join_tables[] = $table_out[1];
        }

        $parsed = array(
            'from_table'   => $from_table,
            'join_tables'  => $join_tables,
            'join_queries' => $join_queries
        );

        return $parsed;
    }

    private function checkRequiredFiles()
    {
        $files_to_create = array(
            ADMIN_DIR . 'crud-data/nav-data.json',
            ADMIN_DIR . 'crud-data/db-data.json'
        );
        $directories_to_create = array(
            BACKUP_DIR . 'class',
            BACKUP_DIR . 'class/crud',
            BACKUP_DIR . 'crud-data',
            BACKUP_DIR . 'database',
            BACKUP_DIR . 'inc',
            BACKUP_DIR . 'inc/forms',
            BACKUP_DIR . 'templates'
        );

        foreach ($files_to_create as $file) {
            if (!file_exists($file)) {
                if (!touch($file)) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $file, 'alert-danger has-icon');
                } else {
                    $this->logMessage('<span class="font-weight-bold">checkRequiredFiles</strong> => CREATE ' . $file);
                }
            }
        }

        foreach ($directories_to_create as $dir) {
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0755)) {
                    $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $dir, 'alert-danger has-icon');
                } else {
                    $this->logMessage('<span class="font-weight-bold">checkRequiredFiles</strong> => CREATE ' . $dir);
                }
            }
        }
    }

    private function unlockAdminPanel()
    {
        $userConf = json_decode(file_get_contents(ROOT . 'conf/user-conf.json'));
        $userConf->admin_locked = false;
        $user_conf = json_encode($userConf);
        if (DEMO !== true) {
            if (!file_put_contents(ROOT . 'conf/user-conf.json', $user_conf)) {
                $this->userMessage(ERROR_CANT_WRITE_FILE . ': ' . ROOT . 'conf/user-conf.json', 'alert-danger has-icon');

                return false;
            }

            return true;
        }

        return true;
    }

    private function removeAuthentificationModule()
    {
        // USERS_TABLE
        include_once ADMIN_DIR . 'secure/conf/conf.php';
        $users_classname = ElementsUtilities::upperCamelCase($this->table);
        $item = mb_strtolower($users_classname);

        $files_to_delete = array(
            GENERATOR_DIR . 'database/' . $this->database . '/' . USERS_TABLE . '.json',
            GENERATOR_DIR . 'database/' . $this->database . '/' . USERS_TABLE . '_profiles.json',
            ADMIN_DIR . 'class/crud/' . $users_classname . '.php',
            ADMIN_DIR . 'class/crud/' . $users_classname . 'Profiles.php',
            ADMIN_DIR . 'crud-data/' . USERS_TABLE . '-filter-data.json',
            ADMIN_DIR . 'crud-data/' . USERS_TABLE . '-select-data.json',
            ADMIN_DIR . 'crud-data/' . USERS_TABLE . 'profiles-filter-data.json',
            ADMIN_DIR . 'crud-data/' . USERS_TABLE . 'profiles-select-data.json',
            ADMIN_DIR . 'inc/forms/' . USERS_TABLE . '-create.php',
            ADMIN_DIR . 'inc/forms/' . USERS_TABLE . '-edit.php',
            ADMIN_DIR . 'inc/forms/' . USERS_TABLE . 'profiles-create.php',
            ADMIN_DIR . 'inc/forms/' . USERS_TABLE . 'profiles-edit.php',
            ADMIN_DIR . 'secure/install/install.lock'
        );

        /* store tables custom names to reuse on next authentification module installation */

        // users
        $users_json = file_get_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . USERS_TABLE . '.json');
        $users_json_data = json_decode($users_json, true);
        $_SESSION['users_columns_json_data'] = $users_json_data['columns']['fields']; // [field_name => displayed name]

        // profiles
        $users_profiles_json = file_get_contents(GENERATOR_DIR . 'database/' . $this->database . '/' . USERS_TABLE . '_profiles.json');
        $users_profiles_json_data = json_decode($users_profiles_json, true);
        $_SESSION['users_profiles_columns_json_data'] = $users_profiles_json_data['columns']['fields']; // [field_name => displayed name]

        $unlink_success = true;
        foreach ($files_to_delete as $file) {
            if (file_exists($file)) {
                if (@unlink($file) === false) {
                    $unlink_success = false;
                    $this->userMessage(FAILED_TO_DELETE . ' ' . $file, 'alert-danger has-icon');
                }
            }
        }

        if ($unlink_success === true) {
            // nav data (admin/data/nav-data.json)
            $nav_data = array();
            if (file_exists(ADMIN_DIR . 'crud-data/nav-data.json')) {
                $json     = file_get_contents(ADMIN_DIR . 'crud-data/nav-data.json');
                $nav_data = json_decode($json, true);
                foreach ($nav_data as $root => $navcat) {
                    if (in_array(USERS_TABLE, $navcat['tables'])) {
                        $key = array_search(USERS_TABLE, $navcat['tables']);
                        unset($navcat['tables'][$key]);
                        unset($navcat['is_disabled'][$key]);
                    }
                    if (in_array(USERS_TABLE . '_profiles', $navcat['tables'])) {
                        $key = array_search(USERS_TABLE . '_profiles', $navcat['tables']);
                        unset($navcat['tables'][$key]);
                        unset($navcat['is_disabled'][$key]);
                    }
                }
                $dir              = ADMIN_DIR . 'crud-data/';
                $file             = 'nav-data.json';
                $this->registerAdminFile($dir, $file, json_encode($nav_data, JSON_UNESCAPED_UNICODE));
            }

            // db-data (admin/data/db-data.json)
            if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
                $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
                $db_data = json_decode($json, true);
                unset($db_data[USERS_TABLE]);
                unset($db_data[USERS_TABLE . '_profiles']);
                $dir = ADMIN_DIR . 'crud-data/';
                $file = 'db-data.json';
                $this->registerAdminFile($dir, $file, $json);
            }

            $db = new Mysql();
            $qry = 'DROP TABLE ' . USERS_TABLE;
            $db->query($qry);
            $qry = 'DROP TABLE ' . USERS_TABLE . '_profiles';
            $db->query($qry);

            $this->resetRelations();
            $this->registerRelations();
            $this->reset('tables');
            $_SESSION['generator'] = $this;

            // reload page to refresh authentification module
            header("Refresh:0");
            exit();
        }

        $this->logMessage('<span class="font-weight-bold">removeAuthentificationModule</strong>');
    }

    /**
     * replace some content in given file
     * @param  string $find
     * @param  string $replace
     * @param  string $file_path
     * @return Boolean
     */
    private function replaceInFile($find, $replace, $file_path)
    {
        if (file_exists($file_path)) {
            $content = file_get_contents($file_path);
            $content = str_replace($find, $replace, $content);
            if (file_put_contents($file_path, $content) === false) {
                $this->userMessage(ERROR_CANT_WRITE_FILE . ' ' . $file_path, 'alert-danger has-icon');

                return false;
            } else {
                return true;
            }
        } else {
            $this->userMessage(ERROR_FILE_NOT_FOUND . ' ' . $file_path, 'alert-danger has-icon');

            return false;
        }
    }

    /**
     * recursive scan of directory
     * get all files paths in dir & all subdirs.
     * http://php.net/manual/fr/function.scandir.php
     * @param  string $root_dir
     * @param  string $all_data
     * @return  Array indexed array (non-multidimensional) with all files paths
     */
    private function scanDirectories($root_dir, $all_data = array())
    {

        // set filenames invisible if you want
        $invisible_file_names = array(".", "..", ".htaccess", ".htpasswd");

        // run through content of root directory
        $dir_content = scandir($root_dir);
        foreach ($dir_content as $key => $content) {
            // filter all files not accessible
            $path = $root_dir.'/'.$content;
            if (!in_array($content, $invisible_file_names)) {
                // if content is file & readable, add to array
                if (is_file($path) && is_readable($path)) {
                    // save file name with path
                    $all_data[] = $path;

                // if content is a directory and readable, add path and name
                } elseif (is_dir($path) && is_readable($path)) {
                    // recursive callback to open new directory
                    $all_data = $this->scanDirectories($path, $all_data);
                }
            }
        }
        return $all_data;
    }

    private function logMessage($msg)
    {
        if ($this->debug === true) {
            if (!isset($_SESSION['log-msg'])) {
                $_SESSION['log-msg'] = '';
            }
            $_SESSION['log-msg'] .= '<p>' . $msg . '</p>';
        }
    }

    /**
     * register output message for user
     * alert if no content
     * panel if content
     * @param  string $title            alert|panel title
     * @param  string $classname        Boootstrap alert|panel class (bg-success, bg-primary, bg-warning, bg-danger)
     * @param  string $heading_elements [panels] separated comma list : collapse, reload, close
     * @param  string $content          [panels] panel body html content
     * @return void
     */
    private function userMessage($title, $classname, $heading_elements = 'close', $content = '')
    {
        if (!isset($_SESSION['msg'])) {
            $_SESSION['msg'] = '';
        }
        if (!empty($content)) {
            // panel
            $_SESSION['msg'] .= Utils::alertCard($title, $classname, '', $heading_elements, $content);
        } else {
            // alert
            $_SESSION['msg'] .= Utils::alert($title, $classname);
        }
    }
}
