<?php
use phpformbuilder\Form;

@session_start();
include_once '../../conf/conf.php';
$form_remove_authentification_module = new Form('form-remove-authentification-module', 'vertical', 'novalidate', 'bs4');
$form_remove_authentification_module->setAction(GENERATOR_URL . 'generator.php');
$form_remove_authentification_module->startFieldset(REMOVE . ' ' . ADMIN_AUTHENTIFICATION_MODULE . ' ?');
$form_remove_authentification_module->addHtml(REMOVE_ADMIN_AUTHENTIFICATION_MODULE_HELPER);
$form_remove_authentification_module->addInputWrapper('<div class="text-center"></div>', 'remove');
$form_remove_authentification_module->addRadio('remove', NO, 0);
$form_remove_authentification_module->addRadio('remove', YES, 1);
$form_remove_authentification_module->printRadioGroup('remove', '');
$form_remove_authentification_module->endFieldset();
$form_remove_authentification_module->render();
