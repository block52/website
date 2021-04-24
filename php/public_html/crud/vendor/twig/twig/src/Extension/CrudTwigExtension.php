<?php
use common\Utils;
use phpformbuilder\database\Mysql;

class CrudTwigExtension extends Twig\Extension\AbstractExtension
{

    public function initRuntime(Twig_Environment $environment) { }

    public function getGlobals() { }
    public function getFunctions()
    {
        return array(
            new Twig\TwigFunction('alert', 'alert'),
            new Twig\TwigFunction('jeditSelect', 'getJeditSelect'),
            new Twig\TwigFunction('remoteFileExists', 'ifRemoteFileExists'),
            new Twig\TwigFunction('toBoolean', 'replaceWithBooleen'),
            new Twig\TwigFunction('toCustomSelectValue', 'getCustomSelectValue'),
            new Twig\TwigFunction('toDate', 'formatDate')
        );
    }

    public function getName()
    {
        return 'crud';
    }
}

function alert($content, $class)
{
    return Utils::alert($content, $class);
}

function ifRemoteFileExists($url)
{
    $ch = curl_init(trim($url));
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $status === 200 ? true : false;
}

function replaceWithBooleen($value)
{
    return Utils::replaceWithBooleen($value);
}

function formatDate($date, $format)
{
    if (empty($date)) {
        return '';
    }
    try {
        $date = new \DateTime($date);
        $out = '';
        // format date using PHP intl extension if possible
        if (class_exists('IntlDateFormatter')) {
            $out = IntlDateFormatter::formatObject(
                $date,
                $format,
                Locale::getDefault()
            );
        } else {
            // dd MMMM yyyy H:m a => dd F yyyy H:G A
            // old version with php date formats if PHP intl extension is not installed/enabled
            // translate PHP intl date format (ICU) to PHP date format

            $find = array('eeee', 'eee', 'dd', 'd', 'MMMM', 'MMM', 'MM', 'M', 'yyyy', 'yy', 'hh', 'h', 'HH', 'H', 'm');
            $replace = array('l', 'D', 'd', 'j', 'F', 'M', 'm', 'n', 'Y', 'y', 'h', 'g', 'H', 'G', 'i');

            $format  = trim(str_replace($find, $replace, $format));
            $date = $date->format($format);

            // remove am/pm from format as it can cause unjustified warnings (http://php.net/manual/en/function.date-parse-from-format.php)
            $safe_format = trim(str_replace(array('A', 'a'), '', $format));
            $safe_date   = trim(str_replace(array('AM', 'am', 'PM', 'pm'), '', $date));
            $parsed = date_parse_from_format($safe_format, $safe_date);
            if ($parsed['warning_count'] < 1 && $parsed['error_count'] < 1) {
                $out = $date;
            } else {
                $out = $date . ' <span class="badge badge-warning p-1">WRONG_DATE_FORMAT: ' . $format . '</span>';
            }
        }
    } catch (\Exception $e) {
        // echo  $e->getMessage();
        $out = 'WRONG_DATE_FORMAT';
    }

    return $out;
}

/*
$array_values = array(
    from
    from_table
    from_value
    from_field_1
    from_field_2
    custom_values => array(
        name => value,
        ...
    )
)
 */
function getJeditSelect($table, $select_data)
{
    if (!empty($select_data)) {
        // exit(var_dump($select_data));
        $js_code = "\n";
        foreach ($select_data as $field => $array_values) {
            $values = array();
            if ($array_values->from == 'from_table' && !empty($array_values->from_value)) {
                $from_value   = $array_values->from_value;
                $from_field_1 = $array_values->from_field_1;
                $from_field_2 = $array_values->from_field_2;
                $from_table   = $array_values->from_table;

                $fields_query = $from_value;
                if ($from_field_1 != $from_value) {
                    $fields_query .= ', ' . $from_field_1;
                }
                if (!empty($from_field_2)) {
                    $fields_query .= ', ' . $from_field_2;
                }
                $qry = 'SELECT DISTINCT ' . $fields_query . ' FROM ' . $from_table;
                $db = new Mysql();
                $db->query($qry);
                $db_count = $db->rowCount();
                if (!empty($db_count)) {
                    while (! $db->endOfSeek()) {
                        $row = $db->row();
                        $value = $row->$from_value;
                        if ($from_field_1 != $from_value) {
                            $display_value = $row->$from_field_1;
                        } else {
                            $display_value = $row->$from_value;
                        }
                        if (!empty($from_field_2)) {
                            $display_value .= ' ' . $row->$from_field_2;
                        }
                        $values[$value] = $display_value;
                    }
                }
            } elseif ($array_values->from == 'custom_values' && !empty($array_values->custom_values)) {
                foreach ($array_values->custom_values as $value => $name) {
                    $values[$name] = $value;
                }
            }
            if (!empty($values)) {
                $js_code .= '    $(\'.jedit-select[data-field="' . $field . '"]\').editable(\'' . ADMIN_URL . 'inc/jedit.php\', {' . "\n";
                $js_code .= '        cssclass      : \'form-inline\',' . "\n";
                $js_code .= '        type          : \'select\',' . "\n";
                $js_code .= '        data          : \'' . json_encode($values, JSON_HEX_APOS)  . '\',' . "\n";
                $js_code .= '        indicator     : \'<img src="' . ADMIN_URL . 'assets/images/ajax-loader.gif" alt="' . RECORDING . '">\',' . "\n";
                $js_code .= '        cancel        : \'' . CANCEL . '\',' . "\n";
                $js_code .= '        submit        : \'' . OK . '\',' . "\n";
                $js_code .= '        onsubmit: function() {' . "\n";
                $js_code .= '            $(this).closest(\'[class^="jedit-"]\').removeClass(\'active\');' . "\n";
                $js_code .= '        },' . "\n";
                $js_code .= '        onreset: function() {' . "\n";
                $js_code .= '            $(this).closest(\'[class^="jedit-"]\').removeClass(\'active\');' . "\n";
                $js_code .= '        },' . "\n";
                $js_code .= '        callback      : function (value, settings) {' . "\n";
                $js_code .= '            $(this).html(value);' . "\n";
                $js_code .= '        }' . "\n";
                $js_code .= '    });' . " \n\n";
            }
        }

        return $js_code;
    }
}

/**
 * get display value from real registered value
 * @param  string $table
 * @param  string $fieldname
 * @param  string $value     registered value
 * @return string            display value
 */
function getCustomSelectValue($table, $fieldname, $value)
{
    $json = file_get_contents(ADMIN_DIR . 'crud-data/' . $table . '-select-data.json');
    $select_data = json_decode($json, true);
    $values = $select_data[$fieldname]['custom_values'];
    $test_if_json = json_decode($value);
    // if $value is a string in JSON format we decode to get the array value
    if (json_last_error() == JSON_ERROR_NONE) {
        $value = json_decode($value);
    }
    if (is_array($value)) {
        $return_values = array();
        foreach ($values as $display_value => $custom_value) {
            if (in_array($custom_value, $value)) {
                $return_values[] = $display_value;
            }
        }
        return implode(', ', $return_values);
    }
    foreach ($values as $display_value => $custom_value) {
        if ($custom_value == $value) {
            return $display_value;
        }
    }

    return false;
}

/*
$('.jedit-select').editable('inc/jedit.php', {
    cssclass: 'form-inline',
    type      : 'select',
    <?php
    /*$array['value 1'] =  'option 1';
    $array['value 2'] =  'option 2';
    $array['value 3'] =  'option 3';
    $array['selected'] =  'value 2';
    ?>
    data       : <?php // echo json_encode($array); ?>,
    indicator     : '<img src="images/ajax-loader.gif" alt="enregistrement ...">',
    tooltip       : 'Cliquer pour modifier ...',
    cancel        : 'ANNULER',
    submit        : 'OK',
    onblur: 'ignore',
    callback     : function (value, settings) {
        $(this).html(settings.data[value]);
    }
});*/
