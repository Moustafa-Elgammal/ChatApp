<?php
$title = 'Sing Up';
$token = get_csrf();
$content = <<<textcontent
    <br>
<form action="signup.php" method="post">
    username : <input name="username" type="text">
    password : <input name="password" type="password">
    name     : <input name="name" type="text"><br>
               <input name="submit" type="submit">
    <input type="hidden" name="_token" value="$token">
</form>

textcontent;
require_once('main.php');