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

$form_id = 'plugins-icheck-form-1';

$form = new Form($form_id, 'horizontal');


$form->addRadio('yes-or-no', 'No', 0);
$form->addRadio('yes-or-no', 'Yes', 1);
$form->printRadioGroup('yes-or-no', 'Yes or No?', true, 'required');

$form->addCheckbox('check-this', 'I agree', 1);
$form->printCheckboxGroup('check-this', 'Please check');

$form->addPlugin('icheck', 'input', 'default', array('%theme%' => 'square', '%color%' => 'green'));


$output['title'][]     = 'Default theme green';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addRadio(\'yes-or-no\', \'No\', 0);
$form->addRadio(\'yes-or-no\', \'Yes\', 1);
$form->printRadioGroup(\'yes-or-no\', \'Yes or No?\', true, \'required\');

$form->addCheckbox(\'check-this\', \'I agree\', 1);
$form->printCheckboxGroup(\'check-this\', \'Please check\');

$form->addPlugin(\'icheck\', \'input\', \'default\', array(\'%theme%\' => \'square\', \'%color%\' => \'green\'));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 2 ----------*/

$form_id = 'plugins-icheck-form-2';

$form = new Form($form_id, 'horizontal');


$form->addRadio('yes-or-no-2', 'No', 0);
$form->addRadio('yes-or-no-2', 'Yes', 1);
$form->printRadioGroup('yes-or-no-2', 'Yes or No?', true, 'required');

$form->addCheckbox('check-this-2', 'I agree', 1);
$form->printCheckboxGroup('check-this-2', 'Please check');

$form->addPlugin('icheck', 'input', 'line', array('%color%' => 'purple'));


$output['title'][]     = 'Line theme purple';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\');

$form->addRadio(\'yes-or-no-2\', \'No\', 0);
$form->addRadio(\'yes-or-no-2\', \'Yes\', 1);
$form->printRadioGroup(\'yes-or-no-2\', \'Yes or No?\', true, \'required\');

$form->addCheckbox(\'check-this-2\', \'I agree\', 1);
$form->printCheckboxGroup(\'check-this-2\', \'Please check\');

$form->addPlugin(\'icheck\', \'input\', \'line\', array(\'%color%\' => \'purple\'));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 3 ----------*/

$form_id = 'plugins-icheck-form-3';

$form = new Form($form_id, 'horizontal', 'class=bg-dark text-white p-4');


$form->addRadio('yes-or-no-3', 'No', 0);
$form->addRadio('yes-or-no-3', 'Yes', 1);
$form->printRadioGroup('yes-or-no-3', 'Yes or No?', true, 'required');

$form->addCheckbox('check-this-3', 'I agree', 1);
$form->printCheckboxGroup('check-this-3', 'Please check');

$form->addPlugin('icheck', 'input', 'theme', array('%theme%' => 'futurico'));


$output['title'][]     = 'Futurico theme';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\', \'class=bg-dark text-white p-4\');

$form->addRadio(\'yes-or-no-3\', \'No\', 0);
$form->addRadio(\'yes-or-no-3\', \'Yes\', 1);
$form->printRadioGroup(\'yes-or-no-3\', \'Yes or No?\', true, \'required\');

$form->addCheckbox(\'check-this-3\', \'I agree\', 1);
$form->printCheckboxGroup(\'check-this-3\', \'Please check\');

$form->addPlugin(\'icheck\', \'input\', \'theme\', array(\'%theme%\' => \'futurico\'));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

/*----------  example 4 ----------*/

$form_id = 'plugins-icheck-form-4';

$form = new Form($form_id, 'horizontal', 'class=bg-dark text-white p-4');


$form->addRadio('yes-or-no-4', 'No', 0);
$form->addRadio('yes-or-no-4', 'Yes', 1);
$form->printRadioGroup('yes-or-no-4', 'Yes or No?', true, 'required');

$form->addCheckbox('check-this-4', 'I agree', 1);
$form->printCheckboxGroup('check-this-4', 'Please check');

$form->addPlugin('icheck', 'input', 'theme', array('%theme%' => 'polaris'));


$output['title'][]     = 'Polaris theme';
$output['form_code'][] = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'horizontal\', \'class=bg-dark text-white p-4\');

$form->addRadio(\'yes-or-no-4\', \'No\', 0);
$form->addRadio(\'yes-or-no-4\', \'Yes\', 1);
$form->printRadioGroup(\'yes-or-no-4\', \'Yes or No?\', true, \'required\');

$form->addCheckbox(\'check-this-4\', \'I agree\', 1);
$form->printCheckboxGroup(\'check-this-4\', \'Please check\');

$form->addPlugin(\'icheck\', \'input\', \'theme\', array(\'%theme%\' => \'polaris\'));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
