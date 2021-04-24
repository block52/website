<?php
namespace crud;

use secure\Secure;
use phpformbuilder\Form;
use phpformbuilder\database\Mysql;
use common\Utils;

class ElementsFilters
{
    public $table                       = '';
    public $filters                     = array();
    public $filters_count               = 0;
    public $active_filters              = array();
    public $active_filters_from_tables  = array();
    public $active_filters_count        = 0;
    public $active_filters_select_names = array();
    public $ajax_filters                = array();

    private $debug;
    private $join_query;
    private $qry_restriction;

    /**
     * register filters and list
     * @param string $list    name of the list to filter (ex : clients)
     * @param array  $filters ; example :
     *                        $filters = array(
     *                        array(
     *                        'ajax'            =>  false,
     *                        'daterange'       =>  false,
     *                        'filter_mode'     =>  'simple',
     *                        'filter_A'        =>   'ID',
     *                        'select_label'    =>  'sous-menu',
     *                        'select_name'     =>  'dropdown_ID',
     *                        'option_text'     =>  'nav_nom + dropdown.nom',
     *                        'fields'          =>  'dropdown.ID, dropdown.nom, nav.nom AS nav_nom',
     *                        'field_to_filter' =>  'dropdown.ID',
     *                        'from'            =>  'pages, dropdown Left Join nav On dropdown.nav_ID = nav.ID',
     *                        'type'            =>  'text',
     *                        'column'          =>  2
     *                        ),
     *                        array(
     *                        ...
     *                        )
     *                        );
     */
    public function __construct($table, $filters, $join_query = '', $debug = false)
    {
        $this->debug         = $debug;
        $this->filters       = $filters;
        $this->filters_count = count($this->filters);
        $this->table         = $table;

        // ajax - reset filters on each page load
        $_SESSION['filters_ajax'] = array();

        for ($i = 0; $i < $this->filters_count; $i++) {
            $filter = $this->filters[$i];
            // ajax filter default value
            if (!isset($filter['ajax'])) {
                $filter['ajax'] = false;
                $this->filters[$i] = $filter;
            }
            // daterange default value
            if (!isset($filter['daterange'])) {
                $filter['daterange'] = false;
                $this->filters[$i] = $filter;
            }
            $filter_var = $this->table . '_filter_' . $filter['select_name'];
            // get the active filters from session to build the queries
            $this->active_filters[$i] = array();
            if (isset($_SESSION['filters-list'][$filter_var]) && $_SESSION['filters-list'][$filter_var] !== 'all' && $_SESSION['filters-list'][$filter_var] !== '') {
                $this->active_filters[$i]            = $filter;
                $this->active_filters_from_tables[]  = $filter['from_table'];
                $this->active_filters_select_names[] = $filter['select_name'];
                $this->active_filters_count ++;
            }
        }

        // join-query will be used only with filters[filter_mode = 'simple']
        // Advanced filters's join query is entered in SQL FROM settings's advanced parameters
        $this->join_query = str_replace('`', '', $join_query);
        // $this->qry_restriction = Secure::getRestrictionQuery($list, 'WHERE');
        $this->qry_restriction = '';
    }

    /**
     * create html form with selects of elements to filter
     * @param  string $form_action ex : page.php
     * @param  boolean $use_restrictions false only if request comes from generator filter test.
     * @return string form html
     */
    public function returnForm($form_action, $use_restrictions = true)
    {
        $log                  = array();
        $output               = '';
        $datetime_field_types = explode(',', DATETIME_FIELD_TYPES);
        if ($this->filters_count > 0) {
            $output .= '<div class="px-3">' . "\n";
            $attr = 'novalidate';
            if (AUTO_ENABLE_FILTERS === true) {
                $attr .= ', class=auto-enable-filters';
            }
            $form = new Form('filters-list', 'horizontal', $attr, 'bs4');
            if (isset($_POST['cancel_filters'])) {
                Form::clear('filters-list');
            }
            $form->setAction($form_action);
            $form->startFieldset();
            $db = new Mysql();
            for ($i = 0; $i < $this->filters_count; $i++) {
                $filter          = $this->filters[$i];
                $from_query      = $filter['from_table'];
                $field_var       = $this->table . '_filter_' . $filter['select_name'];
                $qry_restriction = '';
                $select_name     = $filter['select_name'];

                // if limited READ rights
                if ($use_restrictions !== false && Secure::canReadRestricted($this->table)) {
                    $qry_restriction = $this->qry_restriction;
                }

                $qry_where = $this->returnWhereQry($filter['field_to_filter']);

                // merge the join_query from the current filter and the active ones
                if (count($this->active_filters_select_names) > 0) {
                    $current_join_query = $this->mergeJoinQueries($filter);
                } else {
                    $current_join_query = implode(' ', $filter['join_queries']);
                }

                /*====================================================================================================================
                we retrieve all the filters, except the one of the current field (we filter the dropdown list according to the other fields,
                but not the field itself. e.g. if a category is chosen, we still display them all in the list.
                ====================================================================================================================== */

                if (!empty($qry_restriction)) {
                    $qry_where = str_replace('WHERE', 'AND', $qry_where);
                }
                $option_text = array();
                $option_value = array();
                $qry = 'SELECT DISTINCT ' . $filter['fields'] . ' FROM ' . $from_query . $current_join_query . $qry_restriction . $qry_where . ' ORDER BY ' . $this->getAliases($filter['fields']) . ' ASC';
                if ($this->debug === true) {
                    $log[] = array(
                    '$select_name    => ' . $select_name,
                    'from            => ' . $filter['from'],
                    'join_query      => ' . $this->join_query,
                    'qry_restriction => ' . $qry_restriction,
                    'qry_where       => ' . $qry_where,
                    '$qry            => ' . $qry
                    );
                }
                if ($filter['ajax'] === true) {
                    $_SESSION['filters_ajax'][$field_var] = array(
                        'table'           => $this->table,
                        'field_to_filter' => $filter['field_to_filter'],
                        'option_text'     => $filter['option_text'],
                        'qry'             => $qry
                    );
                    $form->addOption($field_var, 'all', DISPLAY_ALL);
                    // if an ajax field is active we get the display value from a new query
                    if (isset($_SESSION['filters-list'][$field_var]) && $_SESSION['filters-list'][$field_var] !== 'all') {
                        // var_dump($filter);
                        $where_option = ' AND ';
                        if (strpos($qry_where, 'WHERE') === false) {
                            $where_option = ' WHERE ';
                        }
                        $field_to_filter = $filter['field_to_filter'];
                        // if json values => $_SESSION['filters-list'][$field_var] = ~value~
                        if (preg_match('`^~([^~]+)~$`', $_SESSION['filters-list'][$field_var], $out)) {
                            $where_option .= 'JSON_CONTAINS(' . $this->sqlProtect($field_to_filter) . ', \'["' . $out[1] . '"]\')';
                        } else {
                            if (is_numeric($_SESSION['filters-list'][$field_var])) {
                                $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_NUMBER);
                            } else {
                                $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_TEXT);
                            }
                            $where_option .= $this->sqlProtect($field_to_filter) . ' = ' . $field_var_sqlvalue;
                        }
                        $qry_option = 'SELECT DISTINCT ' . $filter['fields'] . ' FROM ' . $from_query . $current_join_query . $qry_restriction . $qry_where . $where_option . ' LIMIT 1';
                        // var_dump($qry_option);
                        if ($db->query($qry_option) !== false) {
                            $values_count = $db->rowCount();
                            if (!empty($values_count)) {
                                if (preg_match('`[\s]?\+[\s]?`', $filter['option_text'])) {
                                    $field_text = preg_split('`[\s]?\+[\s]?`', $filter['option_text']);
                                    $field_text[0] = preg_replace('`[^.]+\.`', '', $field_text[0]);
                                    $field_text[1] = preg_replace('`[^.]+\.`', '', $field_text[1]);
                                } else {
                                    $field_text = preg_replace('`[^.]+\.`', '', $filter['option_text']);
                                }
                                $field_value = preg_replace('`[^.]+\.`', '', $filter['field_to_filter']);
                                $row = $db->row();
                                $test_if_json = json_decode($row->$field_value);
                                if (json_last_error() == JSON_ERROR_NONE && is_array($test_if_json)) {
                                    foreach ($test_if_json as $value) {
                                        if ('~' . $value . '~' === $_SESSION['filters-list'][$field_var]) {
                                            $option_text = $value;
                                            $option_value = '~' . $value . '~';
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
                                }
                                // var_dump($option_text);
                                $form->addOption($field_var, $option_value, $option_text, '', 'selected');
                            }
                        }
                    }
                    $form->addSelect($field_var, ucwords($filter['select_label']), 'class=ajax-filter form-control, data-width=100%');
                } elseif ($filter['daterange'] === true && in_array($filter['type'], $datetime_field_types)) {
                    // var_dump($qry);
                    if ($db->query($qry) === false) {
                        $output.= '<p class="text-center text-danger"><strong><em>' . ucwords($filter['select_label']) . '</em></strong>: ' . QUERY_FAILED . '</p>';
                    } else {
                        $values_count = $db->rowCount();
                        if (!empty($values_count)) {
                            $field_value = preg_replace('`[^.]+\.`', '', $filter['field_to_filter']);
                            $all_dates   = array();
                            while (!$db->endOfSeek()) {
                                $row = $db->row();
                                $all_dates[] = $row->$field_value;
                            }

                            sort($all_dates);
                            $date_min = new \DateTime($all_dates[0]);
                            $date_min = $date_min->format('Y-m-d');
                            $date_max = new \DateTime($all_dates[$values_count - 1]);
                            $date_max->add(new \DateInterval('P1D'));
                            $date_max = $date_max->format('Y-m-d');

                            $form->addInput('text', $field_var, '', ucwords($filter['select_label']), 'class=litepick, placeholder=' . DISPLAY_ALL . ', autocomplete=off, data-min-date=' . $date_min . ', data-max-date=' . $date_max);
                        }
                        $db->close();
                    }
                } else {
                    // var_dump($qry);
                    if ($db->query($qry) === false) {
                        $output.= '<p class="text-center text-danger"><strong><em>' . ucwords($filter['select_label']) . '</em></strong>: ' . QUERY_FAILED . '</p>';
                    } else {
                        $values_count = $db->rowCount();
                        if (!empty($values_count)) {
                            if (preg_match('`[\s]?\+[\s]?`', $filter['option_text'])) {
                                $field_text = preg_split('`[\s]?\+[\s]?`', $filter['option_text']);
                                $field_text[0] = preg_replace('`[^.]+\.`', '', $field_text[0]);
                                $field_text[1] = preg_replace('`[^.]+\.`', '', $field_text[1]);
                            } else {
                                $field_text = preg_replace('`[^.]+\.`', '', $filter['option_text']);
                            }
                            $field_value = preg_replace('`[^.]+\.`', '', $filter['field_to_filter']);
                            $used_values = array();
                            while (!$db->endOfSeek()) {
                                $row = $db->row();
                                $test_if_json = json_decode($row->$field_value);
                                if (json_last_error() == JSON_ERROR_NONE && is_array($test_if_json)) {
                                    foreach ($test_if_json as $value) {
                                        if (!in_array($value, $used_values)) {
                                            $option_text [] = $value;
                                            $option_value[] = '~' . $value . '~';
                                            $used_values [] = $value;
                                        }
                                    }
                                } else {
                                    if (is_array($field_text)) {
                                        $f0 = $field_text[0];
                                        $f1 = $field_text[1];
                                        $option_text[] = $row->$f0 . '/' . $row->$f1;
                                    } else {
                                        $option_text[] = $row->$field_text;
                                    }
                                    $option_value[] = $row->$field_value;
                                }
                            }

                            $values_count = count($option_value);

                            for ($j = - 1; $j < $values_count; $j++) {
                                if ($j == - 1) {
                                    $form->addOption($field_var, 'all', DISPLAY_ALL);
                                } elseif ($filter['type'] == 'text' || $filter['type'] == 'datetime') {
                                    $op_txt = $option_text[$j];
                                    if (empty($op_txt)) {
                                        $op_txt = '-';
                                    }
                                    $form->addOption($field_var, $option_value[$j], $op_txt);
                                }
                            }
                            if ($filter['type'] == 'boolean') {
                                if (in_array('1', $option_value)) {
                                    $form->addOption($field_var, '1', YES);
                                }
                                if (in_array('0', $option_value)) {
                                    $form->addOption($field_var, '0', NO);
                                }
                            }
                            $form->addSelect($field_var, ucwords($filter['select_label']), 'class=select2 form-control, data-width=100%');
                        }
                        $db->close();
                    }
                }
            }

            // reset then add buttons
            $form->centerButtons(true);
            $form->setCols(0, 12);
            $form->addHtml('<span class="d-block mb-4"></span>');
            $form->addBtn('submit', 'cancel_filters', 1, '<i class="' . ICON_RESET . ' position-left"></i>' . RESET, 'class=btn btn-sm btn-warning legitRipple', 'btns');
            $form->addBtn('submit', 'submit_filters', 1, '<i class="' . ICON_FILTER . ' position-left"></i>' . FILTER, 'class=btn btn-sm btn-primary legitRipple', 'btns');
            $form->printBtnGroup('btns');
            $form->endFieldset();
            $output.= $form->render(false, false);
            $output.= '</div>' . "\n";
        }

        if ($this->debug === true) {
            if (!empty($log)) {
                $content = array();
                foreach ($log as $array) {
                    $content[] = implode('<br>', $array);
                }
                $this->userMessage('<span class="badge badge-primary prepend">LOG OUTPUT</span>returnForm()', 'panel-default m-5', 'close', implode('<br><br>', $content));
            }
        }

        return $output;
    }

    /**
     * build filtered elements
     * @param  string $current_select
     * @return string the filtered elements query
     */
    public function buildElementJoinQuery()
    {
        $log = array();
        $joins = array(
        'join_queries' => array(),
        'from_table'   => array()
        );
        $final_join_queries_1 = array();
        $final_join_queries_2 = array();
        $final_join_queries   = array();
        foreach ($this->active_filters as $key => $active_filter) {
            if (!empty($active_filter)) {
                $active_filter_join_queries_count = count($active_filter['join_queries']);
                for ($i=0; $i < $active_filter_join_queries_count; $i++) {
                    if (!empty($active_filter['join_queries'])) {
                        $joins['join_queries'][] = $active_filter['join_queries'][$i];
                        $joins['origin_table'][]   = $active_filter['from_table'];
                    }
                }
            }
        }

        // if the table joined is the element table we have to invert the joined table

       /* WRONG
        FROM actor
        INNER JOIN film_actor ON film_actor.film_id = film.film_id =>INNER JOIN film ON film.film_id = film_actor.film_id
        INNER JOIN actor ON film_actor.actor_id =actor.actor_id

        OK
        FROM actor
        INNER JOIN film_actor ON film_actor.actor_id =actor.actor_id
        INNER JOIN film ON film.film_id = film_actor.film_id
        */

        $join_type         = array();
        $joined_table      = array();
        $left_equal_table  = array();
        $left_equal_field  = array();
        $right_equal_table = array();
        $right_equal_field = array();

        $joins_count = count($joins['join_queries']);
        for ($i=0; $i < $joins_count; $i++) {
            if (preg_match('`(LEFT|INNER|RIGHT) JOIN ([a-zA-Z_]+) ON ([a-zA-Z_]+).([a-zA-Z_]+)(?:[\s]*=[\s]*)([a-zA-Z_]+).([a-zA-Z_]+)`', $joins['join_queries'][$i], $out)) {
                $join_type[]         = $out[1];
                $joined_table[]      = $out[2];
                $left_equal_table[]  = $out[3];
                $left_equal_field[]  = $out[4];
                $right_equal_table[] = $out[5];
                $right_equal_field[] = $out[6];
            } else {
                // ERROR
                $log[] = array('Malformed JOIN query');
            }
        }

        // add the Element join queries to the filter joins
        // $this->join_query = ' LEFT JOIN `types` ON `articles`.`types_ID`=`types`.`ID` LEFT JOIN `marques` ON `articles`.`marques_ID`=`marques`.`ID`';
            /*
            $out = array(
                0 =>
                  array (size=2)
                    0 => string 'LEFT JOIN types ON articles.types_ID=types.ID' (length=45)
                    1 => string 'LEFT JOIN marques ON articles.marques_ID=marques.ID' (length=51)
                1 =>
                  array (size=2)
                    0 => string 'LEFT' (length=4)
                    1 => string 'LEFT' (length=4)
                2 =>
                  array (size=2)
                    0 => string 'types' (length=5)
                    1 => string 'marques' (length=7)
                3 =>
                  array (size=2)
                    0 => string 'articles' (length=8)
                    1 => string 'articles' (length=8)
                4 =>
                  array (size=2)
                    0 => string 'types_ID' (length=8)
                    1 => string 'marques_ID' (length=10)
                5 =>
                  array (size=2)
                    0 => string 'types' (length=5)
                    1 => string 'marques' (length=7)
                6 =>
                  array (size=2)
                    0 => string 'ID' (length=2)
                    1 => string 'ID' (length=2)
            }
            */
        if (preg_match_all('`(LEFT|INNER|RIGHT) JOIN ([a-zA-Z_]+) ON ([a-zA-Z_]+).([a-zA-Z_]+)(?:[\s]*=[\s]*)([a-zA-Z_]+).([a-zA-Z_]+)`', $this->join_query, $out)) {
            $element_joins_count = count($out[0]);

            for ($i=0; $i < $element_joins_count; $i++) {
                $join_type[]         = $out[1][$i];
                $joined_table[]      = $out[2][$i];
                $left_equal_table[]  = $out[3][$i];
                $left_equal_field[]  = $out[4][$i];
                $right_equal_table[] = $out[5][$i];
                $right_equal_field[] = $out[6][$i];
            }
        }

        // each left table MUST BE UNIQUE AND MUST NOT BE THE MAIN QUERY TABLE (ie $this->table)
        $used_left_tables   = array($this->table);
        $final_join_queries = array();
        $joins_count        = count($join_type);

        // 1st loop: register joins which use $this->table
        for ($i=0; $i < $joins_count; $i++) {
            if ($left_equal_table[$i] == $this->table || $right_equal_table[$i] == $this->table) {
                $case = 'SKIP';
                if ($right_equal_table[$i] == $this->table && !in_array($left_equal_table[$i], $used_left_tables)) {
                    $invert_query = false;
                    $used_left_tables[] = $left_equal_table[$i];
                    $case = '[ORIGINAL JOIN] - ';
                } elseif ($left_equal_table[$i] == $this->table && !in_array($right_equal_table[$i], $used_left_tables)) {
                    $invert_query = true;
                    $used_left_tables[] = $right_equal_table[$i];
                    $case = '[INVERTED JOIN] - ';
                }

                if ($case != 'SKIP') {
                    $new_join_query = $this->formatJoinQuery($join_type[$i], $left_equal_table[$i], $left_equal_field[$i], $right_equal_table[$i], $right_equal_field[$i], $invert_query);

                    $final_join_queries[] = $new_join_query;

                    if ($this->debug === true) {
                        $log[] = array($case . $this->table . '<br>' . $new_join_query . '<br>--------------<br>');
                    }
                }
            }
        }

        // 2nd loop: register joins which don't use $this->table
        for ($i=0; $i < $joins_count; $i++) {
            if ($left_equal_table[$i] != $this->table && $right_equal_table[$i] != $this->table) {
                $case = 'SKIP';
                if (!in_array($left_equal_table[$i], $used_left_tables)) {
                    $invert_query = false;
                    $used_left_tables[] = $left_equal_table[$i];
                    $case = '[ORIGINAL JOIN] - ';
                } elseif (!in_array($right_equal_table[$i], $used_left_tables)) {
                    $invert_query = true;
                    $used_left_tables[] = $right_equal_table[$i];
                    $case = '[INVERTED JOIN] - ';
                }

                if ($case != 'SKIP') {
                    $new_join_query = $this->formatJoinQuery($join_type[$i], $left_equal_table[$i], $left_equal_field[$i], $right_equal_table[$i], $right_equal_field[$i], $invert_query);

                    $final_join_queries[] = $new_join_query;

                    if ($this->debug === true) {
                        $log[] = array($case . $this->table . '<br>' . $new_join_query . '<br>--------------<br>');
                    }
                }
            }
        }

        $final_join_queries = array_filter(array_unique($final_join_queries));

        if ($this->debug === true) {
            if (!empty($final_join_queries)) {
                $log[] = $final_join_queries;
            } else {
                $log[] = array('ELEMENT JOIN QUERY IS EMPTY');
            }

            if (!empty($log)) {
                $content = array();
                foreach ($log as $array) {
                    $content[] = implode('<br>', $array);
                }
                $this->userMessage('<span class="badge badge-primary prepend">LOG OUTPUT</span>buildElementJoinQuery()', 'panel-default m-5', 'close', implode('<br><br>', $content));
            }
        }

        return implode(' ', $final_join_queries);
    }

    /**
     * build filtered elements
     * @param  string $current_select
     * @return string the filtered elements query
     */
    public function returnWhereQry($current_field = '')
    {
        $qry_where = '';
        $filtered_columns = array();
        $i = 0;
        foreach ($this->filters as $filter) {
            $select_label    = $filter['select_label'];
            $select_name     = $filter['select_name'];
            $option_text     = $filter['option_text'];
            $fields          = $filter['fields'];
            $field_to_filter = $filter['field_to_filter'];
            $from            = $filter['from'];
            $daterange       = $filter['daterange'];
            $type            = $filter['type'];
            $column          = $filter['column'];

            $field_var = $this->table . '_filter_' . $select_name;
            if (!isset($_SESSION['filters-list'][$field_var]) || (empty($_SESSION['filters-list'][$field_var]) && $_SESSION['filters-list'][$field_var] !== (int) 0)) {
                $_SESSION['filters-list'][$field_var] = 'all';
            }
            // echo $field_var . ' => ' . $_SESSION['filters-list'][$field_var] . '<br>';
            // echo $field_to_filter . ' => ' . $current_field . '<br>';
            if ($_SESSION['filters-list'][$field_var] != 'all' && $field_to_filter != $current_field) {
                if (!isset($transition)) {
                    $transition = ' WHERE ';
                } else {
                    $transition = ' AND ';
                }

                $datetime_field_types = explode(',', DATETIME_FIELD_TYPES);

                // if json values => $_SESSION['filters-list'][$field_var] = ~value~
                if (preg_match('`^~([^~]+)~$`', $_SESSION['filters-list'][$field_var], $out)) {
                    $qry_where.= $transition . 'JSON_CONTAINS(' . $this->sqlProtect($field_to_filter) . ', \'["' . $out[1] . '"]\')';
                } elseif (in_array($type, $datetime_field_types) && boolval($daterange) === true) {
                    $range_dates = explode(' - ', $_SESSION['filters-list'][$field_var]);
                    if (count($range_dates) === 2) {
                        $min_date_sqlvalue = Mysql::sqlValue($range_dates[0], Mysql::SQLVALUE_DATE);
                        $max_date_sqlvalue = Mysql::sqlValue($range_dates[1], Mysql::SQLVALUE_DATE);
                        $qry_where.= $transition . '(' . $this->sqlProtect($field_to_filter) . ' >= ' . $min_date_sqlvalue;
                        $qry_where.= ' AND ' . $this->sqlProtect($field_to_filter) . ' <= ' . $max_date_sqlvalue . ')';
                    }
                } else {
                    if (is_numeric($_SESSION['filters-list'][$field_var])) {
                        $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_NUMBER);
                    } else {
                        $field_var_sqlvalue = Mysql::sqlValue($_SESSION['filters-list'][$field_var], Mysql::SQLVALUE_TEXT);
                    }
                    $qry_where.= $transition . $this->sqlProtect($field_to_filter) . ' = ' . $field_var_sqlvalue;
                }
                if (empty($current_field)) {
                    if (ADMIN_ACTION_BUTTONS_POSITION === 'left') {
                        $filtered_columns[] = $column + 1;
                    } else {
                        $filtered_columns[] = $column;
                    }
                }
            }
            $i++;
        }
        if (empty($current_field)) {
            $_SESSION['filtered_columns'] = $filtered_columns;
        }
        return $qry_where;
    }

    /**
     * build the JOIN query
     * @param  syting  $join_type         LEFT|INNER
     * @param  syting  $left_equal_table
     * @param  syting  $left_equal_field
     * @param  syting  $right_equal_table
     * @param  syting  $right_equal_field
     * @param  boolean $invert            invert left/right terms if true
     * @return string                     the join query for SQL
     */
    private function formatJoinQuery($join_type, $left_equal_table, $left_equal_field, $right_equal_table, $right_equal_field, $invert = false)
    {
        if ($invert == false) {
            $join_query = ' ' . $join_type . ' JOIN ' . $this->sqlProtect($left_equal_table) . ' ON ' . $this->sqlProtect($left_equal_table . '.' . $left_equal_field) .  ' = ' . $this->sqlProtect($right_equal_table . '.' . $right_equal_field);
        } else {
            $join_query = ' ' . ' ' . $join_type . ' JOIN ' . $this->sqlProtect($right_equal_table) . ' ON ' . $this->sqlProtect($right_equal_table . '.' . $right_equal_field) .  ' = ' . $this->sqlProtect($left_equal_table . '.' . $left_equal_field);
        }
        return $join_query;
    }

    private function getAliases($fields) {
        $fields_array = explode(',', $fields);
        $output = array();
        foreach ($fields_array as $field) {
            $trimmed = trim($field);
            if (preg_match('`^[a-zA-Z0-9._ \']+ AS ([a-zA-Z 0-9_]+)$`', $trimmed, $out)) {
                $output[] = $out[1];
            } else {
                $output[] = $trimmed;
            }
        }

        return implode(', ', $output);
    }

    /**
     * merge and order the join queries from the current filter and the active ones
     * @param array the current filter joins
     * @return sql the final JOIN query for the current filter
     */
    private function mergeJoinQueries($filter)
    {
        $log = array();
        $joins = array(
        'join_queries' => array(),
        'from_table'   => array()
        );
        $final_join_queries_1 = array();
        $final_join_queries_2 = array();
        $final_join_queries   = array();
        if (!empty($filter)) {
            $filter_join_queries_count = count($filter['join_queries']);
            for ($i=0; $i < $filter_join_queries_count; $i++) {
                if (!empty($filter['join_queries'])) {
                    $joins['join_queries'][] = $filter['join_queries'][$i];
                    $joins['origin_table'][]   = $filter['from_table'];
                }
            }
        }
        foreach ($this->active_filters as $key => $active_filter) {
            if (!empty($active_filter) && $active_filter['select_name'] != $filter['select_name']) {
                $active_filter_join_queries_count = count($active_filter['join_queries']);
                for ($i=0; $i < $active_filter_join_queries_count; $i++) {
                    if (!empty($active_filter['join_queries'])) {
                        $joins['join_queries'][] = $active_filter['join_queries'][$i];
                        $joins['origin_table'][]   = $active_filter['from_table'];
                    }
                }
            }
        }

        // if the table joined is the filter table we have to invert the joined table
        // => $from_table is replaced with left equal table
        // ie: actor query with films filtered

       /* WRONG
        FROM actor
        INNER JOIN film_actor ON film_actor.film_id = film.film_id =>INNER JOIN film ON film.film_id = film_actor.film_id
        INNER JOIN actor ON film_actor.actor_id =actor.actor_id

        OK
        FROM actor
        INNER JOIN film_actor ON film_actor.actor_id =actor.actor_id
        INNER JOIN film ON film.film_id = film_actor.film_id
        */

        $join_type         = array();
        $joined_table      = array();
        $left_equal_table  = array();
        $left_equal_field  = array();
        $right_equal_table = array();
        $right_equal_field = array();

        $joins_count = count($joins['join_queries']);

        if ($this->debug === true) {
            $log[] = array(
            '<br><br>
                /* =============================================<br>
                    FILTER ' . $filter['from_table'] . '<br>
                ============================================= */<br>
                '
            );
        }
        for ($i=0; $i < $joins_count; $i++) {
            if (preg_match('`(LEFT|INNER|RIGHT) JOIN ([a-zA-Z_]+) ON ([a-zA-Z_]+).([a-zA-Z_]+)(?:[\s]*=[\s]*)([a-zA-Z_]+).([a-zA-Z_]+)`', $joins['join_queries'][$i], $out)) {
                $join_type[]         = $out[1];
                $joined_table[]      = $out[2];
                $left_equal_table[]  = $out[3];
                $left_equal_field[]  = $out[4];
                $right_equal_table[] = $out[5];
                $right_equal_field[] = $out[6];
            } else {
                // ERROR
                $log[] = array('Malformed JOIN query');
            }
        }

        // each left table MUST BE UNIQUE AND MUST NOT BE THE MAIN QUERY TABLE (ie $filter['from_table'])
        $used_left_tables   = array($filter['from_table']);
        $final_join_queries = array();
        $joins_count        = count($join_type);

        // 1st loop: register joins which use $filter['from_table']
        for ($i=0; $i < $joins_count; $i++) {
            if ($left_equal_table[$i] == $filter['from_table'] || $right_equal_table[$i] == $filter['from_table']) {
                $case = 'SKIP';
                if ($right_equal_table[$i] == $filter['from_table'] && !in_array($left_equal_table[$i], $used_left_tables)) {
                    $invert_query = false;
                    $used_left_tables[] = $left_equal_table[$i];
                    $case = '[ORIGINAL JOIN] - ';
                } elseif ($left_equal_table[$i] == $filter['from_table'] && !in_array($right_equal_table[$i], $used_left_tables)) {
                    $invert_query = true;
                    $used_left_tables[] = $right_equal_table[$i];
                    $case = '[INVERTED JOIN] - ';
                }

                if ($case != 'SKIP') {
                    $new_join_query = $this->formatJoinQuery($join_type[$i], $left_equal_table[$i], $left_equal_field[$i], $right_equal_table[$i], $right_equal_field[$i], $invert_query);

                    $final_join_queries[] = $new_join_query;

                    if ($this->debug === true) {
                        $log[] = array($case . $filter['from_table'] . '<br>' . $new_join_query . '<br>--------------<br>');
                    }
                }
            }
        }

        // 2nd loop: register joins which don't use $filter['from_table']
        for ($i=0; $i < $joins_count; $i++) {
            if ($left_equal_table[$i] != $filter['from_table'] && $right_equal_table[$i] != $filter['from_table']) {
                $case = 'SKIP';
                if (!in_array($left_equal_table[$i], $used_left_tables)) {
                    $invert_query = false;
                    $used_left_tables[] = $left_equal_table[$i];
                    $case = '[ORIGINAL JOIN] - ';
                } elseif (!in_array($right_equal_table[$i], $used_left_tables)) {
                    $invert_query = true;
                    $used_left_tables[] = $right_equal_table[$i];
                    $case = '[INVERTED JOIN] - ';
                }

                if ($case != 'SKIP') {
                    $new_join_query = $this->formatJoinQuery($join_type[$i], $left_equal_table[$i], $left_equal_field[$i], $right_equal_table[$i], $right_equal_field[$i], $invert_query);

                    $final_join_queries[] = $new_join_query;

                    if ($this->debug === true) {
                        $log[] = array($case . $filter['from_table'] . '<br>' . $new_join_query . '<br>--------------<br>');
                    }
                }
            }
        }

        $final_join_queries = array_filter(array_unique($final_join_queries));

        if ($this->debug === true) {
            if (!empty($final_join_queries)) {
                $log[] = array_merge(array('FINAL JOIN QUERIES:'), $final_join_queries);
            } else {
                $log[] = array('EMPTY JOIN QUERY');
            }

            if (!empty($log)) {
                $content = array();
                foreach ($log as $array) {
                    $content[] = implode('<br>', $array);
                }
                $this->userMessage('<span class="badge badge-primary prepend">LOG OUTPUT</span>mergeJoinQueries()', 'panel-default m-5', 'close', implode('<br><br>', $content));
            }
        }

        return implode(' ', $final_join_queries);
    }

    /**
     * used in generator to test filter query
     * @return string     sql query
     */
    public function showQuery()
    {
        $filter      = $this->filters[0];
        $select_name = $filter['select_name'];
        $qry_where   = $this->returnWhereQry($select_name);
        $qry         = 'SELECT DISTINCT ' . $filter['fields'] . ' FROM ' . $filter['from'] . $qry_where;

        return $qry;
    }

    /**
     * Register filtered elements in session
     * @param  string $list name of the list to filter (ex : clients)
     * @return void
     */
    public static function register($list)
    {
        if (isset($_SESSION['filters-list'])) {
            if (isset($_POST['cancel_filters'])) {
                foreach ($_SESSION['filters-list'] as $key => $value) {
                    if (preg_match('`' . $list . '_filter_`', $key)) {
                        unset($_SESSION['filters-list'][$key]);
                    }
                }
                $_SESSION['filtered_columns'] = '';
            } else {
                foreach ($_POST as $key => $value) {
                    if (preg_match('`_filter_`', $key)) {
                        $_SESSION['filters-list'][$key] = $value;
                    }
                }
            }
        }
    }

    /**
     * protect a field with ` for sql query
     * @param  string $field
     * @return string
     */
    private function sqlProtect($field)
    {
        return '`' . str_replace('.', '`.`', $field) . '`';
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
        if (!empty($content)) {
            // panel
            echo Utils::alertCard($title, $classname, '', $heading_elements, $content);
        } else {
            // alert
            echo Utils::alert($title, $classname);
        }
    }
}
