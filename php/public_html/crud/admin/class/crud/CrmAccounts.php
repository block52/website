<?php
namespace crud;

use common\Utils;
use phpformbuilder\database\Mysql;
use phpformbuilder\database\Pagination;
use secure\Secure;

class CrmAccounts extends Elements
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
    public $account = array();
    public $fname = array();
    public $lname = array();
    public $company = array();
    public $business_number = array();
    public $jobtitle = array();
    public $cid = array();
    public $o = array();
    public $phone = array();
    public $fax = array();
    public $email = array();
    public $username = array();
    public $address = array();
    public $city = array();
    public $state = array();
    public $zip = array();
    public $country = array();
    public $balance = array();
    public $status = array();
    public $notes = array();
    public $options = array();
    public $tags = array();
    public $password = array();
    public $token = array();
    public $ts = array();
    public $img = array();
    public $web = array();
    public $facebook = array();
    public $google = array();
    public $linkedin = array();
    public $twitter = array();
    public $skype = array();
    public $tax_number = array();
    public $entity_number = array();
    public $currency = array();
    public $pmethod = array();
    public $autologin = array();
    public $lastlogin = array();
    public $lastloginip = array();
    public $stage = array();
    public $timezone = array();
    public $isp = array();
    public $lat = array();
    public $lon = array();
    public $gname = array();
    public $gid = array();
    public $sid = array();
    public $role = array();
    public $country_code = array();
    public $country_idd = array();
    public $signed_up_by = array();
    public $signed_up_ip = array();
    public $dob = array();
    public $ct = array();
    public $assistant = array();
    public $asst_phone = array();
    public $second_email = array();
    public $second_phone = array();
    public $taxexempt = array();
    public $latefeeoveride = array();
    public $overideduenotices = array();
    public $separateinvoices = array();
    public $disableautocc = array();
    public $billingcid = array();
    public $securityqid = array();
    public $securityqans = array();
    public $cardtype = array();
    public $cardlastfour = array();
    public $cardnum = array();
    public $startdate = array();
    public $expdate = array();
    public $issuenumber = array();
    public $bankname = array();
    public $banktype = array();
    public $bankcode = array();
    public $bankacct = array();
    public $gatewayid = array();
    public $language = array();
    public $pwresetkey = array();
    public $emailoptout = array();
    public $created_at = array();
    public $updated_at = array();
    public $pwresetexpiry = array();
    public $is_email_verified = array();
    public $is_phone_veirifed = array();
    public $photo_id_type = array();
    public $photo_id = array();
    public $type = array();
    public $drive = array();
    public $workspace_id = array();
    public $parent_id = array();
    public $code = array();
    public $display_name = array();
    public $secondary_email = array();
    public $secondary_phone = array();
    public $upokername_2 = array();
    public $upokerid_2 = array();

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
        $qry_start        = 'SELECT `crm_accounts`.`id`, `crm_accounts`.`account`, `crm_accounts`.`fname`, `crm_accounts`.`lname`, `crm_accounts`.`company`, `crm_accounts`.`business_number`, `crm_accounts`.`jobtitle`, `crm_accounts`.`cid`, `crm_accounts`.`o`, `crm_accounts`.`phone`, `crm_accounts`.`fax`, `crm_accounts`.`email`, `crm_accounts`.`username`, `crm_accounts`.`address`, `crm_accounts`.`city`, `crm_accounts`.`state`, `crm_accounts`.`zip`, `crm_accounts`.`country`, `crm_accounts`.`balance`, `crm_accounts`.`status`, `crm_accounts`.`notes`, `crm_accounts`.`options`, `crm_accounts`.`tags`, `crm_accounts`.`password`, `crm_accounts`.`token`, `crm_accounts`.`ts`, `crm_accounts`.`img`, `crm_accounts`.`web`, `crm_accounts`.`facebook`, `crm_accounts`.`google`, `crm_accounts`.`linkedin`, `crm_accounts`.`twitter`, `crm_accounts`.`skype`, `crm_accounts`.`tax_number`, `crm_accounts`.`entity_number`, `crm_accounts`.`currency`, `crm_accounts`.`pmethod`, `crm_accounts`.`autologin`, `crm_accounts`.`lastlogin`, `crm_accounts`.`lastloginip`, `crm_accounts`.`stage`, `crm_accounts`.`timezone`, `crm_accounts`.`isp`, `crm_accounts`.`lat`, `crm_accounts`.`lon`, `crm_accounts`.`gname`, `crm_accounts`.`gid`, `crm_accounts`.`sid`, `crm_accounts`.`role`, `crm_accounts`.`country_code`, `crm_accounts`.`country_idd`, `crm_accounts`.`signed_up_by`, `crm_accounts`.`signed_up_ip`, `crm_accounts`.`dob`, `crm_accounts`.`ct`, `crm_accounts`.`assistant`, `crm_accounts`.`asst_phone`, `crm_accounts`.`second_email`, `crm_accounts`.`second_phone`, `crm_accounts`.`taxexempt`, `crm_accounts`.`latefeeoveride`, `crm_accounts`.`overideduenotices`, `crm_accounts`.`separateinvoices`, `crm_accounts`.`disableautocc`, `crm_accounts`.`billingcid`, `crm_accounts`.`securityqid`, `crm_accounts`.`securityqans`, `crm_accounts`.`cardtype`, `crm_accounts`.`cardlastfour`, `crm_accounts`.`cardnum`, `crm_accounts`.`startdate`, `crm_accounts`.`expdate`, `crm_accounts`.`issuenumber`, `crm_accounts`.`bankname`, `crm_accounts`.`banktype`, `crm_accounts`.`bankcode`, `crm_accounts`.`bankacct`, `crm_accounts`.`gatewayid`, `crm_accounts`.`language`, `crm_accounts`.`pwresetkey`, `crm_accounts`.`emailoptout`, `crm_accounts`.`created_at`, `crm_accounts`.`updated_at`, `crm_accounts`.`pwresetexpiry`, `crm_accounts`.`is_email_verified`, `crm_accounts`.`is_phone_veirifed`, `crm_accounts`.`photo_id_type`, `crm_accounts`.`photo_id`, `crm_accounts`.`type`, `crm_accounts`.`drive`, `crm_accounts`.`workspace_id`, `crm_accounts`.`parent_id`, `crm_accounts`.`code`, `crm_accounts`.`display_name`, `crm_accounts`.`secondary_email`, `crm_accounts`.`secondary_phone`, `crm_accounts`.`upokername_2`, `crm_accounts`.`upokerid_2` FROM crm_accounts';

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
                $this->account[]= $row->account;
                $this->fname[]= $row->fname;
                $this->lname[]= $row->lname;
                $this->company[]= $row->company;
                $this->business_number[]= $row->business_number;
                $this->jobtitle[]= $row->jobtitle;
                $this->cid[]= $row->cid;
                $this->o[]= $row->o;
                $this->phone[]= $row->phone;
                $this->fax[]= $row->fax;
                $this->email[]= $row->email;
                $this->username[]= $row->username;
                $this->address[]= $row->address;
                $this->city[]= $row->city;
                $this->state[]= $row->state;
                $this->zip[]= $row->zip;
                $this->country[]= $row->country;
                $this->balance[]= $row->balance;
                $this->status[]= $row->status;
                $this->notes[]= $row->notes;
                $this->options[]= $row->options;
                $this->tags[]= $row->tags;
                $this->password[]= $row->password;
                $this->token[]= $row->token;
                $this->ts[]= $row->ts;
                $this->img[]= $row->img;
                $this->web[]= $row->web;
                $this->facebook[]= $row->facebook;
                $this->google[]= $row->google;
                $this->linkedin[]= $row->linkedin;
                $this->twitter[]= $row->twitter;
                $this->skype[]= $row->skype;
                $this->tax_number[]= $row->tax_number;
                $this->entity_number[]= $row->entity_number;
                $this->currency[]= $row->currency;
                $this->pmethod[]= $row->pmethod;
                $this->autologin[]= $row->autologin;
                $this->lastlogin[]= $row->lastlogin;
                $this->lastloginip[]= $row->lastloginip;
                $this->stage[]= $row->stage;
                $this->timezone[]= $row->timezone;
                $this->isp[]= $row->isp;
                $this->lat[]= $row->lat;
                $this->lon[]= $row->lon;
                $this->gname[]= $row->gname;
                $this->gid[]= $row->gid;
                $this->sid[]= $row->sid;
                $this->role[]= $row->role;
                $this->country_code[]= $row->country_code;
                $this->country_idd[]= $row->country_idd;
                $this->signed_up_by[]= $row->signed_up_by;
                $this->signed_up_ip[]= $row->signed_up_ip;
                $this->dob[]= $row->dob;
                $this->ct[]= $row->ct;
                $this->assistant[]= $row->assistant;
                $this->asst_phone[]= $row->asst_phone;
                $this->second_email[]= $row->second_email;
                $this->second_phone[]= $row->second_phone;
                $this->taxexempt[]= $row->taxexempt;
                $this->latefeeoveride[]= $row->latefeeoveride;
                $this->overideduenotices[]= $row->overideduenotices;
                $this->separateinvoices[]= $row->separateinvoices;
                $this->disableautocc[]= $row->disableautocc;
                $this->billingcid[]= $row->billingcid;
                $this->securityqid[]= $row->securityqid;
                $this->securityqans[]= $row->securityqans;
                $this->cardtype[]= $row->cardtype;
                $this->cardlastfour[]= $row->cardlastfour;
                $this->cardnum[]= $row->cardnum;
                $this->startdate[]= $row->startdate;
                $this->expdate[]= $row->expdate;
                $this->issuenumber[]= $row->issuenumber;
                $this->bankname[]= $row->bankname;
                $this->banktype[]= $row->banktype;
                $this->bankcode[]= $row->bankcode;
                $this->bankacct[]= $row->bankacct;
                $this->gatewayid[]= $row->gatewayid;
                $this->language[]= $row->language;
                $this->pwresetkey[]= $row->pwresetkey;
                $this->emailoptout[]= $row->emailoptout;
                $this->created_at[]= $row->created_at;
                $this->updated_at[]= $row->updated_at;
                $this->pwresetexpiry[]= $row->pwresetexpiry;
                $this->is_email_verified[]= $row->is_email_verified;
                $this->is_phone_veirifed[]= $row->is_phone_veirifed;
                $this->photo_id_type[]= $row->photo_id_type;
                $this->photo_id[]= $row->photo_id;
                $this->type[]= $row->type;
                $this->drive[]= $row->drive;
                $this->workspace_id[]= $row->workspace_id;
                $this->parent_id[]= $row->parent_id;
                $this->code[]= $row->code;
                $this->display_name[]= $row->display_name;
                $this->secondary_email[]= $row->secondary_email;
                $this->secondary_phone[]= $row->secondary_phone;
                $this->upokername_2[]= $row->upokername_2;
                $this->upokerid_2[]= $row->upokerid_2;
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
