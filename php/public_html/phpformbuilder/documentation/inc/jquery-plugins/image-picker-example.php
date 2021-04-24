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

$form_id = 'plugins-image-picker-form-1';

$form = new Form($form_id, 'vertical');


$img_path = 'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/';
$form->addOption('animal', 'Animal 1', '', '', 'data-img-src=' . $img_path . 'animals-1.jpg, data-img-alt=Animal 1');
$form->addOption('animal', 'Animal 2', '', '', 'data-img-src=' . $img_path . 'animals-2.jpg, data-img-alt=Animal 2');
$form->addOption('animal', 'Animal 3', '', '', 'data-img-src=' . $img_path . 'animals-3.jpg, data-img-alt=Animal 3');
$form->addSelect('animal', 'Choose your preferred animal', 'required');

$form->addPlugin('image-picker', 'select');


$output['title'][]     = '';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$img_path = \'https://www.phpformbuilder.pro/templates/assets/img/random-images/animals/\';
$form->addOption(\'animal\', \'Animal 1\', \'\', \'\', \'data-img-src=\' . $img_path . \'animals-1.jpg, data-img-alt=Animal 1\');
$form->addOption(\'animal\', \'Animal 2\', \'\', \'\', \'data-img-src=\' . $img_path . \'animals-2.jpg, data-img-alt=Animal 2\');
$form->addOption(\'animal\', \'Animal 4\', \'\', \'\', \'data-img-src=\' . $img_path . \'animals-4.jpg, data-img-alt=Animal 4\');
$form->addSelect(\'animal\', \'Choose your preferred animal\', \'required\');

$form->addPlugin(\'image-picker\', \'select\');');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
