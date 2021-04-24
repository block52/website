<?php
use generator\TemplatesUtilities;

include_once GENERATOR_DIR . 'class/generator/TemplatesUtilities.php';

$generator = $_SESSION['generator'];
?>
    <div class="card {{ constant('DEFAULT_CARD_CLASS') }} mb-5">
        <div class="card-header {{ constant('DEFAULT_CARD_HEADING_CLASS') }}">
<?php
// when building users & profiles templates, $_POST['export_btn'] is not set
if (!isset($_POST['rs_export_btn']) || ($_POST['rs_export_btn'] == true)) {
?>
{{ object.export_data_button|raw }}
<?php } // END if ?>
            <div class="btn-group heading-btn ml-2">
<?php
if (isset($_POST['rs_open_url_btn']) && ($_POST['rs_open_url_btn'] == true)) { ?>
                    <a href="{{ constant('BASE_URL') }}" class="btn bg-gray-200 btn-sm btn-icon legitRipple" data-delay="500" data-tooltip="{{ constant('OPEN_URL') }}" target="_blank"><span class="{{ constant('ICON_NEW_TAB') }} text-center"></span></a>
<?php
} // END if ?>
                {% if object.pk[0] in object.authorized_update_pk %}
                    <a href="{{ constant('ADMIN_URL') }}{{ object.item }}/edit/{{ object.pk[0] }}" class="btn btn-sm btn-warning legitRipple" title="{{ constant('EDIT') }}" data-popup="tooltip" data-delay="500"><span class="{{ constant('ICON_EDIT') }} icon-md"></span></a>
                {% endif %}
            </div>
        </div>

{% if object.records_count > 0 %}
    {% for i in range(0, object.records_count - 1) %}
        <div class="table-responsive">
            <table id="{{ object.item }}-list" class="table table-striped table-condensed table-data">
                <tbody>
<?php
for ($i=0; $i < $generator->columns_count; $i++) {
    if ($generator->columns['skip'][$i] == false) {
        $field_name = $generator->columns['name'][$i];
        // get display value
        $display_value = TemplatesUtilities::getDisplayValue($generator, $field_name, $i);
?>
                    <tr>
                        <th>{{ object.fields.<?php echo $field_name; ?> }}</th>
<?php
if (!empty($generator->columns['jedit'][$i])) { // with jedit
    echo TemplatesUtilities::getJeditCell($generator, $field_name, $display_value, $i);
} else { // without jedit ?>
                        <td><?php echo $display_value; ?></td>
<?php
} // END without jedit
?>
                    </tr>
<?php
    } // END if !skip
} // END for

// External relations
if (count($generator->external_columns) > 0) {
    foreach ($generator->external_columns as $key => $ext_col) {
        if ($ext_col['active'] === true) { ?>
                    <tr>
                        <th><?php echo $ext_col['table_label']; ?></th>
                        {% if object.external_tables_count > 0 %}
                        {% for j in range(0, object.external_tables_count - 1) %}
                        <td class="no-ellipsis">
                            {% if object.external_rows_count[i][j] > 0 %}
                            <h6 class="card-title nowrap mb-0"><span class="badge bg-gray-300 position-left">{{ object.external_rows_count[i][j] }}</span><a class="dropdown-toggle" data-toggle="collapse" href="#{{ object.external_fields[i][j]['uniqid'] }}" role="button" aria-expanded="false" aria-controls="{{ object.external_fields[i][j]['uniqid'] }}"><small class="text-muted">{{ constant('SHOW') }} / {{ constant('HIDE') }}</small></a></h6>
                            <div class="collapse" id="{{ object.external_fields[i][j]['uniqid'] }}">
                                <table class="table table-striped table-condensed">
                                    <thead class=" {{ constant('DEFAULT_CARD_HEADING_CLASS') }}">
                                        <tr>
                                            {% for field, value in object.external_fields[i][j].fields %}
                                            <th>{{ field }}</th>
                                            {% endfor %}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {# Loop records #}

                                        {% for k in range(0, object.external_rows_count[i][j] - 1) %}
                                        <tr>

                                        {# Loop fields #}

                                        {% for field, value in object.external_fields[i][j].fields %}
                                            <td>{{ object.external_fields[i][j].fields[field][k] }}</td>
                                        {% endfor %}
                                        </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                            {% endif %}
                        </td>
                        {% endfor %}
                        {% endif %}
<?php
        } // end if
    } // END foreach
} // END if
?>
                    </tr>
                </tbody>
            </table>
        </div> <!-- END table-responsive -->
    {% endfor %}
{% else %}
        <div class="card-body">
            <p class="text-semibold">
                {{ alert(constant('NO_RECORD_FOUND'), 'alert-info has-icon')|raw }}
            </p>
        </div>
{% endif %}
    </div> <!-- END card -->
