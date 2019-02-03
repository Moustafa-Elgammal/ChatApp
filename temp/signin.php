<?php
$title = 'Sing In';
$token = get_csrf();
$content = <<<textcontent
    <br>
<form action="signin.php" method="post">
    username : <input name="username" type="text">
    password : <input name="password" type="password"><br>
               <input name="submit" type="submit">
    <input type="hidden" name="_token" value="$token">
</form>

textcontent;
require_once('main.php');