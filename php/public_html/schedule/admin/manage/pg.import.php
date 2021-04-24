<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 13.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
if(!$master_conn){die('<strong style="color:red;">Access denied</strong> - You are not authorized to access this page!');}

/* Demo Check */
if(!isDemo('impFile')){$errText = errMod(calglb_demo_mode_active,'danger');}

# Import
if(isset($_POST['impFile'])){
	$errText = '';
	$new_file_name = null;
	$valid_file = false;
	$progress[] = '- Start';
	
	//print_r($_FILES['file']);
	
	if(!isset($_POST['eventUser']) || !is_numeric($_POST['eventUser'])){
		$_POST['eventUser'] = CAL_AUTH_ID;
	}
	
	if(!isset($_FILES['file']) || $_FILES['file']['error']!=0){$errText .= '* '. calglb_please_choose_a_file .'<br>';}else{
		if($_FILES['file']['size'] > (cal_set_file_size)){ # 2MB
			$errText .= '* '. calglb_file_size_too_large .'<br>';
		}else{
			if($_FILES['file']['type'] != 'text/calendar'){ # ICS
				$errText .= '* '. calglb_incorrect_file_type .'<br>';
			}
		}
	}
	
	if($errText==''){
		
		$new_file_name = 'import.'.md5(time().rand().uniqid(true));
		if(move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$new_file_name)){
			$progress[] = '- '. calglb_file_uploaded .'';
			
			include_once(CAL_APP.DIRECTORY_SEPARATOR.'lib/class.iCalReader.php');
			$ical   = new ICal('uploads/'.$new_file_name);
			$events = $ical->events();
			$date = reset($events);
			$date = $date['DTSTART'];
			$progress[] = '- '. calglb_parsing_started .': ' . date('d.m.Y H:i:s A');
			$progress[] = '- '. calglb_number_of_events .': ' . $ical->event_count;
			
			$data = array();
			
			foreach ($events as $event) {
				$data['user_id'] = $_POST['eventUser'];
				$data['title'] = ((isset($event['SUMMARY']) && !empty($event['SUMMARY'])) ? mysql_prep($event['SUMMARY']):'Event '.rand(1,99));
				$data['mynotes'] = mysql_prep(@$event['DESCRIPTION']);
				$data['add_date'] = (($event['CREATED']) ? date('Y-m-d H:i:s',strtotime($event['CREATED'])):date('Y-m-d H:i:s'));
				$data['note_date'] = (($event['DTSTART']) ? date('Y-m-d H:i:s',strtotime($event['DTSTART'])):date('Y-m-d H:i:s'));
				$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$data['edit_date'] = (($event['LAST-MODIFIED']) ? date('Y-m-d H:i:s',strtotime($event['LAST-MODIFIED'])):date('Y-m-d H:i:s'));
				$db->insert('panel_notes',$data);
			}
			$progress[] = '- '. calglb_events_imported_successfully .'!';
			
		}else{
			$progress[] = '- '. calglb_there_error_occurred_while_upload_file .'';
		}
		
		$errText = '<div class="well">'. implode('<br>',$progress) .'</div>';
		
	}else{
		$errText = errMod($errText,'danger');
	}
}
?>
<!-- PAGE NAVIGATION START -->
<div>
	<h3 class="no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->
<!-- IMPORT START -->
<div class="row">
	<div class="col-md-6">
		<form name="imports" id="imports" method="POST" action="" enctype="multipart/form-data">
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
				<label for="file"><?php echo(calglb_file);?></label>
				<input type="file" class="form-control input-sm" id="file" name="file">
				<span class="help-block"><?php echo(calglb_allowed_file);?>: <?php echo($CAL_FILE_SIZES[cal_set_file_size]);?> - .ics</span>
			</div>
			<div class="form-group">
				<button type="submit" name="impFile" id="impFile" class="btn btn-success btn-sm"><i class="fa fa-download"></i> <?php echo(calglb_import);?></button>
			</div>
		</form>
	</div>
	<div class="col-md-5">
		<?php echo($errText);?>
	</div>
</div>
			
<script>
$(document).ready(function(){
	pgTitleMod('<?php echo(calglb_import);?>');
	$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
	$(".navb-event-mng").addClass('active');
});
</script>
<!-- IMPORT END -->