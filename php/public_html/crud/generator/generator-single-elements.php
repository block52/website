<?php
use phpformbuilder\Form;
use phpformbuilder\database\Mysql;
use common\Utils;

session_start();
include_once '../conf/conf.php';

if (!isset($_SESSION['db_list'])) {
    $qry = "SHOW DATABASES";
    $db = new Mysql();
    $array = $db->queryArray($qry);
    $_SESSION['db_count'] = $db->rowCount();
    if (!empty($_SESSION['db_count'])) {    // SI LA REQUETE N'EST PAS VIDE
        for ($index = 0; $index<$_SESSION['db_count']; $index++) {
            $row = $db->row($index);
            $db_list[] = $array[$index][0];
        }
    }
    $_SESSION['db_list'] = $db_list;
}
$form_select_db = new form('form-select-db', 'inline');
for ($i = 0; $i<$_SESSION['db_count']; $i++) {
    $form_select_db->addOption('database', $_SESSION['db_list'][$i], $_SESSION['db_list'][$i]);
}
if (isset($_POST['database'])) {
    $_SESSION['database'] = $_POST['database'];
    $_SESSION['table'] = '';
}
if (isset($_POST['table'])) {
    $_SESSION['table'] = $_POST['table'];
}
$form_select_db->addSelect('database', 'database : ');
$form_select_db->addBtn('submit', 'submit', 1, 'submit', 'class=btn btn-sm btn-primary');
if (isset($_SESSION['database'])) {
    $db = new Mysql();
    $db->selectDatabase($_SESSION['database']);
    $tables = $db->getTables();
    if (empty($_SESSION['table'])) {
        $_SESSION['table'] = $tables[0];
    }
    $form_select_table = new form('form-select-table', 'inline');
    foreach ($tables as $table) {
        $form_select_table->addOption('table', $table, $table);
    }
    $form_select_table->addSelect('table', 'table : ');
    $form_select_table->addBtn('submit', 'submit', 1, 'submit', 'class=btn btn-sm btn-primary');
}
if (isset($_SESSION['table'])) {
    $db = new Mysql();
    $db->selectDatabase($_SESSION['database']);
    $columns = $db->getColumnNames($_SESSION['table']);
    $form_select_fields = new form('form-select-fields');
    $form_select_fields->setAction($_SERVER['REQUEST_URI'] . '#msg');

    /*=====================================

        UNCHECK ALL

    =====================================*/

    Form::clear('form_select_fields');

    foreach ($columns as $column_name) {
        $form_select_fields->addOption('fields_select[]', $column_name, $column_name);
    }
    $form_select_fields->startFieldset('Qry Select');
    $form_select_fields->addSelect('fields_select[]', 'champs : ', 'multiple=multiple');
    $form_select_fields->addCheckbox('group1', 'build Select Query', 'build_select_query');
    $form_select_fields->addCheckbox('group1', 'build Select Query with Pagination', 'build_select_query_pagination');
    $form_select_fields->addCheckbox('group1', 'build Select Query with Pagination and Filters', 'build_select_query_filters');
    $form_select_fields->printCheckboxGroup('group1', '', false);
    $form_select_fields->endFieldset();
    $form_select_fields->startFieldset('Qry Insert | Qry Update');
    $form_select_fields->addCheckbox('group2', 'build Public $', 'build_public_dollar');
    $form_select_fields->addCheckbox('group2', 'build Qry Insert', 'build_qry_insert');
    $form_select_fields->addCheckbox('group2', 'build Qry Update', 'build_qry_update');
    $form_select_fields->printCheckboxGroup('group2', '', false);
    $form_select_fields->addInput('text', 'update_filter', '', 'field to filter update : ', 'size=30');
    $form_select_fields->endFieldset();
    $form_select_fields->startFieldset('Database');
    $form_select_fields->addCheckbox('group3', 'build Db Insert', 'build_db_insert');
    $form_select_fields->addCheckbox('group3', 'build Db Insert with 1 image', 'build_db_insert_one_image');
    $form_select_fields->addCheckbox('group3', 'build Db Insert with several images', 'build_db_insert_several_images');
    $form_select_fields->addCheckbox('group3', 'build Db Update', 'build_db_update');
    $form_select_fields->addCheckbox('group3', 'build Db Update with 1 image', 'build_db_update_one_image');
    $form_select_fields->addCheckbox('group3', 'build Db Update with several images', 'build_db_update_several_images');
    $form_select_fields->addCheckbox('group3', 'build Db Delete', 'build_db_delete');
    $form_select_fields->addCheckbox('group3', 'build Db Delete with 1 image', 'build_db_delete_one_image');
    $form_select_fields->addCheckbox('group3', 'build Db Delete with several images', 'build_db_delete_several_images');
    $form_select_fields->addCheckbox('group3', 'build Db Sorting', 'build_db_sorting');
    $form_select_fields->printCheckboxGroup('group3', '', false);
    $form_select_fields->endFieldset();
    $form_select_fields->startFieldset('Form Delete | Form Sorting');
    $form_select_fields->addCheckbox('group4', 'build Delete Form', 'build_delete_form');
    $form_select_fields->addCheckbox('group4', 'build Sorting Form', 'build_sorting_form');
    $form_select_fields->printCheckboxGroup('group4', '', false);
    $form_select_fields->endFieldset();

    /*__________ SELECT LIST _________________*/

    $form_select_fields->addCheckbox('build_list', 'build List', 'build_list');
    $form_select_fields->printCheckboxGroup('build_list', '');
    $form_select_fields->html .= '<div class="slide-div" id="list-options">' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-2', 'horizontalOffsetCol' => 'col-sm-offset-2', 'horizontalElementCol' => 'col-sm-10'));
    $form_select_fields->addRadio('open_url_btn', 'yes', true);
    $form_select_fields->addRadio('open_url_btn', 'no', false);
    $form_select_fields->printRadioGroup('open_url_btn', '"open url" button : ');
    $form_select_fields->addRadio('export_btn', 'yes', true);
    $form_select_fields->addRadio('export_btn', 'no', false);
    $form_select_fields->printRadioGroup('export_btn', '"export (xls/csv)" button : ');
    foreach ($columns as $column_name) {
        $form_select_fields->addCheckbox('field_type' . $column_name, 'text/number', 'text' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'image', 'image' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'boolean', 'boolean' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'skip this field', 'skip_this_field' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'enable_sorting', 'sorting' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'jedit text', 'jedit_text' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'jedit textarea', 'jedit_textarea' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'jedit select', 'jedit_select' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'jedit date', 'jedit_date' . $column_name);
        $form_select_fields->addCheckbox('field_type' . $column_name, 'nested-table', 'nested_table' . $column_name);
        $form_select_fields->printCheckboxGroup('field_type' . $column_name, $column_name);
    }
    $form_select_fields->html .= '</div><!-- #list-options -->' . "\n";

    /*__________ LISTE VERTICALE ADMIN _________________*/

    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-4', 'horizontalOffsetCol' => 'col-sm-offset-4', 'horizontalElementCol' => 'col-sm-8'));
    $form_select_fields->addCheckbox('build_vertical_list', 'Build Vertical List', 'build_vertical_list');
    $form_select_fields->printCheckboxGroup('build_vertical_list', '');
    $form_select_fields->html .= '<div class="slide-div" id="vertical-list-options">' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-3', 'horizontalOffsetCol' => 'col-sm-offset-3', 'horizontalElementCol' => 'col-sm-9'));
    $form_select_fields->addRadio('show_previous_next_link', 'yes', true);
    $form_select_fields->addRadio('show_previous_next_link', 'no', false);
    $form_select_fields->printRadioGroup('show_previous_next_link', 'show Previous / Next link : ');
    foreach ($columns as $column_name) {
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'text/number', 'text' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'image', 'image' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'boolean', 'boolean' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'skip this field', 'skip_this_field' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'enable_sorting', 'sorting' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'jedit text', 'jedit_text' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'jedit textarea', 'jedit_textarea' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'jedit select', 'jedit_select' . $column_name);
        $form_select_fields->addCheckbox('field_type_vl' . $column_name, 'jedit date', 'jedit_date' . $column_name);
        $form_select_fields->printCheckboxGroup('field_type_vl' . $column_name, $column_name);
    }
    $form_select_fields->html .= '</div><!-- #vertical-list-options -->' . "\n";

    /*__________ FORM AJOUT ADMIN _________________*/

    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-4', 'horizontalOffsetCol' => 'col-sm-offset-4', 'horizontalElementCol' => 'col-sm-8'));
    $form_select_fields->addCheckbox('build_add_form', 'Build Add Form', 'build_add_form');
    $form_select_fields->printCheckboxGroup('build_add_form', '');
    $form_select_fields->html .= '<div class="slide-div" id="add-form-options">' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-2', 'horizontalOffsetCol' => 'col-sm-offset-2', 'horizontalElementCol' => 'col-sm-10'));
    foreach ($columns as $column_name) {
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'input', 'input' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'textarea', 'textarea' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'select', 'select' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'radio', 'radio' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'image', 'image' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'date', 'date' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'hidden', 'hidden' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'required', 'required' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'tooltip', 'tooltip' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'char_count', 'char_count' . $column_name);
        $form_select_fields->addCheckbox('field_type_af' . $column_name, 'tinyMce', 'tinyMce' . $column_name);
        $form_select_fields->printCheckboxGroup('field_type_af' . $column_name, $column_name);
    }
    $form_select_fields->html .= '</div><!-- #add-form-options -->' . "\n";

    /*__________ FORM MODIF ADMIN _________________*/

    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-4', 'horizontalOffsetCol' => 'col-sm-offset-4', 'horizontalElementCol' => 'col-sm-8'));
    $form_select_fields->addCheckbox('build_update_form', 'Build Update Form', 'build_update_form');
    $form_select_fields->printCheckboxGroup('build_update_form', '', 1);
    $form_select_fields->html .= '<div class="slide-div" id="update-form-options">' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-2', 'horizontalOffsetCol' => 'col-sm-offset-2', 'horizontalElementCol' => 'col-sm-10'));
    foreach ($columns as $column_name) {
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'input', 'input' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'textarea', 'textarea' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'select', 'select' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'radio', 'radio' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'image', 'image' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'date', 'date' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'hidden', 'hidden' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'required', 'required' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'tooltip', 'tooltip' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'char_count', 'char_count' . $column_name);
        $form_select_fields->addCheckbox('field_type_FM' . $column_name, 'tinyMce', 'tinyMce' . $column_name);
        $form_select_fields->printCheckboxGroup('field_type_FM' . $column_name, $column_name);
    }
    $form_select_fields->html .= '</div><!-- #update-form-options -->' . "\n";

    /*__________ DEPENDANT SELECT _________________*/

    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-4', 'horizontalOffsetCol' => 'col-sm-offset-4', 'horizontalElementCol' => 'col-sm-8'));
    $form_select_fields->addCheckbox('build_dependant_select', 'Afficher Dependent Select', 'build_dependant_select');
    $form_select_fields->printCheckboxGroup('build_dependant_select', '');
    $form_select_fields->html .= '<div class="slide-div" id="dependant-select-options">' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-3', 'horizontalOffsetCol' => 'col-sm-offset-3', 'horizontalElementCol' => 'col-sm-9'));
    $tables = $db->getTables();
    foreach ($tables as $table) {
        $form_select_fields->addOption('select_1_table', $table, $table);
    }
    $form_select_fields->addSelect('select_1_table', 'select 1 table : ');
    $form_select_fields->addInput('text', 'select_1_field_name', '', 'select 1 field name : ');
    $form_select_fields->addInput('text', 'select_1_label', '', 'select 1 label : ');
    $form_select_fields->addInput('text', 'select_1_field_value', '', 'select 1 field value : ');
    foreach ($tables as $table) {
        $form_select_fields->addOption('select_2_table', $table, $table);
    }
    $form_select_fields->addSelect('select_2_table', 'select 2 table : ');
    $form_select_fields->addInput('text', 'select_2_field_name', '', 'select 2 field name : ');
    $form_select_fields->addInput('text', 'select_2_label', '', 'select 2 label : ');
    $form_select_fields->addInput('text', 'select_2_field_value', '', 'select 2 field value : ');
    $form_select_fields->html .= '</div><!-- #admin-list-options -->' . "\n";
    $form_select_fields->setOptions(array('horizontalLabelCol' => 'col-sm-4', 'horizontalOffsetCol' => 'col-sm-offset-4', 'horizontalElementCol' => 'col-sm-8'));
    $form_select_fields->addBtn('submit', 'submit', 1, 'submit', 'class=btn btn-primary');
    $form_select_fields->addPlugin('icheck', 'input', 'default', array('%theme%' => 'square', '%color%' => 'purple'));
}

if (isset($_POST['form-select-fields'])) {
    $table = $_SESSION['table'];
    if (empty($_POST['fields_select'])) {
        $db = new Mysql();
        $db->selectDatabase($_SESSION['database']);
        $fields_list = $db->getColumnNames($_SESSION['table']);
    } else {
        $fields_list = $_POST['fields_select'];
    }
    $fields_count = count($fields_list);

    // build_public_dollar
    if (isset($_POST['group2']) && in_array('build_public_dollar', $_POST['group2'])) {
        ob_start();
        include_once 'generator-templates/public_dollar.php';
        $output_public_dollar = ob_get_contents();
    }

    // build_select_query
    if (isset($_POST['group1']) && in_array('build_select_query', $_POST['group1'])) {
        ob_start();
        include_once 'generator-templates/select_query.php';
        $output_select = ob_get_contents();
        ob_end_clean();
    }

    // build_select_query_pagination
    if (isset($_POST['group1']) && in_array('build_select_query_pagination', $_POST['group1'])) {
        ob_start();
        include_once 'generator-templates/select_query_pagination.php';
        $output_select_pagination = ob_get_contents();
        ob_end_clean();
    }
    if (isset($_POST['group1']) && in_array('build_select_query_filters', $_POST['group1'])) {
        $output_qry_filters = '        /*________ CONSTRUCT ________*/' . " \n\n";
        $output_qry_filters .= '$filters = array(' . "\n";
        $output_qry_filters .= '            array(' . "\n";
        $output_qry_filters .= '                \'select_label\'    =>  \'menu\',' . "\n";
        $output_qry_filters .= '                \'select_name\'     =>  \'nav_ID\',' . "\n";
        $output_qry_filters .= '                \'option_text\'     =>  \'nav.nom\',' . "\n";
        $output_qry_filters .= '                \'fields\'          =>  \'nav.ID, nav.nom\',' . "\n";
        $output_qry_filters .= '                \'field_to_filter\' =>  \'nav.ID\',' . "\n";
        $output_qry_filters .= '                \'from\'            =>  \'pages, dropdown Left Join nav On dropdown.nav_ID = nav.ID\',' . "\n";
        $output_qry_filters .= '                \'type\'            =>  \'text\',' . "\n";
        $output_qry_filters .= '                \'column\'          =>  1' . "\n";
        $output_qry_filters .= '            ),' . "\n";
        $output_qry_filters .= '            array(' . "\n";
        $output_qry_filters .= '                \'select_label\'    =>  \'sous-menu\',' . "\n";
        $output_qry_filters .= '                \'select_name\'     =>  \'dropdown_ID\',' . "\n";
        $output_qry_filters .= '                \'option_text\'     =>  \'nav_nom + dropdown.nom\',' . "\n";
        $output_qry_filters .= '                \'fields\'          =>  \'dropdown.ID, dropdown.nom, nav.nom AS nav_nom\',' . "\n";
        $output_qry_filters .= '                \'field_to_filter\' =>  \'dropdown.ID\',' . "\n";
        $output_qry_filters .= '                \'from\'            =>  \'pages, dropdown Left Join nav On dropdown.nav_ID = nav.ID\',' . "\n";
        $output_qry_filters .= '                \'type\'            =>  \'text\',' . "\n";
        $output_qry_filters .= '                \'column\'          =>  2' . "\n";
        $output_qry_filters .= '            ),' . "\n";
        $output_qry_filters .= '            array(' . "\n";
        $output_qry_filters .= '                \'select_label\'    =>  \'actif\',' . "\n";
        $output_qry_filters .= '                \'select_name\'     =>  \'pages_actif\',' . "\n";
        $output_qry_filters .= '                \'option_text\'     =>  \'pages.actif\',' . "\n";
        $output_qry_filters .= '                \'fields\'          =>  \'pages.actif\',' . "\n";
        $output_qry_filters .= '                \'field_to_filter\' =>  \'pages.actif\',' . "\n";
        $output_qry_filters .= '                \'from\'            =>  \'pages, dropdown Left Join nav On dropdown.nav_ID = nav.ID\',' . "\n";
        $output_qry_filters .= '                \'type\'            =>  \'boolean\',' . "\n";
        $output_qry_filters .= '                \'column\'          =>  3' . "\n";
        $output_qry_filters .= '            )' . "\n";
        $output_qry_filters .= '        );' . "\n";
        $output_qry_filters .= '        $form_action = \'' . $_SESSION['table'] . '.php\';' . "\n";
        $output_qry_filters .= '        $filters = new Filters(\'' . $_SESSION['table'] . '\', $filters);' . "\n";
        $output_qry_filters .= '        $this->qry_filters = $filters->returnQry();' . "\n";
        $output_qry_filters .= '        $this->filters_array = $filters->returnForm($form_action);' . "\n";
        $output_qry_filters .= '        $this->sorting = Utils::getSorting(\'' . $_SESSION['table'] . '\', SORTING_FIELD, \'ASC\');' . "\n";
        $output_qry_filters .= '        $start_qry = \'SELECT * FROM ' . $_SESSION['table'] . '\';' . "\n";
        $output_qry_filters .= '        $this->qry_filters .= " ORDER BY" . $this->sorting;' . "\n";
        $output_qry_filters .= '        $db = new Pagination();' . "\n";
        $output_qry_filters .= '        $pagination_url = $_SERVER[\'HTTP_REFERER\'];' . "\n";
        $output_qry_filters .= '        if (isset($_GET[\'npp\']) && is_numeric($_GET[\'npp\'])) {' . "\n";
        $output_qry_filters .= '            $_SESSION[\'npp\'] = $_GET[\'npp\'];' . "\n";
        $output_qry_filters .= '        } elseif (!isset($_SESSION[\'npp\'])) {' . "\n";
        $output_qry_filters .= '            $_SESSION[\'npp\'] = 20;' . "\n";
        $output_qry_filters .= '        }' . "\n";
        $output_qry_filters .= '        $this->pagination_html = $db->pagine($start_qry . $this->qry_filters, $_SESSION[\'npp\'], "p", $pagination_url, 5, false);' . "\n";
        $output_qry_filters .= '        $this->count_' . $_SESSION['table'] . ' = $db->rowCount();' . "\n";
        $output_qry_filters .= '        while (!$db->endOfSeek()) {' . "\n";
        $output_qry_filters .= '            $row = $db->row();' . "\n";
        foreach ($fields_list as $field) {
            $output_qry_filters .= '            $this->' . $field . '[] = $row->' . $field . "; \n";
        }
        $output_qry_filters .= '        }' . "\n";
        $output_qry_filters .= '        /*________ FUNCTION list ________*/' . " \n\n";
        $output_qry_filters .= '        $html = $this->filters_array;' . " \n\n";
        $output_qry_filters .= '        /*________ JS TO COLOR FILTERED COLUMNS (put code in inc/list-' . $_SESSION['table'] . '.php) ________*/' . " \n\n";
        $output_qry_filters .= '<script type="text/javascript">' . "\n";
        $output_qry_filters .= '<?php' . "\n";
        $output_qry_filters .= 'if (!empty($_SESSION[\'highlighted_col\'])) { ?>' . "\n";
        $output_qry_filters .= '    var filtered_columns = [<?php echo implode(\', \', $_SESSION[\'highlighted_col\']); ?>]; // don\'t use new Array(), it doesn\' work with a single element.' . "\n";
        $output_qry_filters .= '    $(\'#table-' . $_SESSION['table'] . '-admin\').colorColumns(filtered_columns, \'#EFEFEF\');' . "\n";
        $output_qry_filters .= '<?php' . "\n";
        $output_qry_filters .= '} ?>' . "\n";
        $output_qry_filters .= '</script>' . "\n";
    }
    if (isset($_POST['group2']) && in_array('build_qry_insert', $_POST['group2'])) {
        $output_insert = '            $msg_failure = \'<p class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="icon-warning icon-lg prepend"></span>Echec de la mise à jour<br><br>DB_ERROR</p>\';' . "\n";
        $output_insert .= '            $msg_success = \'<p class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="icon-info-round icon-lg prepend"></span>Modifications effectuées !</p>\';' . "\n";
        foreach ($fields_list as $field) {
            $output_insert .= '             $insert[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
        }
        $output_insert .= '            $db = new Mysql();' . "\n";
        $output_insert .= '            if (!$db->insertRow(\'' . $_SESSION['table'] . '\', $insert)) {' . "\n";
        $output_insert .= '                $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error(), $msg_failure)) . \'");\';' . "\n";
        $output_insert .= '            } else {' . "\n";
        $output_insert .= '                $msg = \'$("#msg").html("\' . addslashes($msg_success) . \'");\';' . "\n";
        $output_insert .= '            }' . "\n";
    }
    if (isset($_POST['group2']) && in_array('build_qry_update', $_POST['group2'])) {
        $output_update = '            $msg_failure = \'<p class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="icon-warning icon-lg prepend"></span>Echec de la mise à jour<br><br>DB_ERROR</p>\';' . "\n";
        $output_update .= '            $msg_success = \'<p class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="icon-info-round icon-lg prepend"></span>Modifications effectuées !</p>\';' . "\n";
        $output_update .= '                $filter["' . $_POST['update_filter'] . '"] = Mysql::SQLValue($_POST[\'' . $_POST['update_filter'] . '\'])' . "; \n";
        foreach ($fields_list as $field) {
            $output_update .= '                $update[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
        }
        $output_update .= '                $db = new Mysql();' . "\n";
        $output_update .= '                if (!$db->UpdateRows(\'' . $_SESSION['table'] . '\', $update, $filter)) {' . "\n";
        $output_update .= '                    $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error(), $this->msg_failure)) . \'");\';' . "\n";
        $output_update .= '                } else {' . "\n";
        $output_update .= '                    $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_update .= '                }' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_insert', $_POST['group3'])) {
        $output_db_insert = '';
        $output_db_insert .= '            case \'ajout_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_insert .= '                $form = new Form(\'form-ajout-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_insert .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_insert .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_insert .= '                foreach ($required as $required) {' . "\n";
        $output_db_insert .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_insert .= '                }' . "\n";
        $output_db_insert .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_insert .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_insert .= '                    $_SESSION[\'errors\'][\'form-ajout-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_insert .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/ajouter-' . $_SESSION['table'] . '.php"});\';' . "\n";
        $output_db_insert .= '                } else { // if posted values are ok' . "\n";
        foreach ($fields_list as $field) {
            if ($field == 'ID') {
                $output_db_insert .= '                   $insert[\'' . $field . '\'] = Mysql::SQLValue(\'\')' . "; \n";
            } else {
                $output_db_insert .= '                   $insert[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
            }
        }
        $output_db_insert .= '                    $db = new Mysql();' . "\n";
        $output_db_insert .= '                    if (!$db->insertRow(\'' . $_SESSION['table'] . '\', $insert)) {' . "\n";
        $output_db_insert .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_insert .= '                    } else {' . "\n";
        $output_db_insert .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_insert .= '                    }' . "\n";
        $output_db_insert .= '                }' . "\n";
        $output_db_insert .= '                $this->echoResult($msg);' . "\n";
        $output_db_insert .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_insert_one_image', $_POST['group3'])) {
        $output_db_insert_one_image = '';
        $output_db_insert_one_image .= '            case \'ajout_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_insert_one_image .= '                $form = new Form(\'form-ajout-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_insert_one_image .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_insert_one_image .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_insert_one_image .= '                foreach ($required as $required) {' . "\n";
        $output_db_insert_one_image .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_insert_one_image .= '                }' . "\n";
        $output_db_insert_one_image .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_insert_one_image .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_insert_one_image .= '                    $_SESSION[\'errors\'][\'form-ajout-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_insert_one_image .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/ajouter-' . $_SESSION['table'] . '.php"});\';' . "\n";
        $output_db_insert_one_image .= '                } else { // if posted values are ok' . "\n";
        $output_db_insert_one_image .= '                    if (isset($_POST[\'photo\'])) {' . "\n";
        $output_db_insert_one_image .= '                        $insert[\'photo\'] = Mysql::SQLValue($_POST[\'photo\']);' . "\n";
        $output_db_insert_one_image .= '                    } else {' . "\n";
        $output_db_insert_one_image .= '                        $insert[\'photo\'] = Mysql:: SQLValue(\'\', "text");' . "\n";
        $output_db_insert_one_image .= '                    }' . "\n";
        foreach ($fields_list as $field) {
            if ($field == 'ID') {
                $output_db_insert_one_image .= '                    $insert[\'' . $field . '\'] = Mysql::SQLValue(\'\')' . "; \n";
            } else {
                $output_db_insert_one_image .= '                    $insert[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
            }
        }
        $output_db_insert_one_image .= '                    $db = new Mysql();' . "\n";
        $output_db_insert_one_image .= '                    if (!$db->insertRow(\'' . $_SESSION['table'] . '\', $insert)) {' . "\n";
        $output_db_insert_one_image .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_insert_one_image .= '                    } else {' . "\n";
        $output_db_insert_one_image .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_insert_one_image .= '                    }' . "\n";
        $output_db_insert_one_image .= '                }' . "\n";
        $output_db_insert_one_image .= '                $this->echoResult($msg);' . "\n";
        $output_db_insert_one_image .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_insert_several_images', $_POST['group3'])) {
        $output_db_insert_several_images = '';
        $output_db_insert_several_images .= '            case \'ajout_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_insert_several_images .= '                $form = new Form(\'form-ajout-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_insert_several_images .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_insert_several_images .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_insert_several_images .= '                foreach ($required as $required) {' . "\n";
        $output_db_insert_several_images .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_insert_several_images .= '                }' . "\n";
        $output_db_insert_several_images .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_insert_several_images .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_insert_several_images .= '                    $_SESSION[\'errors\'][\'form-ajout-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_insert_several_images .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/ajouter-' . $_SESSION['table'] . '.php"});\';' . "\n";
        $output_db_insert_several_images .= '                } else { // if posted values are ok' . "\n";
        $output_db_insert_several_images .= '                    $fields_photo = \'photo\';' . "\n";
        $output_db_insert_several_images .= '                    $fields_count_photos = 2;' . "\n";
        $output_db_insert_several_images .= '                    for ($i = 0; $i <= count($fields_count_photos); $i++) {' . "\n";
        $output_db_insert_several_images .= '                        if (isset($_POST[$fields_photo][$i])) {' . "\n";
        $output_db_insert_several_images .= '                            $insert[\'photo_\' . ($i + 1)] = Mysql::SQLValue($_POST[$fields_photo][$i]);' . "\n";
        $output_db_insert_several_images .= '                        } else {' . "\n";
        $output_db_insert_several_images .= '                            $insert[\'photo_\' . ($i + 1)] = Mysql:: SQLValue(\'\', "text");' . "\n";
        $output_db_insert_several_images .= '                        }' . "\n";
        $output_db_insert_several_images .= '                    }' . "\n";
        foreach ($fields_list as $field) {
            if ($field == 'ID') {
                $output_db_insert_several_images .= '                    $insert[\'' . $field . '\'] = Mysql::SQLValue(\'\')' . "; \n";
            } else {
                $output_db_insert_several_images .= '                    $insert[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
            }
        }
        $output_db_insert_several_images .= '                    $db = new Mysql();' . "\n";
        $output_db_insert_several_images .= '                    if (!$db->insertRow(\'' . $_SESSION['table'] . '\', $insert)) {' . "\n";
        $output_db_insert_several_images .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_insert_several_images .= '                    } else {' . "\n";
        $output_db_insert_several_images .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_insert_several_images .= '                    }' . "\n";
        $output_db_insert_several_images .= '                }' . "\n";
        $output_db_insert_several_images .= '                $this->echoResult($msg);' . "\n";
        $output_db_insert_several_images .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_update', $_POST['group3'])) {
        $output_db_update = '            case \'modif_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_update .= '                $form = new Form(\'form-modif-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_update .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_update .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_update .= '                foreach ($required as $required) {' . "\n";
        $output_db_update .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_update .= '                }' . "\n";
        $output_db_update .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_update .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_update .= '                    $_SESSION[\'errors\'][\'form-modif-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_update .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/modifier-' . $_SESSION['table'] . '.php?ID=\' . $_POST[\'ID\'] . \'"});\';' . "\n";
        $output_db_update .= '                } else { // if posted values are ok' . "\n";
        $output_db_update .= '                    $filter[\'ID\']          = Mysql::SQLValue($_POST[\'ID\']);' . "\n";
        $output_db_update .= '             $filter["ID"] = Mysql::SQLValue($_POST[\'ID\']);' . "\n";
        foreach ($fields_list as $field) {
            $output_db_update .= '                $update[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
        }
        $output_db_update .= '                    $db = new Mysql();' . "\n";
        $output_db_update .= '                    if (!$db->UpdateRows(\'' . $_SESSION['table'] . '\', $update, $filter)) {' . "\n";
        $output_db_update .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_update .= '                    } else {' . "\n";
        $output_db_update .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_update .= '                    }' . "\n";
        $output_db_update .= '                }' . "\n";
        $output_db_update .= '                $this->echoResult($msg);' . "\n";
        $output_db_update .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_update_one_image', $_POST['group3'])) {
        $output_db_update_one_image = '            case \'modif_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_update_one_image .= '                $form = new Form(\'form-modif-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_update_one_image .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_update_one_image .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_update_one_image .= '                foreach ($required as $required) {' . "\n";
        $output_db_update_one_image .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_update_one_image .= '                }' . "\n";
        $output_db_update_one_image .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_update_one_image .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_update_one_image .= '                    $_SESSION[\'errors\'][\'form-modif-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_update_one_image .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/modifier-' . $_SESSION['table'] . '.php?ID=\' . $_POST[\'ID\'] . \'"});\';' . "\n";
        $output_db_update_one_image .= '                } else { // if posted values are ok' . "\n";
        $output_db_update_one_image .= '                    $old_photo = \'\';' . "\n";
        $output_db_update_one_image .= '                    if (isset($_POST[\'CHAMP_PHOTO\'])) {    // delete old photo' . "\n";
        $output_db_update_one_image .= '                        $qry = "SELECT CHAMP_PHOTO FROM ' . $_SESSION['table'] . ' WHERE ID=\'" . $_POST[\'ID\'] . "\' LIMIT 1";' . "\n";
        $output_db_update_one_image .= '                        $db = new Mysql();' . "\n";
        $output_db_update_one_image .= '                        $db->query($qry);' . "\n";
        $output_db_update_one_image .= '                        $row = $db->row();    //echo $qry.\'<br />\';' . "\n";
        $output_db_update_one_image .= '                        $count = $db->rowCount();' . "\n";
        $output_db_update_one_image .= '                        if (!empty($count)) {' . "\n";
        $output_db_update_one_image .= '                            $old_photo = $row->CHAMP_PHOTO;    //echo $old_photo.\'<br />\';' . "\n";
        $output_db_update_one_image .= '                        }' . "\n";
        $output_db_update_one_image .= '                    }' . "\n";
        $output_db_update_one_image .= '                    $filter[\'ID\'] = Mysql::SQLValue($_POST[\'ID\']);' . "\n";
        foreach ($fields_list as $field) {
            $output_db_update_one_image .= '                    $update[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
        }
        $output_db_update_one_image .= '                    $db = new Mysql();' . "\n";
        $output_db_update_one_image .= '                    if (!$db->UpdateRows(\'' . $_SESSION['table'] . '\', $update, $filter)) {' . "\n";
        $output_db_update_one_image .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_update_one_image .= '                    } else {' . "\n";
        $output_db_update_one_image .= '                        if (!empty($old_photo) && $old_photo != $_POST[\'CHAMP_PHOTO\']) {' . "\n";
        $output_db_update_one_image .= '                            @ chmod(rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/$old_photo", 0775);' . "\n";
        $output_db_update_one_image .= '                            @ unlink(rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/$old_photo");' . "\n";
        $output_db_update_one_image .= '                            @ chmod(rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/$old_photo", 0775);' . "\n";
        $output_db_update_one_image .= '                            @ unlink(rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/$old_photo");' . "\n";
        $output_db_update_one_image .= '                        }' . "\n";
        $output_db_update_one_image .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_update_one_image .= '                    }' . "\n";
        $output_db_update_one_image .= '                }' . "\n";
        $output_db_update_one_image .= '                $this->echoResult($msg);' . "\n";
        $output_db_update_one_image .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_update_several_images', $_POST['group3'])) {
        $output_db_update_several_images = '            case \'modif_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_update_several_images .= '                $form = new Form(\'form-modif-' . $_SESSION['table'] . '\');' . "\n";
        $output_db_update_several_images .= '                $validator = new Validator($_POST);' . "\n";
        $output_db_update_several_images .= '                $required = array(\'nom\', \'prenom\', \'email\');' . "\n";
        $output_db_update_several_images .= '                foreach ($required as $required) {' . "\n";
        $output_db_update_several_images .= '                    $validator->required()->validate($required);' . "\n";
        $output_db_update_several_images .= '                }' . "\n";
        $output_db_update_several_images .= '                $validator->email()->validate(\'email\');' . "\n";
        $output_db_update_several_images .= '                if ($validator->hasErrors()) {' . "\n";
        $output_db_update_several_images .= '                    $_SESSION[\'errors\'][\'form-modif-' . $_SESSION['table'] . '\'] = $validator->getAllErrors();' . "\n";
        $output_db_update_several_images .= '                    $msg = \'$("#ajax-modal").modal({remote: "inc/modifier-' . $_SESSION['table'] . '.php?ID=\' . $_POST[\'ID\'] . \'"});\';' . "\n";
        $output_db_update_several_images .= '                } else { // if posted values are ok' . "\n";
        $output_db_update_several_images .= '                    $old_photo = array();' . "\n";
        $output_db_update_several_images .= '                    $count_photos = 2;' . "\n";
        $output_db_update_several_images .= '                    for ($i = 0; $i < $count_photos; $i++) {' . "\n";
        $output_db_update_several_images .= '                        $field_photo = \'CHAMP_PHOTO\' . ($i + 1);' . "\n";
        $output_db_update_several_images .= '                        if (isset($_POST[$field_photo])) {' . "\n";
        $output_db_update_several_images .= '                            $update[$field_photo] = Mysql::SQLValue($_POST[$field_photo]);' . "\n";
        $output_db_update_several_images .= '                            $qry = "SELECT $field_photo FROM ' . $_SESSION['table'] . ' WHERE ID=\'" . $_POST[\'ID\'] . "\' LIMIT 1";' . "\n";
        $output_db_update_several_images .= '                            $db = new Mysql();' . "\n";
        $output_db_update_several_images .= '                            $db->query($qry);' . "\n";
        $output_db_update_several_images .= '                            $row = $db->row();    //echo $qry.\'<br />\';' . "\n";
        $output_db_update_several_images .= '                            $count = $db->rowCount();' . "\n";
        $output_db_update_several_images .= '                            if (!empty($count)) {    // SI LA REQUETE N\'EST PAS VIDE' . "\n";
        $output_db_update_several_images .= '                                $old_photo[] = $row->$field_photo;    //echo $row->$field_photo.\'<br />\';' . "\n";
        $output_db_update_several_images .= '                            }' . "\n";
        $output_db_update_several_images .= '                        }' . "\n";
        $output_db_update_several_images .= '                    }    // fin boucle photos' . "\n";
        $output_db_update_several_images .= '                    $filter[\'ID\']          = Mysql::SQLValue($_POST[\'ID\']);' . "\n";
        foreach ($fields_list as $field) {
            $output_db_update_several_images .= '                $update[\'' . $field . '\'] = Mysql::SQLValue($_POST[\'' . $field . '\'])' . "; \n";
        }
        $output_db_update_several_images .= '                    $db = new Mysql();' . "\n";
        $output_db_update_several_images .= '                    if (!$db->UpdateRows(\'' . $_SESSION['table'] . '\', $update, $filter)) {' . "\n";
        $output_db_update_several_images .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_update_several_images .= '                    } else {' . "\n";
        $output_db_update_several_images .= '                        for ($i=0; $i < $count_photos; $i++) {' . "\n";
        $output_db_update_several_images .= '                            $field_photo = \'photo_\' . ($i + 1);' . "\n";
        $output_db_update_several_images .= '                            if (!empty($old_photo[$i]) && ($old_photo[$i] !== $_POST[$field_photo])) {' . "\n";
        $output_db_update_several_images .= '                                @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/$old_photo[$i]", 0777);' . "\n";
        $output_db_update_several_images .= '                                @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/$old_photo[$i]");' . "\n";
        $output_db_update_several_images .= '                                @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/$old_photo[$i]", 0777);' . "\n";
        $output_db_update_several_images .= '                                @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/$old_photo[$i]");' . "\n";
        $output_db_update_several_images .= '                            }' . "\n";
        $output_db_update_several_images .= '                        }' . "\n";
        $output_db_update_several_images .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_update_several_images .= '                    }' . "\n";
        $output_db_update_several_images .= '                }' . "\n";
        $output_db_update_several_images .= '                $this->echoResult($msg);' . "\n";
        $output_db_update_several_images .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_delete', $_POST['group3'])) {
        $output_db_suppr = '            case \'suppr_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_suppr .= '                $filter["ID"] = Mysql::sqlValue($_POST[\'ID\'], Mysql::SQLVALUE_NUMBER);' . "\n";
        $output_db_suppr .= '                $db = new Mysql();' . "\n";
        $output_db_suppr .= '                if (!$db->deleteRows(\'' . $_SESSION['table'] . '\', $filter)) {' . "\n";
        $output_db_suppr .= '                    $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_suppr .= '                } else {' . "\n";
        $output_db_suppr .= '                    $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_suppr .= '                }' . "\n";
        $output_db_suppr .= '                $this->echoResult($msg);' . "\n";
        $output_db_suppr .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_sorting', $_POST['group3'])) {
        $output_db_sorting = '            case \'sorting_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_sorting .= '                foreach ($_POST[\'ids\'] as $id) {' . "\n";
        $output_db_sorting .= '                    $order = $_POST[\'order_\'.$id];' . "\n";
        $output_db_sorting .= '                    $filter["ID"] = Mysql::SQLValue($id);' . "\n";
        $output_db_sorting .= '                    $update[\'ordre\'] = Mysql::SQLValue($order);' . "\n";
        $output_db_sorting .= '                    $db = new Mysql();' . "\n";
        $output_db_sorting .= '                    if (!$db->UpdateRows("' . $_SESSION['table'] . '", $update, $filter)) {' . "\n";
        $output_db_sorting .= '                        $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_sorting .= '                    } else {' . "\n";
        $output_db_sorting .= '                        $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_sorting .= '                    }' . "\n";
        $output_db_sorting .= '                 }' . "\n";
        $output_db_sorting .= '                $this->echoResult($msg);' . "\n";
        $output_db_sorting .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_delete_one_image', $_POST['group3'])) {
        $output_db_delete_one_image = '            case \'suppr_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_delete_one_image .= '                $ID = $_POST[\'ID\'];' . "\n";
        $output_db_delete_one_image .= '                $qry = "SELECT CHAMP FROM ' . $_SESSION['table'] . ' WHERE ID = \'$ID\' LIMIT 1";' . "\n";
        $output_db_delete_one_image .= '                $db = new Mysql();' . "\n";
        $output_db_delete_one_image .= '                $db->query($qry);' . "\n";
        $output_db_delete_one_image .= '                $row = $db->row();' . "\n";
        $output_db_delete_one_image .= '                $photo = $row->CHAMP;' . "\n";
        $output_db_delete_one_image .= '                $filter["ID"] = Mysql::sqlValue($_POST[\'ID\'], Mysql::SQLVALUE_NUMBER);' . "\n";
        $output_db_delete_one_image .= '                $db = new Mysql();' . "\n";
        $output_db_delete_one_image .= '                if (!$db->deleteRows(\'' . $_SESSION['table'] . '\', $filter)) {' . "\n";
        $output_db_delete_one_image .= '                    $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_delete_one_image .= '                } else {' . "\n";
        $output_db_delete_one_image .= '                    if (!empty($photo)) {' . "\n";
        $output_db_delete_one_image .= '                        @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/" . $photo, 0775);' . "\n";
        $output_db_delete_one_image .= '                        @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/" . $photo);' . "\n";
        $output_db_delete_one_image .= '                        @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/" . $photo, 0775);' . "\n";
        $output_db_delete_one_image .= '                        @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/" . $photo);' . "\n";
        $output_db_delete_one_image .= '                    }' . "\n";
        $output_db_delete_one_image .= '                    $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_delete_one_image .= '                }' . "\n";
        $output_db_delete_one_image .= '                $this->echoResult($msg);' . "\n";
        $output_db_delete_one_image .= '                break;' . "\n";
    }
    if (isset($_POST['group3']) && in_array('build_db_delete_several_images', $_POST['group3'])) {
        $output_db_delete_several_images = '            case \'suppr_' . $_SESSION['table'] . '\':' . "\n";
        $output_db_delete_several_images .= '                $ID = $_POST[\'ID\'];' . "\n";
        $output_db_delete_several_images .= '                $count_photos = 4;' . "\n";
        $output_db_delete_several_images .= '                for ($i=0; $i < $count_photos; $i++) {' . "\n";
        $output_db_delete_several_images .= '                    $fields_photo[] = \'CHAMP_\' . ($i + 1);' . "\n";
        $output_db_delete_several_images .= '                }' . "\n";
        $output_db_delete_several_images .= '                $qry_champs_photo = implode(\', \', $fields_photo);' . "\n";
        $output_db_delete_several_images .= '                $qry = "SELECT $qry_champs_photo FROM ' . $_SESSION['table'] . ' WHERE ID = \'$ID\' LIMIT 1";' . "\n";
        $output_db_delete_several_images .= '                $db = new Mysql();' . "\n";
        $output_db_delete_several_images .= '                $db->query($qry);' . "\n";
        $output_db_delete_several_images .= '                $row = $db->row();' . "\n";
        $output_db_delete_several_images .= '                for ($i=0; $i < $count_photos; $i++) {' . "\n";
        $output_db_delete_several_images .= '                    $photos[] = $row->$fields_photo[$i];' . "\n";
        $output_db_delete_several_images .= '                }' . "\n";
        $output_db_delete_several_images .= '                $filter["ID"] = Mysql::sqlValue($_POST[\'ID\'], Mysql::SQLVALUE_NUMBER);' . "\n";
        $output_db_delete_several_images .= '                $db = new Mysql();' . "\n";
        $output_db_delete_several_images .= '                if (!$db->deleteRows(\'' . $_SESSION['table'] . '\', $filter)) {' . "\n";
        $output_db_delete_several_images .= '                    $msg = \'$("#msg").html("\' . addslashes(str_replace(\'DB_ERROR\', $db->error() . \'<br>\' . $db->getLastSql(), $this->msg_failure)) . \'");\';' . "\n";
        $output_db_delete_several_images .= '                } else {' . "\n";
        $output_db_delete_several_images .= '                    for ($i=0; $i < $count_photos; $i++) {' . "\n";
        $output_db_delete_several_images .= '                        $photo = $photos[$i];' . "\n";
        $output_db_delete_several_images .= '                        if (!empty($photo)) {' . "\n";
        $output_db_delete_several_images .= '                            @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/" . $photo, 0775);' . "\n";
        $output_db_delete_several_images .= '                            @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/" . $photo);' . "\n";
        $output_db_delete_several_images .= '                            @ chmod((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/" . $photo, 0775);' . "\n";
        $output_db_delete_several_images .= '                            @ unlink((rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . "/DIR/thumbnail/" . $photo);' . "\n";
        $output_db_delete_several_images .= '                        }' . "\n";
        $output_db_delete_several_images .= '                    }' . "\n";
        $output_db_delete_several_images .= '                    $msg = \'$("#msg").html("\' . addslashes($this->msg_success) . \'");\';' . "\n";
        $output_db_delete_several_images .= '                }' . "\n";
        $output_db_delete_several_images .= '                $this->echoResult($msg);' . "\n";
        $output_db_delete_several_images .= '                break;' . "\n";
    }
    if (isset($_POST['build_list'])) {
        $_SESSION['countJeditBooleen'] = 0;
        $_SESSION['countJeditTexte'] = 0;
        $_SESSION['countJeditTextarea'] = 0;
        $_SESSION['countJeditSelect'] = 0;
        $_SESSION['countJeditDate'] = 0;
        $output_list = "\n\r";
        $has_nested_table = false;
        foreach ($fields_list as $field) {
            if ($has_nested_table == false) {
                $has_nested_table = getNestedTable($field);
            }
        }
        $output_list .= '        $html = $this->filters_array;' . "\n";
        $output_list .= '        $numbersArray = array(10,20,50);' . "\n";
        $output_list .= '        $numbers_array = array(10, 20, 50, 10000);' . "\n";
        $output_list .= '        $html .= \'<a data-toggle="modal" href="inc/ajouter-' . $_SESSION['table'] . '.php" data-target="#ajax-modal" class="btn btn-sm btn-primary pull-left"><span class="icon-plus icon-md prepend"></span>Ajouter un ' . singular($_SESSION['table']) . '</a>\' . "\n";' . "\n";
        if (isset($_POST['export_btn']) && $_POST['export_btn'] == true) {
            $output_list .= '        $html .= Utils::exportDataButtons(\'subscribers\', \'SELECT * FROM ' . $_SESSION['table'] . ' ORDER BY ID ASC\', \'excel, csv\') . "\n";' . "\n";
        }
        $output_list .= '        $html .= Utils::selectNumberPerPage($numbers_array, $_SESSION[\'npp\'], \'' . $_SESSION['table'] . '\') . "\n";' . "\n";
        $output_list .= '        $html .= \'<table id="table-' . $_SESSION['table'] . '-admin" class="table table-striped table-condensed table-bordered mb-xs">\' . "\n";' . "\n";
        $output_list .= '        $html .= \'<thead>\' . "\n";' . "\n";
        $output_list .= '        $html .= \'<tr>\' . "\n";' . "\n";
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);    // text, image, boolean, skip_this_field
            $enable_sorting = getSorting($field);
            $nested_table = getNestedTable($field);
            if (!empty($field_type) && $field_type != 'skip_this_field' && $nested_table == false) {
                if ($enable_sorting == true) {
                    $output_list .= '        if (isset($_GET[\'p\'])) {' . "\n";
                    $output_list .= '            $array_url_vars_up = array(\'sorting\', \'direction\', \'p\');' . "\n";
                    $output_list .= '            $array_url_values_up = array(\'' . $field . '\', \'ASC\', $_GET[\'p\']);' . "\n";
                    $output_list .= '            $array_url_vars_down = array(\'sorting\', \'direction\', \'p\');' . "\n";
                    $output_list .= '            $array_url_values_down = array(\'' . $field . '\', \'DESC\', $_GET[\'p\']);' . "\n";
                    $output_list .= '        } else {' . "\n";
                    $output_list .= '            $array_url_vars_up = array(\'sorting\', \'direction\');' . "\n";
                    $output_list .= '            $array_url_values_up = array(\'' . $field . '\', \'ASC\');' . "\n";
                    $output_list .= '            $array_url_vars_down = array(\'sorting\', \'direction\');' . "\n";
                    $output_list .= '            $array_url_values_down = array(\'' . $field . '\', \'DESC\');' . "\n";
                    $output_list .= '        }' . "\n";
                    $output_list .= '        $html .= \'<th><span class="sorting">' . $field . '\' . Utils::lienAjax(\'inc/afficher-' . $_SESSION['table'] . '.php\', $array_url_vars_up, $array_url_values_up, \'&nbsp;\', \'' . $_SESSION['table'] . '-liste\', \'sorting-up\') . Utils::lienAjax(\'inc/afficher-' . $_SESSION['table'] . '.php\', $array_url_vars_down, $array_url_values_down, \'&nbsp;\', \'' . $_SESSION['table'] . '-liste\', \'sorting-down\') . \'</span></th>\' . "\n";' . "\n";
                } else {
                    $output_list .= '        $html .= \'<th>' . $field . '</th>\' . "\n";' . "\n";
                }
            }
        }
        if ($has_nested_table == true) {
            $output_list .= '        $html .= \'<th>détail</th>\' . "\n";' . "\n";
        }
        if (isset($_POST['open_url_btn']) && $_POST['open_url_btn'] == true) {
            $output_list .= '        $html .= \'<th>afficher</th>\' . "\n";' . "\n";
        }
        $output_list .= '        $html .= \'<th>action</th>\' . "\n";' . "\n";
        $output_list .= '        $html .= \'</tr>\' . "\n";' . "\n";
        $output_list .= '        $html .= \'</thead>\' . "\n";' . "\n";
        $output_list .= '        $html .= \'<tbody>\' . "\n";' . "\n";
        $output_list .= '        for ($i=0; $i<$this->count_' . $_SESSION['table'] . '; $i++) {' . "\n";
        $textFields = array();
        $imageFields = array();
        $booleanFields = array();
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);    // text, image, boolean, skip_this_field
            if ($field_type == 'text') {
                $textFields[] = $field;
            } elseif ($field_type == 'image') {
                $imageFields[] = $field;
            } elseif ($field_type == 'boolean') {
                $booleanFields[] = $field;
            }
        }

        /************* IMAGES *************/

        $countImages = count($imageFields);
        for ($i = 0; $i<$countImages; $i++) {
            $output_list .= '            if (!empty($this->' . $imageFields[$i] . '[$i])) {' . "\n";
            $output_list .= '                $txt_' . $imageFields[$i] . ' = \'<img src="/thumbnail/\' . $this->' . $imageFields[$i] . '[$i].\'" alt="" />\' . "\n";' . "\n";
            $output_list .= '            } else {' . "\n";
            $output_list .= '                $txt_' . $imageFields[$i] . ' = \'\';' . "\n";
            $output_list .= '            }' . "\n";
        }
        $countBooleen = count($booleanFields);
        for ($i = 0; $i<$countBooleen; $i++) {
            $output_list .= '            $txt_' . $booleanFields[$i]  . ' = utils::replaceWithBooleen($this->' . $booleanFields[$i]  . '[$i]);' . "\n";
        }
        $output_list .= '            $html .= \'<tr>\' . "\n";' . "\n";
        $output_nested_table = '';
        foreach ($fields_list as $field) {
            $field_type     = getFieldType($field);    // text, image, boolean, skip_this_field
            $jedit_text     = getJedit($field, 'text'); // true pour text OU boolean
            $jedit_textarea = getJedit($field, 'textarea');
            $jedit_select   = getJedit($field, 'select');
            $jedit_date     = getJedit($field, 'date');
            $nested_table   = getNestedTable($field);
            if ($field_type != 'skip_this_field' && $nested_table == false) {
                if ($field_type == 'text') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditTexte'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_textarea == true) {
                        $_SESSION['countJeditTextarea'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit-textarea tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_select == true) {
                        $_SESSION['countJeditSelect'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit-select tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_date == true) {
                        $_SESSION['countJeditDate'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit-date tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_list .= '            $html .= \'<td>\' . $this->' . $field . '[$i] . \'</td>\' . "\n";' . "\n";
                    }
                } elseif ($field_type == 'image') {
                    $output_list .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                } elseif ($field_type == 'boolean') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditBooleen'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit-boolean tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $txt_' . $field . ' . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_list .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                    }
                }
            } elseif ($field_type != 'skip_this_field' && $nested_table == true) {
                $output_nested_table .= '            $html .= \'<tr>\' . "\n";' . "\n";
                $output_nested_table .= '            $html .= \'<th class="header">' . $field . '</th>\' . "\n";' . "\n";
                if ($field_type == 'text') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditTexte'] += 1;
                        $output_nested_table .= '             $html .= \'<td><span class="jedit tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_textarea == true) {
                        $_SESSION['countJeditTextarea'] += 1;
                        $output_nested_table .= '             $html .= \'<td><span class="jedit-textarea tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_select == true) {
                        $_SESSION['countJeditSelect'] += 1;
                        $output_nested_table .= '             $html .= \'<td><span class="jedit-select tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_date == true) {
                        $_SESSION['countJeditDate'] += 1;
                        $output_nested_table .= '             $html .= \'<td><span class="jedit-date tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $this->' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_nested_table .= '            $html .= \'<td>\' . $this->' . $field . '[$i] . \'</td>\' . "\n";' . "\n";
                    }
                } elseif ($field_type == 'image') {
                    $output_nested_table .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                } elseif ($field_type == 'boolean') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditBooleen'] += 1;
                        $output_list .= '            $html .= \'<td><span class="jedit-boolean tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[$i] . \'">\' . $txt_' . $field . '[$i] . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_list .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                    }
                }
                $output_nested_table .= '            $html .= \'</tr>\' . "\n";' . "\n";
            }
        }
        if ($has_nested_table == true) { // affichage du nested-table en cours
            $output_list .= '            $html .= \'<td><a href="#" class="lien-nested-table btn btn-default btn-xs">afficher<span class="caret append"></span></a><div class="table-slide">\' . "\n";' . "\n";
            $output_list .= '            $html .= \'<table class="table table-condensed table-bordered mb-xs small">\' . "\n";' . "\n";
            $output_list .= $output_nested_table;
            $output_list .= '            $html .= \'</tbody>\' . "\n";' . "\n";
            $output_list .= '            $html .= \'</table>\' . "\n";' . "\n";
            $output_list .= '            $html .= \'</div></td>\' . "\n";' . "\n";
        }
        if (isset($_POST['open_url_btn']) && $_POST['open_url_btn'] == true) {
            $output_list .= '            $html .= \'<td><a href="URLSITECLIENTS" class="tip" data-delay="500" title="voir sur le site (nouvelle fenêtre)" target="_blank"><span class="icon-arrow-up-right-round icon-lg text-center"></span></a>\' . \'</td>\' . "\n";' . "\n";
        }

        $output_list .= '            $html .= \'<td class="nowrap"><a data-toggle="modal" href="inc/modifier-' . $_SESSION['table'] . '.php?ID=\' . $this->ID[$i] . \'" data-target="#ajax-modal" class="btn btn-sm btn-warning tip" title="Modifier" data-placement="left" data-delay="500"><span class="icon-pencil icon-md"></span></a>\' . "\n";' . "\n";
        $output_list .= '            $html .= \'<a data-toggle="modal" href="inc/supprimer-' . $_SESSION['table'] . '.php?ID=\' . $this->ID[$i] . \'" data-target="#ajax-modal" class="btn btn-sm btn-danger tip" title="Deleteimer" data-placement="right" data-delay="500"><span class="icon-remove icon-md"></span></a>\' . \'</td>\' . "\n";' . "\n";
        $output_list .= '            $html .= \'</tr>\' . "\n";' . "\n";
        $output_list .= '        }' . "\n";
        $output_list .= '        $html .= \'</tbody>\' . "\n";' . "\n";
        $output_list .= '        $html .= \'</table>\' . "\n";' . "\n";
        $output_list .= '        echo $html;' . "\n";
        $output_list .= '        echo $this->pagination_html;' . "\n";
        $output_list .= "\n" . '        /*_______ TRI _______' . " \n\n";
        $output_list .= '        $this->sorting = Utils::getSorting(\'' . $_SESSION['table'] . '\', SORTING_FIELD, \'ASC\');' . "\n";
        $output_list .= '        QRY :         $qry .= \' ORDER BY\' . $this->sorting;' . "\n";
        $output_list .= " \n" . returnJedit();
        if ($has_nested_table == true) {
            $output_list .= " \n" . getNestedTableJS();
        }
    }
    if (isset($_POST['build_vertical_list'])) {
        $_SESSION['countJeditBooleen'] = 0;
        $_SESSION['countJeditTexte'] = 0;
        $_SESSION['countJeditTextarea'] = 0;
        $_SESSION['countJeditSelect'] = 0;
        $_SESSION['countJeditDate'] = 0;
        $output_vertical_list = '        $html = \'<div class="mb-xs">\' . "\n";' . "\n";
        $output_vertical_list .= '        $html .= \'<a data-toggle="modal" href="inc/modifier-' . $_SESSION['table'] . '.php?ID=\' . $this->ID[0] . \'" data-target="#ajax-modal" class="btn btn-warning pull-right tip" title="Modifier" data-placement="left" data-delay="500"><span class="icon-pencil icon-md prepend"></span>Modifier</a>\' . "\n";' . "\n";
        if ($_POST['afficher_lien_precedent_suivant'] == true) {
            $output_vertical_list .= '        $numeroRef = substr($this->reference[0], 5, 5);' . "\n";
            $output_vertical_list .= '        $html .= \'<div class="btn-group"><a href="\' . $this->lienReference(\'precedente\', $numeroRef) . \'" class="btn btn-primary"><span class="icon-arrow-left prepend"></span>Précédent</a><a href="\' . $this->lienReference(\'suivante\', $numeroRef) . \'" class="btn btn-primary">Suivant<span class="icon-arrow-right append"></span></a>\' . "\n";' . "\n";
        }
        $output_vertical_list .= '        $html .= \'</div>\' . "\n";' . "\n";
        $output_vertical_list .= '        $html .= \'<table class="table width-auto table-condensed table-bordered mb-xs small clearfix">\' . "\n";' . "\n";
        $output_vertical_list .= '        $html .= \'<tbody>\' . "\n";' . "\n";
        $textFields = array();
        $imageFields = array();
        $booleanFields = array();
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);    // text, image, boolean, skip_this_field
            if ($field_type == 'text') { // true pour text OU boolean
                $textFields[] = $field;
            } elseif ($field_type == 'image') {
                $imageFields[] = $field;
            } elseif ($field_type == 'boolean') {
                $booleanFields[] = $field;
            }
        }

        /************* IMAGES *************/

        $countImages = count($imageFields);
        for ($i = 0; $i<$countImages; $i++) {
            $output_vertical_list .= '        if (!empty($this->' . $imageFields[$i] . '[0])) {' . "\n";
            $output_vertical_list .= '            $txt_' . $imageFields[$i] . ' = \'<img src="/thumbnail/\' . $this->' . $imageFields[$i] . '[0].\'" alt="" />\' . "\n";' . "\n";
            $output_vertical_list .= '        } else {' . "\n";
            $output_vertical_list .= '            $txt_' . $imageFields[$i] . ' = \'\';' . "\n";
            $output_vertical_list .= '        }' . "\n";
        }

        /************* BOOLEENS *************/

        $countBooleen = count($booleanFields);
        for ($i = 0; $i<$countBooleen; $i++) {
            $output_vertical_list .= '        $txt_' . $booleanFields[$i]  . ' = utils::replaceWithBooleen($this->' . $booleanFields[$i]  . '[0]);' . "\n";
        }
        $i = 0;
        foreach ($fields_list as $field) {
            $field_type     = getFieldType($field);    // text, image, boolean, skip_this_field
            $jedit_text    = getJedit($field, 'text');
            $jedit_textarea = getJedit($field, 'textarea');
            $jedit_select   = getJedit($field, 'select');
            $jedit_date     = getJedit($field, 'date');
            if (!empty($field_type) && $field_type != 'skip_this_field') {
                $output_vertical_list .= '        $html .= \'<tr>\' . "\n";' . "\n";
                $output_vertical_list .= '        $html .= \'<th class="header">' . $field . '</th>\' . "\n";' . "\n";
                if ($field_type == 'text') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditTexte'] += 1;
                        $output_vertical_list .= '            $html .= \'<td><span class="jedit tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[0] . \'">\' . $this->' . $field . '[0] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_textarea == true) {
                        $_SESSION['countJeditTextarea'] += 1;
                        $output_vertical_list .= '            $html .= \'<td><span class="jedit-textarea tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[0] . \'">\' . $this->' . $field . '[0] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_select == true) {
                        $_SESSION['countJeditSelect'] += 1;
                        $output_vertical_list .= '            $html .= \'<td><span class="jedit-select tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[0] . \'">\' . $this->' . $field . '[0] . \'</span></td>\' . "\n";' . "\n";
                    } elseif ($jedit_date == true) {
                        $_SESSION['countJeditDate'] += 1;
                        $output_vertical_list .= '            $html .= \'<td><span class="jedit-date tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[0] . \'">\' . $this->' . $field . '[0] . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_vertical_list .= '            $html .= \'<td>\' . $this->' . $field . '[0] . \'</td>\' . "\n";' . "\n";
                    }
                } elseif ($field_type == 'image') {
                    $output_vertical_list .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                } elseif ($field_type == 'boolean') {
                    if ($jedit_text == true) {
                        $_SESSION['countJeditBooleen'] += 1;
                        $output_vertical_list .= '            $html .= \'<td><span class="jedit-boolean tip" data-delay="500" title="cliquer pour modifier" id="' . $_SESSION['table'] . '-' . $field . '-\' . $this->ID[0] . \'">\' . $txt_' . $field . ' . \'</span></td>\' . "\n";' . "\n";
                    } else {
                        $output_vertical_list .= '            $html .= \'<td>\' . $txt_' . $field . ' . \'</td>\' . "\n";' . "\n";
                    }
                }
                $output_vertical_list .= '        $html .= \'</tr>\' . "\n";' . "\n";
                $i++;
            }
        }
        $output_vertical_list .= '        $html .= \'</tbody>\' . "\n";' . "\n";
        $output_vertical_list .= '        $html .= \'</table>\' . "\n";' . "\n";
        $output_vertical_list .= '        echo $html;' . "\n";
        $output_vertical_list .= " \n" . returnJedit();
    }
    if (isset($_POST['build_add_form'])) {
        $output_add_form = '<?php' . "\n";
        $output_add_form .= 'use phpformbuilder\Form;' . "\n";
        $output_add_form .= 'use common\Mysql;' . "\n";
        $output_add_form .= '' . "\n";
        $output_add_form .= '@session_start();' . "\n";
        $output_add_form .= 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/conf/conf.php\';' . "\n";
        $output_add_form .= 'if (!isset($_SESSION[\'errors\'][\'form-ajout-' . $_SESSION['table'] . '\']) || empty($_SESSION[\'errors\'][\'form-ajout-' . $_SESSION['table'] . '\'])) { // SI 1er POST, sans msg d\'erreur' . "\n";
        $output_add_form .= '    $db = new Mysql();' . "\n";
        $output_add_form .= '    $columns = $db->getColumnNames("' . $_SESSION['table'] . '");' . "\n";
        $output_add_form .= '    foreach ($columns as $columnName) {' . "\n";
        $output_add_form .= '        $_SESSION[\'form-ajout-' . $_SESSION['table'] . '\'][$columnName] = \'\';' . "\n";
        $output_add_form .= '    }' . "\n";
        $output_add_form .= '}' . "\n";
        $output_add_form .= '$form = new form(\'form-ajout-' . $_SESSION['table'] . '\');' . "\n";
        /*$output_add_form .= '$options = array(' . "\n";
        $output_add_form .= '    \'openDomReady\'             => \'\',' . "\n";
        $output_add_form .= '    \'closeDomReady\'            => \'\'' . "\n";
        $output_add_form .= ');' . "\n";
        $output_add_form .= '$form->setOptions($options);' . "\n";*/
        $output_add_form .= '$form->setAction($_SERVER[\'HTTP_REFERER\'], false);' . "\n";
        $output_add_form .= '$form->startFieldset(\'Ajouter un ' . singular($_SESSION['table']) . '\');' . "\n";
        $uploadifyIndex = 1;
        $dateIndex = 1;
        $_SESSION['countTooltips'] = 0;
        $_SESSION['countTextarea'] = 0;
        $_SESSION['textareaIds'] = array();
        $_SESSION['countDates'] = 0;
        $_SESSION['dateIds'] = array();
        $_SESSION['countUploadify'] = 0;
        $_SESSION['uploadifyIds'] = array();
        $_SESSION['countTinyMce'] = 0;
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);  // input, textarea, tinyMce, select, radio, image, date, hidden
            if ($field_type == 'tinyMce') {
                $required = ''; // tinyMce bloque l'envoi du formulaire si required
            } else {
                $required = getRequired($field);    // , required=required
            }
            $tooltip = getTooltip($field);    // <a href="#" title="TEXTE_TOOLTIP" class="tip"><span class="badge">?</span></a>
            $char_count = getChar_count($field); // true or false

            if ($field_type == 'input') {
                $output_add_form .= '$form->addInput(\'text\', \'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'size=60' . $required . '\');' . "\n";
                if ($char_count == true) {
                    if ($char_count == true) {
                        $output_add_form .= '$form->addPlugin(\'word-character-count\', \'#' . $field . '\', \'default\', array(\'%maxAuthorized%\' => 200));' . "\n";
                    }
                }
            } elseif ($field_type == 'textarea') {
                $_SESSION['countTextarea']++;
                $_SESSION['textareaIds'][] = 'textarea-' . $field;
                $output_add_form .= '$form->addTextarea(\'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'cols=64, rows=8, id=textarea-' . $field . $required . '\');' . "\n";
                if ($char_count == true) {
                    $output_add_form .= '$form->addPlugin(\'word-character-count\', \'#textarea-' . $field . '\', \'default\', array(\'%maxAuthorized%\' => 200));' . "\n";
                }
            } elseif ($field_type == 'select') {
                $output_add_form .= 'for ($i=0; $i<NBRE; $i++) {' . "\n";
                $output_add_form .= '    $form->addOption(\'' . $field . '\', $' . $_SESSION['table'] . '->' . $field . '[$i], $' . $_SESSION['table'] . '->' . $field . '[$i]);' . "\n";
                $output_add_form .= '}' . "\n";
                if (!empty($required)) {
                    $attributs = ', \'required=required\'';
                } else {
                    $attributs = '';
                }
                $output_add_form .= '$form->addSelect(\'' . $field . '\', \'' . $field . ' : ' . $tooltip . '\'' . $attributs . ');' . "\n";
            } elseif ($field_type == 'radio') {
                $output_add_form .= '$form->addRadio(\'' . $field . '\', \'oui\', 1);' . "\n";
                $output_add_form .= '$form->addRadio(\'' . $field . '\', \'non\', 0);' . "\n";
                $output_add_form .= '$form->printRadioGroup(\'' . $field . '\', \'' . $field . ' : ' . $tooltip . '\');' . "\n";
            } elseif ($field_type == 'image') {
                if ($_SESSION['countUploadify'] < 1) {
                    $output_add_form .= '$fileUpload_config = array(' . "\n";
                    $output_add_form .= '    \'xml\'                 => \'images\',' . "\n";
                    $output_add_form .= '    \'uploader\'            => \'imageFileUpload.php\',' . "\n";
                    $output_add_form .= '    \'btn-text\'            => \'Parcourir ...\',' . "\n";
                    $output_add_form .= '    \'max-number-of-files\' => 1' . "\n";
                    $output_add_form .= ');' . "\n";
                }
                $_SESSION['countUploadify']++;
                $_SESSION['uploadifyIds'][] = 'photo_' . $uploadifyIndex;
                if (!empty($required)) {
                    $attributs = ', \'required=required\'';
                } else {
                    $attributs = ', \'\'';
                }
                $output_add_form .= '$form->addFileUpload(\'file\', \'photo_' . $uploadifyIndex . '\', \'\', \'photo ' . $uploadifyIndex . '<br><span class="form-text text-muted">La photo sera redimensionnée à 818px x 253px.<br>Si les proportions ne correspondent pas elle sera rognée.<br>Pour manipuler vos photos en ligne : <a href="http://cropp.me/" target="_blank">http://cropp.me/</a></span> : ' . $tooltip . '\'' . $attributs . ', $fileUpload_config);' . "\n";
                $uploadifyIndex++;
            } elseif ($field_type == 'date') {
                $_SESSION['countDates']++;
                $_SESSION['dateIds'][] = 'date_' . $dateIndex;
                $output_add_form .= '$form->addInput(\'text\', \'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'size=60, id=date_' . $dateIndex . ', placeholder=utilisez le calendrier svp' . $required . '\');' . "\n";
                $output_add_form .= '$form->addPlugin(\'pickadate\', \'#date_' . $dateIndex . '\');' . "\n";
                $dateIndex++;
            } elseif ($field_type == 'hidden') {
                $output_add_form .= '$form->addInput(\'hidden\', \'' . $field . '\', $_GET[\'' . $field . '\']);' . "\n";
            } elseif ($field_type == 'tinyMce') {
                $_SESSION['countTinyMce']++;
                $output_add_form .= '$form->addTextarea(\'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'cols=100, rows=20' . $required . ', class=tinyMce\');' . "\n";
                $output_add_form .= '$form->addPlugin(\'tinymce\', \'#' . $field . '\');' . "\n";
            }
        }
        $output_add_form .= '$options = array(' . "\n";
        $output_add_form .= '        \'horizontalOffsetCol\'      => \'\',' . "\n";
        $output_add_form .= '        \'horizontalElementCol\'     => \'col-sm-12\',' . "\n";
        $output_add_form .= ');' . "\n";
        $output_add_form .= '$form->setOptions($options);' . "\n";
        $output_add_form .= '$form->addBtn(\'button\', \'cancel\', 0, \'<span class="icon-cancel prepend"></span>Annuler\', \'class=btn btn-warning, data-dismiss=modal\', \'btn-group\');' . "\n";
        $output_add_form .= '$form->addBtn(\'submit\', \'submit\', 1, \'<span class="icon-checkmark prepend"></span>Valider\', \'class=btn btn-success\', \'btn-group\');' . "\n";
        $output_add_form .= '$form->printBtnGroup(\'btn-group\');' . "\n";
        $output_add_form .= '$form->endFieldset();' . "\n";
        $output_add_form .= '$form->render();' . "\n";
        $output_add_form .= '$form->printIncludes(\'css\');' . "\n";
        $output_add_form .= '$form->printIncludes(\'js\');' . "\n";
        $output_add_form .= '$form->printJsCode();' . "\n";
        $output_add_form .= '?>' . "\n";
        $output_add_form .= '<script type="text/javascript">$(\'.tip\').tooltip();</script>' . "\n";
    }
    if (isset($_POST['build_update_form'])) {
        $output_update_form = '<?php' . "\n";
        $output_update_form .= 'use phpformbuilder\Form;' . "\n";
        $output_update_form .= 'use common\Mysql;' . "\n";
        $output_update_form .= '' . "\n";
        $output_update_form .= '@session_start();' . "\n";
        $output_update_form .= 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/conf/conf.php\';' . "\n";
        $output_update_form .= '$ID = $_GET[\'ID\'];' . "\n";
        $output_update_form .= 'if (!isset($_GET[\'alerteMsg\'])) { // SI 1er POST, sans msg d\'erreur' . "\n";
        $output_update_form .= '    $qry = "SELECT * FROM ' . $_SESSION['table']  . ' WHERE ID=\'$ID\'";' . "\n";
        $output_update_form .= '    $db = new Mysql();' . "\n";
        $output_update_form .= '    $db->query($qry);' . "\n";
        $output_update_form .= '    $row = $db->row();' . "\n";
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);    // input, textarea, select, radio, image, date, hidden
            if ($field_type == 'date') {
                $output_update_form .= '    if (!empty($row->' . $field . ')) {' . "\n";
                $output_update_form .= '        $_SESSION[\'form-modif-' . $_SESSION['table'] . '\'][\'' . $field . '\'] = date(\'Y-m-d\', strtotime($row->' . $field . '));' . "\n";
                $output_update_form .= '    }' . "\n";
                $output_update_form .= '    else {' . "\n";
                $output_update_form .= '        $_SESSION[\'form-modif-' . $_SESSION['table'] . '\'][\'' . $field . '\'] = \'\';' . "\n";
                $output_update_form .= '    }' . "\n";
            } else {
                $output_update_form .= '    $_SESSION[\'form-modif-' . $_SESSION['table'] . '\'][\'' . $field . '\'] = $row->' . $field . ';' . "\n";
            }
        }
        $output_update_form .= '}' . "\n";
        $output_update_form .= '$form = new form(\'form-modif-' . $_SESSION['table'] . '\');' . "\n";
        $output_update_form .= '$form->setAction($_SERVER[\'HTTP_REFERER\'], false);' . "\n";
        $output_update_form .= '$form->startFieldset(\'Modifier un ' . singular($_SESSION['table']) . '\');' . "\n";
        $output_update_form .= '$form->addInput(\'hidden\', \'ID\', $ID);' . "\n";
        $uploadifyIndex = 1;
        $dateIndex = 1;
        $_SESSION['countTooltips'] = 0;
        $_SESSION['countTextarea'] = 0;
        $_SESSION['textareaIds'] = array();
        $_SESSION['countDates'] = 0;
        $_SESSION['dateIds'] = array();
        $_SESSION['countUploadify'] = 0;
        $_SESSION['uploadifyIds'] = array();
        $_SESSION['countTinyMce'] = 0;
        foreach ($fields_list as $field) {
            $field_type = getFieldType($field);  // input, textarea, tinyMce, select, radio, image, date, hidden
            if ($field_type == 'tinyMce') {
                $required = ''; // tinyMce bloque l'envoi du formulaire si required
            } else {
                $required = getRequired($field);    // , required=required
            }
            $tooltip = getTooltip($field);    // <a href="#" title="TEXTE_TOOLTIP" class="tip"><span class="badge">?</span></a>
            $char_count = getChar_count($field); // true or false

            if ($field_type == 'input') {
                $output_update_form .= '$form->addInput(\'text\', \'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'size=60' . $required . '\');' . "\n";
                if ($char_count == true) {
                    $output_update_form .= '$form->addPlugin(\'word-character-count\', \'#' . $field . '\', \'default\', array(\'%maxAuthorized%\' => 200));' . "\n";
                }
            } elseif ($field_type == 'textarea') {
                $_SESSION['countTextarea']++;
                $_SESSION['textareaIds'][] = 'textarea-' . $field;
                $output_update_form .= '$form->addTextarea(\'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'cols=64, rows=8, id=textarea-' . $field . $required . '\');' . "\n";
                if ($char_count == true) {
                    $output_update_form .= '$form->addPlugin(\'word-character-count\', \'#textarea-' . $field . '\', \'default\', array(\'%maxAuthorized%\' => 200));' . "\n";
                }
            } elseif ($field_type == 'select') {
                $output_update_form .= 'for ($i=0; $i<NBRE; $i++) {' . "\n";
                $output_update_form .= '$form->addOption(\'' . $field . '\', $' . $_SESSION['table'] . '->' . $field . '[$i], $' . $_SESSION['table'] . '->' . $field . '[$i]);' . "\n";
                $output_update_form .= '}' . "\n";
                if (!empty($required)) {
                    $attributs = ', \'required=required\'';
                } else {
                    $attributs = '';
                }
                $output_update_form .= '$form->addSelect(\'' . $field . '\', \'' . $field . ' : ' . $tooltip . '\'' . $attributs . ');' . "\n";
            } elseif ($field_type == 'radio') {
                $output_update_form .= '$form->addRadio(\'' . $field . '\', \'oui\', 1);' . "\n";
                $output_update_form .= '$form->addRadio(\'' . $field . '\', \'non\', 0);' . "\n";
                $output_update_form .= '$form->printRadioGroup(\'' . $field . '\', \'' . $field . ' : ' . $tooltip . '\');' . "\n";
            } elseif ($field_type == 'image') {
                if ($_SESSION['countUploadify'] < 1) {
                    $output_update_form .= '$fileUpload_config = array(' . "\n";
                    $output_update_form .= '    \'xml\'                 => \'images\',' . "\n";
                    $output_update_form .= '    \'uploader\'            => \'imageFileUpload.php\',' . "\n";
                    $output_update_form .= '    \'btn-text\'            => \'Parcourir ...\',' . "\n";
                    $output_update_form .= '    \'max-number-of-files\' => 1' . "\n";
                    $output_update_form .= ');' . "\n";
                }
                $_SESSION['countUploadify']++;
                $_SESSION['uploadifyIds'][] = 'photo_' . $uploadifyIndex;
                if (!empty($required)) {
                    $attributs = ', \'required=required\'';
                } else {
                    $attributs = ', \'\'';
                }
                $output_update_form .= '$form->addFileUpload(\'file\', \'photo_' . $uploadifyIndex . '\', \'\', \'photo ' . $uploadifyIndex . '<br><span class="form-text text-muted">La photo sera redimensionnée à 818px x 253px.<br>Si les proportions ne correspondent pas elle sera rognée.<br>Pour manipuler vos photos en ligne : <a href="http://cropp.me/" target="_blank">http://cropp.me/</a></span> : ' . $tooltip . '\'' . $attributs . ', $fileUpload_config);' . "\n";
                $uploadifyIndex++;
            } elseif ($field_type == 'date') {
                $_SESSION['countDates']++;
                $_SESSION['dateIds'][] = 'date_' . $dateIndex;
                $output_update_form .= '$form->addInput(\'text\', \'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'size=60, id=date_' . $dateIndex . ', placeholder=utilisez le calendrier svp' . $required . '\');' . "\n";
                $output_update_form .= '$form->addPlugin(\'pickadate\', \'#date_' . $dateIndex . '\');' . "\n";
                $dateIndex++;
            } elseif ($field_type == 'hidden') {
                $output_update_form .= '$form->addInput(\'hidden\', \'' . $field . '\', $_GET[\'' . $field . '\']);' . "\n";
            } elseif ($field_type == 'tinyMce') {
                $_SESSION['countTinyMce']++;
                $output_update_form .= '$form->addTextarea(\'' . $field . '\', \'\', \'' . $field . ' : ' . $tooltip . '\', \'cols=100, rows=20' . $required . ', class=tinyMce\');' . "\n";
                $output_update_form .= '$form->addPlugin(\'tinymce\', \'#' . $field . '\');' . "\n";
            }
        }
        $output_update_form .= '$options = array(' . "\n";
        $output_update_form .= '        \'horizontalOffsetCol\'      => \'\',' . "\n";
        $output_update_form .= '        \'horizontalElementCol\'     => \'col-sm-12\',' . "\n";
        $output_update_form .= ');' . "\n";
        $output_update_form .= '$form->setOptions($options);' . "\n";
        $output_update_form .= '$form->addBtn(\'button\', \'cancel\', 0, \'<span class="icon-cancel prepend"></span>Annuler\', \'class=btn btn-warning, data-dismiss=modal\', \'btn-group\');' . "\n";
        $output_update_form .= '$form->addBtn(\'submit\', \'submit\', 1, \'<span class="icon-checkmark prepend"></span>Valider\', \'class=btn btn-success\', \'btn-group\');' . "\n";
        $output_update_form .= '$form->printBtnGroup(\'btn-group\');' . "\n";
        $output_update_form .= '$form->endFieldset();' . "\n";
        $output_update_form .= '$form->render();' . "\n";
        $output_update_form .= '$form->printIncludes(\'css\');' . "\n";
        $output_update_form .= '$form->printIncludes(\'js\');' . "\n";
        $output_update_form .= '$form->printJsCode();' . "\n";
        $output_update_form .= '?>' . "\n";
        $output_update_form .= '<script type="text/javascript">$(\'.tip\').tooltip();</script>' . "\n";
    }
    if (isset($_POST['group4']) && in_array('build_delete_form', $_POST['group4'])) {
        $output_delete_form = '<?php' . "\n";
        $output_delete_form .= 'use phpformbuilder\Form;' . "\n";
        $output_delete_form .= 'use common\Mysql;' . "\n";
        $output_delete_form .= '' . "\n";
        $output_delete_form .= '@session_start();' . "\n";
        $output_delete_form .= 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/conf/conf.php\';' . "\n";
        $output_delete_form .= '$ID = Mysql::sqlValue($_GET[\'ID\'], Mysql::SQLVALUE_NUMBER);' . "\n";
        $output_delete_form .= '$qry = \'SELECT * FROM ' . $_SESSION['table'] . ' WHERE ID = \' . $ID . \' LIMIT 1\';' . "\n";
        $output_delete_form .= '$db = new Mysql();' . "\n";
        $output_delete_form .= '$db->query($qry);' . "\n";
        $output_delete_form .= '$count = $db->rowCount();' . "\n";
        $output_delete_form .= 'if (!empty($count)) {' . "\n";
        $output_delete_form .= '    $row = $db->row();' . "\n";
        $output_delete_form .= '        $nom = $row->nom;' . "\n";
        $output_delete_form .= '        $prenom = $row->prenom;' . "\n";
        $output_delete_form .= '}' . "\n";
        $output_delete_form .= '$options = array(' . "\n";
        $output_delete_form .= '    \'horizontalOffsetCol\'      => \'\',' . "\n";
        $output_delete_form .= '    \'horizontalElementCol\'     => \'col-sm-12 text-center\'' . "\n";
        $output_delete_form .= ');' . "\n";
        $output_delete_form .= '$form = new form(\'form-suppr-' . $_SESSION['table'] . '\');' . "\n";
        $output_delete_form .= '$form->setOptions($options);' . "\n";
        $output_delete_form .= '$form->setAction($_SERVER[\'HTTP_REFERER\'], false);' . "\n";
        $output_delete_form .= '$form->startFieldset(\'Deleteimer un ' . singular($_SESSION['table']) . '\');' . "\n";
        $output_delete_form .= '$form->html .= \'<p class="lead text-danger text-center">Deleteimer \' . $nom . \' \' . $prenom . \' ?</p>\' . "\n";' . "\n";
        $output_delete_form .= '$form->addInput(\'hidden\', \'ID\', $_GET[\'ID\']);' . "\n";
        $output_delete_form .= '$form->addBtn(\'button\', \'cancel\', 0, \'<span class="icon-cancel prepend"></span>Annuler\', \'class=btn btn-warning, data-dismiss=modal\', \'btn-group\');' . "\n";
        $output_delete_form .= '$form->addBtn(\'submit\', \'submit\', 1, \'<span class="icon-checkmark prepend"></span>Deleteimer\', \'class=btn btn-success\', \'btn-group\');' . "\n";
        $output_delete_form .= '$form->printBtnGroup(\'btn-group\');' . "\n";
        $output_delete_form .= '$form->endFieldset();' . "\n";
        $output_delete_form .= '$form->render();' . "\n";
    }
    if (isset($_POST['group4']) && in_array('build_sorting_form', $_POST['group4'])) {
        $output_sorting_form = '<?php' . "\n";
        $output_sorting_form .= 'use phpformbuilder\Form;' . "\n";
        $output_sorting_form .= 'use common\Mysql;' . "\n";
        $output_sorting_form .= '' . "\n";
        $output_sorting_form .= '@session_start();' . "\n";
        $output_sorting_form .= 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/conf/conf.php\';' . "\n";
        $output_sorting_form .= '$qry = "SELECT ID, CHAMP_NOM, ordre FROM ' . $_SESSION['table'] . ' ORDER BY ordre ASC";' . "\n";
        $output_sorting_form .= '$db = new Mysql();' . "\n";
        $output_sorting_form .= '$db->query($qry);' . "\n";
        $output_sorting_form .= '$count_nav = $db->rowCount();' . "\n";
        $output_sorting_form .= 'if (!empty($count_nav)) {' . "\n";
        $output_sorting_form .= '    while (! $db->endOfSeek()) {' . "\n";
        $output_sorting_form .= '        $row = $db->row();' . "\n";
        $output_sorting_form .= '        $ID[] = $row->ID;' . "\n";
        $output_sorting_form .= '        $CHAMP_NOM[] = $row->CHAMP_NOM;' . "\n";
        $output_sorting_form .= '        $ordre[] = $row->ordre;' . "\n";
        $output_sorting_form .= '    }' . "\n";
        $output_sorting_form .= '}' . "\n";
        $output_sorting_form .= '$form = new form(\'form-sorting-' . $_SESSION['table'] . '\');' . "\n";
        $output_sorting_form .= '$options = array(' . "\n";
        $output_sorting_form .= '        \'horizontalOffsetCol\'      => \'\',' . "\n";
        $output_sorting_form .= '        \'horizontalElementCol\'     => \'col-sm-12\',' . "\n";
        $output_sorting_form .= ');' . "\n";
        $output_sorting_form .= '$form->setOptions($options);' . "\n";
        $output_sorting_form .= '$form->setAction($_SERVER[\'HTTP_REFERER\'], false);' . "\n";
        $output_sorting_form .= '$form->startFieldset(\'Sorting le menu\');' . "\n";
        $output_sorting_form .= '$form->html .= \'<div class="form-group">\' . "\n";' . "\n";
        $output_sorting_form .= '$form->html .= \'<ul id="sortable" class="col-sm-12">\' . "\n";' . "\n";
        $output_sorting_form .= 'for ($i=0; $i<$count_nav; $i++) {' . "\n";
        $output_sorting_form .= '    $form->addInput(\'hidden\', \'order_\' . $ID[$i], $ordre[$i], \'\', \'id=order_\' . $ID[$i]);' . "\n";
        $output_sorting_form .= '    $form->addInput(\'hidden\', \'ids[]\', $ID[$i]);' . "\n";
        $output_sorting_form .= '    $form->html .= \'<li id="sort_\' . $ID[$i] . \'">\' . "\n";' . "\n";
        $output_sorting_form .= '    $form->html .= \'<span class="glyphicon glyphicon-resize-vertical prepend"> </span>\' . $CHAMP_NOM[$i] . "\n";' . "\n";
        $output_sorting_form .= '    $form->html .= \'</li>\' . "\n";' . "\n";
        $output_sorting_form .= '}' . "\n";
        $output_sorting_form .= '$form->html .= \'</ul>\' . "\n";' . "\n";
        $output_sorting_form .= '$form->html .= \'</div>\' . "\n";' . "\n";
        $output_sorting_form .= '$form->addBtn(\'button\', \'cancel\', 0, \'<span class="icon-cancel prepend"></span>Annuler\', \'class=btn btn-warning, data-dismiss=modal\', \'btn-group\');' . "\n";
        $output_sorting_form .= '$form->addBtn(\'submit\', \'submit\', 1, \'<span class="icon-checkmark prepend"></span>Valider\', \'class=btn btn-success\', \'btn-group\');' . "\n";
        $output_sorting_form .= '$form->printBtnGroup(\'btn-group\');' . "\n";
        $output_sorting_form .= '$form->endFieldset();' . "\n";
        $output_sorting_form .= '$form->render();' . "\n";
        $output_sorting_form .= '?>' . "\n";
        $output_sorting_form .= '<script type="text/javascript">' . "\n";
        $output_sorting_form .= '  $( "#sortable" ).sortable({' . "\n";
        $output_sorting_form .= '        revert: true,' . "\n";
        $output_sorting_form .= '        update: function (event,ui) {' . "\n";
        $output_sorting_form .= '            //create an array with the new order (ex : ["sort_2", "sort_3", "sort_4", "sort_5", "sort_1"])' . "\n";
        $output_sorting_form .= '                var order = $( "#sortable" ).sortable(\'toArray\');' . "\n";
        $output_sorting_form .= '                for (var key in order) { /* indexes du table */' . "\n";
        $output_sorting_form .= '                    var val = order[key]; /* ex : sort_2 (pour key = 0) */' . "\n";
        $output_sorting_form .= '                    var part = val.split("_"); /* ex : ["sort", "2"] */' . "\n";
        $output_sorting_form .= '                    //update each hidden field used to store the list item position' . "\n";
        $output_sorting_form .= '                    $("#order_"+part[1]).val(parseInt(key) + 1); /* ex : $(\'#order_1\').val(5) */' . "\n";
        $output_sorting_form .= '                    //console.log($("#order"+part[1]).value + \'=\' + key);' . "\n";
        $output_sorting_form .= '          }' . "\n";
        $output_sorting_form .= '      }' . "\n";
        $output_sorting_form .= '  });' . "\n";
        $output_sorting_form .= '</script>' . "\n";
    }
    if (isset($_POST['build_dependant_select'])) {
        /*$_POST['select_2_table']
        $_POST['select_2_field_name']
        $_POST['select_2_label']
        $_POST['select_2_champ_value']*/
        $output_dependant_select_form = '$qry = \'SELECT ' . $_POST['select_1_field_name'] . ', ' . $_POST['select_1_label'] . ' FROM ' . $_POST['select_1_table'] . ' ORDER BY ' . $_POST['select_1_label'] . ' ASC\';' . "\n";
        $output_dependant_select_form .= '$db = new Mysql();' . "\n";
        $output_dependant_select_form .= '$db->query($qry);' . "\n";
        $output_dependant_select_form .= '$count = $db->rowCount();' . "\n";
        $output_dependant_select_form .= 'if (!empty($count)) {' . "\n";
        $output_dependant_select_form .= '    while (! $db->endOfSeek()) {' . "\n";
        $output_dependant_select_form .= '        $row         = $db->row();' . "\n";
        $output_dependant_select_form .= '        $' . $_POST['select_1_field_name'] . '[]  = $row->' . $_POST['select_1_field_name'] . ';' . "\n";
        $output_dependant_select_form .= '        $' . $_POST['select_1_label'] . '[] = $row->' . $_POST['select_1_label'] . ';' . "\n";
        $output_dependant_select_form .= '    }' . "\n";
        $output_dependant_select_form .= '}' . "\n";
        $output_dependant_select_form .= 'for ($i=0; $i < count($' . $_POST['select_1_field_name'] . '); $i++) {' . "\n";
        $output_dependant_select_form .= '    $form->addOption(\'' . $_POST['select_1_field_name'] . '\', $' . $_POST['select_1_field_name'] . '[$i], $' . $_POST['select_1_label'] . '[$i]);' . "\n";
        $output_dependant_select_form .= '}' . "\n";
        $output_dependant_select_form .= '$form->addSelect(\'' . $_POST['select_1_field_name'] . '\', \'' . $_POST['select_1_label'] . ' : \');' . "\n";
        $output_dependant_select_form .= '$form->html .= \'<div id="' . $_POST['select_2_table'] . '-select-wrapper"></div>\' . "\n";' . "\n";
        $output_dependant_select_form .= '<script type="text/javascript">' . "\n";
        $output_dependant_select_form .= '    $(\'#' . $_POST['select_2_table'] . '-select-wrapper\').ajax({\'url\' : \'inc/' . $_POST['select_2_table'] . '_select.php\', \'vars\': "' . $_POST['select_1_field_name'] . '=<?php echo $_SESSION[\'' . $_POST['select_1_field_name'] . '\'] ?>", \'divAjaxContenu\': false, \'resize\': false});' . "\n";
        $output_dependant_select_form .= '    $(\'#' . $_POST['select_1_field_name'] . '\').on(\'change\', function () {' . "\n";
        $output_dependant_select_form .= '        $(\'#' . $_POST['select_2_table'] . '-select-wrapper\').ajax({\'url\' : \'inc/' . $_POST['select_2_table'] . '_select.php\', \'vars\': \'' . $_POST['select_1_field_name'] . '=\' + $(this).val(), \'divAjaxContenu\': false, \'resize\': false});' . "\n";
        $output_dependant_select_form .= '    });' . "\n";
        $output_dependant_select_form .= '</script>' . "\n";
        $output_dependant_select_form .= '' . "\n";
        $output_dependant_select_form .= '/* Fichier ' . $_POST['select_2_table'] . '_select.php */' . "\n";
        $output_dependant_select_form .= '<?php' . "\n";
        $output_dependant_select_form .= 'use phpformbuilder\Form;' . "\n";
        $output_dependant_select_form .= 'use common\Mysql;' . "\n";
        $output_dependant_select_form .= '' . "\n";
        $output_dependant_select_form .= '@session_start();' . "\n";
        $output_dependant_select_form .= 'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'/conf/conf.php\';' . "\n";
        $output_dependant_select_form .= '$' . $_POST['select_1_field_name'] . ' = $_GET[\'' . $_POST['select_1_field_name'] . '\'];' . "\n";
        $output_dependant_select_form .= '$qry = \'SELECT ' . $_POST['select_2_field_name'] . ', ' . $_POST['select_2_label'] . ' FROM ' . $_POST['select_2_table'] . ' WHERE ' . $_POST['select_1_field_name'] . ' = "\' . $_GET[\'' . $_POST['select_1_field_name'] . '\'] . \'" ORDER BY ' . $_POST['select_2_label'] . ' ASC\';' . "\n";
        $output_dependant_select_form .= '$db = new Mysql();' . "\n";
        $output_dependant_select_form .= '$db->query($qry);' . "\n";
        $output_dependant_select_form .= '$count = $db->rowCount();' . "\n";
        $output_dependant_select_form .= 'if (!empty($count)) {' . "\n";
        $output_dependant_select_form .= '    while (! $db->endOfSeek()) {' . "\n";
        $output_dependant_select_form .= '        $row         = $db->row();' . "\n";
        $output_dependant_select_form .= '        $' . $_POST['select_2_field_name'] . '[]  = $row->' . $_POST['select_2_field_name'] . ';' . "\n";
        $output_dependant_select_form .= '        $' . $_POST['select_2_label'] . '[] = $row->' . $_POST['select_2_label'] . ';' . "\n";
        $output_dependant_select_form .= '    }' . "\n";
        $output_dependant_select_form .= '}' . "\n";
        $output_dependant_select_form .= '$form = new form(\'form-' . $_POST['select_2_table'] . '\');' . "\n";
        $output_dependant_select_form .= '$options = array(' . "\n";
        $output_dependant_select_form .= '        \'horizontalLabelCol\'       => \'col-sm-2\',' . "\n";
        $output_dependant_select_form .= '        \'horizontalOffsetCol\'      => \'col-sm-offset-2\',' . "\n";
        $output_dependant_select_form .= '        \'horizontalElementCol\'     => \'col-sm-10\',' . "\n";
        $output_dependant_select_form .= ');' . "\n";
        $output_dependant_select_form .= '$form->setOptions($options);' . "\n";
        $output_dependant_select_form .= '$form->addOption(\'' . $_POST['select_2_field_name'] . '\', \'\', \' - \');' . "\n";
        $output_dependant_select_form .= 'for ($i=0; $i < count($' . $_POST['select_2_field_name'] . '); $i++) {' . "\n";
        $output_dependant_select_form .= '    $form->addOption(\'' . $_POST['select_2_field_name'] . '\', $' . $_POST['select_2_field_name'] . '[$i], $' . $_POST['select_2_label'] . '[$i]);' . "\n";
        $output_dependant_select_form .= '}' . "\n";
        $output_dependant_select_form .= '$form->addSelect(\'' . $_POST['select_2_field_name'] . '\', \'' . $_POST['select_2_label'] . ' : \');' . "\n";
        $output_dependant_select_form .= 'echo $form->html;' . " \n\n";
    }
}

function getFieldType($field)
{
    $field_type = '';
    $tab = array('input', 'textarea', 'select', 'radio', 'image', 'date', 'hidden', 'tinyMce', 'text', 'image', 'boolean', 'skip_this_field');
    foreach ($tab as $tab) {
        $value = $tab . $field;
        if (isset($_POST['field_type' . $field])) {
            if (in_array($value, $_POST['field_type' . $field])) {
                $field_type = $tab;
            }
        }
    }

    return $field_type;
}

function getNestedTable($field)
{
    if (isset($_POST['nested_table' . $field])) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param  string $field
 * @param  string $type  text|textarea|select|date
 * @return Boolean        true|false
 */
function getJedit($field, $type)
{
    if (isset($_POST['field_type' . $field])) {
        if (in_array('jedit' . '_' . $type . $field, $_POST['field_type' . $field])) {
            return true;
        }

        return false;
    }

    return false;
}

function getChar_count($field)
{
    if (isset($_POST['char_count' . $field])) {
        return true;
    } else {
        return false;
    }
}

function getRequired($field)
{
    if (isset($_POST['required' . $field])) {
        return ', required=required';
    } else {
        return '';
    }
}

function getTooltip($field)
{
    if (isset($_POST['tooltip' . $field])) {
        $_SESSION['countTooltips']++;

        return '<a href="#" title="TEXTE_TOOLTIP" class="tip"><span class="badge">?</span></a>';
    } else {
        return '';
    }
}

function getSorting($field)
{
    if (isset($_POST['field_type' . $field])) {
        if (in_array('sorting' . $field, $_POST['field_type' . $field])) {
            return true;
        }

        return false;
    }

    return false;
}
function returnJedit()
{
    $out = '';
    if ($_SESSION['countJeditBooleen'] > 0 || $_SESSION['countJeditTexte'] > 0 || $_SESSION['countJeditTextarea'] > 0 ||$_SESSION['countJeditSelect'] > 0 ||$_SESSION['countJeditDate'] > 0) {
        $out .= '' . "\n";
        $out .= '                /* dans ' . $_SESSION['table'] . '.php */' . "\n";
        $out .= '' . "\n";
        if ($_SESSION['countJeditDate'] > 0) {
            $out .= '<link rel="stylesheet" href="../class/phpformbuilder/plugins/pickadate/lib/compressed/themes/classic.css">' . "\n";
            $out .= '<link rel="stylesheet" href="../class/phpformbuilder/plugins/pickadate/lib/compressed/themes/classic.date.css">' . "\n";
        }
        $out .= '<script src="js/jeditable.js"></script>' . "\n";
        if ($_SESSION['countJeditDate'] > 0) {
            $out .= '<script src="../class/phpformbuilder/plugins/pickadate/lib/compressed/picker.js"></script>' . "\n";
            $out .= '<script src="../class/phpformbuilder/plugins/pickadate/lib/compressed/picker.date.js"></script>' . "\n";
            $out .= '<script src="../class/phpformbuilder/plugins/pickadate/lib/compressed/translations/fr_FR.js"></script>' . "\n";
        }
        $out .= '' . "\n";
        $out .= '                /* dans inc/afficher-' . $_SESSION['table'] . '.php */' . "\n";
        $out .= '' . "\n";
        $out .= '<script type="text/javascript">' . "\n";
        if ($_SESSION['countJeditBooleen'] > 0) {
            $out .= '    $(\'.jedit-boolean\').editable(\'inc/jedit.php\', {' . "\n";
            $out .= '        cssclass      : \'form-inline\',' . "\n";
            $out .= '        type          : \'select\',' . "\n";
            $out .= '        data    : {"1":"oui","0":"non","selected":"1"},' . "\n";
            $out .= '        indicator     : \'<img src="images/ajax-loader.gif" alt="enregistrement ...">\',' . "\n";
            $out .= '        tooltip       : \'Cliquer pour modifier ...\',' . "\n";
            $out .= '        cancel        : \'ANNULER\',' . "\n";
            $out .= '        submit        : \'OK\',' . "\n";
            $out .= '        onblur: \'ignore\',' . "\n";
            $out .= '        callback     : function (value, settings) {' . "\n";
            $out .= '            //console.log(this);' . "\n";
            $out .= '            //console.log(value);' . "\n";
            $out .= '            //console.log(settings);' . "\n";
            $out .= '            $(this).html(value);' . "\n";
            $out .= '        }' . "\n";
            $out .= '    });' . "\n";
        }
        if ($_SESSION['countJeditTexte'] > 0) {
            $out .= '    $(\'.jedit\').editable(\'inc/jedit.php\', {' . "\n";
            $out .= '        cssclass: \'form-inline\',' . "\n";
            $out .= '        type   : \'text\',' . "\n";
            $out .= '        indicator     : \'<img src="images/ajax-loader.gif" alt="enregistrement ...">\',' . "\n";
            $out .= '        tooltip       : \'Cliquer pour modifier ...\',' . "\n";
            $out .= '        cancel        : \'ANNULER\',' . "\n";
            $out .= '        submit        : \'OK\',' . "\n";
            $out .= '        onblur: \'ignore\',' . "\n";
            $out .= '        callback     : function (value, settings) {' . "\n";
            $out .= '            //console.log(this);' . "\n";
            $out .= '            //console.log(value);' . "\n";
            $out .= '            //console.log(settings);' . "\n";
            $out .= '            $(this).html(value);' . "\n";
            $out .= '        }' . "\n";
            $out .= '    });' . "\n";
        }
        if ($_SESSION['countJeditTextarea'] > 0) {
            $out .= '    $(\'.jedit-textarea\').editable(\'inc/jedit.php\', {' . "\n";
            $out .= '        cssclass: \'form-inline\',' . "\n";
            $out .= '        type      : \'textarea\',' . "\n";
            $out .= '        rows    : 5,' . "\n";
            $out .= '        cols    : 30,' . "\n";
            $out .= '        indicator     : \'<img src="images/ajax-loader.gif" alt="enregistrement ...">\',' . "\n";
            $out .= '        tooltip       : \'Cliquer pour modifier ...\',' . "\n";
            $out .= '        cancel        : \'ANNULER\',' . "\n";
            $out .= '        submit        : \'OK\',' . "\n";
            $out .= '        onblur: \'ignore\',' . "\n";
            $out .= '        callback     : function (value, settings) {' . "\n";
            $out .= '            //console.log(this);' . "\n";
            $out .= '            //console.log(value);' . "\n";
            $out .= '            //console.log(settings);' . "\n";
            $out .= '            $(this).html(value);' . "\n";
            $out .= '        }' . "\n";
            $out .= '    });' . "\n";
        }
        if ($_SESSION['countJeditSelect'] > 0) {
            $out .= '    $(\'.jedit-select\').editable(\'inc/jedit.php\', {' . "\n";
            $out .= '        cssclass: \'form-inline\',' . "\n";
            $out .= '        type      : \'select\',' . "\n";
            $out .= '        <?php' . "\n";
            $out .= '        /*$array[\'value 1\'] =  \'option 1\';' . "\n";
            $out .= '        $array[\'value 2\'] =  \'option 2\';' . "\n";
            $out .= '        $array[\'value 3\'] =  \'option 3\';' . "\n";
            $out .= '        $array[\'selected\'] =  \'value 2\';*/' . "\n";
            $out .= '        ?>' . "\n";
            $out .= '        data       : <?php // echo json_encode($array); ?>,' . "\n";
            $out .= '        indicator     : \'<img src="images/ajax-loader.gif" alt="enregistrement ...">\',' . "\n";
            $out .= '        tooltip       : \'Cliquer pour modifier ...\',' . "\n";
            $out .= '        cancel        : \'ANNULER\',' . "\n";
            $out .= '        submit        : \'OK\',' . "\n";
            $out .= '        onblur: \'ignore\',' . "\n";
            $out .= '        callback     : function (value, settings) {' . "\n";
            $out .= '            //console.log(this);' . "\n";
            $out .= '            //console.log(value);' . "\n";
            $out .= '            //console.log(settings);' . "\n";
            $out .= '            $(this).html(settings.data[value]);' . "\n";
            $out .= '        }' . "\n";
            $out .= '    });' . "\n";
        }
        if ($_SESSION['countJeditDate'] > 0) {
            $out .= '    $(\'.jedit-date\').editable(\'inc/jedit.php\', {' . "\n";
            $out .= '        cssclass: \'form-inline\',' . "\n";
            $out .= '        type   : \'pickadate\',' . "\n";
            $out .= '        indicator     : \'<img src="images/ajax-loader.gif" alt="enregistrement ...">\',' . "\n";
            $out .= '        tooltip       : \'Cliquer pour modifier ...\',' . "\n";
            $out .= '        cancel        : \'\',' . "\n";
            $out .= '        submit        : \'\',' . "\n";
            $out .= '        submitdata    : function (value, settings) {' . "\n";
            $out .= '            return { "value_submit": $(\'input[name=value_submit]\').val() };' . "\n";
            $out .= '        },' . "\n";
            $out .= '        onblur: \'ignore\',' . "\n";
            $out .= '        callback     : function (value, settings) {' . "\n";
            $out .= '            //console.log(this);' . "\n";
            $out .= '            //console.log(value);' . "\n";
            $out .= '            //console.log(settings);' . "\n";
            $out .= '            $(this).html(value);' . "\n";
            $out .= '        }' . "\n";
            $out .= '    });' . "\n";
        }
        $out .= '</script>' . "\n";
        $out .= '' . "\n";
        $out .= '                /* fichier inc/jedit.php */' . "\n";
        $out .= '' . "\n";
        $out .= '<?php' . "\n";
        $out .= 'use common\Mysql;' . "\n";
        $out .= 'use common\Utils;' . "\n";
        $out .= '' . "\n";
        $out .= 'include_once \'../../conf/conf.php\';' . "\n";
        $out .= 'preg_match(\'`([a-z0-9]+)-([a-zA-Z0-9_-]+)-([0-9]+)`\', $_POST[\'id\'], $out);' . "\n";
        $out .= '$table = $out[1];' . "\n";
        $out .= '$field = $out[2];' . "\n";
        $out .= '$ID = $out[3];' . "\n";
        $out .= 'if (isset($_POST[\'value_submit\'])) { // pickadate' . "\n";
        $out .= '    $nouvelle_value = $_POST[\'value_submit\'];' . "\n";
        $out .= '} else {' . "\n";
        $out .= '    $nouvelle_value = $_POST[\'value\'];' . "\n";
        $out .= '}' . "\n";
        $out .= '$display = $_POST[\'value\'];' . "\n";
        $out .= '$filter["ID"] = Mysql::SQLValue($ID);' . "\n";
        $out .= '$update[$field] = Mysql::SQLValue($nouvelle_value);' . "\n";
        $out .= '$db = new Mysql();' . "\n";
        $out .= '$db->updateRows($table, $update, $filter);' . "\n";
        $out .= 'if ($field == \'actif\') {' . "\n";
        $out .= '    $display = Utils::replaceWithBooleen($display);' . "\n";
        $out .= '}' . "\n";
        $out .= 'echo $display;' . " \n\n";
    }

    return $out;
}

function getNestedTableJS()
{
    $out = '';
    $out .= '' . "\n";
    $out .= '                /* dans inc/afficher' . $_SESSION['table'] . '.php */' . "\n";
    $out .= '' . "\n";
    $out .= '<script type="text/javascript">' . "\n";
    $out .= '    $(\'.lien-nested-table\').each(function (index, element) {' . "\n";
    $out .= '        var lien_nested_table = $(this);' . "\n";
    $out .= '        var table_slide = $(this).parent(\'td\').find(\'.table-slide\');' . "\n";
    $out .= '        table_slide.addClass(\'ts-hidden\').hide();' . "\n";
    $out .= '        $(this).on(\'click\', function () {' . "\n";
    $out .= '            table_slide.toggle(400, function () {' . "\n";
    $out .= '                if ($(this).hasClass(\'ts-hidden\')) {' . "\n";
    $out .= '                    lien_nested_table.html(\'masquer<span class="caret rotate append"></span>\');' . "\n";
    $out .= '                    $(this).removeClass(\'ts-hidden\');' . "\n";
    $out .= '                } else {' . "\n";
    $out .= '                    lien_nested_table.html(\'afficher<span class="caret append"></span>\');' . "\n";
    $out .= '                    $(this).addClass(\'ts-hidden\');' . "\n";
    $out .= '                }' . "\n";
    $out .= '            });' . "\n";
    $out .= '' . "\n";
    $out .= '            return false;' . "\n";
    $out .= '        });' . "\n";
    $out .= '    });' . "\n";
    $out .= '</script>' . "\n";

    return $out;
}

function singular($table)
{
    if (preg_match('`(.*)[s|x]$`', $table, $out)) {
        return $out[1];
    } else {
        return $table;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Generator</title>
    <meta name="description" content="">
    <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';</script><!-- adaptative-images -->
    <link rel="stylesheet" href="../assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="generator-assets/stylesheets/generator.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet" type="text/css">
    <?php
    if (isset($form_select_fields)) {
        $form_select_fields->printIncludes('css');
    }
    ?>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header id="header">
        <h1>CRUD Generator</h1>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-4 mb-md">
                <?php $form_select_db->render(); ?>
            </div>
        </div>
        <?php if (isset($form_select_table)) { ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-4 mb-md">
                <?php $form_select_table->render(); ?>
            </div>
        </div>
        <?php }
if (isset($form_select_fields)) { ?>
            <div class="row">
            <div class="col-md-12">
                <?php $form_select_fields->render(); ?>
            </div>
        </div>
        <div id="msg"></div>
<?php }
if (isset($output_public_dollar)) { ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>PUBLIC $</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_public_dollar) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_select)) { ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>HTML SELECT</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_select) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_select_pagination)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>HTML PAGINATION</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_select_pagination) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_qry_filters)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>QRY FILTRES ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_qry_filters) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_qry_filters_2_tables)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>QRY FILTRES ADMIN SUR 2 TABLES</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_qry_filters_2_tables) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_insert)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry INSERT</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_insert) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_update)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry UPDATE</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_update) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_insert)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd INSERT</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_insert) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_insert_one_image)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd INSERT 1 SEULE PHOTO</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_insert_one_image) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_insert_several_images)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd INSERT PLUSIEURS PHOTOS</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_insert_several_images) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_update)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd UPDATE</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_update) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_update_one_image)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd UPDATE 1 SEULE PHOTO</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_update_one_image) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_update_several_images)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd UPDATE PLUSIEURS PHOTOS</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_update_several_images) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_suppr)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd SUPPR</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_suppr) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_delete_one_image)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd SUPPR 1 PHOTO</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_delete_one_image) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_delete_several_images)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Qry Bdd SUPPR PLUSIEURS PHOTOS</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_delete_several_images) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_db_sorting)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Bdd ORDONNER</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_db_sorting) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_list)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>LISTE ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_list) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_vertical_list)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>LISTE VERTICALE ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_vertical_list) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_add_form)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>FORM AJOUT ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_add_form) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_update_form)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>FORM MODIF ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_update_form) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_delete_form)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>FORM SUPPR ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_delete_form) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_sorting_form)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>FORM ORDONNER ADMIN</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_sorting_form) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_select_edit_in_place)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>SELECT EDIT IN PLACE</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_select_edit_in_place) ?></textarea>
                </div>
            </div>
<?php }
if (isset($output_dependant_select_form)) { ?>
        <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>SELECT EDIT IN PLACE</h2>
                    <textarea cols="120" rows="15" class="small"><?php echo htmlspecialchars($output_dependant_select_form) ?></textarea>
                </div>
            </div>
<?php }
        ?>
    </div>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" defer src="<?php echo GENERATOR_URL; ?>generator-assets/javascripts/generator-single-elements.js"></script>
    <?php
    if (isset($form_select_fields)) {
        $form_select_fields->printIncludes('js');
        $form_select_fields->printJsCode();
    }
    ?>
</body>
</html>
