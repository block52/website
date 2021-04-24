<?php
use crud\ElementsFilters;
use phpformbuilder\database\Mysql;

include_once '../class/generator/Generator.php';

@session_start();
if (isset($_SESSION['generator'])) {
    include_once '../../conf/conf.php';
    include_once ADMIN_DIR . 'secure/class/secure/Secure.php';

    $generator     = $_SESSION['generator'];
    $index         = $_POST['index'];
    $filter_parsed = $generator->parseQuery($_POST['from']);
    $from_table    = $filter_parsed['from_table'];
    $join_tables   = $filter_parsed['join_tables'];
    $join_queries  = $filter_parsed['join_queries'];
    $filters = array(
        'filter_mode'     => $_POST['filter_mode'],
        'filter_A'        => $_POST['filter_A'],
        'select_label'    => $_POST['select_label'],
        'select_name'     => $index,
        'option_text'     => $_POST['option_text'],
        'fields'          => $_POST['fields'],
        'field_to_filter' => $_POST['field_to_filter'],
        'from'            => $_POST['from'],
        'from_table'      => $from_table,
        'join_tables'     => $join_tables,
        'join_queries'    => $join_queries,
        'type'            => $_POST['type'],
        'column'          => 1
    );
    $filters_array = array($filters);
    $filters   = new ElementsFilters('test', $filters_array);
    $filters->register('test');
    $qry = $filters->showQuery();

    $filters_form = $filters->returnForm('#', false);

    $out = '';
    $out .= '<h4>' . QUERY . ' : </h4>' . "\n";
    $out .= '<pre><code>' . $qry . '</code></pre>' . "\n";
    $out .= '<hr>' . "\n";
    $out .= '<h4>' . GENERATED_FILTER . ' : </h4>' . "\n";
    $out .= $filters_form;

    echo $out;
}
