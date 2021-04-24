<?php
use phpformbuilder\Form;
use phpformbuilder\database\Mysql;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

if (!isset($_POST['category']) || !preg_match('`[a-zA-Z ]+`', $_POST['category'])) {
    echo 'wrong query';
    exit;
}

require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/db-connect.php';
require_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/database/Mysql.php';

$products = array();
$category_sqlvalue = Mysql::sqlValue($_POST['category'], Mysql::SQLVALUE_TEXT);

$qry = 'SELECT
    products.productName,
    products.productCode
FROM
    products
WHERE
    products.productLine = ' . $category_sqlvalue . '
ORDER BY
    products.productName';
$db = new Mysql();
$db->query($qry);
$db_count = $db->rowCount();
if (!empty($db_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $products_name[] = $row->productName;
        $products_code[] = $row->productCode;
    }
}

$form = new Form('ajax-products', 'vertical');
// $form->setMode('development');

// materialize plugin
$form->addPlugin('materialize', '#ajax-products');

$options = array(
    'elementsWrapper' => ''
);
$form->setOptions($options);

for ($i=0; $i < $db_count; $i++) {
    $selected = '';
    if (isset($_SESSION['customer-support-form']['product']) && $_SESSION['customer-support-form']['product'] == $products_code[$i]) {
        $selected = 'selected';
    }
    $form->addOption('product', $products_code[$i], $products_name[$i], '', $selected);
}
$form->addSelect('product', '', 'required');

echo $form->html;
