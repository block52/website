<?php
namespace generator;

class TemplatesUtilities
{

    /**
     * get special display for boolean, images and dates
     * @param  obj      $generator
     * @param  int      $i current index
     * @return string   twig template value
     */
    public static function getDisplayValue($generator, $field_name, $i)
    {
        /* values types : array|boolean|color|date|datetime|time|image|number|password|set|text|url */

        $value_type = $generator->columns['value_type'][$i];
        if ($value_type == 'boolean') {
            // convert boolean to icon html
            $display_value = '{{ toBoolean(object.' . $field_name . '[ loop.index0 ])|raw }}';
        } elseif ($value_type == 'color') {
            // add color span preview
            $display_value = '<span class="color-preview prepend" style="background-color:{{ object.' . $field_name . '[ loop.index0 ] }}"></span>{{ object.' . $field_name . '[ loop.index0 ] }}';
        } elseif ($value_type == 'date') {
            // set date display format
            $php_date = self::pickerdateToPhpdate($generator->columns['special'][$i]);
            $display_value = '{{ toDate(object.' . $field_name . '[ loop.index0 ], \'' . $php_date . '\')|raw }}';
        } elseif ($value_type == 'datetime') {
            // set datetime display format
            $php_datetime = self::pickerdateToPhpdate($generator->columns['special'][$i] . ' ' . $generator->columns['special2'][$i]);
            $display_value = '{{ toDate(object.' . $field_name . '[ loop.index0 ], \'' . $php_datetime . '\')|raw }}';
        } elseif ($value_type == 'time') {
            // set time display format
            $php_time = self::pickerdateToPhpdate($generator->columns['special'][$i]);
            $display_value = '{{ toDate(object.' . $field_name . '[ loop.index0 ], \'' . $php_time . '\')|raw }}';
        } elseif ($value_type == 'file') {
            $file_url = '{{ constant(\'BASE_URL\') }}' . rtrim($generator->columns['special2'][$i], '') . '{{ object.' . $field_name . '[ loop.index0 ] }}';
            $display_value = '{% if object.' . $field_name . '[ loop.index0 ]|length %}
                        {% set remote_file = constant(\'BASE_URL\') ~ \'' . $generator->columns['special2'][$i] . '\' ~ object.' . $field_name . '[ loop.index0 ] %}
                            {% if remoteFileExists(remote_file) %}
                            <a href="' . $file_url . '" title="' . $file_url . '" class="badge badge-success text-nowrap" target="_blank">{{ object.' . $field_name . '[ loop.index0 ] }}</a>
                            {% else %}
                                <a href="' . $file_url . '" title="' . $file_url . '" class="badge badge-danger text-nowrap" target="_blank">{{ constant(\'FILE_NOT_FOUND\') }}</a>
                            {% endif %}
                        {% else %}
                        -
                        {% endif %}';
        } elseif ($value_type == 'image') {
            $thumb_folder = '';
            if ($generator->columns['special3'][$i] > 0) {
                // if thumbs enabled
                $thumb_folder = 'thumbs/sm/';
            }

            $img_url = '{{ constant(\'BASE_URL\') }}' . rtrim($generator->columns['special2'][$i], '') . $thumb_folder . '{{ object.' . $field_name . '[ loop.index0 ] }}';

            $display_value = '{% if object.' . $field_name . '[ loop.index0 ]|length %}
                        {% set remote_file = constant(\'BASE_URL\') ~ \'' . rtrim($generator->columns['special2'][$i], '') . $thumb_folder . '\' ~ object.' . $field_name . '[ loop.index0 ] %}
                            {% if remoteFileExists(remote_file) %}
                            <img src="' . $img_url . '" alt="{{ object.' . $field_name . '[ loop.index0 ] }}" title="{{ object.' . $field_name . '[ loop.index0 ] }}" height="50">
                            {% else %}
                                <a href="' . $img_url . '" title="' . $img_url . '" class="badge badge-danger text-nowrap" target="_blank">{{ constant(\'FILE_NOT_FOUND\') }}</a>
                            {% endif %}
                        {% else %}
                        -
                        {% endif %}';
        } elseif ($value_type == 'url') {
            // add url link
            $display_value = '<a href="{{ object.' . $field_name . '[ loop.index0 ] }}" target=_blank">{{ object.' . $field_name . '[ loop.index0 ] }}</a>';
        } else {
            // if select custom values
            if ($value_type == 'array' && ($generator->columns['select_from'][$i] == 'custom_values' && $generator->columns['column_type'][$i] != 'enum' && $generator->columns['column_type'][$i] != 'set')) {
                $display_value = '{{ toCustomSelectValue(\'' . $generator->item . '\', \'' . $field_name . '\', object.' . $field_name . '[ loop.index0 ]) }}';
            } else {
                $display_value = '{{ object.' . $field_name . '[ loop.index0 ] }}';
            }
        }

        return $display_value;
    }

    /**
     * get td template for jedit
     * @param  obj      $generator
     * @param  int      $i current index
     * @return string   twig template td
     */
    public static function getJeditCell($generator, $field_name, $display_value, $i)
    {
        $value_type = $generator->columns['value_type'][$i];
        $out = '                            <td>
                            {% if object.pk[loop.index0] in object.authorized_update_pk %}' . "\n";

        if ($value_type == 'date' || $value_type == 'datetime' || $value_type == 'time') {
            $out .= '                            <span class="jedit-' . $generator->columns['jedit'][$i] . ' tip" data-field="' . $field_name . '" data-delay="500" data-value="{{ toDate(object.' . $field_name . '[ loop.index0 ], \'Y-m-d\')|raw }}" title="{{ constant(\'CLICK_TO_EDIT\') }}" id="' . $generator->table . '-' . $field_name . '-' . $generator->primary_key . '-{{ object.pk[ loop.index0 ] }}">' . $display_value . '</span>' . "\n";
        } else {
            $out .= '                            <span class="jedit-' . $generator->columns['jedit'][$i] . ' tip" data-field="' . $field_name . '" data-delay="500" title="{{ constant(\'CLICK_TO_EDIT\') }}" id="' . $generator->table . '-' . $field_name . '-' . $generator->primary_key . '-{{ object.pk[ loop.index0 ] }}">' . $display_value . '</span>' . "\n";
        }

        $out .= '                            {% else %}
                            ' . $display_value . '
                            {% endif %}
                            </td>' . "\n";

        return $out;
    }

    /**
     * convert a javascript datepicker format to ICU date format
     * http://www.icu-project.org/apiref/icu4c/classSimpleDateFormat.html#details
     *
     * used by vendor/twig/twig/lib/Twig/Extension/CrudTwigExtension.php :: formatDate($date, $format)
     * to format international dates with PHP IntlDateFormatter
     * http://php.net/manual/fr/intldateformatter.formatobject.php
     *
     * @param  string   pickadate format
     * @return string   ICU date format
     */
    public static function pickerdateToPhpdate($pickerdate)
    {
        // ICU values
        $find    = array('dddd', 'ddd', 'mmmm', 'mmm', 'mm', 'm', 'i', 'A');
        $replace = array('eeee', 'eee', 'MMMM', 'MMM', 'MM', 'M', 'm', 'a');

        return str_replace($find, $replace, $pickerdate);
    }
}
