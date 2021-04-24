<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use common\Utils;
use secure\Secure;

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('form-create-float-transactions') === true) {
    include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
    include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
    $validator->required()->validate('id');
    $validator->float()->validate('id');
    $validator->integer()->validate('id');
    $validator->min(-99999999999)->validate('id');
    $validator->max(99999999999)->validate('id');
    $validator->required()->validate('upoker_name');
    $validator->maxLength(20)->validate('upoker_name');
    $validator->required()->validate('upoker_id');
    $validator->float()->validate('upoker_id');
    $validator->integer()->validate('upoker_id');
    $validator->min(-9999999)->validate('upoker_id');
    $validator->max(9999999)->validate('upoker_id');
    $validator->required()->validate('mobile_number');
    $validator->maxLength(10)->validate('mobile_number');
    $validator->required()->validate('transaction_type');
    $validator->oneOf('Deposit,Withdrawal')->validate('transaction_type');
    $validator->required()->validate('amount');
    $validator->float()->validate('amount');
    $validator->integer()->validate('amount');
    $validator->min(-999999)->validate('amount');
    $validator->max(999999)->validate('amount');
    $validator->maxLength(5)->validate('referral_code');
    $validator->maxLength(12)->validate('bonus_code');
    $validator->required()->validate('status');
    $validator->oneOf('Pending,Approved,Void')->validate('status');
    $validator->required()->validate('submit_time');
    if (isset($_POST['submit_time_submit'])) {
        $validator->date()->validate('submit_time_submit');
    } else {
        $validator->date()->validate('submit_time');
    }
    $validator->required()->validate('processed_time');
    if (isset($_POST['processed_time_submit'])) {
        $validator->date()->validate('processed_time_submit');
    } else {
        $validator->date()->validate('processed_time');
    }
    $validator->required()->validate('ip_address');
    $validator->maxLength(12)->validate('ip_address');
    $validator->required()->validate('country');
    $validator->maxLength(30)->validate('country');
    $validator->required()->validate('city');
    $validator->maxLength(30)->validate('city');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['form-create-float-transactions'] = $validator->getAllErrors();
    } else {
        require_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
        require_once CLASS_DIR . 'phpformbuilder/database/Mysql.php';
        $db = new Mysql();
        $insert['id'] = Mysql::SQLValue($_POST['id'], Mysql::SQLVALUE_NUMBER);
        $insert['upoker_name'] = Mysql::SQLValue($_POST['upoker_name'], Mysql::SQLVALUE_TEXT);
        $insert['upoker_id'] = Mysql::SQLValue($_POST['upoker_id'], Mysql::SQLVALUE_NUMBER);
        $insert['mobile_number'] = Mysql::SQLValue($_POST['mobile_number'], Mysql::SQLVALUE_TEXT);
        if (is_array($_POST['transaction_type'])) {
            $values = implode(',', $_POST['transaction_type']);
            $insert['transaction_type'] = Mysql::SQLValue($values);
        } else {
            $insert['transaction_type'] = Mysql::SQLValue($_POST['transaction_type'], Mysql::SQLVALUE_TEXT);
        }
        $insert['amount'] = Mysql::SQLValue($_POST['amount'], Mysql::SQLVALUE_NUMBER);
        $insert['referral_code'] = Mysql::SQLValue($_POST['referral_code'], Mysql::SQLVALUE_TEXT);
        $insert['bonus_code'] = Mysql::SQLValue($_POST['bonus_code'], Mysql::SQLVALUE_TEXT);
        if (is_array($_POST['status'])) {
            $values = implode(',', $_POST['status']);
            $insert['status'] = Mysql::SQLValue($values);
        } else {
            $insert['status'] = Mysql::SQLValue($_POST['status'], Mysql::SQLVALUE_TEXT);
        }
        $value_date = $_POST['submit_time'];
        $value_time = $_POST['submit_time-time'];
        if (isset($_POST['submit_time_submit'])) {
            $value_date = $_POST['submit_time_submit'];
        }
        if (isset($_POST['submit_time-time_submit'])) {
            $value_time = $_POST['submit_time-time_submit'];
        }
        $insert['submit_time'] = Mysql::SQLValue($value_date . ' ' . $value_time, Mysql::SQLVALUE_DATETIME);
        $value_date = $_POST['processed_time'];
        $value_time = $_POST['processed_time-time'];
        if (isset($_POST['processed_time_submit'])) {
            $value_date = $_POST['processed_time_submit'];
        }
        if (isset($_POST['processed_time-time_submit'])) {
            $value_time = $_POST['processed_time-time_submit'];
        }
        $insert['processed_time'] = Mysql::SQLValue($value_date . ' ' . $value_time, Mysql::SQLVALUE_DATETIME);
        $insert['ip_address'] = Mysql::SQLValue($_POST['ip_address'], Mysql::SQLVALUE_TEXT);
        $insert['country'] = Mysql::SQLValue($_POST['country'], Mysql::SQLVALUE_TEXT);
        $insert['city'] = Mysql::SQLValue($_POST['city'], Mysql::SQLVALUE_TEXT);
        $db->throwExceptions = true;
        try {
            // begin transaction
            $db->transactionBegin();

            // insert new float_transactions

            if (DEMO !== true && !$db->insertRow('float_transactions', $insert)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            } else {
                $float_transactions_last_insert_ID = $db->getLastInsertID();
                if (!isset($error)) {
                    // ALL OK - NO DB ERROR
                    $db->transactionEnd();
                    $_SESSION['msg'] = Utils::alert(INSERT_SUCCESS_MESSAGE, 'alert-success has-icon');

                    // reset form values
                    Form::clear('form-create-float-transactions');

                    // redirect to list page
                    if (isset($_SESSION['active_list_url'])) {
                        header('Location:' . $_SESSION['active_list_url']);
                    } else {
                        header('Location:' . ADMIN_URL . 'floattransactions');
                    }

                    // if we don't exit here, $_SESSION['msg'] will be unset
                    exit();
                }
            }
        } catch (\Exception $e) {
            $msg_content = DB_ERROR;
            if (ENVIRONMENT == 'development') {
                $msg_content .= '<br>' . $e->getMessage() . '<br>' . $db->getLastSql();
            }
            $_SESSION['msg'] = Utils::alert($msg_content, 'alert-danger has-icon');
        }
    } // END else
} // END if POST
$form = new Form('form-create-float-transactions', 'horizontal', 'novalidate', 'bs4');
$form->setAction(ROOT_RELATIVE_URL . 'admin/floattransactions/create');
$form->startFieldset();

// id --
$form->setCols(2, 10);
$form->addInput('number', 'id', '', 'Id', 'required');

// upoker_name --
$form->setCols(2, 10);
$form->addInput('text', 'upoker_name', '', 'Upoker Name', 'required');

// upoker_id --
$form->addInput('number', 'upoker_id', '', 'Upoker Id', 'required');

// mobile_number --
$form->addInput('text', 'mobile_number', '', 'Mobile Number', 'required');

// transaction_type --
$form->addOption('transaction_type', 'Deposit', 'Deposit');
$form->addOption('transaction_type', 'Withdrawal', 'Withdrawal');
$form->addSelect('transaction_type', 'Transaction Type', 'required, class=select2');

// amount --
$form->addInput('number', 'amount', '', 'Amount', 'required');

// referral_code --
$form->addInput('text', 'referral_code', '', 'Referral Code', '');

// bonus_code --
$form->addInput('text', 'bonus_code', '', 'Bonus Code', '');

// status --
$form->addOption('status', 'Pending', 'Pending');
$form->addOption('status', 'Approved', 'Approved');
$form->addOption('status', 'Void', 'Void');
$form->addSelect('status', 'Status', 'required, class=select2');

// submit_time --
$form->groupInputs('submit_time', 'submit_time-time');
$form->addPlugin('pickadate', '#submit_time'); // date field
$form->addPlugin('pickadate', '#submit_time-time', 'pickatime'); // time field

$form->setCols(2, 6);
$form->addInput('text', 'submit_time', '', 'Submit Time', 'required, data-format=dd mmmm yyyy, data-format-submit=yyyy-mm-dd, data-set-default-date=true');
$form->setCols(0, 4);
if (DATETIMEPICKERS_STYLE === 'material') {
    $form->addInput('text', 'submit_time-time', '', '', 'required, data-format=hh:i A, data-format-submit=HH:i, data-twelve-hour=false, data-interval=15, placeholder=Hour');
} else {
    $form->addInput('text', 'submit_time-time', '', '', 'required, data-format=H:i a, data-format-submit=HH:i, data-interval=15, placeholder=Hour');
}
$form->setCols(2, 10);

// processed_time --
$form->groupInputs('processed_time', 'processed_time-time');
$form->addPlugin('pickadate', '#processed_time'); // date field
$form->addPlugin('pickadate', '#processed_time-time', 'pickatime'); // time field

$form->setCols(2, 6);
$form->addInput('text', 'processed_time', '', 'Processed Time', 'required, data-format=dd mmmm yyyy, data-format-submit=yyyy-mm-dd, data-set-default-date=true');
$form->setCols(0, 4);
if (DATETIMEPICKERS_STYLE === 'material') {
    $form->addInput('text', 'processed_time-time', '', '', 'required, data-format=hh:i A, data-format-submit=HH:i, data-twelve-hour=false, data-interval=15, placeholder=Hour');
} else {
    $form->addInput('text', 'processed_time-time', '', '', 'required, data-format=H:i a, data-format-submit=HH:i, data-interval=15, placeholder=Hour');
}
$form->setCols(2, 10);

// ip_address --
$form->addInput('text', 'ip_address', '', 'Ip Address', 'required');

// country --
$form->addInput('text', 'country', '', 'Country', 'required');

// city --
$form->addInput('text', 'city', '', 'City', 'required');
$form->addBtn('button', 'cancel', 0, '<i class="' . ICON_BACK . ' position-left"></i>' . CANCEL, 'class=btn btn-warning ladda-button legitRipple, onclick=history.go(-1)', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button legitRipple', 'btn-group');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->printBtnGroup('btn-group');
$form->endFieldset();
$form->addPlugin('nice-check', 'form', 'default', array('%skin%' => 'green'));
