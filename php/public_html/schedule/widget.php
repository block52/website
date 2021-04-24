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
header('Access-Control-Allow-Origin: *');
include_once('caledonian.php');
error_reporting(E_ALL);
ini_set('display_errors',1);
$wk = ((!isset($_GET['wk']) || empty($_GET['wk'])) ? die('Invalid Widget Key!'):trim($_GET['wk']));

# Load Widget
$widget = $db->where('widget_key=?',array($wk))->getOne('widgets');
if($db->count==0){die('Widget Not Found!');}

# Widget Settings
$wSets = json_decode($widget['widget_settings'],true);

if(!isAjax()){
# Selected Plugins
if(in_array('jquery',$wSets['plugins'])){
	echo('
<!-- JQuery -->
<script src="'.cal_set_app_url.'valve/Scripts/jquery-1.11.3.min.js"></script>');
}

if(in_array('bootstrap',$wSets['plugins'])){
	echo('
<!-- Bootstrap -->
<link rel="stylesheet" href="'.cal_set_app_url.'valve/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="'.cal_set_app_url.'valve/bootstrap/css/flatly_bootstrap.min.css">
<script src="'.cal_set_app_url.'valve/bootstrap/js/bootstrap.min.js"></script>');
}

if(in_array('datepicker',$wSets['plugins'])){
	echo('
<!-- jQueryUI -->
<link href="'.cal_set_app_url.'valve/css/jquery-ui.min.css" rel="stylesheet">
<link href="'.cal_set_app_url.'valve/css/jquery-ui.theme.min.css" rel="stylesheet">
<script src="'.cal_set_app_url.'valve/Scripts/jquery-ui.min.js"></script>
<script src="'.cal_set_app_url.'valve/Scripts/dp_lang/'. DEFAULT_LANG .'.js"></script>');
}
}

# Common Plugins
echo('
<!-- Calendario -->
<link rel="stylesheet" type="text/css" href="'.cal_set_app_url.'valve/calendario/calendar.css" />
<link rel="stylesheet" type="text/css" href="'.cal_set_app_url.'valve/calendario/custom_2.css" />
<script type="text/javascript" src="'.cal_set_app_url.'valve/calendario/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="'.cal_set_app_url.'valve/calendario/jquery.calendario.js"></script>
<!-- Fancybox -->
<link href="'.cal_set_app_url.'valve/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<!-- iCheck -->
<link href="'.cal_set_app_url.'valve/icheck/skins/flat/red.css" rel="stylesheet">
<!-- ScrollBar -->
<link href="'.cal_set_app_url.'valve/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
<script src="'.cal_set_app_url.'valve/Scripts/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Caledonian -->
<link rel="stylesheet" href="'.cal_set_app_url.'valve/css/cal_wid.css">
<!-- Fancybox -->
<script src="'.cal_set_app_url.'valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="'.cal_set_app_url.'valve/icheck/icheck.min.js"></script>
<!-- Caledonian -->
<script src="'.cal_set_app_url.'valve/Scripts/caledonian.js"></script>
');

# Call Widget
if($widget['widget_type']=='full_calendar'){ # FULL CALENDAR
	# Widget specific Styles
	echo('
	<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/full_calendar.css">
	<div id="sdr-calendar" style="min-height:500px;"></div>
	');
	$cal = new caledonian();
	$cal->widgetOn = true;
	$cal->widgetFetchData = $widget['widget_data'];
	$cal->widgetUser = $widget['data_user'];
	echo($cal->getCalendar());
}

if($widget['widget_type']=='mini_calendar'){ # MINI CALENDAR
	# Widget specific Styles
	echo('
	<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/mini_calendar.css">
	<div id="sdr-calendar"></div>
	');
	$cal = new caledonian();
	$cal->widgetOn = true;
	$cal->widgetFetchData = $widget['widget_data'];
	$cal->widgetUser = $widget['data_user'];
	echo($cal->getCalendar());
}

if($widget['widget_type']=='upcoming_list'){ # UPCOMING LIST
	# Widget specific Styles
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo('<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/upcoming_list.css">');
	}
	$upcList = new caledonian(); 
	$upcList->widgetOn = true;
	$upcList->widgetFetchData = $widget['widget_data'];
	$upcList->widgetUser = $widget['data_user'];
	$upcList->widgetDataCount = $widget['max_data'];
	$upcList = $upcList->upcoming(true); # Show 1 hour expiration, default true
	if($upcList['error']){echo(errMod(calglb_record_not_found,'danger'));}else{
		# List Upcoming Events
		$printData = '';
		$printData .= '
				<ul class="timeline">';
					foreach($upcList['data'] as $list){
		$printData .= '
					<li>
						<i class="'. $list['note_icon'] .'" style="background:'. $list['note_color'] .'"></i>
						<div class="timeline-item">
							<h3 class="timeline-header">
								<a href="javascript:;" data-fancybox-href="'. getSEO($list['note_id'],$list['title']) .'" data-fancybox-type="iframe" '. ((date('Y-m-d H:i',strtotime($list['note_date'])) < demoDate('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .'>'. showIn($list['title'],'page') .'</a>
								<span class="time-label"><i class="fa fa-clock-o"></i> '. date('d/m/Y H:i A',strtotime($list['note_date'])) .'</span>
							</h3>
						</div>
					</li>';
					}
		$printData .= '		</ul>';
		$printData .= '<script>$(".fancybox").fancybox();</script>';
		echo($printData);
	}
}

if($widget['widget_type']=='today_list'){ # TODAYS LIST
	# Widget specific Styles
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo('<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/today_list.css">');
	}
	$upcList = new caledonian(); 
	$upcList->widgetOn = true;
	$upcList->widgetFetchData = $widget['widget_data'];
	$upcList->widgetUser = $widget['data_user'];
	$upcList->widgetDataCount = $widget['max_data'];
	$upcList = $upcList->todays(true); # Show 1 hour expiration, default true
	if($upcList['error']){echo(errMod(calglb_record_not_found,'danger'));}else{
		# List Upcoming Events
		$printData = '';
		$printData .= '
				<ul class="timeline">';
					foreach($upcList['data'] as $list){
		$printData .= '
					<li>
						<i class="'. $list['note_icon'] .'" style="background:'. $list['note_color'] .'"></i>
						<div class="timeline-item">
							<h3 class="timeline-header">
								<a href="javascript:;" data-fancybox-href="'. getSEO($list['note_id'],$list['title']) .'" data-fancybox-type="iframe" '. ((date('Y-m-d H:i',strtotime($list['note_date'])) < demoDate('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .'>'. showIn($list['title'],'page') .'</a>
								<span class="time-label"><i class="fa fa-clock-o"></i> '. date('d/m/Y H:i A',strtotime($list['note_date'])) .'</span>
							</h3>
						</div>
					</li>';
					}
		$printData .= '		</ul>';
		$printData .= '<script>$(".fancybox").fancybox();</script>';
		echo($printData);
	}
}

if($widget['widget_type']=='navbar_notices'){ # NAVBAR
	# Widget specific Styles
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo('<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/navbar_notices.css">');
	}
	echo('<link rel="stylesheet" href="'.cal_set_app_url.'valve/css/animate.min.css">');
	//if(array_key_exists('sound',$wSets) && $wSets['sound']==true){echo('<script src="'.cal_set_app_url.'valve/widgets/scripts/buzz.min.js"></script>');}
	$upcList = new caledonian(); 
	$upcList->widgetOn = true;
	$upcList->widgetFetchData = $widget['widget_data'];
	$upcList->widgetUser = $widget['data_user'];
	$upcList->widgetDataCount = $widget['max_data'];
	$upcList = $upcList->navbar(true); # Show 1 hour expiration, default true
	if($upcList['error']){
		echo('<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'. showIn($widget['widget_name'],'page') .' <span class="caret"></span></a>');
		# Enable Add Task Button
/* 		echo'<ul class="wd-timeline dropdown-menu">
			<li><a href="'. cal_set_app_url .'sdr.calendar.php?pos=add" class="fancybox" data-fancybox-type="iframe"><i class="fa fa-calendar"></i> '. calglb_new_task .'</a></li>
		</ul>'); */
	}else{
		# List Upcoming Events
		$printData = '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'. showIn($widget['widget_name'],'page') .' <span class="caret"></span></a>';
		$printData .= '
				<ul class="wd-timeline dropdown-menu">';
					foreach($upcList['data'] as $list){
		$printData .= '
					<li>
						<i class="'. $list['note_icon'] .'" style="background:'. $list['note_color'] .'"></i>
						<div class="timeline-item">
							<h3 class="timeline-header">
								<a href="javascript:;" data-fancybox-href="'. getSEO($list['note_id'],$list['title']) .'" data-fancybox-type="iframe" '. ((date('Y-m-d H:i',strtotime($list['note_date'])) < date('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .'>'. showIn($list['title'],'page') .'</a>
								<span class="time-label"><i class="fa fa-clock-o"></i> '. date('d/m/Y H:i A',strtotime($list['note_date'])) .'</span>
							</h3>
						</div>
					</li>';
					}
		$printData .= '		</ul>';
		$printData .= '<script>
							$(".dropdown-toggle").dropdown();
							$(".fancybox").fancybox();';
		# Addiontinal
		if(array_key_exists('sound',$wSets) && $wSets['sound']==true){
			$printData .= '
								var selAudio = $("#event_sound_file option:selected").val();
								var soundFile = "'. $wSets['soundFile'] .'";
								var mySound = new buzz.sound( soundFile, {
									//formats: ["mp3"]
								});
								mySound.play();
			';
		}
		if(array_key_exists('refreshTime',$wSets) && intval($wSets['refreshTime'])!=0){
			# Refresh Data
			$printData .= '
			function refreshWidget(){
				$(".caledonian").html("");
				$.ajax({
					url : "'.cal_set_app_url.'widget.php?wk='. $widget['widget_key'] .'",
					type: "GET",
					contentType: "application/x-www-form-urlencoded",
					success: function(data, textStatus, jqXHR)
					{
						$(".caledonian").html(data);
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$(".caledonian").html("");
						clearTimeout(stid);
					},
					complete: function(){
						$(".caledonian").addClass("animated flash");
					}
				});
			} $(window).load(function(){refreshWidget();});var stid = setTimeout(refreshWidget, '. $wSets['refreshTime']*1000 .');';
		}
		$printData .= '
					   </script>';
		echo($printData);
	}
}

if($widget['widget_type']=='popup_master'){ # POP-UP MASTER

	# Check Dates
	if(array_key_exists('time_range',$wSets)){
		
		$start_date = ((array_key_exists('start',$wSets['time_range'])) ? $wSets['time_range']['start']:date('Y-m-d'));
		$end_date = ((array_key_exists('end',$wSets['time_range'])) ? $wSets['time_range']['end']:date('Y-m-d'));
		
		# re-formatted
		$start_date = DateTime::createFromFormat("Y-m-d", $start_date)->format("Ymd");
		$end_date = DateTime::createFromFormat("Y-m-d", $end_date)->format("Ymd");
		
		# Check Date Avability
		if(date('Ymd') >= $start_date && date('Ymd') <= $end_date){
			$upcList = new caledonian(); 
			$upcList->widgetOn = true;
			$upcList->widgetFetchData = $widget['widget_data'];
			$upcList->widgetUser = $widget['data_user'];
			$upcList->widgetDataCount = $widget['max_data'];
			$upcList = $upcList->upcoming(true); # Show 1 hour expiration, default true
			if($upcList['error']){echo(errMod(calglb_record_not_found,'danger'));}else{
				# List Upcoming Events Between Start / End
				$printData = '';
				$printData .= '
						<ul class="timeline popupdata">';
							foreach($upcList['data'] as $list){
				$printData .= '
							<li>
								<i class="'. $list['note_icon'] .'" style="background:'. $list['note_color'] .'"></i>
								<div class="timeline-item">
									<h3 class="timeline-header">
										<a href="javascript:;" data-fancybox-href="'. getSEO($list['note_id'],$list['title']) .'" data-fancybox-type="iframe" '. ((date('Y-m-d H:i',strtotime($list['note_date'])) < demoDate('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .'>'. showIn($list['title'],'page') .'</a>
										<span class="time-label"><i class="fa fa-clock-o"></i> '. date('d/m/Y H:i A',strtotime($list['note_date'])) .'</span>
									</h3>
								</div>
							</li>';
							}
				$printData .= '		</ul>';
				$printData .= '<script>
									// Load Modal
									
									$(document).ready(function(){
										$(".fancybox").fancybox();
										parent.$.fancybox({
											type:"iframe",
											content:"<ul class=\"timeline popupdata\">"+ $(".popupdata").html() +"</ul>"
										});
									});									
							   </script>';
				
				echo($printData);
			}
		}
		
	}else{
		die('Widget Error!');
	}

}

if($widget['widget_type']=='event_lister'){ # EVENT LISTER
	# Widget specific Styles
	if(!isAjax()) {
		echo('<link rel="stylesheet" href="'.cal_set_app_url.'valve/widgets/css/event_list.css">');
	}
	$upcList = new caledonian(); 
	$upcList->widgetOn = true;
	$upcList->widgetFetchData = $widget['widget_data'];
	$upcList->widgetUser = $widget['data_user'];
	$upcList->widgetDataCount = $widget['max_data'];
	$upcList->widgetKey = $widget['widget_key'];
	$upcList->widgetDataPg = ((!isset($_GET['pgGo'])) ? 1:intval($_GET['pgGo']));
	$upcList = $upcList->listEvent(true); # Show 1 hour expiration, default true
	if($upcList['error']){echo(errMod(calglb_record_not_found,'danger'));}else{
		# List
		$printData = '';
		$printData .= '
				<ul class="timeline">';
					foreach($upcList['data'] as $list){
		$printData .= '
					<li>
						<i class="'. $list['note_icon'] .'" style="background:'. $list['note_color'] .'"></i>
						<div class="timeline-item">
							<h3 class="timeline-header">
								<a href="javascript:;" data-fancybox-href="'. getSEO($list['note_id'],$list['title']) .'" data-fancybox-type="iframe" '. ((date('Y-m-d H:i',strtotime($list['note_date'])) < demoDate('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .'>'. showIn($list['title'],'page') .'</a>
								<span class="time-label"><i class="fa fa-clock-o"></i> '. date('d/m/Y H:i A',strtotime($list['note_date'])) .'</span>
							</h3>
						</div>
					</li>';
					}
		$printData .= '		</ul>';
		$printData .= '<!-- PAGINATION -->';
		$printData .= $upcList['pages'];
		$printData .= '<!-- PAGINATION -->';
		$printData .= '<script>
							$(document).ready(function(){
								$.(".fancybox").fancybox();
							});
					   </script>';
		echo($printData);
	}
}
?>