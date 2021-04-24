<?php
if (isset($_POST['language']) && preg_match('`[a-z]{2}`', $_POST['language'])) {
    if (!file_exists('../conf/conf.php')) {
        exit('Configuration file not found (7)');
    }
    include_once '../conf/conf.php';
    if (!file_exists(ADMIN_DIR . 'i18n/' . $_POST['language'] . '.php')) {
        ?>
        <p class="alert alert-warning mt-2">Language file doesn't exist.<br>You've got to create your language file named "<strong><?php echo $_POST['language']; ?>.php</strong>" and save it in the "<strong>/admin/i18n/</strong>" folder.</p>
        <?php
    }
}
