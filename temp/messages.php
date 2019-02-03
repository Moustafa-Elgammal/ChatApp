<?php
$title = 'Inbox';
$token = get_csrf();
$select = "";
if (isset($users) && count($users) > 0)
    foreach ($users as $user) {
        if ($_SESSION['user']['id'] == $user['id'])
            continue;
        $name = $user['name'];
        $id = $user['id'];
        $select .= "<option value='$id'>$name</option>";
    }
else
    $select .= "<option value=''>no users found</option>";

$content = "<br>     Messages Table: <a href='../dbdump/index.php'>_HERE_</a> ".<<<textcontent
    <br>
<form action="messages.php" method="post">
    send to : <select name="to" required>$select</select>
    Message : <textarea name="message" type="password"></textarea><br>
               <input name="submit" type="submit" value="send">
    <input type="hidden" name="_token" value="$token">
</form>
textcontent;

$content .="<br>";
$content .= viewMessages($messages);
require('main.php');