<?php
use phpformbuilder\Form;
use phpformbuilder\FormExtended;

include_once '../class/generator/Generator.php';

@session_start();
if (isset($_SESSION['generator']) && isset($_GET['index']) && is_numeric($_GET['index'])) {
    include_once '../../conf/conf.php';

    $index = $_GET['index'];
    $generator = $_SESSION['generator'];

    $form = new FormExtended('form-select-fields', 'horizontal', 'novalidate', 'bs4');
    $form->addFilterFields($generator->table, $generator->db_columns['name'], $generator->db_columns['type'], $index);

    /* render elements */

    /* !!! Don't remove dynamic div, required to delete elements using jQuery !!! */

    echo $form->html;
}

// The script below updates the form token value with the new generated token
?>
<script type="text/javascript">
    var run = function() {
        $('input[name="form-select-fields-token"]').val('<?php echo $_SESSION['form-select-fields_token']; ?>');
    }
</script>
<?php
/*
    Simple filter example

array(
    'select_label'    =>  'Name',
    'select_name'     =>  'mock-data',
    'option_text'     =>  'mock_data.last_name + mock_data.first_name',
    'fields'          =>  'mock_data.last_name, mock_data.first_name',
    'field_to_filter' =>  'mock_data.last_name',
    'from'            =>  'mock_data',
    'type'            =>  'text',
    'column'          =>  1
)

    Advanced filter example

array(
    'select_label'    =>  'Secondary nav',
    'select_name'     =>  'dropdown_ID',
    'option_text'     =>  'nav_name + dropdown.name',
    'fields'          =>  'dropdown.ID, dropdown.name, nav.name AS nav_name',
    'field_to_filter' =>  'dropdown.ID',
    'from'            =>  'dropdown Left Join nav On dropdown.nav_ID = nav.ID',
    'type'            =>  'text',
    'column'          =>  2
)
*/
