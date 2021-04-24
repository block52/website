<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    Markup
=============================================

Available data attributes:
---------------------

data-tooltip    String or jQuery selector
                if String:
                    The text content of body's tooltip
                if jQuery selector:
                    jQuery selector of the hidden div which contains the tooltip html body.

data-style      One of the followings:
                qtip-plain
                qtip-light
                qtip-dark
                qtip-red
                qtip-green
                qtip-blue
                qtip-shadow     (can be mixed with others)
                qtip-rounded    (can be mixed with others)
                qtip-bootstrap
                qtip-tipsy
                qtip-youtube
                qtip-jtools
                qtip-cluetip
                qtip-tipped

data-title          String
data-show-event     Mouse event
data-hide-event     Mouse event
data-position       top|right|bottom|left
data-adjust-x       Number to adjust tooltip on x axis
data-adjust-y       Number to adjust tooltip on y axis
data-max-width      css max-width  (px|%)
data-max-height     css max-height (px|%)

/* ==================================================
    The Form
================================================== */

$form = new Form('tooltip-form', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->startFieldset('Tooltips on input focus');

$form->addInput('text', 'input-a', '', 'Default tooltip', 'data-tooltip=I\'m a default tooltip, required');
$form->addInput('text', 'input-z', '', 'Tooltip with title', 'data-tooltip=I\'m a default tooltip, data-title=Title here, required');
$form->addInput('text', 'input-e', '', 'Styled Tooltip', 'data-tooltip=I\'m styled, data-style=cluetip, required');
$form->addInput('text', 'input-r', '', 'Positioned tooltip', 'data-tooltip=I\'m on the right, data-position=right, required');
$form->addInput('text', 'input-t', '', 'Tooltip on hover', 'data-tooltip=I\'m an hovered default tooltip, data-show-event=mouseenter, data-hide-event=mouseleave, required');

// html tooltip
$form->addHtml('<div id="html-content-y" style="display:none">
    <div class="row">
        <div class="col-xs-4"><img src="../assets/img/wallacegromit.jpg" alt="Hi there"></div>
        <div class="col-xs-8"><p><em>Won\'t you come in?<br>We were just about to have some cheese ...</em></p></div>
    </div>
</div>');
$form->addInput('text', 'input-y', '', 'Html tooltip', 'data-tooltip=#html-content-y, data-max-width=380px, required');

$form->endFieldset();

/********************************************************/

$form->startFieldset('Tooltips on any text content');

// label tooltip
$form->addInput('text', 'input-u', '', 'Tooltip <span data-tooltip="I\'m a tooltip">on label</span>', 'required');

// glyphicon question sign
$form->addInput('text', 'input-o', '', 'Helper Tooltip <span class="glyphicon glyphicon-question-sign append" data-tooltip="I\'m here to help users to fill-in the following field." data-title="Do you need help ?"></span>', 'required');

// helper
$form->addHelper('Do you need <span data-tooltip="I\'m a tooltip">more help</span>?', 'input-p');
$form->addInput('text', 'input-p', '', 'Tooltip on helper text', 'required');

// checkboxes
$form->addCheckbox('chkb', 'Tooltip on checkbox', 1, 'checked=checked, data-tooltip=I\'m a tooltip on checkbox, data-show-event=ifChanged, data-hide-event=unfocus, data-adjust-x=25, data-adjust-y=-10');
$form->addCheckbox('chkb', 'Tooltip on a <span data-tooltip="I\'m a tooltip">checkbox label</span>', 1, 'checked=checked');
$form->printCheckboxGroup('chkb', 'Tooltip on <span data-tooltip="I\'m a tooltip">checkbox group label</span>');

// radio buttons
$form->addRadio('radbtn', 'Tooltip on a <span data-tooltip="I\'m a tooltip">radio button label</span>', 0);
$form->addRadio('radbtn', 'Tooltip on a radio button', 1, 'data-tooltip=I\'m a tooltip on a radio button, data-show-event=ifChanged, data-hide-event=unfocus, data-adjust-x=25, data-adjust-y=-10');
$form->printRadioGroup('radbtn', 'Tooltip on <span data-tooltip="I\'m a tooltip">radio group label</span>');

$form->endFieldset();

/********************************************************/

$form->startFieldset('Available styles');

$form->addHelper('Adds a shadows to your tooltips', 'input-q');
$form->addInput('text', 'input-q', '', 'Shadow', 'data-tooltip=I\'m a default tooltip, required with title, data-title=Title here, data-style=qtip-shadow');

$form->addHelper('Adds a rounded corner to your tooltips', 'input-s');
$form->addInput('text', 'input-s', '', 'Rounded corner', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-rounded, required');

$form->addInput('text', 'input-d', '', 'Bootstrap style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-bootstrap, required');
$form->addInput('text', 'input-f', '', 'Tipsy style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-tipsy, required');
$form->addInput('text', 'input-g', '', 'Youtube style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-youtube, required');
$form->addInput('text', 'input-h', '', 'jTools style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-jtools, required');
$form->addInput('text', 'input-j', '', 'ClueTip style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-clueTip, required');
$form->addInput('text', 'input-k', '', 'Tipped style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-tipped, required');
$form->addInput('text', 'input-l', '', 'Cream style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip, required');
$form->addInput('text', 'input-m', '', 'Light style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-light, required');
$form->addInput('text', 'input-w', '', 'Dark style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-dark, required');
$form->addInput('text', 'input-x', '', 'Red style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-red, required');
$form->addInput('text', 'input-c', '', 'Green style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-green, required');
$form->addInput('text', 'input-v', '', 'Blue style', 'data-tooltip=I\'m a tooltip with title, data-title=Title here, data-style=qtip-blue, required');

$form->addHtml('<div class="col-sm-8 col-sm-offset-4"><p>You can mix shadows and rounded corners with any style</p></div>');

$form->addInput('text', 'input-b', '', 'Blue style with shadow', 'data-tooltip=I\'m a default tooltip, required with title, data-title=Title here, data-style=qtip-blue qtip-shadow');
$form->addInput('text', 'input-n', '', 'Light style with shadow and rounded corners', 'data-tooltip=I\'m a default tooltip, required with title, data-title=Title here, data-style=qtip-light qtip-shadow qtip-rounded');

$form->endFieldset();

$form->setCols(4, 8, 'sm');
$form->addBtn('reset', 'reset-btn', 1, 'Reset <span class="glyphicon glyphicon-erase append"></span>', 'class=btn btn-warning', 'my-btn-group');
$form->addBtn('submit', 'submit-btn', 1, 'Send <span class="glyphicon glyphicon-envelope append"></span>', 'class=btn btn-success ladda-button, data-style=zoom-in', 'my-btn-group');
$form->printBtnGroup('my-btn-group');

$form->addPlugin('tooltip', '[data-tooltip]', 'default', array('%style%' => 'qtip-tipsy'));

// Custom radio & checkbox css
$form->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'yellow']);

// jQuery validation
// $form->addPlugin('formvalidation', '#tooltip-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Form with Tooltips - How to create PHP forms easily</title>
    <meta name="description" content="Bootstrap Form Generator - how to create a Form with tooltips using Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/bootstrap-3-forms/tooltip-form.php" />
    <!-- Link to Bootstrap css here -->
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
            AND REPLACE WITH BOOTSTRAP CSS
            FOR EXAMPLE <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>

    <!-- custom style for tooltips links -->
    <style type="text/css">
        span[data-tooltip]:not(.glyphicon) {
            border-bottom: 1px dotted #333;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Bootstrap Form with tooltips</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            $form->render();
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
        $form->printIncludes('js');
        $form->printJsCode();
    ?>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
