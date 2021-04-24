<?php
use phpformbuilder\Form;

@session_start();
include_once '../../conf/conf.php';
$form = new Form('reset-table-choices', 'form-inline', 'novalidate', 'bs4');
$form->addRadio('reset-data-choices', STRUCTURE_ONLY . '<span class="small text-red-300 append">*</span>', 0);
$form->addRadio('reset-data-choices', STRUCTURE_AND_DATA . '<span class="small text-red-400 append">**</span>', 1);
$form->printRadioGroup('reset-data-choices', '', false);
$form->addHtml(RESET_DATA_CHOICES_HELP_1);
$form->addHtml(RESET_DATA_CHOICES_HELP_2);
$form->addHtml(RESET_DATA_CHOICES_HELP_3);
echo '<h4 class="mb-20">' . RESET_TABLE_DATA . ' ' . $_POST['table'] . '</h4>' . "\n";
echo $form->html;
if (DEMO === true) {
    ?>
    <div class="alert alert-info has-icon">
        <h4 class="mb-0">All CRUD operations are disabled in this demo.</h4>
    </div>
    <?php
}
