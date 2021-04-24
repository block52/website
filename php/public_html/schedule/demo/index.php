<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 18.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once('../caledonian.php');
$master_conn = true;

if(!isset($_GET['p']) || empty($_GET['p'])){
	$page_main = 'full_calendar';
	$page_sub = '';
	$p = '';
}else{
	$p = $_GET['p'];
	$split_qry = explode('/',$p);
	$page_main = $split_qry[0];
	if(array_key_exists(1,$split_qry)){$page_sub = $split_qry[1];}else{$page_sub = '';}
	if(array_key_exists(2,$split_qry)){$page_sub2 = $split_qry[2];}else{$page_sub2 = '';}
	if(array_key_exists(3,$split_qry)){$page_sub3 = $split_qry[3];}else{$page_sub3 = '';}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once('inc/meta.php');?>
<style>
html,body{
margin:0; padding:0;
background-color:#0081D8 !important;
background-image:url('/valve/images/bg.jpg') !important;
background-repeat:no-repeat !important;
background-attachment:fixed !important;
font-family:'Open Sans'
}
</style>
</head>
<body>
<!-- page content -->
<div class="container">
	<h1 class="main-head">Caledonian<sup>PRO</sup></h1>
	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="?p=full_calendar">Full</a></li>
		<li class="wid2"><a href="?p=mini_calendar">Mini</a></li>
		<li class="wid3"><a href="?p=upcoming_list">Upcoming Events</a></li>
		<li class="wid4"><a href="?p=todays_list">Today's Events</a></li>
		<li class="wid5"><a href="?p=navbar_notices">Navbar Notices</a></li>
		<li class="wid6"><a href="?p=popup_master">Pop-up Master</a></li>
		<li class="wid7"><a href="?p=event_lister">Event Lister</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<?php 
		if($page_main=='full_calendar'){include_once('widgets/full_calendar.php');}
		else if($page_main=='mini_calendar'){include_once('widgets/mini_calendar.php');}
		else if($page_main=='upcoming_list'){include_once('widgets/upcoming_events.php');}
		else if($page_main=='todays_list'){include_once('widgets/today_events.php');}
		else if($page_main=='navbar_notices'){include_once('widgets/navbar_notices.php');}
		else if($page_main=='popup_master'){include_once('widgets/popup.php');}
		else if($page_main=='event_lister'){include_once('widgets/event_lister.php');}
	?>
	
</div>
<!-- page end -->
<?php include_once('inc/footer.php');?>
</body>
</html>