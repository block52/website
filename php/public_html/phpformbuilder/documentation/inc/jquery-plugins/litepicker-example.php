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

$form_id = 'plugins-litepicker-form-1';

$form = new Form($form_id, 'horizontal');


$form->addInput('text', 'my-daterange', '', 'Choose the start and end dates:', 'class=litepick, data-single-mode=false');


$output['title'][]      = 'Date range selector with minimum options';
$output['form_code'][]  = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'my-daterange\', \'\', \'Choose the start and end dates:\', \'class=litepick, data-single-mode=false\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-litepicker-form-2';

$form = new Form($form_id, 'horizontal');

// set minimum date
$now      = new DateTime('now');
$date_min = $now->format('Y-m-d');

$form->addInput('text', 'my-daterange-2', '', 'Choose the start and end dates', 'class=litepick, data-single-mode=false, data-min-date=' . $date_min . ', data-format=YYYY-MM-DD');

$output['title'][]      = 'Date range selector with a minimum date and a custom format';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addInput(\'text\', \'my-daterange-2\', \'\', \'Choose the start and end dates\', \'class=litepick, data-single-mode=false, data-min-date=\' . $date_min . \', data-format=YYYY-MM-DD\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 3 ----------*/

$form_id = 'plugins-litepicker-form-3';

$form = new Form($form_id, 'vertical');

// set minimum date
$now      = new DateTime('now');
$date_min = $now->format('Y-m-d');

$form->addInput('text', 'pick-up-date', '', 'Pick-up Date', 'class=litepick, data-single-mode=false, data-min-date=' . $date_min . ', data-format=YYYY-MM-DD, data-element-end=drop-off-date, data-split-view=true, required');
$form->addInput('text', 'drop-off-date', '', 'Drop-off Date', 'readonly, required');

$output['title'][]      = 'Date range selector with a minimum date, a custom format and start date / end date in 2 separate fields';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->addInput(\'text\', \'pick-up-date\', \'\', \'Pick-up Date\', \'class=litepick, data-single-mode=false, data-min-date=\' . $date_min . \', data-format=YYYY-MM-DD, data-element-end=drop-off-date, data-split-view=true, required\');
$form->addInput(\'text\', \'drop-off-date\', \'\', \'Drop-off Date\', \'readonly, required\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
