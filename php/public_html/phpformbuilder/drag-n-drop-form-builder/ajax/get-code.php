<?php
use phpformbuilder\Form;
use dragNDropFormGenerator\FormGenerator;
session_start();
include_once '../FormGenerator.php';
include_once '../../phpformbuilder/Form.php';
$json = json_decode($_POST['data']);
/* foreach ($json as $var => $val) {
    ${$var} = $val;
    echo '<h3 class="text-white font-weight-light bg-secondary px-2 py-1">' . $var . '</h3>';
    var_dump(${$var});
} */

$generator = new FormGenerator($_POST['data'], false);
?>

<div class="container">

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link text-body active" id="get-code-form-code-tab" data-toggle="tab" href="#get-code-form-code" role="tab" aria-controls="get-code-form-code" aria-selected="true">Form code</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-body" id="get-code-full-page-tab" data-toggle="tab" href="#get-code-full-page" role="tab" aria-controls="get-code-full-page" aria-selected="false">Full page</a>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="get-code-form-code" role="tabpanel" aria-labelledby="get-code-form-code-tab"><?php $generator->outputCode(); ?></div>
        <div class="tab-pane" id="get-code-full-page" role="tabpanel" aria-labelledby="get-code-full-page-tab"><?php $generator->outputPageCode(); ?></div>
    </div>
</div>
<!-- JavaScript -->
<script src="assets/javascripts/get-code.js"></script>
