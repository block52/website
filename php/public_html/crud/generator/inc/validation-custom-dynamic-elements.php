<?php
use phpformbuilder\Form;
use phpformbuilder\FormExtended;

include_once '../class/generator/Generator.php';

@session_start();
if (isset($_SESSION['generator']) && isset($_GET['index']) && is_numeric($_GET['index']) && isset($_GET['columnName']) && preg_match('([0-9a-zA-Z_-]+)', $_GET['columnName'])) {
    include_once '../../conf/conf.php';

    $index       = $_GET['index']; // dynamic field index
    $generator   = $_SESSION['generator'];
    $column_name = $_GET['columnName'];

    $form = new FormExtended('form-select-fields', 'horizontal', 'novalidate', 'bs4');
    if (!isset($_SESSION['cu_validation_function_c_' . $column_name . '-' . $index])) {
        // default = required
        $helper_text = $validation_helper_texts['required'];
    } else {
        $function = $_SESSION['cu_validation_function_c_' . $column_name . '-' . $index];
        $helper_text = $validation_helper_texts[$function];
    }
    $form->addCustomValidationFields($column_name, $index, false, $helper_text);

    /* render elements */

    /* !!! Don't remove dynamic div, required to delete elements using jQuery !!! */

    echo $form->html;

// The script below updates the form token value with the new generated token
?>
<script type="text/javascript">
    var run = function() {
        $('input[name="form-select-fields-token"]').val('<?php echo $_SESSION['form-select-fields_token']; ?>');
    }
</script>
<?php
}
?>
