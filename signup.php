<?php
require_once('config.php');
if (isset($_POST['submit'])) {
    if (check_csrf($_POST['_token'])) {
        $users = new users($db->connection(), 'users');
        $user = new stdClass();
        $user->name = $_POST['name'];
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->created_at = date('Y-m-d h:m:s');
        if ($users->signUp($user))
            die("<pre>Thank you, $user->name ,<a href='index.php'>Home</a> <a href='signin.php'> Log In</a> </pre>");
        else {
            echo "<pre> Errors: ";
            foreach ($users->getErrors() as $error) {
                echo "<br>        -$error.";
            }
            echo "</pre>";
            require_once('temp/signup.php');
        }
    } else
        expired_page();
} else {
    require_once('temp/signup.php');
}
?>