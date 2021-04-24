<?php
namespace dragNDropFormGenerator;

use phpformbuilder\Form;

/**
 * Class FormGenerator
 *
 * @version 0.1
 * @author Gilles Migliori - gilles.migliori@gmail.com
 *
 */

class FormGenerator
{

    public $json_form;
    private $json_form_sections;
    private $autoloaded_plugins = array('bootstrap-select', 'intl-tel-input', 'select2');

    private $current_dir;

    /*
    array
    0 =>
        'id' => string
        'componentType' => string 'input'
        'component' =>
            object(stdClass)
            'componentType' => string 'input'
            'helper'        => string
            'plugins'       =>
                array
                0 =>
                    object(stdClass)
                    'objectName'   => string 'Autocomplete'
                    'pluginName'   => string 'autocomplete'
                    'selector'     => string
                    'jsConfig'     => string 'default'
                    'replacements' =>
                        array
                        0 =>
                            object(stdClass)
                            'availableTags' => string '"value 1", "value 2", "add other values ..."'
                    'dataAttributes' => string
            'attr'        => array
            'clazz'       => string
            'index'       => int
            'label'       => string
            'name'        => string
            'placeholder' => string
            'type'        => string
            'value'       => string
            'width'       => string
    */

    // special data
    private $db_fields = array();
    private $hasCaptcha = false;
    private $captchaFieldname = '';
    private $has_recaptcha = false;
    private $recaptcha_private_key = '';

    private $current_cols = '4-8';

    private $has_email_fields = false;
    private $email_field_names = array();

    private $output_preview;
    private $php_form;
    private $php_form_code = array(
        'components'     => array(),
        'global_plugins' => '',
        'head'           => '',
        'if_posted'      => '',
        'main'           => '',
        'message'        => '',
        'scripts'        => '',
        'start_form'     => '',
        'start'          => ''
    );

    private $error_msg = '';

    public function __construct($json_string, $output_preview = true)
    {
        $this->current_dir = $this->getCurrentDir();
        $this->output_preview = $output_preview;

        $json = json_decode($json_string);
        $json_error = $this->getLastJsonError();
        if (!empty($json_error)) {
            $this->error_msg = $json_error;
            $this->buildErrorMsg($this->error_msg);
        } else {
            $this->json_form = $json->userForm;
            $this->json_form_sections = $json->formSections;

            $this->getSpecialData();

            $this->createForm($this->json_form);
            foreach ($this->json_form->plugins as $plugin) {
                $this->addPlugin($plugin, true);
            }

            // Group components depending on their width
            // and the width of the following component
            $this->getSectionGroups();

            foreach ($this->json_form_sections as $key => $section) {
                $this->buildSection($section);
            }

            $this->buildCodeParts();
        }
    }

    public function outputCode()
    {
        $output = '';
        $code_part_index = 1;
        $numbered_class = 'd-inline-block px-3 py-1 rounded-circle bg-info text-info-100 mr-3';
        if ($this->json_form->ajax !== 'true') {
            $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Add the following code at the very beginning of your file</h5>';
        } else {
            $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Create a <span class="badge badge-warning font-weight-normal px-2 py-1">/ajax-forms</span> directory and place a file named <span class="badge badge-warning font-weight-normal px-2 py-1">' . $this->json_form->id . '.php</span> in it.<br>Then save the code of the form below in this file</h5>';
        }

        $output .= '<pre><code class="language-php">';
        $output .= $this->php_form_code['main'];
        $output .= '?&gt;</code></pre>';

        $code_part_index ++;

        $output .= '<hr class="mt-4">';
        if ($this->json_form->ajax === 'true') {
            $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Add the following code in your page to display the form</h5>';
            $output .= '<pre><code class="language-php">';
            $output .= '&lt;div id="ajax-' . $this->json_form->id . '-loader"&gt;&lt;/div&gt;';
            $output .= '</code></pre>';
        } else {
            $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Add the following code between &lt;head&gt;&lt;/head&gt;</h5>';
            $output .= '<pre><code class="language-php">';
            $output .= $this->php_form_code['head'];
            $output .= '</code></pre>';

            $code_part_index ++;

            $output .= '<hr class="mt-4">';
            $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Add the following code in your page to display the form</h5>';
            $output .= '<pre><code class="language-php">';
            $output .= $this->php_form_code['render'];
            $output .= '</code></pre>';
        }

        $code_part_index ++;

        $output .= '<hr class="mt-4">';
        $output .= '<h5 class="font-weight-light"><span class="' . $numbered_class . '">' . $code_part_index . '</span>Add the following code just before &lt;/body&gt;<sup class="text-danger ml-2">*</sup></h5>';
        $output .= '<pre><code class="language-php">';
        $output .= $this->php_form_code['scripts'];
        $output .= '</code></pre>';
        $output .= '<p><sup class="text-danger mr-2">*</sup><span class="text-secondary">jQuery script must have already been added before.</span></p>';

        echo $output;
    }

    public function outputPageCode()
    {
        $output = '';
        if ($this->json_form->ajax === 'true') {
            $output .= '<div class="alert alert-info"><p>Forms loaded with Ajax use 2 files - refer to the <em>Form code</em> tab</p><p class="mb-0">It is therefore not possible to display a complete one-page code here</p></div>';

        } else {
            $page_code = htmlspecialchars(file_get_contents('sample-pages/' . $this->json_form->framework . '.html'));

            $find = array("`\{form-php\}[\r\n]+`", "`\{form-head\}[\r\n]+`", "`\{form\}`", "`\{form-js\}`");

            $head_code = $this->reindentCode($this->php_form_code['head'], 4);
            $render_code = $this->reindentCode($this->php_form_code['render'], 16);
            $scripts_code = $this->reindentCode($this->php_form_code['scripts'], 4);

            $replace = array($this->php_form_code['main'] . "?&gt;\n", $head_code, $render_code, $scripts_code);
            $page_code = preg_replace($find, $replace, $page_code);
            $output .= '<pre><code class="language-php">' . $page_code . '</code></pre>';
        }

        echo $output;
    }

    public function outputPreview()
    {
        $this->php_form->render();
    }

    public function printJsCode()
    {
        $js_code = $this->php_form->printJsCode(false, false);
        // base_url for tinymce in preview
        echo str_replace(array('location.protocol', 'location.host'), array('window.parent.location.protocol', 'window.parent.location.host'), $js_code);
    }

    private function addAttribute($new_attr_name, $new_attr_value, $comp_attr)
    {
        // create new attr object then push it to the component attributes
        $new_attr = new \stdClass();
        $new_attr->name = $new_attr_name;
        $new_attr->value = $new_attr_value;
        $comp_attr[] = $new_attr;

        return $comp_attr;
    }

    private function addBtn($comp)
    {
        foreach ($comp->plugins as $key => $plugin) {
            if ($plugin->pluginName == 'ladda') {
                $comp->attr = $this->addAttribute('class', 'ladda-button', $comp->attr);
            }
        }
        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);
        $label = $this->addBtnIcon($comp->icon, $comp->iconPosition, $comp->label);
        if ($this->output_preview === true) {
            $this->php_form->addBtn($comp->type, $comp->name, $comp->value, $label, $attr);
        }
        $this->php_form_code['components'][] = "\$form->addBtn('$comp->type', '$comp->name', '$comp->value', '" . $this->sanitize($label) . "', '" . $this->sanitize($attr) . "');\n";
    }

    private function addBtngroup($comp)
    {
        foreach ($comp->plugins as $key => $plugin) {
            if ($plugin->pluginName == 'ladda') {
                foreach ($comp->buttons as $btn) {
                    $btn->attr = $this->addAttribute('class', 'ladda-button', $btn->attr);
                    foreach ($plugin->dataAttributes as $attr) {
                       $btn->attr = $this->addAttribute('data-' . $attr->name, $attr->value, $btn->attr);
                    }
                }
            }
        }
        foreach ($comp->buttons as $btn) {
            $attrArray = $this->mergeAttributes($btn);
            $attr = $this->getAttributes($attrArray);
            $label = $this->addBtnIcon($btn->icon, $btn->iconPosition, $btn->label);
            if ($this->output_preview === true) {
                $this->php_form->addBtn($btn->type, $btn->name, $btn->value, $label, $attr, $comp->name);
            }
            $this->php_form_code['components'][] = "\$form->addBtn('$btn->type', '$btn->name', '$btn->value', '" . $this->sanitize($label) . "', '" . $this->sanitize($attr) . "', '$comp->name');\n";
        }
        if ($this->output_preview === true) {
            $this->php_form->printBtnGroup($comp->name);
        }
        $this->php_form_code['components'][] = "\$form->printBtnGroup('$comp->name');\n";
    }

    private function addBtnIcon($icon, $iconPosition, $label)
    {
        if (!empty($icon)) {
            $icon_html = '<i class="' . $icon . '" aria-hidden="true"></i>';
            if ($iconPosition === 'before') {
                $label = $icon_html . ' ' . $label;
            } else {
                $label .= ' ' . $icon_html;
            }
        }

        return $label;
    }

    private function addCheckboxGroup($comp)
    {
        $php_code = '';

        $inline = false;
        if (filter_var($comp->inline, FILTER_VALIDATE_BOOLEAN)) {
            $inline = true;
        }

        // helper
        $this->addHelper($comp->helper, $comp->name);

        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);

        foreach ($comp->checkboxes as $chk) {
            $chk_attr = '';

            if ($comp->value === $chk->value) {
                $chk_attr = 'checked';
            }
            if ($this->output_preview === true) {
                $this->php_form->addCheckbox($comp->name, $chk->text, $chk->value, $chk_attr);
            }
            $php_code .= "\$form->addCheckbox('$comp->name', '$chk->text', '$chk->value', '$chk_attr');\n";
        }
        if ($this->output_preview === true) {
            $this->php_form->printCheckboxGroup($comp->name, $comp->label, $inline, $attr);
        }
        $php_code .= "\$form->printCheckboxGroup('$comp->name', '$comp->label', $comp->inline, '$attr');\n";
        $this->php_form_code['components'][] = $php_code;
        foreach ($comp->plugins as $key => $plugin) {
            if (!in_array($plugin->pluginName, $this->autoloaded_plugins)) {
                $this->addPlugin($plugin);
            }
        }
    }

    /**
     * addGroupInputs
     *
     * @param  array $group = ['fieldname-1', 'firldname-2']
     * @return void
     */
    private function addGroupInputs($group)
    {
        if ($this->output_preview === true) {
            $this->php_form->groupInputs($group[0], $group[1]);
        }
        $this->php_form_code['components'][] = "\$form->groupInputs('$group[0]', '$group[1]');\n";
    }

    private function addHelper($helper, $name)
    {
        if (!empty($helper)) {
            if ($this->output_preview === true) {
                $this->php_form->addHelper($helper, $name);
            }
            $this->php_form_code['components'][] = "\$form->addHelper('" . $this->sanitize($helper) . "', '$name');\n";
        }
    }

    private function addIcon($icon, $iconPosition, $name)
    {
        if (!empty($icon)) {
            $icon_html = '<i class="' . $icon . '" aria-hidden="true"></i>';
            if ($this->output_preview === true) {
                $this->php_form->addIcon($name, $icon_html, $iconPosition);
            }
            $this->php_form_code['components'][] = "\$form->addIcon( '$name', '" . $this->sanitize($icon_html) . "', '$iconPosition');\n";
        }
    }

    private function addHtml($comp)
    {
        if ($this->output_preview === true) {
            $this->php_form->addHtml($comp->value);
        }
        $this->php_form_code['components'][] = "\$form->addHtml('" . $this->sanitize($comp->value) . "');\n";
    }

    private function addInput($comp)
    {
        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);
        $this->addIcon($comp->icon, $comp->iconPosition, $comp->name);
        $this->addHelper($comp->helper, $comp->name);
        if ($this->output_preview === true) {
            $this->php_form->addInput($comp->type, $comp->name, $comp->value, $comp->label, $attr);
        }
        $this->php_form_code['components'][] = "\$form->addInput('$comp->type', '$comp->name', '$comp->value', '" . $this->sanitize($comp->label) . "', '" . $this->sanitize($attr) . "');\n";
        foreach ($comp->plugins as $key => $plugin) {
            if (!in_array($plugin, $this->autoloaded_plugins)) {
                $this->addPlugin($plugin);
            }
        }
    }

    private function addParagraph($comp)
    {
        $class = '';
        if (!empty($comp->clazz)) {
            $class = ' class="' . $comp->clazz . '"';
        }
        if ($this->output_preview === true) {
            $this->php_form->addHtml('<p' . $class . '>' . $comp->value . '</p>');
        }
        $this->php_form_code['components'][] = "\$form->addHtml('" . $this->sanitize('<p' . $class . '>' . $comp->value . '</p>') . "');\n";
    }

    private function addPlugin($plugin, $global = false)
    {
        $replacements = array();
        $replacements_code_array = array();
        foreach ($plugin->replacements as $key => $repl) {
            $replacements["%$key%"] = $repl;
            $replacements_code_array[] = "'%$key%' => '$repl'";
        }
        // array('%availableTags%' => '"value 1","value 2","add other values ..."')

        if (count($replacements) < 1) {
            if ($this->output_preview === true) {
                $this->php_form->addPlugin($plugin->pluginName, $plugin->selector, $plugin->jsConfig);
            }

            $replacements_code = implode(', ', $replacements_code_array);
            if ($plugin->pluginName === 'formvalidation') {
                $php_form_code = "\$form->addPlugin('$plugin->pluginName', '$plugin->selector');\n";
            } else {
                $php_form_code = "\$form->addPlugin('$plugin->pluginName', '$plugin->selector', '$plugin->jsConfig');\n";
            }
        } else {
            if ($this->output_preview === true) {
                $this->php_form->addPlugin($plugin->pluginName, $plugin->selector, $plugin->jsConfig, $replacements);
            }

            $replacements_code = implode(', ', $replacements_code_array);
            $php_form_code = "\$form->addPlugin('$plugin->pluginName', '$plugin->selector', '$plugin->jsConfig', array($replacements_code));\n";
        }

        if ($global === true) {
            $this->php_form_code['global_plugins'] .= $php_form_code;
        } else {
            $this->php_form_code['components'][] = $php_form_code;
        }
    }

    private function addRadioGroup($comp)
    {
        $php_code = '';

        $inline = false;
        if (filter_var($comp->inline, FILTER_VALIDATE_BOOLEAN)) {
            $inline = true;
        }

        // helper
        $this->addHelper($comp->helper, $comp->name);

        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);

        foreach ($comp->radioButtons as $rad) {
            $rad_attr = '';
            if ($comp->value === $rad->value) {
                $rad_attr = 'checked';
            }
            if ($this->output_preview === true) {
                $this->php_form->addRadio($comp->name, $rad->text, $rad->value, $rad_attr);
            }
            $php_code .= "\$form->addRadio('$comp->name', '" . $this->sanitize($rad->text) . "', '$rad->value', '" . $this->sanitize($rad_attr) . "');\n";
        }
        if ($this->output_preview === true) {
            $this->php_form->printRadioGroup($comp->name, $comp->label, $inline, $attr);
        }
        $php_code .= "\$form->printRadioGroup('$comp->name', '" . $this->sanitize($comp->label) . "', $comp->inline, '" . $this->sanitize($attr) . "');\n";
        $this->php_form_code['components'][] = $php_code;
        foreach ($comp->plugins as $key => $plugin) {
            if (!in_array($plugin->pluginName, $this->autoloaded_plugins)) {
                $this->addPlugin($plugin);
            }
        }
    }

    private function addRecaptcha($comp)
    {
        if ($this->output_preview === true) {
            $this->php_form->addRecaptchaV3($comp->publickey, $this->json_form->id);
        }
        $form_id = $this->json_form->id;
        if (empty($comp->publickey)) {
            $comp->publickey = 'RECAPTCHA_PUBLIC_KEY_HERE';
        }
        $this->php_form_code['components'][] = "\$form->addRecaptchaV3('$comp->publickey', '$form_id');\n";
    }

    private function addSelect($comp)
    {
        $php_code             = '';
        $has_bootstrap_select = false;
        $has_select2          = false;
        foreach ($comp->plugins as $key => $plugin) {
            if ($plugin->pluginName == 'bootstrap-select') {
                $comp->attr = $this->addAttribute('class', 'selectpicker', $comp->attr);
                $has_bootstrap_select = true;
            } else if ($plugin->pluginName == 'select2') {
                $comp->attr = $this->addAttribute('class', 'select2', $comp->attr);
                $has_select2          = true;
            }
        }

        // helper
        $this->addHelper($comp->helper, $comp->name);

        // placeholder
        if (!empty($comp->placeholder)) {
            if ($has_bootstrap_select === true) {
                $comp->attr = $this->addAttribute('title', $comp->placeholder, $comp->attr);
            } else if ($has_select2 === true) {
                $comp->attr = $this->addAttribute('data-placeholder', $comp->placeholder, $comp->attr);
            } else {
                $php_code .= "\$form->addOption('$comp->name', '', '$comp->placeholder', '', 'disabled, selected');\n";
            }
            foreach ($comp->attr as $index => $attr) {
                if ($attr->name === 'placeholder') {
                    // placeholder has been added to the form, we delete the attribute & reindex
                    unset($comp->attr[$index]);
                    $comp->attr = array_values($comp->attr);
                }
            }
        }
        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);
        $is_multiple = false;
        if (!empty($attr) && strpos('multiple=true', $attr) !== false) {
            $is_multiple = true;
        }
        if (!empty($comp->placeholder) && $has_bootstrap_select !== true) {
            if ($this->output_preview === true) {
                $this->php_form->addOption($comp->name, '', $comp->placeholder, '', 'disabled, selected');
            }
            $php_code .= "\$form->addOption('$comp->name', '', '$comp->placeholder', '', 'disabled, selected');\n";
        }
        if ($is_multiple !== true) {
            foreach ($comp->selectOptions as $option) {
                $opt_attr = '';

                if ($comp->value === $option->value) {
                    $opt_attr = 'selected';
                }
                if ($this->output_preview === true) {
                    $this->php_form->addOption($comp->name, $option->value, $option->text, $option->groupname, $opt_attr);
                }
                $php_code .= "\$form->addOption('$comp->name', '$option->value', '$option->text', '$option->groupname', '$opt_attr');\n";
            }
        } else {
            $select_array_values = array_map('trim', explode(',', $comp->value));
            foreach ($comp->selectOptions as $option) {
                $opt_attr = '';

                if (in_array($option->value, $select_array_values)) {
                    $opt_attr = 'selected';
                }
                if ($this->output_preview === true) {
                    $this->php_form->addOption($comp->name, $option->value, $option->text, $option->groupname, $opt_attr);
                }
                $php_code .= "\$form->addOption('$comp->name', '$option->value', '$option->text', '$option->groupname', '$opt_attr');\n";
            }
        }
        if ($this->output_preview === true) {
            $this->php_form->addSelect($comp->name, $comp->label, $attr);
        }
        $php_code .= "\$form->addSelect('$comp->name', '" . $this->sanitize($comp->label) . "', '" . $this->sanitize($attr) . "');\n";
        $this->php_form_code['components'][] = $php_code;
        foreach ($comp->plugins as $key => $plugin) {
            if (!in_array($plugin->pluginName, $this->autoloaded_plugins)) {
                $this->addPlugin($plugin);
            }
        }
    }

    private function addSetCols($section)
    {
        $comp = $section->component;
        if (isset($comp->label) && isset($comp->width)) {
            $cw = $comp->width;
            if (empty($comp->label)) {
                $cols = array(
                    '100%' => '0-12',
                    '66%'  => '0-8',
                    '50%'  => '0-6',
                    '33%'  => '0-4'
                );
            } else {
                $cols = array(
                    '100%' => '4-8',
                    '66%'  => '3-5',
                    '50%'  => '2-4',
                    '33%'  => '2-2'
                );
            }
            $form_cols = $cols[$cw];
            if ($form_cols !== $this->current_cols) {
                $new_cols = explode('-', $form_cols);
                if ($this->output_preview === true) {
                    $this->php_form->setCols($new_cols[0], $new_cols[1]);
                }
                $this->php_form_code['components'][] = "\$form->setCols($new_cols[0], $new_cols[1]);\n";

                $this->current_cols = $form_cols;
            }
        } else if ($section->componentType == 'buttongroup' || $section->componentType == 'button') {
            if ($this->output_preview === true) {
                $this->php_form->setCols(0, 12);
                $this->php_form->centerButtons(true);
            }
            $this->php_form_code['components'][] = "\$form->setCols(0, 12);\n";
            $this->php_form_code['components'][] = "\$form->centerButtons(true);\n";

            $this->current_cols = '0-12';
        }
    }

    private function addTextarea($comp)
    {
        foreach ($comp->plugins as $key => $plugin) {
            if ($plugin->pluginName == 'tinymce') {
                $comp->attr = $this->addAttribute('class', 'tinymce', $comp->attr);
            }
        }
        $attrArray = $this->mergeAttributes($comp);
        $attr = $this->getAttributes($attrArray);
        $this->addHelper($comp->helper, $comp->name);
        if ($this->output_preview === true) {
            $this->php_form->addTextarea($comp->name, $comp->value, $comp->label, $attr);
        }
        $this->php_form_code['components'][] = "\$form->addTextarea('$comp->name', '$comp->value', '$comp->label', '$attr');\n";
        foreach ($comp->plugins as $key => $plugin) {
            if (!in_array($plugin->pluginName, $this->autoloaded_plugins)) {
                $this->addPlugin($plugin);
            }
        }
    }

    private function addTitle($comp)
    {
        $class = '';
        if (!empty($comp->clazz)) {
            $class = ' class="' . $comp->clazz . '"';
        }
        if ($this->output_preview === true) {
            $this->php_form->addHtml('<' . $comp->type . $class . '>' . $comp->value . '</' . $comp->type . '>');
        }
        $this->php_form_code['components'][] = "\$form->addHtml('" . $this->sanitize('<' . $comp->type . $class . '>' . $this->sanitize($comp->value) . '</' . $comp->type . '>') . "');\n";
    }

    private function buildCodeParts()
    {
        /* Start
        -------------------------------------------------- */

        $start_1 = array(
            '&lt;?php',
            'use phpformbuilder\Form;',
            'use phpformbuilder\Validator\Validator;'
        );
        $start_2 = array();
        if ($this->json_form->aftervalidation === 'db-insert' || $this->json_form->aftervalidation === 'db-update' || $this->json_form->aftervalidation === 'db-delete') {
            $start_2 = array('use phpformbuilder\database\Mysql;');
        }
        $start_3 = array(
            '',
            '/* =============================================',
            '    start session and include form class',
            '============================================= */',
            '',
            'session_start();',
            'include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'' . $this->current_dir . 'Form.php\';',
            ''
        );

        $start = array_merge($start_1, $start_2, $start_3);
        $this->php_form_code['start'] = implode("\n", $start);

        /* if_posted
        -------------------------------------------------- */

        $if_posted_1 = array(
            '',
            '/* =============================================',
            '    validation if posted',
            '============================================= */',
            '',
            'if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken(\'' . $this->json_form->id . '\') === true) {',
            '    // create validator & auto-validate required fields',
            '    $validator = Form::validate(\'' . $this->json_form->id . '\');'
        );
        $if_posted_2 = array();
        if ($this->has_email_fields === true) {
            $if_posted_2 = array(
                '',
                '    // additional validation'
            );
            foreach ($this->email_field_names as $field_name) {
                $if_posted_2[] = '    $validator->email()->validate(\'' . $field_name . '\');';
            }
        }
        $if_posted_3 = array();
        if ($this->has_recaptcha === true) {
            if (empty($this->recaptcha_private_key)) {
                $this->recaptcha_private_key = 'RECAPTCHA_PRIVATE_KEY_HERE';
            }
            $if_posted_3 = array(
                '',
                '    // recaptcha validation',
                '    $validator->recaptcha(\'' . $this->recaptcha_private_key . '\', \'Recaptcha Error\')->validate(\'g-recaptcha-response\');'
            );
        }
        $if_posted_4 = array();
        if ($this->hasCaptcha === true) {
            $if_posted_4 = array(
                '',
                '    // captcha validation',
                '    $validator->captcha()->validate(\'' . $this->captchaFieldname . '\');'
            );
        }
        $if_posted_5 = array(
            '',
            '    // check for errors',
            '    if ($validator->hasErrors()) {',
            '        $_SESSION[\'errors\'][\'' . $this->json_form->id . '\'] = $validator->getAllErrors();',
            '    } else {'
        );
        $if_posted_6 = array();
        if ($this->json_form->aftervalidation === 'send-email') {
            // Email sending
            $if_posted_6 = array(
                '        // send email',
                '        $email_config = array(',
                '            \'sender_email\'    => \'' . $this->json_form->senderEmail . '\',',
                '            \'recipient_email\' => \'' . $this->json_form->recipientEmail . '\',',
                '            \'subject\'         => \'' . $this->json_form->subject . '\','
            );
            if (!empty($this->json_form->senderName)) {
                $if_posted_6[] = '            \'sender_name\'     => \'' . $this->json_form->senderName . '\',';
            }
            if (!empty($this->json_form->replyToEmail)) {
                $if_posted_6[] = '            \'reply_to_email\'  => \'' . $this->json_form->replyToEmail . '\',';
            }
            if (!empty($this->json_form->sentMessage)) {
                $if_posted_6[] = '            \'sent_message\'    => \'' . $this->json_form->sentMessage . '\',';
            }
            $if_posted_6[] = '            \'filter_values\'   => \'' . $this->json_form->id . '\'';
            $if_posted_6[] = '        );';
            $if_posted_6[] = '        $sent_message = Form::sendMail($email_config);';

            $message = array(
                'if (isset($sent_message)) {',
                '    echo $sent_message;',
                '}'
            );
            $this->php_form_code['message'] = implode("\n", $message);
        } else if ($this->json_form->aftervalidation === 'db-insert' || $this->json_form->aftervalidation === 'db-update' || $this->json_form->aftervalidation === 'db-delete') {
            $message = array(
                'if (isset($msg)) {',
                '    echo $msg;',
                '}'
            );
            $this->php_form_code['message'] = implode("\n", $message);
            // DB insert
            $if_posted_6 = array(
                '        include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'' . $this->current_dir . 'database/db-connect.php\';',
                '        include_once rtrim($_SERVER[\'DOCUMENT_ROOT\'], DIRECTORY_SEPARATOR) . \'' . $this->current_dir . 'database/Mysql.php\';',
                '',
                '        $db = new Mysql();'
            );

            if ($this->json_form->aftervalidation === 'db-insert') {

                foreach ($this->db_fields as $db_field) {
                    if ($db_field['component_name'] === $this->json_form->dbPrimary) {
                        $if_posted_6[] = '        $insert[\'' . $db_field['component_name'] . '\'] = Mysql::SQLValue(\'\');';
                    } else if ($db_field['multiple'] === true) {
                        $if_posted_6[] = '        $insert[\'' . $db_field['component_name'] . '\'] = Mysql::SQLValue(json_encode($_POST[\'' . $db_field['component_name'] . '\']));';
                    } else {
                        $if_posted_6[] = '        $insert[\'' . $db_field['component_name'] . '\'] = Mysql::SQLValue($_POST[\'' . $db_field['component_name'] . '\']);';
                    }

                }
                $if_posted_6[] = '        if (!$db->insertRow(\'' . $this->json_form->dbTable . '\', $insert)) {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-danger">\' . $db->error() . \'<br>\' . $db->getLastSql() . \'</p>\' . " \n";';
                $if_posted_6[] = '        } else {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-success">1 row inserted !</p>\' . " \n";';
                $if_posted_6[] = '        }';
            } else if ($this->json_form->aftervalidation === 'db-update') {

                foreach ($this->db_fields as $db_field) {
                    if ($db_field['component_name'] === $this->json_form->dbFilter) {
                        $if_posted_6[] = '        $filter[\'' . $db_field['component_name'] . '\'] = Mysql::sqlValue($_POST[\'' . $db_field['component_name'] . '\']);';
                    } else if ($db_field['multiple'] === true) {
                        $if_posted_6[] = '        $update[\'' . $db_field['component_name'] . '\'] = Mysql::SQLValue(json_encode($_POST[\'' . $db_field['component_name'] . '\']));';
                    } else {
                        $if_posted_6[] = '        $update[\'' . $db_field['component_name'] . '\'] = Mysql::SQLValue($_POST[\'' . $db_field['component_name'] . '\']);';
                    }

                }
                $if_posted_6[] = '        if (!$db->updateRows(\'' . $this->json_form->dbTable . '\', $update, $filter)) {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-danger">\' . $db->error() . \'<br>\' . $db->getLastSql() . \'</p>\' . " \n";';
                $if_posted_6[] = '        } else {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-success">Database updated successfully !</p>\' . " \n";';
                $if_posted_6[] = '        }';
            } else if ($this->json_form->aftervalidation === 'db-delete') {

                foreach ($this->db_fields as $db_field) {
                    if ($db_field['component_name'] === $this->json_form->dbFilter) {
                        $if_posted_6[] = '        $filter[\'' . $db_field['component_name'] . '\'] = Mysql::sqlValue($_POST[\'' . $db_field['component_name'] . '\']);';
                    }
                }
                $if_posted_6[] = '        if (!$db->deleteRows(\'' . $this->json_form->dbTable . '\', $filter)) {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-danger">\' . $db->error() . \'<br>\' . $db->getLastSql() . \'</p>\' . " \n";';
                $if_posted_6[] = '        } else {';
                $if_posted_6[] = '            $msg = \'<p class="alert alert-success">1 row deleted !</p>\' . " \n";';
                $if_posted_6[] = '        }';
            }
        }

        $if_posted_6[] = '        // clear the form';
        $if_posted_6[] = '        Form::clear(\'' . $this->json_form->id . '\');';
        if (!empty($this->json_form->redirectUrl)) {
            $if_posted_6[] = '        // redirect after success';
            $if_posted_6[] = '        header(\'Location:' . $this->json_form->redirectUrl . '\');';
            $if_posted_6[] = '        exit;';
        }
        $if_posted_6[] = '    }';
        $if_posted_6[] = '}';
        $if_posted_6[] = '';

        $if_posted = array_merge($if_posted_1, $if_posted_2, $if_posted_3, $if_posted_4, $if_posted_5, $if_posted_6);
        $this->php_form_code['if_posted'] = implode("\n", $if_posted);

        /* head
        -------------------------------------------------- */

        if ($this->json_form->ajax !== 'true') {
            $this->php_form_code['head'] = '';
            $icon_font_url = $this->getIconFont();
            if (!empty($icon_font_url)) {
                $icon_font = $this->json_form->iconFont;
                $this->php_form_code['head'] .= "&lt;!-- $icon_font --&gt;\n\n&lt;link rel=\"stylesheet\" href=\"$icon_font_url\"&gt;\n\n";
            }
            $this->php_form_code['head'] .= "&lt;?php \$form->printIncludes('css'); ?&gt;\n";
        }

        /* render
        -------------------------------------------------- */

        $render = array();
        if ($this->json_form->ajax !== 'true') {
            $render[] = '&lt;?php';
        } else {
            $render[] = '';
        }
        if (!empty($this->php_form_code['message'])) {
            $render[] = $this->php_form_code['message'];
        }
        if ($this->json_form->ajax === 'true') {
            $render[] = '';
        }
        $render[] = '$form->render();';
        if ($this->json_form->ajax !== 'true') {
            $render[] = '?&gt;';
        } else {
            $render[] = '';
        }
        $this->php_form_code['render'] = implode("\n", $render);

        /* scripts
        -------------------------------------------------- */

        if ($this->json_form->ajax !== 'true') {
            $scripts = array(
                '&lt;?php',
                '$form->printIncludes(\'js\');',
                '$form->printJsCode();',
                '?&gt;'
            );
            if ($this->json_form->framework === 'material' || $this->json_form->framework === 'bs4-material') {
                $scripts[] = '&lt;script&gt;';
                $scripts[] = '$(document).ready(function() {';
                $scripts[] = '    $(\'select:not(.selectpicker):not(.select2)\').formSelect();';
                $scripts[] = '});';
                $scripts[] = '&lt;/script&gt;';
            }
            $this->php_form_code['scripts'] = implode("\n", $scripts);
        } else {
            $scripts = array(
                '&lt;!-- Ajax form loader --&gt;',
                '',
                '&lt;script type="text/javascript"&gt;',
                'var $head= document.getElementsByTagName(\'head\')[0],',
                '    target = \'#ajax-' . $this->json_form->id . '-loader\';',
                '',
                'var loadData = function(data, index) {',
                '    if (index &lt;= $(data).length) {',
                '        var that = $(data).get(index);',
                '        if ($(that).is(\'script\')) {',
                '            // output script',
                '            var script = document.createElement(\'script\');',
                '            script.type = \'text/javascript\';',
                '            if (that.src != \'\') {',
                '                script.src = that.src;',
                '                script.onload = function() {',
                '                    loadData(data, index + 1);',
                '                };',
                '                $head.append(script);',
                '            } else {',
                '                script.text = that.text;',
                '                $(\'body\').append(script);',
                '                loadData(data, index + 1);',
                '            }',
                '        } else {',
                '            // output form html',
                '            $(target).append($(that));',
                '            loadData(data, index + 1);',
                '        }',
                '    } else {',
                '        $.holdReady(false);',
                '    }',
                '};',
                '',
                '$(document).ready(function() {',
                '    $.ajax({',
                '        url: \'/ajax-forms/' . $this->json_form->id . '.php\',',
                '        type: \'GET\'',
                '    }).done(function(data) {',
                '        $.holdReady(true);',
                '        loadData(data, 0);',
                '    }).fail(function(data, statut, error) {',
                '        console.log(error);',
                '    });',
                '});',
                '&lt;/script&gt;'
            );
            $this->php_form_code['scripts'] = implode("\n", $scripts);
        }

        /* Main form code
        -------------------------------------------------- */

        $main_code = '';
        $main_code .= $this->php_form_code['start'];
        $main_code .= $this->php_form_code['if_posted'];
        $main_code .= $this->php_form_code['start_form'];
        foreach ($this->php_form_code['components'] as $comp) {
            $main_code .= $comp;
        }
        $main_code .= $this->php_form_code['global_plugins'];
        if ($this->json_form->ajax === 'true') {
            $main_code .= $this->php_form_code['render'];
        }
        $this->php_form_code['main'] = $main_code;
    }

    /**
     * display error message if
     *     - iCheck used with material
     * @param string $msg
     */
    private function buildErrorMsg($msg)
    {
        $this->error_msg .= '<div style="line-height:30px;border-radius:5px;border-bottom:1px solid #ac2925;background-color: #c9302c;margin:10px auto;"><p style="color:#fff;text-align:center;font-size:16px;margin:0">' . $msg . '</p></div>';
    }

    private function buildSection($section)
    {
        if ($this->json_form->layout == 'horizontal') {
            $this->addSetCols($section);

            if ($section->group_inputs !== false) {
                $this->addGroupInputs($section->group_inputs);
            }
        }
        switch ($section->componentType) {
            case 'button':
                $this->addBtn($section->component);
                break;

            case 'buttongroup':
                $this->addBtngroup($section->component);
                break;

            case 'checkbox':
                $this->addCheckboxGroup($section->component);
                break;

            case 'dependent':
                $this->startDependent($section->component);
                break;

            case 'dependentend':
                $this->endDependent();
                break;

            case 'html':
                $this->addHtml($section->component);
                break;

            case 'input':
                $this->addInput($section->component);
                break;

            case 'paragraph':
                $this->addParagraph($section->component);
                break;

            case 'radio':
                $this->addRadioGroup($section->component);
                break;

            case 'recaptcha':
                $this->addRecaptcha($section->component);
                break;

            case 'select':
                $this->addSelect($section->component);
                break;

            case 'textarea':
                $this->addTextarea($section->component);
                break;

            case 'title':
                $this->addTitle($section->component);
                break;

            default:
                # code...
                break;
        }
    }

    private function createForm($json_form) {
        $form_framework = $json_form->framework;
        $is_bs4_material = false;
        if ($form_framework === 'bs4-material') {
            $form_framework = 'material';
            $is_bs4_material = true;
        }
        foreach ($json_form->plugins as $pl) {
            if ($pl->pluginName === 'formvalidation') {
                if (empty($json_form->attr)) {
                    $json_form->attr = 'data-fv-no-icon=true';
                } else {
                    $json_form->attr .= ', data-fv-no-icon=true';
                }
            }
        }
        if ($this->output_preview === true) {
            $this->php_form = new Form($json_form->id, $json_form->layout, $json_form->attr, $form_framework);
            if ($is_bs4_material === true) {
                $this->php_form->addPlugin('materialize', '#' . $json_form->id);
            }
            $this->php_form->useLoadJs('core-preview');
            $this->php_form->setMode('development');
        }
        $this->php_form_code['start_form'] = "\n/* ==================================================\n    The Form\n ================================================== */\n\n";
        $this->php_form_code['start_form'] .= "\$form = new Form('$json_form->id', '$json_form->layout', '$json_form->attr', '$form_framework');\n";
        if ($this->json_form->ajax === 'true') {
            $this->php_form_code['start_form'] .= "// enable Ajax loading\n\$form->setOptions(['ajax' => true]);\n\n";
        }
        if ($is_bs4_material === true) {
            $this->php_form_code['start_form'] .= "\$form->addPlugin('materialize', '#$json_form->id');\n";
        }
        $this->php_form_code['start_form'] .= "// \$form->setMode('development');\n";
    }

    private function endDependent()
    {
        if ($this->output_preview === true) {
            $this->php_form->endDependentFields();
        }
        $this->php_form_code['components'][] = "\$form->endDependentFields();\n";
    }

    private function getAttributes($attrArray)
    {
        $tempArray = array();
        foreach ($attrArray as $attr) {
            if (!empty($attr->value) && !is_bool($attr->value)) {
                $tempArray[] = $attr->name . '=' . str_replace(',', '\,', $attr->value);
            } else {
                $tempArray[] = $attr->name;
            }
        }
        $attr = implode(',',$tempArray);

        return $attr;
    }

    /**
     * getCurrentDir
     *
     * @return current_dir root-relative dir to phpformbuilder with starting & ending DIRECTORY_SEPARATOR
     */
    private function getCurrentDir()
    {
        $phpformbuilder_path = realpath('../../phpformbuilder');

        $document_root = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']);
        $phpformbuilder_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $phpformbuilder_path);

        $current_dir = DIRECTORY_SEPARATOR . ltrim(str_replace($document_root, '', $phpformbuilder_path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // var_dump($current_dir);

        return $current_dir;
    }

    /**
     * getIconFont
     * The fonts URLs are listed in src/ts/defaultConfig.ts
     *
     * @return link to the font stylesheet || ''
     */
    private function getIconFont()
    {
        $iconFonts = array(
            'elusiveicon'    => 'assets/fonts/elusive-icons-2.0.0/css/elusive-icons.min.css',
            'fontawesome5'   => '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css',
            'ionicon'        => '//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
            'materialdesign' => '//cdn.jsdelivr.net/npm/material-design-iconic-font@2.2.0/dist/css/material-design-iconic-font.min.css',
            'octicon'        => '//cdnjs.cloudflare.com/ajax/libs/octicons/4.4.0/font/octicons.min.css',
            'typicon'        => '//cdnjs.cloudflare.com/ajax/libs/typicons/2.0.9/typicons.min.css'
        );
        if (array_key_exists($this->json_form->iconFont, $iconFonts)) {
            $icf = $this->json_form->iconFont;
            return $iconFonts[$icf];
        }
        return '';
    }

    private function getLastJsonError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return '';
            break;
            case JSON_ERROR_DEPTH:
                $error_msg = 'JSON Error - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                $error_msg = 'JSON Error - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                $error_msg = 'JSON Error - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                $error_msg = 'JSON Error - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                $error_msg = 'JSON Error - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                $error_msg = 'JSON Error - Unknown error';
            break;
        }

        return $error_msg;
    }

    private function getSectionGroups()
    {
        $json_form_sections_count = count($this->json_form_sections);
        $grouppable_component_types = array('checkbox', 'input', 'radio', 'select', 'textarea');
        $group_started = false;
        for ($i=0; $i < $json_form_sections_count; $i++) {
            $current_section               = $this->json_form_sections[$i];
            $current_section->group_inputs = false;
            if (isset($this->json_form_sections[$i + 1]) && $group_started === false) {
                $next_section = $this->json_form_sections[$i + 1];
                if (in_array($current_section->componentType, $grouppable_component_types) && in_array($next_section->componentType, $grouppable_component_types)) {
                    $current_component_width = intval(str_replace('%', '', $current_section->component->width));
                    $next_component_width = intval(str_replace('%', '', $next_section->component->width));
                    if ($current_component_width + $next_component_width <= 100) {
                        $current_section->group_inputs = array($current_section->component->name, $next_section->component->name);
                        $group_started = true;
                    }
                }
            } else {
                $group_started = false;
            }
        }
    }

    private function getSpecialData()
    {
        $add_to_dbfields = array('checkbox', 'input', 'radio', 'select', 'textarea');

        foreach ($this->json_form_sections as $key => $section) {
            if (in_array($section->componentType, $add_to_dbfields)) {
                $multiple = false;
                if ($section->componentType === 'checkbox' || ($section->componentType === 'select' && in_array('multiple', $section->component->attr))) {
                    $multiple = true;
                }
                $db_field = array(
                    'component_type' => $section->componentType,
                    'component_name' => $section->component->name,
                    'multiple'       => $multiple
                );
                $this->db_fields[] = $db_field;
            }
            if ($section->componentType === 'recaptcha') {
                $this->has_recaptcha = true;
                $this->recaptcha_private_key = $section->component->privatekey;
            } else if($section->componentType === 'input') {
                if ($section->component->type === 'email') {
                    $this->has_email_fields = true;
                    $this->email_field_names[] = $section->component->name;
                }
            }
            if (isset($section->component->plugins)) {
                foreach ($section->component->plugins as $key => $plugin) {
                    if ($plugin->pluginName === 'captcha') {
                        $this->hasCaptcha = true;
                        $this->captchaFieldname = $section->component->name;
                    }
                }
            }
        }
    }

    private function mergeAttributes($component)
    {
        if (!empty($component->plugins)) {
            foreach ($component->plugins as $plugin) {
                if ($plugin->dataAttributes !== null) {
                    foreach ($plugin->dataAttributes as $attr) {
                        if ($attr !== null && isset($attr->value) && $attr->value !== null) {
                            // create new attr object then push it to the component attributes
                            $plugin_attr = new \stdClass();
                            $plugin_attr->name = 'data-' . $attr->name;
                            $plugin_attr->value = $attr->value;
                            $component->attr[] = $plugin_attr;
                        }
                    }
                }
            }
        }
        return $component->attr;
    }

    private function reindentCode($codepart, $spaces)
    {
        $replacement = '';
        for ($i=0; $i < $spaces; $i++) {
            $replacement .= ' ';
        }
        return rtrim(preg_replace("`[\n]`", "\n" . $replacement, $codepart)) . "\n";
    }

    private function sanitize($html)
    {
        return htmlspecialchars(str_replace(array("\\", "'"),  array("\\\\", "\'"), $html));
    }

    private function startDependent($component)
    {
        if ($this->output_preview === true) {
            $this->php_form->startDependentFields($component->name, $component->value);
        }
        $this->php_form_code['components'][] = "\$form->startDependentFields('$component->name', '" . $this->sanitize($component->value) . "');\n";
    }
}
