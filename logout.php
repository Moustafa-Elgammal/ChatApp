<?php
require_once('config.php');
if (isset($_POST['_token'])) {
    if (check_csrf($_POST['_token'])) {
        logout();
    }
}
expired_page();

?>