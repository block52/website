<?php
use phpformbuilder\Form;
use phpformbuilder\database\Mysql;
use generator\Generator;
use common\Utils;

include_once '../class/generator/Generator.php';

@session_start();
if (isset($_SESSION['generator']) && isset($_GET['column']) && preg_match('([0-9a-zA-Z_-]+)', $_GET['column'])) {
    include_once '../../conf/conf.php';
    $generator = $_SESSION['generator'];
    $editable_column = $_GET['column'];

    if (DEMO === true) {
        ?>
        <div class="alert alert-info has-icon">
            <h4 class="mb-0">All CRUD operations are disabled in this demo.</h4>
        </div>
        <?php
    }

    /* =============================================
    editable column sent from generator
    ============================================= */

    if (isset($_GET['action']) && $_GET['action'] == 'select-table') {
        // get values from generator
        $index = array_search($editable_column, $generator->columns['name']);
        $_SESSION['form-select-from-table-' . $editable_column]['select-from-' . $editable_column] = $generator->columns['select_from'][$index];
        $_SESSION['form-select-from-table-' . $editable_column]['table-' . $editable_column]       = $generator->columns['select_from_table'][$index];
        $_SESSION['form-select-from-table-' . $editable_column]['value-' . $editable_column]       = $generator->columns['select_from_value'][$index];
        $_SESSION['form-select-from-table-' . $editable_column]['field-1-' . $editable_column]     = $generator->columns['select_from_field_1'][$index];
        $_SESSION['form-select-from-table-' . $editable_column]['field-2-' . $editable_column]     = $generator->columns['select_from_field_2'][$index];

        $select_custom_values = $generator->columns['select_custom_values'][$index];

        if (!empty($select_custom_values)) {
            $i = 0;
            foreach ($select_custom_values as $name => $value) {
                $_SESSION['form-select-from-table-' . $editable_column]['custom_name-' . $i]  = $name;
                $_SESSION['form-select-from-table-' . $editable_column]['custom_value-' . $i] = $value;
                $i ++;
            }
        }

        $_SESSION['form-select-from-table-' . $editable_column]['select_multiple-' . $editable_column] = $generator->columns['select_multiple'][$index];

        $form_select_from_table = new Form('form-select-from-table-' . $editable_column, 'horizontal', 'novalidate', 'bs4');
        $form_select_from_table->setCols(0, 12);

        // table to choose select values from
        $form_select_from_table->addRadio('select-from-' . $editable_column, CHOOSE_VALUES_FROM_TABLE, 'from_table');
        $form_select_from_table->addRadio('select-from-' . $editable_column, CUSTOM_VALUES, 'custom_values');
        $form_select_from_table->printRadioGroup('select-from-' . $editable_column, '');

        /**** if values from table ****/

        $form_select_from_table->startDependentFields('select-from-' . $editable_column, 'from_table');

        $form_select_from_table->setCols(3, 6);

        // loop tables
        foreach ($generator->tables as $table) {
            $form_select_from_table->addOption('table-' . $editable_column, $table, $table);
        }
        $form_select_from_table->addSelect('table-' . $editable_column, TABLE);
        $form_select_from_table->addHtml('<div id="form-select-from-field-' . $editable_column . '-wrapper" class="mb-5"></div>');
        $form_select_from_table->endDependentFields();

        /**** END values from table ****/

        /**** if custom values ****/

        $form_select_from_table->startDependentFields('select-from-' . $editable_column, 'custom_values');
        $form_select_from_table->setCols(2, 3);
        $form_select_from_table->groupInputs('custom_name-0', 'custom_value-0');
        $form_select_from_table->addInput('text', 'custom_name-0', '', NAME);
        $form_select_from_table->addInput('text', 'custom_value-0', '', VALUE);

        // Dynamic fields - container + add button
        $form_select_from_table->addHtml('<div id="ajax-elements-container">');

        // current names / values from generator
        if (is_array($select_custom_values) && !empty($select_custom_values)) {
            $count = count($select_custom_values);
            if ($count > 0) {
                for ($i=1; $i < $count; $i++) {
                    $form_select_from_table->addHtml('<div class="dynamic mb-4 clearfix">');
                    $form_select_from_table->setCols(2, 3);
                    $form_select_from_table->groupInputs('custom_name-' . $i, 'custom_value-' . $i, 'remove-btn');
                    $form_select_from_table->addInput('text', 'custom_name-' . $i, '', NAME);
                    $form_select_from_table->addInput('text', 'custom_value-' . $i, '', VALUE);
                    $form_select_from_table->setCols(0, 2);
                    $form_select_from_table->addBtn('button', 'remove-btn', '', '<i class="' . ICON_DELETE . '"></i>', 'class=btn btn-danger remove-element-button, data-index=' . $i);
                    $form_select_from_table->addHtml('</div>');
                }
                $current_index = $i;
            }
        } else {
            $current_index = 1;
        }

        $form_select_from_table->addHtml('</div>');
        $form_select_from_table->addHtml('<div class="row justify-content-end text-right"><div class="col"><p>&nbsp;</p>');
        $form_select_from_table->addHtml('<button type="button" class="btn btn-primary add-element-button">' . ADD . '<i class="' . ICON_PLUS . ' position-right"></i></button>');
        $form_select_from_table->addHtml('<p>&nbsp;</p></div></div>');

        // End Dynamic fields
        $form_select_from_table->endDependentFields();

        /**** END custom values ****/

        $form_select_from_table->setCols(3, 6);

         // multiple
        $form_select_from_table->addRadio('select_multiple-' . $editable_column, NO, 0);
        $form_select_from_table->addRadio('select_multiple-' . $editable_column, YES, 1);
        $form_select_from_table->printRadioGroup('select_multiple-' . $editable_column, MULTIPLE_CONST);
        $form_select_from_table->addPlugin('select2', 'select', 'default');
        $form_select_from_table->render();
        ?>
        <script type="text/javascript">
        var generatorUrl = $('input[name="generator-url"]').val();
        $("#remodal-content .hidden-wrapper").dependentFields();
        $('#remodal-content input[type="checkbox"], #remodal-content form').niceCheck();

        // send selected table via ajax to generate field select
        $('#remodal-content select[name="table-<?php echo $editable_column; ?>"]').on('change', function() {

    $.ajax({
    url: generatorUrl + 'inc/select-values.php',
    type: 'GET',
    data: {
        column: '<?php echo $editable_column; ?>',
        table: $(this).val()
    }
    }).done(function(data) {
        $('#<?php echo 'form-select-from-field-' . $editable_column; ?>-wrapper').html(data);
        $('#remodal-content select').select2();
    }).fail(function(data, statut, error) {
    console.log(error);
    });
    });
    $('#remodal-content select[name="table-<?php echo $editable_column; ?>"]').trigger('change');

    // Dynamic fields
    // target to receive dynamic fields
    var target = $('#ajax-elements-container');

    // hidden field to store dynamic fields index
    target.closest('form').prepend('<input type="hidden" name="dynamic-fields-index" value="<?php echo $current_index; ?>">');
    var countInput = $('input[name="dynamic-fields-index"]');

    $('.add-element-button').off('click').on('click', function () {

    // ajax call
    $.ajax({
    url: generatorUrl + 'inc/select-values-dynamic-elements.php',
    data: {
        index: parseInt(countInput.val()) + 1
    }
    }).done(function (data) {

    target.append(data);

    // increment dynamic-fields-index
    countInput.val(parseInt(countInput.val()) + 1);

    // Remove action
    activateRemoveButtons();
    }).fail(function (data, statut, error) {
    console.log(error);
    });
    });

    var activateRemoveButtons = function() {
    $('.remove-element-button').removeClass('hidden').off('click').on('click', function () {
    var currentIndex = parseInt($(this).attr('data-index'));

    // Transfer upper dynamics values to each previous
    var transferUpperValues = function() {
        var dynamic = $('.dynamic')[currentIndex - 2],
            fields = $(dynamic).find('input, textarea, select, radio, checkbox');
        $(fields).each(function(index, field) {
            if ($(field).attr('data-activates') === undefined) { // specific condition for material select
                var followingField = '',
                    newValue = '';
                if ($(field).is('input[type="radio"]')) {
                    var followingFieldName = $(field).attr('name').replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                    followingField = $('input[name="' + followingFieldName + '"]:checked');
                    newValue = followingField.val();
                    if ($(field).val() == newValue) {
                        $(field).prop('checked', true);
                    } else {
                        $(field).prop('checked', false);
                    }
                } else {
                    var followingFieldId = $(field).attr('id').replace('-' + parseInt(currentIndex), '-' + parseInt(currentIndex + 1));
                    followingField = $('#' + followingFieldId);
                    if ($(field).is('select')) {
                        newValue = followingField.find('option:selected').val();
                        $(field).val(newValue);
                    } else  {
                        newValue = followingField.val();
                        $(field).val(newValue);
                    }
                }
            }
        });
    };

    // if upper dynamic sections
    if ($('.dynamic')[currentIndex - 1]) {
        while ($($('.dynamic')[currentIndex - 1]).length > 0) {
            transferUpperValues();
            currentIndex ++;
        }
    }

    // decrement dynamic-fields-index
    countInput.val(parseInt(countInput.val()) - 1);

    // remove last dynamic container
    $('.remove-element-button:last').closest('.dynamic').remove();
    });
    };

    activateRemoveButtons();
    </script>
    <?php
    } elseif (isset($_GET['table']) && preg_match('([0-9a-zA-Z_-]+)', $_GET['table'])) {
        $table = $_GET['table'];

        /* =============================================
        table sent => fields to choose select values from
        ============================================= */

        // loop fields
        $db = new Mysql();
        $fields = $db->GetColumnNames($table);
        $form_select_values = new form('form-select-from-table-' . $editable_column, 'horizontal');
        $form_select_values->setCols(3, 6);
        $form_select_values->addOption('field-2-' . $editable_column, '', NONE, $table);
        foreach ($fields as $field) {
            $form_select_values->addOption('value-' . $editable_column, $field, $field, $table);
            $form_select_values->addOption('field-1-' . $editable_column, $field, $field, $table);
            $form_select_values->addOption('field-2-' . $editable_column, $field, $field, $table);
        }
        $form_select_values->addSelect('value-' . $editable_column, VALUE);
        $form_select_values->addSelect('field-1-' . $editable_column, DISPLAY_VALUE . ' 1');
        $form_select_values->addSelect('field-2-' . $editable_column, DISPLAY_VALUE . ' 2');
        echo $form_select_values->html;
    }
}
?>
