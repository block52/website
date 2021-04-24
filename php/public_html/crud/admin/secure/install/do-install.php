<?php
use secure\Secure;
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;
use phpformbuilder\database\Mysql;
use generator\Generator;
use crud\ElementsUtilities;

session_start();
if (!file_exists("install.lock")) {
    if (!file_exists('../../../conf/conf.php')) {
        exit('Configuration file not found (1)');
    }
    include_once '../../../conf/conf.php';

    /* =============================================
    Get default tables used in admin
    ============================================= */

    if (!isset($_POST['form-admin-setup'])) {
        if (file_exists(ADMIN_DIR . 'crud-data/db-data.json')) {
            $_SESSION['form-admin-setup'] = array();
            $_SESSION['form-admin-setup']['tables'] = array();
            $json    = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
            $db_data = json_decode($json, true);
            if (empty($db_data)) {
                $_SESSION['msg'] = '<div class="alert alert-danger mb-5"><p class="lead text-semibold">You must first generate your admin dashboard and then install the authentication module.</p><p>The authentication module requires the admin dashboard to be built to assign rights to users on the tables used.</p></div>';
            }
            $tables = array_keys($db_data);
            foreach ($tables as $t) {
                $_SESSION['form-admin-setup']['tables'][] = $t;
            }
        }
    }

    /* =============================================
    Register Posted Values
    ============================================= */

    if (isset($_POST['form-admin-setup'])) {
        include_once CLASS_DIR . 'phpformbuilder/Validator/Validator.php';
        include_once CLASS_DIR . 'phpformbuilder/Validator/Exception.php';
        $validator = new Validator($_POST);
        $required = array('tables.0', 'users_table', 'name', 'firstname', 'email', 'pass');
        foreach ($required as $required) {
            $validator->required()->validate($required);
        }

        // registration table name is reserved & unallowed
        if ($_POST['users_table'] == 'user_data') {
            $validator->maxLength(-1, USER_DATA_RESERVED_NAME)->validate('users_table');
        }

        // users table must not already exist
        /*$db = new Mysql();
        $tables = $db->getTables();
        if (in_array($_POST['users_table'], $tables)) {
            // trigger the error manually
            $validator->maxLength(-1, str_replace('%posted_table%', addslashes($_POST['users_table']), USER_TABLE_ALREADY_EXISTS))->validate('users_table');
        }
        if (in_array($_POST['users_table'] . '_profiles', $tables)) {
            // trigger the error manually
            $validator->maxLength(-1, str_replace('%posted_table%', addslashes($_POST['users_table'] . '_profiles'), USER_TABLE_ALREADY_EXISTS))->validate('users_table');
        }*/
        $validator->hasPattern('`^[a-z_]+$`', WRONG_PATTERN)->validate('users_table');
        $validator->email()->validate('email');
        $validator->minLength(6)->validate('pass');
        $validator->hasLowercase()->validate('pass');
        $validator->hasUppercase()->validate('pass');

        // check for errors
        if ($validator->hasErrors()) {
            $_SESSION['errors']['form-admin-setup'] = $validator->getAllErrors();
        } else {
            // if NOT https://www.phpcrudgenerator.com (AUTH module is disabled in demo)
            if (DEMO === false) {
                /* =============================================
                Create users & profiles tables
                ============================================= */

                $db = new Mysql();
                $db->throw_exceptions = true;

                include_once '../class/secure/Secure.php';

                $users_table = $_POST['users_table'];

                try {
                    /* Begin transaction */

                    $db->transactionBegin();

                    /* get posted tables & test if exist in db */

                    $tables    = $_POST['tables'];
                    $db_tables = $db->getTables();
                    foreach ($tables as $t) {
                        if (!in_array($t, $db_tables)) {
                            exit('Table ' . $t . ' not found');
                        }
                    }

                    /* add users table to administrable tables */

                    if (!in_array($users_table, $tables)) {
                        $tables[] = $users_table;
                    }

                    /* add profiles table to administrable tables */

                    if (!in_array($users_table . '_profiles', $tables)) {
                        $tables[] = $users_table . '_profiles';
                    }

                    /* test if user table & user_profiles table already exist */

                    $user_table_already_exists          = false;
                    $user_profiles_table_already_exists = false;

                    if (in_array($users_table, $db_tables)) {
                        $user_table_already_exists = true;
                    }

                    if (in_array($users_table . '_profiles', $db_tables)) {
                        $user_profiles_table_already_exists = true;
                    }

                    if ($user_profiles_table_already_exists === false) {
                        /* create profiles table if not exists */

                        $qry = 'CREATE TABLE IF NOT EXISTS `' . $users_table . '_profiles` (';
                        $qry .= '  `ID` int(11) NOT NULL AUTO_INCREMENT,';
                        $qry .= '  `profile_name` varchar(100) NOT NULL,';
                        foreach ($tables as $t) {
                            $qry .= '  `read_' . $t . '` tinyint(1) NOT NULL DEFAULT 0,';
                            $qry .= '  `update_' . $t . '` tinyint(1) NOT NULL DEFAULT 0,';
                            $qry .= '  `create_delete_' . $t . '` tinyint(1) NOT NULL DEFAULT 0,';
                            $qry .= '  `constraint_query_' . $t . '` VARCHAR(255) NULL DEFAULT NULL,';
                        }
                        $qry .= '  PRIMARY KEY (`ID`),';
                        $qry .= '  UNIQUE KEY `profile_name_UNIQUE` (`profile_name`)';
                        $qry .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

                        if (!$db->query($qry)) {
                            throw new \Exception($users_table . '_profiles ' . QUERY_FAILED);
                        }
                    }

                    /* create users table if not exists */

                    if ($user_table_already_exists === false) {
                        $qry = 'CREATE TABLE IF NOT EXISTS `' . $users_table . '` (
                          `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                          `profiles_ID` int(11) NOT NULL,
                          `name` varchar(50) NOT NULL,
                          `firstname` varchar(50) NOT NULL,
                          `address` varchar(50) DEFAULT NULL,
                          `city` varchar(50) DEFAULT NULL,
                          `zip_code` varchar(20),
                          `email` varchar(50) NOT NULL,
                          `phone` varchar(20) NULL,
                          `mobile_phone` varchar(20) DEFAULT NULL,
                          `password` varchar(255) NOT NULL,
                          `active` boolean NOT NULL COMMENT \'Boolean\',
                          PRIMARY KEY (`ID`),
                          UNIQUE KEY `email_UNIQUE` (`email`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';

                        if (!$db->query($qry)) {
                            throw new \Exception($users_table . ' ' . QUERY_FAILED);
                        }
                    }

                    if ($user_profiles_table_already_exists === false && $user_table_already_exists === false) {
                        /* add constraints */
                        $qry = 'ALTER TABLE `' . $users_table . '`
                                ADD CONSTRAINT `fk_' . $users_table . '_' . $users_table . '_profiles` FOREIGN KEY (`profiles_ID`) REFERENCES `' . $users_table . '_profiles` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;';

                        if (!$db->query($qry)) {
                            throw new \Exception($users_table . ' ADD CONSTRAINT ' . QUERY_FAILED);
                        }

                        /* insert main administrator profile */

                        $insert = array();
                        $insert['ID']           = Mysql::sqlValue('', Mysql::SQLVALUE_NUMBER);
                        $insert['profile_name'] = Mysql::sqlValue('superadmin', Mysql::SQLVALUE_TEXT);

                        foreach ($tables as $t) {
                            $insert['read_' . $t]          = Mysql::sqlValue(2, Mysql::SQLVALUE_NUMBER);
                            $insert['update_' . $t]        = Mysql::sqlValue(2, Mysql::SQLVALUE_NUMBER);
                            $insert['create_delete_' . $t] = Mysql::sqlValue(2, Mysql::SQLVALUE_NUMBER);
                            $insert['constraint_query_' . $t] = Mysql::sqlValue('', Mysql::SQLVALUE_TEXT);
                        }

                        if (!$db->insertRow($users_table . '_profiles', $insert)) {
                            throw new \Exception($users_table . ' ADD CONSTRAINT ' . QUERY_FAILED);
                        }

                        /* insert main administrator */

                        $profile_id = $db->getLastInsertID();

                        $encrypted_pass         = Secure::encrypt($_POST['pass']);

                        $insert = array();
                        $insert['ID']           = Mysql::sqlValue('', Mysql::SQLVALUE_NUMBER);
                        $insert['profiles_ID']   = Mysql::sqlValue($profile_id, Mysql::SQLVALUE_TEXT);
                        $insert['name']         = Mysql::sqlValue($_POST['name'], Mysql::SQLVALUE_TEXT);
                        $insert['firstname']    = Mysql::sqlValue($_POST['firstname'], Mysql::SQLVALUE_TEXT);
                        $insert['address']      = Mysql::sqlValue($_POST['address'], Mysql::SQLVALUE_TEXT);
                        $insert['city']         = Mysql::sqlValue($_POST['city'], Mysql::SQLVALUE_TEXT);
                        $insert['zip_code']     = Mysql::sqlValue($_POST['zip_code'], Mysql::SQLVALUE_TEXT);
                        $insert['email']        = Mysql::sqlValue($_POST['email'], Mysql::SQLVALUE_TEXT);
                        $insert['phone']        = Mysql::sqlValue($_POST['phone'], Mysql::SQLVALUE_TEXT);
                        $insert['mobile_phone'] = Mysql::sqlValue($_POST['mobile_phone'], Mysql::SQLVALUE_TEXT);
                        $insert['password']     = Mysql::sqlValue($encrypted_pass, Mysql::SQLVALUE_TEXT);
                        $insert['active']       = Mysql::sqlValue(1, Mysql::SQLVALUE_NUMBER);

                        if (!$db->insertRow($users_table, $insert)) {
                            throw new \Exception($users_table . ' ADD CONSTRAINT ' . QUERY_FAILED);
                        }
                    }

                    /* register users table name in conf file */

                    $file = '../conf/conf.php';
                    $contents = '<?php define(\'USERS_TABLE\', \'' . $users_table . '\');';
                    file_put_contents($file, $contents);

                    /* =============================================
                    All OK
                    ============================================= */

                    $db->transactionEnd();

                    // Generate Class, List & forms for users & profiles
                    include_once(GENERATOR_DIR . 'class/generator/Generator.php');
                    $generator = new Generator();
                    $generator->database = DBNAME;

                    // reset relations
                    $generator->init();
                    $generator->tables               = $db->getTables();

                    /* =============================================
                    profiles
                    ============================================= */

                    $generator->table                = $users_table . '_profiles';
                    $generator->table_label          = $generator->getLabel($generator->table);
                    $upperCamelCaseTable             = ElementsUtilities::upperCamelCase($generator->table);
                    $generator->item                 = mb_strtolower($upperCamelCaseTable);
                    $generator->reset('columns');
                    $generator->getDbColumns();
                    $generator->registerColumnsProperties();

                    $generator->resetRelations();
                    $generator->registerRelations();

                    // users_profiles select values
                    $custom_read_update_values = array(
                        YES        => 2,
                        RESTRICTED => 1,
                        NO         => 0
                    );
                    $custom_create_delete_values = array(
                        YES        => 2,
                        RESTRICTED => 1,
                        NO         => 0
                    );
                    $custom_usertable_create_delete_values = array(
                        YES        => 2,
                        NO         => 0
                    );
                    foreach ($tables as $t) {
                        $generator->registerSelectValues('read_' . $t, 'custom_values', '', '', '', '', $custom_read_update_values, false);
                        $generator->registerSelectValues('update_' . $t, 'custom_values', '', '', '', '', $custom_read_update_values, false);
                        if ($t !== $users_table) {
                            $generator->registerSelectValues('create_delete_' . $t, 'custom_values', '', '', '', '', $custom_create_delete_values, false);
                        } else {
                            $generator->registerSelectValues('create_delete_' . $t, 'custom_values', '', '', '', '', $custom_usertable_create_delete_values, false);
                        }
                    }
                    foreach ($tables as $t) {
                        $index = array_search('read_' . $t, $generator->columns['name']);
                        $generator->columns['field_type'][$index] = 'select';
                        $generator->columns['field_width'][$index] = '50% grouped';
                        $generator->columns['nested'][$index] = true;

                        $index = array_search('update_' . $t, $generator->columns['name']);
                        $generator->columns['field_type'][$index] = 'select';
                        $generator->columns['field_width'][$index] = '50% grouped';
                        $generator->columns['nested'][$index] = true;

                        $index = array_search('create_delete_' . $t, $generator->columns['name']);
                        $generator->columns['field_type'][$index] = 'select';
                        $generator->columns['field_width'][$index] = '50%';
                        $generator->columns['nested'][$index] = true;

                        $index = array_search('constraint_query_' . $t, $generator->columns['name']);
                        $generator->columns['field_width'][$index] = '100%';
                        $generator->columns['nested'][$index] = true;
                        if ($t !== $users_table) {
                            $generator->columns['tooltip'][$index] = CONSTRAINT_QUERY_TIP;
                        } else {
                            $generator->columns['help_text'][$index] = CONSTRAINT_USERS_CREATE_HELPER;
                        }
                    }
                    $generator->field_delete_confirm_1 = 'profile_name';
                    $generator->field_delete_confirm_2 = '';

                    $json_data = array(
                        'list_options'           => $generator->list_options,
                        'columns'                => $generator->columns,
                        'external_columns'       => $generator->external_columns,
                        'field_delete_confirm_1' => $generator->field_delete_confirm_1,
                        'field_delete_confirm_2' => $generator->field_delete_confirm_2
                    );

                    // register table & columns properties in json file
                    $json = json_encode($json_data);
                    $generator->registerJson($generator->table . '.json', $json);

                    $_SESSION['generator'] = $generator;

                    $generator->action = 'build_paginated_list';
                    $generator->runBuild();
                    $generator->action = 'build_create_edit';
                    $generator->runBuild();

                    // edit admin/inc/forms/[userstable]profiles[-create|-edit].php
                    // for specific customization
                    include_once 'users-profiles-form-edit-customization.php';

                    /* =============================================
                    users
                    ============================================= */

                    $generator->table                = $users_table;
                    $generator->table_label          = $generator->toReadable($generator->table);
                    $upperCamelCaseTable             = ElementsUtilities::upperCamelCase($generator->table);
                    $generator->item                 = mb_strtolower($upperCamelCaseTable);
                    $generator->reset('columns');
                    $generator->getDbColumns();
                    $generator->registerColumnsProperties();
                    $generator->registerSelectValues('profiles_ID', 'from_table', $users_table . '_profiles', 'ID', 'profile_name', '', '', false);

                    // users select values (profile ID => name)
                    $index = array_search('profiles_ID', $generator->columns['name']);
                    $generator->columns['relation'][$index] = array(
                        'target_table'  => $users_table . '_profiles',
                        'target_fields' => 'profile_name'
                    );
                    $generator->columns['fields']['profiles_ID'] = PROFILE;
                    $generator->columns['field_type'][$index]    = 'select';
                    $generator->field_delete_confirm_1 = 'email';
                    $generator->field_delete_confirm_2 = '';

                    // filters
                    $generator->list_options['filters'] = array(
                        array(
                            'filter_mode'     => 'simple',
                            'filter_A'        => 'name',
                            'select_label'    => NAME,
                            'select_name'     => 'name',
                            'option_text'     => $users_table . '.name',
                            'fields'          => $users_table . '.name',
                            'field_to_filter' => $users_table . '.name',
                            'from'            => $users_table,
                            "from_table"      => $users_table,
                            "join_tables"     => [],
                            "join_queries"    => [],
                            'type'            => 'text',
                            'column'          => 3
                        ),
                        array(
                            'filter_mode'     => 'simple',
                            'filter_A'        => 'email',
                            'select_label'    => EMAIL,
                            'select_name'     => 'email',
                            'option_text'     => $users_table . '.email',
                            'fields'          => $users_table . '.email',
                            'field_to_filter' => $users_table . '.email',
                            'from'            => $users_table,
                            "from_table"      => $users_table,
                            "join_tables"     => [],
                            "join_queries"    => [],
                            'type'            => 'text',
                            'column'          => 8
                        ),
                        array(
                            'filter_mode'     => 'simple',
                            'filter_A'        => 'active',
                            'select_label'    => ENABLED,
                            'select_name'     => 'active',
                            'option_text'     => $users_table . '.active',
                            'fields'          => $users_table . '.active',
                            'field_to_filter' => $users_table . '.active',
                            'from'            => $users_table,
                            "from_table"      => $users_table,
                            "join_tables"     => [],
                            "join_queries"    => [],
                            'type'            => 'boolean',
                            'column'          => 13
                        )
                    );

                    // nested columns
                    $nested_columns = array('address', 'city', 'zip_code', 'phone', 'mobile_phone');
                    foreach ($nested_columns as $nested) {
                        $nested_index = array_search($nested, $generator->columns['name']);
                        $generator->columns['nested'][$nested_index] = true;
                    }

                    // sorting
                    $sorting_columns = array('profiles_ID', 'name', 'firstname', 'email', 'active');
                    foreach ($sorting_columns as $sorting) {
                        $sorting_index = array_search($sorting, $generator->columns['name']);
                        $generator->columns['sorting'][$sorting_index] = true;
                    }

                    // password
                    $password_index = array_search('password', $generator->columns['name']);
                    $generator->columns['field_type'][$password_index] = 'password';
                    $generator->columns['special'][$password_index]    = USERS_PASSWORD_CONSTRAINT;
                    $help_text_constant = strtoupper(str_replace('-', '_', USERS_PASSWORD_CONSTRAINT));
                    $generator->columns['help_text'][$password_index]  = constant($help_text_constant);

                    $json_data = array(
                        'list_options'         => $generator->list_options,
                        'columns'              => $generator->columns,
                        'external_columns'     => $generator->external_columns,
                        'field_delete_confirm_1' => $generator->field_delete_confirm_1,
                        'field_delete_confirm_2' => $generator->field_delete_confirm_2
                    );

                    // register table & columns properties in json file
                    $json = json_encode($json_data);
                    $generator->registerJson($generator->table . '.json', $json);

                    // db-data (admin/data/db-data.json)
                    $json                                      = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
                    $db_data                                   = json_decode($json, true);
                    $table                                     = $generator->table;
                    $db_data[$table]['field_delete_confirm_1'] = $generator->field_delete_confirm_1;
                    $db_data[$table]['field_delete_confirm_2'] = $generator->field_delete_confirm_2;
                    $db_data[$table]['fields']                 = $generator->columns['fields'];

                    $json = json_encode($db_data);
                    $dir = ADMIN_DIR . 'crud-data/';
                    $file = 'db-data.json';
                    $generator->registerAdminFile($dir, $file, $json);

                    $_SESSION['generator'] = $generator;

                    $generator->action = 'build_paginated_list';
                    $generator->runBuild();
                    $generator->action = 'build_create_edit';
                    $generator->runBuild();

                    $_SESSION['form_select_db']['database'] = DBNAME;
                    $_SESSION['form_select_table']['table'] = $users_table;

                    Secure::userMessage(USER_MANAGEMENT_SUCCESSFULLY_CREATED, 'alert-success');


                    /* =============================================
                    TODO : send user email here
                    ============================================= */

                    // create lock file
                    if (file_put_contents('install.lock', '') === false) {
                        exit('Unable to write lock file');
                    } else {
                        $generator->lockAdminPanel();
                    }
                    $show_admin_link = true;
                } catch (\Exception $e) {
                    $db->TransactionRollback();
                    exit($e->getMessage() . '<br><br>' . $db->getLastSql());
                }
            }
        }
    }

    if (!isset($_POST['form-admin-setup']) || (isset($_POST['form-admin-setup']) && $validator->hasErrors())) {
        /* =============================================
        Select Tables
        ============================================= */

        $db = new Mysql();
        if (!$db->IsConnected()) {
            Secure::userMessage(FAILED_TO_CONNECT_DB, 'alert-danger');
        } else {
            $default_users_table = '';
            if (!isset($_SESSION['form-admin-setup']['users_table']) || empty($_SESSION['form-admin-setup']['users_table'])) {
                $default_users_table = 'phpcg_users';
            }
            $tables = $db->getTables();
            $form_admin_setup = new Form('form-admin-setup', 'horizontal', 'novalidate', 'bs4');
            $form_admin_setup->addInput('hidden', 'reset-relations', true);
            foreach ($tables as $table) {
                $form_admin_setup->addOption('tables[]', $table, $table);
            }
            $form_admin_setup->setCols(3, 9);
            $form_admin_setup->startFieldset(TABLES);
            $form_admin_setup->addHtml('<span class="form-text text-muted">' . SELECT_TABLES_USED_IN_ADMIN_HELP . '</span>', 'tables[]', 'after');
            $form_admin_setup->addSelect('tables[]', SELECT_TABLES_USED_IN_ADMIN, 'class=select2, data-width=100%, data-placeholder=' . SELECT_CONST . ' ..., multiple, required');
            $form_admin_setup->addHtml('<span class="form-text text-muted">' . USERS_TABLE_NAME_HELP . '</span>', 'users_table', 'after');
            $form_admin_setup->addInput('text', 'users_table', $default_users_table, USERS_TABLE_NAME, 'required');
            $form_admin_setup->endFieldset();
            $form_admin_setup->startFieldset(SITE_ADMINISTRATOR);
            $form_admin_setup->addInput('text', 'name', '', NAME, 'required');
            $form_admin_setup->addInput('text', 'firstname', '', FIRST_NAME, 'required');
            $form_admin_setup->addTextarea('address', '', ADDRESS);
            $form_admin_setup->setCols(3, 3);
            $form_admin_setup->groupInputs('city', 'zip_code');
            $form_admin_setup->addInput('text', 'city', '', CITY);
            $form_admin_setup->setCols(2, 4);
            $form_admin_setup->addInput('text', 'zip_code', '', ZIP_CODE);
            $form_admin_setup->setCols(3, 9);
            $form_admin_setup->addInput('text', 'email', '', EMAIL, 'required');
            $form_admin_setup->setCols(3, 3);
            $form_admin_setup->groupInputs('phone', 'mobile_phone');
            $form_admin_setup->addInput('text', 'phone', '', PHONE);
            $form_admin_setup->setCols(2, 4);
            $form_admin_setup->addInput('text', 'mobile_phone', '', MOBILE_PHONE);
            $form_admin_setup->setCols(3, 9);
            $form_admin_setup->addHtml('<span class="form-text text-muted">' . ADMIN_PASSWORD_HELP . '</span>', 'pass', 'after');
            $form_admin_setup->addInput('password', 'pass', '', PASSWORD, 'required');
            $form_admin_setup->endFieldset();
            $form_admin_setup->addHtml('<p>&nbsp;</p>');
            $form_admin_setup->setCols(0, 12);
            $form_admin_setup->addHtml('<div class="text-center">');
            $form_admin_setup->addBtn('submit', 'submit', 1, SUBMIT . '<i class="' . ICON_CHECKMARK . ' position-right"></i>', 'class=btn btn-success ladda-button');
            $form_admin_setup->addHtml('</div>');
            $form_admin_setup->addPlugin('passfield', '#pass', 'lower-upper-min-6');
        }
    }
} else {
    exit('Installer is locked.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP CRUD Admin Authentication module Installer</title>
    <meta name="description" content="Install the PHP CRUD Admin Authentication module to protect your admin dashboard access">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/ripple.min.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/stylesheets/generator.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet" type="text/css">
    <?php
    if (isset($form_admin_setup)) {
        $form_admin_setup->printIncludes('css', false, true, false);
    }
    ?>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-tall mb-5">
        <h4 class="ml-2 mb-0"><i class="icon-hammer-wrench position-left"></i>PHP CRUD Generator</h4>
    </nav>
    <div class="container">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="row justify-content-md-center">
            <div class="col-md-11 col-lg-10 mb-4">
                <div class="card card-default">
                    <div class="card-header">
                        <?php echo DATABASE_CONST . ' ' . DBNAME; ?>
                        <div class="heading-elements">
                            <span class="badge badge-primary"><?php echo USER_MANAGEMENT; ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if (DEMO === true) {
                            ?>
                            <div class="alert alert-info has-icon">
                            <h4>The user authentication module is disabled in this demo.</h4>

                            <p>In real life, it protects access to the site administration interface using a login form.</p>

                            <p>The lead administrator may then:</p>
                            <ul>
                                <li>create different user profiles</li>
                                <li>assign read/write / delete permissions to each profile</li>
                                <li>create different users and assign each of them a profile</li>
                            </ul>

                            <p>Rights can be allocated individually to each table.</p>
                            <p>They can also be restricted to the user himself.</p>

                            <p>For example:<br>
                                If there is an "actors" table joined to the user table, an actor can access his own records only.</p>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($form_admin_setup)) {
                            $form_admin_setup->render();
                        } elseif (isset($show_admin_link)) {
                        ?>
                        <div class="text-center">
                            <p class="text-semibold"><a href="<?php echo ADMIN_URL ?>login" class="btn btn primary" target="_blank" rel="noopener"><?php echo OPEN_ADMIN_PAGE ?></a></p>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/ripple.min.js"></script>
    <?php
    if (isset($form_admin_setup)) {
        $form_admin_setup->printIncludes('js', false, true, false);
        $form_admin_setup->printJsCode();
    }
    ?>
</body>
</html>
