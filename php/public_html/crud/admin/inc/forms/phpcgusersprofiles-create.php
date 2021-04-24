<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use common\Utils;
use secure\Secure;

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('form-create-phpcg-users-profiles') === true) {
    include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
    include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
    $validator = new Validator($_POST);
    $validator->required()->validate('profile_name');
    $validator->maxLength(100)->validate('profile_name');
    $validator->required()->validate('read_crm_accounts');
    $validator->integer()->validate('read_crm_accounts');
    $validator->min(-9)->validate('read_crm_accounts');
    $validator->max(9)->validate('read_crm_accounts');
    $validator->required()->validate('update_crm_accounts');
    $validator->integer()->validate('update_crm_accounts');
    $validator->min(-9)->validate('update_crm_accounts');
    $validator->max(9)->validate('update_crm_accounts');
    $validator->required()->validate('create_delete_crm_accounts');
    $validator->integer()->validate('create_delete_crm_accounts');
    $validator->min(-9)->validate('create_delete_crm_accounts');
    $validator->max(9)->validate('create_delete_crm_accounts');
    $validator->maxLength(255)->validate('constraint_query_crm_accounts');
    $validator->required()->validate('read_phpcg_users');
    $validator->integer()->validate('read_phpcg_users');
    $validator->min(-9)->validate('read_phpcg_users');
    $validator->max(9)->validate('read_phpcg_users');
    $validator->required()->validate('update_phpcg_users');
    $validator->integer()->validate('update_phpcg_users');
    $validator->min(-9)->validate('update_phpcg_users');
    $validator->max(9)->validate('update_phpcg_users');
    $validator->required()->validate('create_delete_phpcg_users');
    $validator->integer()->validate('create_delete_phpcg_users');
    $validator->min(-9)->validate('create_delete_phpcg_users');
    $validator->max(9)->validate('create_delete_phpcg_users');
    $validator->maxLength(255)->validate('constraint_query_phpcg_users');
    $validator->required()->validate('read_phpcg_users_profiles');
    $validator->integer()->validate('read_phpcg_users_profiles');
    $validator->min(-9)->validate('read_phpcg_users_profiles');
    $validator->max(9)->validate('read_phpcg_users_profiles');
    $validator->required()->validate('update_phpcg_users_profiles');
    $validator->integer()->validate('update_phpcg_users_profiles');
    $validator->min(-9)->validate('update_phpcg_users_profiles');
    $validator->max(9)->validate('update_phpcg_users_profiles');
    $validator->required()->validate('create_delete_phpcg_users_profiles');
    $validator->integer()->validate('create_delete_phpcg_users_profiles');
    $validator->min(-9)->validate('create_delete_phpcg_users_profiles');
    $validator->max(9)->validate('create_delete_phpcg_users_profiles');
    $validator->maxLength(255)->validate('constraint_query_phpcg_users_profiles');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['form-create-phpcg-users-profiles'] = $validator->getAllErrors();
    } else {
        require_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
        require_once CLASS_DIR . 'phpformbuilder/database/Mysql.php';
        $db = new Mysql();
        $insert['ID'] = Mysql::SQLValue('');
        $insert['profile_name'] = Mysql::SQLValue($_POST['profile_name'], Mysql::SQLVALUE_TEXT);
        if (is_array($_POST['read_crm_accounts'])) {
            $json_values = json_encode($_POST['read_crm_accounts'], JSON_UNESCAPED_UNICODE);
            $insert['read_crm_accounts'] = Mysql::SQLValue($json_values);
        } else {
            $insert['read_crm_accounts'] = Mysql::SQLValue($_POST['read_crm_accounts'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['update_crm_accounts'])) {
            $json_values = json_encode($_POST['update_crm_accounts'], JSON_UNESCAPED_UNICODE);
            $insert['update_crm_accounts'] = Mysql::SQLValue($json_values);
        } else {
            $insert['update_crm_accounts'] = Mysql::SQLValue($_POST['update_crm_accounts'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['create_delete_crm_accounts'])) {
            $json_values = json_encode($_POST['create_delete_crm_accounts'], JSON_UNESCAPED_UNICODE);
            $insert['create_delete_crm_accounts'] = Mysql::SQLValue($json_values);
        } else {
            $insert['create_delete_crm_accounts'] = Mysql::SQLValue($_POST['create_delete_crm_accounts'], Mysql::SQLVALUE_TEXT);
        }
        $insert['constraint_query_crm_accounts'] = Mysql::SQLValue($_POST['constraint_query_crm_accounts'], Mysql::SQLVALUE_TEXT);
        if (is_array($_POST['read_phpcg_users'])) {
            $json_values = json_encode($_POST['read_phpcg_users'], JSON_UNESCAPED_UNICODE);
            $insert['read_phpcg_users'] = Mysql::SQLValue($json_values);
        } else {
            $insert['read_phpcg_users'] = Mysql::SQLValue($_POST['read_phpcg_users'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['update_phpcg_users'])) {
            $json_values = json_encode($_POST['update_phpcg_users'], JSON_UNESCAPED_UNICODE);
            $insert['update_phpcg_users'] = Mysql::SQLValue($json_values);
        } else {
            $insert['update_phpcg_users'] = Mysql::SQLValue($_POST['update_phpcg_users'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['create_delete_phpcg_users'])) {
            $json_values = json_encode($_POST['create_delete_phpcg_users'], JSON_UNESCAPED_UNICODE);
            $insert['create_delete_phpcg_users'] = Mysql::SQLValue($json_values);
        } else {
            $insert['create_delete_phpcg_users'] = Mysql::SQLValue($_POST['create_delete_phpcg_users'], Mysql::SQLVALUE_TEXT);
        }
        $insert['constraint_query_phpcg_users'] = Mysql::SQLValue($_POST['constraint_query_phpcg_users'], Mysql::SQLVALUE_TEXT);
        if (is_array($_POST['read_phpcg_users_profiles'])) {
            $json_values = json_encode($_POST['read_phpcg_users_profiles'], JSON_UNESCAPED_UNICODE);
            $insert['read_phpcg_users_profiles'] = Mysql::SQLValue($json_values);
        } else {
            $insert['read_phpcg_users_profiles'] = Mysql::SQLValue($_POST['read_phpcg_users_profiles'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['update_phpcg_users_profiles'])) {
            $json_values = json_encode($_POST['update_phpcg_users_profiles'], JSON_UNESCAPED_UNICODE);
            $insert['update_phpcg_users_profiles'] = Mysql::SQLValue($json_values);
        } else {
            $insert['update_phpcg_users_profiles'] = Mysql::SQLValue($_POST['update_phpcg_users_profiles'], Mysql::SQLVALUE_TEXT);
        }
        if (is_array($_POST['create_delete_phpcg_users_profiles'])) {
            $json_values = json_encode($_POST['create_delete_phpcg_users_profiles'], JSON_UNESCAPED_UNICODE);
            $insert['create_delete_phpcg_users_profiles'] = Mysql::SQLValue($json_values);
        } else {
            $insert['create_delete_phpcg_users_profiles'] = Mysql::SQLValue($_POST['create_delete_phpcg_users_profiles'], Mysql::SQLVALUE_TEXT);
        }
        $insert['constraint_query_phpcg_users_profiles'] = Mysql::SQLValue($_POST['constraint_query_phpcg_users_profiles'], Mysql::SQLVALUE_TEXT);
        $db->throwExceptions = true;
        try {
            // begin transaction
            $db->transactionBegin();

            // insert new phpcg_users_profiles

            if (DEMO !== true && !$db->insertRow('phpcg_users_profiles', $insert)) {
                $error = $db->error();
                $db->transactionRollback();
                throw new \Exception($error);
            } else {
                $phpcg_users_profiles_last_insert_ID = $db->getLastInsertID();
                if (!isset($error)) {
                    // ALL OK - NO DB ERROR
                    $db->transactionEnd();
                    $_SESSION['msg'] = Utils::alert(INSERT_SUCCESS_MESSAGE, 'alert-success has-icon');

                    // reset form values
                    Form::clear('form-create-phpcg-users-profiles');

                    // redirect to list page
                    if (isset($_SESSION['active_list_url'])) {
                        header('Location:' . $_SESSION['active_list_url']);
                    } else {
                        header('Location:' . ADMIN_URL . 'phpcgusersprofiles');
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
$form = new Form('form-create-phpcg-users-profiles', 'horizontal', 'novalidate', 'bs4');
$form->setAction(ROOT_RELATIVE_URL . 'admin/phpcgusersprofiles/create');

$form->addHtml(USERS_PROFILES_HELPER);


$form->startFieldset();

// ID --
$form->setCols(2, 10);
$form->addInput('hidden', 'ID', '');

// profile_name --
$form->setCols(2, 10);
$form->addInput('text', 'profile_name', '', 'Profile Name', 'required');

$form->endFieldset();

// read_crm_accounts --

$form->startFieldset('crm_accounts', 'class=my-5');

$form->groupInputs('read_crm_accounts', 'update_crm_accounts');
$form->setCols(2, 4);
$form->addOption('read_crm_accounts', '2', 'Yes');
$form->addOption('read_crm_accounts', '1', 'Restricted');
$form->addOption('read_crm_accounts', '0', 'No');
$form->addSelect('read_crm_accounts', 'Read Crm Accounts', 'required, class=select2');

// update_crm_accounts --
$form->addOption('update_crm_accounts', '2', 'Yes');
$form->addOption('update_crm_accounts', '1', 'Restricted');
$form->addOption('update_crm_accounts', '0', 'No');
$form->addSelect('update_crm_accounts', 'Update Crm Accounts', 'required, class=select2');

// create_delete_crm_accounts --
$form->setCols(2, 10);
$form->addOption('create_delete_crm_accounts', '2', 'Yes');
$form->addOption('create_delete_crm_accounts', '1', 'Restricted');
$form->addOption('create_delete_crm_accounts', '0', 'No');
$form->addSelect('create_delete_crm_accounts', 'Create Delete Crm Accounts', 'required, class=select2');

// constraint_query_crm_accounts --
$uniqid = uniqid();
$form->addHtml('<div id="' . $uniqid . '" style="display:none">
<p>WHERE query if limited rights.</p><p>Example: <br><em>, users WHERE table.users_ID = users.ID AND users.ID = CURRENT_USER_ID</em></p><p><em>CURRENT_USER_ID</em> will be automatically replaced by the connected user\'s ID.</p></div>');
$form->addInput('text', 'constraint_query_crm_accounts', '', 'Constraint Query Crm Accounts<a href="#" data-tooltip="#' . $uniqid . '" data-delay="500" class="position-right"><span class="badge badge-secondary">?</span></a>', '');

$form->endFieldset();

// read_phpcg_users --

$form->startFieldset('phpcg_users', 'class=my-5');

$form->groupInputs('read_phpcg_users', 'update_phpcg_users');
$form->setCols(2, 4);
$form->addOption('read_phpcg_users', '2', 'Yes');
$form->addOption('read_phpcg_users', '1', 'Restricted');
$form->addOption('read_phpcg_users', '0', 'No');
$form->addSelect('read_phpcg_users', 'Read Phpcg Users', 'required, class=select2');

// update_phpcg_users --
$form->addOption('update_phpcg_users', '2', 'Yes');
$form->addOption('update_phpcg_users', '1', 'Restricted');
$form->addOption('update_phpcg_users', '0', 'No');
$form->addSelect('update_phpcg_users', 'Update Phpcg Users', 'required, class=select2');

// create_delete_phpcg_users --
$form->setCols(2, 10);
$form->addOption('create_delete_phpcg_users', '2', 'Yes');
$form->addOption('create_delete_phpcg_users', '0', 'No');
$form->addSelect('create_delete_phpcg_users', 'Create Delete Phpcg Users', 'required, class=select2');

// constraint_query_phpcg_users --
$form->addHtml('<span class="form-text text-muted">CREATE/DELETE rights on users table cannot be limited - this would be a nonsense</span>', 'constraint_query_phpcg_users', 'after');
$form->addInput('text', 'constraint_query_phpcg_users', '', 'Constraint Query Phpcg Users', '');

$form->endFieldset();

// read_phpcg_users_profiles --

$form->startFieldset('phpcg_users_profiles', 'class=my-5');

$form->groupInputs('read_phpcg_users_profiles', 'update_phpcg_users_profiles');
$form->setCols(2, 4);
$form->addOption('read_phpcg_users_profiles', '2', 'Yes');
$form->addOption('read_phpcg_users_profiles', '1', 'Restricted');
$form->addOption('read_phpcg_users_profiles', '0', 'No');
$form->addSelect('read_phpcg_users_profiles', 'Read Phpcg Users Profiles', 'required, class=select2');

// update_phpcg_users_profiles --
$form->addOption('update_phpcg_users_profiles', '2', 'Yes');
$form->addOption('update_phpcg_users_profiles', '1', 'Restricted');
$form->addOption('update_phpcg_users_profiles', '0', 'No');
$form->addSelect('update_phpcg_users_profiles', 'Update Phpcg Users Profiles', 'required, class=select2');

// create_delete_phpcg_users_profiles --
$form->setCols(2, 10);
$form->addOption('create_delete_phpcg_users_profiles', '2', 'Yes');
$form->addOption('create_delete_phpcg_users_profiles', '1', 'Restricted');
$form->addOption('create_delete_phpcg_users_profiles', '0', 'No');
$form->addSelect('create_delete_phpcg_users_profiles', 'Create Delete Phpcg Users Profiles', 'required, class=select2');

// constraint_query_phpcg_users_profiles --
$uniqid = uniqid();
$form->addHtml('<div id="' . $uniqid . '" style="display:none">
<p>WHERE query if limited rights.</p><p>Example: <br><em>, users WHERE table.users_ID = users.ID AND users.ID = CURRENT_USER_ID</em></p><p><em>CURRENT_USER_ID</em> will be automatically replaced by the connected user\'s ID.</p></div>');
$form->addInput('text', 'constraint_query_phpcg_users_profiles', '', 'Constraint Query Phpcg Users Profiles<a href="#" data-tooltip="#' . $uniqid . '" data-delay="500" class="position-right"><span class="badge badge-secondary">?</span></a>', '');
$form->addBtn('button', 'cancel', 0, '<i class="' . ICON_BACK . ' position-left"></i>' . CANCEL, 'class=btn btn-warning ladda-button legitRipple, onclick=history.go(-1)', 'btn-group');
$form->addBtn('submit', 'submit-btn', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button legitRipple', 'btn-group');
$form->setCols(0, 12);
$form->centerButtons(true);
$form->printBtnGroup('btn-group');
$form->endFieldset();
$form->addPlugin('nice-check', 'form', 'default', array('%skin%' => 'green'));
