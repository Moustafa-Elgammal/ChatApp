<?php
$title = 'Home';
$token = get_csrf();
$content = <<<textcontent
    <br>
    Hello, chat..
    This project, just to test web security concepts and tips:
    01. SQL injection
    02. XSS attacks
    03. CSRF
    04. Check your passwords
    05. Avoid file uploads
    06. Beware of error messages
    
    

textcontent;
require_once('main.php');