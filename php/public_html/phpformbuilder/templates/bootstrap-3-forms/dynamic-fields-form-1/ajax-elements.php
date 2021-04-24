<?php
use phpformbuilder\Form;

session_start();

if (!isset($_GET['job-index']) || !is_numeric($_GET['job-index'])) {
    exit();
}

include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

$index = $_GET['job-index'];

$form = new Form('dynamic-fields-form-1', 'horizontal', 'novalidate', 'bs3');
// $form->setMode('development');
$form->setCols(2, 4);
$form->groupInputs('job-' . $index, 'person-' . $index);
$form->addOption('job-' . $index, 'Content writer', 'Content writer');
$form->addOption('job-' . $index, 'Tech Support / Technical Leader', 'Tech Support / Technical Leader');
$form->addOption('job-' . $index, 'Office Assistant', 'Office Assistant');
$form->addOption('job-' . $index, 'Secretary', 'Secretary');
$form->addOption('job-' . $index, 'Team Leader', 'Team Leader');
$form->addOption('job-' . $index, 'Data Analyst', 'Data Analyst');
$form->addOption('job-' . $index, 'Safety Officer', 'Safety Officer');
$form->addOption('job-' . $index, 'Delivery Boy', 'Delivery Boy');
$form->addOption('job-' . $index, 'Admin Assistant', 'Admin Assistant');
$form->addSelect('job-' . $index, 'Job ' . $index, 'class=selectpicker job, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, title=Select a Job ..., required');
$form->addOption('person-' . $index, 'Adam Bryant', 'Adam Bryant');
$form->addOption('person-' . $index, 'Lillian Riley', 'Lillian Riley');
$form->addOption('person-' . $index, 'Paula Day', 'Paula Day');
$form->addOption('person-' . $index, 'Kelly Stephens', 'Kelly Stephens');
$form->addOption('person-' . $index, 'Russell Hawkins', 'Russell Hawkins');
$form->addOption('person-' . $index, 'Carl Watson', 'Carl Watson');
$form->addOption('person-' . $index, 'Judith White', 'Judith White');
$form->addOption('person-' . $index, 'Tina Cook', 'Tina Cook');
$form->addSelect('person-' . $index, 'Person ' . $index, 'class=selectpicker person, data-icon-base=glyphicon, data-tick-icon=glyphicon-ok, title=Select a Person ..., required');

/* render select lists */

echo $form->html;

// The script below updates the form token value with the new generated token
?>
<script type="text/javascript">
    var run = function() {
        $('input[name="dynamic-fields-form-1-token"]').val('<?php echo $_SESSION['dynamic-fields-form-1_token']; ?>');
    }
</script>
