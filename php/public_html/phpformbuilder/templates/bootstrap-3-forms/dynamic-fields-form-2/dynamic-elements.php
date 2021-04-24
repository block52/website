<?php
use phpformbuilder\Form;

session_start();

if (!isset($_POST['index']) || !is_numeric($_POST['index'])) {
    exit();
}

include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

// define the form name globally
// (must be the same as the main calling form)
$form_id = 'dynamic-fields-form-2';

$index = $_POST['index'];

// retrieve & register errors
if (isset($_SESSION['ajax-errors'][$form_id])) {
    $_SESSION['errors'][$form_id] = $_SESSION['ajax-errors'][$form_id];
}

$form = new Form($form_id, 'horizontal');
// $form->setMode('development');
$form->setCols(2, 3, 'md');
$form->groupInputs('job-' . $index, 'person-' . $index, 'remove-btn');

$form->addOption('job-' . $index, '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('job-' . $index, 'Content writer', 'Content writer');
$form->addOption('job-' . $index, 'Tech Support / Technical Leader', 'Tech Support / Technical Leader');
$form->addOption('job-' . $index, 'Office Assistant', 'Office Assistant');
$form->addOption('job-' . $index, 'Secretary', 'Secretary');
$form->addOption('job-' . $index, 'Team Leader', 'Team Leader');
$form->addOption('job-' . $index, 'Data Analyst', 'Data Analyst');
$form->addOption('job-' . $index, 'Safety Officer', 'Safety Officer');
$form->addOption('job-' . $index, 'Delivery Boy', 'Delivery Boy');
$form->addOption('job-' . $index, 'Admin Assistant', 'Admin Assistant');
$form->addSelect('job-' . $index, 'Job ' . $index, 'class=selectpicker job, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, required');

$form->addOption('person-' . $index, '', 'Choose one ...', '', 'disabled, selected');
$form->addOption('person-' . $index, 'Adam Bryant', 'Adam Bryant');
$form->addOption('person-' . $index, 'Lillian Riley', 'Lillian Riley');
$form->addOption('person-' . $index, 'Paula Day', 'Paula Day');
$form->addOption('person-' . $index, 'Kelly Stephens', 'Kelly Stephens');
$form->addOption('person-' . $index, 'Russell Hawkins', 'Russell Hawkins');
$form->addOption('person-' . $index, 'Carl Watson', 'Carl Watson');
$form->addOption('person-' . $index, 'Judith White', 'Judith White');
$form->addOption('person-' . $index, 'Tina Cook', 'Tina Cook');
$form->addSelect('person-' . $index, 'Person ' . $index, 'class=selectpicker person, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, required');

$form->setCols(0, 2, 'md');
$form->addBtn('button', 'remove-btn', '', '<span class="glyphicon glyphicon-minus-sign"></span>', 'class=btn btn-danger remove-element-button, data-index=' . $index);

/* render elements */

/* !!! Don't remove dynamic div, required to delete elements using jQuery !!! */

echo '<div class="dynamic" data-index="' . $index . '">' . $form->html . '</div>' . "\n";

// The script below updates the form token value with the new generated token
?>
<script type="text/javascript">
    var run = function() {
        $('input[name="dynamic-fields-form-2-token"]').val('<?php echo $_SESSION['dynamic-fields-form-2_token']; ?>');
    }
</script>
