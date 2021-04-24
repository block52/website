<?php
namespace crud;

class ElementsUtilities extends Elements
{
    public static function getTableName($item, $db_data)
    {
        // get real table name
        foreach ($db_data as $db_table => $values) {
            if ($values['item'] === $item) {
                return $db_table;
            }
        }

        return false;
    }

    /**
     * convert variable to be usable as an object attribute if it contains hyphens.
     * @param  String $var
     * @param  String $context  php_class|twig_template
     * @return String       if $var contains '-':
     *                          if $context == 'php_class':
                                    returns {'var-with-hyphen'} to be usable as $obj->{'var-with-hyphen'}
                                if $context == 'twig_template':
                                    returns for example attribute(object.fields, 'address-1')
     *                      else
     *                          if $context == 'php_class':
                                    returns $var
                                if $context == 'twig_template':
                                    returns the normal twig value, for example object.fields.city
     */
    /*public static function getHyphenVar($var, $context = 'php_class', $twig_object = '')
    {

        if ($context == 'php_class') {
            if (strpos($var, '-') === false) {
                return $var;
            }

            return '{\'' . $var . '\'}';
        } elseif ($context == 'twig_template') {
            if (strpos($var, '-') === false) {
                return $twig_object . '.' . $var;
            }

            return 'attribute(' . $twig_object . ', \'' . $var . '\')';
        }
    }*/

    public static function sanitizeFieldName($field_name)
    {
        $old_name = trim($field_name);
        $charset = 'utf-8';
        $new_name = htmlentities($old_name, ENT_NOQUOTES, $charset);
        $new_name = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $new_name);
        $new_name = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $new_name);    // pour les ligatures e.g. '&oelig;'
        $new_name = preg_replace('#\&[^;]+\;#', '', $new_name);    // supprime les autres caractères
        $new_name = preg_replace('`[ &~"#{( \'\[|\\^@)\]=}$¤*µ%,;:!?/§.-]+`', '_', $new_name);
        while (preg_match('`__`', $new_name)) {
            $new_name = preg_replace('`__`', '_', $new_name);
        }
        $new_name = trim($new_name, '_');

        return $new_name;
    }

    public static function upperCamelCase($str, array $noStrip = array())
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);

        return $str;
    }

    public static function addNameSpace($class_name, $namespace)
    {
        return '\\' . $namespace . '\\' . $class_name;
    }


    /**
     * getFieldNames
     *
     * @param  string $table
     *
     * @return array
     */
    public static function getFieldNames($table)
    {
        $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
        $db_data = json_decode($json, true);
        if (isset($db_data[$table])) {
            return $db_data[$table]['fields'];
        }

        return false;
    }

    /**
     * create export buttons for admin, store export queries.
     * @param  string $sql     sql query
     * @param  string $formats list of export formats separated with commas.
     *                         accepted formats : excel, csv, tsv
     * @return string html buttons code
     */
    public static function exportDataButtons($table, $sql, $formats)
    {
        $_SESSION['export'] = array();
        $html = '<div class="btn-group heading-btn">' . "\n";
        $html .= '    <button type="button" class="btn ' . DEFAULT_BUTTONS_BACKGROUND . ' btn-sm btn-icon dropdown-toggle legitRipple" data-toggle="dropdown"><i class="' . ICON_UPLOAD . '"></i></button>' . "\n";
        $html .= '    <ul class="dropdown-menu dropdown-menu-right">' . "\n";
        $formats = explode(',', $formats);
        $_SESSION['export'][$table]['sql'] = $sql;
        if (!isset($_SESSION['npp'])) {
            $_SESSION['npp'] = 20;
        }
        foreach ($formats as $format) {
            $format = trim($format);
            switch ($format) {
                case 'excel':
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=excel&amp;npp=' . $_SESSION['npp'] . '">' . EXPORT_TO_EXCEL . ' (' . CURRENT_VIEW . ')</a></li>' . "\n";
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=excel&amp;npp=-1">' . EXPORT_TO_EXCEL . ' (' . ALL_RECORDS . ')</a></li>' . "\n";
                    break;
                case 'csv':
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=csv&amp;npp=' . $_SESSION['npp'] . '">' . EXPORT_TO_CSV . ' (' . CURRENT_VIEW . ')</a></li>' . "\n";
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=csv&amp;npp=-1">' . EXPORT_TO_CSV . ' (' . ALL_RECORDS . ')</a></li>' . "\n";
                    break;
                case 'tsv':
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=tsv&amp;npp=' . $_SESSION['npp'] . '">' . EXPORT_TO_TSV . ' (' . CURRENT_VIEW . ')</a></li>' . "\n";
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=tsv&amp;npp=-1">' . EXPORT_TO_TSV . ' (' . ALL_RECORDS . ')</a></li>' . "\n";
                    break;
                case 'browser':
                    $p = @$_GET['p'];
                    if (!$p) {
                        $p = 1;
                    }
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=browser&amp;npp=' . $_SESSION['npp'] . '&p=' . $p . '" target="_blank">' . PRINTABLE_VIEW . ' (' . CURRENT_VIEW . ')</a></li>' . "\n";
                    $html .= '<li><a class="dropdown-item" href="' . ADMIN_URL . 'inc/export-data.php?table=' . $table . '&amp;format=browser&amp;npp=-1&p=' . $p . '" target="_blank">' . PRINTABLE_VIEW . ' (' . ALL_RECORDS . ')</a></li>' . "\n";
                    break;
                default:
                    break;
            }
        }
        $html .= '    </ul>' . "\n";
        $html .= '</div>' . "\n";

        return $html;
    }

    public static function getSorting($table, $sorting_field, $default_direction = 'ASC')
    {
        if (!isset($_SESSION['sorting_' . $table])) {
            $_SESSION['sorting_' . $table] = $table . '.' . $sorting_field;
        }
        if (!isset($_SESSION['direction_' . $table])) {
            $_SESSION['direction_' . $table] = $default_direction;
        }

        return ' ' . $_SESSION['sorting_' . $table] . ' ' . $_SESSION['direction_' . $table];
    }

    public static function selectNumberPerPage($numbersArray, $selectedNumber, $url)
    {
        $html = '<form id="npp-form" action="' . $url . '" method="post" value="1" class="form-inline">' . "\n";
        $html .= '    <div class="form-group">' . "\n";
        $html .= '        <label class="control-label pr-2" for="npp-select">' . RESULTS_PER_PAGE . '</label>' . "\n";
        $html .= '        <select name="npp" id="npp" class="form-control form-control-sm pr-4" data-minimum-results-for-search="-1">' . "\n";
        foreach ($numbersArray as $number) {
            $selected = '';
            if ($number == $_SESSION['npp']) {
                $selected = ' selected';
            }
            if ($number == 10000) {
                $html .= '            <option value="' . $number . '"' . $selected . '>' . ALL . '</option>' . "\n";
            } else {
                $html .= '            <option value="' . $number . '"' . $selected . '>' . $number . '</option>' . "\n";
            }
        }
        $html .= '        </select>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '</form>' . "\n";

        return $html;
    }
}
