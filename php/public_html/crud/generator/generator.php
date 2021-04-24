<?php

use phpformbuilder\Form;
use phpformbuilder\FormExtended;
use phpformbuilder\database\Mysql;
use generator\Generator;
use common\Utils;

if (file_exists('conf/conf.php')) {
    include_once 'conf/conf.php';
} elseif (file_exists('../conf/conf.php')) {
    include_once '../conf/conf.php';
} else {
    exit('Configuration file not found (4)');
}
include_once GENERATOR_DIR . 'class/generator/Generator.php';
session_start();

// lock access on production server
if (ENVIRONMENT !== 'localhost' && GENERATOR_LOCKED === true) {
    include_once 'inc/protect.php';
}

// phpcrudgenerator.com navbar (include path from index router)
$body_padding_style = '';
if (file_exists('inc/navbar-main.php')) {
    define('IS_PHPCRUDGENERATOR_COM', true);
    $body_padding_style = ' style="padding-top:52px;"';
}

// default card header class
$card_header_class = 'h5 text-light font-weight-normal text-uppercase bg-gray-700';
// card active header class
$card_active_header_class = 'h5 text-light font-weight-normal text-uppercase bg-pink';
// add the 'dropdown-light' class to carets if cards headers are dark
$dropdown_toggle_class = 'dropdown-light';

// default classes for all forms rows
$row_class            = 'row pb-3 mb-3 ml-3 mr-3 border-bottom border-gray-300';
$row_last_child_class = 'row pb-3 mb-3 ml-3 mr-3';

// class for all fieldset legends
$legend_attr       = 'class=bg-gray-600 text-light';
$legend_icon_color = 'text-light';

if (!isset($_SESSION['generator'])) {
    $generator = new Generator(DEBUG);
} else {
    $generator = $_SESSION['generator'];
}
$generator->init();

if (!empty($generator->database)) {
    $form_reset_relations = new Form('form-reset-relations', 'inline');
    $form_reset_relations->useLoadJs('core');
    $form_reset_relations->setMode('development');

    // required just to transmit generator url to jQuery for the updater
    $form_reset_relations->addInput('hidden', 'generator-url', GENERATOR_URL);

    $form_reset_relations->setAction($_SERVER["REQUEST_URI"]);
    $form_reset_relations->addHtml('<div class="ml-auto">');
    $form_reset_relations->addInput('hidden', 'reset-relations', 1);
    $form_reset_relations->addBtn('submit', 'submit', 1, RESET . '<i class="' . ICON_RESET . ' position-right"></i>', 'class=btn btn-sm btn-warning float-right');
    $form_reset_relations->addHtml('</div>');
    $generator->getTables();

    if (isset($_POST['reset-table']) && $_POST['reset-table'] > 0 && DEMO !== true) {
        // select the posted table, which has been set as the new generator table
        $_SESSION['form-select-table']['table'] = $generator->table;
    }

    $form_select_table = new Form('form-select-table', 'inline');
    $form_select_table->useLoadJs('core');
    $form_select_table->setMode('development');
    $form_select_table->setAction($_SERVER["REQUEST_URI"]);
    $addon = '<button class="btn btn-success" type="submit">' . SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i></button>';
    $form_select_table->addAddon('table', $addon, 'after');
    foreach ($generator->tables as $table) {
        $form_select_table->addOption('table', $table, $table);
    }
    $form_select_table->addSelect('table', 'table : ', 'class=select2, data-dropdown-auto-width=true');

    $form_reset_table = new Form('form_reset_table', 'inline');
    $form_reset_table->useLoadJs('core');
    $form_reset_table->setMode('development');
    $form_reset_table->setAction($_SERVER["REQUEST_URI"]);
    $form_reset_table->addInput('hidden', 'reset-table', 1);
    $form_reset_table->addInput('hidden', 'table-to-reset', $generator->table);
    $form_reset_table->addInput('hidden', 'reset-data', 0);
    $form_reset_table->addBtn('button', 'btn-reset-table', 1, RESET . ' "<em>' . $generator->table . '</em>" ' . STRUCTURE . '<i class="' . ICON_RESET . ' position-right"></i>', 'class=btn btn-sm btn-warning');
}
if (!empty($generator->table)) {
    $generator->getDbColumns();
    $generator->registerColumnsProperties();
    $generator->runBuild();

    // get values from generator
    if (!isset($_POST['form-select-fields'])) {
        $_SESSION['form-select-fields']['action'] = 'build_read';
    }

    // Create the form before registering session values
    // to overwrite posted values with the generator ones
    // if the form has been posted
    $form_select_fields = new FormExtended('form-select-fields', 'horizontal', '');
    $form_select_fields->useLoadJs('core');
    $form_select_fields->setMode('development');
    $form_select_fields->setAction($_SERVER['REQUEST_URI']);
    $options = array(
        'elementsClass'       => 'form-control form-control-sm'
    );
    $form_select_fields->setOptions($options);

    /* =============================================
    Default List Values
    ============================================= */

    $_SESSION['form-select-fields']['list_type']               = $generator->list_options['list_type'];
    $_SESSION['form-select-fields']['rp_export_btn']           = $generator->list_options['export_btn'];
    $_SESSION['form-select-fields']['rp_open_url_btn']         = $generator->list_options['open_url_btn'];
    $_SESSION['form-select-fields']['rp_table_label']          = $generator->table_label;
    $_SESSION['form-select-fields']['rp_table_label']          = $generator->table_label;

    if ($generator->list_options['list_type'] !== 'build_single_element_list') {
        $_SESSION['form-select-fields']['rp_default_search_field'] = $generator->list_options['default_search_field'];
        $_SESSION['form-select-fields']['rp_bulk_delete']          = $generator->list_options['bulk_delete'];
        $_SESSION['form-select-fields']['rp_order_by']             = $generator->list_options['order_by'];
        $_SESSION['form-select-fields']['rp_order_direction']      = $generator->list_options['order_direction'];
    }

    // columns
    for ($i = 0; $i < $generator->columns_count; $i++) {
        $column_name     = $generator->columns['name'][$i];
        $column_type     = $generator->columns['column_type'][$i];
        $column_relation = $generator->columns['relation'][$i];

        // if one-to-many relation
        if (!empty($column_relation['target_table'])) {
            $target_fields = explode(', ', $column_relation['target_fields']);
            for ($j = 0; $j < 2; $j++) {
                if (isset($target_fields[$j])) {
                    $_SESSION['form-select-fields']['rp_target_column_' . $j . '_' . $column_name] = $target_fields[$j];
                    $_SESSION['form-select-fields']['rs_target_column_' . $j . '_' . $column_name] = $target_fields[$j];
                } else {
                    $_SESSION['form-select-fields']['rp_target_column_' . $j . '_' . $column_name] = '';
                    $_SESSION['form-select-fields']['rs_target_column_' . $j . '_' . $column_name] = '';
                }
            }
        }

        // label
        if (isset($generator->columns['fields'][$column_name])) {
            $_SESSION['form-select-fields']['rp_label_' . $column_name] = $generator->columns['fields'][$column_name];
            $_SESSION['form-select-fields']['rs_label_' . $column_name] = $generator->columns['fields'][$column_name];
        }

        // value type
        $_SESSION['form-select-fields']['rp_value_type_' . $column_name] = $generator->columns['value_type'][$i];
        $_SESSION['form-select-fields']['rs_value_type_' . $column_name] = $generator->columns['value_type'][$i];

        // jedit
        $_SESSION['form-select-fields']['rp_jedit_' . $column_name] = $generator->columns['jedit'][$i];
        $_SESSION['form-select-fields']['rs_jedit_' . $column_name] = $generator->columns['jedit'][$i];

        // special
        if ($generator->columns['value_type'][$i] == 'file') {
            $_SESSION['form-select-fields']['rp_special_file_dir_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rp_special_file_url_' . $column_name] = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['rp_special_file_types_' . $column_name] = $generator->columns['special3'][$i];
            $_SESSION['form-select-fields']['rs_special_file_dir_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rs_special_file_url_' . $column_name] = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['rs_special_file_types_' . $column_name] = $generator->columns['special3'][$i];
        } elseif ($generator->columns['value_type'][$i] == 'image') {
            $_SESSION['form-select-fields']['rp_special_image_dir_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rp_special_image_url_' . $column_name] = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['rp_special_image_thumbnails_' . $column_name] = $generator->columns['special3'][$i];
            $_SESSION['form-select-fields']['rs_special_image_dir_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rs_special_image_url_' . $column_name] = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['rs_special_image_thumbnails_' . $column_name] = $generator->columns['special3'][$i];
        } elseif ($generator->columns['value_type'][$i] == 'password') {
            $_SESSION['form-select-fields']['rp_special_password_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rs_special_password_' . $column_name] = $generator->columns['special'][$i];
        } elseif ($generator->columns['value_type'][$i] == 'date') {
            $_SESSION['form-select-fields']['rp_special_date_' . $column_name] = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['rs_special_date_' . $column_name] = $generator->columns['special'][$i];
        }

        // others
        $others = '';
        if ($generator->columns['sorting'][$i] == true) {
            $others = 'sorting';
        } elseif ($generator->columns['nested'][$i] == true) {
            $others = 'nested';
        } elseif ($generator->columns['skip'][$i] == true) {
            $others = 'skip';
        }
        $_SESSION['form-select-fields']['rp_others_' . $column_name] = $others;
    }

    // external relations
    if (count($generator->external_columns) > 0) {
        $i = 0;
        foreach ($generator->external_columns as $key => $ext_col) {
            if (!isset($ext_col['allow_crud_in_list'])) {
                $ext_col['allow_crud_in_list'] = false;
            }
            if (!isset($ext_col['allow_in_forms'])) {
                $ext_col['allow_in_forms'] = true;
            }
            if (!isset($ext_col['forms_fields'])) {
                $ext_col['forms_fields'] = array();
            }
            if (!isset($ext_col['field_type'])) {
                $ext_col['field_type'] = 'select-multiple';
            }
            $_SESSION['form-select-fields']['rp_ext_col_target_table-' . $i]       = $ext_col['active'];
            $_SESSION['form-select-fields']['rp_ext_col_target_fields-' . $i]      = $ext_col['target_fields'];
            $_SESSION['form-select-fields']['rp_ext_col_allow_crud_in_list-' . $i] = $ext_col['allow_crud_in_list'];
            $_SESSION['form-select-fields']['rs_ext_col_target_table-' . $i]       = $ext_col['active'];
            $_SESSION['form-select-fields']['rs_ext_col_target_fields-' . $i]      = $ext_col['target_fields'];
            $_SESSION['form-select-fields']['rs_ext_col_allow_crud_in_list-' . $i] = $ext_col['allow_crud_in_list'];

            $_SESSION['form-select-fields']['cu_ext_col_allow_in_forms-' . $i]     = $ext_col['allow_in_forms'];
            $_SESSION['form-select-fields']['cu_ext_col_forms_fields-' . $i]       = $ext_col['forms_fields'];
            $_SESSION['form-select-fields']['cu_ext_col_field_type-' . $i]         = $ext_col['field_type'];
            $i++;
        }
    }

    /* =============================================
    Default Create | Update Values
    ============================================= */

    // columns
    for ($i = 0; $i < $generator->columns_count; $i++) {
        $column_name = $generator->columns['name'][$i];
        $column_type = $generator->columns['column_type'][$i];
        $field_type  = $generator->columns['field_type'][$i];

        // file path & url | image path & url | date display format | password constraint
        if ($field_type == 'file') {
            $_SESSION['form-select-fields']['cu_special_file_dir_' . $column_name]        = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['cu_special_file_url_' . $column_name]        = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['cu_special_file_types_' . $column_name]      = $generator->columns['special3'][$i];
        } elseif ($field_type == 'image') {
            $_SESSION['form-select-fields']['cu_special_image_dir_' . $column_name]        = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['cu_special_image_url_' . $column_name]        = $generator->columns['special2'][$i];
            $_SESSION['form-select-fields']['cu_special_image_thumbnails_' . $column_name] = $generator->columns['special3'][$i];
            $_SESSION['form-select-fields']['cu_special_image_editor_' . $column_name]     = $generator->columns['special4'][$i];
            $_SESSION['form-select-fields']['cu_special_image_width_' . $column_name]      = $generator->columns['special5'][$i];
            $_SESSION['form-select-fields']['cu_special_image_height_' . $column_name]     = $generator->columns['special6'][$i];
            $_SESSION['form-select-fields']['cu_special_image_crop_' . $column_name]       = $generator->columns['special7'][$i];
        } elseif ($field_type == 'date' || $field_type == 'datetime' || $field_type == 'time' || $field_type == 'month') {
            $_SESSION['form-select-fields']['cu_special_date_' . $column_name]            = $generator->columns['special'][$i];
            $_SESSION['form-select-fields']['cu_special_date_now_hidden_' . $column_name] = $generator->columns['special3'][$i];
        } elseif ($field_type == 'password') {
            $_SESSION['form-select-fields']['cu_special_password_' . $column_name] = $generator->columns['special'][$i];
        }
        $_SESSION['form-select-fields']['cu_field_type_' . $column_name]      = $generator->columns['field_type'][$i];
        $_SESSION['form-select-fields']['cu_validation_type_' . $column_name] = $generator->columns['validation_type'][$i];
        $_SESSION['form-select-fields']['cu_help_text_' . $column_name]       = $generator->columns['help_text'][$i];
        $_SESSION['form-select-fields']['cu_tooltip_' . $column_name]         = $generator->columns['tooltip'][$i];
        $_SESSION['form-select-fields']['cu_char_count_' . $column_name]      = $generator->columns['char_count'][$i];
        $_SESSION['form-select-fields']['cu_char_count_max_' . $column_name]  = $generator->columns['char_count_max'][$i];
        $_SESSION['form-select-fields']['cu_tinyMce_' . $column_name]         = $generator->columns['tinyMce'][$i];
        $_SESSION['form-select-fields']['cu_field_width_' . $column_name]     = $generator->columns['field_width'][$i];
        // validation
        $column_validation = $generator->columns['validation'][$i];
        for ($j = 0; $j < count($column_validation); $j++) {
            $_SESSION['form-select-fields']['cu_validation_function_' . $column_name . '-' . $j] = $column_validation[$j]['function'];
            $_SESSION['form-select-fields']['cu_validation_arguments_' . $column_name . '-' . $j] = $column_validation[$j]['args'];
        }
    }

    /*=============================================
    =    Cascade delete + Bulk cascade delete     =
    =============================================*/

    // Look for other tables with foreign keys pointing to current one
    $constrained_from_to_relations = array();

    /* constrained_from_to_relations:
        array(
            'origin_table'
            'origin_column'
            'intermediate_table'
            'intermediate_column_1' // refers to origin_table
            'intermediate_column_2' // refers to target_table
            'target_table'
            'target_column',
            'cascade_delete' // true will automatically delete all matching records according to foreign keys constraints. Default: true
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

    if (!isset($_SESSION['form-select-fields']['constrained_tables'])) {
        $_SESSION['form-select-fields']['constrained_tables'] = array();
    }
    if (is_array($generator->relations['from_to_target_tables']) && in_array($generator->table, $generator->relations['from_to_target_tables'])) {
        $index = 0;
        $constrained_from_to_relations_indexes = array();
        foreach ($generator->relations['from_to'] as $from_to) {
            if ($from_to['target_table'] == $generator->table) {
                $constrained_from_to_relations[] = $from_to;
                $constrained_from_to_relations_indexes[] = $index;
                if (!empty($from_to['intermediate_table'])) {
                    $field_name = 'constrained_tables_' . $from_to['intermediate_table'];
                    $_SESSION['form-select-fields'][$field_name] = $from_to['cascade_delete_from_intermediate'];
                    // bulk delete value
                    $bulk_field_name = 'bulk_constrained_tables_' . $from_to['intermediate_table'];
                    $_SESSION['form-select-fields'][$bulk_field_name] = $from_to['cascade_delete_from_intermediate'];
                }
                $field_name = 'constrained_tables_' . $from_to['origin_table'];
                $_SESSION['form-select-fields'][$field_name] = $from_to['cascade_delete_from_origin'];
                // bulk delete value
                $bulk_field_name = 'bulk_constrained_tables_' . $from_to['origin_table'];
                $_SESSION['form-select-fields'][$bulk_field_name] = $from_to['cascade_delete_from_origin'];

                $_SESSION['form-select-fields']['constrained_tables'][] = $from_to['origin_table'];
            }
            $index++;
        }
    }

    // filters
    for ($i = 0; $i < count($generator->list_options['filters']); $i++) {
        $filter = $generator->list_options['filters'][$i];
        $_SESSION['form-select-fields']['filter-mode-' . $i]            = $filter['filter_mode'];
        $_SESSION['form-select-fields']['filter_field_A-' . $i]         = $filter['filter_A'];
        $_SESSION['form-select-fields']['filter_select_label-' . $i]    = $filter['select_label'];
        $_SESSION['form-select-fields']['filter_option_text-' . $i]     = $filter['option_text'];
        $_SESSION['form-select-fields']['filter_fields-' . $i]          = $filter['fields'];
        $_SESSION['form-select-fields']['filter_field_to_filter-' . $i] = $filter['field_to_filter'];
        $_SESSION['form-select-fields']['filter_from-' . $i]            = $filter['from'];
        $_SESSION['form-select-fields']['filter_type-' . $i]            = $filter['type'];
        $_SESSION['form-select-fields']['filter_column-' . $i]          = $filter['column'];

        // default values if not set
        $_SESSION['form-select-fields']['filter-ajax-' . $i]      = false;
        $_SESSION['form-select-fields']['filter-daterange-' . $i] = false;

        // else
        if (isset($filter['ajax'])) {
            $_SESSION['form-select-fields']['filter-ajax-' . $i] = $filter['ajax'];
        }
        if (isset($filter['daterange'])) {
            $_SESSION['form-select-fields']['filter-daterange-' . $i] = $filter['daterange'];
        }
    }

    // START 1st row
    $form_select_fields->startRowCol('row', 'col mb-4');

    // START 1st card
    $form_select_fields->startCard(SELECT_ACTION, '', $card_header_class);
    $form_select_fields->addInput('hidden', 'action');
    $form_select_fields->addHtml('<div class="card-deck mb-3">
        <a href="#" class="choose-action-radio card bg-dark" id="build_read">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="h6 card-title text-center text-white my-4"><span class="rounded-circle bg-pink-400"><i class="' . ICON_CHECKMARK . '"></i></span>' . BUILD . ' Read List</h4>
            </div>
        </a>
        <a href="#" class="choose-action-radio card bg-dark" id="build_create_edit">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="h6 card-title text-center text-white my-4"><span class="rounded-circle bg-pink-400"><i class="' . ICON_CHECKMARK . '"></i></span>' . BUILD . ' Create / Update Forms</h4>
            </div>
        </a>
        <a href="#" class="choose-action-radio card bg-dark" id="build_delete">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="h6 card-title text-center text-white my-4"><span class="rounded-circle bg-pink-400"><i class="' . ICON_CHECKMARK . '"></i></span>' . BUILD . ' Delete Form</h4>
            </div>
        </a>
    </div>');

    $form_select_fields->startDependentFields('action', 'build_read');
    $form_select_fields->addRadio('list_type', PAGINATED_LIST, 'build_paginated_list');
    $form_select_fields->addRadio('list_type', SINGLE_ELEMENT_LIST, 'build_single_element_list');
    $form_select_fields->printRadioGroup('list_type', CHOOSE_LIST_TYPE, true, 'class=pb-4');
    $form_select_fields->endDependentFields();

    // END 1st card
    $form_select_fields->endCard();

    // END 1st row
    $form_select_fields->endRowCol();

    /*__________ READ PAGINATED _________________*/

    $form_select_fields->startDependentFields('action', 'build_read');
    $form_select_fields->startDependentFields('list_type', 'build_paginated_list');
    $form_select_fields->addHtml('<div class="slide-div">');

    $form_select_fields->startCard(SELECT_OPTIONS_FOR_PAGINATED_LIST, '', $card_active_header_class);

    $form_select_fields->startFieldset('<i class="fas fa-cogs ' . $legend_icon_color . ' position-left"></i><span class="badge badge-flat ' . $legend_icon_color . ' position-left">' . $generator->table . '</span>' . MAIN_SETTINGS, 'class=mb-5', $legend_attr);
    $form_select_fields->setCols(2, 4, 'md');
    $form_select_fields->groupInputs('rp_open_url_btn', 'rp_export_btn');
    $form_select_fields->addRadio('rp_open_url_btn', YES, true);
    $form_select_fields->addRadio('rp_open_url_btn', NO, false);
    $form_select_fields->addHelper('<a href="https://www.phpcrudgenerator.com/tutorials/how-to-customize-the-bootstrap-admin-data-tables#open-url-button" target="_blank">' . NEED_HELP . '?<i class="' . ICON_NEW_TAB . ' text-center ml-2"></i></a>', 'rp_open_url_btn');
    $form_select_fields->printRadioGroup('rp_open_url_btn', OPEN_URL_BUTTON . OPEN_URL_BUTTON_TIP);
    $form_select_fields->addRadio('rp_export_btn', YES, true);
    $form_select_fields->addRadio('rp_export_btn', NO, false);
    $form_select_fields->printRadioGroup('rp_export_btn', EXPORT_CSV_BUTTON);
    $form_select_fields->groupInputs('rp_bulk_delete', 'rp_default_search_field');
    $form_select_fields->addRadio('rp_bulk_delete', YES, true);
    $form_select_fields->addRadio('rp_bulk_delete', NO, false);
    $form_select_fields->printRadioGroup('rp_bulk_delete', BULK_DELETE_BUTTON . BULK_DELETE_BUTTON_TIP);
    for ($i = 0; $i < $generator->columns_count; $i++) {
        $form_select_fields->addOption('rp_default_search_field', $generator->columns['name'][$i], $generator->columns['name'][$i]);
    }
    $form_select_fields->addSelect('rp_default_search_field', DEFAULT_SEARCH_FIELD, 'class=select2');

    $form_select_fields->startDependentFields('rp_bulk_delete', true);

    $index = 0;
    $done_tables = array();
    if (!empty($constrained_from_to_relations)) {
        $form_select_fields->startFieldset(CASCADE_DELETE_OPTIONS, 'class=mt-n4 mb-5 px-3 py-2');
        $form_select_fields->setCols(4, 8, 'md');
        foreach ($constrained_from_to_relations as $from_to) {
            $form_select_fields->addInput('hidden', 'bulk_from_to_indexes[]', $constrained_from_to_relations_indexes[$index]);
            // if intermediate table
            if (!empty($from_to['intermediate_table']) && !in_array($from_to['intermediate_table'], $done_tables)) {
                $form_select_fields->addRadio('bulk_constrained_tables_' . $from_to['intermediate_table'], YES, true);
                $form_select_fields->addRadio('bulk_constrained_tables_' . $from_to['intermediate_table'], NO, false);
                $form_select_fields->printRadioGroup('bulk_constrained_tables_' . $from_to['intermediate_table'], DELETE_RECORDS_FROM . ' "' . $from_to['intermediate_table'] . '"');
                $done_tables[] = $from_to['intermediate_table'];
            }
            if (!in_array($from_to['origin_table'], $done_tables)) {
                $form_select_fields->addRadio('bulk_constrained_tables_' . $from_to['origin_table'], YES, true);
                $form_select_fields->addRadio('bulk_constrained_tables_' . $from_to['origin_table'], NO, false);
                $form_select_fields->printRadioGroup('bulk_constrained_tables_' . $from_to['origin_table'], DELETE_RECORDS_FROM . ' "' . $from_to['origin_table'] . '"');
                $done_tables[] = $from_to['origin_table'];
            }
            $index++;
        }
        $form_select_fields->endFieldset();
    }
    $form_select_fields->endDependentFields();

    $form_select_fields->setCols(2, 4, 'md');
    $form_select_fields->groupInputs('rp_order_by', 'rp_order_direction');
    for ($i = 0; $i < $generator->columns_count; $i++) {
        $form_select_fields->addOption('rp_order_by', $generator->columns['name'][$i], $generator->columns['name'][$i]);
    }
    $form_select_fields->addSelect('rp_order_by', ORDER_BY, 'class=select2');
    $form_select_fields->setCols(0, 6, 'md');
    $form_select_fields->addOption('rp_order_direction', 'ASC', 'ASC');
    $form_select_fields->addOption('rp_order_direction', 'DESC', 'DESC');
    $form_select_fields->addSelect('rp_order_direction', '', 'class=select2');

    $form_select_fields->endFieldset();
    $form_select_fields->startFieldset('<i class="fas fa-signature ' . $legend_icon_color . ' position-left"></i><span class="badge badge-flat ' . $legend_icon_color . ' position-left">' . $generator->table . '</span>' . HUMAN_READABLE_NAMES, 'class=mb-5', $legend_attr);

    $form_select_fields->setCols(3, 3, 'md');
    $form_select_fields->addInput('text', 'rp_table_label', '', $generator->table);
    for ($i = 0; $i < $generator->columns_count; $i++) {
        if (Utils::pair($i) && $i + 1 < $generator->columns_count) {
            $form_select_fields->groupInputs('rp_label_' . $generator->columns['name'][$i], 'rp_label_' . $generator->columns['name'][$i + 1]);
        }
        $form_select_fields->addInput('text', 'rp_label_' . $generator->columns['name'][$i], '', $generator->columns['name'][$i]);
    }
    $form_select_fields->setCols(2, 4, 'md');

    // filters
    $form_select_fields->addInput('hidden', 'filters-dynamic-fields-index', count($generator->list_options['filters']) - 1);

    // Dynamic fields for filters - container + add button

    $form_select_fields->endFieldset();
    $form_select_fields->startFieldset('<i class="fas fa-filter ' . $legend_icon_color . ' position-left"></i><span class="badge badge-flat ' . $legend_icon_color . ' position-left">' . $generator->table . '</span>' . FILTER_DROPDOWNS, '', $legend_attr);

    $form_select_fields->addHtml('<div class="col-md-4 pt-3 pb-3 text-right"><button type="button" data-toggle="collapse" data-target="#filter-help" aria-expanded="false" aria-controls="filter-help" class="btn btn-sm bg-gray text-light dropdown-toggle dropdown-light">' . NEED_HELP . ' ?</button></div>');

    $form_select_fields->addHtml('<div class="col-12 mb-2 collapse" id="filter-help">' . FILTER_HELP . '</div>');
    $form_select_fields->addHtml('<div class="col-md-11">'); // START col
    $form_select_fields->addHtml(FILTER_HELP_3);
    $form_select_fields->addHtml('<div id="filters-ajax-elements-container" class="pr-10">'); // START ajax
    for ($i = 0; $i < count($generator->list_options['filters']); $i++) {
        $form_select_fields->addFilterFields($generator->table, $generator->db_columns['name'], $generator->db_columns['type'], $i);
    }
    $form_select_fields->addHtml('</div>'); // END ajax

    $form_select_fields->startRowCol('row justify-content-end', 'col pt-4 pb-4');

    $form_select_fields->addHtml('<button type="button" class="btn btn-sm btn-primary filters-add-element-button float-right legitRipple">' . ADD_FILTER . '<i class="' . ICON_PLUS . ' position-right"></i></button>');

    $form_select_fields->addHtml('</div>'); // END col
    $form_select_fields->addHtml('</div>'); // END row
    $form_select_fields->endFieldset();

    // values
    $form_select_fields->startFieldset('<i class="fas fa-database ' . $legend_icon_color . ' position-left"></i><span class="badge badge-flat ' . $legend_icon_color . ' position-left">' . $generator->table . '</span>' . $generator->table . ' ' . FIELDS, '', $legend_attr);

    // values types arrays
    $int      = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint');
    $decimal  = array('decimal', 'numeric', 'float', 'double', 'real');
    $boolean  = array('boolean');
    $date     = array('date', 'year');
    $datetime = array('datetime', 'timestamp');
    $time     = array('time');
    $string   = array('char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext');
    $sets     = array('enum', 'set');


    for ($i = 0; $i < $generator->columns_count; $i++) {
        $uniqid = uniqid();
        $column_name = $generator->columns['name'][$i];

        $column_type = $generator->columns['column_type'][$i];
        $has_relation = false;
        $target_table = '';
        $relation_label = '';
        // if one-to-many relation
        if (!empty($generator->columns['relation'][$i]['target_table'])) {
            $has_relation = true;
            $target_table = $generator->columns['relation'][$i]['target_table'];
            $relation_label = '<br><span class="badge badge-flat border-gray-600 text-gray-600 mt-1"><i class="' . ICON_TRANSMISSION . ' position-left"></i>' . $target_table . '</span>';
        }
        if ($i + 1 < $generator->columns_count) {
            $rc = $row_class;
        } else {
            $rc = $row_last_child_class;
        }
        $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
        $font_size_class = '';
        if (strlen($column_name) > 24) {
            $font_size_class = ' text-size-mini';
        } elseif (strlen($column_name) > 18) {
            $font_size_class = ' text-size-small';
        }
        $form_select_fields->addHtml('<label class="col-md-2 control-label' . $font_size_class . '">' . $column_name . $relation_label . '</label>');
        $form_select_fields->addHtml('<div class="col-md-10">'); // START col

        $form_select_fields->addHtml('<div class="skippable">'); // START wrapper to hide skipped fields

        $form_select_fields->setCols(2, 4, 'md');

        // value type
        // boolean|color|date|datetime|time|file|image|number|password|set|text|url
        $form_select_fields->groupInputs('rp_value_type_' . $column_name, 'rp_jedit_' . $column_name);
        if ($has_relation === true) {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'text', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $int) || in_array($column_type, $decimal)) {
            // if tinyInt, can be boolean
            if ($column_type == 'tinyint') {
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'number', NUMBER);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'boolean', BOOLEAN_CONST);
                $form_select_fields->addSelect('rp_value_type_' . $column_name, TYPE, 'class=select2 width-auto');
            } else {
                $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'number', TYPE, 'readonly, class=input-sm');
            }
        } elseif ($column_type == 'boolean') {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'boolean', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $date)) {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'date', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $datetime)) {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'datetime', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $time)) {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'time', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $string)) {
            if ($column_type == 'char' || $column_type == 'varchar' || $column_type == 'tinytext' || $column_type == 'text') {
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'text', TEXT_NUMBER);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'array', ARRAY_VALUE_TYPE);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'file', FILE);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'image', IMAGE);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'password', PASSWORD);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'color', COLOR);
                $form_select_fields->addOption('rp_value_type_' . $column_name, 'url', URL);
                $form_select_fields->addSelect('rp_value_type_' . $column_name, TYPE, 'class=select2 width-auto');
            } else {
                $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'text', TYPE, 'readonly, class=input-sm');
            }
        } elseif (in_array($column_type, $sets)) {
            $form_select_fields->addInput('text', 'rp_value_type_' . $column_name, 'set', TYPE, 'readonly, class=input-sm');
        }

        // edit in place
        $form_select_fields->addOption('rp_jedit_' . $column_name, false, DISABLED);
        $form_select_fields->addOption('rp_jedit_' . $column_name, 'text', TEXT_INPUT);
        $form_select_fields->addOption('rp_jedit_' . $column_name, 'textarea', TEXTAREA);
        $form_select_fields->addOption('rp_jedit_' . $column_name, 'boolean', BOOLEAN_CONST);
        $form_select_fields->addOption('rp_jedit_' . $column_name, 'select', SELECT_CONST);
        $form_select_fields->addOption('rp_jedit_' . $column_name, 'date', DATE_CONST);
        $form_select_fields->addSelect('rp_jedit_' . $column_name, EDIT_IN_PLACE, 'class=select2 width-auto');

        // "select" values
        if (in_array($column_type, $sets)) {
            $form_select_fields->startRowCol('row', 'col-md-offset-8 col-md-4 pt-4 pb-4');

            // show select values from generator data
            $select_values = $generator->getSelectValues($column_name);
            $form_select_fields->addHtml('<p>' . VALUES . ' : <span  id="rp_select-values-' . $column_name . '">' . $select_values . '</span></p>');

            $form_select_fields->endRowCol();

            $form_select_fields->setCols(8, 4, 'md');
            $form_select_fields->addBtn('button', 'rp_jedit_select_modal' . $column_name, '', ADD_EDIT_VALUES, 'class=btn btn-sm btn-success btn-sm, data-origin=rp_jedit, data-column=' . $column_name);
            $form_select_fields->setCols(2, 4, 'md');
        } else {
            //  Edit in place "select" values
            $form_select_fields->startDependentFields('rp_jedit_' . $column_name, 'select');
            $form_select_fields->startRowCol('row', 'col-md-offset-8 col-md-4 pt-4 pb-4');

            // show select values from generator data
            $select_values = $generator->getSelectValues($column_name);
            $form_select_fields->addHtml('<p>' . VALUES . ' : <span  id="rp_select-values-' . $column_name . '">' . $select_values . '</span></p>');

            $form_select_fields->endRowCol();

            $form_select_fields->setCols(8, 4, 'md');
            $form_select_fields->addBtn('button', 'rp_jedit_select_modal' . $column_name, '', ADD_EDIT_VALUES, 'class=btn btn-sm btn-success btn-sm, data-origin=rp_jedit, data-column=' . $column_name);
            $form_select_fields->setCols(2, 4, 'md');
            $form_select_fields->endDependentFields();
        }

        $form_select_fields->setCols(2, 10, 'md');

        // date
        if (in_array($column_type, $date)) {
            $placeholder = 'dddd dd mmm yyyy';
            if ($column_type == 'year') {
                $placeholder = 'yyyy';
            }
            $form_select_fields->addHtml('<div class="rp_special_date_wrapper mb-3">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rp-date-format-helper' . $uniqid . '" class="date-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rp-date-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rp_special_date_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rp_special_date_' . $column_name, '', DATE_DISPLAY_FORMAT . DATE_DISPLAY_TIP, 'placeholder=' . $placeholder . ', data-index=' . $i);
            $form_select_fields->addHtml('</div>');

            // datetime
        } elseif (in_array($column_type, $datetime)) {
            $form_select_fields->groupInputs('rp_special_date_' . $column_name, 'rp_special_time_' . $column_name);
            $form_select_fields->addHtml('<div class="rp_special_date_wrapper mb-3">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rp-date-format-helper' . $uniqid . '" class="date-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rp-date-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rp_special_date_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rp_special_date_' . $column_name, '', DATE_DISPLAY_FORMAT . DATE_DISPLAY_TIP, 'placeholder=dddd dd mmm yyyy, data-index=' . $i);
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rp-time-format-helper' . $uniqid . '" class="time-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rp-time-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rp_special_time_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rp_special_time_' . $column_name, '', TIME_DISPLAY_FORMAT . TIME_DISPLAY_TIP, 'placeholder=H:i a, data-index=' . $i);
            $form_select_fields->addHtml('</div>');

            // time
        } elseif (in_array($column_type, $time)) {
            $form_select_fields->addHtml('<div class="rp_special_date_wrapper mb-3">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rp-time-format-helper' . $uniqid . '" class="time-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rp-time-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rp_special_time_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rp_special_time_' . $column_name, '', TIME_DISPLAY_FORMAT . TIME_DISPLAY_TIP, 'placeholder=H:i a, data-index=' . $i);
            $form_select_fields->addHtml('</div>');
        } elseif (in_array($column_type, $string)) {
            if ($column_type == 'char' || $column_type == 'varchar' || $column_type == 'tinytext' || $column_type == 'text') {
                // file path & url
                $form_select_fields->startDependentFields('rp_value_type_' . $column_name, 'file');
                $form_select_fields->addIcon('rp_special_file_dir_' . $column_name, '[ROOT_PATH]/', 'before');
                $form_select_fields->addInput('text', 'rp_special_file_dir_' . $column_name, '', FILE_PATH . FILE_PATH_TIP, 'class=input-sm');
                $form_select_fields->addIcon('rp_special_file_url_' . $column_name, '[ROOT_URL]/', 'before');
                $form_select_fields->addInput('text', 'rp_special_file_url_' . $column_name, '', FILE_URL . FILE_URL_TIP, 'class=input-sm');
                $form_select_fields->addHelper(FILE_AUTHORIZED_HELPER, 'rp_special_file_types_' . $column_name);
                $form_select_fields->addInput('text', 'rp_special_file_types_' . $column_name, '', FILE_AUTHORIZED, 'class=input-sm');
                $form_select_fields->endDependentFields();

                // image path & url
                $form_select_fields->startDependentFields('rp_value_type_' . $column_name, 'image');
                $form_select_fields->addIcon('rp_special_image_dir_' . $column_name, '[ROOT_PATH]/', 'before');
                $form_select_fields->addInput('text', 'rp_special_image_dir_' . $column_name, '', IMAGE_PATH . IMAGE_PATH_TIP, 'class=input-sm');
                $form_select_fields->addIcon('rp_special_image_url_' . $column_name, '[ROOT_URL]/', 'before');
                $form_select_fields->addInput('text', 'rp_special_image_url_' . $column_name, '', IMAGE_URL . IMAGE_URL_TIP, 'class=input-sm');
                $form_select_fields->addRadio('rp_special_image_thumbnails_' . $column_name, NO, 0);
                $form_select_fields->addRadio('rp_special_image_thumbnails_' . $column_name, YES, 1);
                $form_select_fields->printRadioGroup('rp_special_image_thumbnails_' . $column_name, CREATE_IMAGE_THUMBNAILS . CREATE_IMAGE_THUMBNAILS_TIP);
                $form_select_fields->endDependentFields();

                // password constraints
                $form_select_fields->startDependentFields('rp_value_type_' . $column_name, 'password');
                $lower_char = mb_strtolower(LOWERCASE_CHARACTERS, 'UTF-8');
                $char       = mb_strtolower(CHARACTERS, 'UTF-8');

                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-3', MIN_3);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-4', MIN_4);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-5', MIN_5);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-6', MIN_6);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-7', MIN_7);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'min-8', MIN_8);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-3', LOWER_UPPER_MIN_3);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-4', LOWER_UPPER_MIN_4);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-5', LOWER_UPPER_MIN_5);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-6', LOWER_UPPER_MIN_6);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-7', LOWER_UPPER_MIN_7);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-min-8', LOWER_UPPER_MIN_8);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-3', LOWER_UPPER_NUMBER_MIN_3);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-4', LOWER_UPPER_NUMBER_MIN_4);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-5', LOWER_UPPER_NUMBER_MIN_5);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-6', LOWER_UPPER_NUMBER_MIN_6);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-7', LOWER_UPPER_NUMBER_MIN_7);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-min-8', LOWER_UPPER_NUMBER_MIN_8);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-3', LOWER_UPPER_NUMBER_SYMBOL_MIN_3);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-4', LOWER_UPPER_NUMBER_SYMBOL_MIN_4);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-5', LOWER_UPPER_NUMBER_SYMBOL_MIN_5);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-6', LOWER_UPPER_NUMBER_SYMBOL_MIN_6);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-7', LOWER_UPPER_NUMBER_SYMBOL_MIN_7);
                $form_select_fields->addOption('rp_special_password_' . $column_name, 'lower-upper-number-symbol-min-8', LOWER_UPPER_NUMBER_SYMBOL_MIN_8);
                $form_select_fields->addSelect('rp_special_password_' . $column_name, PASSWORD_CONSTRAINT, 'class=select2 width-auto');
                $form_select_fields->endDependentFields();
            }
        }
        if (in_array($column_type, $date) || in_array($column_type, $datetime)) {
            // date format helper
            $form_select_fields->setCols(2, 10, 'md');
            $form_select_fields->addHtml('<div id="rp-date-format-helper' . $uniqid . '" class="collapse">');
            $form_select_fields->addHtml('<table class="table small date-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>d</code></td> <td>Date of the month</td> <td>1 – 31</td> </tr> <tr> <td><code>dd</code></td> <td>Date of the month with a leading zero</td> <td>01 – 31</td> </tr> <tr> <td><code>ddd</code></td> <td>Day of the week in short form</td> <td>Sun – Sat</td> </tr> <tr> <td><code>dddd</code></td> <td>Day of the week in full form</td> <td>Sunday – Saturday</td> </tr> </tbody> <tbody> <tr> <td><code>m</code></td> <td>Month of the year</td> <td>1 – 12</td> </tr> <tr> <td><code>mm</code></td> <td>Month of the year with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>mmm</code></td> <td>Month name in short form</td> <td>Jan – Dec</td> </tr> <tr> <td><code>mmmm</code></td> <td>Month name in full form</td> <td>January – December</td> </tr> </tbody> <tbody> <tr> <td><code>yy</code></td> <td>Year in short form <b>*</b></td> <td>00 – 99</td> </tr> <tr> <td><code>yyyy</code></td> <td>Year in full form</td> <td>2000 – 2999</td> </tr> </tbody> </table>');
            $form_select_fields->addHtml('</div>');
        }

        // time format helper
        if (in_array($column_type, $time) || in_array($column_type, $datetime)) {
            $form_select_fields->addHtml('<div id="rp-time-format-helper' . $uniqid . '" class="collapse">');
            $form_select_fields->addHtml('<table class="table small time-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>h</code></td> <td>Hour in 12-hour format</td> <td>1 – 12</td> </tr> <tr> <td><code>hh</code></td> <td>Hour in 12-hour format with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>H</code></td> <td>Hour in 24-hour format</td> <td>0 – 23</td> </tr> <tr> <td><code>HH</code></td> <td>Hour in 24-hour format with a leading zero</td> <td>00 – 23</td> </tr> </tbody> <tbody> <tr> <td><code>i</code></td> <td>Minutes</td> <td>00 – 59</td> </tr> </tbody> <tbody> <tr> <td><code>a</code></td> <td>Day time period</td> <td>a.m. / p.m.</td> </tr> <tr> <td><code>A</code></td> <td>Day time period in uppercase</td> <td>AM / PM</td> </tr> </tbody> </table>');
            $form_select_fields->addHtml('</div>');
        }

        if ($has_relation === true) {
            // get fields from target table
            $db = new Mysql();
            $db->selectDatabase($generator->database);
            $qry = 'SHOW COLUMNS FROM ' . $target_table;
            $db->query($qry);
            $columns_count = $db->rowCount();

            // none value available for 2nd field only
            $form_select_fields->addOption('rp_target_column_1_' . $column_name, '', NONE);
            if (!empty($columns_count)) {
                while (!$db->endOfSeek()) {
                    $row = $db->row();
                    // last row is table comments, skip it.
                    if (isset($row->Field)) {
                        $field = $row->Field;
                        $form_select_fields->addOption('rp_target_column_0_' . $column_name, $field, $field);
                        $form_select_fields->addOption('rp_target_column_1_' . $column_name, $field, $field);
                    }
                }
            }
            $form_select_fields->addSelect('rp_target_column_0_' . $column_name, DISPLAY_VALUE . ' 1', 'class=select2 width-auto');
            $form_select_fields->addSelect('rp_target_column_1_' . $column_name, DISPLAY_VALUE . ' 2', 'class=select2 width-auto');
        }

        $form_select_fields->addHtml('</div>'); // END wrapper to hide skipped fields

        // others
        $form_select_fields->setCols(2, 10, 'md');
        $form_select_fields->addRadio('rp_others_' . $column_name, NONE, '');
        $form_select_fields->addRadio('rp_others_' . $column_name, ENABLE_SORTING, 'sorting');
        $form_select_fields->addRadio('rp_others_' . $column_name, NESTED_TABLE, 'nested');
        $form_select_fields->addRadio('rp_others_' . $column_name, '<span class="text-muted">' . SKIP_THIS_FIELD . '</span>', 'skip');
        $form_select_fields->printRadioGroup('rp_others_' . $column_name, OPTIONS);

        $form_select_fields->addHtml('</div>'); // END col
        $form_select_fields->addHtml('</div>'); // END row
    }

    $form_select_fields->endFieldset();

    // external relations
    if (count($generator->external_columns) > 0) {
        $form_select_fields->startFieldset('<i class="' . ICON_TRANSMISSION . ' ' . $legend_icon_color . ' position-left"></i><span class="badge badge-flat ' . $legend_icon_color . ' position-left">' . $generator->table . '</span>' . EXTERNAL_RELATIONS, '', $legend_attr);
        $i = 0;

        /*
        $ext_col             = array(
            'target_table'       => array(),
            'target_fields'      => array(),
            'name'               => array(),
            'label'              => array(),
            'allow_crud_in_list' => array(),
            'allow_in_forms'     => array(),
            'forms_fields'       => array(),
            'field_type'         => array(), // 'select-multiple' | 'checkboxes'
            'active'             => array()
        );
         */

        $db = new Mysql();
        $db->selectDatabase($generator->database);
        foreach ($generator->external_columns as $key => $ext_col) {
            // var_dump($ext_col);
            $origin_table       = $ext_col['relation']['origin_table'];
            $intermediate_table = $ext_col['relation']['intermediate_table'];
            $target_table       = $ext_col['relation']['target_table'];

            $form_select_fields->addHtml('<div class="row">'); // START row
            if (!empty($intermediate_table)) {
                // many to many
                $form_select_fields->addHtml('<label class="col-md-4 control-label">' . $target_table . '<br><small class="text-muted">(' . $origin_table . ' => ' . $intermediate_table . ' => ' . $target_table . ')</small></label>');
            } else {
                // one to many with the current table as target
                $form_select_fields->addHtml('<label class="col-md-4 control-label">' . $origin_table . '<br><small class="text-muted">(' . $origin_table . ' => ' . $target_table . ')</small></label>');
            }
            $form_select_fields->addHtml('<div class="col-md-8">'); // START col

            $form_select_fields->startRowCol('row', 'col');
            $form_select_fields->setCols(2, 10, 'md');
            $form_select_fields->addRadio('rp_ext_col_target_table-' . $i, YES, 1);
            $form_select_fields->addRadio('rp_ext_col_target_table-' . $i, NO, 0);
            $form_select_fields->printRadioGroup('rp_ext_col_target_table-' . $i, ENABLE);

            $form_select_fields->startDependentFields('rp_ext_col_target_table-' . $i, 1);
            if (empty($intermediate_table)) {
                $form_select_fields->setCols(5, 7, 'md');
            }
            $qry = 'SHOW COLUMNS FROM ' . $ext_col['target_table'];
            $db = new Mysql();
            $db->query($qry);
            $columns_count = $db->rowCount();
            if (!empty($columns_count)) {
                while (!$db->endOfSeek()) {
                    $row = $db->row();

                    // last row is table comments, skip it.
                    if (isset($row->Field)) {
                        $form_select_fields->addOption('rp_ext_col_target_fields-' . $i . '[]', $row->Field, $row->Field);
                    }
                }
                $form_select_fields->addSelect('rp_ext_col_target_fields-' . $i . '[]', FIELDS_TO_DISPLAY, 'class=select2, multiple');

                if (empty($intermediate_table)) {
                    $form_select_fields->addRadio('rp_ext_col_allow_crud_in_list-' . $i, YES, 1);
                    $form_select_fields->addRadio('rp_ext_col_allow_crud_in_list-' . $i, NO, 0);
                    $form_select_fields->printRadioGroup('rp_ext_col_allow_crud_in_list-' . $i, ALLOW_CRUD_IN_LIST);
                }
            }
            $form_select_fields->endDependentFields();
            $form_select_fields->endRowCol();
            $form_select_fields->endRowCol();

            // help dropdown
            if ($i + 1 < count($generator->external_columns)) {
                $rc = $row_class;
            } else {
                $rc = $row_last_child_class;
            }

            $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
            $form_select_fields->addHtml('<div class="col">'); // START col
            $form_select_fields->setCols(0, 12, 'justify-content-end', 'md');

            if (!empty($intermediate_table)) {
                // many to many
                $find = array('%origin_table%', '%intermediate_table%', '%target_table%');
                $replace = array($origin_table, $intermediate_table, $target_table);
                $helper_text = str_replace($find, $replace, EXPLAIN_RELATION_MANY_TO_MANY);
            } else {
                // one to many with the current table as target
                $find = array('%origin_table%', '%target_table%');
                $replace = array($origin_table, $target_table);
                $helper_text = str_replace($find, $replace, EXPLAIN_RELATION_ONE_TO_MANY);
            }
            $form_select_fields->addBtn('button', 'rs_ext_col_helper_btn_' . $i, 1, EXPLAIN_RELATION, 'data-toggle=collapse, data-target=#rs_ext_col_helper_' . $i . ', aria-expanded=false, aria-controls=rs_ext_col_helper_' . $i . ', class=btn btn-sm bg-gray text-light mt-2 mt-md-0 dropdown-toggle dropdown-light');
            $form_select_fields->addHtml('<div class="col mb-2 collapse" id="rs_ext_col_helper_' . $i . '">');
            $form_select_fields->addHtml($helper_text);
            $form_select_fields->addHtml('</div>');

            $form_select_fields->endRowCol();
            $i++;
        }
        $form_select_fields->endFieldset();
    }

    $form_select_fields->endCard();

    $form_select_fields->addHtml('</div>'); // END slide-div
    $form_select_fields->endDependentFields(); // END build_paginated_list
    $form_select_fields->endDependentFields(); // END build_read

    /*__________ CREATE | UPDATE _________________*/

    $form_select_fields->startDependentFields('action', 'build_create_edit');
    $form_select_fields->addHtml('<div class="slide-div">');
    $form_select_fields->addHtml('  <div class="card">');
    $form_select_fields->addHtml('      <div class="card-header ' . $card_active_header_class . '">' . SELECT_FIELDS_TYPES_FOR_CREATE_UPDATE . '</div>');
    $form_select_fields->addHtml('      <div class="card-body">');
    $form_select_fields->startFieldset('<i class="fas fa-database ' . $legend_icon_color . ' position-left"></i>' . $generator->table, '', $legend_attr);
    for ($i = 0; $i < $generator->columns_count; $i++) {
        $uniqid = uniqid();
        if ($i + 1 < $generator->columns_count) {
            $rc = $row_class;
        } else {
            $rc = $row_last_child_class;
        }
        $form_select_fields->setCols(3, 9, 'md');
        $column_name           = $generator->columns['name'][$i];
        $column_type           = $generator->columns['column_type'][$i];
        $column_validation     = $generator->columns['validation'][$i];
        $column_primary        = $generator->columns['primary'][$i];
        $column_auto_increment = $generator->columns['auto_increment'][$i];
        $primary_badge = '';
        if ($column_auto_increment == true) {
            $primary_badge = '<br><small class="badge badge-primary mt-1">primary</small>';
        }
        $ai_badge = '';
        if ($column_auto_increment == true) {
            $ai_badge = '<br><small class="badge badge-primary mt-1">auto-increment</small>';
        }
        $form_select_fields->addHtml('<div class="' . $rc . '">');
        $form_select_fields->addHtml('<label class="col-md-2">' . $column_name . $primary_badge . $ai_badge . '</label>');
        $form_select_fields->addHtml('<div class="col-md-10">');

        $form_select_fields->addOption('cu_field_type_' . $column_name, 'boolean', 'boolean');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'checkbox', 'checkbox');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'color', 'color');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'date', 'date');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'datetime', 'datetime');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'email', 'email');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'file', 'file');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'hidden', 'hidden');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'image', 'image');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'month', 'month');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'number', 'number');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'password', 'password');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'radio', 'radio');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'select', 'select');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'text', 'text');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'textarea', 'textarea');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'time', 'time');
        $form_select_fields->addOption('cu_field_type_' . $column_name, 'url', 'url');
        $form_select_fields->addSelect('cu_field_type_' . $column_name, FIELD, 'class=select2 width-auto, data-index=' . $i);

        if ($column_auto_increment == true) {
            $form_select_fields->addHtml(AUTO_INCREMENT_HELP);
        }

        // special (file path | image path | date display format | password constraint)

        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'file');
        $form_select_fields->addIcon('cu_special_file_dir_' . $column_name, '[ROOT_PATH]/', 'before');
        $form_select_fields->addInput('text', 'cu_special_file_dir_' . $column_name, '', FILE_PATH . FILE_PATH_TIP, 'data-index=' . $i);
        $form_select_fields->addIcon('cu_special_file_url_' . $column_name, '[ROOT_URL]/', 'before');
        $form_select_fields->addInput('text', 'cu_special_file_url_' . $column_name, '', FILE_URL . FILE_URL_TIP, 'data-index=' . $i);
        $form_select_fields->addHelper(FILE_AUTHORIZED_HELPER, 'cu_special_file_types_' . $column_name);
        $form_select_fields->addInput('text', 'cu_special_file_types_' . $column_name, '', FILE_AUTHORIZED, 'data-index=' . $i);
        $form_select_fields->endDependentFields();

        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'image');
        $form_select_fields->addIcon('cu_special_image_dir_' . $column_name, '[ROOT_PATH]/', 'before');
        $form_select_fields->addInput('text', 'cu_special_image_dir_' . $column_name, '', IMAGE_PATH . IMAGE_PATH_TIP, 'data-index=' . $i);
        $form_select_fields->addIcon('cu_special_image_url_' . $column_name, '[ROOT_URL]/', 'before');
        $form_select_fields->addInput('text', 'cu_special_image_url_' . $column_name, '', IMAGE_URL . IMAGE_URL_TIP, 'data-index=' . $i);
        $form_select_fields->addRadio('cu_special_image_thumbnails_' . $column_name, NO, 0);
        $form_select_fields->addRadio('cu_special_image_thumbnails_' . $column_name, YES, 1);
        $form_select_fields->printRadioGroup('cu_special_image_thumbnails_' . $column_name, CREATE_IMAGE_THUMBNAILS . CREATE_IMAGE_THUMBNAILS_TIP);
        $form_select_fields->addRadio('cu_special_image_editor_' . $column_name, NO, 0);
        $form_select_fields->addRadio('cu_special_image_editor_' . $column_name, YES, 1);
        $form_select_fields->printRadioGroup('cu_special_image_editor_' . $column_name, IMAGE_EDITOR . IMAGE_EDITOR_TIP);
        $form_select_fields->setCols(3, 3, 'md');
        $form_select_fields->groupInputs('cu_special_image_width_' . $column_name, 'cu_special_image_height_' . $column_name);
        $form_select_fields->addHelper(MAX_SIZE_HELPER, 'cu_special_image_width_' . $column_name);
        $form_select_fields->addInput('number', 'cu_special_image_width_' . $column_name, '', MAX_WIDTH);
        $form_select_fields->addHelper(MAX_SIZE_HELPER, 'cu_special_image_height_' . $column_name);
        $form_select_fields->addInput('number', 'cu_special_image_height_' . $column_name, '', MAX_HEIGHT);
        $form_select_fields->setCols(3, 9, 'md');
        $form_select_fields->addRadio('cu_special_image_crop_' . $column_name, NO, 0);
        $form_select_fields->addRadio('cu_special_image_crop_' . $column_name, YES, 1);
        $form_select_fields->printRadioGroup('cu_special_image_crop_' . $column_name, CROP);
        $form_select_fields->endDependentFields();

        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'date, datetime, month, time');
        $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#cu-date-format-helper' . $uniqid . '" class="cu-date-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="cu-date-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'cu_special_date_' . $column_name, 'after');
        $form_select_fields->addInput('text', 'cu_special_date_' . $column_name, '', DATE_DISPLAY_FORMAT . DATE_DISPLAY_TIP, 'placeholder=dddd dd mmm yyyy, data-index=' . $i);
        $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#cu-time-format-helper' . $uniqid . '" class="time-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="cu-time-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'cu_special_time_' . $column_name, 'after');
        $form_select_fields->addInput('text', 'cu_special_time_' . $column_name, '', TIME_DISPLAY_FORMAT . TIME_DISPLAY_TIP, 'placeholder=H:i a, data-index=' . $i);
        $form_select_fields->addHelper(DATE_NOW_HIDDEN_HELPER, 'cu_special_date_now_hidden_' . $column_name);
        $form_select_fields->addRadio('cu_special_date_now_hidden_' . $column_name, NO, 0);
        $form_select_fields->addRadio('cu_special_date_now_hidden_' . $column_name, YES, 1);
        $form_select_fields->printRadioGroup('cu_special_date_now_hidden_' . $column_name, DATE_NOW_HIDDEN);
        $form_select_fields->endDependentFields();

        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'password');
        $lower_char = mb_strtolower(LOWERCASE_CHARACTERS, 'UTF-8');
        $char       = mb_strtolower(CHARACTERS, 'UTF-8');
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-3', AT_LEAST . ' 3 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-4', AT_LEAST . ' 4 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-5', AT_LEAST . ' 5 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-6', AT_LEAST . ' 6 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-7', AT_LEAST . ' 7 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-min-8', AT_LEAST . ' 8 ' . $lower_char);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-min-8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-min-8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addOption('cu_special_password_' . $column_name, 'lower-upper-number-symbol-min-8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
        $form_select_fields->addSelect('cu_special_password_' . $column_name, PASSWORD_CONSTRAINT, 'class=select2 width-auto, data-index=' . $i);
        $form_select_fields->endDependentFields();

        // show select values from generator data
        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'select, radio, checkbox');
        $form_select_fields->addHtml('<div class="form-group row justify-content-start mb-3"><label class="col-md-3 col-form-label">' . VALUES . '</label>');
        $select_values = $generator->getSelectValues($column_name);
        $form_select_fields->addHtml('<div class="col-md-4"><p class="p-0"><span id="cu_select-values-' . $column_name . '">' . $select_values . '</span></p></div>');
        $form_select_fields->setOptions(array('buttonWrapper' => ''));
        $form_select_fields->setCols(0, 5, 'md');
        $form_select_fields->addBtn('button', 'cu_select_modal' . $column_name, '', ADD_EDIT_VALUES, 'class=btn btn-xs btn-success, data-origin=create-edit, data-column=' . $column_name);
        $form_select_fields->setOptions(array('buttonWrapper' => '<div class="form-group"></div>'));
        $form_select_fields->addHtml('</div>');
        $form_select_fields->endDependentFields();

        // date format helper
        $form_select_fields->setCols(3, 9, 'md');
        $form_select_fields->addHtml('<div id="cu-date-format-helper' . $uniqid . '" class="collapse">');
        $form_select_fields->addHtml('<table class="table small date-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>d</code></td> <td>Date of the month</td> <td>1 – 31</td> </tr> <tr> <td><code>dd</code></td> <td>Date of the month with a leading zero</td> <td>01 – 31</td> </tr> <tr> <td><code>ddd</code></td> <td>Day of the week in short form</td> <td>Sun – Sat</td> </tr> <tr> <td><code>dddd</code></td> <td>Day of the week in full form</td> <td>Sunday – Saturday</td> </tr> </tbody> <tbody> <tr> <td><code>m</code></td> <td>Month of the year</td> <td>1 – 12</td> </tr> <tr> <td><code>mm</code></td> <td>Month of the year with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>mmm</code></td> <td>Month name in short form</td> <td>Jan – Dec</td> </tr> <tr> <td><code>mmmm</code></td> <td>Month name in full form</td> <td>January – December</td> </tr> </tbody> <tbody> <tr> <td><code>yy</code></td> <td>Year in short form <b>*</b></td> <td>00 – 99</td> </tr> <tr> <td><code>yyyy</code></td> <td>Year in full form</td> <td>2000 – 2999</td> </tr> </tbody> </table>');
        $form_select_fields->addHtml('</div>');

        $form_select_fields->addHtml('<div id="cu-time-format-helper' . $uniqid . '" class="collapse">');
        $form_select_fields->addHtml('<table class="table small time-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>h</code></td> <td>Hour in 12-hour format</td> <td>1 – 12</td> </tr> <tr> <td><code>hh</code></td> <td>Hour in 12-hour format with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>H</code></td> <td>Hour in 24-hour format</td> <td>0 – 23</td> </tr> <tr> <td><code>HH</code></td> <td>Hour in 24-hour format with a leading zero</td> <td>00 – 23</td> </tr> </tbody> <tbody> <tr> <td><code>i</code></td> <td>Minutes</td> <td>00 – 59</td> </tr> </tbody> <tbody> <tr> <td><code>a</code></td> <td>Day time period</td> <td>a.m. / p.m.</td> </tr> <tr> <td><code>A</code></td> <td>Day time period in uppercase</td> <td>AM / PM</td> </tr> </tbody> </table>');
        $form_select_fields->addHtml('</div>');

        // help text: tooltip; options; field width
        $form_select_fields->startDependentFields('cu_field_type_' . $column_name, 'hidden', true);
        $form_select_fields->setCols(3, 3, 'md');
        $form_select_fields->groupInputs('cu_help_text_' . $column_name, 'cu_tooltip_' . $column_name);
        $form_select_fields->addInput('text', 'cu_help_text_' . $column_name, '', HELP_TEXT);
        $form_select_fields->addHelper(NO_HTML, 'cu_tooltip_' . $column_name);
        $form_select_fields->addInput('text', 'cu_tooltip_' . $column_name, '', TOOLTIP);

        $form_select_fields->groupInputs('cu_options_' . $column_name, 'cu_field_width_' . $column_name);
        $form_select_fields->addCheckbox('cu_options_' . $column_name, CHAR_COUNT, 'char_count_' . $column_name, 'class=char-count');
        $form_select_fields->addCheckbox('cu_options_' . $column_name, TINYMCE, 'tinyMce_' . $column_name, 'class=tinymce');
        $form_select_fields->printCheckboxGroup('cu_options_' . $column_name, OPTIONS);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '100%', '100%', SINGLE);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '66% single', '66% ' . SINGLE, SINGLE);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '50% single', '50% ' . SINGLE, SINGLE);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '33% single', '33% ' . SINGLE, SINGLE);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '66% grouped', '66% ' . GROUPED, GROUPED);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '50% grouped', '50% ' . GROUPED, GROUPED);
        $form_select_fields->addOption('cu_field_width_' . $column_name, '33% grouped', '33% ' . GROUPED, GROUPED);
        $form_select_fields->addSelect('cu_field_width_' . $column_name, FIELD_WIDTH . GROUPED_SINGLE_TIP, 'class=select2 width-auto');

        $form_select_fields->startDependentFields('cu_options_' . $column_name, 'char_count_' . $column_name);
        $form_select_fields->addInput('text', 'char_count_max_' . $column_name, '', CHAR_COUNT_MAX);
        $form_select_fields->endDependentFields();
        $form_select_fields->endDependentFields();

        $form_select_fields->setCols(3, 9, 'md');

        /* =============================================
        Validation
        ============================================= */

        $form_select_fields->addHtml('<div class="validation-col px-4 py-2">'); // START validation-col

        // validation type
        if ($column_auto_increment === true) {
            $options_muted = array(
                'radioWrapper' => '<div class="form-check justify-content-start text-muted"></div>',
                'inlineRadioLabelClass' => 'form-check-label disabled'
            );
            $options_normal = array(
                'radioWrapper' => '<div class="form-check justify-content-start"></div>',
                'inlineRadioLabelClass' => 'form-check-label'
            );

            $form_select_fields->setOptions($options_muted);
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, NONE, 'none', 'disabled');
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, AUTO, 'auto', 'checked');
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, CUSTOM, 'custom', 'disabled');

            $form_select_fields->printRadioGroup('cu_validation_type_' . $column_name, VALIDATION);

            $form_select_fields->setOptions($options_normal);
        } else {
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, NONE, 'none');
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, AUTO, 'auto');
            $form_select_fields->addRadio('cu_validation_type_' . $column_name, CUSTOM, 'custom');
            $form_select_fields->printRadioGroup('cu_validation_type_' . $column_name, VALIDATION);
        }

        // validation auto
        $form_select_fields->startDependentFields('cu_validation_type_' . $column_name, 'auto');
        $form_select_fields->addHtml('<div id="validation-auto-ajax-elements-container-' . $column_name . '">');

        $form_select_fields->addHtml('</div>');
        $form_select_fields->endDependentFields();

        // validation custom
        $form_select_fields->startDependentFields('cu_validation_type_' . $column_name, 'custom');
        $form_select_fields->addInput('hidden', 'validation-dynamic-fields-index-' . $column_name, count($column_validation) - 1);

        // Dynamic fields - container + add button
        $form_select_fields->addHtml('<div id="validation-custom-ajax-elements-container-' . $column_name . '">');
        for ($j = 0; $j < count($column_validation); $j++) {
            if (!isset($_SESSION['form-select-fields']['cu_validation_function_' . $column_name . '-' . $j])) {
                // default = required
                $helper_text = $validation_helper_texts['required'];
            } else {
                $function = $_SESSION['form-select-fields']['cu_validation_function_' . $column_name . '-' . $j];
                if (!empty($function)) {
                    $helper_text = $validation_helper_texts[$function];
                }
            }
            $form_select_fields->addCustomValidationFields($column_name, $j, $helper_text);
        }
        $form_select_fields->addHtml('</div>');
        $form_select_fields->addHtml('<div class="row">'); // START row
        $form_select_fields->addHtml('<div class="col pt-4 pb-2">'); // START col-md-4
        $form_select_fields->addHtml('<button type="button" class="btn btn-success validation-add-element-button btn-sm float-right">' . ADD . '<i class="' . ICON_PLUS . ' icon-sm position-right"></i></button>');
        $form_select_fields->addHtml('</div>'); // END col-md-4
        $form_select_fields->addHtml('</div>'); // END row
        $form_select_fields->endDependentFields();

        $form_select_fields->addHtml('</div>'); // END validation-col
        $form_select_fields->addHtml('</div>'); // END main col-md-10
        $form_select_fields->addHtml('</div>'); // END main row
    }
    $form_select_fields->addHtml('          </fieldset>'); // END fieldset

    // external relations
    if (count($generator->external_columns) > 0) {
        $show_external = false;
        $active_ext_cols = array();
        foreach ($generator->external_columns as $key => $ext_col) {
            if ($ext_col['active'] === true && !empty($ext_col['relation']['intermediate_table'])) {
                $show_external = true;
                $active_ext_cols[] = $ext_col;
            }
        }
        if ($show_external === true) {
            $form_select_fields->startFieldset('<i class="' . ICON_TRANSMISSION . ' ' . $legend_icon_color . ' position-left"></i>' . EXTERNAL_RELATIONS, '', $legend_attr);
            $i = 0;

            /*
            $ext_col = array(
                'target_table'       => array(),
                'target_fields'      => array(),
                'name'               => array(),
                'label'              => array(),
                'allow_crud_in_list' => array(),
                'allow_in_forms'     => array(),
                'forms_fields'       => array(),
                'field_type'         => array(), // 'select-multiple' | 'checkboxes'
                'active'             => array()
            );
             */

            $db = new Mysql();
            $db->selectDatabase($generator->database);
            foreach ($active_ext_cols as $key => $ext_col) {
                // var_dump($ext_col);
                $origin_table       = $ext_col['relation']['origin_table'];
                $intermediate_table = $ext_col['relation']['intermediate_table'];
                $target_table       = $ext_col['relation']['target_table'];
                if ($i + 1 < count($active_ext_cols)) {
                    $rc = $row_class;
                } else {
                    $rc = $row_last_child_class;
                }

                $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
                if (!empty($intermediate_table)) {
                    // many to many
                    $form_select_fields->addHtml('<label class="col-md-4 control-label">' . $target_table . '<br><small class="text-muted">(' . $origin_table . ' => ' . $intermediate_table . ' => ' . $target_table . ')</small></label>');
                    $form_select_fields->addHtml('<div class="col-md-8">'); // START col

                    $form_select_fields->startRowCol('row', 'col');
                    $form_select_fields->setCols(-1, -1, 'md');
                    $form_select_fields->addRadio('cu_ext_col_allow_in_forms-' . $i, YES, 1);
                    $form_select_fields->addRadio('cu_ext_col_allow_in_forms-' . $i, NO, 0);
                    $find = array('%origin_table%', '%target_table%');
                    $replace = array($origin_table, $target_table);
                    $radio_label = str_replace($find, $replace, ALLOW_RECORDS_MANAGEMENT_IN_FORMS);
                    $form_select_fields->printRadioGroup('cu_ext_col_allow_in_forms-' . $i, $radio_label);

                    $form_select_fields->setCols(2, 10, 'md');
                    $form_select_fields->startDependentFields('cu_ext_col_allow_in_forms-' . $i, 1);
                    $qry = 'SHOW COLUMNS FROM ' . $ext_col['target_table'];
                    $db = new Mysql();
                    $db->query($qry);
                    $columns_count = $db->rowCount();
                    if (!empty($columns_count)) {
                        while (!$db->endOfSeek()) {
                            $row = $db->row();

                            // last row is table comments, skip it.
                            if (isset($row->Field)) {
                                $form_select_fields->addOption('cu_ext_col_forms_fields-' . $i . '[]', $row->Field, $row->Field);
                            }
                        }
                        $form_select_fields->addSelect('cu_ext_col_forms_fields-' . $i . '[]', VALUES_TO_DISPLAY, 'class=select2, multiple, data-maximum-selection-length=2, required');

                        $form_select_fields->addRadio('cu_ext_col_field_type-' . $i, SELECT_MULTIPLE, 'select-multiple');
                        $form_select_fields->addRadio('cu_ext_col_field_type-' . $i, CHECKBOXES, 'checkboxes');
                        $form_select_fields->printRadioGroup('cu_ext_col_field_type-' . $i, FIELD_TYPE);
                    }
                    $form_select_fields->endDependentFields();
                    $form_select_fields->endRowCol();
                    $form_select_fields->endRowCol();
                }
                $i++;
            }
            $form_select_fields->endFieldset();
        } // end if
    } // end if

    $form_select_fields->addHtml('      </div>'); // END card-body
    $form_select_fields->addHtml('  </div>'); // END card
    $form_select_fields->addHtml('</div>'); // END slide-div
    $form_select_fields->endDependentFields();

    /*__________ READ SINGLE _________________*/

    $form_select_fields->startDependentFields('action', 'build_read');
    $form_select_fields->startDependentFields('list_type', 'build_single_element_list');
    $form_select_fields->addHtml('<div class="slide-div">');

    $form_select_fields->startCard(SELECT_OPTIONS_FOR_SINGLE_ELEMENT_LIST, '', $card_active_header_class);

    $form_select_fields->startFieldset('<i class="fas fa-cogs ' . $legend_icon_color . ' position-left"></i>' . MAIN_SETTINGS, '', $legend_attr);
    $form_select_fields->startRowCol($row_class, 'col');
    $form_select_fields->setCols(2, 4, 'md');
    $form_select_fields->groupInputs('rs_open_url_btn', 'rs_export_btn');
    $form_select_fields->addRadio('rs_open_url_btn', YES, true);
    $form_select_fields->addRadio('rs_open_url_btn', NO, false);
    $form_select_fields->printRadioGroup('rs_open_url_btn', OPEN_URL_BUTTON . OPEN_URL_BUTTON_TIP);
    $form_select_fields->addRadio('rs_export_btn', YES, true);
    $form_select_fields->addRadio('rs_export_btn', NO, false);
    $form_select_fields->printRadioGroup('rs_export_btn', EXPORT_CSV_BUTTON);
    $form_select_fields->endRowCol();

    $form_select_fields->addHtml('<div class="' . $row_class . '">'); // START row
    $form_select_fields->addHtml('<div class="col-12 pt-3 pb-3"><span class="badge badge-flat badge-primary position-left">' . $generator->table . '</span><label>' . HUMAN_READABLE_NAMES . '</label></div>');
    $form_select_fields->addHtml('<div class="col-12 pt-3 pb-3">'); // START col
    $form_select_fields->setCols(3, 3, 'md');
    $form_select_fields->addInput('text', 'rs_table_label', '', $generator->table);
    for ($i = 0; $i < $generator->columns_count; $i++) {
        if (Utils::pair($i) && $i + 1 < $generator->columns_count) {
            $form_select_fields->groupInputs('rs_label_' . $generator->columns['name'][$i], 'rs_label_' . $generator->columns['name'][$i + 1]);
        }
        $form_select_fields->addInput('text', 'rs_label_' . $generator->columns['name'][$i], '', $generator->columns['name'][$i]);
    }
    $form_select_fields->endRowCol();
    $form_select_fields->endFieldset();

    // values
    $form_select_fields->startFieldset('<i class="fas fa-database ' . $legend_icon_color . ' position-left"></i>' . $generator->table, '', $legend_attr);

    // values types arrays
    $int      = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint');
    $decimal  = array('decimal', 'numeric', 'float', 'double', 'real');
    $boolean  = array('boolean');
    $date     = array('date', 'year');
    $datetime = array('datetime', 'timestamp');
    $time     = array('time');
    $string   = array('char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext');
    $sets     = array('enum', 'set');


    for ($i = 0; $i < $generator->columns_count; $i++) {
        $uniqid = uniqid();
        $column_name = $generator->columns['name'][$i];

        $column_type = $generator->columns['column_type'][$i];
        $has_relation = false;
        $target_table = '';
        $relation_label = '';
        // if one-to-many relation
        if (!empty($generator->columns['relation'][$i]['target_table'])) {
            $has_relation = true;
            $target_table = $generator->columns['relation'][$i]['target_table'];
            $relation_label = '<br><span class="badge badge-flat border-gray-600 text-gray-600 mt-1"><i class="' . ICON_TRANSMISSION . ' position-left"></i>' . $target_table . '</span>';
        }
        if ($i + 1 < $generator->columns_count) {
            $rc = $row_class;
        } else {
            $rc = $row_last_child_class;
        }
        $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
        $font_size_class = '';
        if (strlen($column_name) > 24) {
            $font_size_class = ' text-size-mini';
        } elseif (strlen($column_name) > 18) {
            $font_size_class = ' text-size-small';
        }
        $form_select_fields->addHtml('<label class="col-md-2 control-label' . $font_size_class . '">' . $column_name . $relation_label . '</label>');
        $form_select_fields->addHtml('<div class="col-md-10">'); // START col

        $form_select_fields->setCols(2, 4, 'md');

        // value type
        // boolean|color|date|datetime|time|image|number|password|set|text|url
        $form_select_fields->groupInputs('rs_value_type_' . $column_name, 'rs_jedit_' . $column_name);
        if ($has_relation === true) {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'text', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $int) || in_array($column_type, $decimal)) {
            // if tinyInt, can be boolean
            if ($column_type == 'tinyint') {
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'number', NUMBER);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'boolean', BOOLEAN_CONST);
                $form_select_fields->addSelect('rs_value_type_' . $column_name, TYPE, 'class=select2 width-auto');
            } else {
                $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'number', TYPE, 'readonly, class=input-sm');
            }
        } elseif ($column_type == 'boolean') {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'boolean', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $date)) {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'date', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $datetime)) {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'datetime', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $time)) {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'time', TYPE, 'readonly, class=input-sm');
        } elseif (in_array($column_type, $string)) {
            if ($column_type == 'char' || $column_type == 'varchar' || $column_type == 'tinytext' || $column_type == 'text') {
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'text', TEXT_NUMBER);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'file', FILE);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'image', IMAGE);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'password', PASSWORD);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'color', COLOR);
                $form_select_fields->addOption('rs_value_type_' . $column_name, 'url', URL);
                $form_select_fields->addSelect('rs_value_type_' . $column_name, TYPE, 'class=select2 width-auto');
            } else {
                $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'text', TYPE, 'readonly, class=input-sm');
            }
        } elseif (in_array($column_type, $sets)) {
            $form_select_fields->addInput('text', 'rs_value_type_' . $column_name, 'set', TYPE, 'readonly, class=input-sm');
        }

        // edit in place
        $form_select_fields->addOption('rs_jedit_' . $column_name, false, DISABLED);
        $form_select_fields->addOption('rs_jedit_' . $column_name, 'text', TEXT_INPUT);
        $form_select_fields->addOption('rs_jedit_' . $column_name, 'textarea', TEXTAREA);
        $form_select_fields->addOption('rs_jedit_' . $column_name, 'boolean', BOOLEAN_CONST);
        $form_select_fields->addOption('rs_jedit_' . $column_name, 'select', SELECT_CONST);
        $form_select_fields->addOption('rs_jedit_' . $column_name, 'date', DATE_CONST);
        $form_select_fields->addSelect('rs_jedit_' . $column_name, EDIT_IN_PLACE, 'class=select2 width-auto');

        // "select" values
        if (in_array($column_type, $sets)) {
            $form_select_fields->startRowCol('row', 'col-md-offset-8 col-md-4 pt-4 pb-4');

            // show select values from generator data
            $select_values = $generator->getSelectValues($column_name);
            $form_select_fields->addHtml('<p>' . VALUES . ' : <span  id="rs_select-values-' . $column_name . '">' . $select_values . '</span></p>');

            $form_select_fields->endRowCol();

            $form_select_fields->setCols(8, 4, 'md');
            $form_select_fields->addBtn('button', 'rs_jedit_select_modal' . $column_name, '', ADD_EDIT_VALUES, 'class=btn btn-sm btn-success btn-sm, data-origin=rs_jedit, data-column=' . $column_name);
            $form_select_fields->setCols(2, 4, 'md');
        } else {
            //  Edit in place "select" values
            $form_select_fields->startDependentFields('rs_jedit_' . $column_name, 'select');
            $form_select_fields->startRowCol('row', 'col-md-offset-8 col-md-4 pt-4 pb-4');

            // show select values from generator data
            $select_values = $generator->getSelectValues($column_name);
            $form_select_fields->addHtml('<p>' . VALUES . ' : <span  id="rs_select-values-' . $column_name . '">' . $select_values . '</span></p>');

            $form_select_fields->endRowCol();

            $form_select_fields->setCols(8, 4, 'md');
            $form_select_fields->addBtn('button', 'rs_jedit_select_modal' . $column_name, '', ADD_EDIT_VALUES, 'class=btn btn-sm btn-success btn-sm, data-origin=rs_jedit, data-column=' . $column_name);
            $form_select_fields->setCols(2, 4, 'md');
            $form_select_fields->endDependentFields();
        }

        $form_select_fields->setCols(2, 10, 'md');

        // date
        if (in_array($column_type, $date)) {
            $placeholder = 'dddd dd mmm yyyy';
            if ($column_type == 'year') {
                $placeholder = 'yyyy';
            }
            $form_select_fields->addHtml('<div class="rs_special_date_wrapper">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rs-date-format-helper' . $uniqid . '" class="date-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rs-date-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rs_special_date_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rs_special_date_' . $column_name, '', DATE_DISPLAY_FORMAT . DATE_DISPLAY_TIP, 'placeholder=' . $placeholder . ', data-index=' . $i);
            $form_select_fields->addHtml('</div>');

            // datetime
        } elseif (in_array($column_type, $datetime)) {
            $form_select_fields->groupInputs('rs_special_date_' . $column_name, 'rs_special_time_' . $column_name);
            $form_select_fields->addHtml('<div class="rs_special_date_wrapper">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rs-date-format-helper' . $uniqid . '" class="date-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rs-date-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rs_special_date_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rs_special_date_' . $column_name, '', DATE_DISPLAY_FORMAT . DATE_DISPLAY_TIP, 'placeholder=dddd dd mmm yyyy, data-index=' . $i);
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rs-time-format-helper' . $uniqid . '" class="time-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rs-time-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rs_special_time_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rs_special_time_' . $column_name, '', TIME_DISPLAY_FORMAT . TIME_DISPLAY_TIP, 'placeholder=H:i a, data-index=' . $i);
            $form_select_fields->addHtml('</div>');

            // time
        } elseif (in_array($column_type, $time)) {
            $form_select_fields->addHtml('<div class="rs_special_date_wrapper">');
            $form_select_fields->addHtml('<span class="form-text text-muted"><a href="#rs-time-format-helper' . $uniqid . '" class="time-format-helper-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="rs-time-format-helper' . $uniqid . '">' . DATE_HELPER . '</a></span>', 'rs_special_time_' . $column_name, 'after');
            $form_select_fields->addInput('text', 'rs_special_time_' . $column_name, '', TIME_DISPLAY_FORMAT . TIME_DISPLAY_TIP, 'placeholder=H:i a, data-index=' . $i);
            $form_select_fields->addHtml('</div>');
        } elseif (in_array($column_type, $string)) {
            if ($column_type == 'char' || $column_type == 'varchar' || $column_type == 'tinytext' || $column_type == 'text') {
                // file path & url
                $form_select_fields->startDependentFields('rs_value_type_' . $column_name, 'file');
                $form_select_fields->addIcon('rs_special_file_dir_' . $column_name, '[ROOT_PATH]/', 'before');
                $form_select_fields->addInput('text', 'rs_special_file_dir_' . $column_name, '', FILE_PATH . FILE_PATH_TIP, 'class=input-sm');
                $form_select_fields->addIcon('rs_special_file_url_' . $column_name, '[ROOT_URL]/', 'before');
                $form_select_fields->addInput('text', 'rs_special_file_url_' . $column_name, '', FILE_URL . FILE_URL_TIP, 'class=input-sm');
                $form_select_fields->addHelper(FILE_AUTHORIZED_HELPER, 'rs_special_file_types_' . $column_name);
                $form_select_fields->addInput('text', 'rs_special_file_types_' . $column_name, '', FILE_AUTHORIZED, 'class=input-sm');
                $form_select_fields->endDependentFields();

                // image path & url
                $form_select_fields->startDependentFields('rs_value_type_' . $column_name, 'image');
                $form_select_fields->addIcon('rs_special_image_dir_' . $column_name, '[ROOT_PATH]/', 'before');
                $form_select_fields->addInput('text', 'rs_special_image_dir_' . $column_name, '', IMAGE_PATH . IMAGE_PATH_TIP, 'class=input-sm');
                $form_select_fields->addIcon('rs_special_image_url_' . $column_name, '[ROOT_URL]/', 'before');
                $form_select_fields->addInput('text', 'rs_special_image_url_' . $column_name, '', IMAGE_URL . IMAGE_URL_TIP, 'class=input-sm');
                $form_select_fields->addRadio('rs_special_image_thumbnails_' . $column_name, NO, 0);
                $form_select_fields->addRadio('rs_special_image_thumbnails_' . $column_name, YES, 1);
                $form_select_fields->printRadioGroup('rs_special_image_thumbnails_' . $column_name, CREATE_IMAGE_THUMBNAILS . CREATE_IMAGE_THUMBNAILS_TIP);
                $form_select_fields->endDependentFields();

                // password constraints
                $form_select_fields->startDependentFields('rs_value_type_' . $column_name, 'password');
                $lower_char = mb_strtolower(LOWERCASE_CHARACTERS, 'UTF-8');
                $char       = mb_strtolower(CHARACTERS, 'UTF-8');

                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-3', MIN_3);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-4', MIN_4);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-5', MIN_5);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-6', MIN_6);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-7', MIN_7);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'min-8', MIN_8);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-3', LOWER_UPPER_MIN_3);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-4', LOWER_UPPER_MIN_4);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-5', LOWER_UPPER_MIN_5);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-6', LOWER_UPPER_MIN_6);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-7', LOWER_UPPER_MIN_7);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-min-8', LOWER_UPPER_MIN_8);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-3', LOWER_UPPER_NUMBER_MIN_3);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-4', LOWER_UPPER_NUMBER_MIN_4);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-5', LOWER_UPPER_NUMBER_MIN_5);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-6', LOWER_UPPER_NUMBER_MIN_6);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-7', LOWER_UPPER_NUMBER_MIN_7);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-min-8', LOWER_UPPER_NUMBER_MIN_8);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-3', LOWER_UPPER_NUMBER_SYMBOL_MIN_3);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-4', LOWER_UPPER_NUMBER_SYMBOL_MIN_4);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-5', LOWER_UPPER_NUMBER_SYMBOL_MIN_5);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-6', LOWER_UPPER_NUMBER_SYMBOL_MIN_6);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-7', LOWER_UPPER_NUMBER_SYMBOL_MIN_7);
                $form_select_fields->addOption('rs_special_password_' . $column_name, 'lower-upper-number-symbol-min-8', LOWER_UPPER_NUMBER_SYMBOL_MIN_8);
                $form_select_fields->addSelect('rs_special_password_' . $column_name, PASSWORD_CONSTRAINT, 'class=select2 width-auto');
                $form_select_fields->endDependentFields();
            }
        }
        if (in_array($column_type, $date) || in_array($column_type, $datetime)) {
            // date format helper
            $form_select_fields->setCols(2, 10, 'md');
            $form_select_fields->addHtml('<div id="rs-date-format-helper' . $uniqid . '" class="collapse">');
            $form_select_fields->addHtml('<table class="table small date-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>d</code></td> <td>Date of the month</td> <td>1 – 31</td> </tr> <tr> <td><code>dd</code></td> <td>Date of the month with a leading zero</td> <td>01 – 31</td> </tr> <tr> <td><code>ddd</code></td> <td>Day of the week in short form</td> <td>Sun – Sat</td> </tr> <tr> <td><code>dddd</code></td> <td>Day of the week in full form</td> <td>Sunday – Saturday</td> </tr> </tbody> <tbody> <tr> <td><code>m</code></td> <td>Month of the year</td> <td>1 – 12</td> </tr> <tr> <td><code>mm</code></td> <td>Month of the year with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>mmm</code></td> <td>Month name in short form</td> <td>Jan – Dec</td> </tr> <tr> <td><code>mmmm</code></td> <td>Month name in full form</td> <td>January – December</td> </tr> </tbody> <tbody> <tr> <td><code>yy</code></td> <td>Year in short form <b>*</b></td> <td>00 – 99</td> </tr> <tr> <td><code>yyyy</code></td> <td>Year in full form</td> <td>2000 – 2999</td> </tr> </tbody> </table>');
            $form_select_fields->addHtml('</div>');
        }

        // time format helper
        if (in_array($column_type, $time) || in_array($column_type, $datetime)) {
            $form_select_fields->addHtml('<div id="rs-time-format-helper' . $uniqid . '" class="collapse">');
            $form_select_fields->addHtml('<table class="table small time-table"> <thead> <tr> <th>Rule</th> <th>Description</th> <th>Result</th> </tr> </thead> <tbody> <tr> <td><code>h</code></td> <td>Hour in 12-hour format</td> <td>1 – 12</td> </tr> <tr> <td><code>hh</code></td> <td>Hour in 12-hour format with a leading zero</td> <td>01 – 12</td> </tr> <tr> <td><code>H</code></td> <td>Hour in 24-hour format</td> <td>0 – 23</td> </tr> <tr> <td><code>HH</code></td> <td>Hour in 24-hour format with a leading zero</td> <td>00 – 23</td> </tr> </tbody> <tbody> <tr> <td><code>i</code></td> <td>Minutes</td> <td>00 – 59</td> </tr> </tbody> <tbody> <tr> <td><code>a</code></td> <td>Day time period</td> <td>a.m. / p.m.</td> </tr> <tr> <td><code>A</code></td> <td>Day time period in uppercase</td> <td>AM / PM</td> </tr> </tbody> </table>');
            $form_select_fields->addHtml('</div>');
        }

        if ($has_relation === true) {
            // get fields from target table
            $db = new Mysql();
            $db->selectDatabase($generator->database);
            $qry = 'SHOW COLUMNS FROM ' . $target_table;
            $db->query($qry);
            $columns_count = $db->rowCount();

            // none value available for 2nd field only
            $form_select_fields->addOption('rs_target_column_1_' . $column_name, '', NONE);
            if (!empty($columns_count)) {
                while (!$db->endOfSeek()) {
                    $row = $db->row();
                    // last row is table comments, skip it.
                    if (isset($row->Field)) {
                        $field = $row->Field;
                        $form_select_fields->addOption('rs_target_column_0_' . $column_name, $field, $field);
                        $form_select_fields->addOption('rs_target_column_1_' . $column_name, $field, $field);
                    }
                }
            }
            $form_select_fields->groupInputs('rs_target_column_0_' . $column_name, 'rs_target_column_1_' . $column_name);
            $form_select_fields->addSelect('rs_target_column_0_' . $column_name, DISPLAY_VALUE . ' 1', 'class=select2 width-auto');
            $form_select_fields->addSelect('rs_target_column_1_' . $column_name, DISPLAY_VALUE . ' 2', 'class=select2 width-auto');
        }

        // others
        $form_select_fields->setCols(2, 10, 'md');
        $form_select_fields->addCheckbox('rs_others_' . $column_name, '<span class="text-muted">' . SKIP_THIS_FIELD . '</span>', 'skip');
        $form_select_fields->printCheckboxGroup('rs_others_' . $column_name, OPTIONS);

        $form_select_fields->addHtml('</div>'); // END col
        $form_select_fields->addHtml('</div>'); // END row
    }

    $form_select_fields->endFieldset();

    // external relations
    if (count($generator->external_columns) > 0) {
        $form_select_fields->startFieldset('<i class="' . ICON_TRANSMISSION . ' ' . $legend_icon_color . ' position-left"></i>' . EXTERNAL_RELATIONS, '', $legend_attr);
        $i = 0;

        /*
        $ext_col = array(
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
         */

        $db = new Mysql();
        $db->selectDatabase($generator->database);
        foreach ($generator->external_columns as $key => $ext_col) {
            // var_dump($ext_col);
            $origin_table       = $ext_col['relation']['origin_table'];
            $intermediate_table = $ext_col['relation']['intermediate_table'];
            $target_table       = $ext_col['relation']['target_table'];
            if ($i + 1 < count($generator->external_columns)) {
                $rc = $row_class;
            } else {
                $rc = $row_last_child_class;
            }

            $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
            if (!empty($intermediate_table)) {
                // many to many
                $form_select_fields->addHtml('<label class="col-md-4 control-label">' . $target_table . '<br><small class="text-muted">(' . $origin_table . ' => ' . $intermediate_table . ' => ' . $target_table . ')</small></label>');
            } else {
                // one to many with the current table as target
                $form_select_fields->addHtml('<label class="col-md-4 control-label">' . $origin_table . '<br><small class="text-muted">(' . $origin_table . ' => ' . $target_table . ')</small></label>');
            }
            $form_select_fields->addHtml('<div class="col-md-8">'); // START col

            $form_select_fields->startRowCol('row', 'col');
            $form_select_fields->setCols(2, 10, 'md');
            $form_select_fields->addRadio('rs_ext_col_target_table-' . $i, YES, 1);
            $form_select_fields->addRadio('rs_ext_col_target_table-' . $i, NO, 0);
            $form_select_fields->printRadioGroup('rs_ext_col_target_table-' . $i, ENABLE);

            $form_select_fields->startDependentFields('rs_ext_col_target_table-' . $i, 1);
            if (empty($intermediate_table)) {
                $form_select_fields->setCols(5, 7, 'md');
            }
            $qry = 'SHOW COLUMNS FROM ' . $ext_col['target_table'];
            $db = new Mysql();
            $db->query($qry);
            $columns_count = $db->rowCount();
            if (!empty($columns_count)) {
                while (!$db->endOfSeek()) {
                    $row = $db->row();

                    // last row is table comments, skip it.
                    if (isset($row->Field)) {
                        $form_select_fields->addOption('rs_ext_col_target_fields-' . $i . '[]', $row->Field, $row->Field);
                    }
                }
                $form_select_fields->addSelect('rs_ext_col_target_fields-' . $i . '[]', FIELDS_TO_DISPLAY, 'class=select2, multiple');
                if (empty($intermediate_table)) {
                    $form_select_fields->addRadio('rs_ext_col_allow_crud_in_list-' . $i, YES, 1);
                    $form_select_fields->addRadio('rs_ext_col_allow_crud_in_list-' . $i, NO, 0);
                    $form_select_fields->printRadioGroup('rs_ext_col_allow_crud_in_list-' . $i, ALLOW_CRUD_IN_LIST);
                }
            }
            $form_select_fields->endDependentFields();
            $form_select_fields->endRowCol();
            $form_select_fields->endRowCol();

            // help dropdown
            if ($i + 1 < count($generator->external_columns)) {
                $rc = $row_class;
            } else {
                $rc = $row_last_child_class;
            }

            $form_select_fields->addHtml('<div class="' . $rc . '">'); // START row
            $form_select_fields->addHtml('<div class="col">'); // START col
            $form_select_fields->setCols(0, 12, 'justify-content-end', 'md');

            if (!empty($intermediate_table)) {
                // many to many
                $find = array('%origin_table%', '%intermediate_table%', '%target_table%');
                $replace = array($origin_table, $intermediate_table, $target_table);
                $helper_text = str_replace($find, $replace, EXPLAIN_RELATION_MANY_TO_MANY);
            } else {
                // one to many with the current table as target
                $find = array('%origin_table%', '%target_table%');
                $replace = array($origin_table, $target_table);
                $helper_text = str_replace($find, $replace, EXPLAIN_RELATION_ONE_TO_MANY);
            }
            $form_select_fields->addBtn('button', 'rs_ext_col_helper_btn_' . $i, 1, EXPLAIN_RELATION, 'data-toggle=collapse, data-target=#rs_ext_col_helper2_' . $i . ', aria-expanded=false, aria-controls=rs_ext_col_helper2_' . $i . ', class=btn btn-sm bg-gray text-light dropdown-toggle dropdown-light');
            $form_select_fields->addHtml('<div class="col mb-2 collapse" id="rs_ext_col_helper2_' . $i . '">');
            $form_select_fields->addHtml($helper_text);
            $form_select_fields->addHtml('</div>');

            $form_select_fields->endRowCol();

            $i++;
        }
        $form_select_fields->endFieldset();
    }

    $form_select_fields->endCard();

    $form_select_fields->addHtml('</div>'); // END slide-div
    $form_select_fields->endDependentFields(); // END build_single_element_list
    $form_select_fields->endDependentFields(); // END build_read

    /*__________ DELETE _________________*/

    $form_select_fields->startDependentFields('action', 'build_delete');
    $form_select_fields->addHtml('<div class="slide-div">');
    $form_select_fields->addHtml('<div class="card">');
    $form_select_fields->addHtml('<div class="card-header ' . $card_active_header_class . '">' . SELECT_OPTIONS_FOR_DELETE_FORM . '</div>');
    $form_select_fields->addHtml('<div class="card-body">');
    $form_select_fields->setCols(4, 8, 'md');

    foreach ($generator->columns['name'] as $column_name) {
        $form_select_fields->addOption('field_delete_confirm_1', $column_name, $column_name);
    }
    $form_select_fields->addSelect('field_delete_confirm_1', FIELD_DELETE_CONFIRM, 'class=select2 width-auto');

    $form_select_fields->addOption('field_delete_confirm_2', '', NONE);
    foreach ($generator->columns['name'] as $column_name) {
        $form_select_fields->addOption('field_delete_confirm_2', $column_name, $column_name);
    }
    $form_select_fields->addSelect('field_delete_confirm_2', FIELD_DELETE_CONFIRM . ' (n°2)', 'class=select2 width-auto');
    $form_select_fields->addHtml(FIELD_DELETE_CONFIRM_HELP);


    $index = 0;
    $done_tables = array();
    foreach ($constrained_from_to_relations as $from_to) {
        $form_select_fields->addInput('hidden', 'from_to_indexes[]', $constrained_from_to_relations_indexes[$index]);
        // if intermediate table
        if (!empty($from_to['intermediate_table']) && !in_array($from_to['intermediate_table'], $done_tables)) {
            $form_select_fields->addRadio('constrained_tables_' . $from_to['intermediate_table'], YES, true);
            $form_select_fields->addRadio('constrained_tables_' . $from_to['intermediate_table'], NO, false);
            $form_select_fields->printRadioGroup('constrained_tables_' . $from_to['intermediate_table'], DELETE_RECORDS_FROM . ' "' . $from_to['intermediate_table'] . '"');
            $done_tables[] = $from_to['intermediate_table'];
        }
        if (!in_array($from_to['origin_table'], $done_tables)) {
            $form_select_fields->addRadio('constrained_tables_' . $from_to['origin_table'], YES, true);
            $form_select_fields->addRadio('constrained_tables_' . $from_to['origin_table'], NO, false);
            $form_select_fields->printRadioGroup('constrained_tables_' . $from_to['origin_table'], DELETE_RECORDS_FROM . ' "' . $from_to['origin_table'] . '"');
            $done_tables[] = $from_to['origin_table'];
        }
        $index++;
    }

    $form_select_fields->addHtml('</div>'); // END card-body
    $form_select_fields->addHtml('</div>'); // END card
    $form_select_fields->addHtml('</div>'); // END slide-div
    $form_select_fields->endDependentFields();

    $form_select_fields->addHtml('<p>&nbsp;</p>');
    $form_select_fields->setCols(0, 12, 'md');
    $form_select_fields->centerButtons(true);
    $form_select_fields->addBtn('button', 'form-select-fields-submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button');

    // Custom radio & checkbox css
    $form_select_fields->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'green']);
}


/* ===========================================================
Get admin current state (locked|unlocked)
Get current Secure state ($secure_installed = true|false|)
Generate corresponding heading elements
=========================================================== */
$secure_installed = false;
if (file_exists(ADMIN_DIR . 'secure/install/install.lock')) {
    $secure_installed = true;

    $form_lock_unlock_admin = new Form('lock-unlock-admin', 'horizontal', '');
    $form_lock_unlock_admin->useLoadJs('core');
    $form_lock_unlock_admin->setMode('development');
    $form_lock_unlock_admin->setAction($_SERVER["REQUEST_URI"]);
    if ($generator->authentication_module_enabled !== true) {
        $form_lock_unlock_admin->addInput('hidden', 'lock-admin', 1);
    } else {
        $form_lock_unlock_admin->addInput('hidden', 'unlock-admin', 1);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP CRUD - Admin Panel Generator</title>
    <meta name="description" content="PHP CRUD generates your CRUD admin panel to manage your website content - PHPCG">
    <link href="https://www.phpcrudgenerator.com/crud-generator-demo" rel="canonical">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/pace-theme-minimal.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <script src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/pace.min.js"></script>
</head>
<body<?php echo $body_padding_style; ?>>
    <?php

    // hidden form to lock|unlock admin
    if (isset($form_lock_unlock_admin)) {
        $form_lock_unlock_admin->render();
    }
    ?>
    <?php
    // phpcrudgenerator.com navbar for demo website
    if (defined('IS_PHPCRUDGENERATOR_COM')) {
        include_once 'inc/navbar-main.php';
    }
    ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-indigo navbar-tall">
        <h3 class="h4 ml-2 mb-0"><i class="fas fa-wrench fa-lg position-left"></i>PHP CRUD Generator</h3>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-main">
            <div class="btn-group ml-auto my-2 my-lg-0">
                <?php
                if ($secure_installed !== true) {
                    // Install auth. module button
                    ?>
                <a href="<?php echo ADMIN_URL; ?>secure/install/index.php" class="btn btn-sm bg-indigo-400 text-white legitRipple" target="_blank"><i class="fas fa-magic position-left"></i> <?php echo INSTALL_ADMIN_AUTHENTIFICATION_MODULE; ?></a>
                <?php
                } else {
                    if ($generator->authentication_module_enabled !== true) {
                    // Lock admin button
                        ?>
                <button type="button" class="btn btn-sm bg-white legitRipple"><i class="<?php echo ICON_UNLOCK; ?> text-danger-600 position-left"></i><?php echo ADMIN_AUTHENTIFICATION_MODULE_IS_DISABLED; ?></button>
                <button type="button" class="btn btn-sm bg-white pr-4 dropdown-toggle legitRipple" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" id="lock-admin-link"><i class="<?php echo ICON_CHECKMARK; ?> text-success-600 position-left"></i><?php echo ENABLE; ?></a>
                    <a class="dropdown-item" href="#" id="remove-authentification-module"><i class="<?php echo ICON_DELETE; ?> text-danger-600 position-left"></i><?php echo REMOVE; ?></a>
                </div>
                <?php
                    } else {
                        // Unlock admin button
                        ?>
                <button type="button" class="btn btn-sm bg-white legitRipple"><i class="<?php echo ICON_LOCK; ?> text-success-600 position-left"></i><?php echo ADMIN_AUTHENTIFICATION_MODULE_IS_ENABLED; ?></button>
                <button type="button" class="btn btn-sm bg-white pr-4 dropdown-toggle legitRipple" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" id="lock-admin-link"><i class="<?php echo ICON_UNLOCK; ?> text-danger-600 position-left"></i><?php echo DISABLE; ?></a>
                </div>
                <?php
                    }
                }
                ?>
                <?php
                if (ENVIRONMENT !== 'localhost' && GENERATOR_LOCKED === true) {
                    // Logout button
                    ?>
                <a href="logout.php" class="btn btn-sm bg-white text-danger-600 legitRipple" title="<?php echo LOGOUT; ?>"><i class="<?php echo ICON_LOCK; ?> text-danger-600 position-left"></i><?php echo LOGOUT; ?></a>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <?php
        $update_class = 'mb-5';
        if (defined('IS_PHPCRUDGENERATOR_COM')) {
            $update_class = 'mb-n3';
        }
    ?>
    <div class="<?php echo $update_class; ?>"><?php include_once 'update/index.php'; ?></div>
    <?php
    // phpcrudgenerator.com navbar for demo website
    if (defined('IS_PHPCRUDGENERATOR_COM')) {
        include_once 'inc/breadcrumb.php';
    }
    ?>
    <div class="container">
        <?php
        if (isset($_SESSION['msg'])) {
            if (!strpos($_SESSION['msg'], LOGIN_ERROR)) {
                echo $_SESSION['msg'];
            }
            unset($_SESSION['msg']);
        }
        ?>
        <?php
        if (!empty($generator->database)) {
            ?>
        <h1 class="border-bottom display-4 text-gray pb-2 mb-5"><span class="text-muted">PHP CRUD Generator</span> - <?php echo DATABASE_CONST ?> <?php echo $generator->database ?></h1>
        <?php if (DEMO === true) { ?>
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="alert alert-info has-icon shadow-sm">
                    <h2>PHP CRUD generator - Create your Bootstrap Admin Panel from here</h2>
                    <p class="font-weight-bold">You are here in the PHP CRUD generator, which allows you to generate your <a href="https://www.phpcrudgenerator.com/admin/home">Bootstrap admin panel</a> from any MySQL database in a few clicks.</p>
                    <hr>
                    <ol>
                        <li class="font-weight-bold mb-2">Select the table that you want to add in your admin panel.</li>
                        <li class="font-weight-bold mb-2">To create your CRUD pages, click one of the 3 big buttons:
                            <div class="d-md-flex my-1">
                                <a href="#form-select-fields" class="btn btn-sm bg-pink text-white text-decoration-none mr-3 mb-2">Build READ List</a>
                                <a href="#form-select-fields" class="btn btn-sm bg-pink text-white text-decoration-none mr-3 mb-2">Build Create / Update Forms</a>
                                <a href="#form-select-fields" class="btn btn-sm bg-pink text-white text-decoration-none mb-2">Build Delete Form</a>
                            </div>
                        </li>
                        <li class="font-weight-bold">Choose your options for each field then confirm at the bottom of the page</li>
                    </ol>
                    <div class="d-flex justify-content-end"><a href="/admin/home" class="btn btn-info text-decoration-none" title="Switch to the Admin Panel">Switch to the Admin Panel</a></div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row justify-content-md-center">
            <div class="col-md-10 mb-5">
                <div class="card card-collapsed">
                    <div class="card-header <?php echo $card_header_class; ?>"><?php echo TOOLS; ?>
                        <div class="heading-elements">
                            <a class="dropdown-toggle <?php echo $dropdown_toggle_class; ?>" data-toggle="collapse" href="#tools" role="button" aria-expanded="false" aria-controls="relations"></a>
                        </div>
                    </div>
                    <div class="card-body collapse" id="tools">
                        <div class="row justify-content-md-center mb-4">
                            <?php
                                if (!empty($generator->diff_files_form)) {
                                    ?>
                            <div class="col-lg-8">
                                <div class="card-text d-flex justify-content-center mb-4 mb-lg-0">
                                    <?php $generator->diff_files_form->render(); ?>
                                </div>
                            </div>
                            <?php
                                }
                                ?>
                            <div class="col-lg-4">
                                <div class="card-text d-flex justify-content-end">
                                    <a href="<?php echo BASE_URL; ?>generator/general-settings-form.php" class="btn btn-primary" target="_blank"><?php echo GENERAL_SETTINGS ?><span class="fa fa-lg fa-cogs append"></span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                            if (file_exists(ADMIN_DIR . 'crud-data/nav-data.json')) {
                                ?>
                        <div class="row mb-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card-text d-flex justify-content-end">
                                    <a href="<?php echo BASE_URL; ?>generator/organize-navbar.php" class="btn btn-primary" target="_blank"><?php echo ORGANIZE_ADMIN_NAVBAR ?><span class="fa fa-lg fa-map-signs append"></span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                            ?>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card-text d-flex justify-content-end">
                                    <a href="#" id="reload-db-structure-link" class="btn btn-warning btn-sm"><?php echo RELOAD_DB_STRUCTURE ?><span class="fa fa-lg fa-sync-alt append"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-10 mb-5">
                <div class="card card-collapsed">
                    <div class="card-header <?php echo $card_header_class; ?>"><?php echo $generator->database . ' ' . RELATIONS; ?>
                        <div class="heading-elements">
                            <a class="dropdown-toggle <?php echo $dropdown_toggle_class; ?>" data-toggle="collapse" href="#relations" role="button" aria-expanded="false" aria-controls="relations"></a>
                        </div>
                    </div>
                    <div class="card-body collapse" id="relations">
                        <div class="card-text">
                            <?php

                                // Relations table
                                if (!empty($generator->relations)) {
                                    ?>
                            <div class="table-responsive">
                                <table class="table table-sm mb-4">
                                    <thead>
                                        <tr class="bt-0">
                                            <th><?php echo TABLE; ?></th>
                                            <th><?php echo COLUMN; ?></th>
                                            <th><?php echo REFERENCED_TABLE; ?></th>
                                            <th><?php echo REFERENCED_COLUMN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                foreach ($generator->relations['db'] as $r) {
                                                    ?>
                                        <tr>
                                            <td><?php echo $r['table']; ?></td>
                                            <td><?php echo $r['column']; ?></td>
                                            <td><?php echo $r['referenced_table']; ?></td>
                                            <td><?php echo $r['referenced_column']; ?></td>
                                        </tr>
                                        <?php
                                                } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php }
                                $form_reset_relations->render();
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        if (isset($form_select_table)) {
            ?>
        <div class="row justify-content-md-center">
            <div class="col-md-10 mb-5">
                <div class="card">
                    <div class="card-header <?php echo $card_header_class; ?>"><?php echo CHOOSE_TABLE; ?></div>
                    <div class="card-body">
                        <div class="row justify-content-md-center align-items-end">
                            <div class="col-lg-8">
                                <div class="card-text d-flex justify-content-center mb-4 mb-lg-0">
                                    <?php $form_select_table->render(); ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-text d-flex justify-content-end">
                                    <?php $form_reset_table->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        if (DEMO === true) {
            ?>
        <div class="alert alert-info has-icon">
            <p class="mb-0">All CRUD operations are disabled in this demo.</p>
        </div>
            <?php
        }
        if (isset($form_select_fields)) {
            $form_select_fields->render();
        }
        ?>
    </div>
    <?php
    if ($generator->debug === true) {
        ?>
    <div id="debug">
        <button id="btn-debug" type="button" class="btn btn-sm btn-danger">DEBUG</button>
        <?php
            if (isset($_SESSION['log-msg'])) {
                echo $_SESSION['log-msg'];
                unset($_SESSION['log-msg']);
            } else {
                echo '<p>No debug message registered</p>';
            } ?>
    </div>
        <?php
    }
    ?>
    <div class="remodal-bg">
        <div data-remodal-id="modal">
            <button data-remodal-action="close" class="remodal-close"></button>
            <div id="remodal-content"></div>
            <button data-remodal-action="cancel" class="remodal-cancel"><?php echo CANCEL; ?></button>
            <button data-remodal-action="confirm" class="remodal-confirm"><?php echo OK; ?></button>
        </div>
    </div>
    <div id="ajax-update-validation-helper"></div>

    <script src="<?php echo ADMIN_URL; ?>assets/javascripts/loadjs.min.js"></script>
    <script>
        var adminUrl = '<?php echo ADMIN_URL; ?>';
        var generatorUrl = '<?php echo GENERATOR_URL; ?>';
    </script>

    <script src="<?php echo GENERATOR_URL; ?>generator-assets/javascripts/generator.min.js"></script>
    <?php
    if (isset($form_select_fields)) {
        $form_select_table->printJsCode();
    }
    if (isset($form_select_fields)) {
        $form_select_fields->printJsCode();
    }
    if (!empty($generator->diff_files_form)) {
        $generator->diff_files_form->printJsCode();
    }
    ?>
    </body>

</html>
