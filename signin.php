<?php
require_once('config.php');
if (auth()) {
    $title = 'Sign In';
    $token = get_csrf();
    $content = <<<textcontent
Already Logged in.
textcontent;
    require_once('temp/main.php');
    die();
}

if (isset($_POST['submit'])) {
    if (check_csrf($_POST['_token'])) {
        $users = new users($db->connection(), 'users');
        if ($users->signIn($_POST['username'], $_POST['password'])) {
            $title = 'Sign In';
            $content = "<br> logged in,<a href=\"messages.php\"> as " . $_SESSION['user']['name'] . ", check your inbox </a>";
            require_once('temp/main.php');
            die();
        } else {
            $title = "Sign In Errors:";
            $content = "<pre> Errors: ";
            foreach ($users->getErrors() as $error) {
                $content .= "<br>        - $error.";
            }
            $content .= "</pre>";
            require_once('temp/main.php');
            die();
        }
    } else
        expired_page();
} else {
    require_once('temp/signin.php');
}
?>