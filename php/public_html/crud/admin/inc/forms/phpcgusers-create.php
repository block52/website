<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use common\Utils;
use secure\Secure;

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('form-create-phpcg-users') === true) {
    include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
    include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
    $validator->required()->validate('profiles_ID');
    $validator->integer()->validate('profiles_ID');
    $validator->min(-99999999999)->validate('profiles_ID');
    $validator->max(99999999999)->validate('profiles_ID');
    $validator->required()->validate('name');
    $validator->maxLength(50)->validate('name');
    $validator->required()->validate('firstname');
    $validator->maxLength(50)->validate('firstname');
    $validator->maxLength(50)->validate('address');
    $validator->maxLength(50)->validate('city');
    $validator->maxLength(20)->validate('zip_code');
    $validator->required()->validate('email');
    $validator->maxLength(50)->validate('email');
    $validator->maxLength(20)->validate('phone');
    $validator->maxLength(20)->validate('mobile_phone');
    $validator->required()->validate('password');
    $validator->maxLength(255)->validate('password');
    $validator->required()->validate('active');
    $validator->min(0)->validate('active');
    $validator->max(1)->validate('active');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['form-create-phpcg-users'] = $validator->getAllErrors();
    } else {
        require_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
        require_once CLASS_DIR . 'phpformbuilder/database/Mysql.php';
        $db = new Mysql();
        $insert['ID'] = Mysql::SQLValue('');
        if (is_array($_POST['profiles_ID'])) {
            $json_values = json_encode($_POST['profiles_ID'], JSON_UNESCAPED_UNICODE);
            $insert['profiles_ID'] = Mysql::SQLValue($json_values);
        } else {
            $insert['profiles_ID'] = Mysql::SQLValue($_POST['profiles_ID'], Mysql::SQLVALUE_TEXT);
        }
        $insert['name'] = Mysql::SQLValue($_POST['name'], Mysql::SQLVALUE_TEXT);
        $insert['firstname'] = Mysql::SQLValue($_POST['firstname'], Mysql::SQLVALUE_TEXT);
        $insert['address'] = Mysql::SQLValue($_POST['address'], Mysql::SQLVALUE_TEXT);
        $insert['city'] = Mysql::SQLValue($_POST['city'], Mysql::SQLVALUE_TEXT);
        $insert['zip_code'] = Mysql::SQLValue($_POST['zip_code'], Mysql::SQLVALUE_TEXT);
        $insert['email'] = Mysql::SQLValue($_POST['email'], Mysql::SQLVALUE_TEXT);
        $insert['phone'] = Mysql::SQLValue($_POST['phone'], Mysql::SQLVALUE_TEXT);
        $insert['mobile_phone'] = Mysql::SQLValue($_POST['mobile_phone'], Mysql::SQLVALUE_TEXT);
        $password = Secure::encrypt($_POST['password']);
        $insert['password'] = Mysql::SQLValue($password, Mysql::SQLVALUE_TEXT);
        $insert['active'] = Mysql::SQLValue($_POST['active'], Mysql::SQLVALUE_BOOLEAN);
        $db->throwExceptions = true;
        try {
            // begin transaction
            $db->transactionBegin();

            // insert new phpcg_users

            if (DEMO !== true && !$db->insertRow('phpcg_users', $insert)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            } else {
                $phpcg_users_last_insert_ID = $db->getLastInsertID();
                if (!isset($error)) {
                    // ALL OK - NO DB ERROR
                    $db->transactionEnd();
                    $_SESSION['msg'] = Utils::alert(INSERT_SUCCESS_MESSAGE, 'alert-success has-icon');

                    // reset form values
                    Form::clear('form-create-phpcg-users');

                    // redirect to list page
                    if (isset($_SESSION['active_list_url'])) {
                        header('Location:' . $_SESSION['active_list_url']);
                    } else {
                        header('Location:' . ADMIN_URL . 'phpcgusers');
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
$form = new Form('form-create-phpcg-users', 'horizontal', 'novalidate', 'bs4');
$form->setAction(ROOT_RELATIVE_URL . 'admin/phpcgusers/create');
$form->startFieldset();

// ID --
$form->setCols(2, 10);
$form->addInput('hidden', 'ID', '');

// profiles_ID --
$form->setCols(2, 10);

// set the selected value if it has been sent in URL query parameters
if (isset($_GET['profiles_ID'])) {
    $_SESSION['form-create-phpcg-users']['profiles_ID'] = addslashes($_GET['profiles_ID']);
}

$qry = 'SELECT DISTINCT `phpcg_users_profiles`.`ID`, `phpcg_users_profiles`.`profile_name` FROM phpcg_users_profiles';

// restrict if relationship table is the users table OR if the relationship table is used in the restriction query
if (ADMIN_LOCKED === true && Secure::canCreateRestricted('phpcg_users')) {
    $restriction_query = Secure::getRestrictionQuery('phpcg_users');
    if ('phpcg_users_profiles' == USERS_TABLE) {
        $qry .= ' WHERE  `phpcg_users_profiles`.`ID` = ' . $_SESSION['secure_user_ID'];
    } else if (preg_match('/(?:`)*phpcg_users_profiles(?:`)*\./', $restriction_query)) {
        $qry .= ', phpcg_users' . $restriction_query;
    }
}


$db = new Mysql();

// echo $qry . '<br>';

$db->query($qry);

$db_count = $db->rowCount();
if (!empty($db_count)) {
    while (! $db->endOfSeek()) {
        $row = $db->row();
        $value = $row->ID;
        $display_value = $row->profile_name;
        if ($db_count > 1) {
            $form->addOption('profiles_ID', $value, $display_value);
        }
    }
}

if ($db_count > 1) {
    $form->addSelect('profiles_ID', 'Profile', 'required, class=select2');
} else {
    // for display purpose
    $form->addInput('text', 'profiles_ID-display', $display_value, 'Profile', 'readonly');

    // for send purpose
    $form->addInput('hidden', 'profiles_ID', $value);
}

// name --
$form->addInput('text', 'name', '', 'Name', 'required');

// firstname --
$form->addInput('text', 'firstname', '', 'Firstname', 'required');

// address --
$form->addInput('text', 'address', '', 'Address', '');

// city --
$form->addInput('text', 'city', '', 'City', '');

// zip_code --
$form->addInput('text', 'zip_code', '', 'Zip Code', '');

// email --
$form->addInput('text', 'email', '', 'Email', 'required');

// phone --
$form->addInput('text', 'phone', '', 'Phone', '');

// mobile_phone --
$form->addInput('text', 'mobile_phone', '', 'Mobile Phone', '');

// password --
$form->addHtml('<span class="form-text text-muted">At least 6 characters - Lowercase + Uppercase + Numbers</span>', 'password', 'after');
$form->addPlugin('passfield', '#password', 'lower-upper-number-min-6');
$form->addInput('password', 'password', '', 'Password', 'required');

// active --
$form->addRadio('active', YES, 1);
$form->addRadio('active', NO, 0);
$form->printRadioGroup('active', 'Active', true, 'required');
$form->addBtn('button', 'cancel', 0, '<i class="' . ICON_BACK . ' position-left"></i>' . CANCEL, 'class=btn btn-warning ladda-button legitRipple, onclick=history.go(-1)', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button legitRipple', 'btn-group');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->printBtnGroup('btn-group');
$form->endFieldset();
$form->addPlugin('nice-check', 'form', 'default', array('%skin%' => 'green'));
