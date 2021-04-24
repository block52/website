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

/* Demo Check */
if(!isDemo('addUser,editUser,editProfile')){$errText = errMod(calglb_demo_mode_active,'danger');}

# Error Handler
$errz = array();

# Requests
$ID = ((!isset($_GET['ID']) || !is_numeric($_GET['ID'])) ? 0:$_GET['ID']);

# Admin Control
if(CAL_AUTH_MODE!=1){
	if($page_sub!='profile'){
		header('Location: ?p=users/profile');
		die();
	}
}

# Add User
if(isset($_POST['addUser'])){
	
	$data = array();
	$errText = '';
	
	if(!isset($_POST['name']) || empty($_POST['name'])){$errText.='* '. calglb_please_enter_a_name .'<br>';$errz[] = '#name';}else{
		$data['full_name'] = trim($_POST['name']);
	}
	
	if(!isset($_POST['email']) || !mailVal($_POST['email'])){$errText.='* '. calglb_invalid_e_mail_address .'<br>';$errz[] = '#email';}else{
		$db->where('email=?',array($_POST['email']))->getOne('users');
		$cnt = $db->count;
		if($cnt!=0){
			$errText.='* '. calglb_e_mail_already_exists .'<br>';
			$errz[] = '#email';
		}else{
			$data['email'] = trim($_POST['email']);
		}
	}
	
	if(!isset($_POST['pass']) || empty($_POST['pass'])){$errText.='* '. calglb_please_enter_a_password .'<br>';$errz[] = '#pass';}else{
		# Length
		$pLen = isToo($_POST['pass'],calglb_password.': ',5,30);
		if($pLen!=''){
			$errText.='* '. $pLen .'<br>'; $errz[] = '#pass';
		}else{
			if(!isset($_POST['pass2']) || empty($_POST['pass2'])){$errText.='* '. calglb_please_re_enter_password .'<br>';$errz[] = '#pass2';}else{
				if($_POST['pass'] != $_POST['pass2']){$errText.='* '. calglb_passwords_mismatch .'<br>';$errz[] = '#pass2';$errz[] = '#pass';}else{
					$data['pass'] = encr($_POST['pass']);
				}
			}
		}
	}
	
	if($errText==''){
		
		$data['add_date'] = date('Y-m-d H:i:s');
		$data['private_key'] = encr($_POST['email'].time().rand().uniqid(true));
		$data['public_key'] = encr(rand().md5($_POST['email']).time().rand().uniqid(true));
		$data['view_mode'] = ((isset($_POST['user_view']) && $_POST['user_view']=='YES') ? 1:0);
		
		$db->insert('users',$data);
		
		$errText = errMod(calglb_recorded_successfully.'!','success');
		unset($_POST);
	}else{
		$errText = errMod($errText,'danger');
	}
	
	$errText.='<script>$(document).ready(function(){formScrollTo("#newUser");});</script>';
	
}

# Edit User
if(isset($_POST['editUser'])){
	
	$data = array();
	$errText = '';
	
	# Load User
	$user = $db->where('user_id=?',array($ID))->getOne('users');
	if($db->count==0){header('Location: ?p=users');die();}
	
	## DELETE / ACTIVE ##
		if($user['isPrimary']!=1){
			
			if(isset($_POST['del']) && $_POST['del']=='YES'){
				
				// -> Check Fate
				if(isset($_POST['fate']) && $_POST['fate']==0){
					# Force Remove
					$db->where('user_id=?',array($ID))->delete('panel_notes');
				}else{
					# Move to Another User
					$data = array('user_id'=>intval($_POST['fate']));
					$db->where('user_id=?',array($ID))->update('panel_notes',$data);
				}
				
				// -> User Removing
				$db->where('user_id=? AND isPrimary=0',array($ID))->delete('users');
				header('Location: ?p=users');die();
			}
			
			// ->Activation
			$data['isActive'] = ((isset($_POST['active']) && $_POST['active']=='YES') ? 1:0);
			
		}
	## DELETE / ACTIVE ##
	
	if(!isset($_POST['name']) || empty($_POST['name'])){$errText.='* '. calglb_please_enter_a_name .'<br>';$errz[] = '#name';}else{
		$data['full_name'] = trim($_POST['name']);
	}
	
	if(!isset($_POST['email']) || !mailVal($_POST['email'])){$errText.='* '. calglb_invalid_e_mail_address .'<br>';$errz[] = '#email';}else{
		$db->where('email=? AND user_id<>?',array($_POST['email'],$ID))->getOne('users');
		$cnt = $db->count;
		if($cnt!=0){
			$errText.='* '. calglb_e_mail_already_exists .'<br>';
			$errz[] = '#email';
		}else{
			$data['email'] = trim($_POST['email']);
		}
	}
	
	if(isset($_POST['pass']) && !empty($_POST['pass'])){
		# Length
		$pLen = isToo($_POST['pass'],calglb_password.': ',5,30);
		if($pLen!=''){
			$errText.='* '. $pLen .'<br>'; $errz[] = '#pass';
		}else{
			if(!isset($_POST['pass2']) || empty($_POST['pass2'])){$errText.='* '. calglb_please_re_enter_password .'<br>';$errz[] = '#pass2';}else{
				if($_POST['pass'] != $_POST['pass2']){$errText.='* '. calglb_passwords_mismatch .'<br>';$errz[] = '#pass2';$errz[] = '#pass';}else{
					$data['pass'] = encr($_POST['pass']);
				}
			}
		}
	}
	
	if($errText==''){
		
		$data['view_mode'] = ((isset($_POST['user_view']) && $_POST['user_view']=='YES') ? 1:0);
		
		$db->where('user_id=?',array($ID))->update('users',$data);
		
		$errText = errMod(calglb_recorded_successfully.'!','success');
		unset($_POST);
	}else{
		$errText = errMod($errText,'danger');
	}
	
	$errText.='<script>$(document).ready(function(){formScrollTo("#updUser");});</script>';
	
}

# Edit User
if(isset($_POST['editProfile'])){
	
	$data = array();
	$errText = '';
	
	# Load User
	$ID = CAL_AUTH_ID;
	$user = $db->where('user_id=?',array($ID))->getOne('users');
	if($db->count==0){header('Location: login.php?p=logout');die();}
		
	if(!isset($_POST['name']) || empty($_POST['name'])){$errText.='* '. calglb_please_enter_a_name .'<br>';$errz[] = '#name';}else{
		$data['full_name'] = trim($_POST['name']);
	}
	
	if(!isset($_POST['email']) || !mailVal($_POST['email'])){$errText.='* '. calglb_invalid_e_mail_address .'<br>';$errz[] = '#email';}else{
		$db->where('email=? AND user_id<>?',array($_POST['email'],$ID))->getOne('users');
		$cnt = $db->count;
		if($cnt!=0){
			$errText.='* '. calglb_e_mail_already_exists .'<br>';
			$errz[] = '#email';
		}else{
			$data['email'] = trim($_POST['email']);
		}
	}
	
	if(isset($_POST['pass']) && !empty($_POST['pass'])){
		# Length
		$pLen = isToo($_POST['pass'],calglb_password.': ',5,30);
		if($pLen!=''){
			$errText.='* '. $pLen .'<br>'; $errz[] = '#pass';
		}else{
			if(!isset($_POST['pass2']) || empty($_POST['pass2'])){$errText.='* '. calglb_please_re_enter_password .'<br>';$errz[] = '#pass2';}else{
				if($_POST['pass'] != $_POST['pass2']){$errText.='* '. calglb_passwords_mismatch .'<br>';$errz[] = '#pass2';$errz[] = '#pass';}else{
					$data['pass'] = encr($_POST['pass']);
				}
			}
		}
	}
	
	if($errText==''){
				
		$db->where('user_id=?',array($ID))->update('users',$data);
		
		$errText = errMod(calglb_recorded_successfully.'!','success');
		unset($_POST);
	}else{
		$errText = errMod($errText,'danger');
	}
	
	$errText.='<script>$(document).ready(function(){formScrollTo("#updUser");});</script>';
	
}
?>
<!-- PAGE NAVIGATION START -->
<div>
	<?php if(CAL_AUTH_MODE==1){
		echo('<a href="?p=users/add" class="btn btn-success"><i class="fa fa-plus"></i> '. calglb_add .'</a> <a href="?p=users" class="btn btn-warning"><i class="fa fa-users"></i> '. calglb_list .'</a>');
	}?>
	<h3 class="pull-right no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->

<!-- USERS START -->
<?php if($page_sub=='add'){
	echo($errText);
	?>
	<!-- USER ADD START -->
	<form name="newUser" id="newUser" action="" method="POST">
		<div class="row">
			<div class="col-md-5">
				
				<div class="form-group">
					<label for="name"><?php echo(sh('k0aMV9DrZQ').calglb_display_name);?></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo(((isseter('name')) ? showIn($_POST['name'],'input'):''));?>">
				</div>
				
				<div class="form-group">
					<label for="email"><?php echo(sh('vparlWEgDQ').calglb_email_address);?></label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo(((isseter('email')) ? showIn($_POST['email'],'input'):''));?>">
				</div>
				
				<div class="form-group">
					<label for="pass"><?php echo(sh('lPBgzlKMQZ').calglb_password);?></label>
					<input type="password" class="form-control" id="pass" name="pass" autocomplete="off">
				</div>
				
				<div class="form-group">
					<label for="pass2"><?php echo(sh('QnVM3VarO9').calglb_re_type);?></label>
					<input type="password" class="form-control" id="pass2" name="pass2" autocomplete="off">
				</div>
				
				<div class="form-group">
					<input type="checkbox" id="user_view" name="user_view" value="YES" class="iCheck">
					<label for="user_view"><?php echo(sh('wxvgXW08b4').calglb_user_can_see_only_their_own_records);?></label>
				</div>
				
				<div class="form-group">
					<a href="?p=users" class="btn btn-danger delConf" data-redir="true" data-calert="<?php echo(calglb_do_you_want_to_leave_from_this_page);?>"><i class="fa fa-remove"></i> <?php echo(calglb_cancel);?></a>
					<button type="submit" name="addUser" id="addUser" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo(calglb_save);?></button>
				</div>
				
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_new_user);?>');
			<?php
			if(count($errz)>0){
				echo('
				$("'. implode(',',$errz) .'").parent(".form-group").addClass("has-error");
				$("'. implode(',',$errz) .'").parent(".form-group").find("label").addClass("control-label");
				');
			}
			?>
		});
	</script>
	<!-- USER ADD END -->
<?php }else if($page_sub=='edit'){
	echo($errText);
	?>
	<!-- USER EDIT START -->
	<?php 
	$userData = $db->where('user_id=?',array($ID))->getOne('users');
	if($db->count==0){echo(errMod(calglb_record_not_found,'danger'));}else{
	?>
	<form name="updUser" id="updUser" action="" method="POST">
		<div class="row">
			<div class="col-md-5">
				
				<div class="form-group">
					<label for="name"><?php echo(sh('k0aMV9DrZQ').calglb_display_name);?></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo(showIn($userData['full_name'],'input'));?>">
				</div>
				
				<div class="form-group">
					<label for="email"><?php echo(sh('vparlWEgDQ').calglb_email_address);?></label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo(showIn($userData['email'],'input'));?>">
				</div>
				
				<div class="form-group">
					<label for="pass"><?php echo(sh('lPBgzlKMQZ').calglb_password);?></label>
					<input type="password" class="form-control" id="pass" name="pass" autocomplete="off">
				</div>
				
				<div class="form-group">
					<label for="pass2"><?php echo(sh('QnVM3VarO9').calglb_re_type);?></label>
					<input type="password" class="form-control" id="pass2" name="pass2" autocomplete="off">
				</div>
				
				<div class="form-group">
					<input type="checkbox" id="user_view" name="user_view" value="YES" class="iCheck"<?php echo(formSelector($userData['view_mode'],1,1));?>>
					<label for="user_view"><?php echo(sh('wxvgXW08b4').calglb_user_can_see_only_their_own_records);?></label>
				</div>
				<?php if($userData['isPrimary']!=1){?>
				<div class="form-group">
					<input type="checkbox" id="active" name="active" value="YES" class="iCheck"<?php echo(formSelector($userData['isActive'],1,1));?>>
					<label for="active"><?php echo(sh('bjdMP4aM5v').calglb_active);?></label>
				</div>
				<div class="form-group">
					<input type="checkbox" id="del" name="del" value="YES" class="iCheck">
					<label for="del"><?php echo(calglb_delete);?></label>
				</div>
				<div id="moveEntry" class="sHide">
				<div class="form-group">
					<label for="fate"><?php echo(sh('2KRg1Vkrep').calglb_the_fate_of_the_entries);?></label>
					<select name="fate" id="fate" class="form-control autoWidth input-sm">
							<option value="0"><?php echo(calglb_remove_all_entries);?></option>
							<option disabled>── <?php echo(calglb_move_to_another_user);?> ──</option>
						<?php
							$users = $db->where('isActive=1')->orderBy('full_name','ASC')->get('users');
							foreach($users as $user){
								if($user['user_id']!=$ID){
									echo('<option value="'. $user['user_id'] .'">'. showIn($user['full_name'],'page') .'</option>');
								}
							}
						?>
					</select>
				</div>
				</div>
				<?php }?>
				
				<div class="form-group">
					<a href="?p=users" class="btn btn-danger delConf" data-redir="true" data-calert="<?php echo(calglb_do_you_want_to_leave_from_this_page);?>"><i class="fa fa-remove"></i> <?php echo(calglb_cancel);?></a>
					<button type="submit" name="editUser" id="editUser" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo(calglb_save);?></button>
				</div>
				
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label for="cal_set_api_public"><?php echo(calglb_api_public_key);?></label>
					<input type="text" class="form-control autoWidth" onclick="this.select();" size="30" id="cal_set_api_public" name="cal_set_api_public" value="<?php echo(showIn($userData['public_key'],'page'));?>" readonly>
				</div>
				<div class="form-group">
					<label for="cal_set_api_private"><?php echo(calglb_api_private_key);?></label>
					<input type="text" class="form-control autoWidth" onclick="this.select();" size="30" id="cal_set_api_private" name="cal_set_api_private" value="<?php echo(showIn($userData['private_key'],'page'));?>" readonly>
				</div>
			</div>
		</div>
	</form>
	<?php }?>
	<script>
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_edit);?>');
			<?php
			if(count($errz)>0){
				echo('
				$("'. implode(',',$errz) .'").parent(".form-group").addClass("has-error");
				$("'. implode(',',$errz) .'").parent(".form-group").find("label").addClass("control-label");
				');
			}
			?>
			$("#del").on('ifToggled',function(){
				$("#moveEntry").slideToggle();
			});
		});
	</script>
	<!-- USER EDIT END -->
<?php }else if($page_sub=='profile'){
	echo($errText);
	?>
	<!-- USER PROFILE START -->
	<?php 
	$userData = $db->where('user_id=?',array(CAL_AUTH_ID))->getOne('users');
	if($db->count==0){echo(errMod(calglb_record_not_found,'danger'));}else{
	?>
	<form name="updUser" id="updUser" action="" method="POST">
		<div class="row">
			<div class="col-md-5">
				
				<div class="form-group">
					<label for="name"><?php echo(sh('k0aMV9DrZQ').calglb_display_name);?></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo(showIn($userData['full_name'],'input'));?>">
				</div>
				
				<div class="form-group">
					<label for="email"><?php echo(sh('vparlWEgDQ').calglb_email_address);?></label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo(showIn($userData['email'],'input'));?>">
				</div>
				
				<div class="form-group">
					<label for="pass"><?php echo(sh('lPBgzlKMQZ').calglb_password);?></label>
					<input type="password" class="form-control" id="pass" name="pass" autocomplete="off">
				</div>
				
				<div class="form-group">
					<label for="pass2"><?php echo(sh('QnVM3VarO9').calglb_re_type);?></label>
					<input type="password" class="form-control" id="pass2" name="pass2" autocomplete="off">
				</div>
				
				<div class="form-group">
					<a href="?p=dashboard" class="btn btn-danger delConf" data-redir="true" data-calert="<?php echo(calglb_do_you_want_to_leave_from_this_page);?>"><i class="fa fa-remove"></i> <?php echo(calglb_cancel);?></a>
					<button type="submit" name="editProfile" id="editProfile" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo(calglb_save);?></button>
				</div>
				
			</div>
		</div>
	</form>
	<?php }?>
	<script>
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_profile);?>');
			<?php
			if(count($errz)>0){
				echo('
				$("'. implode(',',$errz) .'").parent(".form-group").addClass("has-error");
				$("'. implode(',',$errz) .'").parent(".form-group").find("label").addClass("control-label");
				');
			}
			?>
		});
	</script>
	<!-- USER PROFILE END -->
<?php }else {?>
	<!-- USER LIST START -->
	
	<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th><?php echo(calglb_display_name);?></th>
				<th><?php echo(calglb_type);?></th>
				<th><?php echo(calglb_primary);?></th>
				<th><?php echo(calglb_active);?></th>
				<th><?php echo(calglb_last_login);?></th>
				<th><?php echo(calglb_created);?></th>
			</tr>
		</thead>
		<tbody>
		<?php $lists = $db->get('users');
		if($db->count==0){}else{
			foreach($lists as $list){
		?>
			<tr>
				<td><a href="?p=users/edit&amp;ID=<?php echo($list['user_id']);?>"><?php echo(showIn($list['full_name'],'page'));?></a></td>
				<td><?php echo(($list['admin_mod']==1) ? calglb_admin:calglb_user);?></td>
				<td><?php echo(getBullets($list['isPrimary']));?></td>
				<td><?php echo(getBullets($list['isActive']));?></td>
				<td><?php echo(setMyDate($list['last_login'],2));?></td>
				<td><?php echo(setMyDate($list['add_date'],2));?></td>
			</tr>
		<?php }}?>
		</tbody>
	</table>
	</div>
	
	<script>
		$(document).ready(function(){
			pgTitleMod('<?php echo(calglb_users);?>');
			$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
			$(".navAdmn").addClass('active');
		});
	</script>
	<!-- USER LIST END -->
<?php }?>
<!-- USERS END -->