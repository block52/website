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

$form_id = 'plugins-tooltip-form-1';

$form = new Form($form_id, 'vertical');


$form->addInput('text', 'input-a', '', 'Default tooltip', 'required, data-tooltip=I\'m a default tooltip');
$form->addInput('text', 'input-z', '', 'Tooltip with title', 'required, data-tooltip=I\'m a default tooltip with title, data-title=Title here');
$form->addInput('text', 'input-e', '', 'Styled Tooltip', 'required, data-tooltip=I\'m styled, data-style=cluetip');
$form->addInput('text', 'input-r', '', 'Positioned tooltip', 'required, data-tooltip=I\'m on the right, data-position=right');
$form->addInput('text', 'input-t', '', 'Tooltip on hover', 'required, data-tooltip=I\'m an hovered default tooltip, data-show-event=mouseenter, data-hide-event=mouseleave');

$form->addPlugin('tooltip', '[data-tooltip]', 'default', array('%style%' => 'qtip-tipsy'));


$output['title'][]      = '';
$output['form_code'][]  = htmlspecialchars('$form = new Form(\'' . $form_id . '\', \'vertical\');

$form->addInput(\'text\', \'input-a\', \'\', \'Default tooltip\', \'required, data-tooltip=I\\\'m a default tooltip\');
$form->addInput(\'text\', \'input-z\', \'\', \'Tooltip with title\', \'required, data-tooltip=I\\\'m a default tooltip with title, data-title=Title here\');
$form->addInput(\'text\', \'input-e\', \'\', \'Styled Tooltip\', \'required, data-tooltip=I\\\'m styled, data-style=cluetip\');
$form->addInput(\'text\', \'input-r\', \'\', \'Positioned tooltip\', \'required, data-tooltip=I\\\'m on the right, data-position=right\');
$form->addInput(\'text\', \'input-t\', \'\', \'Tooltip on hover\', \'required, data-tooltip=I\\\'m an hovered default tooltip, data-show-event=mouseenter, data-hide-event=mouseleave\');

$form->addPlugin(\'tooltip\', \'[data-tooltip]\', \'default\', array(\'%style%\' => \'qtip-tipsy\'));');

$output['form'][]        = $form;
$output['html_code'][]   = trim(htmlspecialchars($form->cleanHtmlOutput($form->html)));

echo renderExample($output);
