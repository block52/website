<?php
use PHPMailer\PHPMailer\PHPMailer;

$out = '';
if (isset($_POST['inputEmail'])) {
    require_once 'phpmailer/src/PHPMailer.php';
    require_once 'phpmailer/src/SMTP.php';
    require_once 'phpmailer/src/Exception.php';
    require_once 'emogrifier/Emogrifier.php';
    require_once 'phpmailer/extras/htmlfilter.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Set who the message is to be sent from
    $mail->setFrom('from@example.com');
    //Set an alternative reply-to address
    $mail->addReplyTo('replyto@example.com');
    //Set who the message is to be sent to
    $mail->addAddress(addslashes($_POST['inputEmail']));
    //Set the subject line
    $mail->Subject = 'PHPMailer sendmail test';

    /* Uncomment the following lines if you use SMTP
       (and replace with your SMTP settings)
    -------------------------------------------------- */

    // $mail->SMTPDebug = 3;
    // $mail->isSMTP();                    // Set mailer to use SMTP
    // $mail->Host       = 'host';         // Specify main and backup SMTP servers
    // $mail->SMTPAuth   = 'smtp_auth';    // Enable SMTP authentication
    // $mail->Username   = 'username';     // SMTP username
    // $mail->Password   = 'password';     // SMTP password
    // $mail->SMTPSecure = 'smtp_secure';  // Enable TLS encryption, `ssl` also accepted
    // $mail->Port       = 'port';         // TCP port to connect to

    /* End of Uncomment
    -------------------------------------------------- */

    $html = file_get_contents('email-templates/default.html');
    $css = file_get_contents('email-templates/default.css');
    // Merge css into html (inline-style) for compatibility.
    $emogrifier = new Pelago\Emogrifier();
    $emogrifier->setHtml($html);
    $emogrifier->setCss($css);
    $mergedHtml = $emogrifier->emogrify();
    // Filter content to prevent attacks. To block external images, switch false to true.
    HTMLFilter($mergedHtml, '', false);
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($mergedHtml, dirname(__FILE__), true);
    //Replace the plain text body with one created manually
    // $mail->AltBody = 'This is a plain-text message body';

    //send the message, check for errors
    if (!$mail->send()) {
        $out = '<p class="alert alert-danger">Mailer Error: ' . $mail->ErrorInfo . '</p>' . " \n";
        $out .= '<p class="alert alert-danger">Email sending failed. Please <a href="http://php.net/manual/en/mail.configuration.php">review your php.ini settings</a></p>' . " \n";
    } else {
        $out = '<p class="alert alert-success">Message sent!</p>' . " \n";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email sending test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Email sending test</h1>
            <hr>
            <div class="col-md-6">
                <form action="email-sending-test.php" method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Enter Destination Email address</label>
                        <input type="email" class="form-control" name="inputEmail" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?php
                    echo $out;
                ?>
            </div>
        </div>
    </div>
</body>
</html>
