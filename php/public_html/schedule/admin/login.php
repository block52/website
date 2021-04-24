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
$master_conn = true;

$p = ((!isset($_GET['p']) || $_GET['p']=='') ? '':$_GET['p']);

# - Logout
if($p=='logout'){

	$letheCookie = new sessionMaster;
	$letheCookie->sesList = "caledonian,cal_login";
	$letheCookie->sessDestroy();
	header('Location:index.php');
	die();

}

# - Login
if($p=='procxmlhttp'){
	
	$loginSucc = false;

	if(!isset($_POST['email']) || !mailVal($_POST['email'])){
		$errText = errMod('* '. calglb_invalid_e_mail_address .'','danger');
	}else{
	
		if(!isset($_POST['pass']) || empty($_POST['pass'])){
			$errText = errMod('* '. calglb_please_enter_a_password .'','danger');
		}else{
				
			$db->where ("(email = ? and isActive = ?)", Array($_POST['email'],1));
			$SDRlogin = $db->getOne('users');
			
			if(count($SDRlogin)==0){
				$errText = errMod('* '. calglb_incorrect_login_informations .'','danger');
			}else{
				if(encr($_POST['pass']) != $SDRlogin['pass']){
					$errText = errMod('* '. calglb_incorrect_login_informations .'','danger');
				}else{
					/* Create New Token */
					$logToken = encr($SDRlogin['user_id'].$SDRlogin['private_key'].time().uniqid());
					if(DEMO_MODE){$logToken=encr('caledonian_demo_mode');}
					$sessionTime=time()+(11800);
					if(isset($_POST['remember_me']) && $_POST['remember_me']=='YES'){
						$sessionTime=time() + (10 * 365 * 24 * 60 * 60);
					}
					
					/* Create Cookie */
					$letheCookie = new sessionMaster;
					$letheCookie->sesName = "caledonian";
					$letheCookie->sesVal = $logToken;
					$letheCookie->sesTime = $sessionTime;
					$letheCookie->sessMaster();
					
					/* Login Cache */
					$letheCookie->sesName = "cal_login";
					$letheCookie->sesVal = $SDRlogin['last_login'];
					$letheCookie->sesTime = $sessionTime;
					$letheCookie->sessMaster();
					
					/* Update Login Data */
					$update = array(
									'last_login'=>date("Y-m-d H:i:s"),
									'session_token'=>$logToken,
									'session_time'=>date("Y-m-d H:i:s",$sessionTime)
									);
					$db->where ('user_id=?', array($SDRlogin['user_id']));
					$db->update ('users', $update);
					$errText = errMod('<strong>'. calglb_you_have_been_successfully_logged_in .'!</strong><br>
									   '. calglb_youll_redirect_to_dashboard_in_5_seconds .'. <a href="index.php?p=dashboard" class="alert-link">'. calglb_click_here .'</a>
									   <script>
										var refreshId = setInterval(function() {location.href="index.php"}, 5000);
										$(".lg-box").slideUp();
									   </script>
									   '
									   ,'success');
					
					$loginSucc = true;
				}
			}
		
		}
	
	}
	echo($errText);
	if($loginSucc){
		
	}else{
		echo('<script>
				$(".lg-box").addClass("animated shake");
				$(".lg-box").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function(){
					$(".lg-box").removeClass("animated shake");
				});
			  </script>
			');	
	}
	die();
}

# - Password Resetter
if($p=='psRstxmlhttp'){
	
	if(DEMO_MODE){die(errMod(calglb_demo_mode_active,'danger'));}
	$loginSucc = false;
	
	if(!isset($_POST['email_f']) || !mailVal($_POST['email_f'])){
		die(errMod('* '. calglb_invalid_e_mail_address .'','danger'));
	}else{
		$data = $db->where('email',$_POST['email_f'])->getOne('users');
		if($db->count==0){
			die(errMod('* '. calglb_invalid_e_mail_address .'','danger'));
		}else{
			
			$mail = new caledonian();
			
			$newPass = rand_passwd(10);
			$newEncr = encr($newPass);
			
			$tempData = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <title>Error Occurred</title> </head> <body style="margin:0; padding:0; background-color:#EAEEEF; font-family:Tahoma; font-size:12px; color:#000;"> <p> </p> <!-- page content --> <div id="main_lay" style="width: 500px; margin: 50px auto; margin-bottom: 0; padding: 15px; background-color: #fff; -webkit-box-shadow: 2px 2px 5px 0px rgba(148,148,148,1); -moz-box-shadow: 2px 2px 5px 0px rgba(148,148,148,1); box-shadow: 2px 2px 5px 0px rgba(148,148,148,1);"> <h3>CALEDONIAN<br /><small style="color: #999;">Password Resetter<br /></small></h3> <hr style="border: 1px solid #ededed; height: 1px;" />Hello!<br /><br />Here is your new password as you requested.<br /><br /><strong>Password:</strong> {NEW_PASSWORD}<br /><br /><span style="color: #ff0000;"><strong>Don\'t forget to change password after sign in.</strong></span><br /><br />Thank you!<br /><br /><hr style="border: 1px solid #ededed; height: 1px;" /> <div style="background-color: #f2f2f2; padding: 7px;"><small>Caledonian - PHP Event Calendar<br /></small></div> </div> <!-- page content --> <p> </p> </body> </html>';
			$tempData = str_replace('{NEW_PASSWORD}',$newPass,$tempData);
			
			$mailData = array($_POST['email_f']=>array(
															'name'=>$_POST['email_f'],
															'subject'=>'Caledonian Password Resetter',
															'altbody'=>'Caledonian Password Resetter',
															'body'=>$tempData
														));
			
			/* Send Mail */
			$mail->mailReceiver = $mailData;
			$mail->mailIDs = (md5(time().rand()));
			if($mail->calMail()){
				# Change Password
				$db->where('user_id=?',array($data['user_id']));
				$db->update('users',array('pass'=>$newEncr));
				die(errMod(calglb_new_password_details_sent_to_your_e_mail_address,'success'));
			}else{
				$errText = $mail->errPrint;
				die(errMod('Mail Error: '.$errText,'danger'));
			}
			/* Update Data */
			
			
		}
	}
	die();	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once('inc/meta.php');?>
	<link href="css/login.style.css" rel="stylesheet" type="text/css" />
	<link href="../valve/icheck/skins/polaris/polaris.css" rel="stylesheet">
</head>
<body>

	<div id="carousel-login" class="carousel slide" data-ride="carousel" data-interval="0">

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
		<div class="item active">

			<!-- Login -->
        <div class="login-container">
		    <section class="main">
				<form class="login-form-3" method="POST" action="" name="loginForms" id="loginForms">
					<div class="clearfix form-group">
						<h4>Caledonian</h4>
					</div>
					<div class="clearfix form-group">
						<div class="lg-result"></div>
					</div>
					<div class="lg-box">
				    <div class="clearfix form-group">
				        <label for="login"><?php echo(calglb_e_mail);?></label>
				        <input type="email" name="email" id="email" placeholder="<?php echo(calglb_e_mail);?>" value="<?php if(DEMO_MODE){echo('demos@artlantis.net');}?>">
				    </div>
				    <div class="clearfix form-group">
				        <label for="password"><?php echo(calglb_password);?></label>
				        <input type="password" name="pass" id="pass" placeholder="<?php echo(calglb_password);?>" value="<?php if(DEMO_MODE){echo('caledonian');}?>"> 
				    </div>
				    <div class="clearfix form-group">
				        <input type="checkbox" name="remember_me" id="remember_me" value="YES">
				        <label for="remember_me"><?php echo(calglb_remember_me);?></label>
						<a tabindex="-1" href="javascript:;" class="forgot_pass pull-right"><i class="fa fa-key"></i> <?php echo(calglb_forgot_password);?>?</a>
				    </div>
				    <div class="clearfix form-group">
						<button type="submit" name="loginSidera" id="loginSidera"><i class="fa fa-lock"></i> <?php echo(calglb_sign_in);?></button>
				    </div>
					</div>
				</form>
			</section>
			
        </div>
			<!-- Login -->
		
		</div>
		<div class="item">
			<div class="login-container">
				<section class="main">
					<form class="login-form-3" action="" name="forgPass" id="forgPass" method="POST">
						<div class="clearfix form-group">
							<h4>Caledonian</h4>
						</div>
						<div class="clearfix form-group">
							<div class="fp-result"></div>
						</div>
						<div class="fp-box">
						<div class="clearfix form-group">
							<label for="email_f"><?php echo(calglb_e_mail);?></label>
							<input type="email" name="email_f" id="email_f" placeholder="<?php echo(calglb_e_mail);?>">
						</div>
						<div class="clearfix form-group">
							<button type="button" class="back_login"><span class="fa fa-chevron-left"></span></button> <input type="submit" name="sendNewPass" id="sendNewPass" value="<?php echo(calglb_reset_password);?>">
						</div>
						</div>						
					</form>
				</section>
			</div>
			
		</div>
	  </div>
	</div>

    <!-- REQUIRED JS SCRIPTS -->
<script>
$(document).ready(function(){
	$('.forgot_pass').click(function () {
	  $('#carousel-login').carousel('next');
	});
	$('.back_login').click(function () {
	  $('#carousel-login').carousel('prev');
	});
	$(function(){$("#passRecForm").submit(function(e){e.preventDefault();dataString=$("#passRecForm").serialize();$.ajax({type:"POST",url:"/admin/lethe/lethe.login.php",data:dataString,dataType:"html",success:function(e){$("#results").html("<div>"+e+"</div>")},error:function(e){$("#results").html("<div>Error</div>")}})})});

	/* Animate */
	$('.login-container').addClass('animated flipInY');
	$('.login-container').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$('.login-container img').addClass('animated bounceIn');
	});
	/* Login */
	$("#loginForms").submit(function(e){
		e.preventDefault();

			$.ajax({
				url : "login.php?p=procxmlhttp",
				type: "POST",
				data : $("#loginForms").serialize(),
				contentType: "application/x-www-form-urlencoded",
				success: function(data, textStatus, jqXHR)
				{
					$(".lg-result").html(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".lg-result").html('err');
				}
			});

	});
	/* Password Resetter */
	$("#forgPass").submit(function(e){
		e.preventDefault();
			$(".fp-result").html('<div class="overlay text-info"><i class="fa fa-refresh fa-spin"></i></div>');
			$.ajax({
				url : "login.php?p=psRstxmlhttp",
				type: "POST",
				data : $("#forgPass").serialize(),
				contentType: "application/x-www-form-urlencoded",
				success: function(data, textStatus, jqXHR)
				{
					$(".fp-result").html(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$(".fp-result").html('err');
				}
			});

	});
	/* iCheck */
	  $('input').iCheck({
		checkboxClass: 'icheckbox_polaris',
		radioClass: 'iradio_polaris',
		increaseArea: '-10%' // optional
	  });
});
</script>

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