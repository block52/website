<?php
/* Add USERS_PROFILES_HELPER + fieldsets with table names
-------------------------------------------------- */

$content = file_get_contents(ADMIN_DIR . 'inc/forms/' . $generator->item . '-create.php');

$find = '`\$form->setAction\(([^\)]+)\);`';
$replace = "\$form->setAction($1);\n\n\$form->addHtml(USERS_PROFILES_HELPER);\n\n";
$content = preg_replace($find, $replace, $content);

$find = '`// read_([a-zA-Z0-9_]+) --`';
$replace = "\$form->endFieldset();\n\n// read_$1 --\n\n\$form->startFieldset('$1', 'class=my-5');\n";
$content = preg_replace($find, $replace, $content);

file_put_contents(ADMIN_DIR . 'inc/forms/' . $generator->item . '-create.php', $content);

$content = file_get_contents(ADMIN_DIR . 'inc/forms/' . $generator->item . '-edit.php');

$find = '`\$form->setAction\(([^\)]+)\);`';
$replace = "\$form->setAction($1);\n\n\$form->addHtml(USERS_PROFILES_HELPER);\n\n";
$content = preg_replace($find, $replace, $content);

$find = '`// read_([a-zA-Z0-9_]+) --`';
$replace = "\$form->endFieldset();\n\n// read_$1 --\n\n\$form->startFieldset('$1', 'class=my-5');\n";
$content = preg_replace($find, $replace, $content);

file_put_contents(ADMIN_DIR . 'inc/forms/' . $generator->item . '-edit.php', $content);

/* Reload users rights if a user or a user profile is edited
-------------------------------------------------- */

// users_profiles-edit.php + users-edit.php
$files = array(
    ADMIN_DIR . 'inc/forms/' . $generator->item . '-edit.php',
    ADMIN_DIR . 'inc/forms/' . str_replace('_profiles', '', $generator->item) . '-edit.php'
);

$find = array(
    '`use secure\Secure;`',
    '`$db->transactionEnd();`'
);

$replace = array(
    "use secure\Secure;\nuse secure\UsersRights;",
    "\$db->transactionEnd();\n                include_once ADMIN_DIR . 'secure/class/secure/UsersRights.php';\n                \$UsersRights = new UsersRights(\$_SESSION['secure_user_ID']);\n                \$_SESSION['UsersRights'] = serialize(\$UsersRights);"
);

foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = preg_replace($find, $replace, $content);

    file_put_contents($file, $content);
}
