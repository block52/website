<?php
use phpformbuilder\Form;
use dragNDropFormGenerator\FormGenerator;
session_start();
include_once '../FormGenerator.php';
include_once '../../phpformbuilder/Form.php';
/* $json = json_decode($_POST['data']);
foreach ($json as $var => $val) {
    ${$var} = $val;
    echo '<h3 class="text-white font-weight-light bg-secondary px-2 py-1">' . $var . '</h3>';
    var_dump(${$var});
} */

$generator = new FormGenerator($_POST['data']);
?>

<div id="drag-and-drop-preview" class="container">
    <?php $generator->outputPreview(); ?>
</div>
<!-- JavaScript -->
<script src="assets/javascripts/preview-core.js"></script>
<script src="assets/javascripts/preview-<?php echo $generator->json_form->framework; ?>.js"></script>
<?php $generator->printJsCode(); ?>
<script>
var waitFor = ["core-preview"];
if (loadjs.isDefined("ladda/dist/ladda.min.js")) {
    waitFor.push("ladda/dist/ladda.min.js");
}
loadjs.ready(waitFor, function () {
    $('#drag-and-drop-preview form').on('submit', function(e) {
        e.preventDefault;
        if (!$('#preview-post-message')[0]) {
            $('#drag-and-drop-preview').prepend('<p id="preview-post-message" class="alert alert-warning has-icon" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>In real life, the form would have been posted, but here we\'re only in a preview, so it doesn\'t happen.</p>');
        }
        if (loadjs.isDefined("ladda/dist/ladda.min.js")) {
            setTimeout(() => {
                Ladda.stopAll();
            }, 2000);
        }
        return false;
    });
});
</script>
<?php if ($generator->json_form->framework === 'material') { ?>
<script>
loadjs.ready(["core-preview", "frameworks/material/material.min.js"], function () {
    $('select:not(.selectpicker):not(.select2)').formSelect();
});
</script>
<?php } else if ($generator->json_form->framework === 'bs4-material') { ?>
<script>
loadjs.ready(["core-preview", "frameworks/material/material.min.js", "materialize/dist/js/material-forms.min.js"], function () {
    $('select:not(.selectpicker):not(.select2)').formSelect();
});
</script>
<?php } ?>
