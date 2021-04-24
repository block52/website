<?php
namespace crud;

use common\Utils;
use phpformbuilder\database\Mysql;
use phpformbuilder\database\Pagination;
use secure\Secure;

class AccountBalances extends Elements
{

    // item name passed in url
    public $item;

    // item name displayed
    public $item_label;

    // associative array : field => field displayed name
    public $fields;

    // primary key passed to create|edit|delete
    public $primary_key; // primary key fieldname
    public $primary_key_alias; // primary key alias for query

    // CREATE rights
    public $can_create = false;

    // authorized primary keys for restricted updates
    public $authorized_update_pk = array();

    public $pk = array(); // primary key values for each row
    public $id = array();
    public $account_id = array();
    public $currency_id = array();
    public $balance = array();
    public $created_at = array();
    public $updated_at = array();

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
        $qry_start        = 'SELECT `account_balances`.`id`, `account_balances`.`account_id`, `account_balances`.`currency_id`, `account_balances`.`balance`, `account_balances`.`created_at`, `account_balances`.`updated_at` FROM account_balances';

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
        $this->sorting = ElementsUtilities::getSorting($table, 'id', 'ASC');
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
                $this->id[]= $row->id;
                $this->account_id[]= $row->account_id;
                $this->currency_id[]= $row->currency_id;
                $this->balance[]= $row->balance;
                $this->created_at[]= $row->created_at;
                $this->updated_at[]= $row->updated_at;
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
        } // end if

        // Export data button
        $this->export_data_button = ElementsUtilities::exportDataButtons($table, $this->main_query, 'excel, csv, browser');

        // number/page
        $numbers_array = array(5, 10, 20, 50, 100, 200, 10000);
        $this->select_number_per_page = ElementsUtilities::selectNumberPerPage($numbers_array, $_SESSION['npp'], $this->item_url);
    }
}
