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

$form_id = 'plugins-pickadate-timepicker-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'user-pickatime', '', 'Time', 'required');

$form->addPlugin('pickadate', '#user-pickatime', 'pickatime');


$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'user-pickatime\', \'\', \'Time\', \'required\');

$form->addPlugin(\'pickadate\', \'#user-pickatime\', \'pickatime\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-pickadate-timepicker-form-2';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'user-pickatime-2', '', 'Time', 'data-format=HH:i, data-format-submit=HH:i, data-min=9\,30, data-max=17\,00, data-interval=60, required');

$form->addPlugin('pickadate', '#user-pickatime-2', 'pickatime');


$output['title'][]     = 'Time with custom Submit Format, min & max time, custom interval';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'user-pickatime-2\', \'\', \'Time\', \'data-format=H:i, data-format-submit=H:i, data-min=09\,30, data-max=17\,00, data-interval=60, required\');

$form->addPlugin(\'pickadate\', \'#user-pickatime-2\', \'pickatime\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
