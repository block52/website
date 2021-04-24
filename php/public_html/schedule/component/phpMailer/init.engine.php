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

include_once('class.phpmailer.php');
include_once('class.smtp.php');
include_once('PHPMailerAutoload.php');

$mail = new PHPMailer(true);
$mail->Encoding = 'base64';
$mail->CharSet = "utf-8";
$mail->IsHTML(true);
$mail->SetFrom(cal_set_sysmail,'zz');
$mail->SetLanguage("en", 'language/');

$parseSub = $this->mailReceiver;

foreach($parseSub as $k=>$v){
		/* Clear Mails */
		$mail->clearAddresses();
		$mail->clearCustomHeaders();
		$mail->clearAllRecipients();

		$mail->AddAddress($k);
		$mail->Subject = $v['subject'];
		$mail->MsgHTML($v['body']);
		
		if(!$mail->Send()){
			$this->errPrint = $mail->ErrorInfo;
			return false;
		}else{
			
			return true;
		}
}
?>