<?php
include_once '../class/generator/Generator.php';

@session_start();

if (isset($_SESSION['generator']) && isset($_GET['columnName']) && preg_match('([0-9a-zA-Z_-]+)', $_GET['columnName']) && isset($_GET['index']) && is_numeric($_GET['index']) && isset($_GET['value']) && preg_match('([a-zA-Z]+)', $_GET['value'])) {
    include_once '../../conf/conf.php';

    $column_name    = $_GET['columnName'];
    $value     = $_GET['value'];
    $index   = $_GET['index'];

    $helper_text = $validation_helper_texts[$value];

?>
<script type="text/javascript">
    function go() {
        $('input[name="cu_validation_arguments_<?php echo $column_name; ?>-<?php echo $index; ?>"]').siblings('.form-text').text('<?php echo $helper_text; ?>');
    }
</script>
<?php
}
