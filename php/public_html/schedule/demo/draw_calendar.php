<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 21.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once('../caledonian.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- JQuery -->
<script src="../valve/Scripts/jquery-1.11.3.min.js"></script>
<!-- Bootstrap -->
<link rel="stylesheet" href="../valve/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../valve/bootstrap/css/flatly_bootstrap.min.css">
<!-- Calendario -->
<link rel="stylesheet" type="text/css" href="../valve/calendario/calendar.css" />
<link rel="stylesheet" type="text/css" href="../valve/calendario/custom_2.css" />
<script type="text/javascript" src="../valve/calendario/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="../valve/calendario/jquery.calendario.js"></script>
<!-- Fancybox -->
<link href="../valve/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<!-- Caledonian -->
<link rel="stylesheet" href="../valve/css/cal.css">

</head>
<body>
<!-- page content -->
<?php

	$calendar = new caledonian();
	$calendar->calDate = '2015-05';
	echo('<div id="sdr-calendar"></div>');
	echo($calendar->getCalendar());

?>
<!-- page end -->

<!-- Bootstrap -->
<script src="../valve/bootstrap/js/bootstrap.min.js"></script>
<!-- Fancybox -->
<script src="../valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<!-- Caledonian -->
<script src="../valve/Scripts/caledonian.js"></script>
</body>
</html>