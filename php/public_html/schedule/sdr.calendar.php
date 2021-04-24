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
include_once('caledonian.php');
$day = ((!isset($_GET['d']) || empty($_GET['d'])) ? demoDate('d'):trim($_GET['d']));
$month = ((!isset($_GET['m']) || empty($_GET['m'])) ? demoDate('m'):trim($_GET['m']));
$year = ((!isset($_GET['y']) || empty($_GET['y'])) ? demoDate('Y'):trim($_GET['y']));
$selDate = date('d/m/Y',strtotime($year.'-'.$month.'-'.$day));
$selDate2 = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
$qry = '&amp;m='. $month .'&amp;d='. $day .'&amp;y='.$year;
$pos = ((!isset($_GET['pos']) || empty($_GET['pos'])) ? '':trim($_GET['pos']));
$ID = ((!isset($_GET['ID']) || empty($_GET['ID'])) ? 0:(int)$_GET['ID']);
$w = ((!isset($_GET['w']) || empty($_GET['w'])) ? 0:1);
$u = ((!isset($_GET['u']) || empty($_GET['u'])) ? '-':$_GET['u']);
$fd = ((!isset($_GET['fd']) || empty($_GET['fd'])) ? 1:intval($_GET['fd']));
$errText = '';

/* Demo Check */
if(!isDemo('addEvent,editEvent')){$errText = errMod(calglb_demo_mode_active,'danger');}

# Load Auth Data If Possible
include_once('lib/cal.auth.php');

# Add Event
if(isset($_POST['addEvent'])){
		
		if(!isLogged()){die(errMod('<i class="fa fa-warning"></i> '. calglb_you_are_not_authorized_to_access_this_page .'!','danger'));}	
		$data = array();
		$errText = '';
		if(!isset($_POST['title']) || $_POST['title']==''){$errText.='* '. calglb_please_enter_a_title .'<br>';}else{
			$data['title'] = $_POST['title'];
		}
		if(!isset($_POST['evicon']) || $_POST['evicon']==''){$data['note_icon'] = 'fa fa-bell';}else{$data['note_icon'] = $_POST['evicon'];}
		if(!isset($_POST['evcolor']) || $_POST['evcolor']==''){$data['note_color'] = 'deepskyblue';}else{$data['note_color'] = $_POST['evcolor'];}
		if(!isset($_POST['details']) || $_POST['details']==''){$errText.='* '. calglb_please_enter_a_detail .'<br>';}else{
			$data['mynotes'] = $_POST['details'];
		}
		if(!isset($_POST['timeHour']) || $_POST['timeHour']==''){$_POST['timeHour']='00';}
		if(!isset($_POST['timeMin']) || $_POST['timeMin']==''){$_POST['timeMin']='00';}
		if(isset($_POST['isPrivate']) && $_POST['isPrivate']=='YES'){$data['data_type'] = 1;}else{$data['data_type'] = 0;}
		
		if($errText==''){
			
			# Event Date
			if(!isset($_POST['eventDate']) || $_POST['eventDate']==''){$_POST['eventDate']=$year.'-'. $month .'-'.$day;}else{$_POST['eventDate'] = DateTime::createFromFormat("d/m/Y", $_POST['eventDate'])->format("Y-m-d");}
			$eventDate = DateTime::createFromFormat("Y-m-d H:i:s", $_POST['eventDate'].' '. $_POST['timeHour'] .':'. $_POST['timeMin'] .':00')->format("Y-m-d H:i:s");
			
			if(CAL_AUTH_MODE==1){
				$data['user_id'] = (int)$_POST['eventUser'];
			}else{
				$data['user_id'] = CAL_AUTH_ID;
			}
			
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$data['add_date'] = date('Y-m-d H:i:s');
			$data['note_date'] = $eventDate;
			
			$db->insert('panel_notes',$data);
			
			# Duplicate Event
			if(isset($_POST['eventCopies'])){
				foreach($_POST['eventCopies'] as $k=>$v){
					$v = str_replace('/','-',$v);
					$eventDate = date('Y-m-d H:i:s',strtotime($v.' '. $_POST['timeHour'] .':'. $_POST['timeMin'] .':00'));
					$data['add_date'] = date('Y-m-d H:i:s');
					$data['note_date'] = $eventDate;
					$db->insert('panel_notes',$data);
				}
			}
						
			$errText = errMod(calglb_recorded_successfully,'success');
			$errText.='<script>parent.getAjax("#sdr-calendar","'. cal_set_app_url .'sdr.calendar.php?pos=cal&m='. $month .'&d='. $day .'&y='. $year .'",\'<i class="fa fa-cog fa-spin"></i>\');</script>';
			unset($_POST);
			
		}else{
			$errText = errMod($errText,'danger');
		}
				
}

# Edit Event
if(isset($_POST['editEvent'])){
	
$db->where('note_id=?',array($ID));
if(CAL_VIEW_MODE){
	$db->where('user_id',CAL_AUTH_ID);
}
$getEvent = $db->getOne('panel_notes');
if($db->count==0){
	echo(errMod(cal_record_not_found,'danger'));
}else{
		
		if(!isLogged()){die(errMod('<i class="fa fa-warning"></i> '. calglb_you_are_not_authorized_to_access_this_page .'!','danger'));}	
		$data = array();
		$errText = '';
		
		/* Remove Event */
		if(isset($_POST['del']) && $_POST['del']=='YES'){
			$db->where('note_id=?',array($getEvent['note_id']))->delete('panel_notes');
			die('
				<script>
					parent.getAjax("#sdr-calendar","'. cal_set_app_url .'sdr.calendar.php?pos=cal&m='. $month .'&d='. $day .'&y='. $year .'",\'<i class="fa fa-cog fa-spin"></i>\');
					parent.$.fancybox.close();
				</script>
				');
		}
		
		if(!isset($_POST['title']) || $_POST['title']==''){$errText.='* '. calglb_please_enter_a_title .'<br>';}else{
			$data['title'] = $_POST['title'];
		}
		if(!isset($_POST['evicon']) || $_POST['evicon']==''){$data['note_icon'] = 'fa fa-bell';}else{$data['note_icon'] = $_POST['evicon'];}
		if(!isset($_POST['evcolor']) || $_POST['evcolor']==''){$data['note_color'] = 'deepskyblue';}else{$data['note_color'] = $_POST['evcolor'];}
		if(!isset($_POST['details']) || $_POST['details']==''){$errText.='* '. calglb_please_enter_a_detail .'<br>';}else{
			$data['mynotes'] = $_POST['details'];
		}
		if(!isset($_POST['timeHour']) || $_POST['timeHour']==''){$_POST['timeHour']='00';}
		if(!isset($_POST['timeMin']) || $_POST['timeMin']==''){$_POST['timeMin']='00';}
		if(isset($_POST['isPrivate']) && $_POST['isPrivate']=='YES'){$data['data_type'] = 1;}else{$data['data_type'] = 0;}
		
		if($errText==''){
			
			# Event Date
			if(!isset($_POST['eventDate']) || $_POST['eventDate']==''){$_POST['eventDate']=$year.'-'. $month .'-'.$day;}else{$_POST['eventDate'] = DateTime::createFromFormat("d/m/Y", $_POST['eventDate'])->format("Y-m-d");}
			$eventDate = DateTime::createFromFormat("Y-m-d H:i:s", $_POST['eventDate'].' '. $_POST['timeHour'] .':'. $_POST['timeMin'] .':00')->format("Y-m-d H:i:s");
			
			if(CAL_AUTH_MODE==1){
				$data['user_id'] = (int)$_POST['eventUser'];
			}else{
				$data['user_id'] = CAL_AUTH_ID;
			}
			
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$data['edit_date'] = date('Y-m-d H:i:s');
			$data['note_date'] = $eventDate;
			
			$db->where('note_id=?',array($getEvent['note_id']));
			$db->update('panel_notes',$data);
						
			$errText = errMod(calglb_recorded_successfully,'success');
			
		}else{
			$errText = errMod($errText,'danger');
		}
}
				
}


# Draw Calendar
if($pos=='cal'){
	$caledonian = new caledonian();
	$caledonian->month = $month;
	$caledonian->year = $year;
	if($w){
		$caledonian->widgetOn = 1;
		$caledonian->widgetFetchData = $fd;
		if($u!='-'){
			$u = getUser($u,3); # Key to ID
			$caledonian->widgetUser = $u;
		}else{
			$caledonian->widgetUser = 0;
		}
	}else{
		$caledonian->isAdmin = ((isLogged()) ? 1:0);
	}
	die($caledonian->drawCal());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo(CAL_FULL_NAME);?></title>
<base href="<?php echo(cal_set_app_url);?>">
<!-- Bootstrap -->
<link rel="stylesheet" href="valve/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="valve/bootstrap/css/flatly_bootstrap.min.css">
<!-- JQuery -->
<script src="valve/Scripts/jquery-1.11.3.min.js"></script>
<!-- jQueryUI -->
<link href="valve/css/jquery-ui.min.css" rel="stylesheet">
<link href="valve/css/jquery-ui.theme.min.css" rel="stylesheet">
<!-- iCheck -->
<link href="valve/icheck/skins/flat/red.css" rel="stylesheet">
<!-- AnimateCSS -->
<link rel="stylesheet" href="valve/css/animate.min.css">
<!-- Caledonian -->
<link rel="stylesheet" href="valve/css/cal_pop.css">
</head>
<body style="background:inherit;">
<div class="container-fluid">
<?php if($pos=='add'){
if(!isLogged()){die(errMod('<i class="fa fa-warning"></i> '. calglb_you_are_not_authorized_to_access_this_page .'!','danger'));}	
?>
<!-- NEW EVENT START -->
<h3 class="datepick_but"><?php echo($day.' '.$CAL_DATE_VALUES['months'][date('n',strtotime($selDate2))].' '.$year);?><span class="pull-right"><input id="datepicker" type="hidden"></span></h3><hr>

<!-- TinyMCE -->
<script>var mceLang = '<?php echo($cnsLang);?>';</script>
<script src="valve/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="valve/tinymce/js/tinymce/tmce_conf.js"></script>
<form name="newEvent" id="newEvent" action="" method="POST">
<?php echo($errText);?>
	<?php if(CAL_AUTH_MODE==1){?>
	<div class="form-group">
		<label for="eventUser"><?php echo(calglb_user);?></label>
		<select name="eventUser" id="eventUser" class="form-control autoWidth input-sm">
			<?php
				$users = $db->where('isActive=1')->orderBy('full_name','ASC')->get('users');
				foreach($users as $user){
					echo('<option value="'. $user['user_id'] .'"'. formSelector(CAL_AUTH_ID,$user['user_id'],0) .'>'. showIn($user['full_name'],'page') .'</option>');
				}
			?>
		</select>
	</div>
	<?php }?>
	<div class="form-group">
		<label for="title"><?php echo(calglb_title);?></label>
		<input type="text" class="form-control input-sm" id="title" name="title" value="<?php echo(((isseter('title')) ? showIn($_POST['title'],'input'):''));?>">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-3">
				<label for="eventDate"><?php echo(calglb_date);?></label>
				<input type="text" class="form-control input-sm dp" id="eventDate" name="eventDate" value="<?php echo(((isseter('eventDate')) ? showIn($_POST['eventDate'],'input'):$selDate));?>">
			</div>
			<div class="col-sm-3">
				<label for="timeHour"><?php echo(calglb_hour);?></label>
				<select name="timeHour" id="timeHour" class="form-control input-sm">
					<?php for($i=0;$i<=23;$i++){
						$stHr = date('H',strtotime($i.':00'));
						echo('<option value="'. $stHr .'"'. ((isseter('timeHour')) ? formSelector($stHr,$_POST['timeHour'],0):'') .'>'. $stHr .'</option>');
					}?>
				</select>
			</div>
			<div class="col-sm-3">
				<label for="timeMin"><?php echo(calglb_minute);?></label>
				<select name="timeMin" id="timeMin" class="form-control input-sm">
					<?php for($i=0;$i<=59;$i++){
						$stHr = date('i',strtotime('00:'.$i));
						echo('<option value="'. $stHr .'"'. ((isseter('timeMin')) ? formSelector($stHr,$_POST['timeMin'],0):'') .'>'. date('i',strtotime('00:'.$i)) .'</option>');
					}?>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="exampleInputEmail1"><?php echo(calglb_icons_colors);?> <a href="javascript:;" class="toggler" data-target-focus="#details" data-target=".icolbox"><span class="glyphicon glyphicon-chevron-down"></span></a></label>
		<div class="row sHide icolbox">
			<div class="col-sm-6 iconColorList">
				<?php foreach($CAL_EVENT_ICONS as $k=>$v){
					echo('<span class="iconBox"><input type="radio" name="evicon" id="evicon'. $k .'" value="fa '. $v .'" class="iCheck"> <label for="evicon'. $k .'"><i class="fa '. $v .'"></i></label></span>');
				}?>
			</div>
			<div class="col-sm-6 iconColorList">
				<input type="hidden" name="evcolor" id="evcolor" value="<?php echo(((isseter('caldate')) ? showIn($_POST['caldate'],'input'):'deepskyblue'));?>">
				<?php foreach($CAL_EVENT_COLORS as $k=>$v){
					echo('<span title="'. $v .'" data-color="'. $v .'" class="colorBox '. $v .'"><i class="fa fa-leaf"></i></span>');
				}?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="details"><?php echo(calglb_details);?></label>
		<textarea name="details" id="details"></textarea>
	</div>
	<div class="form-group">
		<label for="isPrivate"><?php echo(calglb_private);?></label>
		<input type="checkbox" name="isPrivate" id="isPrivate" value="YES" class="iCheck">
	</div>
	<div class="form-group">
		<label for="dupEvent"><?php echo(calglb_duplicate_event);?> <input type="hidden" id="dupSel"></label>
		<div id="eventDups"></div>
		<div id="copyEv" class="sHide"></div>
	</div>
	<div class="form-group">
		<span class="pull-right">
			<button type="button" class="btn btn-danger closeModal"><i class="fa fa-remove"></i> <?php echo(calglb_cancel);?></button>
			<button type="submit" name="addEvent" id="addEvent" class="btn btn-success"><i class="fa fa-save"></i> <?php echo(calglb_save);?></button>
		</span>
	</div>
</form>

<script>
function createDups(){
	$("#eventDups").html('');
	$("#copyEv input").each(function(e){
		$("#eventDups").append('<code>'+ $(this).val() +' <a href="javascript:;" onclick="remCopy(\''+$(this).val()+'\');"><i class="fa fa-remove"></i></a></code>');
	});
}

function remCopy(d){
	$("#copyEv input[value='"+d+"']").remove();
	createDups();
}

$(document).ready(function(){
	
	$("#dupSel").datepicker({
		showOn: "button",
		buttonText: '<i class="fa fa-calendar text-info"></i>',
		dateFormat: "dd/mm/yy",
		onSelect: function(e){
			$("#copyEv").append('<input type="text" name="eventCopies[]" data-date="'+ e +'" value="'+ e +'">');
			createDups();
		}
	});
	
});
</script>

<!-- NEW EVENT END -->
<?php }else if($pos=='edit'){
if(!isLogged()){die(errMod('<i class="fa fa-warning"></i> '. calglb_you_are_not_authorized_to_access_this_page .'!','danger'));}
$db->where('note_id=?',array($ID));
if(CAL_VIEW_MODE){
	$db->where('user_id',CAL_AUTH_ID);
}
$getEvent = $db->getOne('panel_notes');
if($db->count==0){
	echo(errMod(cal_record_not_found,'danger'));
}else{
?>
<!-- EDIT EVENT START -->
<h3><?php echo(showIn($getEvent['title'],'page'));?><span class="pull-right"><i class="<?php echo($getEvent['note_icon']);?> cal_circle" style="background:<?php echo($getEvent['note_color']);?>"></i></span><span class="help-block text-xs"><?php echo(calglb_edit);?></span></h3><hr>

<!-- TinyMCE -->
<script>var mceLang = '<?php echo($cnsLang);?>';</script>
<script src="valve/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="valve/tinymce/js/tinymce/tmce_conf.js"></script>
<form name="upEvent" id="upEvent" action="" method="POST">
<?php echo($errText);?>
	<?php if(CAL_AUTH_MODE==1){?>
	<div class="form-group">
		<label for="eventUser"><?php echo(calglb_user);?></label>
		<select name="eventUser" id="eventUser" class="form-control autoWidth input-sm">
			<?php
				$users = $db->where('isActive=1')->orderBy('full_name','ASC')->get('users');
				foreach($users as $user){
					echo('<option value="'. $user['user_id'] .'"'. formSelector($getEvent['user_id'],$user['user_id'],0) .'>'. showIn($user['full_name'],'page') .'</option>');
				}
			?>
		</select>
	</div>
	<?php }?>
	<div class="form-group">
		<label for="title"><?php echo(calglb_title);?></label>
		<input type="text" class="form-control input-sm" id="title" name="title" value="<?php echo(showIn($getEvent['title'],'input'));?>">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-3">
				<label for="eventDate"><?php echo(calglb_date);?></label>
				<input type="text" class="form-control input-sm dp" id="eventDate" name="eventDate" value="<?php echo(date('d/m/Y',strtotime($getEvent['note_date'])));?>">
			</div>
			<div class="col-sm-3">
				<label for="timeHour"><?php echo(calglb_hour);?></label>
				<select name="timeHour" id="timeHour" class="form-control input-sm">
					<?php for($i=0;$i<=23;$i++){
						$stHr = date('H',strtotime($i.':00'));
						echo('<option value="'. $stHr .'"'. formSelector($stHr,date('H',strtotime($getEvent['note_date'])),0) .'>'. $stHr .'</option>');
					}?>
				</select>
			</div>
			<div class="col-sm-3">
				<label for="timeMin"><?php echo(calglb_minute);?></label>
				<select name="timeMin" id="timeMin" class="form-control input-sm">
					<?php for($i=0;$i<=59;$i++){
						$stHr = date('i',strtotime('00:'.$i));
						echo('<option value="'. $stHr .'"'. formSelector($stHr,date('i',strtotime($getEvent['note_date'])),0) .'>'. date('i',strtotime('00:'.$i)) .'</option>');
					}?>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="exampleInputEmail1"><?php echo(calglb_icons_colors);?> <a href="javascript:;" class="toggler" data-target-focus="#details" data-target=".icolbox"><span class="glyphicon glyphicon-chevron-down"></span></a></label>
		<div class="row sHide icolbox">
			<div class="col-sm-6 iconColorList">
				<?php foreach($CAL_EVENT_ICONS as $k=>$v){
					echo('<span class="iconBox"><input type="radio" name="evicon" id="evicon'. $k .'" value="fa '. $v .'" class="iCheck"'. formSelector($getEvent['note_icon'],'fa '.$v,1) .'> <label for="evicon'. $k .'"><i class="fa '. $v .'"></i></label></span>');
				}?>
			</div>
			<div class="col-sm-6 iconColorList">
				<input type="hidden" name="evcolor" id="evcolor" value="<?php echo($getEvent['note_color']);?>">
				<?php foreach($CAL_EVENT_COLORS as $k=>$v){
					echo('<span title="'. $v .'" data-color="'. $v .'" class="colorBox '. $v .'"><i class="fa fa-leaf"></i></span>');
				}?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="details"><?php echo(calglb_details);?></label>
		<textarea name="details" id="details"><?php echo($getEvent['mynotes']);?></textarea>
	</div>
	<div class="form-group">
		<label for="isPrivate"><?php echo(calglb_private);?></label>
		<input type="checkbox" name="isPrivate" id="isPrivate" value="YES" class="iCheck"<?php echo(formSelector($getEvent['data_type'],1,1));?>>
	</div>
	<div class="form-group">
		<input type="checkbox" name="del" id="del" value="YES" class="iCheck"> <label for="del"><?php echo(calglb_delete);?></label>
	</div>
	<div class="form-group">
		<span class="pull-right">
			<button type="button" class="btn btn-danger closeModal"><i class="fa fa-remove"></i> <?php echo(calglb_cancel);?></button>
			<button type="submit" name="editEvent" id="editEvent" class="btn btn-success"><i class="fa fa-save"></i> <?php echo(calglb_save);?></button>
		</span>
	</div>
</form>

<!-- EDIT EVENT END -->
<?php }}else if($pos=='details'){
$eventData = $db->where('note_id=?',array($ID))->getOne('panel_notes');
?>
<!-- DETAILS EVENT START -->
<?php if($db->count==0){echo(errMod(calglb_record_not_found,'danger'));}else{
$page_url = getSEO($eventData['note_id'],$eventData['title']);
$edit_but = '<a href="'. cal_set_app_url .'sdr.calendar.php?pos=edit&amp;ID='. $eventData['note_id'] .'"><i class="fa fa-edit"></i></a> ';
if(!isLogged()){$edit_but='';}else{
	if(CAL_AUTH_ID!=$eventData['user_id']){
		if(CAL_VIEW_MODE==1){$edit_but='';}
	}
}
?>
<h3><?php echo(showIn($eventData['title'],'page').'<span class="pull-right">'. $edit_but .'<a target="_blank" href="'. $page_url .'"><i class="fa fa-external-link"></i></a></span><span class="help-block text-xs">'. setMydate($eventData['note_date'],8) .'</span>');?></h3><hr>
<div id="eventDetail">
<div class="data-inner"><?php echo($eventData['mynotes']);?></div>
</div>
<hr>
<div class="helper-block">
	<?php if(cal_set_share_buttons){?>
	<!-- Share Buttons -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-559c94151e6542f3" async="async"></script>
		<div class="addthis_sharing_toolbox"></div>
	<!-- Share Buttons -->
	<?php }?>
	<div class="clearfix"></div>
</div>
<div class="helper-block text-muted data-inner">
	<?php if(cal_set_share_buttons){?>
	<p><input type="text" onclick="this.select();" class="form-control input-sm" value="<?php echo($page_url);?>" readonly></p>
	<?php }
	if(cal_set_show_creator){
		echo('<strong>'. calglb_added .':</strong> '. setMyDate($eventData['add_date'],2) .' | <strong>'. calglb_author .':</strong> '. getUser($eventData['user_id'],1) .'');
	}?>
<br><br>
</div>
<script>
	$(document).ready(function(){
		$(document).find('title').html('<?php echo(showIn($eventData['title'],'page'));?>');
	});
</script>
<?php }?>
<!-- DETAILS EVENT END -->
<?php }?>

<!-- page content -->
</div>

<!-- Bootstrap -->
<script src="valve/bootstrap/js/bootstrap.min.js"></script>
<!-- JQueryUI -->
<script src="valve/Scripts/jquery-ui.min.js"></script>
<script src="valve/Scripts/dp_lang/<?php echo($cnsLang);?>.js"></script>
<!-- Fancybox -->
<script src="valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>

<!-- Global -->
<?php if($pos!='details'){?>
<script>
$(document).ready(function(){
	$("#datepicker").datepicker({
		showOn: "button",
		buttonText: '<i class="fa fa-calendar text-info"></i>',
		dateFormat: "yy/m/d"
	});
	
	$(".dp").datepicker({
		dateFormat: "dd/mm/yy"
	});
	
	$("#datepicker").on('change',function(){
		var date = $(this).val();
		var datePars = date.split('/');
		location.href='sdr.calendar.php?pos=add&m='+ datePars[1] +'&d='+ datePars[2] +'&y='+ datePars[0] +'';
	});
    $(".colorBox").mouseenter(function() {
        $(this).addClass("rotate");
    }).mouseleave(function() {
        $(this).removeClass("rotate");
    });
	
	/* Load Colors */
	$(".colorBox").each(function(e){
		var color = $(this).data('color');
		$(this).css({'color':color});
		$(this).click(function(){
			$(".iconBox").css({'background-color':color,'color':'white'});
			$("#evcolor").val(color);
		});
	});
	
	/* Load Defaults */
	$(".iconBox").css({'color':$("#evcolor").val()});
});
</script>
<?php }?>

<!-- iCheck -->
<script src="valve/icheck/icheck.min.js"></script>
<!-- Caledonian -->
<script src="valve/Scripts/caledonian.js"></script>
</body>
</html>