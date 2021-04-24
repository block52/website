<?php

/* =============================================
Create a database named 'test'
and configure phpformbuilder/database/db-connect.php
to run these tests.
============================================= */

// Include the Ultimate Mysql class and create the object
use phpformbuilder\database\Mysql;

include "../../phpformbuilder/database/db-connect.php";
include "../../phpformbuilder/database/mysql.php";

$db = new Mysql();

// Connect to the database
if (! $db->Open()) $db->Kill();

// --------------------------------------------------------------------------
// Want to know if you are connected? Use IsConnected()
echo "Are we connected? ";
var_dump($db->IsConnected());
echo "\n<br />\n";

$tables = $db->GetTables();
if (!in_array('test', $tables)) {
    $qry = 'CREATE TABLE `test` (
	  `TestID` int(10)     NOT NULL auto_increment,
	  `Color`  varchar(15) default NULL,
	  `Age`    int(10)     default NULL,
	  PRIMARY KEY  (`TestID`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
    $db = new Mysql();
    $db->query($qry);
}

// --------------------------------------------------------------------------
// Now we can generate SQL statements from arrays!

// Let's create an array for the examples
// $arrayVariable["column name"] = formatted SQL value
$values["Name"] = Mysql::SQLValue("Violet");
$values["Age"]  = Mysql::SQLValue(777, Mysql::SQLVALUE_NUMBER);

// Echo out some SQL statements
echo "<pre>" . "\n";
echo Mysql::BuildSQLDelete("test", $values) . "\n<br />\n";
echo Mysql::BuildSQLInsert("test", $values) . "\n<br />\n";
echo Mysql::BuildSQLSelect("test", $values) . "\n<br />\n";
echo Mysql::BuildSQLUpdate("test", $values, $values) . "\n<br />\n";
echo Mysql::BuildSQLWhereClause($values) . "\n<br />\n";
echo "</pre>" . "\n";

// Or create more advanced SQL SELECT statements
$columns = array("Name", "Age");
$sort = "Name";
$limit = 10;
echo Mysql::BuildSQLSelect("test", $values, $columns, $sort, true, $limit);
echo "\n<br />\n";

$columns = array("Color Name" => "Name", "Total Age" => "Age");
$sort = array("Age", "Name");
$limit = "10, 20";
echo Mysql::BuildSQLSelect("test", $values, $columns, $sort, false, $limit);
echo "\n<br />\n";

// The following methods take the same parameters and automatically execute!

// $db->DeleteRows("test", $values);
// $db->InsertRow("test", $values);
// $db->SelectRows("test", $values, $columns, $sort, true, $limit);
// $db->UpdateRows("test", $values1, $values2);

// You can also select an entire table
// $db->SelectTable("test");

// Or truncate and clear out an entire table
// $db->TruncateTable("test");

// --------------------------------------------------------------------------

// Now you can throw exceptions and use try/catch blocks
$db->ThrowExceptions = true;

try {
    // This next line will always cause an error
    $db->Query("BAD SQL QUERY TO CREATE AN ERROR");
} catch (Exception $e) {
    // If an error occurs, do this (great for transaction processing!)
    echo "We caught the error: " . $e->getMessage();
}

// Or let's show a stack trace if we do not use a try/catch
// This shows the stack and tells us exactly where it failed
$db->Query("BAD SQL QUERY TO CREATE AN ERROR");
