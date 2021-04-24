<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 03.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
if(!$master_conn){die('<strong style="color:red;">Access denied</strong> - You are not authorized to access this page!');}
if(CAL_AUTH_MODE!=1){die('<strong style="color:red;">Access denied</strong> - You are not authorized to access this page!');}
$wk = ((!isset($_GET['wk']) || empty($_GET['wk'])) ? '-':trim($_GET['wk']));

/* Demo Check */
if(!isDemo('addWidget,editWidget')){$errText = errMod(calglb_demo_mode_active,'danger');}

# Add Widget
if(isset($_POST['addWidget'])){
	
	$data = array();
	$errText = '';
	$widSet = array(
					'plugins'=>array()
					);
	
	# Commons
	if(!reqVal('widIds','empty')){$errText.='* '. calglb_invalid_widget_id .'<br>';}else{
		$data['widget_key'] = trim($_POST['widIds']);
	}
	if(!reqVal('widName','empty')){$errText.='* '. calglb_please_enter_a_widget_name .'<br>';}else{
		$data['widget_name'] = trim($_POST['widName']);
	}
	if(!isset($_POST['widType']) || !array_key_exists($_POST['widType'],$CAL_WIDGETS)){$errText.='* '. calglb_invalid_widget .'<br>';}else{
		$data['widget_type'] = trim($_POST['widType']);
	}
	if(!reqVal('widUser','numeric')){$errText.='* '. calglb_please_choose_data_user .'<br>';}else{
		$data['data_user'] = intval($_POST['widUser']);
	}
	if(!reqVal('widData','numeric')){$errText.='* '. calglb_please_choose_data_type .'<br>';}else{
		$data['widget_data'] = intval($_POST['widData']);
	}
	if(isset($_POST['widScript'])){
		foreach($_POST['widScript'] as $k=>$v){
			$widSet['plugins'][] = trim($v);
		}
	}
	if(isset($_POST['list_count']) && is_numeric($_POST['list_count'])){
		$data['max_data'] = intval($_POST['list_count']);
	}else{
		$data['max_data'] = 5;
	}
	
	# Widget Specific
	if(isset($_POST['event_sound']) && $_POST['event_sound']=='YES'){
		$widSet['sound'] = true;
		$widSet['soundFile'] = $CAL_SOUNDS[$_POST['event_sound_file']]['file'];
	}
	if(isset($_POST['refresh_time']) && is_numeric($_POST['refresh_time'])){
		$widSet['refreshTime'] = intval($_POST['refresh_time']);
	}
	
	// Popup
	if(isset($_POST['widType']) && $_POST['widType']=='popup_master'){
		$widSet['time_range'] = array('start'=>date('Y-m-d'),'end'=>date('Y-m-d'));
		if(reqVal('start_date','empty')){
			$widSet['time_range']['start'] = DateTime::createFromFormat("d/m/Y", $_POST['start_date'])->format("Y-m-d");
		}
		if(reqVal('end_date','empty')){
			$widSet['time_range']['end'] = DateTime::createFromFormat("d/m/Y", $_POST['end_date'])->format("Y-m-d");
		}
	}
	
	if($errText==''){
		$data['widget_settings'] = json_encode($widSet);
		$db->insert('widgets',$data);
		$ext = '<br><br><a href="?p=widgets/edit&amp;wk='. $data['widget_key'] .'" class="alert-link">'. calglb_go_to_widget_code .'</a>';
		$errText = errMod(''.calglb_recorded_successfully.'!'.$ext,'success');
		unset($_POST);
	}else{
		$errText = errMod($errText,'danger');
	}
	
}

/* Edit Widget */
if(isset($_POST['editWidget'])){
	
	/* Delete */
	if(isset($_POST['del']) && $_POST['del']=='YES'){
		$db->where('widget_key=?',array($wk))->delete('widgets');
		header('Location: ?p=widgets');
		die();
	}
	
	$data = array();
	$errText = '';
	$widSet = array(
					'plugins'=>array()
					);
	
	if(isset($_POST['widName']) && !empty($_POST['widName'])){
		$data['widget_name'] = $_POST['widName'];
	}
	
	if(!reqVal('widUser','numeric')){$errText.='* '. calglb_please_choose_data_user .'<br>';}else{
		$data['data_user'] = intval($_POST['widUser']);
	}
	if(!reqVal('widData','numeric')){$errText.='* '. calglb_please_choose_data_type .'<br>';}else{
		$data['widget_data'] = intval($_POST['widData']);
	}
	if(isset($_POST['widScript'])){
		foreach($_POST['widScript'] as $k=>$v){
			$widSet['plugins'][] = trim($v);
		}
	}
	if(isset($_POST['list_count']) && is_numeric($_POST['list_count'])){
		$data['max_data'] = intval($_POST['list_count']);
	}else{
		$data['max_data'] = 5;
	}
	
	# Widget Specific
	if(isset($_POST['event_sound']) && $_POST['event_sound']=='YES'){
		$widSet['sound'] = true;
		$widSet['soundFile'] = $CAL_SOUNDS[$_POST['event_sound_file']]['file'];
	}
	if(isset($_POST['refresh_time']) && is_numeric($_POST['refresh_time'])){
		$widSet['refreshTime'] = intval($_POST['refresh_time']);
	}
	
	// Popup
	if(isset($_POST['widType']) && $_POST['widType']=='popup_master'){
		$widSet['time_range'] = array('start'=>date('Y-m-d'),'end'=>date('Y-m-d'));
		if(reqVal('start_date','empty')){
			$widSet['time_range']['start'] = DateTime::createFromFormat("d/m/Y", $_POST['start_date'])->format("Y-m-d");
		}
		if(reqVal('end_date','empty')){
			$widSet['time_range']['end'] = DateTime::createFromFormat("d/m/Y", $_POST['end_date'])->format("Y-m-d");
		}
	}
	
	if(count($data)!=0){
		$data['widget_settings'] = json_encode($widSet);
		$db->where('widget_key=?',array($wk))->update('widgets',$data);
	}
	
}
?>
<!-- PAGE NAVIGATION START -->
<div>
	<?php if(CAL_AUTH_MODE==1){
		echo('<a href="?p=widgets/add" class="btn btn-success"><i class="fa fa-plus"></i> '. calglb_add .'</a> <a href="?p=widgets" class="btn btn-warning"><i class="fa fa-users"></i> '. calglb_list .'</a>');
	}?>
	<h3 class="pull-right no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->
<!-- WIDGETS START -->
<script src="../valve/widgets/scripts/buzz.min.js"></script>

<?php if($page_sub=='add'){
	echo($errText);
	?>
<!-- ADD START -->
	<div class="row">
	
		<div class="col-md-7">
			<form name="newWid" id="newWid" action="" method="POST">
			
				<div class="form-group">
					<label for="widIds"><?php echo(calglb_widget_id);?>:</label>
					<code><?php $widIDs = encr('caledonian'.time().rand().uniqid(true)); echo($widIDs);?></code>
					<input type="hidden" name="widIds" id="widIDs" value="<?php echo($widIDs);?>">
				</div>
				<div class="form-group">
					<label for="widName"><?php echo(calglb_widget_name);?>:</label>
					<input type="text" name="widName" id="widName" value="<?php echo(((isseter('widName')) ? showIn($_POST['widName'],'input'):''));?>" class="form-control">
				</div>	
				<div class="form-group">
					<label for="widType"><?php echo(calglb_widget_type);?></label>
					<select name="widType" id="widType" class="form-control autoWidth">
						<option value="-">-- <?php echo(calglb_choose);?></option>
						<?php
						foreach($CAL_WIDGETS as $k=>$v){
							echo('<option value="'. $k .'"'. ((isseter('widType')) ? formSelector($_POST['widType'],$k,0):'') .'>'. $v['name'] .'</option>');
						}
						?>
					</select>
				</div>
				<div id="widgetFields"></div>
				<div class="form-group">
					<button name="addWidget" id="addWidget" class="btn btn-success"><?php echo(calglb_save);?></button>
				</div>	
			
			</form>
		</div>
		<div class="col-md-5">
			<div id="widgetInfo"></div>
		</div>
	
	</div>

	<script>
	
		function widgetLoader(form){
					$("#widgetFields").html('<i class="fa fa-cog fa-spin"></i>');
					$.ajax({
						url : "manage/pg.xmlhttp.php?pos=getFields",
						type: "POST",
						data : $("#"+form).serialize(),
						contentType: "application/x-www-form-urlencoded",
						success: function(data, textStatus, jqXHR)
						{
							$("#widgetFields").html(data);
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							$("#widgetFields").html('Error Occured');
						}
					});
		}
	
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_add);?>');
			
			// Load Default
			<?php if(isset($_POST['widType']) && $_POST['widType']!='-'){
				$fdatas = 'widgetLoader("newWid");';
				echo($fdatas);
			}?>
			
			// Widget Choicer
			$("#widType").on('change',function(){
				
				var selDatas = $(this).val();
							
				if(selDatas!='-'){
				
					widgetLoader("newWid");
				
				}
				
			});
		});
	</script>
<!-- ADD END -->
<!-- EDIT START -->
<?php }else if($page_sub=='edit'){
	$wid = $db->where('widget_key=?',array($wk))->getOne('widgets');
	if($db->count==0){echo(errMod(calglb_record_not_found,'danger'));}else{
	?>
	<form name="edWid" id="edWid" action="" method="POST">
	<div class="row">
		<div class="col-md-6">
				<div class="form-group">
					<label><?php echo(calglb_widget_id);?>:</label>
					<code><?php echo($wid['widget_key']);?></code>
				</div>
				<div class="form-group">
					<label><?php echo(calglb_widget_name);?>:</label>
					<input type="text" name="widName" id="widName" value="<?php echo(showIn($wid['widget_name'],'input'));?>" class="form-control">
				</div>
				<div class="form-group">
					<label><?php echo(calglb_widget_type);?>:</label>
					<code><?php echo(showIn($CAL_WIDGETS[$wid['widget_type']]['name'],'page'));?></code>
				</div>
				
				<!-- Widget Model -->
				<?php 
					$calWid = new caledonian();
					$calWid->widgetEdit = true;
					$calWid->widgetType = $wid['widget_type'];
					$calWid->widgetEditData = $wid;
					echo $calWid->WidgetFields();
				?>
				<!-- Widget Model -->
				
				<div class="form-group">
					<label><?php echo(calglb_delete);?>:</label>
					<input type="checkbox" name="del" id="del" value="YES" class="iCheck">
				</div>
				<div class="form-group">
					<button name="editWidget" id="editWidget" type="submit" class="btn btn-success"><?php echo(calglb_save);?></button>
				</div>
		</div>
		<div class="col-md-6">
				<?php echo(Caledonian::Widget($wid['widget_key'],$wid['widget_type'],$wid['widget_settings']));?>
		</div>
	</div>
	</form>
	<?php }?>
	<script>
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_edit);?>');
		});
	</script>
<!-- EDIT END -->
<?php }else{?>
<!-- LIST START -->

	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th><?php echo(calglb_title);?></th>
				<th><?php echo(calglb_type);?></th>
				<th><?php echo(calglb_created);?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$wList = $db->get('widgets');
			if($db->count==0){echo(errMod(calglb_record_not_found,'danger'));}else{
			foreach($wList as $wListR){
			?>
			<tr>
				<td><a href="?p=widgets/edit&amp;wk=<?php echo($wListR['widget_key']);?>"><?php echo(showIn($wListR['widget_name'],'page'));?></a></td>
				<td><?php echo($CAL_WIDGETS[$wListR['widget_type']]['name']);?></td>
				<td><?php echo(setMyDate($wListR['add_date'],2));?></td>
			</tr>
			<?php }}?>
		</tbody>
	</table>

	<script>
		$(document).ready(function(){
			pgTitleMod('Widgets');
			$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
			$(".navAdmn").addClass('active');
		});
	</script>
<!-- LIST END -->
<?php }?>
<!-- WIDGETS END -->