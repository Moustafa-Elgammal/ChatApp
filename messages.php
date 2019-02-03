<?php
require_once('config.php');
if (!auth()) {
    die("<pre>   <br>    No Access. <a href='index.php'>Home</a> </pre>");
}
if (isset($_POST['submit']) && check_csrf($_POST['_token'])) {
    $messenger = new messages($db->connection(), 'messages');
    $line = new stdClass();
    $line->from = $_SESSION['user']['id'];
    $line->to = $_POST['to'];
    $line->message = e_message($_POST['message']);
    $line->created_at = date('Y-m-d h:m:s');
    if ($messenger->sendMessage($line)) {
        $usersModel = new users($db->connection());
        $users = $usersModel->getUsers();
        $messenger = new messages($db->connection());
        $messages = $messenger->getMessages($_SESSION['user']['id']);
        require('./temp/messages.php');
        die();
    } else {
        echo "<pre> Errors accrued. ";

        global $db;
        $usersModel = new users($db->connection());
        $users = $usersModel->getUsers();
        $messenger = new messages($db->connection());
        $messages = $messenger->getMessages($_SESSION['user']['id']);
        require('./temp/messages.php');
        die();

    }
}

global $db;
$usersModel = new users($db->connection());
$users = $usersModel->getUsers();
$messenger = new messages($db->connection());
$messages = $messenger->getMessages($_SESSION['user']['id']);
require('./temp/messages.php');
die();
?>
