<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 30.06.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'caledonian.php');
include_once('inc/inc_auth.php');
$master_conn = true;

if(!isset($_GET['p']) || empty($_GET['p'])){
	$page_main = 'dashboard';
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
        <li class="active"><a href="?p=dashboard"><i class="fa fa-dashboard"></i> <?php echo(calglb_dashboard);?></a></li>
        <li><a href="<?php echo(cal_set_app_url);?>sdr.calendar.php?pos=add" class="fancybox" data-fancybox-type="iframe"><i class="fa fa-plus"></i> <?php echo(calglb_new_event);?></a></li>
		<li class="navb-events"><a href="?p=events"><i class="fa fa-calendar"></i> <?php echo(calglb_events);?></a></li>
        <li class="dropdown navb-event-mng">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-random"></i> <?php echo(calglb_event_management);?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="sHide"><a href="?p=export"><i class="fa fa-upload"></i> <?php echo(calglb_export);?></a></li>
			<li><a href="?p=import"><i class="fa fa-download"></i> <?php echo(calglb_import);?></a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="flag flag-<?php echo($cnsLang);?>"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<?php foreach($SLNG_LIST as $k=>$v){echo('<li><a href="pg.lang.php?p=&amp;l='. $k .'"><i class="flag flag-'. $k .'"></i> '. $v['sname'] .'</a></li>');}?>
          </ul>
        </li>
        <li class="dropdown navAdmn">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> <span class="hidden-sm"><?php echo(showIn(CAL_AUTH_NAME,'page'));?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<?php if(CAL_AUTH_MODE==1){?>
			<li><a href="?p=widgets"><i class="fa fa-puzzle-piece"></i> Widgets</a></li>
            <li><a href="?p=settings"><i class="fa fa-gears"></i> <?php echo(calglb_settings);?></a></li>
			<li><a href="?p=users"><i class="fa fa-users"></i> <?php echo(calglb_users);?></a></li>
			<?php }else{?>
			<li><a href="?p=users/profile"><i class="fa fa-user"></i> <?php echo(calglb_profile);?></a></li>
			<?php }?>
			<li role="separator" class="divider"></li>
            <li><a href="login.php?p=logout"><i class="fa fa-power-off"></i> <?php echo(calglb_logout);?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
	<div class="panel">
		<div class="panel-body">
			<?php
				if($page_main=='users'){include_once('manage/pg.users.php');}
				else if($page_main=='events'){include_once('manage/pg.events.php');}
				else if($page_main=='import'){include_once('manage/pg.import.php');}
				else if($page_main=='settings'){include_once('manage/pg.settings.php');}
				else if($page_main=='widgets'){include_once('manage/pg.widgets.php');}
				else if($page_main=='api'){include_once('manage/pg.api.php');}
				else{include_once('manage/pg.dashboard.php');}
			?>
		</div>
	</div>
	
<div id="powered">
	<?php echo(CAL_FULL_NAME.' v'.CAL_VERSION);?>
	<span class="pull-right"><a href="http://www.artlantis.net/" target="_blank">Artlantis Design Studio</a> &copy; 2015</span>
</div>
</div>

<!-- page content -->
<!-- Bootstrap -->
<script src="../valve/bootstrap/js/bootstrap.min.js"></script>
<!-- Fancybox -->
<script src="../valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="../valve/icheck/icheck.min.js"></script>
<!-- Caledonian -->
<script src="../valve/Scripts/caledonian.js"></script>

</body>
</html>