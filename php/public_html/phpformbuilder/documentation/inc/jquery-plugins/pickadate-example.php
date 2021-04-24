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

$form_id = 'plugins-pickadate-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'user-pickadate', '', 'Date', 'required');

$form->addPlugin('pickadate', '#user-pickadate');

$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'user-pickadate\', \'\', \'Date\', \'required\');

$form->addPlugin(\'pickadate\', \'#user-pickadate\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-pickadate-form-2';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'user-pickadate-2', '2019-04-26', 'Date', 'data-format=yyyy-mm-dd, required');

$form->addPlugin('pickadate', '#user-pickadate-2');

$output['title'][]     = 'Preselect a date';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'user-pickadate-2\', \'2019-04-26\', \'Date\', \'data-format=yyyy-mm-dd, required\');

$form->addPlugin(\'pickadate\', \'#user-pickadate-2\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 3 ----------*/

$form_id = 'plugins-pickadate-form-3';

$form = new Form($form_id, 'horizontal');


$now = new DateTime('now');
$date_start = $now->format('Y-m-d');
$date_end = $now->modify('+1 month')->format('Y-m-d');

$form->addInput('text', 'user-pickadate-3', '', 'Date', 'data-min=' . $date_start . ', data-max=' . $date_end . ', required');

$form->addPlugin('pickadate', '#user-pickadate-3');


$output['title'][]     = 'Minimum date set to the current day, maximum date += 1 month';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$now = new DateTime(\'now\');
$date_start = $now->format(\'Y-m-d\');
$date_end = $now->modify(\'+1 month\')->format(\'Y-m-d\');

$form->addInput(\'text\', \'user-pickadate-3\', \'\', \'Date\', \'data-min=\' . $date_start . \', data-max=\' . $date_end . \', required\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 4 ----------*/

$form_id = 'plugins-pickadate-form-4';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'user-pickadate-4', '', 'Date', 'data-format-submit=Y-m-d, data-select-years=true, data-select-months=true, required');

$form->addPlugin('pickadate', '#user-pickadate-4');


$output['title'][]     = 'Date with custom Submit Format, Year & Month dropdown selector';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'user-pickadate-4\', \'\', \'Date\', \'data-format-submit=Y-m-d, data-select-years=true, data-select-months=true, required\');

$form->addPlugin(\'pickadate\', \'#user-pickadate-4\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
