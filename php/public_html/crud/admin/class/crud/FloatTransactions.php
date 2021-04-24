<?php
namespace crud;

use common\Utils;
use phpformbuilder\database\Mysql;
use phpformbuilder\database\Pagination;
use secure\Secure;

class FloatTransactions extends Elements
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
    public $upoker_name = array();
    public $upoker_id = array();
    public $mobile_number = array();
    public $transaction_type = array();
    public $amount = array();
    public $referral_code = array();
    public $bonus_code = array();
    public $status = array();
    public $submit_time = array();
    public $processed_time = array();
    public $ip_address = array();
    public $country = array();
    public $city = array();

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
        $qry_start        = 'SELECT `float_transactions`.`id`, `float_transactions`.`upoker_name`, `float_transactions`.`upoker_id`, `float_transactions`.`mobile_number`, `float_transactions`.`transaction_type`, `float_transactions`.`amount`, `float_transactions`.`referral_code`, `float_transactions`.`bonus_code`, `float_transactions`.`status`, `float_transactions`.`submit_time`, `float_transactions`.`processed_time`, `float_transactions`.`ip_address`, `float_transactions`.`country`, `float_transactions`.`city` FROM float_transactions';

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
                $this->upoker_name[]= $row->upoker_name;
                $this->upoker_id[]= $row->upoker_id;
                $this->mobile_number[]= $row->mobile_number;
                $this->transaction_type[]= $row->transaction_type;
                $this->amount[]= $row->amount;
                $this->referral_code[]= $row->referral_code;
                $this->bonus_code[]= $row->bonus_code;
                $this->status[]= $row->status;
                $this->submit_time[]= $row->submit_time;
                $this->processed_time[]= $row->processed_time;
                $this->ip_address[]= $row->ip_address;
                $this->country[]= $row->country;
                $this->city[]= $row->city;
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
