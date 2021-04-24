<?php
use phpformbuilder\Form;

include_once '../../../phpformbuilder/Form.php';
include_once 'render.php';

$output = array(
    'title'       => array(),
    'form_code'   => array(),
    'form'        => array(),
    'html_code'   => array()
);

$form_id = 'plugins-material-timepicker-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'm-time', '', 'Time: ', 'required');

$form->addPlugin('material-timepicker', '#m-time');


$output['title'][] = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'m-time\', \'\', \'Time: \', \'required\');

$form->addPlugin(\'material-timepicker\', \'#m-time\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-material-timepicker-form-2';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'm-time-2', '', 'Time: ', 'data-twelve-hour=false, required');

$form->addPlugin('material-timepicker', '#m-time-2');


$output['title'][] = '24 hours Time';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'m-time-2\', \'\', \'Time: \', \'data-twelve-hour=false, required\');

$form->addPlugin(\'material-timepicker\', \'#m-time-2\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 3 ----------*/

$form_id = 'plugins-material-timepicker-form-3';

// $form = new Form($form_id, 'horizontal');


// $form->addInput('text', 'm-time-3', '', 'Time: ', 'required');
// $form->addPlugin('material-timepicker', '#m-time-3', 'default', array('%language%' => 'fr_FR'));

// // register form to call printIncludes & printJsCode in documentation/jquery-plugins.php
// $forms[] = $form;

$output['title'][] = 'Translation (i18n)';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'m-time-3\', \'\', \'Time: \', \'required\');

$form->addPlugin(\'material-timepicker\', \'#m-time-3\', \'default\', array(\'%language%\' => \'fr_FR\'));');

$output['form'][]        = '<pre><code class="language-php">// We cannot show the timepicker translated here
// because using several different languages on the same page will throw an error.</code></pre>';
$output['html_code'][]   = '';

echo renderExample($output);
