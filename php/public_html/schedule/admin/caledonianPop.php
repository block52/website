<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 06.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'caledonian.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Font Awesome -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!-- Bootstrap -->
<link rel="stylesheet" href="../valve/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../valve/bootstrap/css/flatly_bootstrap.min.css">
<!-- JQuery -->
<script src="../valve/Scripts/jquery-1.11.3.min.js"></script>
<!-- iCheck -->
<link href="../valve/icheck/skins/flat/red.css" rel="stylesheet">
<!-- Caledonian -->
<link rel="stylesheet" href="../valve/css/cal.css"></head>
</head>
<body>
<h3><?php echo($day.' '.$CAL_DATE_VALUES['months'][$month].' '.$year);?></h3><hr>
<!-- page content -->
</body>
</html>