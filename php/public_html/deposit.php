<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('float_deposits') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('float_deposits');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['float_deposits'] = $validator->getAllErrors();
    } else {
        include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/phpformbuilder/database/db-connect.php';
        include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/phpformbuilder/database/Mysql.php';

        $db = new Mysql();
        //$insert['member'] = Mysql::SQLValue($_POST['member']);
        $insert['purchase_type'] = Mysql::SQLValue($_POST['purchase_type']);
        $insert['mobile_number'] = Mysql::SQLValue($_POST['mobile_number']);
        $insert['email_address'] = Mysql::SQLValue($_POST['email_address']);
        $insert['upoker_name'] = Mysql::SQLValue($_POST['upoker_name']);
        $insert['upoker_id'] = Mysql::SQLValue($_POST['upoker_id']);
        $insert['deposit_amount'] = Mysql::SQLValue($_POST['deposit_amount']);
        $insert['first_time_deposit_code'] = Mysql::SQLValue($_POST['first_time_deposit_code']);
        $insert['special_bonus_code'] = Mysql::SQLValue($_POST['special_bonus_code']);
        $insert['referrers_code'] = Mysql::SQLValue($_POST['referrers_code']);
        if (!$db->insertRow('float_deposits', $insert)) {
            $msg = '' . $db->error() . '' . $db->getLastSql() . '' . " \n";
        } else {
            $msg = '1 row inserted !' . " \n";
        }
        // clear the form
        Form::clear('float_deposits');
    }
}

/* ==================================================
    The Form
 ================================================== */
Form::clear('float_deposits');
$form = new Form('float_deposits', 'vertical', 'data-fv-no-icon=true, novalidate', 'bs3');
// $form->setMode('development');
$form->addHelper('Before you purchase chips, you must download the Upoker app, register a free account and join club 202020.', 'member');
$form->addRadio('member', 'Yes', 'Yes', 'checked');
$form->addRadio('member', 'No', 'No', '');
$form->printRadioGroup('member', 'Have you joined club 202020 on the Upoker app?', false, 'required=required');
$form->startDependentFields('member', 'No');
$form->addHtml('<h4>Please visit the Get Started page for instructions on how to set up a free account on Upoker and join Float The Flop, club 202020.</h4><a href="start.php" class="btn btn-primary w-100 mt-2"><i class="fi fi-arrow-end font-weight-medium"></i>Get Started</a>');
$form->endDependentFields();
$form->startDependentFields('member', 'Yes');
$form->addRadio('purchase_type', 'Bank Transfer', 'Bank Transfer', 'checked');
$form->printRadioGroup('purchase_type', 'Deposit Type', false, 'required=required');
$form->addIcon( 'mobile_number', '<i class="fas fa-mobile-alt" aria-hidden="true"></i>', 'before');
$form->addHelper('Your mobile number is used to identify you.', 'mobile_number');
$form->addInput('tel', 'mobile_number', '', 'Mobile Number', 'placeholder=Mobile Number,required=required,data-intphone=true,data-allow-dropdown=true,data-initial-country=auto');
$form->addPlugin('intl-tel-input', '#mobile_number', 'default');
$form->addIcon( 'email_address', '<i class="fas fa-mail-bulk" aria-hidden="true"></i>', 'before');
$form->addHelper('Your email address is used to identify you.', 'email_address');
$form->addInput('text', 'email_address', '', 'Email Address', 'placeholder=Email Address, pattern=^\S+@\S+\.\S+$, data-fv-regexp___message=Please enter a valid email address, required=required');
$form->addIcon( 'upoker_name', '<i class="fas fa-child" aria-hidden="true"></i>', 'before');
$form->addHelper('Your Upoker name can be found on the top left of the lobby within the Upoker app.', 'upoker_name');
$form->addInput('text', 'upoker_name', '', 'Upoker Name', 'placeholder=Upoker Name, data-fv-string-length=true, data-fv-string-length___min=3, data-fv-string-length___max=12, required');
$form->addIcon( 'upoker_id', '<i class="fas fa-key" aria-hidden="true"></i>', 'before');
$form->addHelper('Your Upoker ID can be found on the top right of the lobby within the Upoker app.', 'upoker_id');
$form->addInput('number', 'upoker_id', '', 'Upoker ID', 'placeholder=Upoker ID, pattern=^[1-9]\d\d\d\d\d$, data-fv-regexp___message=Please enter a valid 6 digit Upoker ID, required');
$form->addIcon( 'deposit_amount', '<i class="fas fa-dollar-sign" aria-hidden="true"></i>', 'before');
$form->addHelper('How many chips would you like to purchase? (AUD). Minumum $20, Maximum $1,000.', 'deposit_amount');
$form->addInput('number', 'deposit_amount', '', 'Deposit Amount', 'placeholder=Deposit Amount, min=20, max=1000, required');
$form->addIcon( 'first_time_deposit_code', '<i class="fas fa-percent" aria-hidden="true"></i>', 'before');
$form->addHelper('This is an optional code that\'s only valid for first time depositors. ', 'first_time_deposit_code');
$form->addInput('text', 'first_time_deposit_code', '', 'First Time Deposit Code', '');
$form->addIcon( 'special_bonus_code', '<i class="fas fa-comment-dollar" aria-hidden="true"></i>', 'before');
$form->addHelper('This is an optional code for special bonuses offered to you.', 'special_bonus_code');
$form->addInput('text', 'special_bonus_code', '', 'Special Bonus Code', '');
$form->addIcon( 'referrers_code', '<i class="fas fa-barcode" aria-hidden="true"></i>', 'before');
$form->addHelper('This code is associated with the person that referred you to Float The Flop.', 'referrers_code');
$form->addInput('text', 'referrers_code', '', 'Referrers Code', '');
$form->addBtn('submit', 'submit-1', '', 'Submit Deposit', 'class=btn btn-primary w-100');
$form->endDependentFields();
$form->addPlugin('formvalidation', '#float_deposits');
?>
<!DOCTYPE html>
<html lang="en-AU">
<head>
	<title>Get Started On Float | It's Easy To Get Started On Float The Flop</title>
	<meta content="It's easy to get started on Float The Flop, it's just a simple three step process and then you can jump on a table float some flops." name="description">

	<?php include "includes/section_head.php";?>

	<link href="assets/css/deposit.css" rel="stylesheet" media="screen" />

    <!-- fontawesome5 -->
    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css">
    
    <?php $form->printIncludes('css'); ?>
	
</head>
<body class="header-scroll-reveal overflow-x-hidden">
	<div id="wrapper" class="overflow-x-hidden">
		<?php include "includes/section_menu.php";?>
			<div id="middle">
				<!-- Start Banner Heading -->
				<section class="bg-dark">
					<div class="container min-h-20vh">
						<div class="row text-center-xs d-middle">
							<div class="col-12">
								<div class="text-center" data-aos="zoom-in-down" data-aos-duration="0" data-aos-delay="0">
									<h1 class="h3-xs font-weight-light text-white">
									<span class="text-pink font-weight-medium">Express Deposit</span> 
									</h1>
									<p class="text-white h2 h4-xs font-weight-medium">Use the form below to purchase chips</p>
								</div>
							</div>
						</div>
					</div>
				</section>

			<section>
				<div class="container">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
							<?php
							if (isset($msg)) {
								echo $msg;
							}
							$form->render();
							?>

						</div>
					</div>
				</div>
			</section>
				
				<!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
    $form->printIncludes('js');
    $form->printJsCode();
    ?>
	
			</div>
			<?php include "includes/section_footer.php";?>
	</div>

</body>
</html>