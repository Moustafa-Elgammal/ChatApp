<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
</head>
<body>
<pre>
     <?php
     if (!auth()):
         ?>
 <a href="index.php">Home</a> <a href="signin.php">Sign In</a> <a href="signup.php">Sing Up</a>
     <?php
     else:
         ?><a href="index.php">Home </a> <a href="messages.php">Inbox </a> <a href="#" onclick="logout()">Log out</a><form action="logout.php" id="logout-form" method="post"><input name="_token" type="hidden" value="<?php echo get_csrf(); ?>"></form><script>function logout() { document.getElementById("logout-form").submit();}</script><?php endif;
    echo $content;
    ?>
</pre>


</body>
</html>