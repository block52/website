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
$errText = '';

if(!defined('cal_set_seo_links')){
	define('cal_set_seo_links',1);
}

/* Demo Check */
if(!isDemo('saveSets')){$errText = errMod(calglb_demo_mode_active,'danger');}

if(isset($_POST['saveSets'])){
	$sets = new caledonian();
	$sets->sysSettings();
	$errText = $sets->errPrint;
}
?>
<!-- PAGE NAVIGATION START -->
<div>
	<h3 class="no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->
<!-- SETTINGS START -->
<?php echo($errText);?>
<form name="edSet" id="edSet" action="" method="POST">
	<div class="form-group">
		<label for="cal_set_default_timezone"><?php echo(sh('O50rAJZMqo').calglb_default_timezone);?></label>
		<select name="cal_set_default_timezone" id="cal_set_default_timezone" class="form-control autoWidth">
			<?php 
			$tzones = timezone_list();
			foreach($tzones as $k=>$v){echo('<option value="'. $k .'"'. formSelector($k,cal_set_default_timezone,0) .'>'. showIn($v,'page') .'</option>');}?>
		</select>
	</div>
	<div class="form-group">
		<label for="cal_set_default_language"><?php echo(sh('1p6MmJk8RP').calglb_default_language);?></label>
		<select name="cal_set_default_language" id="cal_set_default_language" class="form-control autoWidth">
			<?php foreach($SLNG_LIST as $k=>$v){
				echo('<option value="'. $k .'"'. formSelector($k,cal_set_default_language,0) .'>'. showIn($v['sname'],'page') .'</option>');
			}?>
		</select>
	</div>
	<div class="form-group">
		<label for="cal_set_app_url"><?php echo(sh('KX1M7VJrmV'));?>APP URL</label>
		<input type="text" class="form-control autoWidth" size="30" id="cal_set_app_url" name="cal_set_app_url" value="<?php echo(showIn(cal_set_app_url,'input'));?>">
	</div>
	<div class="form-group">
		<label for="cal_set_sysmail"><?php echo(sh('1vngRPdMmk').calglb_system_e_mail);?></label>
		<input type="email" class="form-control autoWidth" id="cal_set_sysmail" name="cal_set_sysmail" value="<?php echo(showIn(cal_set_sysmail,'page'));?>">
	</div>
	<div class="form-group">
		<label for="cal_set_max_upcoming"><?php echo(sh('pX6gYn4rOl').calglb_maximum_upcoming_record);?></label>
		<input type="number" class="form-control autoWidth" id="cal_set_max_upcoming" name="cal_set_max_upcoming" value="<?php echo(showIn(cal_set_max_upcoming,'page'));?>">
	</div>
	<div class="form-group">
		<label for="cal_set_file_size"><?php echo(sh('GAYM2Om8XQ').calglb_import_file_size);?></label>
		<select name="cal_set_file_size" id="cal_set_file_size" class="form-control autoWidth">
			<?php foreach($CAL_FILE_SIZES as $k=>$v){
				echo('<option value="'. $k .'"'. formSelector($k,cal_set_file_size,0) .'>'. showIn($v,'page') .'</option>');
			}?>
		</select>
	</div>
	<div class="form-group">
		<label for="cal_set_api_public"><?php echo(sh('maz8jAjMpO').calglb_api_public_key);?></label>
		<div class="input-group">
		<input type="text" class="form-control autoWidth" size="30" id="cal_set_api_public" name="cal_set_api_public" value="<?php echo(showIn(cal_set_api_public,'input'));?>" readonly>
		<span class="input-group-btn autoWidth"><button class="btn btn-default" type="button" onclick="genKey('#cal_set_api_public');"><i class="fa fa-refresh"></i></button></span>
		</div>
	</div>
	<div class="form-group">
		<label for="cal_set_api_private"><?php echo(sh('6mxg6pGM4n').calglb_api_private_key);?></label>
		<div class="input-group">
		<input type="text" class="form-control autoWidth" size="30" id="cal_set_api_private" name="cal_set_api_private" value="<?php echo(showIn(cal_set_api_private,'input'));?>" readonly>
		<span class="input-group-btn autoWidth"><button class="btn btn-default" type="button" onclick="genKey('#cal_set_api_private');"><i class="fa fa-refresh"></i></button></span>
		</div>
	</div>
	<div class="form-group">
		<label for="cal_set_license_key"><?php echo(sh('ZVKMZ5lrLA').calglb_license_key);?></label>
		<input type="password" name="cal_set_license_key" id="cal_set_license_key"  value="<?php echo(showIn(((DEMO_MODE) ? md5(time()):cal_set_license_key),'page'));?>" class="form-control">
	</div>
	<div class="form-group">
		<label for="cal_set_share_buttons"><?php echo(sh('KX1M7V1rmV').calglb_share_buttons);?></label>
		<input type="checkbox" class="iCheck" id="cal_set_share_buttons" name="cal_set_share_buttons" value="YES"<?php echo(formSelector(cal_set_share_buttons,1,1));?>>
	</div>
	<div class="form-group">
		<label for="cal_set_show_creator"><?php echo(sh('ZVKMZ5orLA').calglb_author_informations);?></label>
		<input type="checkbox" class="iCheck" id="cal_set_show_creator" name="cal_set_show_creator" value="YES"<?php echo(formSelector(cal_set_show_creator,1,1));?>>
	</div>
	<div class="form-group">
		<label for="cal_set_pointips"><?php echo(sh('2WzrLjx8m4'));?>Pointips</label>
		<input type="checkbox" class="iCheck" id="cal_set_pointips" name="cal_set_pointips" value="YES"<?php echo(formSelector(cal_set_pointips,1,1));?>>
	</div>
	<div class="form-group">
		<label for="cal_set_debug_mode"><?php echo(sh('PzWM4v4gqx').calglb_debug_mode);?></label>
		<input type="checkbox" class="iCheck" id="cal_set_debug_mode" name="cal_set_debug_mode" value="YES"<?php echo(formSelector(cal_set_debug_mode,1,1));?>>
	</div>
	<div class="form-group">
		<label for="cal_set_seo_links"><?php echo(sh('PzWM4k2rqx').'SEO Links');?></label>
		<input type="checkbox" class="iCheck" id="cal_set_seo_links" name="cal_set_seo_links" value="YES"<?php echo(formSelector(cal_set_seo_links,1,1));?>>
	</div>
	<div class="form-group">
		<button type="submit" name="saveSets" id="saveSets" class="btn btn-success btn-sm"><?php echo(calglb_save);?></button>
	</div>
</form>
<script>
$(document).ready(function(){
	pgTitleMod('<?php echo(calglb_settings);?>');
	$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
	$(".navAdmn").addClass('active');
});
</script>
<!-- SETTING END -->